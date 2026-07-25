<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $itemsMissingContracts = DB::table('order_items')
            ->select('order_items.item_id')
            ->whereNotIn('order_items.item_id', function ($q) {
                $q->select('item_id')->from('contract_items');
            })
            ->distinct()
            ->pluck('item_id');

        if ($itemsMissingContracts->isEmpty()) {
            return;
        }

        $contractData = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('order_items.item_id', $itemsMissingContracts)
            ->select(
                'order_items.item_id',
                'orders.contract_id',
                'orders.institution_id',
                'orders.supplier_id',
                DB::raw('SUM(order_items.ordered_quantity) as total_qty'),
                DB::raw('AVG(order_items.unit_price) as avg_price')
            )
            ->whereNotNull('orders.contract_id')
            ->groupBy('order_items.item_id', 'orders.contract_id', 'orders.institution_id', 'orders.supplier_id')
            ->get();

        $now = now();
        $adminId = 1;
        $inserts = [];

        foreach ($contractData as $row) {
            $inserts[] = [
                'contract_id' => $row->contract_id,
                'item_id' => $row->item_id,
                'uom_id' => DB::table('items')->where('id', $row->item_id)->value('uom_id'),
                'estimated_quantity' => max($row->total_qty, 1),
                'unit_price' => $row->avg_price ?? 0,
                'is_internally_supplied' => 0,
                'notes' => 'Auto-created from order history',
                'created_at' => $now,
                'created_by' => $adminId,
                'updated_at' => $now,
                'updated_by' => $adminId,
            ];
        }

        DB::table('contract_items')->insert($inserts);

        echo 'Inserted ' . count($inserts) . ' missing contract_items records.' . PHP_EOL;
    }

    public function down()
    {
        DB::table('contract_items')
            ->where('notes', 'Auto-created from order history')
            ->delete();
    }
};
