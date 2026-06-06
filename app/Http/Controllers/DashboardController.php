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
        $statusCounts = Order::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $pendingApprovals = $this->pendingApprovalCount();

        return view('user_dashboard', [
            'totalOrders' => (int) ($statusCounts['Pending'] ?? 0)
                + (int) ($statusCounts['In Progress'] ?? 0)
                + (int) ($statusCounts['Completed'] ?? 0)
                + (int) ($statusCounts['Draft'] ?? 0)
                + (int) ($statusCounts['Cancelled'] ?? 0)
                + (int) ($statusCounts['Rejected'] ?? 0),
            'pendingApprovals' => $pendingApprovals,
            'inProgressOrders' => (int) ($statusCounts['In Progress'] ?? 0),
            'completedOrders' => (int) ($statusCounts['Completed'] ?? 0),
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
            ->leftJoin('uom', 'items.uom_id', '=', 'uom.id')
            ->select('items.*', 'categories.name as categoryName', 'uom.code as uomCode')
            ->get()->map(function($item) {
                // Determine a safe minStock to avoid div by zero in JS
                $min = $item->monthly_limit ?: ($item->yearly_limit ? $item->yearly_limit / 12 : ($item->contract_limit ? $item->contract_limit / 12 : max(1, $item->current_quantity * 0.2)));
                
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'category' => $item->categoryName ?? 'Tiada',
                    'stock' => (float)$item->current_quantity,
                    'unit' => $item->uomCode ?? 'Unit',
                    'minStock' => (float)$min,
                    'price' => (float)$item->price_per_unit,
                    'status' => $item->status ? 'aktif' : 'tidak aktif',
                    'description' => '',
                    'lastUpdated' => date('Y-m-d')
                ];
            });

        return view('admin_dashboard', compact('institutions', 'uoms', 'totalSuppliers', 'totalInstitutions', 'totalItems', 'pendingApprovals', 'rawMaterials'));
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
                $inventoryItems = OrderItem::select('item_id', DB::raw('SUM(ordered_quantity) as total_ordered_quantity'), DB::raw('SUM(ordered_total_price) as total_ordered_price'))
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.institution_id', $selectedInstitution->id)
                    ->groupBy('item_id')
                    ->with('item')
                    ->get();
            }

            if ($activePage === 'pembekal') {
                $suppliers = Supplier::with('state')
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
                $topItems = OrderItem::select('items.name', DB::raw('SUM(ordered_quantity) as total_quantity'))
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->join('items', 'order_items.item_id', '=', 'items.id')
                    ->where('orders.institution_id', $selectedInstitution->id)
                    ->groupBy('items.id', 'items.name')
                    ->orderByDesc('total_quantity')
                    ->limit(5)
                    ->get();
                
                $dashboardData['top_items'] = [
                    'labels' => $topItems->pluck('name')->toArray(),
                    'data' => $topItems->pluck('total_quantity')->toArray(),
                ];
            }
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
            'dashboardData' => json_encode($dashboardData),
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

            if (in_array($activePage, ['dashboard', 'ringkasan'])) {
                $orders = Order::with(['institution', 'supplier'])
                    ->whereIn('institution_id', $institutionIds)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }

            if (in_array($activePage, ['dashboard', 'inventori', 'ringkasan'])) {
                $inventoryItems = OrderItem::select('item_id', DB::raw('SUM(ordered_quantity) as total_ordered_quantity'), DB::raw('SUM(ordered_total_price) as total_ordered_price'))
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->whereIn('orders.institution_id', $institutionIds)
                    ->groupBy('item_id')
                    ->with('item')
                    ->get();
            }

            if (in_array($activePage, ['dashboard', 'pembekal'])) {
                $suppliers = Supplier::with('state')
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
                $statusCounts = Order::whereIn('institution_id', $institutionIds)
                    ->select('status', DB::raw('count(*) as count'))
                    ->groupBy('status')
                    ->pluck('count', 'status')->toArray();
                
                $dashboardData['order_status'] = [
                    'Menunggu' => $statusCounts['Pending'] ?? 0,
                    'Sedang Diproses' => $statusCounts['In Progress'] ?? 0,
                    'Selesai' => $statusCounts['Completed'] ?? 0,
                    'Ditolak' => $statusCounts['Rejected'] ?? 0,
                ];

                // 2. Top 5 Items Ordered (Highest Quantity)
                $topItems = OrderItem::select('items.name', DB::raw('SUM(ordered_quantity) as total_quantity'))
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->join('items', 'order_items.item_id', '=', 'items.id')
                    ->whereIn('orders.institution_id', $institutionIds)
                    ->groupBy('items.id', 'items.name')
                    ->orderByDesc('total_quantity')
                    ->limit(5)
                    ->get();
                
                $dashboardData['top_items'] = [
                    'labels' => $topItems->pluck('name')->toArray(),
                    'data' => $topItems->pluck('total_quantity')->toArray(),
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
        ]);
    }

    public function senaraiInden()
    {
        $query = $this->ordersWithDetails();

        return view('senarai_inden', [
            'orders' => $query->get(),
            'pendingApprovals' => $this->pendingApprovalCount(),
        ]);
    }

    public function pengesahanInden()
    {
        $query = $this->ordersWithDetails()
            ->where('orders.status', 'Pending');

        return view('pengesahan_inden', [
            'pendingOrders' => $query->get(),
            'pendingApprovals' => $this->pendingApprovalCount(),
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

        $institution = DB::table('institutions')->where('id', $institutionId)->first(['code', 'location_code']);
        if (!$institution || !$institution->code) {
            return response()->json(['success' => false, 'message' => 'Institution code not found.']);
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
        $items = DB::table('contract_items as ci')
            ->join('items as i', 'ci.item_id', '=', 'i.id')
            ->leftJoin('uom as u', 'ci.uom_id', '=', 'u.id')
            ->where('ci.contract_id', $contractId)
            ->select(
                'ci.id',
                'ci.item_id',
                'i.name as item_name',
                'u.code as uom_code',
                'ci.unit_price',
                'ci.estimated_quantity'
            )
            ->get();
        return response()->json($items);
    }

    public function lihatBorangInden(Order $order)
    {
        return $this->borangIndenView($order, true);
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
                $fail('Ulasan / Catatan tidak boleh melebihi 250 patah perkataan.');
            }
        };

        $validated = $request->validate([
            'no_pesanan' => ['nullable', 'string', 'max:100'],
            'contract_id' => ['required', 'exists:contracts,id'],
            'tarikh_pesanan' => ['required', 'date'],
            'masa' => ['required', 'date_format:H:i'],
            'sesi_kod' => ['required', 'string', 'max:50'],
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
            'contract_id.required' => 'No. Kontrak wajib dipilih.',
            'tarikh_pesanan.required' => 'Tarikh Pesanan wajib diisi.',
            'masa.required' => 'Masa wajib diisi.',
            'sesi_kod.required' => 'Sesi / Kod wajib diisi.',
            'institution_id.required' => 'Institusi (Kepada) wajib dipilih.',
            'institution_id.exists' => 'Institusi yang dipilih tidak sah.',
            'supplier_id.required' => 'Pembekal wajib dipilih.',
            'supplier_id.exists' => 'Pembekal yang dipilih tidak sah.',
            'wakil_pembekal.required' => 'Nama Wakil Pembekal wajib diisi.',
            'alamat_pembekal.required' => 'Alamat Pembekal wajib diisi.',
            'muster_khas_daging.required' => 'Muster Khas (Daging) wajib diisi.',
            'muster_khas_daging.integer' => 'Muster Khas (Daging) mestilah nombor bulat.',
            'muster_khas_daging.min' => 'Muster Khas (Daging) tidak boleh negatif.',
            'muster_ditolak_parol.required' => 'Muster Ditolak Parol wajib diisi.',
            'muster_ditolak_parol.integer' => 'Muster Ditolak Parol mestilah nombor bulat.',
            'muster_ditolak_parol.min' => 'Muster Ditolak Parol tidak boleh negatif.',
            'parol.required' => 'Parol wajib diisi.',
            'parol.integer' => 'Parol mestilah nombor bulat.',
            'parol.min' => 'Parol tidak boleh negatif.',
            'muster_penuh.required' => 'Muster Penuh wajib diisi.',
            'muster_penuh.integer' => 'Muster Penuh mestilah nombor bulat.',
            'muster_penuh.min' => 'Muster Penuh tidak boleh negatif.',
            'tarikh_pembekal.required' => 'Tarikh Pembekal wajib diisi.',
            'items.required' => 'Sila tambah sekurang-kurangnya satu item pesanan.',
            'items.min' => 'Sila tambah sekurang-kurangnya satu item pesanan.',
            'items.*.orderQty.required' => 'Kuantiti pesanan wajib diisi.',
            'items.*.orderQty.numeric' => 'Kuantiti pesanan mestilah dalam bentuk nombor.',
            'items.*.orderQty.min' => 'Kuantiti pesanan tidak boleh negatif.',
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

            // Auto-generate order_no
            $categoryCode = 'BK';

            $institutionData = DB::table('institutions')->where('id', $institutionId)->first(['code', 'location_code']);
            $instCode = $institutionData->code ?? 'XXX';
            $locCode = $institutionData->location_code ?: $instCode;
            $year = (int) now()->format('Y');
            $yearShort = now()->format('y');
            $month = (int) now()->format('m');

            $seqRow = DB::table('order_sequences')
                ->where('institution_code', $instCode)
                ->where('category_code', $categoryCode)
                ->where('year', $year)
                ->where('month', $month)
                ->lockForUpdate()
                ->first();

            if ($seqRow) {
                $nextSeq = $seqRow->sequence_no + 1;
                DB::table('order_sequences')
                    ->where('id', $seqRow->id)
                    ->update(['sequence_no' => $nextSeq, 'updated_at' => now()]);
            } else {
                $nextSeq = 1;
                DB::table('order_sequences')->insert([
                    'institution_code' => $instCode,
                    'category_code' => $categoryCode,
                    'year' => $year,
                    'month' => $month,
                    'sequence_no' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $autoOrderNo = sprintf('%s/%s/%s/%s/%s/%03d', $instCode, $locCode, $categoryCode, $yearShort, str_pad((string) $month, 2, '0', STR_PAD_LEFT), $nextSeq);

            $orderId = DB::table('orders')->insertGetId([
                'order_no' => $autoOrderNo,
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
                ->firstOrFail();

            $today = now()->toDateString();

            $approval->update([
                'approved_by' => Auth::id(),
                'approval_date' => $today,
                'status' => $statusVal,
                'remarks' => $remarksVal,
                'updated_at' => $today,
                'updated_by' => Auth::id(),
            ]);

            $orderStatus = $statusVal === 1 ? 'In Progress' : 'Rejected';
            $order->update([
                'status' => $orderStatus,
                'updated_at' => $today,
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

    public static function pendingApprovalCount(): int
    {
        return Order::where('orders.status', 'Pending')
            ->where(function ($q) {
                $q->whereDoesntHave('approvals')
                  ->orWhereHas('approvals', fn ($q2) => $q2->where('status', 0));
            })
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
                    'd.special_exclusion',
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

        return view('borang_inden', [
            'indenHeader' => $indenHeader,
            'indenItems' => $indenItems,
            'readOnly' => $readOnly,
            'pendingApprovals' => $this->pendingApprovalCount(),
            'institutions' => \App\Models\Institution::orderBy('name')->get(['id', 'name', 'code', 'location_code']),
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
            ->where('orders.status', '!=', 'Completed')
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

        return view('borang_penerimaan', [
            'orders' => $orders,
            'uoms' => $uoms,
        ]);
    }

    public function getPenerimaanItems($order)
    {
        $order = Order::find($order);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak dijumpai.']);
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
            'received_date' => 'required|date',
            'received_by' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.received_qty' => 'required|numeric|min:0',
            'items.*.item_id' => 'required|integer',
        ]);

        $orderId = $request->order_id;
        $today = now()->toDateString();

        DB::transaction(function () use ($request, $orderId, $today) {
            foreach ($request->items as $orderItemId => $item) {
                $remarks = $item['remarks'] ?? null;
                if (!empty($item['is_wrong'])) {
                    $replaceName = $item['replace_name'] ?? null;
                    $replaceUnit = $item['replace_unit'] ?? null;
                    $replaceQty = $item['replace_qty'] ?? null;
                    $replacement = '';
                    if ($replaceName) {
                        $replacement = " Gantian: {$replaceName}";
                        $replacement .= $replaceUnit ? " ({$replaceUnit})" : '';
                        $replacement .= $replaceQty !== null && $replaceQty !== '' ? " x{$replaceQty}" : '';
                    }
                    $remarks = ($remarks ? $remarks . ' | ' : '') . '[SALAH]' . $replacement;
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
                    'receiver_date' => $request->received_date ?? $today,
                    'status' => 'Completed',
                    'remarks' => $deliveryRemarks,
                    'updated_at' => $today,
                    'updated_by' => Auth::id(),
                ]);
        });

        return redirect()
            ->route('borang.penerimaan')
            ->with('success', 'Penerimaan barang berjaya direkodkan.');
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
        foreach (['monthly_limit', 'yearly_limit', 'contract_limit'] as $field) {
            $value = (float) ($item->{$field} ?? 0);
            if ($value > 0) {
                return $value;
            }
        }

        return $stock > 0 ? $stock : 1;
    }

    public function saveDraft(Request $request)
    {
        $data = $request->only([
            'contract_id', 'tarikh_pesanan', 'masa', 'sesi_kod',
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
}
