<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('category_id')->nullable()->default(null)->change();
            $table->integer('subcategories_id')->nullable()->default(null)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('contract_item_id')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('category_id')->nullable(false)->change();
            $table->integer('subcategories_id')->nullable(false)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('contract_item_id')->nullable(false)->change();
        });
    }
};
