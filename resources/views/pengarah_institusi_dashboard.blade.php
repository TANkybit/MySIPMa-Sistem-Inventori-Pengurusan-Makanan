@php
    $activePage = $activePage ?? 'dashboard';
    $pageTitles = [
        'dashboard' => 'Papan Pemuka',
        'ringkasan' => 'Ringkasan Pesanan',
        'institusi' => 'Inventori',
        'pembekal' => 'Pembekal',
        'senarai_user' => 'Senarai Pengguna',
        'laporan-prestasi' => 'Penilaian Prestasi Pembekal',
        'profil' => 'Profil Saya',
    ];
    $pageRoutes = [
        'dashboard' => 'pengarah.institusi.dashboard',
        'ringkasan' => 'pengarah.institusi.ringkasan',
        'institusi' => 'pengarah.institusi.institusi',
        'pembekal' => 'pengarah.institusi.pembekal',
        'senarai_user' => 'pengarah.institusi.senarai_pengguna',
        'laporan-prestasi' => 'pengarah.institusi.laporan_prestasi',
        'profil' => 'pengarah.institusi.profil',
    ];
    $pageTitle = $pageTitles[$activePage] ?? 'Papan Pemuka';
    $currentRoute = $pageRoutes[$activePage] ?? 'pengarah.institusi.dashboard';
    $institutionQuery = request()->only('institution_id');
@endphp

