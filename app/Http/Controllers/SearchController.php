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

        $itemsQuery = Item::with('uom')->where('name', 'like', "%{$query}%");
        $suppliersQuery = Supplier::where(function($q) use ($query) {
            $q->where('company_name', 'like', "%{$query}%")
              ->orWhere('contact_person', 'like', "%{$query}%");
        });
        $ordersQuery = Order::where('order_no', 'like', "%{$query}%");
        $institutionsQuery = Institution::where('name', 'like', "%{$query}%");

        if ($context === 'institusi' && $filterId) {
            $ordersQuery->where('institution_id', $filterId);
            $suppliersQuery->whereExists(function ($q) use ($filterId) {
                $q->select(\Illuminate\Support\Facades\DB::raw(1))
                  ->from('orders')
                  ->whereColumn('orders.supplier_id', 'suppliers.id')
                  ->where('orders.institution_id', $filterId);
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
            $instIds = Institution::where('state_id', $filterId)->pluck('id');
            $ordersQuery->whereIn('institution_id', $instIds);
            $suppliersQuery->whereExists(function ($q) use ($instIds) {
                $q->select(\Illuminate\Support\Facades\DB::raw(1))
                  ->from('orders')
                  ->whereColumn('orders.supplier_id', 'suppliers.id')
                  ->whereIn('orders.institution_id', $instIds);
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
            ];
        }

        $suppliers = $suppliersQuery->limit(5)->get();
        foreach ($suppliers as $supplier) {
            $results['suppliers'][] = [
                'id' => $supplier->id,
                'title' => $supplier->company_name,
                'subtitle' => 'PIC: ' . $supplier->contact_person,
            ];
        }

        $orders = $ordersQuery->limit(5)->get();
        foreach ($orders as $order) {
            $results['orders'][] = [
                'id' => $order->id,
                'title' => 'Pesanan: ' . $order->order_no,
                'subtitle' => 'Status: ' . $order->status . ' - ' . $order->order_date,
            ];
        }

        $institutions = $institutionsQuery->limit(5)->get();
        foreach ($institutions as $institution) {
            $results['institutions'][] = [
                'id' => $institution->id,
                'title' => $institution->name,
                'subtitle' => 'Jenis: ' . $institution->type,
            ];
        }

        return response()->json(['results' => $results]);
    }
}
