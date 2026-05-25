<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE deliveries MODIFY muster_khas_daging INT DEFAULT 0');
        DB::statement('ALTER TABLE deliveries MODIFY muster_ditolak_parol INT DEFAULT 0');
        DB::statement('ALTER TABLE deliveries MODIFY parol INT DEFAULT 0');
        DB::statement('ALTER TABLE deliveries MODIFY muster_penuh INT DEFAULT 0');

        Schema::table('deliveries', function (Blueprint $table) {
            $table->integer('special_exclusion')->default(0)->after('muster_penuh');
        });
    }

    public function down()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn('special_exclusion');
        });

        DB::statement('ALTER TABLE deliveries MODIFY muster_penuh TINYINT(1) DEFAULT 0');
        DB::statement('ALTER TABLE deliveries MODIFY parol TINYINT(1) DEFAULT 0');
        DB::statement('ALTER TABLE deliveries MODIFY muster_ditolak_parol TINYINT(1) DEFAULT 0');
        DB::statement('ALTER TABLE deliveries MODIFY muster_khas_daging TINYINT(1) DEFAULT 0');
    }
};