<!DOCTYPE html>
<html lang="ms" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} Pengarah Institusi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="session-lifetime" content="{{ config('session.lifetime') }}">
    <meta name="session-warning" content="{{ config('session-timeout.warning_time') }}">
    <meta name="session-grace" content="{{ config('session-timeout.grace_period') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
    <div class="wrapper">
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('pengarah.institusi.dashboard') }}" class="logo">
                    <div class="logo-icon">
                        <img src="{{ asset('MySIPMa_logo_wWalls.png') }}" alt="MySIPMa Logo" height="50" class="me-2">
                    </div>
                    <div class="logo-text">
                        <span class="fw-bold">MySIPMA</span>
                        <small>Pengarah Institusi</small>
                    </div>
                </a>
                <button class="sidebar-toggle d-lg-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="sidebar-menu">
                <ul class="nav flex-column">
                    <li class="nav-title">UTAMA</li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.institusi.dashboard') ? 'active' : '' }}" href="{{ route('pengarah.institusi.dashboard', $institutionQuery) }}">
                            <i class="fas fa-home"></i>
                            <span>Papan Pemuka</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">PENGURUSAN DATA</li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.institusi.ringkasan') ? 'active' : '' }}" href="{{ route('pengarah.institusi.ringkasan') }}">
                            <i class="fas fa-file-invoice"></i>
                            <span>Ringkasan Pesanan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.institusi.institusi') ? 'active' : '' }}" href="{{ route('pengarah.institusi.institusi') }}">
                            <i class="fas fa-boxes"></i>
                            <span>Inventori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.institusi.pembekal') ? 'active' : '' }}" href="{{ route('pengarah.institusi.pembekal') }}">
                            <i class="fas fa-truck"></i>
                            <span>Pembekal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.institusi.senarai_pengguna') ? 'active' : '' }}" href="{{ route('pengarah.institusi.senarai_pengguna') }}">
                            <i class="fas fa-users"></i>
                            <span>Senarai Pengguna</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">LAPORAN</li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.institusi.laporan_prestasi') ? 'active' : '' }}" href="{{ route('pengarah.institusi.laporan_prestasi') }}">
                            <i class="fas fa-star"></i>
                            <span>Penilaian Prestasi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.institusi.profil') ? 'active' : '' }}" href="{{ route('pengarah.institusi.profil') }}">
                            <i class="fas fa-user"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->name ?? 'Pengarah Institusi') }}&background=1a5632&color=fff&size=80" alt="{{ auth()->user()?->name ?? 'Pengarah Institusi' }}" class="user-avatar">
                    <div class="user-info">
                        <h6>{{ auth()->user()?->name ?? 'Pengarah Institusi' }}</h6>
                        <small class="text-muted">Pengarah Institusi</small>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-icon text-danger" title="Log Keluar">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <header class="header">
                <div class="header-left">
                    <button class="sidebar-toggle d-lg-none" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-title">
                        <h1>{{ $pageTitle }}</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('pengarah.institusi.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item">Pengarah Institusi</li>
                                <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="header-right">
                    <!-- Notifications -->
                    <div class="dropdown notifications me-3">
                        <button class="btn btn-icon icon-bell position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell text-body"></i>
                            @if(isset($pendingEvaluations) && $pendingEvaluations->count() > 0)
                                <span class="badge-notification bg-danger rounded-circle position-absolute" style="top: 2px; right: 2px; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center; color: white;">{{ $pendingEvaluations->count() }}</span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0" style="width: 320px;">
                            <div class="dropdown-header d-flex justify-content-between align-items-center py-2 px-3 border-bottom">
                                <h6 class="mb-0 fw-bold">Pemberitahuan</h6>
                                <span class="text-muted small">{{ isset($pendingEvaluations) ? $pendingEvaluations->count() : 0 }} tugasan</span>
                            </div>
                            <div class="dropdown-body py-0" style="max-height: 250px; overflow-y: auto;">
                                @if(isset($pendingEvaluations) && $pendingEvaluations->count() > 0)
                                    @foreach($pendingEvaluations as $pendingEval)
                                        <a href="{{ route('pengarah.institusi.laporan_prestasi') }}#pending-section" class="dropdown-item py-2 px-3 border-bottom d-flex align-items-start gap-2 text-wrap">
                                            <div class="notification-icon bg-warning text-white rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                                <i class="fas fa-file-signature" style="font-size: 13px;"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-0 small text-body text-truncate" style="max-width: 240px;">
                                                    Penilaian bagi pembekal <strong>{{ $pendingEval->supplier?->company_name }}</strong> (No. Inden: {{ $pendingEval->order?->order_number }}) memerlukan pengesahan anda.
                                                </p>
                                                <small class="text-muted" style="font-size: 10px;">{{ $pendingEval->created_at->diffForHumans() }}</small>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="p-3 text-center text-muted small">
                                        <i class="fas fa-check-circle text-success mb-2 d-block" style="font-size: 24px;"></i>
                                        Tiada pengesahan penilaian yang belum selesai.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="search-box me-3 position-relative">
                        <input type="text" id="globalSearchInput" data-context="institusi" data-filter-id="{{ optional($selectedInstitution)->id }}" class="form-control" placeholder="Cari Maklumat...">
                        <i class="fas fa-search"></i>
                        <div id="globalSearchResults" class="global-search-dropdown d-none"></div>
                    </div>
                    <button class="btn btn-icon" id="themeToggle">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </header>

            <div class="content-body">
                <div class="container-fluid py-4">
                    @if($activePage === 'dashboard')
                    {{-- Form Tapis disembunyikan dalam komen mengikut kehendak pengguna --}}
                    {{--
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" action="{{ route($currentRoute) }}" class="row g-3 align-items-end">
                                        <div class="col-lg-6 col-md-8">
                                            <label for="institution_id" class="form-label">Pilih Institusi</label>
                                            <select id="institution_id" name="institution_id" class="form-select">
                                                <option value="">Pilih institusi</option>
                                                @foreach($institutions as $institution)
                                                    <option value="{{ $institution->id }}" {{ optional($selectedInstitution)->id == $institution->id ? 'selected' : '' }}>
                                                        {{ $institution->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-4">
                                            <button type="submit" class="btn btn-primary w-100">Tapis</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    --}}

                    @include('partials.low_stock_notification', [
                        'lowStockItems' => $lowStockItems ?? collect(),
                        'inventoryUrl' => route('pengarah.institusi.institusi'),
                    ])

                    <div class="row g-3 mb-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4 h-100">
                                <h6 class="text-uppercase text-muted mb-3">Institusi Terpilih</h6>
                                <h3 class="mb-0">{{ optional($selectedInstitution)->name ?? 'Tiada institusi dipilih' }}</h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4 h-100">
                                <h6 class="text-uppercase text-muted mb-3">Jumlah Pesanan</h6>
                                <h3 class="mb-0">{{ $orders->count() }}</h3>
                                <div class="small text-muted mt-2">Jumlah Item: <strong>{{ number_format($inventoryTotals['total_quantity'] ?? 0, 2) }}</strong> &nbsp;•&nbsp; Nilai: <strong>RM {{ number_format($inventoryTotals['total_value'] ?? 0, 2) }}</strong></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4 h-100">
                                <h6 class="text-uppercase text-muted mb-3">Jumlah Pembekal</h6>
                                <h3 class="mb-0">{{ $suppliers->count() }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <div class="card p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted mb-1">Stok Kritikal</h6>
                                        <h4 id="criticalStockCount" class="mb-0">—</h4>
                                        <small class="text-muted">Item yang mencecah atau di bawah minimum</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-warning" id="btnViewCriticalStock"><i class="fas fa-triangle-exclamation me-2"></i>Lihat</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($activePage === 'dashboard')
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex gap-2 align-items-center">
                                    <label class="mb-0 small text-muted">Tahun:</label>
                                    <select id="chartFilterYear" class="form-select form-select-sm" style="width:120px;">
                                        <option value="">Semua</option>
                                    </select>

                                    <label class="mb-0 small text-muted ms-3">Bulan:</label>
                                    <select id="chartFilterMonth" class="form-select form-select-sm" style="width:140px;">
                                        <option value="">Semua</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Mac</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Jun</option>
                                        <option value="7">Julai</option>
                                        <option value="8">Ogos</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Disember</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Order Status Chart -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header border-0 pt-4 pb-0">
                                        <h5 class="card-title fw-bold mb-0">Status Pesanan Keseluruhan</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="orderStatusChart" style="max-height: 300px;"></canvas>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Top Items Table -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-header bg-transparent border-0 pb-2 pt-4 px-4">
                                        <h5 class="card-title fw-bold mb-0"><i class="fas fa-boxes text-info me-2"></i>5 Item Terbanyak Dipesan</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0" id="topItemsTable">
                                                <thead>
                                                    <tr>
                                                        <th class="ps-4">No.</th>
                                                        <th>Nama Item</th>
                                                        <th class="text-end pe-4">Kuantiti</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td colspan="3" class="text-center py-4 text-muted">Memuatkan...</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Recent Orders -->
                            <div class="col-12 mb-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pb-2 pt-4 px-4">
                                        <h5 class="card-title fw-bold mb-0"><i class="fas fa-clock text-warning me-2"></i>5 Pesanan Terkini</h5>
                                        <a href="{{ route('pengarah.institusi.ringkasan') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0" id="recentOrdersTable">
                                                <thead>
                                                    <tr>
                                                        <th class="ps-4">No.</th>
                                                        <th>No. Pesanan</th>
                                                        <th>Tarikh</th>
                                                        <th>Jumlah (RM)</th>
                                                        <th>Status</th>
                                                        <th>Pembekal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td colspan="6" class="text-center py-4 text-muted">Memuatkan...</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data carta dihantar terus ke JavaScript -->
                        <script>window.dashboardChartData = {!! $dashboardData ?? '{}' !!};</script>

                    @elseif($activePage === 'ringkasan')
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Ringkasan Pesanan</h5>
                                <p class="text-muted">Lihat semua pesanan untuk institusi terpilih.</p>
                                <div class="table-responsive">
                                    <table id="orders-table" class="table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>ID Pesanan</th>
                                                <th>No Pesanan</th>
                                                <th>Tarikh</th>
                                                <th>Jumlah</th>
                                                <th>Status</th>
                                                <th>Pembekal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->order_no }}</td>
                                                    <td>{{ $order->order_date }}</td>
                                                    <td>{{ number_format($order->total_amount, 2) }}</td>
                                                    <td>
                                                        @php
                                                            $statusMalay = match($order->status) {
                                                                'Pending' => 'Menunggu',
                                                                'In Progress' => 'Dalam Proses',
                                                                'Completed' => 'Selesai',
                                                                'Rejected' => 'Ditolak',
                                                                default => $order->status
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $order->status == 'Pending' ? 'bg-warning' : ($order->status == 'In Progress' ? 'bg-primary' : ($order->status == 'Completed' ? 'bg-success' : 'bg-danger')) }}">
                                                            {{ $statusMalay }}
                                                        </span>
                                                    </td>
                                                    <td>{{ optional($order->supplier)->company_name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @elseif($activePage === 'institusi')
                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div>
                                                <h5 class="card-title mb-0">Inventori Pesanan</h5>
                                                <p class="text-muted small mb-0">Lihat ringkasan item yang dipesan untuk institusi terpilih.</p>
                                            </div>
                                            <form id="inventoryFilterForm" method="GET" action="{{ route('pengarah.institusi.institusi') }}" class="d-flex gap-2 align-items-center">
                                                <label class="mb-0 small text-muted">Tahun:</label>
                                                <select name="year" id="inventoryFilterYear" class="form-select form-select-sm" style="width:120px;">
                                                    <option value="">Semua</option>
                                                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                                    @endfor
                                                </select>

                                                <label class="mb-0 small text-muted ms-2">Bulan:</label>
                                                <select name="month" id="inventoryFilterMonth" class="form-select form-select-sm" style="width:140px;">
                                                    <option value="">Semua</option>
                                                    @foreach([1=>'Jan',2=>'Feb',3=>'Mac',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Ogo',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Dis'] as $m => $label)
                                                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="" />
                                            </form>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="inventory-table" class="table table-bordered table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px;">Bil</th>
                                                        <th>Nama Item</th>
                                                        <th>Jumlah Dipesan</th>
                                                        <th>Jumlah Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($inventoryItems as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ optional($item->item)->name ?? 'Item tidak dijumpai' }}</td>
                                                            <td>{{ number_format($item->total_ordered_quantity, 2) }}</td>
                                                            <td>{{ number_format($item->total_ordered_price, 2) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="4" class="text-center text-muted py-4">Tiada data inventori untuk tempoh dipilih.</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="text-uppercase text-muted">Stok Kritikal</h6>
                                        <p class="small text-muted">5 item yang berada di bawah atau hampir minimum stok.</p>
                                        <div class="list-group list-group-flush small" id="institusi-critical-list">
                                            @forelse($lowStockItems->take(5) as $l)
                                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <div class="fw-medium">{{ $l['name'] }}</div>
                                                        <div class="text-muted small">{{ $l['category'] ?? '-' }}</div>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold">{{ $l['stock'] }}</div>
                                                        <div class="text-muted small">Min: {{ $l['minStock'] }}</div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="list-group-item text-center text-muted">Tiada item kritikal.</div>
                                            @endforelse
                                        </div>
                                        <div class="mt-3 text-end">
                                            <button class="btn btn-sm btn-outline-warning" id="btnViewCriticalFromInstitusi"><i class="fas fa-eye me-1"></i>Lihat Semua</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($activePage === 'pembekal')
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Senarai Pembekal</h5>
                                <p class="text-muted">Lihat pembekal yang berkaitan dengan institusi terpilih.</p>
                                <div class="table-responsive">
                                    <table id="suppliers-table" class="table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Syarikat</th>
                                                <th>Pegawai Dihubungi</th>
                                                <th>E-mel</th>
                                                <th>Negeri</th>
                                                <th>Sumber</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($suppliers as $supplier)
                                                <tr>
                                                    <td>{{ $supplier->id }}</td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="supplier-detail-btn fw-bold text-primary text-decoration-none" 
                                                           data-company="{{ $supplier->company_name }}"
                                                           data-contact="{{ $supplier->contact_person }}"
                                                           data-email="{{ $supplier->email }}"
                                                           data-phone="{{ $supplier->phone_number }}"
                                                           data-address="{{ $supplier->address }}"
                                                           data-postcode="{{ $supplier->postcode }}"
                                                           data-state="{{ optional($supplier->state)->name }}"
                                                           data-source="{{ $supplier->createdBy?->effectiveRoleName() === 'Admin' ? 'HQ' : 'Institusi' }}">
                                                            <i class="fas fa-building me-1"></i> {{ $supplier->company_name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $supplier->contact_person }}</td>
                                                    <td>{{ $supplier->email }}</td>
                                                    <td>{{ optional($supplier->state)->name }}</td>
                                                    <td>
                                                        @if($supplier->createdBy?->effectiveRoleName() === 'Admin')
                                                            <span class="badge bg-primary">HQ</span>
                                                        @else
                                                            <span class="badge bg-secondary">Institusi</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @elseif($activePage === 'senarai_user')
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Senarai Pengguna</h5>
                                <p class="text-muted">Lihat semua pengguna untuk institusi terpilih (Paparan sahaja).</p>
                                <div class="table-responsive">
                                    <table id="users-table" class="table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;">Bil</th>
                                                <th>Nama</th>
                                                <th>E-mel</th>
                                                <th>No. Telefon</th>
                                                <th>Jawatan / Peranan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone_number }}</td>
                                                    <td>
                                                        {{ optional($user->position)->name ?? '-' }} 
                                                        <br>
                                                        <small class="text-muted">Peranan: {{ $user->effectiveRoleName() }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @elseif($activePage === 'profil')
                        <div class="row justify-content-center">
                            <div class="col-lg-5 mb-4">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <div class="position-relative d-inline-block mb-3">
                                            <img src="{{ auth()->user()?->image ? asset('storage/' . auth()->user()->image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()?->name ?? 'Pengarah Institusi') . '&background=1a5632&color=fff&size=150' }}"
                                                alt="Profile Picture"
                                                class="rounded-circle img-thumbnail"
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                        <h4 class="mb-0">{{ auth()->user()?->name ?? 'Pengarah Institusi' }}</h4>
                                        <p class="text-muted">{{ auth()->user()?->position?->name ?? 'Pengarah Institusi' }}</p>
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-primary" id="btnEditProfile">
                                                <i class="fas fa-edit me-2"></i>Kemaskini Profil
                                            </button>
                                            <button class="btn btn-warning btn-sm" id="btnChangePassword">
                                                <i class="fas fa-key me-2"></i>Tukar Kata Laluan
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-0 pb-4">
                                        <div class="row text-center mb-3">
                                            <div class="col-6 border-end">
                                                <h5 class="mb-0">{{ auth()->user()?->status ? 'Aktif' : 'Tidak Aktif' }}</h5>
                                                <small class="text-muted">Status</small>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="mb-0">{{ auth()->user()?->effectiveRoleName() }}</h5>
                                                <small class="text-muted">Peranan</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Maklumat Peribadi</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-envelope me-2 text-primary"></i>E-mel</span>
                                                <span class="fw-medium">{{ auth()->user()?->email ?? '-' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-phone me-2 text-primary"></i>No. Telefon</span>
                                                <span class="fw-medium">{{ auth()->user()?->phone_number ?? '-' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-building me-2 text-primary"></i>Institusi</span>
                                                <span class="fw-medium">{{ auth()->user()?->institution?->name ?? '-' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-briefcase me-2 text-primary"></i>Jawatan</span>
                                                <span class="fw-medium">{{ auth()->user()?->position?->name ?? '-' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-calendar-alt me-2 text-primary"></i>Tarikh Sertai</span>
                                                <span class="fw-medium">{{ auth()->user()?->created_at ? \Carbon\Carbon::parse(auth()->user()->created_at)->format('d/m/Y') : '-' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-10">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="card mb-4" id="cardUpdateProfile" style="display: none;">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Kemaskini Maklumat Profil</h5>
                                        <button class="btn btn-sm btn-link text-decoration-none" id="btnCancelEdit">Batal</button>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('profile.update') }}" method="POST">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nama Penuh</label>
                                                    <input type="text" class="form-control" name="name" value="{{ auth()->user()?->name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">E-mel</label>
                                                    <input type="email" class="form-control" name="email" value="{{ auth()->user()?->email }}" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">No. Telefon</label>
                                                    <input type="text" class="form-control" name="phone_number" value="{{ auth()->user()?->phone_number }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Institusi</label>
                                                    <select class="form-select" name="institution_id">
                                                        <option value="">Pilih Institusi</option>
                                                        @foreach($institutions as $institution)
                                                            <option value="{{ $institution->id }}" {{ auth()->user()?->institution_id == $institution->id ? 'selected' : '' }}>
                                                                {{ $institution->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="card mb-4" id="cardChangePassword" style="display: none;">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0"><i class="fas fa-key me-2 text-warning"></i>Tukar Kata Laluan</h5>
                                        <button class="btn btn-sm btn-link text-decoration-none" id="btnCancelPassword">Batal</button>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('profile.password') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Kata Laluan Semasa</label>
                                                <input type="password" class="form-control" name="current_password" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Kata Laluan Baru</label>
                                                <input type="password" class="form-control" name="password" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Sahkan Kata Laluan Baru</label>
                                                <input type="password" class="form-control" name="password_confirmation" required>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-shield-alt me-2"></i>Kemaskini Kata Laluan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($activePage === 'laporan-prestasi')
                        <div class="row">
                            <div class="col-12">
                                <!-- Section 1: Pending Evaluations for Verification -->
                                <div class="card border-0 shadow-sm mb-4" id="pending-section">
                                    <div class="card-header bg-warning text-dark py-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title mb-0 fw-bold"><i class="fas fa-exclamation-circle me-1"></i>Penilaian Menunggu Pengesahan</h5>
                                            <p class="mb-0 small text-dark opacity-100 fw-medium">Sila semak dan sahkan penilaian berikut untuk dipaparkan kepada Pengarah HQ & Negeri.</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle border-top" id="pending-evaluations-table">
                                                <thead>
                                                    <tr>
                                                        <th>Tarikh</th>
                                                        <th>No. Inden</th>
                                                        <th>Pembekal</th>
                                                        <th>Penilai</th>
                                                        <th class="text-center">Skor (%)</th>
                                                        <th class="text-center">Rating</th>
                                                        <th class="text-center">Tindakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($pendingEvaluations) && $pendingEvaluations->count() > 0)
                                                        @foreach($pendingEvaluations as $pendingEval)
                                                            <tr>
                                                                <td>{{ $pendingEval->evaluation_date->format('d/m/Y') }}</td>
                                                                <td>{{ $pendingEval->order?->order_number }}</td>
                                                                <td>{{ $pendingEval->supplier?->company_name }}</td>
                                                                <td>{{ $pendingEval->evaluator_name }}</td>
                                                                <td class="text-center fw-bold">{{ round($pendingEval->percentage, 1) }}%</td>
                                                                <td class="text-center">
                                                                    @if($pendingEval->performance_rating === 'Cemerlang')
                                                                        <span class="badge bg-success">Cemerlang</span>
                                                                    @elseif($pendingEval->performance_rating === 'Sederhana')
                                                                        <span class="badge bg-warning text-dark">Sederhana</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Lemah</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="d-flex justify-content-center gap-2">
                                                                        <button class="btn btn-sm btn-info text-white view-eval-btn" data-id="{{ $pendingEval->id }}">
                                                                            <i class="fas fa-eye"></i> Semak
                                                                        </button>
                                                                        <button class="btn btn-sm btn-success verify-eval-btn" data-id="{{ $pendingEval->id }}">
                                                                            <i class="fas fa-check"></i> Sahkan
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" class="text-center py-4 text-muted">
                                                                Tiada rekod penilaian menunggu pengesahan.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: Monthly performance data table view for trend analysis -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title mb-0 fw-bold text-body">Jadual Prestasi Bulanan Pembekal</h5>
                                            <p class="text-muted small mb-0">Analisis purata pemarkahan (%) bulanan pembekal bagi tahun terpilih</p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-body">
                                            <select class="form-select text-semibold" id="monthlyYearSelect" style="width: 120px;">
                                                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                                    <option value="{{ $y }}">{{ $y }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover align-middle text-center text-body" id="monthly-stats-table">
                                                <thead class="bg-light text-body">
                                                    <tr>
                                                        <th class="text-start">Pembekal</th>
                                                        <th>Purata Tahunan</th>
                                                        <th>Rating Tahunan</th>
                                                        <th>Jan</th>
                                                        <th>Feb</th>
                                                        <th>Mac</th>
                                                        <th>Apr</th>
                                                        <th>Mei</th>
                                                        <th>Jun</th>
                                                        <th>Jul</th>
                                                        <th>Ogos</th>
                                                        <th>Sept</th>
                                                        <th>Okt</th>
                                                        <th>Nov</th>
                                                        <th>Dis</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="monthlyStatsTableBody" class="text-body">
                                                    <tr>
                                                        <td colspan="15" class="py-4 text-muted">
                                                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                                            Memuat data bulanan...
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 3: Performance Evaluations List -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title mb-0 fw-bold text-body">Sejarah Penilaian Prestasi</h5>
                                            <p class="text-muted small mb-0">Semua rekod penilaian prestasi bagi institusi anda</p>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary btn-sm shadow-sm" id="btnTambahPenilaian">
                                                <i class="fas fa-plus me-1"></i>Tambah Penilaian
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle border-top text-body" id="evaluations-history-table">
                                                <thead>
                                                    <tr>
                                                        <th>Tarikh</th>
                                                        <th>No. Inden</th>
                                                        <th>Pembekal</th>
                                                        <th>Penilai</th>
                                                        <th class="text-center">Skor (%)</th>
                                                        <th class="text-center">Rating</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Tindakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="historyTableBody" class="text-body">
                                                    <tr>
                                                        <td colspan="8" class="text-center py-4 text-muted">
                                                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                                            Memuat data sejarah penilaian...
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Add Evaluation Modal -->
            <div class="modal fade" id="addEvaluationModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title"><i class="fas fa-star me-2"></i>Penilaian Prestasi Pembekal (BK-PSPK-09-03)</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="evaluationForm">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">No. Inden / Pesanan</label>
                                        <select class="form-select" name="order_id" id="evalOrderId" required>
                                            <option value="">Pilih Pesanan</option>
                                            <!-- Populated by JS -->
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Tarikh Penilaian</label>
                                        <input type="date" class="form-control" name="evaluation_date" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                
                                <div id="evalSupplierInfo" class="alert alert-info border-0 shadow-sm d-none mb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="small text-muted">Pembekal:</div>
                                            <div id="evalSupplierName" class="fw-bold fs-6">-</div>
                                            <input type="hidden" name="supplier_id" id="evalSupplierId">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="small text-muted">Institusi:</div>
                                            <div id="evalInstitutionName" class="fw-bold fs-6">-</div>
                                            <input type="hidden" name="institution_id" id="evalInstitutionId">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="small text-muted">Nama Penilai:</div>
                                            <input type="text" class="form-control form-control-sm mt-1" name="evaluator_name" value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle text-center overflow-hidden" style="border-radius: 8px;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 50%" class="text-start py-3 ps-3">Kriteria Penilaian</th>
                                                <th style="width: 50%" class="py-3">Skala (1 - 7)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-start ps-3">
                                                    <div class="fw-bold">1. Kuantiti Bekalan</div>
                                                    <div class="small text-muted">Mencukupi dan mengikut pesanan</div>
                                                </td>
                                                <td>
                                                    <div class="px-3">
                                                        <input type="range" class="form-range slider-score" min="1" max="7" step="1" name="criteria_quantity" value="4">
                                                        <div class="fw-bold score-display text-success fs-5">4</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-start ps-3">
                                                    <div class="fw-bold">2. Masa Penghantaran</div>
                                                    <div class="small text-muted">Menepati masa yang ditetapkan</div>
                                                </td>
                                                <td>
                                                    <div class="px-3">
                                                        <input type="range" class="form-range slider-score" min="1" max="7" step="1" name="criteria_delivery" value="4">
                                                        <div class="fw-bold score-display text-success fs-5">4</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-start ps-3">
                                                    <div class="fw-bold">3. Harga Bekalan</div>
                                                    <div class="small text-muted">Berpatutan dan kompetitif</div>
                                                </td>
                                                <td>
                                                    <div class="px-3">
                                                        <input type="range" class="form-range slider-score" min="1" max="7" step="1" name="criteria_price" value="4">
                                                        <div class="fw-bold score-display text-success fs-5">4</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-start ps-3">
                                                    <div class="fw-bold">4. Kualiti Bekalan</div>
                                                    <div class="small text-muted">Bahan mentah segar dan berkualiti</div>
                                                </td>
                                                <td>
                                                    <div class="px-3">
                                                        <input type="range" class="form-range slider-score" min="1" max="7" step="1" name="criteria_quality" value="4">
                                                        <div class="fw-bold score-display text-success fs-5">4</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-start ps-3">
                                                    <div class="fw-bold">5. Kerjasama</div>
                                                    <div class="small text-muted">Responsif dan mudah dihubungi</div>
                                                </td>
                                                <td>
                                                    <div class="px-3">
                                                        <input type="range" class="form-range slider-score" min="1" max="7" step="1" name="criteria_cooperation" value="4">
                                                        <div class="fw-bold score-display text-success fs-5">4</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mt-4 align-items-center">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="card border-0 shadow-sm" style="background-color: #f8f9fa;">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Jumlah Skor:</span>
                                                    <span class="fw-bold fs-5" id="evalTotalScore">20 / 35</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted">Peratus:</span>
                                                    <span class="fw-bold fs-4 text-primary" id="evalPercentage">57.1%</span>
                                                </div>
                                                <div class="mt-3 text-center">
                                                    <span class="badge rounded-pill px-4 py-2 fs-6 shadow-sm" id="evalRatingBadge" style="background-color: #ffc107; color: #000;">SEDERHANA</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted mb-1">Pegawai Penilai:</label>
                                        <input type="text" class="form-control mb-3 bg-light" name="evaluator_name" value="{{ Auth::user()->name }}" readonly>
                                        
                                        <label class="form-label fw-bold small text-muted mb-1">Ulasan / Catatan:</label>
                                        <textarea class="form-control" name="remarks" rows="2" placeholder="Masukkan ulasan tambahan jika perlu..."></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success px-4 shadow-sm" id="saveEvaluationBtn">
                                <i class="fas fa-save me-2"></i>Simpan Penilaian
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Critical Stock Modal -->
            <div class="modal fade" id="criticalStockModal" tabindex="-1" aria-labelledby="criticalStockModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="criticalStockModalLabel"><i class="fas fa-triangle-exclamation me-2"></i>Stok Kritikal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="criticalStockTable">
                                    <thead>
                                        <tr>
                                            <th>Bil</th>
                                            <th>Nama Item</th>
                                            <th>Kategori</th>
                                            <th>Stok</th>
                                            <th>Minimum</th>
                                            <th>Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Supplier Detail Modal -->
            <div class="modal fade" id="supplierDetailModal" tabindex="-1" aria-labelledby="supplierDetailModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="supplierDetailModalLabel"><i class="fas fa-truck me-2"></i>Maklumat Pembekal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-borderless table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <th style="width:40%;">Nama Syarikat</th>
                                        <td>: <span id="modal_supplier_name" class="fw-medium"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Pegawai Dihubungi</th>
                                        <td>: <span id="modal_supplier_contact"></span></td>
                                    </tr>
                                    <tr>
                                        <th>E-mel</th>
                                        <td>: <span id="modal_supplier_email"></span></td>
                                    </tr>
                                    <tr>
                                        <th>No. Telefon</th>
                                        <td>: <span id="modal_supplier_phone"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>: <span id="modal_supplier_address"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Poskod</th>
                                        <td>: <span id="modal_supplier_postcode"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Negeri</th>
                                        <td>: <span id="modal_supplier_state"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Sumber</th>
                                        <td>: <span id="modal_supplier_source"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">&copy; 2026 <strong>Sistem Inventori Dan Pengurusan Makanan</strong>. Hak cipta terpelihara.</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-0">Versi 2.2.0 | Dikemaskini: 17 Feb 2026 | <span id="server-status" class="text-success"><i class="fas fa-circle"></i> Server Aktif</span></p>
                        </div>
                    </div>
                    <div class="row mt-2 border-top pt-2">
                        <div class="col-12 text-center">
                            <p class="text-muted small mb-0">Jabatan Penjara Malaysia tidak bertanggungjawab terhadap sebarang kehilangan atau kerosakan yang dialami kerana menggunakan maklumat yang dicapai dalam laman ini.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        @if($activePage === 'laporan-prestasi')
        // Sliders score color scaling and calculation
        function initEvaluationSliders() {
            const sliders = document.querySelectorAll('#addEvaluationModal .slider-score');
            sliders.forEach(slider => {
                slider.addEventListener('input', () => {
                    const display = slider.nextElementSibling;
                    display.textContent = slider.value;
                    
                    if (slider.value >= 6) display.className = 'fw-bold score-display text-success fs-5';
                    else if (slider.value >= 4) display.className = 'fw-bold score-display text-warning fs-5';
                    else display.className = 'fw-bold score-display text-danger fs-5';
                    
                    calculateScore();
                });
            });
        }

        function calculateScore() {
            const qtyInputs = document.querySelectorAll('input[name="criteria_quantity"]');
            const delInputs = document.querySelectorAll('input[name="criteria_delivery"]');
            const priInputs = document.querySelectorAll('input[name="criteria_price"]');
            const qltyInputs = document.querySelectorAll('input[name="criteria_quality"]');
            const coopInputs = document.querySelectorAll('input[name="criteria_cooperation"]');
            
            if (!qtyInputs.length) return;
            const qty = parseInt(qtyInputs[0].value);
            const del = parseInt(delInputs[0].value);
            const pri = parseInt(priInputs[0].value);
            const qlty = parseInt(qltyInputs[0].value);
            const coop = parseInt(coopInputs[0].value);
            
            const total = qty + del + pri + qlty + coop;
            const percentage = ((total / 35) * 100).toFixed(1);
            
            document.getElementById('evalTotalScore').textContent = `${total} / 35`;
            document.getElementById('evalPercentage').textContent = `${percentage}%`;
            
            const badge = document.getElementById('evalRatingBadge');
            if (percentage >= 81) {
                badge.textContent = 'CEMERLANG';
                badge.style.backgroundColor = '#1a5632';
                badge.style.color = '#fff';
            } else if (percentage >= 51) {
                badge.textContent = 'SEDERHANA';
                badge.style.backgroundColor = '#ffc107';
                badge.style.color = '#000';
            } else {
                badge.textContent = 'LEMAH';
                badge.style.backgroundColor = '#dc3545';
                badge.style.color = '#fff';
            }
        }

        // Load orders for selection in Add Evaluation modal
        async function loadOrdersForEvaluation() {
            try {
                const res = await fetch('/evaluations/orders');
                const json = await res.json();
                if (json.success) {
                    const select = document.getElementById('evalOrderId');
                    select.innerHTML = '<option value="">Pilih Pesanan</option>';
                    
                    window.evaluationOrders = json.data;
                    
                    json.data.forEach(order => {
                        const opt = document.createElement('option');
                        opt.value = order.id;
                        opt.textContent = `${order.order_number} (${order.order_date})`;
                        select.appendChild(opt);
                    });
                }
            } catch (err) {
                console.error('Error loading orders:', err);
            }
        }

        // Load monthly stats trend table
        async function loadMonthlyStats(year) {
            const tableBody = document.getElementById('monthlyStatsTableBody');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="15" class="py-4 text-muted">
                        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                        Memproses analisis bulanan...
                    </td>
                </tr>
            `;
            
            try {
                const res = await fetch(`/evaluations/monthly?year=${year}`);
                const json = await res.json();
                
                if (json.success && json.data.length > 0) {
                    let html = '';
                    json.data.forEach(item => {
                        let ratingBadge = '-';
                        if (item.rating === 'Cemerlang') {
                            ratingBadge = '<span class="badge bg-success">Cemerlang</span>';
                        } else if (item.rating === 'Sederhana') {
                            ratingBadge = '<span class="badge bg-warning text-dark">Sederhana</span>';
                        } else if (item.rating === 'Lemah') {
                            ratingBadge = '<span class="badge bg-danger">Lemah</span>';
                        }
                        
                        html += `<tr>
                            <td class="text-start fw-bold">${item.supplier_name}</td>
                            <td class="fw-bold">${item.average !== null ? item.average + '%' : '-'}</td>
                            <td>${ratingBadge}</td>
                        `;
                        
                        for (let m = 1; m <= 12; m++) {
                            const val = item.monthly[m];
                            if (val !== null) {
                                let textClass = 'text-muted';
                                if (val >= 81) textClass = 'text-success fw-bold';
                                else if (val >= 51) textClass = 'text-warning fw-bold';
                                else textClass = 'text-danger fw-bold';
                                
                                html += `<td class="${textClass}">${val}%</td>`;
                            } else {
                                html += `<td>-</td>`;
                            }
                        }
                        html += '</tr>';
                    });
                    tableBody.innerHTML = html;
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="15" class="py-4 text-muted">
                                Tiada rekod data penilaian bagi tahun ${year}.
                            </td>
                        </tr>
                    `;
                }
            } catch (err) {
                console.error('Error loading monthly stats:', err);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="15" class="py-4 text-danger">
                            Gagal memuatkan rekod data bulanan.
                        </td>
                    </tr>
                `;
            }
        }

        // Load History Table
        async function loadEvaluationsHistory() {
            const tableBody = document.getElementById('historyTableBody');
            try {
                const res = await fetch('/evaluations');
                const json = await res.json();
                
                if (json.success && json.data.length > 0) {
                    let html = '';
                    json.data.forEach(eval => {
                        const evalDate = new Date(eval.evaluation_date).toLocaleDateString('ms-MY', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        
                        let ratingBadge = '';
                        if (eval.performance_rating === 'Cemerlang') {
                            ratingBadge = '<span class="badge bg-success">Cemerlang</span>';
                        } else if (eval.performance_rating === 'Sederhana') {
                            ratingBadge = '<span class="badge bg-warning text-dark">Sederhana</span>';
                        } else {
                            ratingBadge = '<span class="badge bg-danger">Lemah</span>';
                        }
                        
                        let statusBadge = '';
                        if (eval.status === 'Verified') {
                            statusBadge = '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Disahkan</span>';
                        } else {
                            statusBadge = '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Menunggu</span>';
                        }
                        
                        html += `
                            <tr>
                                <td>${evalDate}</td>
                                <td class="fw-bold">${eval.order ? eval.order.order_number : '-'}</td>
                                <td>${eval.supplier ? eval.supplier.company_name : '-'}</td>
                                <td>${eval.evaluator_name}</td>
                                <td class="text-center fw-bold">${eval.percentage}%</td>
                                <td class="text-center">${ratingBadge}</td>
                                <td class="text-center">${statusBadge}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-info text-white view-eval-btn" data-id="${eval.id}">
                                            <i class="fas fa-eye"></i> Papar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                    tableBody.innerHTML = html;
                    
                    if ($.fn.DataTable.isDataTable('#evaluations-history-table')) {
                        $('#evaluations-history-table').DataTable().destroy();
                    }
                    setTimeout(() => {
                        $('#evaluations-history-table').DataTable({
                            responsive: true,
                            order: [[0, 'desc']]
                        });
                    }, 100);
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Tiada rekod penilaian prestasi ditemui.
                            </td>
                        </tr>
                    `;
                }
            } catch (err) {
                console.error('Error loading evaluations:', err);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center py-4 text-danger">
                            Gagal memuatkan rekod sejarah penilaian.
                        </td>
                    </tr>
                `;
            }
        }

        // Setup verification action
        async function verifyEvaluation(id) {
            if (!confirm('Adakah anda bersetuju untuk mengesahkan penilaian prestasi pembekal ini? Sila pastikan maklumat penilaian adalah betul.')) {
                return;
            }
            
            try {
                const res = await fetch(`/evaluations/${id}/verify`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();
                if (json.success) {
                    alert(json.message || 'Penilaian berjaya disahkan.');
                    window.location.reload();
                } else {
                    alert(json.message || 'Gagal mengesahkan penilaian.');
                }
            } catch (err) {
                console.error('Error verifying evaluation:', err);
                alert('Ralat sistem berlaku ketika melakukan pengesahan.');
            }
        }

        // Setup view details popup
        async function viewEvaluation(id) {
            try {
                const res = await fetch(`/evaluations/${id}`);
                const json = await res.json();
                
                if (json.success) {
                    const evalData = json.data;
                    document.getElementById('viewEvalOrderNo').textContent = evalData.order ? evalData.order.order_number : '-';
                    
                    const evalDateStr = new Date(evalData.evaluation_date).toLocaleDateString('ms-MY', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                    document.getElementById('viewEvalDate').textContent = evalDateStr;
                    document.getElementById('viewEvalSupplierName').textContent = evalData.supplier ? evalData.supplier.company_name : '-';
                    document.getElementById('viewEvalInstitutionName').textContent = evalData.institution ? evalData.institution.name : '-';
                    document.getElementById('viewEvalEvaluator').textContent = evalData.evaluator_name;
                    
                    document.getElementById('viewEvalQty').textContent = evalData.criteria_quantity + ' / 7';
                    document.getElementById('viewEvalDelivery').textContent = evalData.criteria_delivery + ' / 7';
                    document.getElementById('viewEvalPrice').textContent = evalData.criteria_price + ' / 7';
                    document.getElementById('viewEvalQuality').textContent = evalData.criteria_quality + ' / 7';
                    document.getElementById('viewEvalCoop').textContent = evalData.criteria_cooperation + ' / 7';
                    
                    document.getElementById('viewEvalTotalScore').textContent = `${evalData.total_score} / 35`;
                    document.getElementById('viewEvalPercentage').textContent = `${evalData.percentage}%`;
                    
                    const badge = document.getElementById('viewEvalRatingBadge');
                    badge.textContent = evalData.performance_rating.toUpperCase();
                    if (evalData.performance_rating === 'Cemerlang') {
                        badge.className = 'badge rounded-pill px-4 py-2 fs-6 shadow-sm bg-success text-white';
                    } else if (evalData.performance_rating === 'Sederhana') {
                        badge.className = 'badge rounded-pill px-4 py-2 fs-6 shadow-sm bg-warning text-dark';
                    } else {
                        badge.className = 'badge rounded-pill px-4 py-2 fs-6 shadow-sm bg-danger text-white';
                    }
                    
                    const statusDiv = document.getElementById('viewEvalStatus');
                    if (evalData.status === 'Verified') {
                        statusDiv.textContent = 'DISAHKAN';
                        statusDiv.className = 'form-control mb-3 bg-success text-white fw-bold';
                        document.getElementById('viewEvalVerifyBtn').classList.add('d-none');
                    } else {
                        statusDiv.textContent = 'MENUNGGU PENGESAHAN';
                        statusDiv.className = 'form-control mb-3 bg-warning text-dark fw-bold';
                        
                        const verifyBtn = document.getElementById('viewEvalVerifyBtn');
                        verifyBtn.classList.remove('d-none');
                        verifyBtn.onclick = () => {
                            bootstrap.Modal.getInstance(document.getElementById('viewEvaluationModal')).hide();
                            verifyEvaluation(evalData.id);
                        };
                    }
                    
                    document.getElementById('viewEvalRemarks').textContent = evalData.remarks || 'Tiada catatan.';
                    
                    const viewModal = new bootstrap.Modal(document.getElementById('viewEvaluationModal'));
                    viewModal.show();
                }
            } catch (err) {
                console.error('Error fetching evaluation details:', err);
                alert('Gagal memuat butiran penilaian.');
            }
        }
        @endif

        if (typeof Chart !== 'undefined' && typeof ChartDataLabels !== 'undefined') {
            try { Chart.register(ChartDataLabels); } catch(e) { console.warn('ChartDataLabels register failed', e); }
        }
        function handleSidebarToggle() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            if (!sidebarToggle || !sidebar) return;

            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                const icon = sidebarToggle.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-bars');
                    icon.classList.toggle('fa-times');
                }
            });

            document.addEventListener('click', function (event) {
                if (window.innerWidth >= 992) return;
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target) && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    const icon = sidebarToggle.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            });
        }

        function handleThemeToggle() {
            const themeToggle = document.getElementById('themeToggle');
            if (!themeToggle) return;

            const applyTheme = function (theme) {
                document.documentElement.setAttribute('data-bs-theme', theme);
                const icon = themeToggle.querySelector('i');
                if (icon) {
                    icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                }
                localStorage.setItem('theme', theme);
            };

            const savedTheme = localStorage.getItem('theme') || 'light';
            applyTheme(savedTheme);

            themeToggle.addEventListener('click', function () {
                const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
                applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (typeof $ === 'function' && $.fn.DataTable) {
                $('#orders-table, #inventory-table, #suppliers-table, #users-table').DataTable({
                    responsive: true,
                });
            }

            handleSidebarToggle();
            handleThemeToggle();

            @if($activePage === 'laporan-prestasi')
            // Initialization for Laporan Prestasi page
            initEvaluationSliders();
            loadOrdersForEvaluation();
            
            const initialYear = document.getElementById('monthlyYearSelect').value;
            loadMonthlyStats(initialYear);
            loadEvaluationsHistory();
            
            document.getElementById('monthlyYearSelect').addEventListener('change', function() {
                loadMonthlyStats(this.value);
            });
            
            document.getElementById('btnTambahPenilaian').addEventListener('click', function() {
                const addModal = new bootstrap.Modal(document.getElementById('addEvaluationModal'));
                addModal.show();
            });
            
            document.getElementById('evalOrderId').addEventListener('change', function() {
                const orderId = this.value;
                if (!orderId) {
                    document.getElementById('evalSupplierInfo').classList.add('d-none');
                    return;
                }
                const order = (window.evaluationOrders || []).find(o => o.id == orderId);
                if (order) {
                    document.getElementById('evalSupplierName').textContent = order.supplier ? order.supplier.company_name : '-';
                    document.getElementById('evalSupplierId').value = order.supplier_id || '';
                    document.getElementById('evalInstitutionName').textContent = order.institution ? order.institution.name : '-';
                    document.getElementById('evalInstitutionId').value = order.institution_id || '';
                    document.getElementById('evalSupplierInfo').classList.remove('d-none');
                } else {
                    document.getElementById('evalSupplierInfo').classList.add('d-none');
                }
            });
            
            document.getElementById('saveEvaluationBtn').addEventListener('click', async function() {
                const form = document.getElementById('evaluationForm');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                
                const formData = new FormData(form);
                const originalContent = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
                this.disabled = true;
                
                try {
                    const response = await fetch('/evaluations', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    
                    const result = await response.json();
                    if (result.success) {
                        alert(result.message || 'Penilaian berjaya disimpan.');
                        bootstrap.Modal.getInstance(document.getElementById('addEvaluationModal')).hide();
                        form.reset();
                        window.location.reload();
                    } else {
                        const errorMsg = result.errors ? Object.values(result.errors).flat().join('\n') : (result.message || 'Ralat menyimpan.');
                        alert(errorMsg);
                    }
                } catch (error) {
                    console.error('Error saving evaluation:', error);
                    alert('Ralat sistem ketika menyimpan penilaian.');
                } finally {
                    this.innerHTML = originalContent;
                    this.disabled = false;
                }
            });
            
            document.addEventListener('click', function(e) {
                const viewBtn = e.target.closest('.view-eval-btn');
                if (viewBtn) {
                    const id = viewBtn.getAttribute('data-id');
                    viewEvaluation(id);
                }
                
                const verifyBtn = e.target.closest('.verify-eval-btn');
                if (verifyBtn) {
                    const id = verifyBtn.getAttribute('data-id');
                    verifyEvaluation(id);
                }
            });
            @endif
            // Load critical stock count for Pengarah Institusi
            (function loadCriticalStock(){
                const countEl = document.getElementById('criticalStockCount');
                const btn = document.getElementById('btnViewCriticalStock');
                if (!countEl) return;

                fetch('/dashboard/critical-stock')
                    .then(res => res.json())
                    .then(json => {
                        if (json && json.success && Array.isArray(json.data)) {
                            const items = json.data;
                            countEl.textContent = items.length;
                            window.criticalStockItems = items;
                        } else {
                            countEl.textContent = '0';
                            window.criticalStockItems = [];
                        }
                    })
                    .catch(() => {
                        countEl.textContent = '—';
                        window.criticalStockItems = [];
                    });

                if (btn) {
                    btn.addEventListener('click', function () {
                        const items = window.criticalStockItems || [];
                        const tbody = document.querySelector('#criticalStockTable tbody');
                        if (!tbody) return;
                        tbody.innerHTML = '';
                        items.forEach((it, idx) => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${idx + 1}</td>
                                <td>${it.name || '-'}</td>
                                <td>${it.category || '-'}</td>
                                <td>${Number(it.stock).toLocaleString()}</td>
                                <td>${Number(it.minStock).toLocaleString()}</td>
                                <td>${it.unit || '-'}</td>
                            `;
                            tbody.appendChild(tr);
                        });

                        const modalEl = document.getElementById('criticalStockModal');
                        if (modalEl) {
                            const modal = new bootstrap.Modal(modalEl);
                            modal.show();
                        }
                    });
                }

                // Inventory filters: submit form when selects change
                const invYear = document.getElementById('inventoryFilterYear');
                const invMonth = document.getElementById('inventoryFilterMonth');
                const invForm = document.getElementById('inventoryFilterForm');
                if (invForm && (invYear || invMonth)) {
                    [invYear, invMonth].forEach(el => {
                        if (!el) return;
                        el.addEventListener('change', function () {
                            invForm.submit();
                        });
                    });
                }

                // 'Lihat Semua' on the institusi critical panel
                const btnViewFromInst = document.getElementById('btnViewCriticalFromInstitusi');
                if (btnViewFromInst) {
                    btnViewFromInst.addEventListener('click', function () {
                        const items = window.criticalStockItems || [];
                        const tbody = document.querySelector('#criticalStockTable tbody');
                        if (!tbody) return;
                        tbody.innerHTML = '';
                        items.forEach((it, idx) => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${idx + 1}</td>
                                <td>${it.name || '-'}</td>
                                <td>${it.category || '-'}</td>
                                <td>${Number(it.stock).toLocaleString()}</td>
                                <td>${Number(it.minStock).toLocaleString()}</td>
                                <td>${it.unit || '-'}</td>
                            `;
                            tbody.appendChild(tr);
                        });

                        const modalEl = document.getElementById('criticalStockModal');
                        if (modalEl) {
                            const modal = new bootstrap.Modal(modalEl);
                            modal.show();
                        }
                    });
                }
            })();
            
                // Dashboard Charts Logic
            const dashDataStore = window.dashboardChartData || {};
            const orderStatusChartEl = document.getElementById('orderStatusChart');
            const topItemsTableBody = document.querySelector('#topItemsTable tbody');
            let orderStatusChart = null;

            function renderCharts(dataset) {
                try {
                    // Order Status
                    if (dataset.order_status && orderStatusChartEl) {
                        const labels = ['Menunggu', 'Dalam Proses', 'Selesai', 'Ditolak'];
                        const data = [
                            dataset.order_status['Pending'] || 0,
                            dataset.order_status['In Progress'] || 0,
                            dataset.order_status['Completed'] || 0,
                            dataset.order_status['Rejected'] || 0,
                        ];

                        if (orderStatusChart) orderStatusChart.destroy();

                        orderStatusChart = new Chart(orderStatusChartEl.getContext('2d'), {
                            type: 'doughnut',
                            data: { labels, datasets: [{ data, backgroundColor: ['#ffc107','#0d6efd','#198754','#dc3545'] }] },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    tooltip: { callbacks: { label: function(ctx) { return ctx.label + ': ' + ctx.parsed + ' pesanan'; } } },
                                    legend: { position: 'top' },
                                    datalabels: {
                                        color: '#fff',
                                        formatter: function(value, ctx) {
                                            const total = ctx.chart.data.datasets[0].data.reduce((a,b)=>a+b,0);
                                            const pct = total ? Math.round((value/total)*100) : 0;
                                            return value + ' (' + pct + '%)';
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Top Items Table
                    if (dataset.top_items && Array.isArray(dataset.top_items.labels) && topItemsTableBody) {
                        const labels = dataset.top_items.labels || [];
                        const data = dataset.top_items.data || [];
                        const uoms = dataset.top_items.uoms || [];
                        if (labels.length > 0) {
                            topItemsTableBody.innerHTML = labels.map((label, idx) => `
                                <tr>
                                    <td class="ps-4 text-muted">${idx + 1}</td>
                                    <td class="fw-medium">${label}</td>
                                    <td class="text-end pe-4">
                                        <span class="badge bg-success rounded-pill px-3 py-2 fs-6">${data[idx] ?? 0}</span>
                                        <span class="ms-1 text-muted small">${uoms[idx] || ''}</span>
                                    </td>
                                </tr>
                            `).join('');
                        } else {
                            topItemsTableBody.innerHTML = '<tr><td colspan="3" class="text-center py-4 text-muted">Tiada data.</td></tr>';
                        }
                    }
                } catch (e) {
                    console.error('Render charts error', e);
                }
            }

            // Initial render from server-provided store
            if (Object.keys(dashDataStore).length > 0) {
                try { renderCharts(dashDataStore); } catch(e) { console.error(e); }
            }
            
            // Setup filters
            const yearSelect = document.getElementById('chartFilterYear');
            const monthSelect = document.getElementById('chartFilterMonth');

            function populateYearOptions() {
                const now = new Date();
                const currentYear = now.getFullYear();
                const startYear = currentYear - 4;
                for (let y = currentYear; y >= startYear; y--) {
                    const opt = document.createElement('option'); opt.value = y; opt.textContent = y; yearSelect.appendChild(opt);
                }
                // populate recent orders year select as well
                const recentYear = document.getElementById('recentFilterYear');
                if (recentYear) {
                    recentYear.innerHTML = '<option value="">Semua Tahun</option>';
                    for (let y = currentYear; y >= startYear; y--) {
                        const opt = document.createElement('option'); opt.value = y; opt.textContent = y; recentYear.appendChild(opt);
                    }
                }
            }

            populateYearOptions();

            function fetchAndRender() {
                const params = new URLSearchParams();
                if (yearSelect && yearSelect.value) params.set('year', yearSelect.value);
                if (monthSelect && monthSelect.value) params.set('month', monthSelect.value);
                fetch('/api/dashboard/pengarah-institusi?' + params.toString())
                    .then(r => r.json())
                    .then(j => { if (j && j.success) renderCharts(j.data); })
                    .catch(e => console.error('Error fetching dashboard data', e));
            }

            // Initial fetch for recent orders
            fetchRecentOrders();

            // Fetch and render recent orders card
            const recentOrdersTableBody = document.querySelector('#recentOrdersTable tbody');
            const recentYear = document.getElementById('recentFilterYear');
            const recentMonth = document.getElementById('recentFilterMonth');

            function fetchRecentOrders() {
                const params = new URLSearchParams();
                if (recentYear && recentYear.value) params.set('year', recentYear.value);
                if (recentMonth && recentMonth.value) params.set('month', recentMonth.value);
                fetch('/api/pengarah-institusi/recent-orders?' + params.toString())
                    .then(r => r.json())
                    .then(j => {
                        if (j && j.success) {
                            let rows = j.data || [];
                            
                            // Insert dummy data if table is empty for visual demonstration
                            if (rows.length === 0) {
                                rows = [
                                    { order_no: 'PEN/1000/BK/26/07/001', order_date: '2026-07-09', total_amount: 1540.50, status: 'Completed', status_malay: 'Selesai', supplier: 'Syarikat Maju Jaya' },
                                    { order_no: 'PEN/1000/BK/26/07/002', order_date: '2026-07-08', total_amount: 890.00, status: 'In Progress', status_malay: 'Dalam Proses', supplier: 'Maju Enterprise' },
                                    { order_no: 'PEN/1000/BK/26/07/003', order_date: '2026-07-05', total_amount: 3200.75, status: 'Pending', status_malay: 'Menunggu', supplier: 'Ahmad Trading' },
                                ];
                            }
                            
                            if (recentOrdersTableBody) {
                                recentOrdersTableBody.innerHTML = '';
                                rows.forEach((o, idx) => {
                                    const tr = document.createElement('tr');
                                    tr.innerHTML = `
                                        <td class="ps-4">${idx+1}</td>
                                        <td>${o.order_no}</td>
                                        <td>${o.order_date}</td>
                                        <td>RM ${Number(o.total_amount).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2})}</td>
                                        <td><span class="badge ${o.status == 'Pending' ? 'bg-warning' : (o.status == 'In Progress' ? 'bg-primary' : (o.status == 'Completed' ? 'bg-success' : 'bg-danger'))}">${o.status_malay}</span></td>
                                        <td>${o.supplier || '-'}</td>
                                    `;
                                    recentOrdersTableBody.appendChild(tr);
                                });
                            }
                        }
                    })
                    .catch(e => console.error('Error fetching recent orders', e));
            }

            if (recentYear) recentYear.addEventListener('change', () => { fetchRecentOrders(); fetchAndRender(); });
            if (recentMonth) recentMonth.addEventListener('change', () => { fetchRecentOrders(); fetchAndRender(); });

            if (yearSelect) yearSelect.addEventListener('change', fetchAndRender);
            if (monthSelect) monthSelect.addEventListener('change', fetchAndRender);

            // End new chart handling
            
            if (Object.keys(dashDataStore).length > 0 && typeof Chart !== 'undefined') {
                try {
                    const dashboardData = dashDataStore;
                    
                    if (dashboardData.order_status) {
                        const ctxStatus = document.getElementById('orderStatusChart').getContext('2d');
                        new Chart(ctxStatus, {
                            type: 'doughnut',
                            data: {
                                labels: ['Menunggu', 'Dalam Proses', 'Selesai', 'Ditolak'],
                                datasets: [{
                                    data: [
                                        dashboardData.order_status['Pending'] || 0,
                                        dashboardData.order_status['In Progress'] || 0,
                                        dashboardData.order_status['Completed'] || 0,
                                        dashboardData.order_status['Rejected'] || 0
                                    ],
                                    backgroundColor: ['#ffc107', '#0d6efd', '#198754', '#dc3545']
                                }]
                            },
                            options: { responsive: true, maintainAspectRatio: false }
                        });
                    }
                } catch(e) {
                    console.error("Error loading charts:", e);
                }
            }
            
            // Supplier Modal Logic
            const supplierBtns = document.querySelectorAll('.supplier-detail-btn');
            supplierBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('modal_supplier_name').textContent = this.dataset.company || '-';
                    document.getElementById('modal_supplier_contact').textContent = this.dataset.contact || '-';
                    document.getElementById('modal_supplier_email').textContent = this.dataset.email || '-';
                    document.getElementById('modal_supplier_phone').textContent = this.dataset.phone || '-';
                    document.getElementById('modal_supplier_address').textContent = this.dataset.address || '-';
                    document.getElementById('modal_supplier_postcode').textContent = this.dataset.postcode || '-';
                    document.getElementById('modal_supplier_state').textContent = this.dataset.state || '-';
                    const source = this.dataset.source || this.getAttribute('data-source') || '';
                    const sourceEl = document.getElementById('modal_supplier_source');
                    if (sourceEl) {
                        sourceEl.textContent = source ? (source === 'HQ' ? 'HQ' : 'Institusi') : '-';
                    }
                    
                    const modal = new bootstrap.Modal(document.getElementById('supplierDetailModal'));
                    modal.show();
                });
            });

            const btnEditProfile = document.getElementById('btnEditProfile');
            const btnCancelEdit = document.getElementById('btnCancelEdit');
            const cardUpdateProfile = document.getElementById('cardUpdateProfile');
            const btnChangePassword = document.getElementById('btnChangePassword');
            const btnCancelPassword = document.getElementById('btnCancelPassword');
            const cardChangePassword = document.getElementById('cardChangePassword');

            if (btnEditProfile && cardUpdateProfile) {
                btnEditProfile.addEventListener('click', function () {
                    cardUpdateProfile.style.display = 'block';
                    if (cardChangePassword) cardChangePassword.style.display = 'none';
                    cardUpdateProfile.scrollIntoView({ behavior: 'smooth' });
                });
            }

            if (btnCancelEdit && cardUpdateProfile) {
                btnCancelEdit.addEventListener('click', function (event) {
                    event.preventDefault();
                    cardUpdateProfile.style.display = 'none';
                });
            }

            if (btnChangePassword && cardChangePassword) {
                btnChangePassword.addEventListener('click', function () {
                    cardChangePassword.style.display = 'block';
                    if (cardUpdateProfile) cardUpdateProfile.style.display = 'none';
                    cardChangePassword.scrollIntoView({ behavior: 'smooth' });
                });
            }

            if (btnCancelPassword && cardChangePassword) {
                btnCancelPassword.addEventListener('click', function (event) {
                    event.preventDefault();
                    cardChangePassword.style.display = 'none';
                });
            }
            // Global Search Logic
            const searchInput = document.getElementById('globalSearchInput');
            const searchResults = document.getElementById('globalSearchResults');
            let searchTimeout;

            if (searchInput && searchResults) {
                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    const query = e.target.value.trim();
                    
                    if (query.length < 2) {
                        searchResults.classList.add('d-none');
                        return;
                    }
                    
                    searchResults.classList.remove('d-none');
                    searchResults.innerHTML = '<div class="search-loading"><i class="fas fa-spinner fa-spin fa-2x"></i></div>';
                    
                    searchTimeout = setTimeout(function() {
                        const context = searchInput.dataset.context || '';
                        const filterId = searchInput.dataset.filterId || '';
                        fetch(`/api/global-search?q=${encodeURIComponent(query)}&context=${context}&filter_id=${filterId}`)
                            .then(response => response.json())
                            .then(data => {
                                renderSearchResults(data.results);
                            })
                            .catch(error => {
                                searchResults.innerHTML = '<div class="search-empty text-danger">Ralat carian</div>';
                            });
                    }, 300);
                });

                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('d-none');
                    }
                });
                
                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length >= 2) {
                        searchResults.classList.remove('d-none');
                    }
                });

                function renderSearchResults(data) {
                    let html = '';
                    let hasResults = false;
                    
                    const configs = [
                        { key: 'users', title: 'Senarai Pengguna', icon: 'fa-users' },
                        { key: 'items', title: 'Item & Inventori', icon: 'fa-box' },
                        { key: 'suppliers', title: 'Pembekal', icon: 'fa-truck' },
                        { key: 'orders', title: 'Pesanan (Inden)', icon: 'fa-file-invoice' },
                        { key: 'institutions', title: 'Institusi', icon: 'fa-building' }
                    ];

                    configs.forEach(config => {
                        if (data[config.key] && data[config.key].length > 0) {
                            hasResults = true;
                            html += `<h6 class="search-category-title">${config.title}</h6>`;
                            data[config.key].forEach(item => {
                                let itemUrl = '#';
                                if (config.key === 'orders') {
                                    itemUrl = `/pengarah-institusi/ringkasan?search=${encodeURIComponent(item.search_term)}`;
                                } else if (config.key === 'institutions') {
                                    itemUrl = `/pengarah-institusi/institusi?search=${encodeURIComponent(item.search_term)}`;
                                } else if (config.key === 'items') {
                                    itemUrl = `/pengarah-institusi/institusi?search=${encodeURIComponent(item.search_term)}`;
                                } else if (config.key === 'suppliers') {
                                    itemUrl = `/pengarah-institusi/pembekal?search=${encodeURIComponent(item.search_term)}`; 
                                } else if (config.key === 'users') {
                                    itemUrl = `/pengarah-institusi/senarai-user?search=${encodeURIComponent(item.search_term)}`; 
                                }
                                html += `
                                    <a href="${itemUrl}" class="search-result-item text-decoration-none d-block">
                                        <div class="d-flex w-100 align-items-center">
                                            <div class="search-result-icon"><i class="fas ${config.icon}"></i></div>
                                            <div class="search-result-content">
                                                <h6 class="mb-0 text-primary">${item.title}</h6>
                                                <small class="text-muted">${item.subtitle}</small>
                                            </div>
                                        </div>
                                    </a>
                                `;
                            });
                        }
                    });

                    if (!hasResults) {
                        html = '<div class="search-empty">Tiada padanan dijumpai.</div>';
                    }

                    searchResults.innerHTML = html;
                }
            }
        });
    </script>
    <script src="{{ asset('js/table-download.js') }}"></script>
    <script src="{{ asset('js/session-timeout.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Check for search parameter to auto-filter and highlight results
            const urlParams = new URLSearchParams(window.location.search);
            const searchKeyword = urlParams.get('search');
            
            if (searchKeyword && $.fn.dataTable) {
                setTimeout(() => {
                    const tables = $.fn.dataTable.tables({ api: true });
                    if (tables.length > 0) {
                        tables.search(searchKeyword).draw();
                    }
                    
                    setTimeout(() => {
                        $('.table tbody tr').each(function() {
                            if ($(this).text().includes(searchKeyword)) {
                                const cells = $(this).children('td');
                                cells.css({
                                    'background-color': '#fff3cd', // Warning colored highlight
                                    'transition': 'background-color 1s ease'
                                });
                                cells.first().css({
                                    'border-left': '4px solid #ffc107'
                                });
                                
                                // Remove highlight after 3 seconds for animation effect
                                setTimeout(() => {
                                    cells.css({
                                        'background-color': '',
                                        'border-left': ''
                                    });
                                }, 3000);
                                
                                // Scroll to element
                                if (this.scrollIntoView && !isElementInViewport(this)) {
                                    this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            }
                        });
                    }, 300);
                }, 500); // Give time for DataTables to finish initialization
            }

            function isElementInViewport(el) {
                const rect = el.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }
        });
    </script>
</body>
</html>
