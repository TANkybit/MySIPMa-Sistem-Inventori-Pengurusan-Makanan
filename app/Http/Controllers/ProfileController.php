<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Return the authenticated user's profile data as JSON.
     */
    public function getProfile()
    {
        $user = Auth::user();

        $avatarUrl = $this->getAvatarUrl($user);

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'grade' => $user->grade,
            'institution' => $user->institution,
            'institution_id' => $user->institution_id,
            'phone_number' => $user->phone_number,
            'avatar_url' => $avatarUrl,
        ]);
    }

    public function showProfile()
    {
        $user = Auth::user();

        return view('profile', [
            'user' => $user,
            'avatarUrl' => $this->getAvatarUrl($user),
        ]);
    }

    public function editProfile()
    {
        $user = Auth::user();

        return view('update', [
            'user' => $user,
            'avatarUrl' => $this->getAvatarUrl($user),
        ]);
    }

    private function getAvatarUrl($user)
    {
        $avatar = $user->avatar ?: $user->image;

        return $avatar
            ? asset('storage/' . $avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=1a5632&color=fff&size=150';
    }

    /**
     * Update profile information (name, email, username, grade, institution).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'grade' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'institution_id' => 'nullable|integer',
        ]);

        $user->update($request->only(['name', 'email', 'username', 'grade', 'institution', 'phone_number', 'institution_id']));

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Profil berjaya dikemaskini']);
        }

        return back()->with('success', 'Profil berjaya dikemaskini');
    }

    /**
     * Upload and update the user's avatar.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar file if it exists
        $oldAvatar = $user->avatar ?: $user->image;
        if ($oldAvatar && Storage::disk('public')->exists($oldAvatar)) {
            Storage::disk('public')->delete($oldAvatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update(['avatar' => $path, 'image' => $path]);

        $avatarUrl = asset('storage/' . $path);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => 'Gambar profil berjaya dikemaskini',
                'avatar_url' => $avatarUrl,
            ]);
        }

        return back()->with('success', 'Gambar profil berjaya dikemaskini');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['current_password' => ['Kata laluan semasa tidak sah']]], 422);
            }
            return back()->withErrors(['current_password' => 'Kata laluan semasa tidak sah']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Kata laluan berjaya ditukar']);
        }

        return back()->with('success', 'Kata laluan berjaya ditukar');
    }
}
