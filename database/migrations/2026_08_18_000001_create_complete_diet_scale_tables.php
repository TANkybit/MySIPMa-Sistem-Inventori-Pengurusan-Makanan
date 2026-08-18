<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_recipient_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('name');
            $table->string('menu_group', 30)->default('standard');
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('diet_scale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guideline_version_id')->constrained('diet_guideline_versions')->cascadeOnDelete();
            $table->unsignedSmallInteger('source_number');
            $table->string('item_name');
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->unique(['guideline_version_id', 'source_number'], 'diet_scale_source_unique');
        });

        Schema::create('diet_scale_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_scale_item_id')->constrained('diet_scale_items')->cascadeOnDelete();
            $table->string('category_code', 30);
            $table->decimal('quantity', 12, 3);
            $table->string('unit', 30);
            $table->timestamps();
            $table->unique(['diet_scale_item_id', 'category_code'], 'diet_scale_category_unique');
            $table->foreign('category_code')->references('code')->on('diet_recipient_categories')->cascadeOnDelete();
        });

        Schema::create('diet_additional_rations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guideline_version_id')->constrained('diet_guideline_versions')->cascadeOnDelete();
            $table->unsignedSmallInteger('source_number');
            $table->string('item_name');
            $table->decimal('quantity', 12, 3);
            $table->string('unit', 30)->default('g');
            $table->timestamps();
            $table->unique(['guideline_version_id', 'source_number'], 'diet_additional_source_unique');
        });

        Schema::create('diet_policy_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guideline_version_id')->constrained('diet_guideline_versions')->cascadeOnDelete();
            $table->string('section_code', 50);
            $table->string('category_code', 30)->nullable();
            $table->text('rule_text');
            $table->timestamps();
        });

        Schema::create('diet_infant_guidance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guideline_version_id')->constrained('diet_guideline_versions')->cascadeOnDelete();
            $table->string('age_group', 20);
            $table->string('item_name');
            $table->string('daily_measure');
            $table->text('preparation')->nullable();
            $table->timestamps();
        });

        Schema::create('order_diet_musters', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('category_code', 30);
            $table->unsignedInteger('headcount')->default(0);
            $table->timestamps();
            $table->unique(['order_id', 'category_code'], 'order_diet_muster_unique');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('category_code')->references('code')->on('diet_recipient_categories')->cascadeOnDelete();
        });

        $now = now();
        $categories = [
            ['standard', 'Banduan / Banduanita / Tahanan', 'standard'],
            ['vegetarian', 'Banduan Vegetarian', 'vegetarian'],
            ['pregnant', 'Banduan Mengandung', 'standard'],
            ['breastfeeding', 'Banduan Menyusukan Bayi', 'standard'],
            ['hiv_aids', 'Banduan HIV / AIDS', 'standard'],
            ['juvenile', 'Banduan Muda / Juvana', 'juvenile'],
            ['child_baby', 'Kanak-Kanak / Bayi', 'child'],
            ['restricted', 'Diet Terhad', 'restricted'],
        ];
        foreach ($categories as $index => [$code, $name, $menuGroup]) {
            DB::table('diet_recipient_categories')->insert([
                'code' => $code, 'name' => $name, 'menu_group' => $menuGroup,
                'display_order' => $index + 1, 'is_active' => true,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        $guidelineId = DB::table('diet_guideline_versions')->where('code', 'SKALA-DIET-2025')->value('id');
        $adult = ['standard', 'vegetarian', 'pregnant', 'breastfeeding', 'hiv_aids', 'juvenile'];
        $nonVegetarian = ['standard', 'pregnant', 'breastfeeding', 'hiv_aids', 'juvenile'];
        $scales = [
            [1, 'Ayam', 'Dengan tulang dan kulit', array_merge(array_fill_keys($nonVegetarian, [100, 'g']), ['child_baby' => [40, 'g']])],
            [2, 'Ikan Segar', 'Tanpa kepala dan perut', array_merge(array_fill_keys($nonVegetarian, [100, 'g']), ['child_baby' => [30, 'g']])],
            [3, 'Daging', 'Tanpa lemak dan tulang', array_merge(array_fill_keys($nonVegetarian, [70, 'g']), ['child_baby' => [20, 'g']])],
            [4, 'Beras', 'Untuk nasi (setiap hari)', array_merge(array_fill_keys($adult, [300, 'g']), ['child_baby' => [25, 'g']])],
            [5, 'Beras', 'Untuk bubur nasi', array_fill_keys($adult, [50, 'g'])],
            [6, 'Beras Pulut Hitam', 'Untuk Juvana', ['juvenile' => [50, 'g']]],
            [7, 'Bihun', 'Untuk Juvana', ['juvenile' => [100, 'g']]],
            [8, 'Biji Gandum', 'Untuk Juvana', ['juvenile' => [50, 'g']]],
            [9, 'Bijirin Bayi', 'Untuk Bayi', ['child_baby' => [50, 'g']]],
            [10, 'Biskut', 'Untuk Juvana', ['juvenile' => [25, 'g']]],
            [11, 'Betik', null, array_merge(array_fill_keys($adult, [150, 'g']), ['child_baby' => [80, 'g']])],
            [12, 'Nenas', null, array_fill_keys($adult, [150, 'g'])],
            [13, 'Tembikai Susu', null, array_merge(array_fill_keys($adult, [150, 'g']), ['child_baby' => [80, 'g']])],
            [14, 'Tembikai', 'Tanpa kulit', array_merge(array_fill_keys($adult, [150, 'g']), ['child_baby' => [100, 'g']])],
            [15, 'Oren', 'Untuk Kanak-Kanak / Bayi', ['child_baby' => [0.5, 'biji']]],
            [16, 'Pisang', 'Untuk Kanak-Kanak / Bayi', ['child_baby' => [45, 'g']]],
            [17, 'Fucuk', null, array_fill_keys($adult, [15, 'g'])],
            [18, 'Gula', null, array_merge(array_fill_keys($adult, [15, 'g']), ['child_baby' => [5, 'g']])],
            [19, 'Gula Merah', null, array_fill_keys($adult, [5, 'g'])],
            [20, 'Ikan Bilis', null, array_merge(array_fill_keys($nonVegetarian, [10, 'g']), ['child_baby' => [10, 'g']])],
            [21, 'Jem / Kaya', null, array_fill_keys($adult, [15, 'g'])],
            [22, 'Kacang Hijau / Kacang Merah', null, array_merge(array_fill_keys($adult, [50, 'g']), ['child_baby' => [25, 'g']])],
            [23, 'Kopi', null, array_fill_keys($adult, [8, 'g'])],
            [24, 'Marjerin', null, array_fill_keys($adult, [15, 'g'])],
            [25, 'Minyak Masak', null, array_merge(array_fill_keys($adult, [20, 'g']), ['child_baby' => [5, 'g']])],
            [26, 'Roti Ban', null, array_fill_keys($adult, [50, 'g'])],
            [27, 'Roti Ban', 'Tambahan banduan menyusukan bayi', ['breastfeeding' => [50, 'g']]],
            [28, 'Roti Putih', null, array_fill_keys($adult, [120, 'g'])],
            [29, 'Sayur Berdaun', 'Tanpa akar', array_merge(array_fill_keys($adult, [160, 'g']), ['child_baby' => [30, 'g']])],
            [30, 'Sayur Berdaun', 'Tambahan banduan menyusukan bayi', ['breastfeeding' => [50, 'g']]],
            [31, 'Sayur Tidak Berdaun', null, array_merge(array_fill_keys($adult, [200, 'g']), ['child_baby' => [20, 'g']])],
            [32, 'Susu Tepung Penuh Krim', 'Untuk susu / teh / kopi', array_merge(array_fill_keys($adult, [30, 'g']), ['child_baby' => [10, 'g']])],
            [33, 'Susu Tepung Penuh Krim', 'Tambahan mengandung / menyusukan bayi / HIV atau AIDS', array_fill_keys(['pregnant', 'breastfeeding', 'hiv_aids'], [30, 'g'])],
            [34, 'Tauhu', null, array_fill_keys($adult, [200, 'g'])],
            [35, 'Teh', null, array_fill_keys($adult, [6.25, 'g'])],
            [36, 'Telur', null, array_merge(array_fill_keys($adult, [1, 'biji']), ['child_baby' => [0.5, 'biji']])],
            [37, 'Tepung Kastard', 'Untuk Kanak-Kanak / Bayi', ['child_baby' => [15, 'g']]],
            [38, 'Ubi Kentang', null, array_merge(array_fill_keys($adult, [50, 'g']), ['child_baby' => [25, 'g']])],
        ];

        foreach ($scales as [$number, $itemName, $notes, $rates]) {
            $itemId = DB::table('diet_scale_items')->insertGetId([
                'guideline_version_id' => $guidelineId, 'source_number' => $number,
                'item_name' => $itemName, 'notes' => $notes,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            foreach ($rates as $category => [$quantity, $unit]) {
                DB::table('diet_scale_rates')->insert([
                    'diet_scale_item_id' => $itemId, 'category_code' => $category,
                    'quantity' => $quantity, 'unit' => $unit,
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }

        $additional = [
            ['Asam Jawa',2],['Asam Keping',0.5],['Bawang Besar',1],['Bawang Merah',1],['Bawang Putih',1],
            ['Belacan',1],['Biji Lada Hitam',1],['Buah Pelaga',0.5],['Bunga Cengkih',0.5],['Bunga Lawang',0.5],
            ['Cili',1],['Cili Kering',1],['Cili Padi',3],['Cuka',1],['Dal',10],['Daun Bawang',0.5],
            ['Daun Kari',0.5],['Daun Kesum',1],['Daun Limau Purut',0.5],['Daun Sup',0.5],['Garam',5],
            ['Halba',0.5],['Halia',1],['Ikan Bilis',8],['Kicap Cair',2],['Kicap Pekat',2],['Kiub Tom Yam',1],
            ['Kulit Kayu Manis',0.5],['Limau Kasturi',10],['Rempah Kari',2],['Rempah Kurma',5],['Rempah Sup',5],
            ['Serai',1],['Serbuk Cili',1],['Serbuk Kunyit',1],['Serbuk Lada Sulah',0.5],['Serbuk Santan',3],
            ['Suun',1],['Sos Cili',10],['Taucu',1],['Taugeh',10],['Tauhu',50],['Telur Asin',0.25,'biji'],
            ['Telur',0.5,'biji'],['Tomato',10],
        ];
        foreach ($additional as $index => $row) {
            DB::table('diet_additional_rations')->insert([
                'guideline_version_id' => $guidelineId, 'source_number' => $index + 1,
                'item_name' => $row[0], 'quantity' => $row[1], 'unit' => $row[2] ?? 'g',
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        $notes = [
            ['category_addition', 'pregnant', 'Tambahan 1 gelas air susu tanpa gula pada waktu minum malam.'],
            ['category_addition', 'breastfeeding', 'Tambahan 1 gelas air susu tanpa gula, roti ban pada waktu minum malam dan sayur berdaun 50g.'],
            ['category_addition', 'hiv_aids', 'Tambahan 1 gelas air susu tanpa gula pada waktu minum malam; diet lembut boleh diberi jika sangat uzur.'],
            ['restricted_diet', null, 'Banduan atau banduanita didera diberi diet terhad 500g roti dan 50g susu sehari, membekalkan 1,500 kilokalori.'],
            ['sugar', null, 'Teh susu/kopi susu 15g; teh O/kopi O 10g; bubur 10g; kanak-kanak 5g. Teh O tanpa gula apabila bersama bubur kacang atau pulut hitam.'],
            ['milk', null, 'Susu tepung penuh krim untuk teh, kopi atau susu ialah 30g.'],
            ['cooking_oil', null, 'Minyak menggoreng dewasa 15g sehari (andaian 50% diserap), kanak-kanak 5g setiap sajian; minyak menumis dewasa 5g sehari, kanak-kanak 5g setiap sajian.'],
            ['child_menu', 'child_baby', 'Ikan masak lemak/singgang, sup ayam dan ayam masak kicap tidak perlu digoreng; lada sulah, cili, rempah dan cuka tidak digunakan.'],
            ['other_menu', null, 'Sambal nasi ayam menggunakan cuka, cili kering atau sos cili, bawang putih dan gula.'],
        ];
        foreach ($notes as [$section, $category, $text]) {
            DB::table('diet_policy_notes')->insert([
                'guideline_version_id' => $guidelineId, 'section_code' => $section,
                'category_code' => $category, 'rule_text' => $text,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        $infant = [
            ['5-6', 'Bubur Nasi', '5 sudu makan', '1 sukatan beras dengan 10 sukatan air; dikisar/dilecek dan ditapis.'],
            ['5-6', 'Ikan / Ayam / Daging / Tauhu', '1 sudu makan', 'Direbus, dikisar/dilecek dan ditapis.'],
            ['5-6', 'Ikan Bilis', '1 sudu makan', 'Digoreng tanpa minyak dan dikisar halus.'],
            ['5-6', 'Kuning Telur', '0.5 biji', 'Direbus.'],['5-6', 'Minyak Masak', '1 sudu teh', 'Dimasukkan ke dalam bubur.'],
            ['5-6', 'Sayur', '1 sudu makan', 'Direbus dengan sedikit air, dikisar/dilecek dan ditapis.'],
            ['5-6', 'Buah-buahan', '2 sudu makan', 'Dikisar/dilecek dan ditapis atau diperah.'],
            ['7-9', 'Bubur Nasi', '2 cawan (pekat)', '1 sukatan beras dengan 5 sukatan air; dilecek.'],
            ['7-9', 'Ikan / Ayam / Daging / Tauhu', '2 sudu makan', 'Direbus dan dilecek.'],
            ['7-9', 'Ikan Bilis', '1 sudu makan', 'Digoreng tanpa minyak dan dikisar halus.'],
            ['7-9', 'Kuning Telur', '0.5 biji', 'Direbus.'],['7-9', 'Minyak Masak', '1 sudu teh', 'Dimasukkan ke dalam bubur.'],
            ['7-9', 'Sayur', '2 sudu makan', 'Direbus dan dilecek.'],['7-9', 'Buah-buahan', '2 sudu makan', 'Dilecek.'],
            ['10-12', 'Bubur Nasi', '1.75 cawan', 'Dimasak sebagai nasi lembik.'],
            ['10-12', 'Ikan / Ayam / Daging / Tauhu', '4 sudu makan', 'Direbus dan dipotong kecil.'],
            ['10-12', 'Ikan Bilis', '1 sudu makan', 'Digoreng tanpa minyak dan dikisar halus.'],
            ['10-12', 'Kuning Telur', '0.5 biji', 'Direbus setengah masak; awasi alahan jika putih telur diberi.'],
            ['10-12', 'Minyak Masak', '1 sudu teh', 'Dimasukkan ke dalam bubur.'],
            ['10-12', 'Sayur', '4 sudu makan', 'Direbus dan dicincang kecil.'],['10-12', 'Buah-buahan', '2 sudu makan', 'Dipotong kecil.'],
        ];
        foreach ($infant as [$age, $item, $measure, $preparation]) {
            DB::table('diet_infant_guidance')->insert([
                'guideline_version_id' => $guidelineId, 'age_group' => $age,
                'item_name' => $item, 'daily_measure' => $measure, 'preparation' => $preparation,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_diet_musters');
        Schema::dropIfExists('diet_infant_guidance');
        Schema::dropIfExists('diet_policy_notes');
        Schema::dropIfExists('diet_additional_rations');
        Schema::dropIfExists('diet_scale_rates');
        Schema::dropIfExists('diet_scale_items');
        Schema::dropIfExists('diet_recipient_categories');
    }
};
