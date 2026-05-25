<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Approval;

class ProfileController extends Controller
{
    /**
     * Return the authenticated user's profile data as JSON.
     */
    public function getProfile()
    {
        $user = Auth::user();

        $avatarUrl = $this->getAvatarUrl($user);

        $institution = $user->institution_id
            ? \Illuminate\Support\Facades\DB::table('institutions')->where('id', $user->institution_id)->value('name')
            : null;

        $position = $user->position_id
            ? \Illuminate\Support\Facades\DB::table('positions')->where('id', $user->position_id)->value('name')
            : null;

        $role = $user->role_id
            ? \Illuminate\Support\Facades\DB::table('roles')->where('id', $user->role_id)->value('role_name')
            : null;

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'username' => $role,
            'grade' => $position,
            'institution' => $institution,
            'institution_id' => $user->institution_id,
            'position_id' => $user->position_id,
            'role_id' => $user->role_id,
            'phone_number' => $user->phone_number,
            'avatar_url' => $avatarUrl,
        ]);
    }

    public function showProfile()
    {
        $user = Auth::user();

        $institutionName = $user->institution_id
            ? \Illuminate\Support\Facades\DB::table('institutions')->where('id', $user->institution_id)->value('name')
            : '-';

        $positionName = $user->position_id
            ? \Illuminate\Support\Facades\DB::table('positions')->where('id', $user->position_id)->value('name')
            : '-';

        $roleName = $user->role_id
            ? \Illuminate\Support\Facades\DB::table('roles')->where('id', $user->role_id)->value('role_name')
            : '-';

        return view('profile', [
            'user' => $user,
            'avatarUrl' => $this->getAvatarUrl($user),
            'pendingApprovals' => \App\Http\Controllers\DashboardController::pendingApprovalCount(),
            'institutionName' => $institutionName,
            'positionName' => $positionName,
            'roleName' => $roleName,
        ]);
    }

    public function editProfile()
    {
        $user = Auth::user();

        $institutions = \App\Models\Institution::orderBy('name')->get();
        $positions = \App\Models\Position::orderBy('name')->get();
        $roles = \App\Models\Role::orderBy('role_name')->get();

        return view('update', [
            'user' => $user,
            'avatarUrl' => $this->getAvatarUrl($user),
            'pendingApprovals' => \App\Http\Controllers\DashboardController::pendingApprovalCount(),
            'institutions' => $institutions,
            'positions' => $positions,
            'roles' => $roles,
        ]);
    }

    private function getAvatarUrl($user)
    {
        return $user->image
            ? asset('storage/' . $user->image)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=1a5632&color=fff&size=150';
    }

    /**
     * Update profile information (name, email, phone_number).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'institution_id' => 'nullable|integer',
            'position_id' => 'nullable|integer',
        ]);

        $data = [
            'name' => $request->name,
            'updated_at' => now(),
        ];

        if ($request->filled('email')) {
            $data['email'] = $request->email;
        }
        if ($request->filled('phone_number')) {
            $data['phone_number'] = $request->phone_number;
        }
        if ($request->filled('institution_id')) {
            $data['institution_id'] = $request->institution_id;
        }
        if ($request->filled('position_id')) {
            $data['position_id'] = $request->position_id;
        }

        $user->update($data);

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
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update(['image' => $path, 'updated_at' => now()]);

        $avatarUrl = asset('storage/' . $path);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Gambar profil berjaya dikemaskini',
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
            'updated_at' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Kata laluan berjaya ditukar']);
        }

        return back()->with('success', 'Kata laluan berjaya ditukar');
    }
}
