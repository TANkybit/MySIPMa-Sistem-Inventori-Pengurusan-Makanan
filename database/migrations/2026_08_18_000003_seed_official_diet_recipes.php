<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diet_recipe_ingredients', function (Blueprint $table) {
            $table->unsignedSmallInteger('scale_source_number')->nullable()->after('scale_item_name');
            $table->decimal('quantity_override', 12, 3)->nullable()->after('scale_source_number');
            $table->string('unit_override', 30)->nullable()->after('quantity_override');
        });

        $guidelineId = DB::table('diet_guideline_versions')->where('code', 'SKALA-DIET-2025')->value('id');
        $now = now();

        $main = static fn (string $item, int $source) => [$item, 'main', $source, null, null];
        $extra = static fn (string $item) => [$item, 'seasoning', null, null, null];
        $fixed = static fn (string $item, float $quantity, string $unit = 'g') => [$item, 'fixed', null, $quantity, $unit];

        $rice = $main('Beras', 4);
        $oil = $main('Minyak Masak', 25);
        $leafy = static fn (string $item) => $main($item, 29);
        $nonLeafy = static fn (string $item) => $main($item, 31);
        $fish = static fn (string $item) => $main($item, 2);

        $recipes = [
            'Air Kosong' => [],
            'Nasi Putih' => [$rice],
            'Roti Putih' => [$main('Roti Putih', 28)],
            'Roti Ban' => [$main('Roti Ban', 26)],
            'Kaya' => [$main('Kaya', 21)], 'Jem' => [$main('Jem', 21)], 'Marjerin' => [$main('Marjerin', 24)],
            'Teh Susu' => [$main('Teh', 35),$main('Susu Tepung Penuh Krim', 32),$main('Gula', 18)],
            'Kopi Susu' => [$main('Kopi', 23),$main('Susu Tepung Penuh Krim', 32),$main('Gula', 18)],
            'Susu' => [$main('Susu Tepung Penuh Krim', 32)],
            'Teh O' => [$main('Teh', 35),$fixed('Gula', 10)],
            'Betik' => [$main('Betik', 11)], 'Nenas' => [$main('Nenas', 12)],
            'Tembikai Susu' => [$main('Tembikai Susu', 13)], 'Tembikai' => [$main('Tembikai', 14)],
            'Bubur Nasi' => [$main('Beras', 5),$oil],
            'Bubur Nasi Dengan Ikan Bilis Goreng' => [$main('Beras', 5),$main('Ikan Bilis', 20),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Daun Bawang'),$extra('Daun Sup'),$extra('Garam'),$extra('Halia')],
            'Bubur Nasi Dengan Telur Masin' => [$main('Beras', 5),$fixed('Telur Asin', .25, 'biji'),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Daun Bawang'),$extra('Daun Sup'),$extra('Garam'),$extra('Halia')],
            'Bubur Kacang Hijau / Kacang Merah' => [$main('Kacang Hijau / Kacang Merah', 22),$fixed('Gula',10),$main('Gula Merah',19),$extra('Garam'),$extra('Serbuk Santan')],
            'Bubur Kacang Hijau' => [$main('Kacang Hijau',22),$fixed('Gula',10),$main('Gula Merah',19),$extra('Garam'),$extra('Serbuk Santan')],
            'Bubur Kacang Merah' => [$main('Kacang Merah',22),$fixed('Gula',10),$main('Gula Merah',19),$extra('Garam'),$extra('Serbuk Santan')],
            'Bubur Gandum' => [$main('Biji Gandum',8),$fixed('Gula',10),$extra('Garam'),$extra('Serbuk Santan')],
            'Bubur Pulut Hitam' => [$main('Beras Pulut Hitam',6),$fixed('Gula',10),$main('Gula Merah',19),$extra('Garam'),$extra('Serbuk Santan')],
            'Biskut Krim Kraker' => [$main('Biskut',10)], 'Biskut Jagung' => [$main('Biskut',10)],
            'Telur Goreng Hancur / Rebus' => [$main('Telur',36),$oil,$extra('Garam'),$extra('Serbuk Lada Sulah')],
            'Telur Rebus Masak Sambal' => [$main('Telur',36),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Garam')],

            'Ayam Goreng' => [$main('Daging Ayam',1),$oil,$extra('Garam'),$extra('Serbuk Kunyit')],
            'Ayam Goreng Kunyit Dengan Lobak Merah' => [$main('Daging Ayam',1),$nonLeafy('Lobak Merah'),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam'),$extra('Serbuk Kunyit')],
            'Ayam Masak Kicap' => [$main('Daging Ayam',1),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Cili Kering'),$extra('Garam'),$extra('Halia'),$extra('Kicap Cair'),$extra('Kicap Pekat'),$extra('Kulit Kayu Manis'),$extra('Serbuk Kunyit'),$extra('Tomato')],
            'Ayam Masak Merah' => [$main('Daging Ayam',1),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili'),$extra('Cili Kering'),$extra('Garam'),$extra('Halia'),$extra('Serbuk Kunyit'),$extra('Sos Cili'),$extra('Tomato')],
            'Tomyam Ayam' => [$main('Daging Ayam',1),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Padi'),$extra('Daun Limau Purut'),$extra('Garam'),$extra('Halia'),$extra('Kiub Tom Yam'),$extra('Serai'),$extra('Tomato')],
            'Ayam & Ubi Kentang Masak Kari' => [$main('Daging Ayam',1),$main('Ubi Kentang',38),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Daun Kari'),$extra('Garam'),$extra('Halia'),$extra('Kulit Kayu Manis'),$extra('Rempah Kari'),$extra('Serbuk Santan')],
            'Daging & Ubi Kentang Masak Kari' => [$main('Daging',3),$main('Ubi Kentang',38),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Daun Kari'),$extra('Garam'),$extra('Halia'),$extra('Kulit Kayu Manis'),$extra('Rempah Kari'),$extra('Serbuk Santan')],
            'Ayam & Ubi Kentang Masak Kurma' => [$main('Daging Ayam',1),$main('Ubi Kentang',38),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Garam'),$extra('Halia'),$extra('Kulit Kayu Manis'),$extra('Rempah Kurma'),$extra('Serai'),$extra('Serbuk Santan'),$extra('Tomato')],
            'Daging & Ubi Kentang Masak Kurma' => [$main('Daging',3),$main('Ubi Kentang',38),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Garam'),$extra('Halia'),$extra('Kulit Kayu Manis'),$extra('Rempah Kurma'),$extra('Serai'),$extra('Serbuk Santan'),$extra('Tomato')],
            'Sup Ayam & Lobak Merah' => [$main('Daging Ayam',1),$nonLeafy('Lobak Merah'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Daun Bawang'),$extra('Daun Sup'),$extra('Garam'),$extra('Halia'),$extra('Kulit Kayu Manis'),$extra('Rempah Sup'),$extra('Tomato')],
            'Sup Ayam & Ubi Kentang' => [$main('Daging Ayam',1),$main('Ubi Kentang',38),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Daun Bawang'),$extra('Daun Sup'),$extra('Garam'),$extra('Halia'),$extra('Kulit Kayu Manis'),$extra('Rempah Sup'),$extra('Tomato')],

            'Ikan Cencaru Goreng' => [$fish('Cencaru'),$oil,$extra('Garam'),$extra('Serbuk Kunyit')],
            'Ikan Cencaru Goreng Berlada' => [$fish('Cencaru'),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Cili Padi'),$extra('Garam'),$extra('Serbuk Kunyit')],
            'Ikan Cencaru Goreng Sambal' => [$fish('Cencaru'),$oil,$extra('Asam Jawa'),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Garam'),$extra('Serai'),$extra('Serbuk Kunyit')],
            'Ikan Air Tawar Goreng Berlada' => [$fish('Ikan Air Tawar'),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Cili Padi'),$extra('Garam'),$extra('Serbuk Kunyit')],
            'Ikan Air Tawar Goreng Sambal' => [$fish('Ikan Air Tawar'),$oil,$extra('Asam Jawa'),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Garam'),$extra('Serai'),$extra('Serbuk Kunyit')],
            'Ikan Kembung Masak Lemak Cili Padi' => [$fish('Kembung'),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Padi'),$extra('Garam'),$extra('Serai'),$extra('Serbuk Kunyit'),$extra('Serbuk Santan')],
            'Ikan Kembung Masak Kicap' => [$fish('Kembung'),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Cili Kering'),$extra('Garam'),$extra('Halia'),$extra('Kicap Cair'),$extra('Kicap Pekat'),$extra('Kulit Kayu Manis'),$extra('Serbuk Kunyit')],
            'Ikan Kembung Masak Singgang Dengan Tomato' => [$fish('Kembung'),$extra('Asam Keping'),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam'),$extra('Serai'),$extra('Tomato')],
            'Ikan Pelata Masak Singgang Dengan Tomato' => [$fish('Pelata'),$extra('Asam Keping'),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam'),$extra('Serai'),$extra('Tomato')],
            'Ikan Pelata Masak Taucu' => [$fish('Pelata'),$oil,$extra('Asam Jawa'),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam'),$extra('Halia'),$extra('Serbuk Kunyit'),$extra('Taucu')],
            'Ikan Sardin Masak Kicap' => [$fish('Sardin'),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Cili Kering'),$extra('Garam'),$extra('Halia'),$extra('Kicap Cair'),$extra('Kicap Pekat'),$extra('Kulit Kayu Manis'),$extra('Serbuk Kunyit')],
            'Ikan Selar Masak Asam Pedas' => [$fish('Selar'),$oil,$extra('Asam Jawa'),$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Belacan'),$extra('Cili Kering'),$extra('Daun Kesum'),$extra('Garam'),$extra('Halba'),$extra('Halia'),$extra('Serbuk Kunyit'),$extra('Tomato')],
            'Ikan Selar Masak Kari' => [$fish('Selar'),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Daun Kari'),$extra('Garam'),$extra('Halba'),$extra('Halia'),$extra('Kulit Kayu Manis'),$extra('Rempah Kari'),$extra('Serbuk Santan'),$extra('Tomato')],

            'Kobis Panjang Goreng' => [$nonLeafy('Kobis Panjang'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Kobis Panjang Masak Air' => [$nonLeafy('Kobis Panjang'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam'),$extra('Ikan Bilis')],
            'Kobis Bulat Goreng' => [$nonLeafy('Kobis Bulat'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Kobis Bulat Goreng Dengan Telur' => [$nonLeafy('Kobis Bulat'),$main('Telur',36),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Bayam Goreng' => [$leafy('Bayam Hijau'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Bayam Masak Air' => [$leafy('Bayam Hijau'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam'),$extra('Ikan Bilis')],
            'Sawi Hijau Goreng' => [$leafy('Sawi Hijau'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Sawi Hijau Masak Air' => [$leafy('Sawi Hijau'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam'),$extra('Ikan Bilis')],
            'Sawi Putih Goreng' => [$leafy('Sawi Putih'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Sawi Putih Masak Air' => [$leafy('Sawi Putih'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam'),$extra('Ikan Bilis')],
            'Kacang Buncis Goreng' => [$nonLeafy('Kacang Buncis'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Kacang Buncis Goreng Dengan Tauhu' => [$nonLeafy('Kacang Buncis'),$main('Tauhu',34),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam')],
            'Kacang Panjang Goreng' => [$nonLeafy('Kacang Panjang'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Kacang Panjang Masak Lemak' => [$nonLeafy('Kacang Panjang'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam'),$extra('Serbuk Santan')],
            'Bendi Goreng' => [$nonLeafy('Bendi'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Ulam Bendi Rebus' => [$nonLeafy('Bendi')],
            'Kangkung Goreng Belacan' => [$leafy('Kangkung'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Belacan'),$extra('Cili'),$extra('Garam')],
            'Kangkung Goreng' => [$leafy('Kangkung'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Labu Kuning Masak Lemak' => [$nonLeafy('Labu Kuning'),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Padi'),$extra('Garam'),$extra('Serai'),$extra('Serbuk Santan')],
            'Labu Kuning Masak Lemak Cili Padi' => [$nonLeafy('Labu Kuning'),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Padi'),$extra('Garam'),$extra('Serai'),$extra('Serbuk Santan')],
            'Petola / Kundur Masak Air' => [$nonLeafy('Ketola / Kundur'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam'),$extra('Ikan Bilis')],
            'Ulam Timun & Tomato' => [$nonLeafy('Timun'),$nonLeafy('Tomato')],
            'Terung & Ikan Bilis Goreng Berlada' => [$nonLeafy('Terung'),$main('Ikan Bilis',20),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Cili Padi'),$extra('Garam')],
            'Terung & Kacang Panjang Masak Dalca' => [$nonLeafy('Terung'),$nonLeafy('Kacang Panjang'),$main('Ubi Kentang',38),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Dal'),$extra('Daun Kari'),$extra('Garam'),$extra('Halia'),$extra('Kulit Kayu Manis'),$extra('Rempah Kari'),$extra('Serbuk Santan'),$extra('Tomato')],
            'Terung & Fucuk Masak Lodeh' => [$nonLeafy('Terung'),$main('Fucuk',17),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam'),$extra('Serbuk Kunyit'),$extra('Serbuk Santan'),$extra('Suun')],
            'Terung Goreng Berlada' => [$nonLeafy('Terung'),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Cili Padi'),$extra('Garam')],
            'Taugeh & Tauhu Goreng' => [$nonLeafy('Taugeh'),$main('Tauhu',34),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam')],
            'Taugeh & Tauhu Masak Lemak' => [$nonLeafy('Taugeh'),$main('Tauhu',34),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam'),$extra('Serbuk Santan')],
            'Taugeh Masak Lemak' => [$nonLeafy('Taugeh'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam'),$extra('Serbuk Santan')],
            'Sambal Tauhu & Ikan Bilis Goreng' => [$main('Tauhu',34),$main('Ikan Bilis',20),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Garam')],
            'Sup Lobak Merah & Tauhu' => [$nonLeafy('Lobak Merah'),$main('Tauhu',34),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Daun Sup'),$extra('Garam')],
            'Kuah Sup' => [$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Daun Bawang'),$extra('Daun Sup'),$extra('Garam'),$extra('Halia'),$extra('Rempah Sup')],
            'Sup Kosong' => [$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Daun Bawang'),$extra('Daun Sup'),$extra('Garam'),$extra('Halia'),$extra('Rempah Sup')],

            'Tauhu Goreng' => [$main('Tauhu',34),$oil],
            'Tauhu & Bendi Goreng' => [$main('Tauhu',34),$nonLeafy('Bendi'),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam')],
            'Sup Tauhu' => [$main('Tauhu',34),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Daun Sup'),$extra('Garam')],
            'Tauhu Goreng Sambal' => [$main('Tauhu',34),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Garam')],
            'Tauhu Goreng Berlada' => [$main('Tauhu',34),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Cili Padi'),$extra('Garam')],
            'Tauhu Masak Sambal' => [$main('Tauhu',34),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Garam')],
            'Tauhu Masak Kicap' => [$main('Tauhu',34),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Kicap Cair'),$extra('Kicap Pekat'),$extra('Garam')],
            'Tauhu Masak Kari' => [$main('Tauhu',34),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Daun Kari'),$extra('Garam'),$extra('Rempah Kari'),$extra('Serbuk Santan')],
            'Tauhu Masak Kurma' => [$main('Tauhu',34),$oil,$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Garam'),$extra('Rempah Kurma'),$extra('Serbuk Santan')],
            'Tauhu Masak Lemak Cili Padi' => [$main('Tauhu',34),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Padi'),$extra('Garam'),$extra('Serai'),$extra('Serbuk Santan')],
            'Tauhu Masak Merah' => [$main('Tauhu',34),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Garam'),$extra('Sos Cili'),$extra('Tomato')],
            'Tauhu Masak Asam Pedas' => [$main('Tauhu',34),$oil,$extra('Asam Jawa'),$extra('Bawang Besar'),$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Daun Kesum'),$extra('Garam'),$extra('Tomato')],
            'Tauhu Masak Singgang Dengan Tomato' => [$main('Tauhu',34),$extra('Asam Keping'),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam'),$extra('Serai'),$extra('Tomato')],
            'Tauhu Masak Taucu' => [$main('Tauhu',34),$oil,$extra('Asam Jawa'),$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili'),$extra('Garam'),$extra('Halia'),$extra('Taucu')],

            'Bihun Goreng' => [$main('Bihun',7),$leafy('Sawi Hijau'),$oil,$extra('Bawang Besar'),$extra('Bawang Putih'),$extra('Cili Kering'),$extra('Garam'),$extra('Ikan Bilis'),$extra('Kicap Cair'),$extra('Kicap Pekat'),$extra('Sos Cili'),$fixed('Telur',.5,'biji')],
            'Bihun Sup' => [$main('Bihun',7),$fixed('Taugeh',10),$oil,$extra('Bawang Merah'),$extra('Bawang Putih'),$extra('Buah Pelaga'),$extra('Bunga Cengkih'),$extra('Bunga Lawang'),$extra('Daun Bawang'),$extra('Daun Sup'),$extra('Garam'),$extra('Halia'),$extra('Kulit Kayu Manis'),$extra('Rempah Sup')],
        ];

        foreach ($recipes as $name => $ingredients) {
            $recipeId = DB::table('diet_recipes')->insertGetId([
                'guideline_version_id' => $guidelineId, 'menu_group' => 'shared',
                'source_number' => null, 'name' => $name,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            foreach ($ingredients as [$item, $role, $source, $quantity, $unit]) {
                DB::table('diet_recipe_ingredients')->insert([
                    'diet_recipe_id' => $recipeId, 'item_name' => $item,
                    'ingredient_role' => $role, 'scale_item_name' => null,
                    'scale_source_number' => $source, 'quantity_override' => $quantity,
                    'unit_override' => $unit, 'is_menu_choice' => str_contains($item, ' / '),
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('diet_recipes')->where('menu_group', 'shared')->delete();
        Schema::table('diet_recipe_ingredients', function (Blueprint $table) {
            $table->dropColumn(['scale_source_number', 'quantity_override', 'unit_override']);
        });
    }
};
