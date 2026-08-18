<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diet_guideline_versions', function (Blueprint $table) {
            $table->string('week_number_method', 30)->default('excel_weeknum')->after('cycle_anchor_week');
            $table->unsignedTinyInteger('week_starts_on')->default(1)->after('week_number_method');
            $table->string('odd_week_cycle', 10)->default('M1-3')->after('week_starts_on');
        });

        DB::table('diet_guideline_versions')->where('code', 'SKALA-DIET-2025')->update([
            'week_number_method' => 'excel_weeknum',
            'week_starts_on' => 1,
            'odd_week_cycle' => 'M1-3',
            'updated_at' => now(),
        ]);

        $guidelineId = DB::table('diet_guideline_versions')->where('code', 'SKALA-DIET-2025')->value('id');
        $notes = [
            ['infant_5_6', 'Susu kekal penting; makanan pepejal diberi dua kali sehari pada minum pagi dan makan tengah hari. Susu ibu diutamakan dan susu tepung penuh krim tidak digalakkan bawah satu tahun.'],
            ['infant_7_9', 'Susu kekal penting; makanan pepejal diberi dua kali sehari pada makan tengah hari dan makan malam. Susu ibu diutamakan.'],
            ['infant_10_12', 'Makanan pepejal diberi tiga kali sehari pada sarapan, makan tengah hari dan makan malam; susu boleh diberi pada minum pagi, petang dan malam. Susu ibu diutamakan.'],
            ['rotation', 'PRISM 4.93 menentukan M1-3 bagi WEEKNUM bertarikh mula Isnin yang ganjil dan M2-4 bagi minggu genap; tetapan offset boleh diterbalikkan jika diarahkan.'],
        ];
        foreach ($notes as [$section, $text]) {
            DB::table('diet_policy_notes')->insert([
                'guideline_version_id' => $guidelineId, 'section_code' => $section,
                'category_code' => null, 'rule_text' => $text,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('diet_policy_notes')->whereIn('section_code', ['infant_5_6','infant_7_9','infant_10_12','rotation'])->delete();
        Schema::table('diet_guideline_versions', function (Blueprint $table) {
            $table->dropColumn(['week_number_method', 'week_starts_on', 'odd_week_cycle']);
        });
    }
};
