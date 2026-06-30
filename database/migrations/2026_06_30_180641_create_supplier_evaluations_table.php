<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplier_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('supplier_id');
            $table->unsignedInteger('institution_id');
            
            // Evaluator info
            $table->string('evaluator_name');
            $table->date('evaluation_date');
            
            // Criteria (1-7 scale)
            $table->integer('criteria_quantity')->default(0);
            $table->integer('criteria_delivery')->default(0);
            $table->integer('criteria_price')->default(0);
            $table->integer('criteria_quality')->default(0);
            $table->integer('criteria_cooperation')->default(0);
            
            // Totals
            $table->integer('total_score')->default(0); // Sum of 5 criteria (max 35)
            $table->decimal('percentage', 5, 2)->default(0.00); // (Total / 35) * 100
            $table->string('performance_rating')->nullable(); // Cemerlang, Sederhana, Lemah
            
            $table->text('remarks')->nullable();
            
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Foreign keys
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_evaluations');
    }
};
