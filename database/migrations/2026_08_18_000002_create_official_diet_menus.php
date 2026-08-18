<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_menu_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guideline_version_id')->constrained('diet_guideline_versions')->cascadeOnDelete();
            $table->string('menu_group', 30);
            $table->string('week_cycle', 10);
            $table->unsignedTinyInteger('day_of_week');
            $table->string('meal_session', 10);
            $table->unsignedTinyInteger('display_order');
            $table->string('dish_name');
            $table->timestamps();
            $table->unique(['guideline_version_id', 'menu_group', 'week_cycle', 'day_of_week', 'meal_session', 'display_order'], 'diet_menu_entry_unique');
        });

        Schema::create('diet_recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guideline_version_id')->constrained('diet_guideline_versions')->cascadeOnDelete();
            $table->string('menu_group', 30)->default('standard');
            $table->unsignedSmallInteger('source_number')->nullable();
            $table->string('name');
            $table->timestamps();
            $table->unique(['guideline_version_id', 'menu_group', 'name'], 'diet_recipe_unique');
        });

        Schema::create('diet_recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_recipe_id')->constrained('diet_recipes')->cascadeOnDelete();
            $table->string('item_name');
            $table->string('ingredient_role', 20);
            $table->string('scale_item_name')->nullable();
            $table->boolean('is_menu_choice')->default(false);
            $table->timestamps();
        });

        $guidelineId = DB::table('diet_guideline_versions')->where('code', 'SKALA-DIET-2025')->value('id');
        $now = now();
        $add = static function (string $group, string $cycle, string $session, array $days) use ($guidelineId, $now): void {
            foreach ($days as $day => $dishes) {
                foreach (array_values($dishes) as $index => $dish) {
                    DB::table('diet_menu_entries')->insert([
                        'guideline_version_id' => $guidelineId, 'menu_group' => $group,
                        'week_cycle' => $cycle, 'day_of_week' => $day,
                        'meal_session' => $session, 'display_order' => $index + 1,
                        'dish_name' => $dish, 'created_at' => $now, 'updated_at' => $now,
                    ]);
                }
            }
        };

        $add('standard', 'M1-3', 'M1', [
            1 => ['Roti Putih','Kaya','Roti Ban','Teh Susu'],
            2 => ['Bubur Nasi Dengan Ikan Bilis Goreng','Roti Ban','Kopi Susu'],
            3 => ['Roti Putih','Marjerin','Roti Ban','Kopi Susu'],
            4 => ['Bubur Kacang Hijau / Kacang Merah','Roti Ban','Teh Susu'],
            5 => ['Roti Putih','Jem','Roti Ban','Teh Susu'],
            6 => ['Bubur Nasi Dengan Ikan Bilis Goreng','Kopi Susu'],
            0 => ['Roti Putih','Telur Goreng Hancur / Rebus','Roti Ban','Teh Susu'],
        ]);
        $add('standard', 'M1-3', 'M2', [
            1 => ['Nasi Putih','Tomyam Ayam','Kobis Panjang Goreng','Betik','Air Kosong'],
            2 => ['Nasi Putih','Ikan Cencaru Goreng','Bayam Masak Air','Nenas','Air Kosong'],
            3 => ['Nasi Putih','Ayam Masak Kicap','Kangkung Goreng Belacan','Tembikai Susu','Air Kosong'],
            4 => ['Nasi Putih','Ikan Air Tawar Goreng Sambal','Sawi Hijau Masak Air','Tembikai','Air Kosong'],
            5 => ['Nasi Putih','Telur Rebus Masak Sambal','Kacang Panjang Masak Lemak','Betik','Air Kosong'],
            6 => ['Nasi Putih','Ikan Kembung Masak Lemak Cili Padi','Kobis Bulat Goreng','Nenas','Air Kosong'],
            0 => ['Nasi Putih','Daging & Ubi Kentang Masak Kurma','Sawi Putih Goreng','Tembikai Susu','Air Kosong'],
        ]);
        $add('standard', 'M1-3', 'M4', [
            1 => ['Nasi Putih','Ikan Sardin Masak Kicap','Kacang Buncis Goreng','Betik','Air Kosong'],
            2 => ['Nasi Putih','Sambal Tauhu & Ikan Bilis Goreng','Terung & Fucuk Masak Lodeh','Nenas','Air Kosong'],
            3 => ['Nasi Putih','Ikan Pelata Masak Singgang Dengan Tomato','Bendi Goreng','Tembikai Susu','Air Kosong'],
            4 => ['Nasi Putih','Sup Ayam & Lobak Merah','Terung & Ikan Bilis Goreng Berlada','Tembikai','Air Kosong'],
            5 => ['Nasi Putih','Ayam & Ubi Kentang Masak Kurma','Bayam Goreng','Betik','Air Kosong'],
            6 => ['Nasi Putih','Ayam Masak Kicap','Taugeh & Tauhu Goreng','Nenas','Air Kosong'],
            0 => ['Nasi Putih','Ikan Selar Masak Asam Pedas','Kacang Panjang Goreng','Tembikai Susu','Air Kosong'],
        ]);

        $add('standard', 'M2-4', 'M1', [
            1 => ['Roti Putih','Kaya','Roti Ban','Kopi Susu'],
            2 => ['Bubur Nasi Dengan Telur Masin','Teh Susu'],
            3 => ['Roti Putih','Marjerin','Roti Ban','Kopi Susu'],
            4 => ['Bubur Kacang Hijau / Kacang Merah','Roti Ban','Teh Susu'],
            5 => ['Roti Putih','Jem','Roti Ban','Kopi Susu'],
            6 => ['Bubur Nasi Dengan Ikan Bilis Goreng','Teh Susu'],
            0 => ['Roti Putih','Telur Goreng Hancur / Rebus','Jem','Roti Ban','Kopi Susu'],
        ]);
        $add('standard', 'M2-4', 'M2', [
            1 => ['Nasi Putih','Ayam Masak Kicap','Kobis Panjang Goreng','Tembikai','Air Kosong'],
            2 => ['Nasi Putih','Ayam & Ubi Kentang Masak Kari','Sawi Hijau Goreng','Betik','Air Kosong'],
            3 => ['Nasi Putih','Ikan Selar Masak Asam Pedas','Bayam Goreng','Nenas','Air Kosong'],
            4 => ['Nasi Putih','Ikan Sardin Masak Kicap','Kobis Panjang Goreng','Tembikai Susu','Air Kosong'],
            5 => ['Nasi Putih','Ayam Goreng','Kuah Sup','Ulam Timun & Tomato','Tembikai','Air Kosong'],
            6 => ['Nasi Putih','Ikan Air Tawar Goreng Berlada','Sawi Putih Masak Air','Betik','Air Kosong'],
            0 => ['Nasi Putih','Ayam Masak Merah','Bayam Masak Air','Nenas','Air Kosong'],
        ]);
        $add('standard', 'M2-4', 'M4', [
            1 => ['Nasi Putih','Ikan Kembung Masak Singgang Dengan Tomato','Bendi Goreng','Tembikai','Air Kosong'],
            2 => ['Nasi Putih','Ikan Cencaru Goreng','Terung & Kacang Panjang Masak Dalca','Betik','Air Kosong'],
            3 => ['Nasi Putih','Telur Rebus Masak Sambal','Labu Kuning Masak Lemak Cili Padi','Nenas','Air Kosong'],
            4 => ['Nasi Putih','Daging & Ubi Kentang Masak Kari','Kobis Bulat Goreng','Tembikai Susu','Air Kosong'],
            5 => ['Nasi Putih','Ikan Cencaru Goreng Berlada','Petola / Kundur Masak Air','Tembikai','Air Kosong'],
            6 => ['Nasi Putih','Sambal Tauhu & Ikan Bilis Goreng','Taugeh Masak Lemak','Betik','Air Kosong'],
            0 => ['Nasi Putih','Ikan Pelata Masak Taucu','Kangkung Goreng Belacan','Nenas','Air Kosong'],
        ]);

        $add('juvenile', 'M1-3', 'M1', [
            1 => ['Roti Putih','Kaya','Susu'],2 => ['Bihun Goreng','Susu'],3 => ['Roti Putih','Marjerin','Susu'],
            4 => ['Bubur Nasi Dengan Telur Masin','Susu'],5 => ['Roti Putih','Jem','Susu'],
            6 => ['Bubur Nasi Dengan Ikan Bilis Goreng','Susu'],0 => ['Roti Putih','Telur Goreng Hancur / Rebus','Susu'],
        ]);
        $add('juvenile', 'M1-3', 'M2', [
            1 => ['Nasi Putih','Tomyam Ayam','Kobis Panjang Goreng','Betik','Air Kosong'],
            2 => ['Nasi Putih','Ikan Air Tawar Goreng Berlada','Bayam Masak Air','Nenas','Air Kosong'],
            3 => ['Nasi Putih','Daging & Ubi Kentang Masak Kurma','Kangkung Goreng Belacan','Tembikai Susu','Air Kosong'],
            4 => ['Nasi Putih','Ikan Cencaru Goreng Sambal','Sawi Hijau Masak Air','Tembikai','Air Kosong'],
            5 => ['Nasi Putih','Ayam & Ubi Kentang Masak Kari','Taugeh & Tauhu Goreng','Betik','Air Kosong'],
            6 => ['Nasi Putih','Ikan Kembung Masak Lemak Cili Padi','Kobis Bulat Goreng','Nenas','Air Kosong'],
            0 => ['Nasi Putih','Ayam Goreng Kunyit Dengan Lobak Merah','Sawi Putih Masak Air','Tembikai Susu','Air Kosong'],
        ]);
        $add('juvenile', 'M1-3', 'M3', [
            1 => ['Bubur Gandum','Teh O'],2 => ['Biskut Krim Kraker','Teh O'],3 => ['Bubur Pulut Hitam','Teh O'],
            4 => ['Roti Ban','Teh O'],5 => ['Bubur Kacang Hijau','Teh O'],6 => ['Biskut Jagung','Teh O'],0 => ['Roti Ban','Teh O'],
        ]);
        $add('juvenile', 'M1-3', 'M4', [
            1 => ['Nasi Putih','Ikan Kembung Masak Kicap','Kacang Buncis Goreng Dengan Tauhu','Betik','Air Kosong'],
            2 => ['Nasi Putih','Sambal Tauhu & Ikan Bilis Goreng','Kacang Panjang Masak Lemak','Nenas','Air Kosong'],
            3 => ['Nasi Putih','Ikan Pelata Masak Singgang Dengan Tomato','Bendi Goreng','Tembikai Susu','Air Kosong'],
            4 => ['Nasi Putih','Sup Ayam & Ubi Kentang','Terung & Ikan Bilis Goreng Berlada','Tembikai','Air Kosong'],
            5 => ['Nasi Putih','Telur Rebus Masak Sambal','Terung & Kacang Panjang Masak Dalca','Betik','Air Kosong'],
            6 => ['Nasi Putih','Ayam Goreng','Sup Lobak Merah & Tauhu','Nenas','Air Kosong'],
            0 => ['Nasi Putih','Ikan Selar Masak Asam Pedas','Ulam Bendi Rebus','Tembikai Susu','Air Kosong'],
        ]);

        $add('juvenile', 'M2-4', 'M1', [
            1 => ['Roti Putih','Kaya','Susu'],2 => ['Bihun Sup','Susu'],3 => ['Roti Putih','Marjerin','Susu'],
            4 => ['Bubur Nasi Dengan Telur Masin','Susu'],5 => ['Roti Putih','Jem','Susu'],
            6 => ['Bubur Nasi Dengan Ikan Bilis Goreng','Susu'],0 => ['Roti Putih','Telur Goreng Hancur / Rebus','Susu'],
        ]);
        $add('juvenile', 'M2-4', 'M2', [
            1 => ['Nasi Putih','Ayam Masak Kicap','Kangkung Goreng Belacan','Tembikai','Air Kosong'],
            2 => ['Nasi Putih','Ikan Selar Masak Kari','Sawi Hijau Goreng','Betik','Air Kosong'],
            3 => ['Nasi Putih','Ayam & Ubi Kentang Masak Kurma','Kobis Bulat Goreng Dengan Telur','Nenas','Air Kosong'],
            4 => ['Nasi Putih','Ikan Kembung Masak Kicap','Kobis Panjang Masak Air','Tembikai Susu','Air Kosong'],
            5 => ['Nasi Putih','Ayam Goreng','Kuah Sup','Ulam Timun & Tomato','Tembikai','Air Kosong'],
            6 => ['Nasi Putih','Daging & Ubi Kentang Masak Kari','Sawi Putih Masak Air','Betik','Air Kosong'],
            0 => ['Nasi Putih','Ikan Air Tawar Goreng Berlada','Bayam Masak Air','Nenas','Air Kosong'],
        ]);
        $add('juvenile', 'M2-4', 'M3', [
            1 => ['Biskut Krim Kraker','Teh O'],2 => ['Bubur Kacang Hijau','Teh O'],3 => ['Roti Ban','Teh O'],
            4 => ['Bubur Gandum','Teh O'],5 => ['Biskut Jagung','Teh O'],6 => ['Bubur Kacang Merah','Teh O'],0 => ['Roti Ban','Teh O'],
        ]);
        $add('juvenile', 'M2-4', 'M4', [
            1 => ['Nasi Putih','Ikan Kembung Masak Singgang Dengan Tomato','Kacang Buncis Goreng Dengan Tauhu','Tembikai','Air Kosong'],
            2 => ['Nasi Putih','Telur Rebus Masak Sambal','Labu Kuning Masak Lemak','Betik','Air Kosong'],
            3 => ['Nasi Putih','Ikan Selar Masak Asam Pedas','Bayam Goreng','Nenas','Air Kosong'],
            4 => ['Nasi Putih','Ayam Masak Merah','Terung & Kacang Panjang Masak Dalca','Tembikai Susu','Air Kosong'],
            5 => ['Nasi Putih','Ikan Cencaru Goreng Berlada','Petola / Kundur Masak Air','Tembikai','Air Kosong'],
            6 => ['Nasi Putih','Sambal Tauhu & Ikan Bilis Goreng','Terung & Fucuk Masak Lodeh','Betik','Air Kosong'],
            0 => ['Nasi Putih','Ayam Goreng','Taugeh & Tauhu Masak Lemak','Nenas','Air Kosong'],
        ]);

        $add('vegetarian', 'M1-3', 'M1', [
            1 => ['Roti Putih','Kaya','Roti Ban','Teh Susu'],2 => ['Bubur Nasi','Roti Ban','Kopi Susu'],
            3 => ['Roti Putih','Marjerin','Roti Ban','Kopi Susu'],4 => ['Bubur Kacang Hijau / Kacang Merah','Roti Ban','Teh Susu'],
            5 => ['Roti Putih','Jem','Roti Ban','Teh Susu'],6 => ['Bubur Nasi','Kopi Susu'],0 => ['Roti Putih','Marjerin','Roti Ban','Teh Susu'],
        ]);
        $add('vegetarian', 'M1-3', 'M2', [
            1 => ['Nasi Putih','Kobis Panjang Goreng','Betik','Air Kosong'],
            2 => ['Nasi Putih','Tauhu Goreng','Bayam Masak Air','Nenas','Air Kosong'],
            3 => ['Nasi Putih','Tauhu Masak Kicap','Kangkung Goreng','Tembikai Susu','Air Kosong'],
            4 => ['Nasi Putih','Tauhu Goreng Sambal','Sawi Hijau Masak Air','Tembikai','Air Kosong'],
            5 => ['Nasi Putih','Tauhu Goreng Sambal','Kacang Panjang Masak Lemak','Betik','Air Kosong'],
            6 => ['Nasi Putih','Tauhu Masak Lemak Cili Padi','Kobis Bulat Goreng','Nenas','Air Kosong'],
            0 => ['Nasi Putih','Tauhu Masak Kurma','Sawi Putih Goreng','Tembikai Susu','Air Kosong'],
        ]);
        $add('vegetarian', 'M1-3', 'M4', [
            1 => ['Nasi Putih','Tauhu Masak Kicap','Kacang Buncis Goreng','Betik','Air Kosong'],
            2 => ['Nasi Putih','Tauhu Goreng Sambal','Terung & Fucuk Masak Lodeh','Nenas','Air Kosong'],
            3 => ['Nasi Putih','Tauhu & Bendi Goreng','Tembikai Susu','Air Kosong'],
            4 => ['Nasi Putih','Sup Tauhu','Terung Goreng Berlada','Tembikai','Air Kosong'],
            5 => ['Nasi Putih','Tauhu Masak Kurma','Bayam Goreng','Betik','Air Kosong'],
            6 => ['Nasi Putih','Taugeh & Tauhu Goreng','Nenas','Air Kosong'],
            0 => ['Nasi Putih','Tauhu Masak Asam Pedas','Kacang Panjang Goreng','Tembikai Susu','Air Kosong'],
        ]);

        $add('vegetarian', 'M2-4', 'M1', [
            1 => ['Roti Putih','Kaya','Roti Ban','Kopi Susu'],2 => ['Bubur Nasi','Teh Susu'],
            3 => ['Roti Putih','Marjerin','Roti Ban','Kopi Susu'],4 => ['Bubur Kacang Hijau / Kacang Merah','Roti Ban','Teh Susu'],
            5 => ['Roti Putih','Jem','Roti Ban','Kopi Susu'],6 => ['Bubur Nasi','Teh Susu'],0 => ['Roti Putih','Jem','Roti Ban','Kopi Susu'],
        ]);
        $add('vegetarian', 'M2-4', 'M2', [
            1 => ['Nasi Putih','Tauhu Masak Kicap','Kobis Panjang Goreng','Tembikai','Air Kosong'],
            2 => ['Nasi Putih','Tauhu Masak Kari','Sawi Hijau Goreng','Betik','Air Kosong'],
            3 => ['Nasi Putih','Tauhu Masak Asam Pedas','Bayam Goreng','Nenas','Air Kosong'],
            4 => ['Nasi Putih','Tauhu Masak Kicap','Kobis Panjang Goreng','Tembikai Susu','Air Kosong'],
            5 => ['Nasi Putih','Tauhu Goreng','Sup Kosong','Ulam Timun & Tomato','Tembikai','Air Kosong'],
            6 => ['Nasi Putih','Tauhu Goreng Berlada','Sawi Putih Masak Air','Betik','Air Kosong'],
            0 => ['Nasi Putih','Tauhu Masak Merah','Bayam Masak Air','Nenas','Air Kosong'],
        ]);
        $add('vegetarian', 'M2-4', 'M4', [
            1 => ['Nasi Putih','Tauhu Masak Singgang Dengan Tomato','Tauhu & Bendi Goreng','Tembikai','Air Kosong'],
            2 => ['Nasi Putih','Tauhu Goreng Sambal','Terung & Kacang Panjang Masak Dalca','Betik','Air Kosong'],
            3 => ['Nasi Putih','Tauhu Masak Sambal','Labu Kuning Masak Lemak Cili Padi','Nenas','Air Kosong'],
            4 => ['Nasi Putih','Tauhu Masak Kari','Kobis Bulat Goreng','Tembikai Susu','Air Kosong'],
            5 => ['Nasi Putih','Tauhu Goreng Berlada','Petola / Kundur Masak Air','Tembikai','Air Kosong'],
            6 => ['Nasi Putih','Tauhu Goreng Sambal','Taugeh Masak Lemak','Betik','Air Kosong'],
            0 => ['Nasi Putih','Tauhu Masak Taucu','Kangkung Goreng','Nenas','Air Kosong'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_recipe_ingredients');
        Schema::dropIfExists('diet_recipes');
        Schema::dropIfExists('diet_menu_entries');
    }
};
