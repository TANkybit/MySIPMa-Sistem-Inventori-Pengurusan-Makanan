<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
    const MAX_ATTEMPTS = 4;
    const BASE_COOLDOWN = 30;

    /**
     * Handle an authentication attempt.
     */
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

        // Check cooldown
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

        // Failed login
        $attempts = (int) Cache::get($cacheKey, 0) + 1;
        Cache::put($cacheKey, $attempts, now()->addMinutes(5));

        $remaining = self::MAX_ATTEMPTS - $attempts;

        if ($remaining <= 0) {
            // Escalating cooldown: each round doubles
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

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }

    /**
     * Check if email exists for forgot password.
     */
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
            // Generate a random 10-character password
            $newPassword = Str::random(10);
            
            // Update the user's password in the database
            $user->password = Hash::make($newPassword);
            $user->updated_at = now();
            $user->save();

            // Send the email with the new password
            try {
                Mail::to($user->email)->send(new ResetPasswordMail($user->email, $newPassword));
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ralat menghantar emel: ' . $e->getMessage()
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Kata laluan baharu telah berjaya dihantar ke: ' . $request->email
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Emel tidak dijumpai dalam pangkalan data kami.'
        ], 404);
    }
}
