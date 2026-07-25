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
        Schema::create('performance_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('institution_id')->nullable();
            $table->integer('generated_by')->nullable();
            
            $table->string('report_title');
            $table->string('report_code')->unique()->nullable();
            $table->integer('month');
            $table->integer('year');
            
            // Aggregated Summary Statistics
            $table->integer('total_evaluations')->default(0);
            $table->decimal('average_percentage', 5, 2)->default(0.00);
            $table->integer('count_cemerlang')->default(0);
            $table->integer('count_sederhana')->default(0);
            $table->integer('count_lemah')->default(0);
            
            // Workflow Status & Remarks
            $table->string('status')->default('Draft'); // Draft, Generated, Verified, Approved
            $table->text('remarks')->nullable();
            
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');
            $table->foreign('generated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_reports');
    }
};
