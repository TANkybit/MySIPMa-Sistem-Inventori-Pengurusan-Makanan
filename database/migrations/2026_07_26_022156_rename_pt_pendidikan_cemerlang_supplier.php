<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('suppliers')
            ->where('company_name', 'PT Pendidikan Cemerlang Sdn Bhd')
            ->update(['company_name' => 'Pembekal Makanan Cemerlang Sdn Bhd']);
    }

    public function down(): void
    {
        DB::table('suppliers')
            ->where('company_name', 'Pembekal Makanan Cemerlang Sdn Bhd')
            ->update(['company_name' => 'PT Pendidikan Cemerlang Sdn Bhd']);
    }
};
