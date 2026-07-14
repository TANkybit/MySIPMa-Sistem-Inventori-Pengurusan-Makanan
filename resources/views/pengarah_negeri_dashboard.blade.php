@php
    $activePage = $activePage ?? 'dashboard';
    $pageTitles = [
        'dashboard' => 'Papan Pemuka',
        'inventori' => 'Inventori',
        'ringkasan' => 'Ringkasan Pesanan',
        'laporan-prestasi' => 'Penilaian Prestasi Pembekal',
        'profil' => 'Profil Saya',
    ];
    $pageRoutes = [
        'dashboard' => 'pengarah.negeri.dashboard',
        'inventori' => 'pengarah.negeri.inventori',
        'ringkasan' => 'pengarah.negeri.ringkasan',
        'laporan-prestasi' => 'pengarah.negeri.laporan_prestasi',
        'profil' => 'pengarah.negeri.profil',
    ];
    $pageTitle = $pageTitles[$activePage] ?? 'Papan Pemuka';
    $currentRoute = $pageRoutes[$activePage] ?? 'pengarah.negeri.dashboard';
    $institutionQuery = request()->only('institution_id');
@endphp

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} Pengarah Negeri</title>
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
                <a href="{{ route('pengarah.negeri.dashboard') }}" class="logo">
                    <div class="logo-icon">
                        <img src="{{ asset('MySIPMa_logo_wWalls.png') }}" alt="MySIPMa Logo" height="50" class="me-2">
                    </div>
                    <div class="logo-text">
                        <span class="fw-bold">MySIPMA</span>
                        <small>Pengarah Negeri</small>
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
                        <a class="nav-link {{ request()->routeIs('pengarah.negeri.dashboard') ? 'active' : '' }}" href="{{ route('pengarah.negeri.dashboard', $institutionQuery) }}">
                            <i class="fas fa-home"></i>
                            <span>Papan Pemuka</span>
                        </a>
                    </li>
                    
                    <li class="nav-title mt-4">PENGURUSAN DATA</li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.negeri.ringkasan') ? 'active' : '' }}" href="{{ route('pengarah.negeri.ringkasan', $institutionQuery) }}">
                            <i class="fas fa-file-invoice"></i>
                            <span>Ringkasan Pesanan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.negeri.inventori') ? 'active' : '' }}" href="{{ route('pengarah.negeri.inventori', $institutionQuery) }}">
                            <i class="fas fa-boxes"></i>
                            <span>Inventori</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">LAPORAN</li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.negeri.laporan_prestasi') ? 'active' : '' }}" href="{{ route('pengarah.negeri.laporan_prestasi') }}">
                            <i class="fas fa-star"></i>
                            <span>Penilaian Prestasi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.negeri.profil') ? 'active' : '' }}" href="{{ route('pengarah.negeri.profil') }}">
                            <i class="fas fa-user"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->name ?? 'Pengarah Negeri') }}&background=1a5632&color=fff&size=80" alt="{{ auth()->user()?->name ?? 'Pengarah Negeri' }}" class="user-avatar">
                    <div class="user-info">
                        <h6>{{ auth()->user()?->name ?? 'Pengarah Negeri' }}</h6>
                        <small class="text-muted">Pengarah Negeri</small>
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
                                <li class="breadcrumb-item"><a href="{{ route('pengarah.negeri.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="header-right">
                    <div class="search-box me-3 position-relative">
                        <input type="text" id="globalSearchInput" data-context="negeri" data-filter-id="{{ optional($selectedState)->id }}" class="form-control" placeholder="Cari Maklumat...">
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
                    
                    @if(!in_array($activePage, ['profil', 'laporan-prestasi']))
                    <!-- Always show filter on non-profile pages -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" action="{{ route($currentRoute) }}" class="row g-3 align-items-end">
                                        <div class="col-lg-4 col-md-12">
                                            <label for="institution_id" class="form-label">Pilih Institusi</label>
                                            <select id="institution_id" name="institution_id" class="form-select">
                                                <option value="">Semua Institusi ({{ optional($selectedState)->name }})</option>
                                                @foreach($institutions as $inst)
                                                    <option value="{{ $inst->id }}" {{ ($selectedInstitutionId ?? '') == $inst->id ? 'selected' : '' }}>{{ $inst->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <label for="year" class="form-label">Tahun</label>
                                            <select id="year" name="year" class="form-select">
                                                <option value="">Semua</option>
                                                @for($y = now()->year; $y >= now()->year - 4; $y--)
                                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <label for="month" class="form-label">Bulan</label>
                                            <select id="month" name="month" class="form-select">
                                                <option value="">Semua</option>
                                                @foreach([1=>'Januari',2=>'Februari',3=>'Mac',4=>'April',5=>'Mei',6=>'Jun',7=>'Julai',8=>'Ogos',9=>'September',10=>'Oktober',11=>'November',12=>'Disember'] as $m => $label)
                                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-12">
                                            <button type="submit" class="btn btn-primary w-100">Tapis</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('partials.low_stock_notification', [
                        'lowStockItems' => $lowStockItems ?? collect(),
                        'inventoryUrl' => route('pengarah.negeri.inventori', $institutionQuery),
                    ])

                    <div class="row g-3 mb-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4 h-100">
                                <h6 class="text-uppercase text-muted mb-3">Institusi Terpilih</h6>
                                <h3 class="mb-0">
                                    @if($selectedInstitutionId)
                                        {{ $institutions->firstWhere('id', $selectedInstitutionId)->name ?? 'Tiada' }}
                                    @else
                                        Semua Institusi ({{ optional($selectedState)->name ?? '-' }})
                                    @endif
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4 h-100">
                                <h6 class="text-uppercase text-muted mb-3">Jumlah Pesanan</h6>
                                <h3 class="mb-0">{{ collect($orders ?? [])->count() }}</h3>
                                <div class="small text-muted mt-2">Jumlah Item: <strong>{{ number_format($inventoryTotals['total_quantity'] ?? 0, 2) }}</strong> &nbsp;•&nbsp; Nilai: <strong>RM {{ number_format($inventoryTotals['total_value'] ?? 0, 2) }}</strong></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4 h-100">
                                <h6 class="text-uppercase text-muted mb-3">Jumlah Pembekal</h6>
                                <h3 class="mb-0">{{ collect($suppliers ?? [])->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($activePage === 'dashboard')
                        <div class="row g-4 mb-4">
                            <div class="col-lg-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                                        <h5 class="card-title fw-bold"><i class="fas fa-chart-pie text-primary me-2"></i>Status Pesanan</h5>
                                    </div>
                                    <div class="card-body px-4 pb-4">
                                        <div style="position: relative; height:300px; width:100%">
                                            <canvas id="orderStatusChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                                        <h5 class="card-title fw-bold"><i class="fas fa-chart-bar text-success me-2"></i>Statistik Entiti (Negeri)</h5>
                                    </div>
                                    <div class="card-body px-4 pb-4">
                                        <div style="position: relative; height:300px; width:100%">
                                            <canvas id="entityStatsChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-lg-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pb-2 pt-4 px-4">
                                        <h5 class="card-title fw-bold mb-0"><i class="fas fa-clock text-warning me-2"></i>5 Inden Terkini</h5>
                                        <a href="{{ route('pengarah.negeri.ringkasan', $institutionQuery) }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="ps-4">No. Pesanan</th>
                                                        <th>Institusi</th>
                                                        <th>Tarikh</th>
                                                        <th class="pe-4">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse(collect($orders)->take(5) as $order)
                                                    <tr>
                                                        <td class="ps-4 fw-medium text-primary">{{ $order->order_no }}</td>
                                                        <td>
                                                            <div class="text-truncate" style="max-width: 150px;" title="{{ optional($order->institution)->name }}">
                                                                {{ optional($order->institution)->name }}
                                                            </div>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                                                        <td class="pe-4">
                                                            @php
                                                                $statusClass = match($order->status) {
                                                                    'Pending' => 'bg-warning',
                                                                    'In Progress' => 'bg-info',
                                                                    'Completed' => 'bg-success',
                                                                    'Rejected', 'Cancelled' => 'bg-danger',
                                                                    default => 'bg-secondary'
                                                                };
                                                                $statusLabel = match($order->status) {
                                                                    'Pending' => 'Menunggu',
                                                                    'In Progress' => 'Sedang Diproses',
                                                                    'Completed' => 'Selesai',
                                                                    'Rejected' => 'Ditolak',
                                                                    'Cancelled' => 'Dibatalkan',
                                                                    default => $order->status
                                                                };
                                                            @endphp
                                                            <span class="badge {{ $statusClass }} rounded-pill">{{ $statusLabel }}</span>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4 text-muted">Tiada pesanan terkini</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-header bg-transparent border-0 pb-2 pt-4 px-4">
                                        <h5 class="card-title fw-bold mb-0"><i class="fas fa-boxes text-info me-2"></i>5 Item Terbanyak Dipesan</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0" id="topItemsTableBody">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="ps-4">No.</th>
                                                        <th>Nama Item</th>
                                                        <th class="text-end pe-4">Kuantiti</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Rendered via JS -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($activePage === 'ringkasan')
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Ringkasan Pesanan</h5>
                                <p class="text-muted">Lihat semua pesanan untuk carian ini.</p>
                                <div class="table-responsive">
                                    <table id="orders-table" class="table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>ID Pesanan</th>
                                                <th>No Pesanan</th>
                                                <th>Institusi</th>
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
                                                    <td>{{ optional($order->institution)->name }}</td>
                                                    <td>{{ $order->order_date }}</td>
                                                    <td>{{ number_format($order->total_amount, 2) }}</td>
                                                    <td>
                                                        @php
                                                            $statusClass = match($order->status) {
                                                                'Pending' => 'bg-warning',
                                                                'In Progress' => 'bg-info',
                                                                'Completed' => 'bg-success',
                                                                'Rejected', 'Cancelled' => 'bg-danger',
                                                                default => 'bg-secondary'
                                                            };
                                                            $statusLabel = match($order->status) {
                                                                'Pending' => 'Menunggu',
                                                                'In Progress' => 'Sedang Diproses',
                                                                'Completed' => 'Selesai',
                                                                'Rejected' => 'Ditolak',
                                                                'Cancelled' => 'Dibatalkan',
                                                                default => $order->status
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $statusClass }} fs-6">{{ $statusLabel }}</span>
                                                    </td>
                                                    <td>{{ optional($order->supplier)->company_name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @elseif($activePage === 'inventori')
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h5 class="card-title mb-0">Inventori Pesanan Mengikut Negeri</h5>
                                                <p class="text-muted small mb-0">Lihat ringkasan item yang dipesan untuk negeri terpilih.</p>
                                            </div>
                                            <form id="negeriInventoryFilterForm" method="GET" action="{{ route('pengarah.negeri.inventori') }}" class="d-flex gap-2 align-items-center">
                                                @if(request('institution_id'))
                                                    <input type="hidden" name="institution_id" value="{{ request('institution_id') }}" />
                                                @endif
                                                <label class="mb-0 small text-muted">Tahun:</label>
                                                <select name="year" id="negeriInventoryYear" class="form-select form-select-sm" style="width:120px;">
                                                    <option value="">Semua</option>
                                                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                                    @endfor
                                                </select>
                                                <label class="mb-0 small text-muted ms-2">Bulan:</label>
                                                <select name="month" id="negeriInventoryMonth" class="form-select form-select-sm" style="width:140px;">
                                                    <option value="">Semua</option>
                                                    @foreach([1=>'Jan',2=>'Feb',3=>'Mac',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Ogo',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Dis'] as $m => $label)
                                                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="inventory-table" class="table table-bordered table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Item</th>
                                                        <th>Jumlah Dipesan</th>
                                                        <th>Jumlah Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($inventoryItems as $item)
                                                        <tr>
                                                            <td>{{ optional($item->item)->name ?? 'Item tidak dijumpai' }}</td>
                                                            <td>{{ number_format($item->total_ordered_quantity, 2) }}</td>
                                                            <td>{{ number_format($item->total_ordered_price, 2) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="3" class="text-center text-muted py-4">Tiada data inventori untuk tempoh dipilih.</td></tr>
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
                                        <div class="list-group list-group-flush small">
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
                                            <button class="btn btn-sm btn-outline-warning" id="btnViewCriticalFromNegeri"><i class="fas fa-eye me-1"></i>Lihat Semua</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($activePage === 'profil')
                        <div class="row justify-content-center">
                            <div class="col-lg-5 mb-4">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <div class="position-relative d-inline-block mb-3">
                                            <img src="{{ auth()->user()?->image ? asset('storage/' . auth()->user()->image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()?->name ?? 'Pengarah Negeri') . '&background=1a5632&color=fff&size=150' }}" 
                                                alt="Profile Picture" 
                                                class="rounded-circle img-thumbnail"
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                        <h4 class="mb-0">{{ auth()->user()?->name ?? 'Pengarah Negeri' }}</h4>
                                        <p class="text-muted">{{ auth()->user()?->position?->name ?? 'Pengarah Negeri' }}</p>
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
                                                <span><i class="fas fa-envelope me-2 text-primary"></i>Email</span>
                                                <span class="fw-medium">{{ auth()->user()?->email ?? '-' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-phone me-2 text-primary"></i>No. Telefon</span>
                                                <span class="fw-medium">{{ auth()->user()?->phone_number ?? '-' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-building me-2 text-primary"></i>Institusi (HQ)</span>
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
                                                    <label class="form-label">Email</label>
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
                                                        @foreach(\App\Models\Institution::orderBy('name')->get() as $inst)
                                                            <option value="{{ $inst->id }}" {{ auth()->user()?->institution_id == $inst->id ? 'selected' : '' }}>
                                                                {{ $inst->name }}
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

                                <!-- Info banner: read-only view -->
                                <div class="alert alert-info d-flex align-items-center gap-3 mb-4 border-0 shadow-sm">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                    <div>
                                        <strong>Paparan Baca Sahaja</strong> — Halaman ini memaparkan penilaian prestasi pembekal yang telah <strong>disahkan</strong> oleh Pengarah Institusi sahaja.
                                    </div>
                                </div>

                                <!-- Monthly Trend Table -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title mb-0 fw-bold text-body">Jadual Prestasi Bulanan Pembekal (Disahkan)</h5>
                                            <p class="text-muted small mb-0">Analisis purata pemarkahan (%) bulanan semua pembekal yang telah disahkan</p>
                                        </div>
                                        <div>
                                            <select class="form-select" id="negeriMonthlyYearSelect" style="width: 120px;">
                                                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                                    <option value="{{ $y }}">{{ $y }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover align-middle text-center text-body" id="negeri-monthly-stats-table">
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
                                                <tbody id="negeriMonthlyStatsTableBody" class="text-body">
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

                                <!-- All Verified Evaluations Table -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="card-title mb-0 fw-bold text-body">Senarai Penilaian Prestasi (Disahkan)</h5>
                                        <p class="text-muted small mb-0">Rekod penilaian yang telah disahkan oleh Pengarah Institusi</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle border-top text-body" id="negeri-evaluations-table">
                                                <thead>
                                                    <tr>
                                                        <th>Tarikh</th>
                                                        <th>No. Inden</th>
                                                        <th>Pembekal</th>
                                                        <th>Institusi</th>
                                                        <th>Penilai</th>
                                                        <th class="text-center">Skor (%)</th>
                                                        <th class="text-center">Rating</th>
                                                        <th class="text-center">Tindakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="negeriHistoryTableBody" class="text-body">
                                                    <tr>
                                                        <td colspan="8" class="text-center py-4 text-muted">
                                                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                                            Memuat data penilaian...
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
            <!-- Footer -->
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
        // Load monthly stats (verified only — Negeri/HQ view)
        async function loadNegeriMonthlyStats(year) {
            const tableBody = document.getElementById('negeriMonthlyStatsTableBody');
            tableBody.innerHTML = '<tr><td colspan="15" class="py-4 text-muted"><div class="spinner-border spinner-border-sm me-2" role="status"></div>Memproses analisis bulanan...</td></tr>';
            try {
                const res = await fetch(`/evaluations/monthly?year=${year}`);
                const json = await res.json();
                if (json.success && json.data.length > 0) {
                    let html = '';
                    json.data.forEach(item => {
                        let ratingBadge = '-';
                        if (item.rating === 'Cemerlang') ratingBadge = '<span class="badge bg-success">Cemerlang</span>';
                        else if (item.rating === 'Sederhana') ratingBadge = '<span class="badge bg-warning text-dark">Sederhana</span>';
                        else if (item.rating === 'Lemah') ratingBadge = '<span class="badge bg-danger">Lemah</span>';
                        html += `<tr><td class="text-start fw-bold">${item.supplier_name}</td><td class="fw-bold">${item.average !== null ? item.average + '%' : '-'}</td><td>${ratingBadge}</td>`;
                        for (let m = 1; m <= 12; m++) {
                            const val = item.monthly[m];
                            if (val !== null) {
                                let cls = val >= 81 ? 'text-success fw-bold' : val >= 51 ? 'text-warning fw-bold' : 'text-danger fw-bold';
                                html += `<td class="${cls}">${val}%</td>`;
                            } else { html += '<td>-</td>'; }
                        }
                        html += '</tr>';
                    });
                    tableBody.innerHTML = html;
                } else {
                    tableBody.innerHTML = `<tr><td colspan="15" class="py-4 text-muted">Tiada rekod data penilaian yang disahkan bagi tahun ${year}.</td></tr>`;
                }
            } catch (err) {
                tableBody.innerHTML = '<tr><td colspan="15" class="py-4 text-danger">Gagal memuatkan rekod data bulanan.</td></tr>';
            }
        }

        async function loadNegeriEvaluationsHistory() {
            const tableBody = document.getElementById('negeriHistoryTableBody');
            try {
                const res = await fetch('/evaluations');
                const json = await res.json();
                if (json.success && json.data.length > 0) {
                    let html = '';
                    json.data.forEach(ev => {
                        const evalDate = new Date(ev.evaluation_date).toLocaleDateString('ms-MY', { day: '2-digit', month: '2-digit', year: 'numeric' });
                        let ratingBadge = ev.performance_rating === 'Cemerlang'
                            ? '<span class="badge bg-success">Cemerlang</span>'
                            : ev.performance_rating === 'Sederhana'
                                ? '<span class="badge bg-warning text-dark">Sederhana</span>'
                                : '<span class="badge bg-danger">Lemah</span>';
                        html += `<tr>
                            <td>${evalDate}</td>
                            <td class="fw-bold">${ev.order ? ev.order.order_number : '-'}</td>
                            <td>${ev.supplier ? ev.supplier.company_name : '-'}</td>
                            <td>${ev.institution ? ev.institution.name : '-'}</td>
                            <td>${ev.evaluator_name}</td>
                            <td class="text-center fw-bold">${ev.percentage}%</td>
                            <td class="text-center">${ratingBadge}</td>
                            <td class="text-center"><span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Disahkan</span></td>
                        </tr>`;
                    });
                    tableBody.innerHTML = html;
                    if ($.fn.DataTable.isDataTable('#negeri-evaluations-table')) { $('#negeri-evaluations-table').DataTable().destroy(); }
                    setTimeout(() => { $('#negeri-evaluations-table').DataTable({ responsive: true, order: [[0, 'desc']] }); }, 100);
                } else {
                    tableBody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-muted">Tiada rekod penilaian prestasi yang telah disahkan ditemui.</td></tr>';
                }
            } catch (err) {
                tableBody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-danger">Gagal memuatkan rekod sejarah penilaian.</td></tr>';
            }
        }
        @endif

        document.addEventListener('DOMContentLoaded', function () {
            // Register chart datalabels plugin
            if (typeof Chart !== 'undefined' && typeof ChartDataLabels !== 'undefined') {
                try { Chart.register(ChartDataLabels); } catch(e) { console.warn('ChartDataLabels register failed', e); }
            }

            @if($activePage === 'laporan-prestasi')
            const negeriYearSelect = document.getElementById('negeriMonthlyYearSelect');
            if (negeriYearSelect) {
                loadNegeriMonthlyStats(negeriYearSelect.value);
                loadNegeriEvaluationsHistory();
                negeriYearSelect.addEventListener('change', function() {
                    loadNegeriMonthlyStats(this.value);
                });
            }
            @endif

            // Initialize DataTables if elements exist
            if ($.fn.DataTable) {
                if (document.getElementById('orders-table')) {
                    $('#orders-table').DataTable();
                }
                if (document.getElementById('inventory-table')) {
                    $('#inventory-table').DataTable();
                }
                if (document.getElementById('suppliers-table')) {
                    $('#suppliers-table').DataTable();
                }
            }

            // Theme Toggle
            const themeToggle = document.getElementById('themeToggle');
            if (themeToggle) {
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

            // Profile toggles
            const btnEditProfile = document.getElementById('btnEditProfile');
            const btnCancelEdit = document.getElementById('btnCancelEdit');
            const cardUpdateProfile = document.getElementById('cardUpdateProfile');
            
            const btnChangePassword = document.getElementById('btnChangePassword');
            const btnCancelPassword = document.getElementById('btnCancelPassword');
            const cardChangePassword = document.getElementById('cardChangePassword');
            
            if (btnEditProfile && btnCancelEdit && cardUpdateProfile) {
                btnEditProfile.addEventListener('click', () => {
                    cardUpdateProfile.style.display = 'block';
                    if(cardChangePassword) cardChangePassword.style.display = 'none';
                    cardUpdateProfile.scrollIntoView({behavior: "smooth"});
                });
                btnCancelEdit.addEventListener('click', () => cardUpdateProfile.style.display = 'none');
            }
            
            if (btnChangePassword && btnCancelPassword && cardChangePassword) {
                btnChangePassword.addEventListener('click', () => {
                    cardChangePassword.style.display = 'block';
                    if(cardUpdateProfile) cardUpdateProfile.style.display = 'none';
                    cardChangePassword.scrollIntoView({behavior: "smooth"});
                });
                btnCancelPassword.addEventListener('click', () => cardChangePassword.style.display = 'none');
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
                                    itemUrl = `/pengarah-negeri/ringkasan?search=${encodeURIComponent(item.search_term)}`;
                                } else if (config.key === 'institutions') {
                                    itemUrl = `/pengarah-negeri?institution_id=${item.id}&search=${encodeURIComponent(item.search_term)}`;
                                } else if (config.key === 'items') {
                                    itemUrl = `/pengarah-negeri/inventori?search=${encodeURIComponent(item.search_term)}`;
                                } else if (config.key === 'suppliers') {
                                    itemUrl = `/pengarah-negeri?search=${encodeURIComponent(item.search_term)}`; 
                                } else if (config.key === 'users') {
                                    itemUrl = `/pengarah-negeri?search=${encodeURIComponent(item.search_term)}`; 
                                }

                                html += `
                                    <a href="${itemUrl}" class="search-result-item text-decoration-none text-dark d-block">
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

            // Charts Rendering
            @if($activePage === 'dashboard' && isset($dashboardData))
                const dashData = {!! $dashboardData !!};

                // Colors
                const pieColors = ['#ffc107', '#0dcaf0', '#198754', '#dc3545', '#6c757d'];
                const barColors = [
                    'rgba(26, 86, 50, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(23, 162, 184, 0.8)'
                ];

                // 1. Order Status Chart
                const statusCtx = document.getElementById('orderStatusChart');
                if (statusCtx && dashData.order_status) {
                    new Chart(statusCtx, {
                        type: 'doughnut',
                        data: {
                            labels: Object.keys(dashData.order_status),
                            datasets: [{
                                data: Object.values(dashData.order_status),
                                backgroundColor: pieColors,
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top' },
                                datalabels: {
                                    color: '#fff',
                                    formatter: function(value, ctx) {
                                        const total = ctx.chart.data.datasets[0].data.reduce((a,b)=>a+b,0);
                                        const pct = total ? Math.round((value/total)*100) : 0;
                                        return value + ' (' + pct + '%)';
                                    }
                                }
                            },
                            cutout: '65%'
                        }
                    });
                }

                // 2. Entity Stats Chart (Institusi & Pembekal)
                const entityStatsCtx = document.getElementById('entityStatsChart');
                if (entityStatsCtx) {
                    new Chart(entityStatsCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Institusi', 'Pembekal'],
                            datasets: [{
                                label: 'Jumlah',
                                data: [{{ $institutions->count() }}, {{ collect($suppliers ?? [])->count() }}],
                                backgroundColor: ['rgba(13, 110, 253, 0.8)', 'rgba(255, 193, 7, 0.8)'],
                                borderRadius: 6,
                                barPercentage: 0.5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { beginAtZero: true, grid: { borderDash: [2, 2] } },
                                x: { grid: { display: false } }
                            },
                            plugins: { 
                                legend: { display: false },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'end',
                                    color: '#0a0a0a',
                                    formatter: function(value) { return value; }
                                }
                            }
                        }
                    });
                }

                // 3. Top Items Data Table
                const tbody = document.querySelector('#topItemsTableBody tbody');
                if (tbody && dashData.top_items && dashData.top_items.labels.length > 0) {
                    let html = '';
                    dashData.top_items.labels.forEach((label, i) => {
                        const uom = (dashData.top_items.uoms && dashData.top_items.uoms[i]) ? dashData.top_items.uoms[i] : '';
                        html += `
                            <tr>
                                <td class="ps-4 text-muted">${i + 1}</td>
                                <td class="fw-medium text-dark">${label}</td>
                                <td class="text-end pe-4">
                                    <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">${dashData.top_items.data[i]}</span>
                                    <span class="ms-1 text-muted small">${uom}</span>
                                </td>
                            </tr>
                        `;
                    });
                    tbody.innerHTML = html;
                } else if(tbody) {
                    tbody.innerHTML = '<tr><td colspan="3" class="text-center py-4 text-muted">Tiada data.</td></tr>';
                }
            @endif

            // Inventory filter handlers for Negeri page
            const negeriYear = document.getElementById('negeriInventoryYear');
            const negeriMonth = document.getElementById('negeriInventoryMonth');
            const negeriForm = document.getElementById('negeriInventoryFilterForm');
            if (negeriForm && (negeriYear || negeriMonth)) {
                [negeriYear, negeriMonth].forEach(el => {
                    if (!el) return;
                    el.addEventListener('change', function () { negeriForm.submit(); });
                });
            }

            const btnViewNegeri = document.getElementById('btnViewCriticalFromNegeri');
            if (btnViewNegeri) {
                btnViewNegeri.addEventListener('click', function () {
                    // reuse same critical-stock endpoint
                    fetch('/dashboard/critical-stock').then(r => r.json()).then(json => {
                        const items = (json && json.success && Array.isArray(json.data)) ? json.data : [];
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
                        if (modalEl) new bootstrap.Modal(modalEl).show();
                    }).catch(() => {});
                });
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
