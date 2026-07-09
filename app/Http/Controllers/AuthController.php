<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use App\Models\User;
use App\Services\GmailService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP as PhpMailerSmtp;
use PHPMailer\PHPMailer\Exception as PhpMailerException;

require_once base_path('vendor/phpmailer/phpmailer/src/PHPMailer.php');
require_once base_path('vendor/phpmailer/phpmailer/src/SMTP.php');
require_once base_path('vendor/phpmailer/phpmailer/src/Exception.php');

class AuthController extends Controller
{
    const MAX_ATTEMPTS = 4;
    const BASE_COOLDOWN = 30;

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Sila masukkan emel anda.',
            'email.email' => 'Sila masukkan format emel yang sah.',
            'password.required' => 'Sila masukkan kata laluan anda.',
        ]);

        $email = $request->email;
        $cacheKey = 'login_attempts_' . md5($email);
        $levelKey = $cacheKey . '_level';

        $cooldownUntil = Cache::get($cacheKey . '_cooldown');
        if ($cooldownUntil) {
            $remaining = $cooldownUntil - now()->timestamp;
            if ($remaining > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terlalu banyak percubaan. Sila tunggu ' . $remaining . ' saat.',
                    'cooldown_remaining' => $remaining,
                    'attempts_remaining' => 0,
                ], 429);
            }
            Cache::forget($cacheKey . '_cooldown');
            Cache::forget($cacheKey);
        }

        if (Auth::attempt($credentials)) {
            Cache::forget($cacheKey);
            Cache::forget($cacheKey . '_cooldown');
            Cache::forget($levelKey);

            $request->session()->regenerate();

            $user = Auth::user();
            $redirectUrl = route($user->landingRouteName());

            return response()->json([
                'success' => true,
                'message' => 'Log masuk berjaya',
                'redirect' => $redirectUrl
            ]);
        }

        $attempts = (int) Cache::get($cacheKey, 0) + 1;
        Cache::put($cacheKey, $attempts, now()->addMinutes(5));

        $remaining = self::MAX_ATTEMPTS - $attempts;

        if ($remaining <= 0) {
            $level = (int) Cache::get($levelKey, 0);
            $cooldown = self::BASE_COOLDOWN * pow(2, $level);
            Cache::put($levelKey, $level + 1, now()->addHours(1));
            Cache::put($cacheKey . '_cooldown', now()->timestamp + $cooldown, now()->addMinutes(5));
            Cache::forget($cacheKey);

            $minutes = floor($cooldown / 60);
            $seconds = $cooldown % 60;
            if ($minutes > 0) {
                $msg = "Terlalu banyak percubaan. Sila tunggu {$minutes} minit {$seconds} saat.";
            } else {
                $msg = "Terlalu banyak percubaan. Sila tunggu {$cooldown} saat.";
            }

            return response()->json([
                'success' => false,
                'message' => $msg,
                'cooldown_remaining' => $cooldown,
                'attempts_remaining' => 0,
            ], 429);
        }

        return response()->json([
            'success' => false,
            'message' => 'Emel atau kata laluan tidak sah. Baki percubaan: ' . $remaining,
            'attempts_remaining' => $remaining,
            'cooldown_remaining' => 0,
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Sila masukkan emel anda.',
            'email.email' => 'Sila masukkan format emel yang sah.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $newPassword = Str::random(10);

            $user->password = Hash::make($newPassword);
            $user->updated_at = now();
            $user->save();

            $mailSent = false;

            try {
                $htmlBody = view('emails.reset_password', ['email' => $user->email, 'password' => $newPassword])->render();

                $gmailApi = new GmailService();

                if ($gmailApi->isConfigured()) {
                    $gmailApi->sendEmail($user->email, 'Maklumat Akaun Pengguna - Sistem MySIPMa', $htmlBody);
                    $mailSent = true;
                } else {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
                    $mail->SMTPAuth   = true;
                    $mail->Username   = env('MAIL_USERNAME', 'mysipma@gmail.com');
                    $mail->Password   = env('MAIL_PASSWORD');
                    $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
                    $mail->Port       = env('MAIL_PORT', 587);
                    $mail->CharSet    = 'UTF-8';

                    $mail->setFrom(env('MAIL_FROM_ADDRESS', 'mysipma@gmail.com'), env('MAIL_FROM_NAME', 'Sistem MySIPMa'));
                    $mail->addAddress($user->email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Maklumat Akaun Pengguna - Sistem MySIPMa';
                    $mail->Body    = $htmlBody;

                    $mail->send();
                    $mailSent = true;
                }
            } catch (\Exception $e) {
                \Log::error('Email failed: ' . $e->getMessage());

                try {
                    $mail = new PHPMailer(true);
                    $mail->isMail();
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('noreply@mysipma.com', 'Sistem MySIPMa');
                    $mail->addAddress($user->email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Maklumat Akaun Pengguna - Sistem MySIPMa';
                    $mail->Body    = $htmlBody;
                    $mail->send();
                    $mailSent = true;
                } catch (\Exception $e2) {
                    \Log::error('Fallback mail() also failed: ' . $e2->getMessage());
                }
            }

            return response()->json([
                'success' => $mailSent,
                'message' => $mailSent
                    ? 'Kata laluan baharu telah berjaya dihantar ke ' . $request->email
                    : 'Gagal menghantar emel. Sila cuba sebentar lagi.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Emel belum didaftarkan.',
        ], 404);
    }
}
