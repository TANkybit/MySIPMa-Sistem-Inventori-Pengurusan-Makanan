<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Institution;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        $query = trim($request->input('q', ''));
        
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [
            'items' => [],
            'suppliers' => [],
            'orders' => [],
            'institutions' => [],
        ];

        $context = $request->input('context');
        $filterId = $request->input('filter_id');

        // If context is specific but no filter ID is provided, return empty to prevent data leak
        if (in_array($context, ['institusi', 'negeri'], true) && empty($filterId)) {
            return response()->json(['results' => $results]);
        }

        $itemsQuery = Item::with('uom')->where('name', 'like', "%{$query}%");
        $suppliersQuery = Supplier::where(function($q) use ($query) {
            $q->where('company_name', 'like', "%{$query}%")
              ->orWhere('contact_person', 'like', "%{$query}%");
        });
        $ordersQuery = Order::where('order_no', 'like', "%{$query}%");
        $institutionsQuery = Institution::where('name', 'like', "%{$query}%");

        if ($context === 'institusi' && $filterId) {
            // Scope to specific Institution
            $ordersQuery->where('institution_id', $filterId);
            
            $suppliersQuery->where(function ($q) use ($filterId) {
                $q->whereExists(function ($subQ) use ($filterId) {
                    $subQ->select(\Illuminate\Support\Facades\DB::raw(1))
                      ->from('orders')
                      ->whereColumn('orders.supplier_id', 'suppliers.id')
                      ->where('orders.institution_id', $filterId);
                })->orWhereExists(function ($subQ) use ($filterId) {
                    $subQ->select(\Illuminate\Support\Facades\DB::raw(1))
                      ->from('contracts')
                      ->whereColumn('contracts.supplier_id', 'suppliers.id')
                      ->where('contracts.institution_id', $filterId);
                });
            });
            
            $itemsQuery->whereExists(function ($q) use ($filterId) {
                $q->select(\Illuminate\Support\Facades\DB::raw(1))
                  ->from('order_items')
                  ->join('orders', 'orders.id', '=', 'order_items.order_id')
                  ->whereColumn('order_items.item_id', 'items.id')
                  ->where('orders.institution_id', $filterId);
            });
            
            $institutionsQuery->where('id', $filterId);
            
        } elseif ($context === 'negeri' && $filterId) {
            // Scope to State
            $instIds = Institution::where('state_id', $filterId)->pluck('id');
            
            $ordersQuery->whereIn('institution_id', $instIds);
            
            $suppliersQuery->where(function ($q) use ($instIds) {
                $q->whereExists(function ($subQ) use ($instIds) {
                    $subQ->select(\Illuminate\Support\Facades\DB::raw(1))
                      ->from('orders')
                      ->whereColumn('orders.supplier_id', 'suppliers.id')
                      ->whereIn('orders.institution_id', $instIds);
                })->orWhereExists(function ($subQ) use ($instIds) {
                    $subQ->select(\Illuminate\Support\Facades\DB::raw(1))
                      ->from('contracts')
                      ->whereColumn('contracts.supplier_id', 'suppliers.id')
                      ->whereIn('contracts.institution_id', $instIds);
                });
            });
            
            $itemsQuery->whereExists(function ($q) use ($instIds) {
                $q->select(\Illuminate\Support\Facades\DB::raw(1))
                  ->from('order_items')
                  ->join('orders', 'orders.id', '=', 'order_items.order_id')
                  ->whereColumn('order_items.item_id', 'items.id')
                  ->whereIn('orders.institution_id', $instIds);
            });
            
            $institutionsQuery->where('state_id', $filterId);
        }

        $items = $itemsQuery->limit(5)->get();
        foreach ($items as $item) {
            $results['items'][] = [
                'id' => $item->id,
                'title' => $item->name,
                'subtitle' => 'Harga: RM ' . number_format($item->price_per_unit, 2),
                'search_term' => $item->name,
            ];
        }

        $suppliers = $suppliersQuery->limit(5)->get();
        foreach ($suppliers as $supplier) {
            $results['suppliers'][] = [
                'id' => $supplier->id,
                'title' => $supplier->company_name,
                'subtitle' => 'PIC: ' . $supplier->contact_person,
                'search_term' => $supplier->company_name,
            ];
        }

        $orders = $ordersQuery->limit(5)->get();
        foreach ($orders as $order) {
            $results['orders'][] = [
                'id' => $order->id,
                'title' => 'Pesanan: ' . $order->order_no,
                'subtitle' => 'Status: ' . $order->status . ' - ' . \Carbon\Carbon::parse($order->order_date)->format('d/m/Y'),
                'search_term' => $order->order_no,
            ];
        }

        $institutions = $institutionsQuery->limit(5)->get();
        foreach ($institutions as $institution) {
            $results['institutions'][] = [
                'id' => $institution->id,
                'title' => $institution->name,
                'subtitle' => 'Jenis: ' . $institution->type,
                'search_term' => $institution->name,
            ];
        }

        return response()->json(['results' => $results]);
    }
}
