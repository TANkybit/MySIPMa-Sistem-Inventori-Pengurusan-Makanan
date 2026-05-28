<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $adminRoleId = DB::table('roles')->where('role_name', 'Admin')->value('id');

        if (!$adminRoleId) {
            $adminRoleId = DB::table('roles')->insertGetId([
                'role_name' => 'Admin',
            ]);
        }

        $directorPositionIds = DB::table('positions')
            ->whereIn('code', ['ADI', 'ADN', 'ADHQ', 'P006', 'P007'])
            ->orWhere('name', 'like', '%Pengarah Institusi%')
            ->orWhere('name', 'like', '%Pengarah Negeri%')
            ->orWhere('name', 'like', '%Admin Institusi%')
            ->orWhere('name', 'like', '%Admin Negeri%')
            ->pluck('id');

        if ($directorPositionIds->isEmpty()) {
            return;
        }

        DB::table('users')
            ->whereIn('position_id', $directorPositionIds)
            ->update(['role_id' => $adminRoleId]);
    }

    public function down(): void
    {
        // Intentionally left blank; previous role assignments cannot be inferred safely.
    }
};
