<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prism_diet_rules', function (Blueprint $table) {
            $table->id();
            $table->string('week_cycle', 10);
            $table->unsignedTinyInteger('day_of_week'); // 0 Ahad through 6 Sabtu
            $table->string('item_name');
            $table->decimal('rate_per_person', 10, 3);
            $table->string('unit', 10)->default('g');
            $table->string('muster_basis', 30)->default('ditolak_parol');
            $table->timestamps();
            $table->unique(['week_cycle', 'day_of_week', 'item_name'], 'prism_rule_unique');
        });

        $m13 = [
            0 => [['Selar',100],['Sawi Putih',160],['Kacang Buncis',200],['Tembikai Susu',150]],
            1 => [['Sardin',100],['Kacang Buncis',200],['Kobis Cina (Panjang)',160],['Betik',150]],
            2 => [['Cencaru',100],['Bayam (Hijau)',160],['Terong',200],['Nenas Mauritius',150],['Ikan Bilis (Perlengkapan)',10]],
            3 => [['Pelata',100],['Kacang Bendi',200],['Tembikai Susu',150]],
            4 => [['Kembong',100],['Sawi Hijau',160],['Terong',100],['Tembikai',150],['Ikan Bilis (Perlengkapan)',10],['Lobak Merah',100]],
            5 => [['Bayam (Hijau)',160],['Kacang Panjang',200],['Betik',150],['Keli',100]],
            6 => [['Kobis Bulat',160],['Nenas Mauritius',150],['Taugeh',200]],
        ];
        $m24 = [
            0 => [['Pelata',100],['Bayam (Hijau)',160],['Nenas Mauritius',150]],
            1 => [['Kembong',100],['Kobis Cina (Panjang)',160],['Kacang Bendi',200],['Tembikai',150]],
            2 => [['Cencaru',100],['Sawi Hijau',160],['Kacang Panjang',100],['Terong',100],['Betik',150]],
            3 => [['Selar',100],['Bayam (Hijau)',160],['Labu Kuning',200],['Nenas Mauritius',150],['Keli',100]],
            4 => [['Kobis Cina (Panjang)',80],['Kobis Bulat',80],['Tembikai Susu',150]],
            5 => [['Cencaru',100],['Petola',100],['Timun',50],['Tembikai',150],['Ikan Bilis (Rencah)',16],['Tomato',50]],
            6 => [['Sardin',100],['Sawi Putih',160],['Betik',150],['Ikan Bilis (Perlengkapan)',10],['Taugeh',200]],
        ];

        $rows = [];
        foreach (['M1-3' => $m13, 'M2-4' => $m24] as $cycle => $days) {
            foreach ($days as $day => $rules) {
                foreach ($rules as [$item, $rate]) {
                    $rows[] = ['week_cycle' => $cycle, 'day_of_week' => $day, 'item_name' => $item, 'rate_per_person' => $rate, 'unit' => 'g', 'muster_basis' => 'ditolak_parol', 'created_at' => now(), 'updated_at' => now()];
                }
            }
        }
        // PRISM treats Grade C eggs as a whole-unit ration rather than grams.
        foreach (['M1-3', 'M2-4'] as $cycle) {
            foreach (range(0, 6) as $day) {
                $rows[] = ['week_cycle' => $cycle, 'day_of_week' => $day, 'item_name' => 'Telur Ayam Gred C', 'rate_per_person' => 1, 'unit' => 'biji', 'muster_basis' => 'ditolak_parol', 'created_at' => now(), 'updated_at' => now()];
            }
        }
        DB::table('prism_diet_rules')->insert($rows);
    }

    public function down(): void
    {
        Schema::dropIfExists('prism_diet_rules');
    }
};
