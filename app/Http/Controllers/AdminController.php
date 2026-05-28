<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Return users/admins from the database for the admin list.
     */
    public function listAdmins()
    {
        $users = User::orderBy('name')
            ->get()
            ->map(fn (User $user) => $this->formatUserForFrontend($user));

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Register a new admin/user.
     */
    public function registerAdmin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => 'required|string|max:20',
                'password' => 'nullable|string|min:8',
                'status' => 'required|string',
                'institution_id' => 'required|integer',
                'role_id' => 'required|integer',
                'position_id' => 'nullable|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ralat pengesahan data.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Handle optional image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('avatars', 'public');
            }

            $institutionId = $this->resolveReferenceId(
                'institutions',
                'name',
                $request->input('institution_id'),
                $request->input('institution_name') ?: $request->input('institution')
            );
            $roleId = $this->resolveReferenceId(
                'roles',
                'role_name',
                $request->input('role_id'),
                $request->input('role_name') ?: $request->input('role') ?: $this->defaultRoleName($request->input('role_id'))
            );
            $positionId = null;
            if ($request->filled('position_id') || $request->filled('position_name') || $request->filled('position')) {
                $positionId = $this->resolveReferenceId(
                    'positions',
                    'name',
                    $request->input('position_id'),
                    $request->input('position_name') ?: $request->input('position')
                );
            }

            // Generate a random password if not provided
            $plainPassword = $request->filled('password') ? $request->password : \Illuminate\Support\Str::random(10);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($plainPassword),
                'status' => $this->statusToDatabaseValue($request->status),
                'institution_id' => $institutionId,
                'role_id' => $roleId,
                'position_id' => $positionId,
                'image' => $imagePath,
                'created_at' => now(),
                'created_by' => auth()->id() ?? 1,
                'updated_at' => now(),
            ]);

            Log::info("New user registered successfully: {$user->email}. Password generated: {$plainPassword}");
            // In a real application, you would dispatch an email job here:
            // Mail::to($user->email)->send(new NewAdminPasswordMail($plainPassword));

            Log::info("New user registered successfully: {$user->email}");

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran pengguna baru berjaya disimpan.',
                'data' => $this->formatUserForFrontend($user->fresh())
            ]);
        } catch (\Exception $e) {
            Log::error('Error registering admin: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi ralat semasa menyimpan rekod.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update admin/user details from the edit modal.
     */
    public function updateAdmin(Request $request, $admin)
    {
        try {
            $admin = User::find($admin);
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin ini belum wujud dalam database. Sila daftar atau import rekod admin ini dahulu.',
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($admin->id),
                ],
                'phone_number' => 'nullable|string|max:50',
                'status' => 'nullable|string|max:50',
                'institution_id' => 'nullable|integer',
                'role_id' => 'nullable|integer',
                'position_id' => 'nullable|integer',
                'institution' => 'nullable|string|max:255',
                'role' => 'nullable|string|max:100',
                'position' => 'nullable|string|max:255',
                'password' => 'nullable|string|min:8',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ralat pengesahan data.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'updated_at' => now(),
                'updated_by' => auth()->id() ?? 1,
            ];

            if ($request->has('status')) {
                $data['status'] = $this->statusToDatabaseValue($request->status);
            }

            $institutionId = $this->resolveReferenceId(
                'institutions',
                'name',
                $request->input('institution_id'),
                $request->input('institution_name') ?: $request->input('institution')
            );
            if ($request->has('institution_id') || $request->filled('institution_name') || $request->filled('institution')) {
                $data['institution_id'] = $institutionId;
            }

            $roleId = $this->resolveReferenceId(
                'roles',
                'role_name',
                $request->input('role_id'),
                $request->input('role_name') ?: $request->input('role') ?: $this->defaultRoleName($request->input('role_id'))
            );
            if ($request->has('role_id') || $request->filled('role_name') || $request->filled('role')) {
                $data['role_id'] = $roleId;
            }

            $positionId = $this->resolveReferenceId(
                'positions',
                'name',
                $request->input('position_id'),
                $request->input('position_name') ?: $request->input('position')
            );
            if ($request->has('position_id') || $request->filled('position_name') || $request->filled('position')) {
                $data['position_id'] = $positionId;
            }

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('avatars', 'public');
            }

            $admin->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Maklumat admin berjaya dikemaskini.',
                'data' => $this->formatUserForFrontend($admin->fresh()),
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating admin: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi ralat semasa mengemaskini rekod.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function resolveReferenceId(string $table, string $nameColumn, mixed $id, ?string $name): ?int
    {
        if ($id !== null && $id !== '') {
            $existing = DB::table($table)->where('id', (int) $id)->first();
            if ($existing) {
                return (int) $existing->id;
            }
        }

        $name = trim((string) $name);
        if ($name === '' || strtoupper($name) === 'N/A') {
            return null;
        }

        $existing = DB::table($table)->where($nameColumn, $name)->first();
        if ($existing) {
            return (int) $existing->id;
        }

        return (int) DB::table($table)->insertGetId([
            $nameColumn => $name,
        ]);
    }

    private function defaultRoleName(mixed $roleId): ?string
    {
        return match ((int) $roleId) {
            1 => 'Admin',
            2 => 'User',
            default => null,
        };
    }

    private function statusToDatabaseValue(mixed $status): int
    {
        $normalized = strtolower(trim((string) $status));

        return in_array($normalized, ['active', 'aktif', '1', 'true', 'yes'], true) ? 1 : 0;
    }

    private function statusToFrontendValue(mixed $status): string
    {
        if ($status === null || $status === '' || $status === false) {
            return 'active';
        }

        $normalized = strtolower(trim((string) $status));

        return in_array($normalized, ['inactive', 'tidak aktif', '0', 'false', 'no'], true) ? 'inactive' : 'active';
    }

    private function formatUserForFrontend(User $user): array
    {
        $institution = $user->institution_id
            ? DB::table('institutions')->where('id', $user->institution_id)->value('name')
            : null;
        $position = $user->position_id
            ? DB::table('positions')->where('id', $user->position_id)->value('name')
            : null;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'status' => $this->statusToFrontendValue($user->status),
            'institution_id' => $user->institution_id,
            'role_id' => $user->role_id,
            'position_id' => $user->position_id,
            'institution' => $institution ?: 'N/A',
            'role' => $user->effectiveRoleName(),
            'position' => $position ?: 'N/A',
            'joinDate' => $user->created_at
                ? \Illuminate\Support\Carbon::parse($user->created_at)->format('Y-m-d')
                : null,
            'avatar' => $user->image,
            'image' => $user->image ? asset('storage/' . $user->image) : null,
        ];
    }
}
