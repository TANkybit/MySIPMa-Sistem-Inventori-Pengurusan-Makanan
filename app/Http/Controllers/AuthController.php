<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
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

        // Ubah: Keluarkan ['status' => 1] supaya pengguna dengan status == 0 boleh log masuk
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $redirectUrl = route('admin.dashboard');

            // "if status is == 0 its user"
            if ($user->status == 0 || $user->status === false) {
                $redirectUrl = route('user.dashboard');
                // Di sini kita juga boleh memuatkan role_id jika perlu pada masa hadapan
                // contoh: Session::put('user_role', $user->role_id);
            }

            return response()->json([
                'success' => true,
                'message' => 'Log masuk berjaya',
                'redirect' => $redirectUrl
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Emel atau kata laluan tidak sah.'
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
