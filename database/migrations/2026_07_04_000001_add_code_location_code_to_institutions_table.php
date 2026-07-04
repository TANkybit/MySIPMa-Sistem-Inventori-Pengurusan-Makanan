<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            if (!Schema::hasColumn('institutions', 'code')) {
                $table->string('code', 20)->nullable()->after('name');
            }
            if (!Schema::hasColumn('institutions', 'location_code')) {
                $table->string('location_code', 20)->nullable()->after('code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->dropColumn(['code', 'location_code']);
        });
    }
};
