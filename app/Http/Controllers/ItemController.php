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
            'uom_id' => 'required|integer',
            'price_per_unit' => 'required|numeric',
            'status' => 'required|string|in:active,inactive,aktif,tidak aktif',
        ]);

        try {
            $statusVal = in_array(strtolower($validated['status']), ['active', 'aktif', '1']) ? 1 : 0;

            $item = Item::create([
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'current_quantity' => $validated['current_quantity'],
                'uom_id' => $validated['uom_id'],
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

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category_id'      => 'required|integer|exists:categories,id',
            'uom_id'           => 'required|integer|exists:uom,id',
            'status'           => 'required',
        ]);

        try {
            $statusVal = in_array((string) $validated['status'], ['1', 'active', 'aktif']) ? 1 : 0;

            $item->update([
                'name'        => $validated['name'],
                'category_id' => $validated['category_id'],
                'uom_id'      => $validated['uom_id'],
                'status'      => $statusVal,
                'updated_by'  => auth()->id() ?? 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item berjaya dikemaskini.',
                'data' => [
                    'id'          => $item->id,
                    'code'        => $item->code,
                    'name'        => $item->name,
                    'category_id' => $item->category_id,
                    'uom_id'      => $item->uom_id,
                    'status'      => $item->status,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengemaskini item: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Item $item)
    {
        try {
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => 'Item berjaya dipadam.'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memadam kerana item ini sedang digunakan di dalam rekod pesanan atau inventori.'
            ], 400);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi ralat semasa memadam rekod item.'
            ], 500);
        }
    }
}
