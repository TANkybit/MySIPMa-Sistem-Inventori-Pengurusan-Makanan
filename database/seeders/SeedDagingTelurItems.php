<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Category;
use App\Models\Uom;

class SeedDagingTelurItems extends Seeder
{
    /**
     * Add more items to DAGING & TELUR AYAM categories and
     * link them to institution-2 contracts via contract_items.
     */
    public function run(): void
    {
        $contractIds = DB::table('contracts')
            ->where('institution_id', 2)
            ->where('status', 'Active')
            ->pluck('id')
            ->toArray();

        if (empty($contractIds)) {
            $this->command?->warn('Tiada kontrak aktif untuk institusi 2.');
            return;
        }

        $categoryId = Category::where('name', 'DAGING')->value('id') ?? 1;
        $telurCatId = Category::where('name', 'TELUR AYAM')->value('id') ?? 10;
        $kgId = Uom::where('code', 'kg')->value('id') ?? 1;
        $bijiId = Uom::where('code', 'Biji')->value('id') ?? 2;

        $newItems = [
            ['name' => 'Daging Ayam',            'category_id' => $categoryId, 'uom_id' => $kgId,   'price' => 12.50, 'est_qty' => 2000],
            ['name' => 'Daging Kambing',         'category_id' => $categoryId, 'uom_id' => $kgId,   'price' => 30.00, 'est_qty' => 800],
            ['name' => 'Daging Kerbau Segar',    'category_id' => $categoryId, 'uom_id' => $kgId,   'price' => 25.00, 'est_qty' => 1200],
            ['name' => 'Telur Ayam Gred A',      'category_id' => $telurCatId, 'uom_id' => $bijiId, 'price' => 0.65,  'est_qty' => 600000],
            ['name' => 'Telur Ayam Gred C',      'category_id' => $telurCatId, 'uom_id' => $bijiId, 'price' => 0.55,  'est_qty' => 500000],
            ['name' => 'Telur Itik',             'category_id' => $telurCatId, 'uom_id' => $bijiId, 'price' => 1.00,  'est_qty' => 200000],
        ];

        foreach ($newItems as $row) {
            // Reuse if an item with this name already exists (idempotent re-run)
            $item = Item::where('name', $row['name'])->first();
            if (!$item) {
                $item = Item::create([
                    'category_id' => $row['category_id'],
                    'uom_id' => $row['uom_id'],
                    'name' => $row['name'],
                    'price_per_unit' => $row['price'],
                    'current_quantity' => 0,
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }

            // Link to contracts if not already linked
            foreach ($contractIds as $contractId) {
                $exists = DB::table('contract_items')
                    ->where('contract_id', $contractId)
                    ->where('item_id', $item->id)
                    ->exists();
                if (!$exists) {
                    DB::table('contract_items')->insert([
                        'contract_id' => $contractId,
                        'item_id' => $item->id,
                        'uom_id' => $row['uom_id'],
                        'estimated_quantity' => $row['est_qty'],
                        'unit_price' => $row['price'],
                        'is_internally_supplied' => 0,
                        'notes' => 'Ration item',
                        'created_at' => now(),
                        'created_by' => 1,
                        'updated_at' => now(),
                        'updated_by' => 1,
                    ]);
                }
            }
        }
    }
}