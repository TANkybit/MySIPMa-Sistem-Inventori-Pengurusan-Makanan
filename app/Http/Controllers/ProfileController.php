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
        $user->load('institution.district', 'institution.state');

        $avatarUrl = $this->getAvatarUrl($user);

        $institution = $user->institution?->name;

        $positionName = $user->position?->name;

        $fullAddress = '';
        if ($user->institution) {
            $parts = [];
            if ($user->institution->address) $parts[] = $user->institution->address;
            if ($user->institution->district) $parts[] = $user->institution->district->name;
            if ($user->institution->state) $parts[] = $user->institution->state->name;
            if ($user->institution->postcode) $parts[] = $user->institution->postcode;
            $fullAddress = implode(', ', $parts);
        }

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->effectiveRoleName(),
            'position_name' => $positionName,
            'institution' => $institution,
            'institution_id' => $user->institution_id,
            'position_id' => $user->position_id,
            'role_id' => $user->role_id,
            'phone_number' => $user->phone_number,
            'avatar_url' => $avatarUrl,
            'full_address' => $fullAddress,
        ]);
    }

    public function showProfile()
    {
        $user = Auth::user();

        if ($user->landingRouteName() === 'pengarah.institusi.dashboard') {
            return redirect()->route('pengarah.institusi.profil');
        }

        $user->load('institution.district', 'institution.state');

        $institutionName = $user->institution?->name ?? '-';
        $positionName = $user->position?->name ?? '-';
        $roleName = $user->effectiveRoleName();

        $fullAddress = '';
        if ($user->institution) {
            $parts = [];
            if ($user->institution->address) $parts[] = $user->institution->address;
            if ($user->institution->district) $parts[] = $user->institution->district->name;
            if ($user->institution->state) $parts[] = $user->institution->state->name;
            if ($user->institution->postcode) $parts[] = $user->institution->postcode;
            $fullAddress = implode(', ', $parts);
        }

        $pendingApprovals = \App\Http\Controllers\DashboardController::pendingApprovalCount();
        $pendingPenerimaan = \App\Models\Order::where('status', 'In Progress')->count();

        return view('profile', [
            'user' => $user,
            'avatarUrl' => $this->getAvatarUrl($user),
            'pendingApprovals' => $pendingApprovals,
            'pendingPenerimaan' => $pendingPenerimaan,
            'institutionName' => $institutionName,
            'positionName' => $positionName,
            'roleName' => $roleName,
            'fullAddress' => $fullAddress,
        ]);
    }

    public function editProfile()
    {
        $user = Auth::user();

        $institutions = \App\Models\Institution::orderBy('name')->get();
        $positions = \App\Models\Position::orderBy('name')->get();
        $roles = \App\Models\Role::orderBy('role_name')->get();

        $pendingApprovals = \App\Http\Controllers\DashboardController::pendingApprovalCount();
        $pendingPenerimaan = \App\Models\Order::where('status', 'In Progress')->count();

        return view('update', [
            'user' => $user,
            'avatarUrl' => $this->getAvatarUrl($user),
            'pendingApprovals' => $pendingApprovals,
            'pendingPenerimaan' => $pendingPenerimaan,
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
