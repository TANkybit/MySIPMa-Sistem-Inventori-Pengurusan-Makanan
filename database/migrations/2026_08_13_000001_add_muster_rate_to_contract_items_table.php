<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contract_items', function (Blueprint $table) {
            $table->decimal('muster_rate', 12, 6)->nullable()->after('estimated_quantity');
            $table->string('muster_basis', 30)->nullable()->after('muster_rate');
        });
    }

    public function down(): void
    {
        Schema::table('contract_items', function (Blueprint $table) {
            $table->dropColumn(['muster_rate', 'muster_basis']);
        });
    }
};
