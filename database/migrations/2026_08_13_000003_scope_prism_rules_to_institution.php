<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prism_diet_rules', function (Blueprint $table) {
            $table->unsignedInteger('institution_id')->nullable()->after('id');
        });

        // The supplied price schedule is for Kajang, so the imported PRISM
        // scale must not be used for any other institution.
        DB::table('prism_diet_rules')->update(['institution_id' => 11]);
        DB::statement('ALTER TABLE prism_diet_rules MODIFY institution_id INT NOT NULL');
    }

    public function down(): void
    {
        Schema::table('prism_diet_rules', function (Blueprint $table) {
            $table->dropColumn('institution_id');
        });
    }
};
