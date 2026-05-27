<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Approval;
use App\Models\Institution;
use App\Models\State;
use App\Models\Supplier;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard with order statistics
     */
    public function userDashboard()
    {
        $totalOrders = Order::count();
        $pendingApprovals = $this->pendingApprovalCount();
        $inProgressOrders = Order::where('status', 'In Progress')->count();
        $completedOrders = Order::where('status', 'Completed')->count();

        return view('user_dashboard', [
            'totalOrders' => $totalOrders,
            'pendingApprovals' => $pendingApprovals,
            'inProgressOrders' => $inProgressOrders,
            'completedOrders' => $completedOrders,
        ]);
    }

    public function pengarahHQDashboard()
    {
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

    public function pengarahInstitusiDashboard(Request $request)
    {
        $institutions = Institution::orderBy('name')->get();
        $selectedInstitutionId = $request->query('institution_id') ?: Auth::user()->institution_id;
        $selectedInstitution = Institution::find($selectedInstitutionId);

        $orders = collect();
        $inventoryItems = collect();
        $suppliers = collect();

        if ($selectedInstitution) {
            $orders = Order::with(['supplier'])
                ->where('institution_id', $selectedInstitution->id)
                ->get();

            $inventoryItems = OrderItem::select('item_id', DB::raw('SUM(ordered_quantity) as total_ordered_quantity'), DB::raw('SUM(ordered_total_price) as total_ordered_price'))
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.institution_id', $selectedInstitution->id)
                ->groupBy('item_id')
                ->with('item')
                ->get();

            $suppliers = Supplier::when($selectedInstitution->state_id, function ($query, $stateId) {
                    return $query->where('state_id', $stateId);
                }, function ($query) {
                    return $query;
                })
                ->orderBy('company_name')
                ->get();
        }

        return view('pengarah_institusi_dashboard', [
            'institutions' => $institutions,
            'selectedInstitution' => $selectedInstitution,
            'orders' => $orders,
            'inventoryItems' => $inventoryItems,
            'suppliers' => $suppliers,
        ]);
    }

    public function pengarahNegeriDashboard(Request $request)
    {
        $states = State::orderBy('name')->get();
        $selectedStateId = $request->query('state_id');
        $selectedState = $selectedStateId ? State::find($selectedStateId) : null;

        $institutionIds = collect();
        $orders = collect();
        $inventoryItems = collect();
        $suppliers = collect();

        if ($selectedState) {
            $institutionIds = Institution::where('state_id', $selectedState->id)->pluck('id');

            $orders = Order::with(['institution', 'supplier'])
                ->whereIn('institution_id', $institutionIds)
                ->get();

            $inventoryItems = OrderItem::select('item_id', DB::raw('SUM(ordered_quantity) as total_ordered_quantity'), DB::raw('SUM(ordered_total_price) as total_ordered_price'))
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->whereIn('orders.institution_id', $institutionIds)
                ->groupBy('item_id')
                ->with('item')
                ->get();

            $suppliers = Supplier::where('state_id', $selectedState->id)
                ->orderBy('company_name')
                ->get();
        }

        return view('pengarah_negeri_dashboard', [
            'states' => $states,
            'selectedState' => $selectedState,
            'orders' => $orders,
            'inventoryItems' => $inventoryItems,
            'suppliers' => $suppliers,
        ]);
    }

    public function senaraiInden()
    {
        return view('senarai_inden', [
            'orders' => $this->ordersWithDetails()->get(),
            'pendingApprovals' => $this->pendingApprovalCount(),
        ]);
    }

    public function pengesahanInden()
    {
        $pendingOrders = $this->ordersWithDetails()
            ->where('orders.status', 'Pending')
            ->get();

        return view('pengesahan_inden', [
            'pendingOrders' => $pendingOrders,
            'pendingApprovals' => $this->pendingApprovalCount(),
        ]);
    }

    public function borangInden()
    {
        return $this->borangIndenView(null, false);
    }

    public function lihatBorangInden(Order $order)
    {
        return $this->borangIndenView($order, true);
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
            'no_pesanan' => ['required', 'string', 'max:100'],
            'no_kontrak' => ['required', 'string', 'max:100'],
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
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.unit' => ['required', 'string', 'max:50'],
            'items.*.orderQty' => ['required', 'numeric', 'min:0'],
            'items.*.unitPrice' => ['required', 'numeric', 'min:0'],
            'items.*.notes' => ['nullable', 'string', $maxUlasanWords],
        ], [
            'no_pesanan.required' => 'No. Pesanan wajib diisi.',
            'no_kontrak.required' => 'No. Kontrak wajib diisi.',
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
            'items.*.name.required' => 'Perihal barang wajib diisi.',
            'items.*.unit.required' => 'Unit barang wajib dipilih.',
            'items.*.orderQty.required' => 'Kuantiti pesanan wajib diisi.',
            'items.*.orderQty.numeric' => 'Kuantiti pesanan mestilah dalam bentuk nombor.',
            'items.*.orderQty.min' => 'Kuantiti pesanan tidak boleh negatif.',
            'items.*.unitPrice.required' => 'Harga seunit wajib diisi.',
            'items.*.unitPrice.numeric' => 'Harga seunit mestilah dalam bentuk nombor.',
            'items.*.unitPrice.min' => 'Harga seunit tidak boleh negatif.',
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

            $contractId = null;
            if (!empty($validated['no_kontrak'])) {
                $contractId = DB::table('contracts')->where('contract_no', $validated['no_kontrak'])->value('id')
                    ?: DB::table('contracts')->insertGetId([
                        'contract_no' => $validated['no_kontrak'],
                        'institution_id' => $institutionId,
                        'supplier_id' => $supplierId,
                        'start_date' => $validated['tarikh_pesanan'] ?? $today,
                        'total_value' => $totalAmount,
                        'status' => 'Active',
                        'created_at' => $today,
                        'created_by' => Auth::id(),
                        'updated_at' => $today,
                        'updated_by' => Auth::id(),
                    ]);
            }

            $orderId = DB::table('orders')->insertGetId([
                'order_no' => $validated['no_pesanan'] ?: 'PESAN/' . now()->format('Y') . '/' . str_pad((string) ((Order::max('id') ?? 0) + 1), 3, '0', STR_PAD_LEFT),
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

                $itemName = $item['name'] ?? '';
                $itemId = is_numeric($itemName)
                    ? DB::table('items')->where('id', $itemName)->value('id')
                    : DB::table('items')->where('name', $itemName)->value('id');

                if (!$itemId) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'items.*.name' => 'Item "' . e($itemName) . '" tidak wujud dalam pangkalan data.',
                    ]);
                }

                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'status' => 'Pending',
                    'ordered_quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'ordered_total_price' => $lineTotal,
                    'received_quantity' => 0,
                    'received_total_price' => 0,
                    'remarks' => $item['notes'] ?? null,
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

    private function ordersWithDetails()
    {
        return Order::query()
            ->leftJoin('institutions', 'orders.institution_id', '=', 'institutions.id')
            ->leftJoin('suppliers', 'orders.supplier_id', '=', 'suppliers.id')
            ->leftJoin('approvals', 'orders.id', '=', 'approvals.order_id')
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
                'name' => $row->nama_barang,
                'unit' => $row->unit ?: 'Unit',
                'orderQty' => (float) $row->kuantiti_dipesan,
                'unitPrice' => (float) $row->harga_seunit,
                'receivedQty' => 0,
                'notes' => $row->catatan_item,
            ])
            ->values();

        return view('borang_inden', [
            'indenHeader' => $indenHeader,
            'indenItems' => $indenItems,
            'readOnly' => $readOnly,
            'pendingApprovals' => $this->pendingApprovalCount(),
            'institutions' => \App\Models\Institution::orderBy('name')->get(['id', 'name']),
            'suppliers' => \App\Models\Supplier::orderBy('company_name')->get(['id', 'company_name', 'contact_person', 'address', 'postcode']),
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
            ])
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

        return view('borang_penerimaan', [
            'orders' => $orders,
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
                DB::table('order_items')
                    ->where('id', $orderItemId)
                    ->where('order_id', $orderId)
                    ->update([
                        'received_quantity' => $item['received_qty'],
                        'received_total_price' => DB::raw('received_quantity * unit_price'),
                        'remarks' => $remarks,
                        'updated_at' => $today,
                        'updated_by' => Auth::id(),
                    ]);
            }

            $order = Order::find($orderId);
            $order->update([
                'status' => 'Completed',
                'remarks' => 'Diterima pada ' . $request->received_date . ' oleh ' . $request->received_by . ($request->reference_no ? ' | Ruj: ' . $request->reference_no : '') . ($request->remarks ? ' | Catatan: ' . $request->remarks : ''),
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
}
