<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('users')->where('id', 1)->update(['role_id' => 1, 'position_id' => 3]);
        DB::table('users')->where('id', '!=', 1)->update(['role_id' => 2, 'position_id' => 6]);

        DB::table('roles')->truncate();
        DB::table('roles')->insert([
            ['id' => 1, 'role_name' => 'Admin'],
            ['id' => 2, 'role_name' => 'User'],
        ]);

        DB::table('positions')->truncate();
        DB::table('positions')->insert([
            ['id' => 1, 'code' => 'ADN', 'name' => 'Admin Negeri', 'grade' => null],
            ['id' => 2, 'code' => 'ADI', 'name' => 'Admin Institusi', 'grade' => null],
            ['id' => 3, 'code' => 'ADHQ', 'name' => 'Admin HQ', 'grade' => null],
            ['id' => 4, 'code' => 'PP', 'name' => 'Pegawai Pengesah', 'grade' => null],
            ['id' => 5, 'code' => 'PR', 'name' => 'Pegawai Penerima', 'grade' => null],
            ['id' => 6, 'code' => 'PS', 'name' => 'Pegawai Stor', 'grade' => null],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('roles')->truncate();
        DB::table('roles')->insert([
            ['id' => 1, 'role_name' => 'Admin'],
            ['id' => 2, 'role_name' => 'User'],
            ['id' => 3, 'role_name' => 'Approver'],
            ['id' => 4, 'role_name' => 'Supplier'],
            ['id' => 5, 'role_name' => 'Finance Officer'],
        ]);

        DB::table('positions')->truncate();
        DB::table('positions')->insert([
            ['id' => 1, 'code' => 'P001', 'name' => 'Pengarah', 'grade' => 'DG54'],
            ['id' => 2, 'code' => 'P002', 'name' => 'Pegawai Kewangan', 'grade' => 'W41'],
            ['id' => 3, 'code' => 'P003', 'name' => 'Kerani', 'grade' => 'N19'],
            ['id' => 4, 'code' => 'P004', 'name' => 'Guru Besar', 'grade' => 'DG48'],
            ['id' => 5, 'code' => 'P005', 'name' => 'Pengetua', 'grade' => 'DG52'],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
