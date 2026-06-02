<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Update positions names
        DB::table('positions')->where('code', 'ADN')->update(['name' => 'Pegawai Penjara Negeri KA19']);
        DB::table('positions')->where('code', 'ADI')->update(['name' => 'Pegawai Penjara Institusi KA29']);
        DB::table('positions')->where('code', 'ADHQ')->update(['name' => 'Pegawai Penjara Pentadbiran KA41']);
        DB::table('positions')->where('code', 'PP')->update(['name' => 'Pegawai Pengesah N19']);
        DB::table('positions')->where('code', 'PR')->update(['name' => 'Pegawai Penerima N29']);
        DB::table('positions')->where('code', 'PS')->update(['name' => 'Pegawai Stor N19']);

        // 2. Update existing roles in-place, then insert new ones
        DB::table('roles')->where('id', 1)->update(['role_name' => 'admin hq']);
        DB::table('roles')->where('id', 2)->update(['role_name' => 'admin negeri']);
        DB::table('roles')->insert([
            ['id' => 3, 'role_name' => 'admin institusi'],
            ['id' => 4, 'role_name' => 'pegawai pengesah'],
            ['id' => 5, 'role_name' => 'pegawai penerima'],
            ['id' => 6, 'role_name' => 'pegawai stor'],
        ]);

        // 3. Update users role_id based on their position (no null needed, valid FK throughout)
        DB::table('users')->where('id', 1)->update(['role_id' => 1]); // ADHQ → admin hq
        DB::table('users')->where('id', 3)->update(['role_id' => 3]); // ADI → admin institusi
        DB::table('users')->where('id', 4)->update(['role_id' => 6]); // PS  → pegawai stor
        DB::table('users')->where('id', 5)->update(['role_id' => 4]); // PP  → pegawai pengesah
        DB::table('users')->where('id', 6)->update(['role_id' => 5]); // PR  → pegawai penerima
        DB::table('users')->where('id', 7)->update(['role_id' => 6]); // PS  → pegawai stor
    }

    public function down()
    {
        // Restore original positions names
        DB::table('positions')->where('code', 'ADN')->update(['name' => 'Admin Negeri']);
        DB::table('positions')->where('code', 'ADI')->update(['name' => 'Admin Institusi']);
        DB::table('positions')->where('code', 'ADHQ')->update(['name' => 'Admin HQ']);
        DB::table('positions')->where('code', 'PP')->update(['name' => 'Pegawai Pengesah']);
        DB::table('positions')->where('code', 'PR')->update(['name' => 'Pegawai Penerima']);
        DB::table('positions')->where('code', 'PS')->update(['name' => 'Pegawai Stor']);

        // Restore roles
        DB::table('users')->where('id', 3)->update(['role_id' => 1]); // ADI → Admin
        DB::table('users')->where('id', 4)->update(['role_id' => 2]); // PS  → User
        DB::table('users')->where('id', 5)->update(['role_id' => 2]); // PP  → User
        DB::table('users')->where('id', 6)->update(['role_id' => 2]); // PR  → User
        DB::table('users')->where('id', 7)->update(['role_id' => 2]); // PS  → User

        DB::table('roles')->whereIn('id', [3, 4, 5, 6])->delete();
        DB::table('roles')->where('id', 1)->update(['role_name' => 'Admin']);
        DB::table('roles')->where('id', 2)->update(['role_name' => 'User']);
    }
};
