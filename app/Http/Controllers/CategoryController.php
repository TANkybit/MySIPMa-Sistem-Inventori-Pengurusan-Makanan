<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('items')
            ->orderBy('name')
            ->get()
            ->filter(fn ($cat) => $this->isFoodCategory($cat->name))
            ->values();

        return response()->json([
            'success' => true,
            'data' => $categories->map(function($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'totalItems' => $cat->items_count,
                ];
            })
        ]);
    }

    private function isFoodCategory(?string $name): bool
    {
        $name = strtolower((string) $name);

        foreach (['peralatan', 'pakaian', 'pejabat', 'ubat', 'kebersihan', 'seragam', 'banduan', 'dapur'] as $nonFoodKeyword) {
            if (str_contains($name, $nonFoodKeyword)) {
                return false;
            }
        }

        return true;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $category = Category::create([
                'name' => $validated['name'],
                'created_by' => auth()->id() ?? 1,
                'updated_by' => auth()->id() ?? 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berjaya ditambah.',
                'category' => $category
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error adding category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah kategori: ' . $e->getMessage()
            ], 500);
        }
    }
}
