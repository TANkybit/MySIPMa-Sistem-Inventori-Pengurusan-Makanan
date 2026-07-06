@php
    $activePage = $activePage ?? 'dashboard';
    $pageTitles = [
        'dashboard' => 'Papan Pemuka',
        'ringkasan' => 'Ringkasan Pesanan',
        'institusi' => 'Inventori',
        'pembekal' => 'Pembekal',
        'senarai_user' => 'Senarai Pengguna',
        'profil' => 'Profil Saya',
    ];
    $pageRoutes = [
        'dashboard' => 'admin.institusi.dashboard',
        'ringkasan' => 'admin.institusi.ringkasan',
        'institusi' => 'admin.institusi.institusi',
        'pembekal' => 'admin.institusi.pembekal',
        'senarai_user' => 'admin.institusi.senarai_pengguna',
        'profil' => 'admin.institusi.profil',
    ];
    $pageTitle = $pageTitles[$activePage] ?? 'Papan Pemuka';
    $currentRoute = $pageRoutes[$activePage] ?? 'admin.institusi.dashboard';
    $institutionQuery = request()->only('institution_id');
@endphp

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} Admin Institusi</title>
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
                <a href="{{ route('admin.institusi.dashboard') }}" class="logo">
                    <div class="logo-icon">
                        <img src="{{ asset('MySIPMa_logo_wWalls.png') }}" alt="MySIPMa Logo" height="50" class="me-2">
                    </div>
                    <div class="logo-text">
                        <span class="fw-bold">MySIPMA</span>
                        <small>Admin Institusi</small>
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
                        <a class="nav-link {{ request()->routeIs('admin.institusi.dashboard') ? 'active' : '' }}" href="{{ route('admin.institusi.dashboard', $institutionQuery) }}">
                            <i class="fas fa-home"></i>
                            <span>Papan Pemuka</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">PENGURUSAN DATA</li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.institusi.ringkasan') ? 'active' : '' }}" href="{{ route('admin.institusi.ringkasan') }}">
                            <i class="fas fa-file-invoice"></i>
                            <span>Ringkasan Pesanan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.institusi.institusi') ? 'active' : '' }}" href="{{ route('admin.institusi.institusi') }}">
                            <i class="fas fa-boxes"></i>
                            <span>Inventori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.institusi.pembekal') ? 'active' : '' }}" href="{{ route('admin.institusi.pembekal') }}">
                            <i class="fas fa-truck"></i>
                            <span>Pembekal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.institusi.senarai_pengguna') ? 'active' : '' }}" href="{{ route('admin.institusi.senarai_pengguna') }}">
                            <i class="fas fa-users"></i>
                            <span>Senarai Pengguna</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">LAPORAN</li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.institusi.profil') ? 'active' : '' }}" href="{{ route('admin.institusi.profil') }}">
                            <i class="fas fa-user"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->name ?? 'Admin Institusi') }}&background=1a5632&color=fff&size=80" alt="{{ auth()->user()?->name ?? 'Admin Institusi' }}" class="user-avatar">
                    <div class="user-info">
                        <h6>{{ auth()->user()?->name ?? 'Admin Institusi' }}</h6>
                        <small class="text-muted">Admin Institusi</small>
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
                                <li class="breadcrumb-item"><a href="{{ route('admin.institusi.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item">Admin Institusi</li>
                                <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="header-right">
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
                        'inventoryUrl' => route('admin.institusi.institusi'),
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
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4 h-100">
                                <h6 class="text-uppercase text-muted mb-3">Jumlah Pembekal</h6>
                                <h3 class="mb-0">{{ $suppliers->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($activePage === 'dashboard')
                        <div class="row mb-4">
                            <!-- Order Status Chart -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-white border-0 pt-4 pb-0">
                                        <h5 class="card-title fw-bold mb-0">Status Pesanan Keseluruhan</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="orderStatusChart" style="max-height: 300px;"></canvas>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Top Items Chart -->
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-white border-0 pt-4 pb-0">
                                        <h5 class="card-title fw-bold mb-0">5 Item Paling Banyak Dipesan</h5>
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 300px;">
                                        <canvas id="topItemsChart" style="max-height: 300px; display:none;"></canvas>
                                        <div id="topItemsNoData" class="text-center text-muted" style="display:none;">
                                            <i class="fas fa-chart-bar fa-3x mb-3 opacity-25"></i>
                                            <p class="mb-0">Tiada rekod item yang dipesan lagi.</p>
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
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Inventori Pesanan</h5>
                                <p class="text-muted">Lihat ringkasan item yang dipesan untuk institusi terpilih.</p>
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
                                            @foreach($inventoryItems as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ optional($item->item)->name ?? 'Item tidak dijumpai' }}</td>
                                                    <td>{{ number_format($item->total_ordered_quantity, 2) }}</td>
                                                    <td>{{ number_format($item->total_ordered_price, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                                                <th>PIC</th>
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
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="card-title mb-0">Senarai Pengguna</h5>
                                        <p class="text-muted mb-0">Lihat dan urus pengguna untuk institusi terpilih.</p>
                                    </div>
                                    <button class="btn btn-primary btn-sm" id="btnTambahPengguna" data-bs-toggle="modal" data-bs-target="#userModal">
                                        <i class="fas fa-plus me-1"></i> Tambah Pengguna Baru
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table id="users-table" class="table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;">Bil</th>
                                                <th>Nama</th>
                                                <th>E-mel</th>
                                                <th>No. Telefon</th>
                                                <th>Jawatan / Peranan</th>
                                                <th>Tindakan</th>
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
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary btn-edit-user" 
                                                            data-id="{{ $user->id }}"
                                                            data-name="{{ $user->name }}"
                                                            data-email="{{ $user->email }}"
                                                            data-phone="{{ $user->phone_number }}"
                                                            data-role="{{ $user->role_id }}"
                                                            data-position="{{ $user->position_id }}"
                                                            data-status="{{ $user->status }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#userModal">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
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
                                            <img src="{{ auth()->user()?->image ? asset('storage/' . auth()->user()->image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()?->name ?? 'Admin Institusi') . '&background=1a5632&color=fff&size=150' }}"
                                                alt="Profile Picture"
                                                class="rounded-circle img-thumbnail"
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                        <h4 class="mb-0">{{ auth()->user()?->name ?? 'Admin Institusi' }}</h4>
                                        <p class="text-muted">{{ auth()->user()?->position?->name ?? 'Admin Institusi' }}</p>
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
                    @endif
                </div>
            </div>

            <!-- User Modal -->
            <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="userModalLabel"><i class="fas fa-user-edit me-2"></i>Tambah / Kemaskini Pengguna</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="userForm">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id">
                            <input type="hidden" id="user_institution" name="institution_id" value="{{ optional($selectedInstitution)->id }}">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="user_name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">E-mel</label>
                                    <input type="email" class="form-control" id="user_email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No. Telefon</label>
                                    <input type="text" class="form-control" id="user_phone" name="phone_number">
                                </div>
                                <div class="mb-3" id="passwordGroup">
                                    <label class="form-label">Kata Laluan (Biarkan kosong jika tidak mahu tukar/Isi jika pengguna baru)</label>
                                    <input type="password" class="form-control" id="user_password" name="password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Peranan</label>
                                    <select class="form-select" id="user_role" name="role_id" required>
                                        <option value="">Pilih Peranan</option>
                                        @foreach($roles ?? collect() as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jawatan</label>
                                    <select class="form-select" id="user_position" name="position_id" required>
                                        <option value="">Pilih Jawatan</option>
                                        @foreach($positions ?? collect() as $position)
                                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="user_status" name="status" value="1" checked>
                                    <label class="form-check-label" for="user_status">Aktif</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" id="btnSaveUser">Simpan</button>
                            </div>
                        </form>
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
                                        <th>PIC</th>
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
    <script>
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
            
            // User Modal Logic
            const userModalElement = document.getElementById('userModal');
            let userModal;
            if (userModalElement) {
                userModal = new bootstrap.Modal(userModalElement);
            }

            $('#btnTambahPengguna').click(function() {
                $('#userForm')[0].reset();
                $('#user_id').val('');
                $('#userModalLabel').html('<i class="fas fa-user-plus me-2"></i>Tambah Pengguna Baru');
            });

            $('.btn-edit-user').click(function() {
                $('#userForm')[0].reset();
                $('#user_id').val($(this).data('id'));
                $('#user_name').val($(this).data('name'));
                $('#user_email').val($(this).data('email'));
                $('#user_phone').val($(this).data('phone'));
                $('#user_role').val($(this).data('role'));
                $('#user_position').val($(this).data('position'));
                
                if ($(this).data('status') == 1) {
                    $('#user_status').prop('checked', true);
                } else {
                    $('#user_status').prop('checked', false);
                }
                
                $('#userModalLabel').html('<i class="fas fa-user-edit me-2"></i>Kemaskini Pengguna');
            });

            $('#userForm').submit(function(e) {
                e.preventDefault();
                const userId = $('#user_id').val();
                let url = userId ? `/admin/${userId}` : '/admin/register';
                let method = userId ? 'PUT' : 'POST';

                const formData = $(this).serialize();
                const btn = $('#btnSaveUser');
                const originalText = btn.text();
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        alert(response.message || 'Berjaya disimpan!');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Ralat semasa menyimpan: ' + (xhr.responseJSON?.message || 'Ralat sistem'));
                        btn.prop('disabled', false).text(originalText);
                    }
                });
            });
            
            // Dashboard Charts Logic
            const dashDataStore = window.dashboardChartData || {};
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
                    
                    const topItemsCanvas = document.getElementById('topItemsChart');
                    const topItemsNoData = document.getElementById('topItemsNoData');
                    if (dashboardData.top_items && dashboardData.top_items.labels && dashboardData.top_items.labels.length > 0) {
                        topItemsCanvas.style.display = 'block';
                        if (topItemsNoData) topItemsNoData.style.display = 'none';
                        new Chart(topItemsCanvas.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: dashboardData.top_items.labels,
                                datasets: [{
                                    label: 'Jumlah Dipesan',
                                    data: dashboardData.top_items.data,
                                    backgroundColor: [
                                        '#1a5632', '#2d8653', '#3aac6b', '#5ec48a', '#8ed4ab'
                                    ],
                                    borderRadius: 6,
                                    borderSkipped: false,
                                }]
                            },
                            options: { 
                                responsive: true, 
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false }
                                },
                                scales: { 
                                    y: { 
                                        beginAtZero: true,
                                        ticks: { precision: 0 }
                                    }
                                }
                            }
                        });
                    } else {
                        if (topItemsCanvas) topItemsCanvas.style.display = 'none';
                        if (topItemsNoData) topItemsNoData.style.display = 'flex';
                        if (topItemsNoData) topItemsNoData.style.flexDirection = 'column';
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
                                    itemUrl = `/admin-institusi/ringkasan?search=${encodeURIComponent(item.search_term)}`;
                                } else if (config.key === 'institutions') {
                                    itemUrl = `/admin-institusi/institusi?search=${encodeURIComponent(item.search_term)}`;
                                } else if (config.key === 'items') {
                                    itemUrl = `/admin-institusi/institusi?search=${encodeURIComponent(item.search_term)}`;
                                } else if (config.key === 'suppliers') {
                                    itemUrl = `/admin-institusi/pembekal?search=${encodeURIComponent(item.search_term)}`; 
                                } else if (config.key === 'users') {
                                    itemUrl = `/admin-institusi/senarai-user?search=${encodeURIComponent(item.search_term)}`; 
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
