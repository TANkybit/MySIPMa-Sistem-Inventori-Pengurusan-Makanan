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
                    'code' => $cat->code,
                    'name' => $cat->name,
                    'description' => $cat->description,
                    'totalItems' => $cat->items_count,
                    'status' => $cat->status
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
}
