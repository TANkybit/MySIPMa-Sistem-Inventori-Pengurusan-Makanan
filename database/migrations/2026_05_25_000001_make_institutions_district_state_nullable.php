<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->integer('district_id')->nullable()->default(null)->change();
            $table->integer('state_id')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->integer('district_id')->nullable(false)->change();
            $table->integer('state_id')->nullable(false)->change();
        });
    }
};
