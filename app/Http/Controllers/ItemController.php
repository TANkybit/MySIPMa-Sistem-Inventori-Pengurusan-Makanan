<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function search(Request $request)
    {
        $search = trim((string) $request->input('q', ''));

        $items = Item::query()
            ->leftJoin('uom', 'items.uom_id', '=', 'uom.id')
            ->select(['items.id', 'items.name', 'uom.code as uom_code', 'items.price_per_unit'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where('items.name', 'like', "%{$search}%");
            })
            ->orderBy('items.name')
            ->limit(20)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
                'name' => $item->name,
                'uom' => $item->uom_code ?: 'Unit',
                'price_per_unit' => (float) ($item->price_per_unit ?? 0),
            ]);

        return response()->json([
            'results' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'current_quantity' => 'required|numeric',
            'uom' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric',
            'status' => 'required|string|in:active,inactive,aktif,tidak aktif',
        ]);

        try {
            $statusVal = in_array(strtolower($validated['status']), ['active', 'aktif', '1']) ? 1 : 0;
            $uomId = DB::table('uom')->where('code', $validated['uom'])->value('id');

            $item = Item::create([
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'current_quantity' => $validated['current_quantity'],
                'uom_id' => $uomId,
                'price_per_unit' => $validated['price_per_unit'],
                'status' => $statusVal,
                'created_by' => auth()->id() ?? 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item berjaya ditambah.',
                'item' => $item
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah item: ' . $e->getMessage()
            ], 500);
        }
    }
}
