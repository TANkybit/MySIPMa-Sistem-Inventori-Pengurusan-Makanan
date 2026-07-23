<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Approval;
use App\Models\Institution;
use App\Models\State;
use App\Models\Supplier;
use App\Models\OrderItem;
use App\Models\BorangIndenDraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard with order statistics
     */
    public function userDashboard()
    {
        $instId = Auth::user()->institution_id;
        $statusCounts = Order::where('institution_id', $instId)
            ->selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $pendingApprovals = $this->pendingApprovalCount($instId);
        $pendingPenerimaan = (int) ($statusCounts['In Progress'] ?? 0);

        $contractData = $this->getContractLimitData();
        $contractTrend = $this->getContractMonthlyTrend();
        $predictions = $this->getItemPredictions($instId);

        return view('user_dashboard', [
            'totalOrders' => (int) ($statusCounts['Pending'] ?? 0)
                + (int) ($statusCounts['In Progress'] ?? 0)
                + (int) ($statusCounts['Completed'] ?? 0)
                + (int) ($statusCounts['Draft'] ?? 0)
                + (int) ($statusCounts['Cancelled'] ?? 0)
                + (int) ($statusCounts['Rejected'] ?? 0),
            'pendingApprovals' => $pendingApprovals,
            'pendingPenerimaan' => $pendingPenerimaan,
            'inProgressOrders' => $pendingPenerimaan,
            'completedOrders' => (int) ($statusCounts['Completed'] ?? 0),
            'contractData' => $contractData,
            'contractTrend' => $contractTrend,
            'predictions' => $predictions,
        ]);
    }

    public function pengarahHQDashboard()
    {
        $landingRouteName = Auth::user()?->landingRouteName();

        if (in_array($landingRouteName, ['pengarah.institusi.dashboard', 'pengarah.negeri.dashboard'], true)) {
            return redirect()->route($landingRouteName);
        }

        $institutions = Institution::orderBy('name')->get();
        $uoms = \App\Models\Uom::orderBy('code')->get();
        
        $totalSuppliers = \App\Models\Supplier::count();
        $totalInstitutions = Institution::count();
        $totalItems = \App\Models\Item::count();
        $pendingApprovals = $this->pendingApprovalCount();

        $rawMaterials = \App\Models\Item::leftJoin('categories', 'items.category_id', '=', 'categories.id')
            ->leftJoin('ceiling_limits', 'items.ceiling_limit_id', '=', 'ceiling_limits.id')
            ->leftJoin('uom', 'items.uom_id', '=', 'uom.id')
            ->select(
                'items.*',
                'categories.name as categoryName',
                'uom.code as uomCode',
                'ceiling_limits.monthly_limit',
                'ceiling_limits.yearly_limit',
                'ceiling_limits.contract_limit'
            )
            ->get()->map(function($item) {
                $stock = (float) ($item->current_quantity ?? 0);
                $min = $this->configuredMinimumStock($item) ?? max(1, $stock * 0.2);
                
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'category' => $item->categoryName ?? 'Tiada',
                    'stock' => $stock,
                    'unit' => $item->uomCode ?? 'Unit',
                    'minStock' => (float)$min,
                    'price' => (float)$item->price_per_unit,
                    'status' => $item->status ? 'aktif' : 'tidak aktif',
                    'description' => '',
                    'lastUpdated' => date('Y-m-d')
                ];
            });

        $lowStockItems = $this->lowStockItems();
        $lowStockCount = $lowStockItems->count();

        return view('admin_dashboard', compact('institutions', 'uoms', 'totalSuppliers', 'totalInstitutions', 'totalItems', 'pendingApprovals', 'rawMaterials', 'lowStockItems', 'lowStockCount'));
    }

    /**
     * API: Return filtered inden (orders) list for Pengarah HQ dashboard Inden page.
     */
    public function apiHqInden(Request $request)
    {
        $query = Order::query()
            ->leftJoin('institutions', 'orders.institution_id', '=', 'institutions.id')
            ->leftJoin('suppliers', 'orders.supplier_id', '=', 'suppliers.id')
            ->leftJoin('approvals', 'orders.id', '=', 'approvals.order_id')
            ->select([
                'orders.id',
                'orders.order_no',
                'orders.order_date',
                'orders.total_amount',
                'orders.status as order_status',
                'institutions.name as institution_name',
                'suppliers.company_name as supplier_name',
                DB::raw('COALESCE(approvals.status, 0) as approval_status'),
            ])
            ->orderByDesc('orders.order_date')
            ->orderByDesc('orders.id');

        // Filter: institusi
        if ($request->filled('institution_id')) {
            $query->where('orders.institution_id', $request->input('institution_id'));
        }

        // Filter: status
        if ($request->filled('status')) {
            $query->where('orders.status', $request->input('status'));
        }

        // Filter: tarikh dari
        if ($request->filled('date_from')) {
            $query->whereDate('orders.order_date', '>=', $request->input('date_from'));
        }

        // Filter: tarikh hingga
        if ($request->filled('date_to')) {
            $query->whereDate('orders.order_date', '<=', $request->input('date_to'));
        }

        $orders = $query->get();

        // Calculate stats
        $stats = [
            'total'        => $orders->count(),
            'pending'      => $orders->where('order_status', 'Pending')->count(),
            'completed'    => $orders->where('order_status', 'Completed')->count(),
            'total_amount' => $orders->sum('total_amount'),
        ];

        return response()->json([
            'orders' => $orders->values(),
            'stats'  => $stats,
        ]);
    }

    public function pengarahInstitusiDashboard(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'dashboard');
    }

    /**
     * API: Return dashboard data for Pengarah Institusi (filterable by year and month)
     */
    public function apiPengarahInstitusiDashboard(Request $request)
    {
        $selectedInstitutionId = Auth::user()->institution_id;
        if (!$selectedInstitutionId) {
            return response()->json(['success' => false, 'message' => 'No institution assigned'], 400);
        }

        $queryOrders = Order::where('institution_id', $selectedInstitutionId);

        if ($request->filled('year')) {
            $year = intval($request->input('year'));
            $queryOrders->whereYear('order_date', $year);
        }

        if ($request->filled('month')) {
            $month = intval($request->input('month'));
            if ($month >=1 && $month <= 12) {
                $queryOrders->whereMonth('order_date', $month);
            }
        }

        // Order Status Breakdown
        $statusCounts = (clone $queryOrders)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $dashboardData['order_status'] = [
            'Pending' => $statusCounts['Pending'] ?? 0,
            'In Progress' => $statusCounts['In Progress'] ?? 0,
            'Completed' => $statusCounts['Completed'] ?? 0,
            'Rejected' => $statusCounts['Rejected'] ?? 0,
        ];

        // Top 5 Items Ordered
        $topItemsQuery = OrderItem::select('items.name', 'uom.code as uom_code', DB::raw('SUM(ordered_quantity) as total_quantity'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->leftJoin('uom', 'items.uom_id', '=', 'uom.id')
            ->where('orders.institution_id', $selectedInstitutionId);

        if ($request->filled('year')) {
            $year = intval($request->input('year'));
            $topItemsQuery->whereYear('orders.order_date', $year);
        }

        if ($request->filled('month')) {
            $month = intval($request->input('month'));
            if ($month >=1 && $month <= 12) {
                $topItemsQuery->whereMonth('orders.order_date', $month);
            }
        }

        $topItems = $topItemsQuery->groupBy('items.id', 'items.name', 'uom.code')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $dashboardData['top_items'] = [
            'labels' => $topItems->pluck('name')->toArray(),
            'data' => $topItems->pluck('total_quantity')->toArray(),
            'uoms' => $topItems->pluck('uom_code')->toArray(),
        ];

        return response()->json(['success' => true, 'data' => $dashboardData]);
    }

    /**
     * API: Return 5 most recent orders for Pengarah Institusi (filterable by year and month)
     */
    public function apiPengarahInstitusiRecentOrders(Request $request)
    {
        $selectedInstitutionId = Auth::user()->institution_id;
        if (!$selectedInstitutionId) {
            return response()->json(['success' => false, 'message' => 'No institution assigned'], 400);
        }

        $query = Order::with('supplier')
            ->where('institution_id', $selectedInstitutionId)
            ->orderByDesc('order_date')
            ->orderByDesc('id');

        if ($request->filled('year')) {
            $year = intval($request->input('year'));
            $query->whereYear('order_date', $year);
        }

        if ($request->filled('month')) {
            $month = intval($request->input('month'));
            if ($month >= 1 && $month <= 12) $query->whereMonth('order_date', $month);
        }

        $orders = $query->limit(5)->get()->map(function ($o) {
            $statusMalay = match($o->status) {
                'Pending' => 'Menunggu',
                'In Progress' => 'Dalam Proses',
                'Completed' => 'Selesai',
                'Rejected' => 'Ditolak',
                default => $o->status,
            };

            return [
                'id' => $o->id,
                'order_no' => $o->order_no,
                'order_date' => $o->order_date,
                'total_amount' => (float) $o->total_amount,
                'status' => $o->status,
                'status_malay' => $statusMalay,
                'supplier' => $o->supplier?->company_name,
            ];
        });

        return response()->json(['success' => true, 'data' => $orders]);
    }

    public function pengarahInstitusiInstitusi(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'institusi');
    }

    public function pengarahInstitusiPembekal(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'pembekal');
    }

    public function pengarahInstitusiRingkasanPesanan(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'ringkasan');
    }

    public function pengarahInstitusiSenaraiUser(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'senarai_user');
    }

    public function pengarahInstitusiProfil(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'profil');
    }

    public function pengarahInstitusiLaporanPrestasi(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'laporan-prestasi');
    }

    public function adminInstitusiDashboard(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'dashboard', 'admin_institusi_dashboard');
    }

    public function adminInstitusiRingkasanPesanan(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'ringkasan', 'admin_institusi_dashboard');
    }

    public function adminInstitusiInstitusi(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'institusi', 'admin_institusi_dashboard');
    }

    public function adminInstitusiPembekal(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'pembekal', 'admin_institusi_dashboard');
    }

    public function adminInstitusiSenaraiUser(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'senarai_user', 'admin_institusi_dashboard');
    }

    public function adminInstitusiProfil(Request $request)
    {
        return $this->pengarahInstitusiView($request, 'profil', 'admin_institusi_dashboard');
    }

    private function pengarahInstitusiView(Request $request, string $activePage, string $viewName = 'pengarah_institusi_dashboard')
    {
        $selectedInstitutionId = Auth::user()->institution_id;
        $selectedInstitution = Institution::find($selectedInstitutionId);
        
        // This is no longer used for filtering since it's hardcoded to user's institution, 
        // but we pass it down for compatibility or future use.
        $institutions = Institution::where('id', $selectedInstitutionId)->get(); 

        $orders = collect();
        $inventoryItems = collect();
        $suppliers = collect();
        $users = collect();
        $roles = collect();
        $positions = collect();
        $dashboardData = [];

        if ($selectedInstitution) {
            if (in_array($activePage, ['dashboard', 'ringkasan'])) {
                $orders = Order::with(['supplier'])
                    ->where('institution_id', $selectedInstitution->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }

            if (in_array($activePage, ['dashboard', 'institusi', 'ringkasan'])) {
                $inventoryQuery = OrderItem::select('item_id', DB::raw('SUM(ordered_quantity) as total_ordered_quantity'), DB::raw('SUM(ordered_total_price) as total_ordered_price'))
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.institution_id', $selectedInstitution->id);

                // Apply optional year/month filters from query string
                if ($request->filled('year')) {
                    $year = intval($request->input('year'));
                    $inventoryQuery->whereYear('orders.order_date', $year);
                }
                if ($request->filled('month')) {
                    $month = intval($request->input('month'));
                    if ($month >= 1 && $month <= 12) {
                        $inventoryQuery->whereMonth('orders.order_date', $month);
                    }
                }

                $inventoryItems = $inventoryQuery->groupBy('item_id')
                    ->with('item')
                    ->get();
            }

            if ($activePage === 'pembekal') {
                $suppliers = Supplier::with(['state','createdBy'])
                    ->where(function($q) use ($selectedInstitution) {
                        $q->whereExists(function ($query) use ($selectedInstitution) {
                            $query->select(DB::raw(1))
                                  ->from('orders')
                                  ->whereColumn('orders.supplier_id', 'suppliers.id')
                                  ->where('orders.institution_id', $selectedInstitution->id);
                        })
                        ->orWhereExists(function ($query) use ($selectedInstitution) {
                            $query->select(DB::raw(1))
                                  ->from('contracts')
                                  ->whereColumn('contracts.supplier_id', 'suppliers.id')
                                  ->where('contracts.institution_id', $selectedInstitution->id);
                        });
                    })
                    ->orderBy('company_name')
                    ->get();
            }
            
            if ($activePage === 'senarai_user') {
                $users = \App\Models\User::with(['role', 'position'])
                    ->where('institution_id', $selectedInstitution->id)
                    ->orderBy('name')
                    ->get();
                $roles = \App\Models\Role::orderBy('id')->get();
                $positions = \App\Models\Position::orderBy('id')->get();
            }

            if ($activePage === 'dashboard') {
                // Prepare data for Chart.js
                // 1. Order Status Breakdown
                $statusCounts = Order::where('institution_id', $selectedInstitution->id)
                    ->select('status', DB::raw('count(*) as count'))
                    ->groupBy('status')
                    ->pluck('count', 'status')->toArray();
                
                $dashboardData['order_status'] = [
                    'Pending' => $statusCounts['Pending'] ?? 0,
                    'In Progress' => $statusCounts['In Progress'] ?? 0,
                    'Completed' => $statusCounts['Completed'] ?? 0,
                    'Rejected' => $statusCounts['Rejected'] ?? 0,
                ];

                // 2. Top 5 Items Ordered (Highest Quantity)
                $topItems = OrderItem::select('items.name', 'uom.code as uom_code', DB::raw('SUM(ordered_quantity) as total_quantity'))
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->join('items', 'order_items.item_id', '=', 'items.id')
                    ->leftJoin('uom', 'items.uom_id', '=', 'uom.id')
                    ->where('orders.institution_id', $selectedInstitution->id)
                    ->groupBy('items.id', 'items.name', 'uom.code')
                    ->orderByDesc('total_quantity')
                    ->limit(5)
                    ->get();
                $dashboardData['top_items'] = [
                    'labels' => $topItems->pluck('name')->toArray(),
                    'data' => $topItems->pluck('total_quantity')->toArray(),
                    'uoms' => $topItems->pluck('uom_code')->toArray(),
                ];
            }
        }
        $pendingEvaluations = collect();
        if ($selectedInstitution) {
            $pendingEvaluations = \App\Models\SupplierEvaluation::with(['supplier', 'order'])
                ->where('institution_id', $selectedInstitution->id)
                ->where('status', 'Pending')
                ->get();
        }

        return view($viewName, [
            'activePage' => $activePage,
            'institutions' => $institutions,
            'selectedInstitution' => $selectedInstitution,
            'orders' => $orders,
            'inventoryItems' => $inventoryItems,
            'suppliers' => $suppliers,
            'users' => $users,
            'roles' => $roles,
            'positions' => $positions,
            'pendingEvaluations' => $pendingEvaluations,
            'dashboardData' => json_encode($dashboardData),
            'lowStockItems' => $this->lowStockItems(),
            'inventoryTotals' => [
                'total_quantity' => $inventoryItems->sum('total_ordered_quantity'),
                'total_value' => $inventoryItems->sum('total_ordered_price'),
            ],
        ]);
    }

    public function pengarahNegeriDashboard(Request $request)
    {
        return $this->pengarahNegeriView($request, 'dashboard');
    }

    public function pengarahNegeriInventori(Request $request)
    {
        return $this->pengarahNegeriView($request, 'inventori');
    }

    public function pengarahNegeriProfil(Request $request)
    {
        return $this->pengarahNegeriView($request, 'profil');
    }

    public function pengarahNegeriLaporanPrestasi(Request $request)
    {
        return $this->pengarahNegeriView($request, 'laporan-prestasi');
    }

    public function pengarahNegeriRingkasanPesanan(Request $request)
    {
        return $this->pengarahNegeriView($request, 'ringkasan');
    }

    private function pengarahNegeriView(Request $request, string $activePage)
    {
        // 1. Detect state from login
        $userStateId = Auth::user()?->institution?->state_id;
        $selectedState = $userStateId ? State::find($userStateId) : null;

        // 2. Institutions in that state
        $institutions = collect();
        if ($selectedState) {
            $institutions = Institution::where('state_id', $selectedState->id)->orderBy('name')->get();
        }

        // 3. User's choice of Institution
        $selectedInstitutionId = $request->query('institution_id');

        $institutionIds = collect();
        $orders = collect();
        $inventoryItems = collect();
        $suppliers = collect();
        $dashboardData = [];

        if ($selectedState) {
            // Filter by selected institution or all in state
            if ($selectedInstitutionId) {
                $institutionIds = collect([$selectedInstitutionId]);
            } else {
                $institutionIds = $institutions->pluck('id');
            }

            $hasYear = $request->filled('year');
            $year = $hasYear ? intval($request->input('year')) : null;
            $hasMonth = $request->filled('month');
            $month = $hasMonth ? intval($request->input('month')) : null;

            if (in_array($activePage, ['dashboard', 'ringkasan'])) {
                $ordersQuery = Order::with(['institution', 'supplier'])
                    ->whereIn('institution_id', $institutionIds);
                    
                if ($hasYear) {
                    $ordersQuery->whereYear('order_date', $year);
                }
                if ($hasMonth && $month >= 1 && $month <= 12) {
                    $ordersQuery->whereMonth('order_date', $month);
                }
                
                $orders = $ordersQuery->orderBy('created_at', 'desc')->get();
            }

            if (in_array($activePage, ['dashboard', 'inventori', 'ringkasan'])) {
                $inventoryQuery = OrderItem::select('item_id', DB::raw('SUM(ordered_quantity) as total_ordered_quantity'), DB::raw('SUM(ordered_total_price) as total_ordered_price'))
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->whereIn('orders.institution_id', $institutionIds);

                // Apply optional year/month filters from query string
                if ($hasYear) {
                    $inventoryQuery->whereYear('orders.order_date', $year);
                }
                if ($hasMonth && $month >= 1 && $month <= 12) {
                    $inventoryQuery->whereMonth('orders.order_date', $month);
                }

                $inventoryItems = $inventoryQuery->groupBy('item_id')
                    ->with('item')
                    ->get();
            }

            if (in_array($activePage, ['dashboard', 'pembekal'])) {
                $suppliers = Supplier::with(['state','createdBy'])
                    ->where(function($q) use ($institutionIds) {
                        $q->whereExists(function ($query) use ($institutionIds) {
                            $query->select(DB::raw(1))
                                  ->from('orders')
                                  ->whereColumn('orders.supplier_id', 'suppliers.id')
                                  ->whereIn('orders.institution_id', $institutionIds);
                        })
                        ->orWhereExists(function ($query) use ($institutionIds) {
                            $query->select(DB::raw(1))
                                  ->from('contracts')
                                  ->whereColumn('contracts.supplier_id', 'suppliers.id')
                                  ->whereIn('contracts.institution_id', $institutionIds);
                        });
                    })
                    ->orderBy('company_name')
                    ->get();
            }

            if ($activePage === 'dashboard') {
                // 1. Order Status Breakdown
                $statusQuery = Order::whereIn('institution_id', $institutionIds);
                if ($hasYear) $statusQuery->whereYear('order_date', $year);
                if ($hasMonth && $month >= 1 && $month <= 12) $statusQuery->whereMonth('order_date', $month);
                
                $statusCounts = $statusQuery->select('status', DB::raw('count(*) as count'))
                    ->groupBy('status')
                    ->pluck('count', 'status')->toArray();
                
                $dashboardData['order_status'] = [
                    'Menunggu' => $statusCounts['Pending'] ?? 0,
                    'Sedang Diproses' => $statusCounts['In Progress'] ?? 0,
                    'Selesai' => $statusCounts['Completed'] ?? 0,
                    'Ditolak' => $statusCounts['Rejected'] ?? 0,
                ];

                // 2. Top 5 Items Ordered (Highest Quantity)
                $topItemsQuery = OrderItem::select('items.name', 'uom.code as uom_code', DB::raw('SUM(ordered_quantity) as total_quantity'))
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->join('items', 'order_items.item_id', '=', 'items.id')
                    ->leftJoin('uom', 'items.uom_id', '=', 'uom.id')
                    ->whereIn('orders.institution_id', $institutionIds);
                    
                if ($hasYear) $topItemsQuery->whereYear('orders.order_date', $year);
                if ($hasMonth && $month >= 1 && $month <= 12) $topItemsQuery->whereMonth('orders.order_date', $month);
                
                $topItems = $topItemsQuery->groupBy('items.id', 'items.name', 'uom.code')
                    ->orderByDesc('total_quantity')
                    ->limit(5)
                    ->get();
                
                $dashboardData['top_items'] = [
                    'labels' => $topItems->pluck('name')->toArray(),
                    'data' => $topItems->pluck('total_quantity')->toArray(),
                    'uoms' => $topItems->pluck('uom_code')->toArray(),
                ];
            }
        }

        return view('pengarah_negeri_dashboard', [
            'activePage' => $activePage,
            'selectedState' => $selectedState,
            'institutions' => $institutions,
            'selectedInstitutionId' => $selectedInstitutionId,
            'orders' => $orders,
            'inventoryItems' => $inventoryItems,
            'suppliers' => $suppliers,
            'dashboardData' => json_encode($dashboardData),
            'lowStockItems' => $this->lowStockItems(),
            'inventoryTotals' => [
                'total_quantity' => $inventoryItems->sum('total_ordered_quantity'),
                'total_value' => $inventoryItems->sum('total_ordered_price'),
            ],
        ]);
    }

    public function senaraiInden()
    {
        $instId = Auth::user()->institution_id;
        $query = $this->ordersWithDetails($instId);
        $pendingPenerimaan = Order::where('status', 'In Progress')->where('institution_id', $instId)->count();

        return view('senarai_inden', [
            'orders' => $query->get(),
            'pendingApprovals' => $this->pendingApprovalCount($instId),
            'pendingPenerimaan' => $pendingPenerimaan,
        ]);
    }

    public function userPenilaianPrestasi()
    {
        $instId = Auth::user()->institution_id;
        $pendingApprovals = $this->pendingApprovalCount($instId);
        $pendingPenerimaan = Order::where('status', 'In Progress')->where('institution_id', $instId)->count();

        return view('user_penilaian_prestasi', [
            'pendingApprovals' => $pendingApprovals,
            'pendingPenerimaan' => $pendingPenerimaan,
        ]);
    }

    public function pengesahanInden()
    {
        $instId = Auth::user()->institution_id;
        $query = $this->ordersWithDetails($instId)
            ->where('orders.status', 'Pending');
        $pendingPenerimaan = Order::where('status', 'In Progress')->where('institution_id', $instId)->count();

        return view('pengesahan_inden', [
            'pendingOrders' => $query->get(),
            'pendingApprovals' => $this->pendingApprovalCount($instId),
            'pendingPenerimaan' => $pendingPenerimaan,
        ]);
    }

    public function borangInden()
    {
        $draft = \App\Models\BorangIndenDraft::where('user_id', Auth::id())->first();
        $view = $this->borangIndenView(null, false);
        return $view->with('savedDraft', $draft ? $draft->data : null);
    }

    public function generateOrderNo(Request $request)
    {
        $institutionId = $request->input('institution_id');
        $categoryCode = 'BK';

        try {
            $institution = DB::table('institutions')->where('id', $institutionId)->first(['code', 'location_code']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => '[Maklumat Pesanan] Ralat pada pangkalan data institusi. Sila pastikan lajur "code" wujud pada jadual institutions.']);
        }
        if (!$institution || !$institution->code) {
            return response()->json(['success' => false, 'message' => '[Maklumat Pesanan] Kod institusi tidak dijumpai. Sila hubungi pentadbir.']);
        }

        $instCode = $institution->code;
        $locCode = $institution->location_code ?: $instCode;
        $year = now()->format('y');
        $month = now()->format('m');

        $seq = DB::table('order_sequences')
            ->where('institution_code', $instCode)
            ->where('category_code', $categoryCode)
            ->where('year', (int) now()->format('Y'))
            ->where('month', (int) now()->format('m'))
            ->lockForUpdate()
            ->first();

        $nextSeq = $seq ? $seq->sequence_no + 1 : 1;
        $orderNo = sprintf('%s/%s/%s/%s/%s/%03d', $instCode, $locCode, $categoryCode, $year, $month, $nextSeq);

        return response()->json([
            'success' => true,
            'order_no' => $orderNo,
        ]);
    }

    public function getContractsByInstitution(Request $request)
    {
        $institutionId = $request->input('institution_id');
        $supplierId = $request->input('supplier_id');
        $query = DB::table('contracts')
            ->where('institution_id', $institutionId)
            ->where('status', 'Active');
        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }
        $contracts = $query->select('id', 'contract_no', 'supplier_id')->get();
        return response()->json($contracts);
    }

    public function getContractItems($contractId)
    {
        // Get ceiling for this contract
        $ceiling = DB::table('ceiling_limits')
            ->where('contract_id', $contractId)
            ->selectRaw('contract_limit - used_quantity as remaining')
            ->first();

        $items = DB::table('contract_items as ci')
            ->join('items as i', 'ci.item_id', '=', 'i.id')
            ->leftJoin('uom as u', 'ci.uom_id', '=', 'u.id')
            ->leftJoin('ceiling_limits as cl', 'i.ceiling_limit_id', '=', 'cl.id')
            ->where('ci.contract_id', $contractId)
            ->select(
                'ci.id',
                'ci.item_id',
                'i.ceiling_limit_id',
                'i.name as item_name',
                'u.code as uom_code',
                'ci.unit_price',
                'ci.estimated_quantity',
                'cl.contract_limit',
                'cl.used_quantity'
            )
            ->get();

        $contractItemIds = $items->pluck('id')->toArray();
        $orderedQty = collect();
        if (!empty($contractItemIds)) {
            $orderedQty = DB::table('order_items as oi')
                ->join('orders as o', 'oi.order_id', '=', 'o.id')
                ->whereIn('oi.contract_item_id', $contractItemIds)
                ->whereNotIn('o.status', ['Cancelled', 'Rejected', 'Draft'])
                ->select('oi.contract_item_id', DB::raw('SUM(oi.ordered_quantity) as total_ordered'))
                ->groupBy('oi.contract_item_id')
                ->get()
                ->keyBy('contract_item_id');
        }

        $items = $items->map(function ($item) use ($orderedQty) {
            $estQty = (float) ($item->estimated_quantity ?? 0);
            $ordered = (float) ($orderedQty->get($item->id)->total_ordered ?? 0);
            return [
                'id' => $item->id,
                'item_id' => $item->item_id,
                'item_name' => $item->item_name,
                'uom_code' => $item->uom_code,
                'unit_price' => (float) ($item->unit_price ?? 0),
                'estimated_quantity' => $estQty,
                'ordered_quantity' => $ordered,
                'ceiling_limit_id' => $item->ceiling_limit_id,
                'ceiling_group_remaining' => $item->contract_limit !== null
                    ? (float) max(0, $item->contract_limit - ($item->used_quantity ?? 0))
                    : null,
            ];
        });

        return response()->json([
            'items' => $items,
            'ceiling_remaining' => $ceiling ? (float) max(0, $ceiling->remaining) : null,
        ]);
    }

    public function lihatBorangInden(Order $order)
    {
        return $this->borangIndenView($order, true);
    }

    public function editBorangInden(Order $order)
    {
        $readOnly = $order->status !== 'Pending';
        return $this->borangIndenView($order, $readOnly);
    }

    public function cetakIndenPdf(Order $order)
    {
        $rows = DB::table('orders as o')
            ->leftJoin('contracts as c', 'o.contract_id', '=', 'c.id')
            ->leftJoin('institutions as i', 'o.institution_id', '=', 'i.id')
            ->leftJoin('suppliers as s', 'o.supplier_id', '=', 's.id')
            ->leftJoin('deliveries as d', 'o.id', '=', 'd.order_id')
            ->leftJoin('order_items as oi', 'o.id', '=', 'oi.order_id')
            ->leftJoin('items as it', 'oi.item_id', '=', 'it.id')
            ->leftJoin('contract_items as ci', 'oi.contract_item_id', '=', 'ci.id')
            ->leftJoin('users as u', 'o.created_by', '=', 'u.id')
            ->leftJoin('positions as p', 'u.position_id', '=', 'p.id')
            ->leftJoin('uom as uom1', 'ci.uom_id', '=', 'uom1.id')
            ->leftJoin('uom as uom2', 'it.uom_id', '=', 'uom2.id')
            ->where('o.id', $order->id)
            ->select([
                'o.id as inden_id',
                'o.order_no as no_pesanan',
                'o.contract_id',
                'c.contract_no as no_kontrak',
                'o.order_date as tarikh_pesanan',
                'd.delivery_time as masa',
                'd.delivery_session as sesi_kod',
                'i.id as institution_id',
                'i.name as kepada_institusi',
                's.id as supplier_id',
                's.company_name as nama_pembekal',
                's.address as alamat_pembekal',
                's.postcode as poskod_pembekal',
                'd.supplier_rep_name as wakil_pembekal',
                'u.name as disediakan_oleh',
                'p.name as jawatan_cop',
                'p.grade as jawatan_gred',
                'd.supplier_declaration_date as tarikh_pembekal',
                'o.remarks as catatan_inden',
                'oi.id as item_inden_id',
                'it.name as nama_barang',
                DB::raw("COALESCE(uom1.code, uom2.code, 'Unit') as unit"),
                'oi.ordered_quantity as kuantiti_dipesan',
                'oi.unit_price as harga_seunit',
                DB::raw('oi.ordered_quantity * oi.unit_price as jumlah_harga'),
                'oi.remarks as catatan_item',
            ])
            ->orderBy('o.id')
            ->orderBy('oi.id')
            ->get();

        $header = $rows->first();
        $items = $rows->filter(fn($r) => $r->item_inden_id !== null)->values();

        if (!$header) {
            abort(404, 'Order not found');
        }

        $mealLabels = ['M1' => 'Breakfast', 'M2' => 'Lunch', 'M3' => 'Tea / Evening Snack', 'M4' => 'Dinner / Supper'];

        $html = view('pdf.borang_inden', [
            'header' => $header,
            'items' => $items,
            'mealLabels' => $mealLabels,
        ])->render();

        $options = new Options();
        $options->set('defaultFont', 'sans-serif');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Pesanan_Penerimaan_Catuan_Harian_' . $header->no_pesanan . '.pdf';
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function simpanBorangInden(Request $request)
    {
        foreach (['tarikh_pesanan', 'tarikh_pembekal'] as $dateField) {
            if ($request->filled($dateField)) {
                try {
                    $dateValue = trim($request->input($dateField));
                    $parsedDate = Carbon::createFromFormat('d/m/Y', $dateValue);
                    if ($parsedDate->format('d/m/Y') !== $dateValue) {
                        continue;
                    }

                    $request->merge([
                        $dateField => $parsedDate->format('Y-m-d'),
                    ]);
                } catch (\Throwable $e) {
                    // Let Laravel's date validation return the field-level error.
                }
            }
        }

        $maxUlasanWords = function ($attribute, $value, $fail) {
            if (!$value) {
                return;
            }

            $wordCount = str_word_count(trim(strip_tags($value)));
            if ($wordCount > 250) {
                $prefix = str_starts_with($attribute, 'items') ? '[Senarai Barang] ' : '[Perakuan Pembekal] ';
                $fail($prefix . 'Ulasan / Catatan tidak boleh melebihi 250 patah perkataan.');
            }
        };

        // Pre-process: strip seconds from masa if present (DB time type stores H:i:s)
        if ($request->filled('masa')) {
            $masa = $request->input('masa');
            if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $masa)) {
                $request->merge(['masa' => substr($masa, 0, 5)]);
            }
        }

        $validated = $request->validate([
            'no_pesanan' => ['required', 'string', 'max:100'],
            'contract_id' => ['required', 'exists:contracts,id'],
            'tarikh_pesanan' => ['required', 'date'],
            'masa' => ['required', 'date_format:H:i'],
            'sesi_kod' => ['required', 'in:M1,M2,M3,M4'],
            'institution_id' => ['required', 'exists:institutions,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'wakil_pembekal' => ['required', 'string', 'max:255'],
            'alamat_pembekal' => ['required', 'string'],
            'muster_khas_daging' => ['required', 'integer', 'min:0'],
            'muster_ditolak_parol' => ['required', 'integer', 'min:0'],
            'parol' => ['required', 'integer', 'min:0'],
            'muster_penuh' => ['required', 'integer', 'min:0'],
            'tarikh_pembekal' => ['required', 'date'],
            'catatan_inden' => ['nullable', 'string', $maxUlasanWords],
            'items' => ['required', 'array', 'min:1'],
            'items.*.contract_item_id' => ['required', 'integer'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.unit' => ['required', 'string', 'max:50'],
            'items.*.orderQty' => ['required', 'numeric', 'min:0'],
            'items.*.unitPrice' => ['required', 'numeric', 'min:0'],
            'items.*.notes' => ['nullable', 'string', $maxUlasanWords],
        ], [
            'no_pesanan.required'       => '[Maklumat Pesanan] No. Pesanan wajib diisi.',
            'contract_id.required'       => '[Maklumat Pesanan] No. Kontrak wajib dipilih.',
            'tarikh_pesanan.required'    => '[Maklumat Pesanan] Tarikh Pesanan wajib diisi.',
            'tarikh_pesanan.date'        => '[Maklumat Pesanan] Tarikh Pesanan mesti dalam format tarikh yang sah.',
            'masa.required'              => '[Maklumat Pesanan] Masa wajib diisi.',
            'masa.date_format'           => '[Maklumat Pesanan] Masa mesti dalam format jam:minit (cth: 14:30).',
            'sesi_kod.required'          => '[Maklumat Pesanan] Sesi / Kod wajib dipilih.',
            'sesi_kod.in'                => '[Maklumat Pesanan] Sesi / Kod mesti salah satu daripada M1, M2, M3, atau M4.',
            'institution_id.required'    => '[Maklumat Pesanan] Institusi (Kepada) wajib dipilih.',
            'institution_id.exists'      => '[Maklumat Pesanan] Institusi yang dipilih tidak sah.',
            'supplier_id.required'       => '[Maklumat Pesanan] Pembekal wajib dipilih.',
            'supplier_id.exists'         => '[Maklumat Pesanan] Pembekal yang dipilih tidak sah.',
            'alamat_pembekal.required'   => '[Maklumat Pesanan] Alamat Pembekal wajib diisi.',
            'muster_penuh.required'      => '[Ringkasan Muster] Muster Penuh wajib diisi.',
            'muster_penuh.integer'       => '[Ringkasan Muster] Muster Penuh mestilah nombor bulat.',
            'muster_penuh.min'           => '[Ringkasan Muster] Muster Penuh tidak boleh negatif.',
            'parol.required'             => '[Ringkasan Muster] Parol wajib diisi.',
            'parol.integer'              => '[Ringkasan Muster] Parol mestilah nombor bulat.',
            'parol.min'                  => '[Ringkasan Muster] Parol tidak boleh negatif.',
            'muster_ditolak_parol.required' => '[Ringkasan Muster] Muster Ditolak Parol wajib diisi.',
            'muster_ditolak_parol.integer'  => '[Ringkasan Muster] Muster Ditolak Parol mestilah nombor bulat.',
            'muster_ditolak_parol.min'      => '[Ringkasan Muster] Muster Ditolak Parol tidak boleh negatif.',
            'muster_khas_daging.required' => '[Ringkasan Muster] Muster Khas (Daging) wajib diisi.',
            'muster_khas_daging.integer'  => '[Ringkasan Muster] Muster Khas (Daging) mestilah nombor bulat.',
            'muster_khas_daging.min'      => '[Ringkasan Muster] Muster Khas (Daging) tidak boleh negatif.',
            'items.required'             => '[Senarai Barang] Sila tambah sekurang-kurangnya satu item pesanan.',
            'items.min'                  => '[Senarai Barang] Sila tambah sekurang-kurangnya satu item pesanan.',
            'items.*.contract_item_id.required' => '[Senarai Barang] ID item kontrak wajib diisi.',
            'items.*.contract_item_id.integer'  => '[Senarai Barang] ID item kontrak mesti nombor bulat.',
            'items.*.name.required'      => '[Senarai Barang] Nama barang wajib diisi.',
            'items.*.unit.required'      => '[Senarai Barang] Unit barang wajib diisi.',
            'items.*.orderQty.required'  => '[Senarai Barang] Kuantiti pesanan wajib diisi.',
            'items.*.orderQty.numeric'   => '[Senarai Barang] Kuantiti pesanan mestilah dalam bentuk nombor.',
            'items.*.orderQty.min'       => '[Senarai Barang] Kuantiti pesanan tidak boleh negatif.',
            'items.*.unitPrice.required' => '[Senarai Barang] Harga seunit wajib diisi.',
            'items.*.unitPrice.numeric'  => '[Senarai Barang] Harga seunit mestilah dalam bentuk nombor.',
            'items.*.unitPrice.min'      => '[Senarai Barang] Harga seunit tidak boleh negatif.',
            'wakil_pembekal.required'    => '[Perakuan Pembekal] Nama Wakil Pembekal wajib diisi.',
            'tarikh_pembekal.required'   => '[Perakuan Pembekal] Tarikh Pembekal wajib diisi.',
            'tarikh_pembekal.date'       => '[Perakuan Pembekal] Tarikh Pembekal mesti dalam format tarikh yang sah.',
        ]);

        $orderId = DB::transaction(function () use ($validated) {
            $today = now();
            $items = collect($validated['items'] ?? [])
                ->filter(fn ($item) => !empty($item['name']));

            $totalAmount = $items->sum(function ($item) {
                return ((float) ($item['orderQty'] ?? 0)) * ((float) ($item['unitPrice'] ?? 0));
            });

            $institutionId = $validated['institution_id'];
            $supplierId = $validated['supplier_id'];

            $contractId = $validated['contract_id'];

            // Auto-generate order_no (commented out — user enters no_pesanan manually)
            // $categoryCode = 'BK';
            //
            // try {
            //     $institutionData = DB::table('institutions')->where('id', $institutionId)->first(['code', 'location_code']);
            // } catch (\Throwable $e) {
            //     DB::rollBack();
            //     return redirect()->back()->withErrors([
            //         'institution_id' => '[Maklumat Pesanan] Ralat pada pangkalan data institusi. Sila pastikan lajur "code" wujud pada jadual institutions.',
            //     ])->withInput();
            // }
            // $instCode = $institutionData->code ?? 'XXX';
            // $locCode = $institutionData->location_code ?: $instCode;
            // $year = (int) now()->format('Y');
            // $yearShort = now()->format('y');
            // $month = (int) now()->format('m');
            //
            // $seqRow = DB::table('order_sequences')
            //     ->where('institution_code', $instCode)
            //     ->where('category_code', $categoryCode)
            //     ->where('year', $year)
            //     ->where('month', $month)
            //     ->lockForUpdate()
            //     ->first();
            //
            // if ($seqRow) {
            //     $nextSeq = $seqRow->sequence_no + 1;
            //     DB::table('order_sequences')
            //         ->where('id', $seqRow->id)
            //         ->update(['sequence_no' => $nextSeq, 'updated_at' => now()]);
            // } else {
            //     $nextSeq = 1;
            //     DB::table('order_sequences')->insert([
            //         'institution_code' => $instCode,
            //         'category_code' => $categoryCode,
            //         'year' => $year,
            //         'month' => $month,
            //         'sequence_no' => 1,
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);
            // }
            //
            // $autoOrderNo = sprintf('%s/%s/%s/%s/%s/%03d', $instCode, $locCode, $categoryCode, $yearShort, str_pad((string) $month, 2, '0', STR_PAD_LEFT), $nextSeq);

            $orderId = DB::table('orders')->insertGetId([
                'order_no' => $validated['no_pesanan'],
                'institution_id' => $institutionId,
                'supplier_id' => $supplierId,
                'contract_id' => $contractId,
                'order_date' => $validated['tarikh_pesanan'] ?? $today,
                'total_amount' => $totalAmount,
                'status' => 'Pending',
                'remarks' => $validated['catatan_inden'] ?? null,
                'created_at' => $today,
                'created_by' => Auth::id(),
                'updated_at' => $today,
                'updated_by' => Auth::id(),
            ]);

            DB::table('deliveries')->insert([
                'order_id' => $orderId,
                'delivery_date' => $validated['tarikh_pesanan'] ?? null,
                'delivery_time' => $validated['masa'] ?? null,
                'delivery_session' => $validated['sesi_kod'] ?? null,
                'muster_khas_daging' => (int) ($validated['muster_khas_daging'] ?? 0),
                'muster_ditolak_parol' => (int) ($validated['muster_ditolak_parol'] ?? 0),
                'parol' => (int) ($validated['parol'] ?? 0),
                'muster_penuh' => (int) ($validated['muster_penuh'] ?? 0),
                'supplier_declaration_date' => $validated['tarikh_pembekal'] ?? null,
                'supplier_rep_name' => $validated['wakil_pembekal'] ?? optional(DB::table('suppliers')->find($supplierId))->company_name ?? null,
                'status' => 'Pending',
                'remarks' => $validated['catatan_inden'] ?? null,
                'created_at' => $today,
                'created_by' => Auth::id(),
                'updated_at' => $today,
                'updated_by' => Auth::id(),
            ]);

            foreach ($items as $item) {
                $quantity = (float) ($item['orderQty'] ?? 0);
                $unitPrice = (float) ($item['unitPrice'] ?? 0);
                $lineTotal = $quantity * $unitPrice;
                $contractItemId = $item['contract_item_id'] ?? null;
                $itemId = null;

                if ($contractItemId && $contractItemId > 0) {
                    $contractItem = DB::table('contract_items')->where('id', $contractItemId)->first(['item_id']);
                    $itemId = $contractItem ? $contractItem->item_id : null;
                }

                if (!$itemId) {
                    // Custom item — find or create in items table
                    $itemName = $item['name'] ?? '';
                    $existing = DB::table('items')->where('name', $itemName)->first(['id']);
                    if ($existing) {
                        $itemId = $existing->id;
                    } else {
                        $itemId = DB::table('items')->insertGetId([
                            'name' => $itemName,
                            'uom_id' => null,
                            'status' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                    // For custom items, contract_item_id stored as null
                    $contractItemId = null;
                }

                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'contract_item_id' => $contractItemId,
                    'item_id' => $itemId,
                    'status' => 'Pending',
                    'ordered_quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'ordered_total_price' => $lineTotal,
                    'received_quantity' => 0,
                    'received_total_price' => 0,
                    'created_at' => $today,
                    'created_by' => Auth::id(),
                    'updated_at' => $today,
                    'updated_by' => Auth::id(),
                ]);
            }

            Approval::create([
                'order_id' => $orderId,
                'approved_by' => null,
                'approval_date' => null,
                'status' => 0,
                'remarks' => 'Menunggu pengesahan',
                'created_at' => $today,
                'created_by' => Auth::id(),
                'updated_at' => $today,
                'updated_by' => Auth::id(),
            ]);

            return $orderId;
        });

        BorangIndenDraft::where('user_id', Auth::id())->delete();

        return redirect()
            ->route('borang.inden')
            ->with('success', 'Borang inden berjaya dihantar dan disimpan.');
    }

    public function sahkanInden(Request $request, Order $order)
    {
        $maxUlasanWords = function ($attribute, $value, $fail) {
            if (!$value) return;
            $wordCount = str_word_count(trim(strip_tags($value)));
            if ($wordCount > 250) {
                $fail('Ulasan tidak boleh melebihi 250 patah perkataan.');
            }
        };

        $request->validate([
            'approval' => 'required|in:sahkan,tidak_disahkan',
            'ulasan' => ['nullable', 'string', $maxUlasanWords],
        ]);

        $statusVal = $request->input('approval') === 'sahkan' ? 1 : 2; // 1 = Disahkan, 2 = Tidak Disahkan
        $remarksVal = $request->input('ulasan');

        DB::transaction(function () use ($order, $statusVal, $remarksVal) {
            $approval = Approval::where('order_id', $order->id)
                ->where('status', 0)
                ->first();

            if (!$approval) {
                $approval = Approval::create([
                    'order_id' => $order->id,
                    'approved_by' => Auth::id(),
                    'approval_date' => now()->toDateString(),
                    'status' => $statusVal,
                    'remarks' => $remarksVal,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'updated_by' => Auth::id(),
                ]);
            } else {
                $today = now()->toDateString();

                $approval->update([
                    'approved_by' => Auth::id(),
                    'approval_date' => $today,
                    'status' => $statusVal,
                    'remarks' => $remarksVal,
                    'updated_at' => $today,
                    'updated_by' => Auth::id(),
                ]);
            }

            $orderStatus = $statusVal === 1 ? 'In Progress' : 'Rejected';
            $order->update([
                'status' => $orderStatus,
                'updated_at' => now(),
                'updated_by' => Auth::id(),
            ]);
        });

        $message = $statusVal === 1 
            ? 'Inden berjaya disahkan dan status ditukar kepada In Progress.' 
            : 'Inden berjaya ditolak.';

        return redirect()
            ->route('user.pengesahan.inden')
            ->with('success', $message);
    }

    public static function pendingApprovalCount(?int $institutionId = null): int
    {
        return Order::where('orders.status', 'Pending')
            ->where(function ($q) {
                $q->whereDoesntHave('approvals')
                  ->orWhereHas('approvals', fn ($q2) => $q2->where('status', 0));
            })
            ->when($institutionId, fn ($q) => $q->where('orders.institution_id', $institutionId))
            ->count();
    }

    private function ordersWithDetails(?int $institutionId = null)
    {
        return Order::query()
            ->leftJoin('institutions', 'orders.institution_id', '=', 'institutions.id')
            ->leftJoin('suppliers', 'orders.supplier_id', '=', 'suppliers.id')
            ->leftJoin('approvals', 'orders.id', '=', 'approvals.order_id')
            ->when($institutionId, fn ($q) => $q->where('orders.institution_id', $institutionId))
            ->select([
                'orders.id',
                'orders.order_no',
                'orders.order_date',
                'orders.total_amount',
                'orders.status as order_status',
                'orders.remarks as order_remarks',
                'institutions.name as institution_name',
                'suppliers.company_name as supplier_name',
                'suppliers.email as supplier_email',
                DB::raw('COALESCE(approvals.status, 0) as approval_status'),
                'approvals.approval_date',
                'approvals.remarks as approval_remarks',
            ])
            ->orderByDesc('orders.order_date')
            ->orderByDesc('orders.id');
    }

    private function borangIndenView(?Order $order, bool $readOnly)
    {
        // Allow access if user is admin HQ or belongs to the institution
        $user = Auth::user();
        $user->loadMissing('role');
        
        $isAdminHQ = $user->role_id == 1 || $user->role?->role_name === 'admin hq';
        
        if ($order && $order->institution_id !== $user->institution_id && !$isAdminHQ) {
            abort(403, 'Anda tidak mempunyai akses kepada pesanan ini.');
        }

        $rows = collect();

        if ($order) {
            $rows = DB::table('orders as o')
                ->leftJoin('contracts as c', 'o.contract_id', '=', 'c.id')
                ->leftJoin('institutions as i', 'o.institution_id', '=', 'i.id')
                ->leftJoin('suppliers as s', 'o.supplier_id', '=', 's.id')
                ->leftJoin('deliveries as d', 'o.id', '=', 'd.order_id')
                ->leftJoin('order_items as oi', 'o.id', '=', 'oi.order_id')
                ->leftJoin('items as it', 'oi.item_id', '=', 'it.id')
                ->leftJoin('contract_items as ci', 'oi.contract_item_id', '=', 'ci.id')
                ->leftJoin('approvals as a', 'o.id', '=', 'a.order_id')
                ->leftJoin('users as u', 'o.created_by', '=', 'u.id')
                ->leftJoin('positions as p', 'u.position_id', '=', 'p.id')
                ->leftJoin('uom as uom1', 'ci.uom_id', '=', 'uom1.id')
                ->leftJoin('uom as uom2', 'it.uom_id', '=', 'uom2.id')
                ->where('o.id', $order->id)
                ->select([
                    'o.id as inden_id',
                    'o.order_no as no_pesanan',
                    'o.contract_id',
                    'c.contract_no as no_kontrak',
                    'o.order_date as tarikh_pesanan',
                    'd.delivery_time as masa',
                    'd.delivery_session as sesi_kod',
                    'i.id as institution_id',
                    'i.name as kepada_institusi',
                    's.id as supplier_id',
                    's.company_name as nama_pembekal',
                    'd.supplier_rep_name as wakil_pembekal',
                    's.address as alamat_pembekal',
                    's.postcode as poskod_pembekal',
                    'd.muster_khas_daging',
                    'd.muster_ditolak_parol',
                    'd.parol',
                    'd.muster_penuh',
                    'u.name as disediakan_oleh',
                    'p.name as jawatan_cop',
                    'd.supplier_declaration_date as tarikh_pembekal',
                    'o.remarks as catatan_inden',
                    'oi.id as item_inden_id',
                    'oi.contract_item_id',
                    'it.name as nama_barang',
                    DB::raw("COALESCE(uom1.code, uom2.code, 'Unit') as unit"),
                    'oi.ordered_quantity as kuantiti_dipesan',
                    'oi.unit_price as harga_seunit',
                    'oi.ordered_total_price as jumlah_harga_item',
                    'oi.status as status_item',
                    'oi.remarks as catatan_item',
                    'a.status as status_kelulusan',
                    'a.approval_date as tarikh_kelulusan',
                    'a.remarks as ulasan_kelulusan',
                ])
                ->orderBy('o.id')
                ->orderBy('oi.id')
                ->get();
        }

        $indenHeader = $rows->first();
        $indenItems = $rows
            ->filter(fn ($row) => $row->item_inden_id !== null)
            ->map(fn ($row) => [
                'contract_item_id' => $row->contract_item_id,
                'name' => $row->nama_barang,
                'unit' => $row->unit ?: 'Unit',
                'orderQty' => (float) $row->kuantiti_dipesan,
                'unitPrice' => (float) $row->harga_seunit,
                'receivedQty' => 0,
                'notes' => $row->catatan_item,
            ])
            ->values();

        $userGrade = optional(Auth::user()->position)->grade;
        $userPositionName = optional(Auth::user()->position)->name;
        $userInstitutionId = Auth::user()->institution_id;
        $pendingPenerimaan = Order::where('status', 'In Progress')->where('institution_id', Auth::user()->institution_id)->count();

        return view('borang_inden', [
            'indenHeader' => $indenHeader,
            'indenItems' => $indenItems,
            'readOnly' => $readOnly,
            'pendingApprovals' => $this->pendingApprovalCount(Auth::user()->institution_id),
            'pendingPenerimaan' => $pendingPenerimaan,
            'institutions' => \App\Models\Institution::orderBy('name')->get(['id', 'name']),
            'suppliers' => \App\Models\Supplier::orderBy('company_name')->get(['id', 'company_name', 'contact_person', 'address', 'postcode']),
            'userGrade' => $userGrade,
            'userPositionName' => $userPositionName,
            'userInstitutionId' => $userInstitutionId,
            'mealSessions' => [
                'M1' => 'Breakfast',
                'M2' => 'Lunch',
                'M3' => 'Tea / Evening Snack',
                'M4' => 'Dinner / Supper',
            ],
        ]);
    }

    public function borangPenerimaan()
    {
        $instId = Auth::user()->institution_id;
        $orders = Order::leftJoin('suppliers', 'orders.supplier_id', '=', 'suppliers.id')
            ->leftJoin('institutions', 'orders.institution_id', '=', 'institutions.id')
            ->select([
                'orders.id',
                'orders.order_no',
                'orders.order_date',
                'suppliers.company_name as supplier_name',
                'institutions.name as institution_name',
                'orders.status',
            ])
            ->where('orders.status', 'In Progress')
            ->where('orders.institution_id', $instId)
            ->orderByDesc('orders.id')
            ->get()
            ->map(function ($order) {
                try {
                    $order->formatted_date = $order->order_date && $order->order_date !== '0000-00-00'
                        ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y')
                        : '-';
                } catch (\Throwable $e) {
                    $order->formatted_date = '-';
                }
                return $order;
            });

        $uoms = \App\Models\Uom::orderBy('code')->get(['id', 'code']);
        $pendingPenerimaan = Order::where('status', 'In Progress')->where('institution_id', $instId)->count();

        return view('borang_penerimaan', [
            'orders' => $orders,
            'uoms' => $uoms,
            'pendingApprovals' => $this->pendingApprovalCount($instId),
            'pendingPenerimaan' => $pendingPenerimaan,
        ]);
    }

    public function getPenerimaanItems($order)
    {
        $order = Order::find($order);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak dijumpai.']);
        }
        if ($order->institution_id !== Auth::user()->institution_id) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.']);
        }

        $items = DB::table('order_items')
            ->leftJoin('items', 'order_items.item_id', '=', 'items.id')
            ->leftJoin('uom', 'items.uom_id', '=', 'uom.id')
            ->where('order_items.order_id', $order->id)
            ->select([
                'order_items.id',
                'order_items.item_id',
                'order_items.ordered_quantity',
                'order_items.received_quantity',
                'items.name',
                DB::raw("COALESCE(uom.code, 'Unit') as unit"),
            ])
            ->get()
            ->map(fn($i) => [
                'id' => $i->id,
                'item_id' => $i->item_id,
                'name' => $i->name,
                'unit' => $i->unit,
                'ordered_qty' => (float) $i->ordered_quantity,
                'received_qty' => (float) $i->received_quantity,
            ]);

        try {
            $formattedDate = $order->order_date && $order->order_date !== '0000-00-00'
                ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y')
                : '-';
        } catch (\Throwable $e) {
            $formattedDate = '-';
        }

        return response()->json([
            'success' => true,
            'data' => [
                'order_no' => $order->order_no,
                'order_date' => $order->order_date,
                'formatted_date' => $formattedDate,
                'supplier_name' => $order->supplier?->company_name ?? '-',
                'institution_name' => $order->institution?->name ?? '-',
                'contract_no' => $order->contract?->contract_no ?? '-',
                'items' => $items,
            ],
        ]);
    }

    public function simpanPenerimaan(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'received_date' => 'required|date_format:d/m/Y',
            'received_by' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.received_qty' => 'required|numeric|min:0',
            'items.*.item_id' => 'required|integer',
        ]);

        $orderId = $request->order_id;
        $today = now()->toDateString();
        $receivedDateDb = \Carbon\Carbon::createFromFormat('d/m/Y', $request->received_date)->format('Y-m-d');

        $orderCheck = Order::find($orderId);
        if (!$orderCheck || $orderCheck->institution_id !== Auth::user()->institution_id) {
            return redirect()->back()->withErrors('Akses ditolak.')->withInput();
        }

        DB::transaction(function () use ($request, $orderId, $today) {
            foreach ($request->items as $orderItemId => $item) {
                $remarks = $item['remarks'] ?? null;
                if (!empty($item['is_wrong'])) {
                    $replaceName = $item['replace_name'] ?? null;
                    $replaceUnit = $item['replace_unit'] ?? null;
                    $replaceQty = $item['replace_qty'] ?? null;

                    $remarks = ($remarks ? $remarks . ' | ' : '') . '[SALAH]';

                    if ($replaceName && $replaceQty !== null && $replaceQty !== '') {
                        $qty = (float) $replaceQty;
                        $unitPrice = (float) (DB::table('items')->where('id', (int) $replaceName)->value('price_per_unit') ?? 0);
                        $totalPrice = $qty * $unitPrice;

                        $replaceItemId = DB::table('replacement_items')->insertGetId([
                            'item_id' => (int) $replaceName,
                            'quantity' => $qty,
                            'unit_price' => $unitPrice,
                            'total_price' => $totalPrice,
                            'remarks' => $replaceUnit ? "Unit: {$replaceUnit}" : null,
                            'created_at' => now(),
                            'created_by' => Auth::id(),
                            'updated_at' => now(),
                            'updated_by' => Auth::id(),
                        ]);

                        DB::table('order_item_replace')->insert([
                            'order_id' => $orderId,
                            'replace_item_id' => $replaceItemId,
                        ]);
                    }
                }

                $receivedQty = (float) ($item['received_qty'] ?? 0);

                DB::table('order_items')
                    ->where('id', $orderItemId)
                    ->where('order_id', $orderId)
                    ->update([
                        'received_quantity' => $receivedQty,
                        'received_total_price' => DB::raw('received_quantity * unit_price'),
                        'remarks' => $remarks,
                        'updated_at' => $today,
                        'updated_by' => Auth::id(),
                    ]);

                // Update inventory: increase current_quantity by received amount
                $itemId = (int) ($item['item_id'] ?? 0);
                if ($itemId > 0 && $receivedQty > 0) {
                    DB::table('items')
                        ->where('id', $itemId)
                        ->increment('current_quantity', $receivedQty);
                }
            }

            $receivingStatus = $request->input('status', 'Lengkap');
            $order = Order::find($orderId);
            $deliveryRemarks = $request->remarks ?: null;
            $order->update([
                'status' => 'Completed',
                'remarks' => 'Diterima pada ' . $request->received_date . ' oleh ' . $request->received_by . ($deliveryRemarks ? ' | Catatan: ' . $deliveryRemarks : ''),
                'updated_at' => $today,
                'updated_by' => Auth::id(),
            ]);

            // Update deliveries table with receiving info
            $receivedByUser = Auth::user();
            DB::table('deliveries')
                ->where('order_id', $orderId)
                ->update([
                    'received_by' => $receivedByUser ? $receivedByUser->id : null,
                    'receiver_date' => $receivedDateDb ?? $today,
                    'status' => $receivingStatus,
                    'remarks' => $deliveryRemarks,
                    'updated_at' => $today,
                    'updated_by' => Auth::id(),
                ]);
        });

        return redirect()
            ->route('borang.penerimaan')
            ->with('success', 'Penerimaan barang berjaya direkodkan.');
    }

    public function cetakPenerimaanPdf(Order $order)
    {
        $rows = DB::table('orders as o')
            ->leftJoin('institutions as i', 'o.institution_id', '=', 'i.id')
            ->leftJoin('suppliers as s', 'o.supplier_id', '=', 's.id')
            ->leftJoin('contracts as c', 'o.contract_id', '=', 'c.id')
            ->leftJoin('deliveries as d', 'o.id', '=', 'd.order_id')
            ->leftJoin('order_items as oi', 'o.id', '=', 'oi.order_id')
            ->leftJoin('items as it', 'oi.item_id', '=', 'it.id')
            ->leftJoin('uom as u', 'it.uom_id', '=', 'u.id')
            ->leftJoin('users as uu', 'd.received_by', '=', 'uu.id')
            ->where('o.id', $order->id)
            ->select([
                'o.id as order_id',
                'o.order_no',
                'o.order_date',
                'o.total_amount',
                'i.name as institution_name',
                's.company_name as supplier_name',
                'c.contract_no',
                'd.receiver_date',
                'd.status as penerimaan_status',
                'd.remarks as penerimaan_catatan',
                'uu.name as received_by_name',
                'oi.id as order_item_id',
                'it.name as item_name',
                DB::raw("COALESCE(u.code, 'Unit') as unit"),
                'oi.ordered_quantity',
                'oi.received_quantity',
                'oi.unit_price',
                'oi.ordered_total_price',
                'oi.received_total_price',
                'oi.remarks as item_remarks',
            ])
            ->orderBy('oi.id')
            ->get();

        if ($rows->isEmpty()) {
            abort(404, 'Penerimaan tidak dijumpai');
        }

        $header = (object) [
            'order_no' => $rows->first()->order_no,
            'order_date' => $rows->first()->order_date,
            'institution_name' => $rows->first()->institution_name,
            'supplier_name' => $rows->first()->supplier_name,
            'contract_no' => $rows->first()->contract_no,
            'receiver_date' => $rows->first()->receiver_date,
            'received_by_name' => $rows->first()->received_by_name,
            'penerimaan_status' => $rows->first()->penerimaan_status,
            'penerimaan_catatan' => $rows->first()->penerimaan_catatan,
            'total_amount' => $rows->first()->total_amount,
        ];

        $items = $rows->filter(fn($r) => $r->order_item_id !== null)->values();

        // Get replacement items for this order
        $replacements = DB::table('order_item_replace as oir')
            ->join('replacement_items as ri', 'oir.replace_item_id', '=', 'ri.id')
            ->join('items as it', 'ri.item_id', '=', 'it.id')
            ->leftJoin('uom as u', 'it.uom_id', '=', 'u.id')
            ->where('oir.order_id', $order->id)
            ->select([
                'ri.id',
                'it.name as item_name',
                DB::raw("COALESCE(u.code, 'Unit') as unit"),
                'ri.quantity',
                'ri.unit_price',
                'ri.total_price',
            ])
            ->get();

        $html = view('pdf.borang_penerimaan', [
            'header' => $header,
            'items' => $items,
            'replacements' => $replacements,
        ])->render();

        $options = new Options();
        $options->set('defaultFont', 'sans-serif');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();
        return response($pdfOutput, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="borang_penerimaan_' . $order->order_no . '.pdf"',
        ]);
    }

    public function criticalStock()
    {
        $items = DB::table('items')
            ->leftJoin('categories', 'items.category_id', '=', 'categories.id')
            ->leftJoin('ceiling_limits', 'items.ceiling_limit_id', '=', 'ceiling_limits.id')
            ->leftJoin('uom', 'items.uom_id', '=', 'uom.id')
            ->select([
                'items.id',
                'items.name',
                'items.current_quantity',
                'uom.code as uom_code',
                'items.price_per_unit',
                'items.status',
                'categories.name as category',
                'ceiling_limits.monthly_limit',
                'ceiling_limits.yearly_limit',
                'ceiling_limits.contract_limit',
            ])
            ->orderBy('items.name')
            ->get()
            ->map(function ($item) {
                $stock = (float) ($item->current_quantity ?? 0);
                $minStock = $this->resolveMinimumStock($item, $stock);
                $percentage = $minStock > 0 ? round(($stock / $minStock) * 100) : 0;

                return [
                    'id' => (int) $item->id,
                    'name' => $item->name,
                    'category' => $item->category ?? 'Tanpa Kategori',
                    'stock' => $stock,
                    'minStock' => $minStock,
                    'unit' => $item->uom_code ?? 'Unit',
                    'price' => (float) ($item->price_per_unit ?? 0),
                    'status' => ((int) $item->status) === 1 ? 'active' : 'inactive',
                    'stockPercentage' => $percentage,
                ];
            })
            ->sortBy('stockPercentage')
            ->take(5)
            ->values();

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }

    public function stockForecast()
    {
        $items = DB::table('items')
            ->leftJoin('categories', 'items.category_id', '=', 'categories.id')
            ->leftJoin('ceiling_limits', 'items.ceiling_limit_id', '=', 'ceiling_limits.id')
            ->leftJoin('uom', 'items.uom_id', '=', 'uom.id')
            ->select([
                'items.id',
                'items.name',
                'items.current_quantity',
                'uom.code as uom_code',
                'items.price_per_unit',
                'items.status',
                'categories.name as category',
                'ceiling_limits.monthly_limit',
                'ceiling_limits.yearly_limit',
                'ceiling_limits.contract_limit',
            ])
            ->orderBy('items.name')
            ->get()
            ->map(function ($item) {
                $stock = (float) ($item->current_quantity ?? 0);
                $minStock = $this->resolveMinimumStock($item, $stock);
                $monthsRemaining = $minStock > 0 ? round($stock / $minStock, 1) : null;

                if ($monthsRemaining === null) {
                    $riskText = 'Tidak Cukup Data';
                    $riskClass = 'secondary';
                } elseif ($monthsRemaining <= 1) {
                    $riskText = 'Habis Bulan Ini';
                    $riskClass = 'danger';
                } elseif ($monthsRemaining <= 3) {
                    $riskText = 'Habis 3 Bulan';
                    $riskClass = 'warning';
                } elseif ($monthsRemaining <= 6) {
                    $riskText = 'Akan Habis 6 Bulan';
                    $riskClass = 'warning';
                } else {
                    $riskText = 'Cukup >6 Bulan';
                    $riskClass = 'success';
                }

                return [
                    'id' => (int) $item->id,
                    'name' => $item->name,
                    'category' => $item->category ?? 'Tanpa Kategori',
                    'stock' => $stock,
                    'monthsRemaining' => $monthsRemaining,
                    'risk' => [
                        'text' => $riskText,
                        'class' => $riskClass
                    ],
                    'unit' => $item->uom_code ?? 'Unit',
                ];
            })
            ->sortBy(function ($item) {
                return $item['monthsRemaining'] === null ? 999999 : $item['monthsRemaining'];
            })
            ->take(5)
            ->values();

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }

    public function stockByCategory()
    {
        $categories = DB::table('categories')
            ->select('id', 'name')
            ->get();

        $data = [];
        foreach ($categories as $category) {
            $items = DB::table('items')
                ->where('category_id', $category->id)
                ->get();
            
            $activeCount = $items->where('status', 1)->count();
            $criticalCount = 0;
            
            foreach ($items as $item) {
                $stock = (float) ($item->current_quantity ?? 0);
                $minStock = $this->resolveMinimumStock($item, $stock);
                if ($stock < $minStock) {
                    $criticalCount++;
                }
            }

            if ($items->count() > 0) {
                $data[] = [
                    'name' => $category->name,
                    'total' => $items->count(),
                    'active' => $activeCount,
                    'critical' => $criticalCount
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    private function resolveMinimumStock(object $item, float $stock): float
    {
        $configuredMinimum = $this->configuredMinimumStock($item);
        if ($configuredMinimum !== null) {
            return $configuredMinimum;
        }

        return $stock > 0 ? $stock : 1;
    }

    private function getContractLimitData()
    {
        $instId = Auth::user()->institution_id;

        $contracts = DB::table('ceiling_limits')
            ->join('contracts', 'ceiling_limits.contract_id', '=', 'contracts.id')
            ->join('suppliers', 'contracts.supplier_id', '=', 'suppliers.id')
            ->where('ceiling_limits.institution_id', $instId)
            ->where('contracts.status', 'Active')
            ->select(
                'ceiling_limits.id',
                'ceiling_limits.contract_limit',
                'ceiling_limits.used_quantity',
                'contracts.id as contract_id',
                'contracts.contract_no',
                'contracts.supplier_id',
                'contracts.start_date',
                'contracts.end_date',
                'suppliers.company_name as supplier_name'
            )
            ->get()
            ->map(function ($item) {
                $limit = (float) ($item->contract_limit ?? 0);

                $actualUsed = (float) DB::table('orders')
                    ->where('contract_id', $item->contract_id)
                    ->whereNotIn('status', ['Cancelled', 'Rejected', 'Draft'])
                    ->sum('total_amount');

                $used = $actualUsed > 0 ? $actualUsed : (float) ($item->used_quantity ?? 0);
                $percentage = $limit > 0 ? round(($used / $limit) * 100, 1) : 0;

                if ($percentage > 100) {
                    $status = 'over';
                    $statusText = 'Melebihi Had';
                    $statusClass = 'danger';
                } elseif ($percentage == 100) {
                    $status = 'hit';
                    $statusText = 'Mencapai Had';
                    $statusClass = 'danger';
                } elseif ($percentage >= 80) {
                    $status = 'near';
                    $statusText = 'Hampir Had';
                    $statusClass = 'warning';
                } else {
                    $status = 'safe';
                    $statusText = 'Selamat';
                    $statusClass = 'success';
                }

                $remaining = $limit - $used;

                return [
                    'id' => $item->id,
                    'contract_no' => $item->contract_no,
                    'supplier' => $item->supplier_name,
                    'limit' => $limit,
                    'used' => $used,
                    'remaining' => $remaining > 0 ? $remaining : 0,
                    'percentage' => min($percentage, 100),
                    'raw_percentage' => $percentage,
                    'status' => $status,
                    'statusText' => $statusText,
                    'statusClass' => $statusClass,
                    'start_date' => $item->start_date,
                    'end_date' => $item->end_date,
                ];
            })
            ->sortByDesc('raw_percentage')
            ->values();

        $total = $contracts->count();
        $safe = $contracts->where('status', 'safe')->count();
        $near = $contracts->where('status', 'near')->count();
        $over = $contracts->where('status', 'over')->count() + $contracts->where('status', 'hit')->count();

        return [
            'contracts' => $contracts,
            'summary' => [
                'total' => $total,
                'safe' => $safe,
                'near' => $near,
                'over' => $over,
            ],
            'hasCritical' => $near > 0 || $over > 0,
        ];
    }

    private function configuredMinimumStock(object $item): ?float
    {
        $monthlyLimit = (float) ($item->monthly_limit ?? 0);
        if ($monthlyLimit > 0) {
            return $monthlyLimit;
        }

        $yearlyLimit = (float) ($item->yearly_limit ?? 0);
        if ($yearlyLimit > 0) {
            return $yearlyLimit / 12;
        }

        $contractLimit = (float) ($item->contract_limit ?? 0);
        if ($contractLimit > 0) {
            return $contractLimit / 12;
        }

        return null;
    }

    private function lowStockItems()
    {
        return DB::table('items')
            ->leftJoin('categories', 'items.category_id', '=', 'categories.id')
            ->leftJoin('ceiling_limits', 'items.ceiling_limit_id', '=', 'ceiling_limits.id')
            ->leftJoin('uom', 'items.uom_id', '=', 'uom.id')
            ->select([
                'items.id',
                'items.name',
                'items.current_quantity',
                'uom.code as uom_code',
                'items.status',
                'categories.name as category',
                'ceiling_limits.monthly_limit',
                'ceiling_limits.yearly_limit',
                'ceiling_limits.contract_limit',
            ])
            ->where('items.status', 1)
            ->orderBy('items.name')
            ->get()
            ->map(function ($item) {
                $minStock = $this->configuredMinimumStock($item);
                if ($minStock === null) {
                    return null;
                }

                $stock = (float) ($item->current_quantity ?? 0);
                $percentage = $minStock > 0 ? round(($stock / $minStock) * 100) : 0;

                return [
                    'id' => (int) $item->id,
                    'name' => $item->name,
                    'category' => $item->category ?? 'Tanpa Kategori',
                    'stock' => $stock,
                    'minStock' => $minStock,
                    'unit' => $item->uom_code ?? 'Unit',
                    'stockPercentage' => $percentage,
                ];
            })
            ->filter(fn ($item) => $item && $item['stock'] <= $item['minStock'])
            ->sortBy('stockPercentage')
            ->values();
    }

    public function saveDraft(Request $request)
    {
        $data = $request->only([
            'no_pesanan', 'contract_id', 'tarikh_pesanan', 'masa', 'sesi_kod',
            'institution_id', 'supplier_id', 'wakil_pembekal', 'alamat_pembekal',
            'muster_khas_daging', 'muster_ditolak_parol', 'parol', 'muster_penuh',
            'tarikh_pembekal', 'catatan_inden',
        ]);

        $data['items'] = $request->input('items', []);

        BorangIndenDraft::updateOrCreate(
            ['user_id' => Auth::id()],
            ['data' => $data]
        );

        return response()->json(['success' => true, 'saved_at' => now()->toIso8601String()]);
    }

    public function getDraft()
    {
        $draft = BorangIndenDraft::where('user_id', Auth::id())->first(['data', 'updated_at']);
        if (!$draft) {
            return response()->json(['success' => false, 'data' => null]);
        }
        return response()->json(['success' => true, 'data' => $draft->data, 'saved_at' => $draft->updated_at]);
    }

    public function deleteDraft()
    {
        BorangIndenDraft::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }

    private function getContractMonthlyTrend()
    {
        $instId = Auth::user()->institution_id;

        $contracts = DB::table('ceiling_limits')
            ->join('contracts', 'ceiling_limits.contract_id', '=', 'contracts.id')
            ->where('ceiling_limits.institution_id', $instId)
            ->where('contracts.status', 'Active')
            ->select('contracts.id', 'contracts.contract_no', 'ceiling_limits.contract_limit')
            ->get();

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        $datasets = [];
        foreach ($contracts as $c) {
            $monthlyData = [];
            $runningTotal = 0;

            foreach ($months as $m) {
                $monthTotal = (float) DB::table('orders')
                    ->where('contract_id', $c->id)
                    ->whereNotIn('status', ['Cancelled', 'Rejected', 'Draft'])
                    ->whereYear('order_date', substr($m, 0, 4))
                    ->whereMonth('order_date', substr($m, 5, 2))
                    ->sum('total_amount');

                $runningTotal += $monthTotal;
                $monthlyData[] = $runningTotal;
            }

            $datasets[] = [
                'label' => $c->contract_no,
                'data' => $monthlyData,
                'limit' => (float) $c->contract_limit,
                'fill' => false,
                'tension' => 0.3,
            ];
        }

        return [
            'labels' => $months->map(fn($m) => \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M Y'))->values(),
            'datasets' => $datasets,
        ];
    }

    private function getItemPredictions($instId)
    {
        $items = DB::table('items as i')
            ->leftJoin('uom as u', 'i.uom_id', '=', 'u.id')
            ->select('i.id', 'i.name', 'i.current_quantity', 'u.code as uom_code')
            ->where(function ($q) use ($instId) {
                $q->whereExists(function ($sub) use ($instId) {
                    $sub->select(DB::raw(1))
                        ->from('contract_items')
                        ->join('contracts', 'contract_items.contract_id', '=', 'contracts.id')
                        ->whereColumn('contract_items.item_id', 'i.id')
                        ->where('contracts.institution_id', $instId)
                        ->where('contracts.status', 'Active');
                })->orWhereExists(function ($sub) use ($instId) {
                    $sub->select(DB::raw(1))
                        ->from('order_items')
                        ->join('orders', 'order_items.order_id', '=', 'orders.id')
                        ->whereColumn('order_items.item_id', 'i.id')
                        ->where('orders.institution_id', $instId);
                });
            })
            ->orderBy('i.name')
            ->get();

        $sixMonthsAgo = now()->subMonths(6)->startOfMonth();
        $usageRaw = DB::table('order_items as oi')
            ->join('orders as o', 'oi.order_id', '=', 'o.id')
            ->where('o.institution_id', $instId)
            ->whereNotIn('o.status', ['Cancelled', 'Rejected', 'Draft'])
            ->where('o.order_date', '>=', $sixMonthsAgo)
            ->select(
                'oi.item_id',
                DB::raw('YEAR(o.order_date) as yr'),
                DB::raw('MONTH(o.order_date) as mo'),
                DB::raw('SUM(oi.ordered_quantity) as total')
            )
            ->groupBy('oi.item_id', 'yr', 'mo')
            ->get();

        $usageByItem = [];
        foreach ($usageRaw as $u) {
            $key = $u->item_id . '_' . $u->yr . '-' . str_pad($u->mo, 2, '0', STR_PAD_LEFT);
            $usageByItem[$key] = (float) $u->total;
        }

        $monthLabels = [];
        $monthIndex = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $monthLabels[] = $m->format('M Y');
            $monthIndex[] = $m->format('Y-m');
        }

        $predictions = [];
        foreach ($items as $item) {
            $monthlyData = [];
            foreach ($monthIndex as $mi) {
                $key = $item->id . '_' . $mi;
                $monthlyData[] = $usageByItem[$key] ?? 0;
            }

            $avgMonthly = array_sum($monthlyData) / max(count($monthlyData), 1);
            $stock = (float) ($item->current_quantity ?? 0);

            $n = count($monthlyData);
            if ($n > 1 && array_sum($monthlyData) > 0) {
                $x = range(1, $n);
                $sumX = array_sum($x);
                $sumY = array_sum($monthlyData);
                $sumXY = 0;
                $sumX2 = 0;
                for ($i = 0; $i < $n; $i++) {
                    $sumXY += $x[$i] * $monthlyData[$i];
                    $sumX2 += $x[$i] * $x[$i];
                }
                $denom = ($n * $sumX2 - $sumX * $sumX);
                if ($denom != 0) {
                    $slope = ($n * $sumXY - $sumX * $sumY) / $denom;
                    $intercept = ($sumY - $slope * $sumX) / $n;
                } else {
                    $slope = 0;
                    $intercept = $avgMonthly;
                }
            } else {
                $slope = 0;
                $intercept = $avgMonthly;
            }

            $forecast = [];
            for ($i = 1; $i <= 3; $i++) {
                $val = max(0, $slope * ($n + $i) + $intercept);
                $forecast[] = round($val, 1);
            }

            $predictedMonthly = max($avgMonthly, 0.001);
            $monthsUntilEmpty = $stock / $predictedMonthly;

            $willLastYear = $monthsUntilEmpty >= 12;
            if ($monthsUntilEmpty <= 1) {
                $status = 'critical';
                $statusText = 'Kritikal';
            } elseif ($monthsUntilEmpty <= 3) {
                $status = 'warning';
                $statusText = 'Akan Habis';
            } elseif ($monthsUntilEmpty <= 6) {
                $status = 'attention';
                $statusText = 'Perhatian';
            } elseif ($monthsUntilEmpty <= 12) {
                $status = 'watch';
                $statusText = 'Dipantau';
            } else {
                $status = 'safe';
                $statusText = 'Selamat';
            }

            $predictions[] = [
                'id' => $item->id,
                'name' => $item->name,
                'uom' => $item->uom_code ?? 'Unit',
                'stock' => $stock,
                'avgMonthly' => round($avgMonthly, 1),
                'monthsUntilEmpty' => round($monthsUntilEmpty, 1),
                'willLastYear' => $willLastYear,
                'status' => $status,
                'statusText' => $statusText,
                'forecast' => $forecast,
                'slope' => round($slope, 2),
                'history' => $monthlyData,
            ];
        }

        usort($predictions, fn($a, $b) => $a['monthsUntilEmpty'] <=> $b['monthsUntilEmpty']);

        $top5 = array_slice($predictions, 0, 5);
        $bottom5 = array_filter($predictions, fn($p) => $p['avgMonthly'] > 0);
        usort($bottom5, fn($a, $b) => $b['monthsUntilEmpty'] <=> $a['monthsUntilEmpty']);
        $bottom5 = array_slice($bottom5, 0, 5);

        $summary = [
            'total' => count($predictions),
            'critical' => count(array_filter($predictions, fn($p) => $p['status'] === 'critical')),
            'warning' => count(array_filter($predictions, fn($p) => $p['status'] === 'warning')),
            'attention' => count(array_filter($predictions, fn($p) => $p['status'] === 'attention')),
            'safe' => count(array_filter($predictions, fn($p) => $p['status'] === 'safe')),
            'willRunOut' => count(array_filter($predictions, fn($p) => !$p['willLastYear'])),
            'willLast' => count(array_filter($predictions, fn($p) => $p['willLastYear'])),
        ];

        return [
            'top5' => $top5,
            'bottom5' => $bottom5,
            'summary' => $summary,
            'forecastLabels' => ['Bulan 1', 'Bulan 2', 'Bulan 3'],
        ];
    }

    public function userInventori()
    {
        $instId = Auth::user()->institution_id;

        $items = DB::table('items as i')
            ->leftJoin('uom as u', 'i.uom_id', '=', 'u.id')
            ->leftJoin('categories as cat', 'i.category_id', '=', 'cat.id')
            ->select(
                'i.id',
                'i.name',
                'i.current_quantity',
                'u.code as uom_code'
            )
            ->where(function ($q) use ($instId) {
                $q->whereExists(function ($sub) use ($instId) {
                    $sub->select(DB::raw(1))
                        ->from('contract_items')
                        ->join('contracts', 'contract_items.contract_id', '=', 'contracts.id')
                        ->whereColumn('contract_items.item_id', 'i.id')
                        ->where('contracts.institution_id', $instId)
                        ->where('contracts.status', 'Active');
                })->orWhereExists(function ($sub) use ($instId) {
                    $sub->select(DB::raw(1))
                        ->from('order_items')
                        ->join('orders', 'order_items.order_id', '=', 'orders.id')
                        ->whereColumn('order_items.item_id', 'i.id')
                        ->where('orders.institution_id', $instId);
                });
            })
            ->orderBy('i.name')
            ->get();

        $contractData = DB::table('contract_items as ci')
            ->join('contracts as c', 'ci.contract_id', '=', 'c.id')
            ->where('c.institution_id', $instId)
            ->where('c.status', 'Active')
            ->select(
                'ci.item_id',
                'c.contract_no',
                'ci.estimated_quantity',
                'ci.unit_price'
            )
            ->get()
            ->keyBy('item_id');

        $usageData = DB::table('order_items as oi')
            ->join('orders as o', 'oi.order_id', '=', 'o.id')
            ->where('o.institution_id', $instId)
            ->whereNotIn('o.status', ['Cancelled', 'Rejected', 'Draft'])
            ->select(
                'oi.item_id',
                DB::raw('SUM(oi.ordered_quantity) as total_ordered')
            )
            ->groupBy('oi.item_id')
            ->get()
            ->keyBy('item_id');

        $hampirHabis = 0;
        $sederhana = 0;
        $banyakLagi = 0;

        foreach ($items as $item) {
            $contract = $contractData->get($item->id);
            $usage = $usageData->get($item->id);

            $item->contract_no = $contract ? $contract->contract_no : '-';
            $item->siling_kuantiti = $contract ? number_format($contract->estimated_quantity, 0) : '-';
            $item->jumlah_guna = $usage ? (float) $usage->total_ordered : 0;

            if ($contract && $contract->estimated_quantity > 0) {
                $peratus = ($item->jumlah_guna / $contract->estimated_quantity) * 100;
                $item->peratus_guna = round($peratus, 1);
                $item->baki = max(0, $contract->estimated_quantity - $item->jumlah_guna);

                if ($peratus >= 80) {
                    $item->warna_status = '#ef4444';
                    $item->status = 'Hampir Habis';
                    $hampirHabis++;
                } elseif ($peratus >= 50) {
                    $item->warna_status = '#f59e0b';
                    $item->status = 'Sederhana';
                    $sederhana++;
                } else {
                    $item->warna_status = '#22c55e';
                    $item->status = 'Banyak Lagi';
                    $banyakLagi++;
                }
            } else {
                $item->peratus_guna = 0;
                $item->baki = $item->current_quantity;
                $item->warna_status = '#6b7280';
                $item->status = 'Tiada Kontrak';
                $banyakLagi++;
            }
        }

        $totalItems = $items->count();
        $pendingApprovals = $this->pendingApprovalCount($instId);
        $pendingPenerimaan = Order::where('status', 'In Progress')->where('institution_id', $instId)->count();

        return view('user_inventori', compact(
            'items', 'totalItems', 'hampirHabis', 'sederhana', 'banyakLagi',
            'pendingApprovals', 'pendingPenerimaan'
        ));
    }
}
