<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Uom;
use App\Models\Item;

class SeedItemsFromPdf extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clear existing items data to ensure a clean state
        // We will disable foreign key checks so we don't hit constrain violations
        // if orders already reference these items.
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // We'll clear items.
        // We also clear categories and uom to start fresh if needed, 
        // but it's safer to just empty items and use updateOrCreate for categories/UOMs.
        DB::table('items')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data from PDF, sanitized (removed "1", "2.1", "a)" etc.)
        $data = [
            ['name' => 'DAGING LEMBU/KERBAU (BEKU)', 'cat' => 'DAGING', 'uom' => 'kg', 'qty' => 52806, 'price' => 27.00],
            ['name' => 'Cencaru', 'cat' => 'IKAN SEGAR (LAUT)', 'uom' => 'kg', 'qty' => 113126, 'price' => 11.00],
            ['name' => 'Kembung', 'cat' => 'IKAN SEGAR (LAUT)', 'uom' => 'kg', 'qty' => 75426, 'price' => 16.00],
            ['name' => 'Pelata', 'cat' => 'IKAN SEGAR (LAUT)', 'uom' => 'kg', 'qty' => 75426, 'price' => 13.00],
            ['name' => 'Sardin', 'cat' => 'IKAN SEGAR (LAUT)', 'uom' => 'kg', 'qty' => 75426, 'price' => 11.00],
            ['name' => 'Selar', 'cat' => 'IKAN SEGAR (LAUT)', 'uom' => 'kg', 'qty' => 75426, 'price' => 16.00],
            ['name' => 'TELUR AYAM (GRED B)', 'cat' => 'TELUR AYAM', 'uom' => 'Biji', 'qty' => 1508026, 'price' => 0.60],
            ['name' => 'Bayam Hijau', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 241306, 'price' => 6.00],
            ['name' => 'Kobis Bulat', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 120666, 'price' => 4.50],
            ['name' => 'Kobis Panjang', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 180986, 'price' => 5.00],
            ['name' => 'Sawi Hijau', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 120666, 'price' => 7.00],
            ['name' => 'Sawi Putih', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 120666, 'price' => 6.50],
            ['name' => 'Bendi', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 150826, 'price' => 10.00],
            ['name' => 'Kacang Buncis', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 75426, 'price' => 12.00],
            ['name' => 'Kacang Panjang', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 226226, 'price' => 9.00],
            ['name' => 'Ketola', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 37726, 'price' => 7.50],
            ['name' => 'Kundur', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 37726, 'price' => 3.50],
            ['name' => 'Labu Kuning', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 75426, 'price' => 4.00],
            ['name' => 'Lobak Merah', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 75426, 'price' => 5.00],
            ['name' => 'Terung', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 226226, 'price' => 8.00],
            ['name' => 'Timun', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 75426, 'price' => 4.00],
            ['name' => 'Tomato', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 124462, 'price' => 7.50],
            ['name' => 'Betik', 'cat' => 'BUAH', 'uom' => 'kg', 'qty' => 452426, 'price' => 4.50],
            ['name' => 'Nanas', 'cat' => 'BUAH', 'uom' => 'kg', 'qty' => 452426, 'price' => 5.00],
            ['name' => 'Tembikai', 'cat' => 'BUAH', 'uom' => 'kg', 'qty' => 339326, 'price' => 4.00],
            ['name' => 'Tembikai Susu', 'cat' => 'BUAH', 'uom' => 'kg', 'qty' => 339326, 'price' => 6.00],
            ['name' => 'Fucuk', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 5668, 'price' => 22.50],
            ['name' => 'Gula', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 90506, 'price' => 4.00],
            ['name' => 'Gula Merah', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 3796, 'price' => 7.00],
            ['name' => 'Ikan Bilis', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 35490, 'price' => 35.00],
            ['name' => 'Jem', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 16978, 'price' => 13.50],
            ['name' => 'Kacang Hijau', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 18876, 'price' => 9.00],
            ['name' => 'Kacang Merah', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 18876, 'price' => 11.00],
            ['name' => 'Kaya', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 11336, 'price' => 13.50],
            ['name' => 'Kopi', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 21138, 'price' => 22.50],
            ['name' => 'Marjerin', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 11336, 'price' => 12.00],
            ['name' => 'Tauhu', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 169702, 'price' => 7.50],
            ['name' => 'Teh', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 16510, 'price' => 24.00],
            ['name' => 'Ubi Kentang', 'cat' => 'PERLENGKAPAN', 'uom' => 'kg', 'qty' => 75426, 'price' => 4.50],
            ['name' => 'Asam Jawa', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 3042, 'price' => 11.50],
            ['name' => 'Asam Keping', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 390, 'price' => 28.00],
            ['name' => 'Bawang Besar', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 11700, 'price' => 4.20],
            ['name' => 'Bawang Merah', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 13598, 'price' => 9.50],
            ['name' => 'Bawang Putih', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 21502, 'price' => 9.00],
            ['name' => 'Belacan', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 1534, 'price' => 22.00],
            ['name' => 'Biji Lada Hitam', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 390, 'price' => 45.00],
            ['name' => 'Buah Pelaga', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 2080, 'price' => 130.00],
            ['name' => 'Bunga Cengkih', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 2080, 'price' => 60.00],
            ['name' => 'Bunga Lawang', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 2080, 'price' => 50.00],
            ['name' => 'Cili', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 3796, 'price' => 13.00],
            ['name' => 'Cili Kering', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 6058, 'price' => 26.00],
            ['name' => 'Cili Padi', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 6812, 'price' => 15.00],
            ['name' => 'Cuka', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 390, 'price' => 3.00],
            ['name' => 'Dal', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 3796, 'price' => 7.00],
            ['name' => 'Daun Bawang', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 1144, 'price' => 16.00],
            ['name' => 'Daun Kari', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 572, 'price' => 12.00],
            ['name' => 'Daun Kesum', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 780, 'price' => 12.00],
            ['name' => 'Daun Limau Purut', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 208, 'price' => 18.00],
            ['name' => 'Daun Sup', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 1144, 'price' => 18.00],
            ['name' => 'Garam', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 60346, 'price' => 1.40],
            ['name' => 'Halba', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 390, 'price' => 14.00],
            ['name' => 'Halia', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 7930, 'price' => 7.00],
            ['name' => 'Kiub Tomyam', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 390, 'price' => 36.00],
            ['name' => 'Kulit Kayu Manis', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 2080, 'price' => 42.00],
            ['name' => 'Limau Kasturi', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 3796, 'price' => 7.50],
            ['name' => 'Rempah Kari', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 2288, 'price' => 19.00],
            ['name' => 'Rempah Kurma', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 3796, 'price' => 19.00],
            ['name' => 'Rempah Sup', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 3796, 'price' => 19.00],
            ['name' => 'Serai', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 3042, 'price' => 4.50],
            ['name' => 'Serbuk Cili', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 390, 'price' => 24.00],
            ['name' => 'Serbuk Kunyit', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 6422, 'price' => 22.00],
            ['name' => 'Serbuk Lada Sulah', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 390, 'price' => 50.00],
            ['name' => 'Serbuk Santan', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 13598, 'price' => 30.00],
            ['name' => 'Suun', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 390, 'price' => 16.00],
            ['name' => 'Taucu', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 390, 'price' => 8.50],
            ['name' => 'Telur Asin', 'cat' => 'PERENCAH', 'uom' => 'Biji', 'qty' => 94276, 'price' => 1.80],
            ['name' => 'Kangkung', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 0, 'price' => 0.00],
            ['name' => 'Taugeh', 'cat' => 'SAYUR', 'uom' => 'kg', 'qty' => 0, 'price' => 0.00],
            ['name' => 'Kicap Cair', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 0, 'price' => 0.00],
            ['name' => 'Kicap Pekat', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 0, 'price' => 0.00],
            ['name' => 'Sos Cili', 'cat' => 'PERENCAH', 'uom' => 'kg', 'qty' => 0, 'price' => 0.00],
        ];

        foreach ($data as $row) {
            $cat = Category::firstOrCreate([
                'name' => $row['cat']
            ]);

            $uom = Uom::firstOrCreate([
                'code' => $row['uom']
            ], [
                'description' => $row['uom'],
                'created_by' => 1
            ]);

            Item::create([
                'name' => $row['name'],
                'category_id' => $cat->id,
                'uom_id' => $uom->id,
                'price_per_unit' => $row['price'],
                'current_quantity' => $row['qty'],
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
