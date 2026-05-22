<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function search(Request $request)
    {
        $search = trim((string) $request->input('q', ''));

        $items = Item::query()
            ->select(['id', 'name', 'uom', 'price_per_unit'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->limit(20)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
                'name' => $item->name,
                'uom' => $item->uom ?: 'Unit',
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
            // Map string statuses to numbers if the DB expects it (e.g. 1 for active)
            // But looking at schema, status is integer. Let's assume 1 for active, 0 for inactive.
            $statusVal = in_array(strtolower($validated['status']), ['active', 'aktif', '1']) ? 1 : 0;

            $item = Item::create([
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'current_quantity' => $validated['current_quantity'],
                'uom' => $validated['uom'],
                'price_per_unit' => $validated['price_per_unit'],
                'status' => $statusVal,
                'created_at' => now()->toDateString(),
                'updated_at' => now()->toDateString(),
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
