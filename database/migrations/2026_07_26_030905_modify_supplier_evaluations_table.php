<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier_evaluations', function (Blueprint $table) {
            if (Schema::hasColumn('supplier_evaluations', 'order_id')) {
                $table->dropColumn('order_id');
            }

            if (!Schema::hasColumn('supplier_evaluations', 'order_date_from')) {
                $table->date('order_date_from')->nullable();
            }
            if (!Schema::hasColumn('supplier_evaluations', 'order_date_to')) {
                $table->date('order_date_to')->nullable();
            }
            if (!Schema::hasColumn('supplier_evaluations', 'order_count')) {
                $table->integer('order_count')->nullable();
            }
            if (!Schema::hasColumn('supplier_evaluations', 'supply_date_from')) {
                $table->date('supply_date_from')->nullable();
            }
            if (!Schema::hasColumn('supplier_evaluations', 'supply_date_to')) {
                $table->date('supply_date_to')->nullable();
            }
            if (!Schema::hasColumn('supplier_evaluations', 'supply_type')) {
                $table->string('supply_type')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('supplier_evaluations', function (Blueprint $table) {
            $table->dropColumn(['order_date_from', 'order_date_to', 'order_count', 'supply_date_from', 'supply_date_to', 'supply_type']);

            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }
};
