<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('order_sequences')) {
            Schema::create('order_sequences', function (Blueprint $table) {
                $table->id();
                $table->string('institution_code', 20);
                $table->string('category_code', 10);
                $table->integer('year');
                $table->integer('month');
                $table->integer('sequence_no')->default(0);
                $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->unique(['institution_code', 'category_code', 'year', 'month'], 'uq_order_seq');
            });
        }

        // Seed institution codes if empty
        DB::statement("UPDATE institutions SET code = 'KPM', location_code = 'KP' WHERE id = 1 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'SKPJ', location_code = 'PJ' WHERE id = 2 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'SMSJ', location_code = 'SJ' WHERE id = 3 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'SKJB', location_code = 'JB' WHERE id = 4 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'SMKK', location_code = 'KLU' WHERE id = 5 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PSP', location_code = 'SP' WHERE id = 9 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PKP', location_code = 'PLS' WHERE id = 10 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PPK', location_code = 'PK' WHERE id = 11 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PAS', location_code = 'AS' WHERE id = 12 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PSP', location_code = 'SP' WHERE id = 13 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PRP', location_code = 'PP' WHERE id = 14 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PKK', location_code = 'KAM' WHERE id = 15 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PTP', location_code = 'TP' WHERE id = 16 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PTA', location_code = 'TPH' WHERE id = 17 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PKBG', location_code = 'BG' WHERE id = 18 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PWK', location_code = 'KJG' WHERE id = 19 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PKJ', location_code = 'KJG' WHERE id = 20 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PKPA', location_code = 'PA' WHERE id = 21 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PSB', location_code = 'SB' WHERE id = 22 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'IPDJ', location_code = 'JLB' WHERE id = 23 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PSR', location_code = 'SR' WHERE id = 24 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PDDM', location_code = 'DM' WHERE id = 25 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'SHGTM', location_code = 'TM' WHERE id = 26 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PKJ', location_code = 'JSN' WHERE id = 27 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PSU', location_code = 'SU' WHERE id = 28 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PSRG', location_code = 'SRG' WHERE id = 29 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PKM', location_code = 'MUAR' WHERE id = 30 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PKJB', location_code = 'JB' WHERE id = 31 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PKLU', location_code = 'KLU' WHERE id = 32 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PBT', location_code = 'BTG' WHERE id = 33 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PPN', location_code = 'PNR' WHERE id = 34 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE institutions SET code = 'PPAM', location_code = 'MCH' WHERE id = 35 AND (code IS NULL OR code = '')");

        // Seed category codes
        DB::statement("UPDATE categories SET code = 'AT' WHERE id = 1 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE categories SET code = 'PS' WHERE id = 2 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE categories SET code = 'ICT' WHERE id = 3 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE categories SET code = 'BP' WHERE id = 4 AND (code IS NULL OR code = '')");
        DB::statement("UPDATE categories SET code = 'PD' WHERE id = 5 AND (code IS NULL OR code = '')");

        // Seed position grades
        DB::statement("UPDATE positions SET grade = 'KA19' WHERE id = 1 AND (grade IS NULL OR grade = '')");
        DB::statement("UPDATE positions SET grade = 'KA29' WHERE id = 2 AND (grade IS NULL OR grade = '')");
        DB::statement("UPDATE positions SET grade = 'KA41' WHERE id = 3 AND (grade IS NULL OR grade = '')");
        DB::statement("UPDATE positions SET grade = 'N19' WHERE id = 4 AND (grade IS NULL OR grade = '')");
        DB::statement("UPDATE positions SET grade = 'N29' WHERE id = 5 AND (grade IS NULL OR grade = '')");
        DB::statement("UPDATE positions SET grade = 'N19' WHERE id = 6 AND (grade IS NULL OR grade = '')");
    }

    public function down()
    {
        Schema::dropIfExists('order_sequences');
    }
};
