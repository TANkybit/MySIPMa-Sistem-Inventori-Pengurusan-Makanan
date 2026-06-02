<!DOCTYPE html>
<html lang="ms" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengurusan Penjara - Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- ApexCharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.0/dist/apexcharts.css">

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🔒</text></svg>">
</head>

<body>
    <!-- Main Wrapper -->
    <div class="wrapper">
        <!-- ========== Sidebar Start ========== -->
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <a href="#" class="logo" data-page="home">
                    <div class="logo-icon">
                        <img src="{{ asset('MySIPMa_logo_wWalls.png') }}" alt="MySIPMa Logo" height="50" class="me-2">
                    </div>
                    <div class="logo-text">
                        <span class="fw-bold">MySIPMA</span>
                        <small class>Admin</small>
                    </div>
                </a>
                <button class="sidebar-toggle d-lg-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Sidebar Menu -->
            <nav class="sidebar-menu">
                <ul class="nav flex-column">
                    <li class="nav-title">MAIN</li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-page="home">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">PENGURUSAN DATA</li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="institusi">
                            <i class="fas fa-building"></i>
                            <span>Institusi</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="admin-list">
                            <i class="fas fa-user-shield"></i>
                            <span>Admin</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="position-list">
                            <i class="fas fa-id-badge"></i>
                            <span>Jawatan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="supplier-list">
                            <i class="fas fa-truck"></i>
                            <span>Pembekal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="category-list">
                            <i class="fas fa-tags"></i>
                            <span>Kategori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="item-list">
                            <i class="fas fa-box"></i>
                            <span>Item</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="uom-list">
                            <i class="fas fa-ruler-combined"></i>
                            <span>UOM</span>
                        </a>
                    </li>
                    <li class="nav-title mt-4">PENGURUSAN INDEN</li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="inden">
                            <i class="fas fa-file-invoice"></i>
                            <span>Inden</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">LAPORAN</li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="laporan-prestasi">
                            <i class="fas fa-chart-line"></i>
                            <span>Laporan Prestasi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="profil">
                            <i class="fas fa-user"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Sidebar Footer -->
            <div class="sidebar-footer">
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->name ?? 'Pengarah HQ') }}&background=1a5632&color=fff&size=80"
                        alt="{{ auth()->user()?->name ?? 'Pengarah HQ' }}" class="user-avatar">
                    <div class="user-info">
                        <h6>{{ auth()->user()?->name ?? 'Pengarah HQ' }}</h6>
                        <small class="text-muted">Pentadbir Sistem</small>
                    </div>
                    <a href="#" class="logout-btn" id="logoutBtn">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </aside>
        <!-- ========== Sidebar End ========== -->

        <!-- ========== Main Content Start ========== -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <button class="sidebar-toggle d-lg-none" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-title">
                        <h1 id="pageTitle">Dashboard</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" data-page="home"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active" id="breadcrumbCurrent">Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="header-right">
                    <div class="search-box position-relative">
                        <input type="text" id="globalSearchInput" data-context="hq" data-filter-id="" class="form-control" placeholder="Cari Maklumat...">
                        <i class="fas fa-search"></i>
                        <div id="globalSearchResults" class="global-search-dropdown d-none"></div>
                    </div>

                    <!-- Theme Toggle -->
                    <div class="theme-toggle">
                        <button class="btn btn-icon" id="themeToggle">
                            <i class="fas fa-moon"></i>
                        </button>
                    </div>

                    <!-- Calendar Quick View -->
                    <div class="dropdown">
                        <button class="btn btn-icon" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-calendar-day"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-3" style="width: 300px;">
                            <h6 class="mb-3">Kalendar Hari Ini</h6>
                            <div id="mini-calendar"></div>
                            <div class="mt-3">
                                <small class="text-muted">15 Oktober 2023</small>
                                <div class="mt-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bullet bg-primary me-2"></div>
                                        <small>10:00 - Mesyuarat Pengurusan</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="bullet bg-success me-2"></div>
                                        <small>14:00 - Lawatan Pemeriksaan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="dropdown notifications">
                        <button class="btn btn-icon" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="badge-notification">5</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="dropdown-header">
                                <h6>Pemberitahuan</h6>
                                <a href="#" class="text-muted small">Tandai semua dibaca</a>
                            </div>
                            <div class="dropdown-body">
                                <a href="#" class="dropdown-item">
                                    <div class="d-flex">
                                        <div class="notification-icon bg-success">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6>Inden Disahkan</h6>
                                            <p class="mb-0">Inden #IN-2023-0456 telah disahkan</p>
                                            <small class="text-muted">10 minit lalu</small>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="d-flex">
                                        <div class="notification-icon bg-warning">
                                            <i class="fas fa-exclamation"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6>Stok Rendah</h6>
                                            <p class="mb-0">Bahan "Gula" hampir habis</p>
                                            <small class="text-muted">1 jam lalu</small>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="d-flex">
                                        <div class="notification-icon bg-info">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6>Banduan Baru</h6>
                                            <p class="mb-0">Banduan #INM-7823 didaftarkan</p>
                                            <small class="text-muted">2 jam lalu</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer">
                                <a href="#" class="text-primary">Lihat semua pemberitahuan</a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="dropdown">
                        <button class="btn btn-icon" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bolt"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-3" style="width: 300px;">
                            <h6 class="mb-3">Tindakan Pantas</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <button class="btn btn-sm btn-outline-primary w-100" data-page="institusi">
                                        <i class="fas fa-building me-1"></i> + Institusi
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-sm btn-outline-success w-100" data-page="admin-list">
                                        <i class="fas fa-user-shield me-1"></i> + Admin
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-sm btn-outline-warning w-100" data-page="position-list">
                                        <i class="fas fa-id-badge me-1"></i> + Jawatan
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-sm btn-outline-info w-100" data-page="supplier-list">
                                        <i class="fas fa-truck me-1"></i> + Pembekal
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-sm btn-outline-secondary w-100" data-page="category-list">
                                        <i class="fas fa-tags me-1"></i> + Kategori
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-sm btn-outline-dark w-100" data-page="item-list">
                                        <i class="fas fa-box me-1"></i> + Item
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="dropdown user-menu">
                        <button class="btn user-btn" type="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->name ?? 'Pengarah HQ') }}&background=1a5632&color=fff&size=40"
                                alt="{{ auth()->user()?->name ?? 'Pengarah HQ' }}" class="user-img">
                            <span
                                class="user-name d-none d-md-inline">{{ auth()->user()?->name ?? 'Pengarah HQ' }}</span>
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item border-bottom" href="#" data-page="profil">
                                <i class="fas fa-user-circle me-2"></i> Profil Saya
                            </a>
                            <a class="dropdown-item" href="#" data-page="tukar-kata-laluan">
                                <i class="fas fa-key me-2"></i> Tukar Kata Laluan
                            </a>
                            <a class="dropdown-item" href="#" data-page="mesej">
                                <i class="fas fa-envelope me-2"></i> Mesej
                            </a>
                            <a class="dropdown-item" href="#" data-page="tetapan">
                                <i class="fas fa-cog me-2"></i> Tetapan
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" id="logoutBtn2">
                                <i class="fas fa-sign-out-alt me-2"></i> Log Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Header End -->

            <!-- ========== Content Area Start ========== -->
            <div class="content-area">
                <!-- Dashboard Page -->
                <div class="page-content active" id="home-content">
                    <!-- Welcome Banner -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="welcome-banner">
                                <div class="banner-content">
                                    <h2>Selamat Datang, {{ auth()->user()?->name ?? 'Pengarah HQ' }}</h2>
                                    <p class="mb-0">Sistem Pengurusan Penjara terintegrasi untuk pengurusan banduan,
                                        institusi, dan operasi harian.</p>
                                </div>
                                <div class="banner-actions">
                                    <button class="btn btn-light" data-page="quick-guide"><i
                                            class="fas fa-rocket me-2"></i>Panduan
                                        Pantas</button>
                                    <button class="btn btn-primary" data-page="laporan"><i
                                            class="fas fa-chart-line me-2"></i>Lihat
                                        Laporan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card card-inmates">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-2">Jumlah Pembekal</h6>
                                            <h2 class="mb-0" id="total-inmates">{{ $totalSuppliers ?? 0 }}</h2>
                                            <div class="stat-change up">
                                                <i class="fas fa-arrow-up me-1"></i>
                                                <span>5.2% dari bulan lepas</span>
                                            </div>
                                        </div>
                                        <div class="stat-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="progress mt-3" style="height: 6px;">
                                        <div class="progress-bar" style="width: 85%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card card-institutions">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-2">Jumlah Institusi</h6>
                                            <h2 class="mb-0" id="total-institutions">{{ $totalInstitutions ?? 0 }}</h2>
                                            <div class="stat-change up">
                                                <i class="fas fa-arrow-up me-1"></i>
                                                <span>2 baru bulan ini</span>
                                            </div>
                                        </div>
                                        <div class="stat-icon">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    </div>
                                    <div class="progress mt-3" style="height: 6px;">
                                        <div class="progress-bar" style="width: 78%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card card-materials">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-2">Senarai Item</h6>
                                            <h2 class="mb-0" id="total-materials">{{ $totalItems ?? 0 }}</h2>
                                            <div class="stat-change down">
                                                <i class="fas fa-arrow-down me-1"></i>
                                                <span>3.2% dari bulan lepas</span>
                                            </div>
                                        </div>
                                        <div class="stat-icon">
                                            <i class="fas fa-utensils"></i>
                                        </div>
                                    </div>
                                    <div class="progress mt-3" style="height: 6px;">
                                        <div class="progress-bar" style="width: 65%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card card-pending">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-2">Menunggu Pengesahan</h6>
                                            <h2 class="mb-0" id="pending-orders">{{ $pendingApprovals ?? 0 }}</h2>
                                            <div class="stat-change up">
                                                <i class="fas fa-arrow-up me-1"></i>
                                                <span>8 permintaan baru</span>
                                            </div>
                                        </div>
                                        <div class="stat-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                    <div class="progress mt-3" style="height: 6px;">
                                        <div class="progress-bar" style="width: 90%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="row mb-4 align-items-stretch">
                        <div class="col-lg-8 d-flex">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Status Stok Bahan Mentah Mengikut Kategori</h5>
                                    <small class="text-muted">Klik bar untuk lihat item dalam kategori</small>
                                    <div class="card-actions">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Lihat Laporan</a></li>
                                                <li><a class="dropdown-item" href="#">Eksport Data</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="populationChart" style="min-height: 300px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 d-flex">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Taburan Institusi</h5>
                                </div>
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <div id="institutionChart" style="min-height: 300px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tables Row -->
                    <div class="row align-items-stretch">
                        <div class="col-lg-8 mb-4 d-flex">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Item Stok Kritikal</h5>
                                    <a href="#" class="btn btn-sm btn-primary" data-page="bahan-mentah">Lihat Semua</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nama Item</th>
                                                    <th>Stok Semasa</th>
                                                    <th>Stok Min</th>
                                                    <th>Status (%)</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="institusi-table-body">
                                                <!-- Data akan dimuatkan via JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-4 d-flex">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Aktiviti Terkini</h5>
                                </div>
                                <div class="card-body">
                                    <div class="activity-timeline" id="activity-timeline">
                                        <!-- Activities will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Forecast Row -->
                    <div class="row mb-4 align-items-stretch">
                        <div class="col-lg-12">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Ramalan Stok 6 Bulan</h5>
                                    <small class="text-muted">Item yang dijangka kekurangan dalam 6 bulan akan datang.</small>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Kategori</th>
                                                    <th>Stok Semasa</th>
                                                    <th>Kiraan Bulan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="forecast-table-body">
                                                <tr><td colspan="5" class="text-center text-muted py-4">Memuatkan ramalan stok...</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar & Messages Row -->
                    <div class="row align-items-stretch">
                        <div class="col-lg-6 mb-4 d-flex">
                            <div class="card h-100 w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="fas fa-calendar me-2"></i>Kalendar</h5>
                                </div>
                                <div class="card-body">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4 d-flex">
                            <div class="card h-100 w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="fas fa-comments me-2"></i>Mesej Terkini</h5>
                                </div>
                                <div class="card-body">
                                    <div class="message-box">
                                        <div class="message-list" id="message-list">
                                            <!-- Messages will be loaded here -->
                                        </div>
                                        <div class="message-input mt-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Tulis mesej..."
                                                    id="message-input">
                                                <button class="btn btn-primary" type="button" id="send-message">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Drilldown Modal -->
                    <div class="modal fade" id="categoryDrilldownModal" tabindex="-1"
                        aria-labelledby="drilldownModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="drilldownModalLabel">Butiran Kategori: <span
                                            id="drilldownCategoryName"></span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nama Item</th>
                                                <th>Stok Semasa</th>
                                                <th>Stok Min</th>
                                                <th>Status (%)</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="drilldown-table-body"></tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Institutions Page -->
                <div class="page-content" id="institusi-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Senarai Institusi Penjara</h5>
                                <p class="text-muted mb-0">30 institusi aktif</p>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-primary me-2" id="addInstitutionBtn">
                                    <i class="fas fa-plus me-1"></i>Tambah Institusi
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-download me-1"></i>Eksport
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="institutions-table">
                                    <thead>
                                        <tr>
                                            <th>BIL</th>
                                            <th>Nama Institusi</th>
                                            <th>Negeri</th>
                                            <th>Jenis</th>
                                            <th>Kapasiti</th>
                                            <th>Penggunaan</th>
                                            <th>Status</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="full-institutions-table">
                                        <!-- Full institutions data will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Raw Materials Page -->
                <div class="page-content" id="bahan-mentah-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Pengurusan Bahan Mentah</h5>
                                <p class="text-muted mb-0">15 bahan aktif | Nilai Inventori: RM 45,230.00</p>
                            </div>
                            <button class="btn btn-sm btn-primary" id="addMaterialBtn">
                                <i class="fas fa-plus me-1"></i>Tambah Bahan
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="materials-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Bahan</th>
                                            <th>Kategori</th>
                                            <th>Stok</th>
                                            <th>Unit</th>
                                            <th>Harga (RM)</th>
                                            <th>Status Stok</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Materials data will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inmates Page -->
                <div class="page-content" id="banduan-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Pengurusan Banduan</h5>
                                <p class="text-muted mb-0">1,245 banduan aktif</p>
                            </div>
                            <button class="btn btn-sm btn-primary" id="addInmateBtn">
                                <i class="fas fa-plus me-1"></i>Tambah Banduan
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="inmates-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Institusi</th>
                                            <th>Status</th>
                                            <th>Tempoh</th>
                                            <th>Umur</th>
                                            <th>Kesalahan</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Inmates data will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verification Page -->
                <div class="page-content" id="pengesahan-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Pengesahan Inden</h5>
                                <p class="text-muted mb-0">4 inden menunggu pengesahan</p>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary">Semua</button>
                                <button class="btn btn-sm btn-outline-warning">Menunggu</button>
                                <button class="btn btn-sm btn-outline-success">Disahkan</button>
                                <button class="btn btn-sm btn-outline-danger">Ditolak</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="verification-table">
                                            <thead>
                                                <tr>
                                                    <th>No. Inden</th>
                                                    <th>Institusi</th>
                                                    <th>Jumlah (RM)</th>
                                                    <th>Tarikh</th>
                                                    <th>Status</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Verification data will be loaded here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Statistik Pengesahan</h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="verificationChart" style="height: 200px;"></div>
                                            <div class="mt-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Menunggu</span>
                                                    <span class="fw-bold">4</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Disahkan</span>
                                                    <span class="fw-bold">12</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Ditolak</span>
                                                    <span class="fw-bold">2</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== Inden Page ===== -->
                <div class="page-content" id="inden-content">

                    <!-- Filter Bar -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form class="row g-3 align-items-end" id="indenFilterForm">
                                <div class="col-lg-4 col-md-6">
                                    <label for="indenInstitusiFilter" class="form-label fw-semibold">
                                        <i class="fas fa-building me-1 text-primary"></i>Pilih Institusi
                                    </label>
                                    <select id="indenInstitusiFilter" class="form-select">
                                        <option value="">-- Semua Institusi --</option>
                                        @foreach($institutions as $inst)
                                            <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label for="indenStatusFilter" class="form-label fw-semibold">
                                        <i class="fas fa-filter me-1 text-primary"></i>Status Inden
                                    </label>
                                    <select id="indenStatusFilter" class="form-select">
                                        <option value="">-- Semua Status --</option>
                                        <option value="Pending">Menunggu</option>
                                        <option value="In Progress">Dalam Proses</option>
                                        <option value="Completed">Selesai</option>
                                        <option value="Rejected">Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4">
                                    <label for="indenDateFrom" class="form-label fw-semibold">Dari Tarikh</label>
                                    <input type="date" id="indenDateFrom" class="form-control">
                                </div>
                                <div class="col-lg-2 col-md-4">
                                    <label for="indenDateTo" class="form-label fw-semibold">Hingga Tarikh</label>
                                    <input type="date" id="indenDateTo" class="form-control">
                                </div>
                                <div class="col-lg-1 col-md-4 d-flex gap-2">
                                    <button type="button" class="btn btn-primary w-100" id="indenTapisBtn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary w-100" id="indenResetBtn" title="Set Semula">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row g-3 mb-4" id="indenSummaryCards">
                        <div class="col-lg-3 col-md-6">
                            <div class="card p-3 h-100 border-0 shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10" style="width:50px;height:50px;">
                                        <i class="fas fa-file-invoice text-primary fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small text-uppercase fw-semibold">Jumlah Inden</div>
                                        <div class="fw-bold fs-4" id="indenStatTotal">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card p-3 h-100 border-0 shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-10" style="width:50px;height:50px;">
                                        <i class="fas fa-clock text-warning fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small text-uppercase fw-semibold">Menunggu</div>
                                        <div class="fw-bold fs-4" id="indenStatPending">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card p-3 h-100 border-0 shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10" style="width:50px;height:50px;">
                                        <i class="fas fa-check-circle text-success fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small text-uppercase fw-semibold">Selesai</div>
                                        <div class="fw-bold fs-4" id="indenStatCompleted">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card p-3 h-100 border-0 shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-info bg-opacity-10" style="width:50px;height:50px;">
                                        <i class="fas fa-dollar-sign text-info fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small text-uppercase fw-semibold">Jumlah Nilai (RM)</div>
                                        <div class="fw-bold fs-4" id="indenStatAmount">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inden Table -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0"><i class="fas fa-list me-2"></i>Senarai Inden</h5>
                                <p class="text-muted mb-0 small">Rekod pesanan/inden mengikut institusi terpilih</p>
                            </div>
                            <div id="indenLoadingBadge" class="d-none">
                                <span class="badge bg-secondary"><i class="fas fa-spinner fa-spin me-1"></i>Memuatkan...</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="inden-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No. Pesanan</th>
                                            <th>Institusi</th>
                                            <th>Pembekal</th>
                                            <th>Tarikh Pesanan</th>
                                            <th>Jumlah (RM)</th>
                                            <th>Status</th>
                                            <th>Pengesahan</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="inden-table-body">
                                        <tr><td colspan="8" class="text-center text-muted py-4"><i class="fas fa-info-circle me-2"></i>Sila pilih institusi atau tekan Tapis untuk melihat data.</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ===== End Inden Page ===== -->

                <!-- Performance Reports Page (Laporan Prestasi) -->
                <div class="page-content" id="laporan-prestasi-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title mb-0">Laporan Prestasi Sistem</h5>
                                        <p class="text-muted mb-0">Prestasi Pembekal dan Ringkasan Inventori</p>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary" id="exportPerformanceReportBtn">
                                        <i class="fas fa-file-export me-1"></i>Eksport Laporan
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4 g-3">
                                        <div class="col-md-4">
                                            <div class="card bg-light border-0">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted mb-2">Penghantaran Tepat Masa</h6>
                                                    <h3 class="mb-0 text-success">92.5%</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light border-0">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted mb-2">Penolakan Kualiti Bahan</h6>
                                                    <h3 class="mb-0 text-danger">3.1%</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light border-0">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted mb-2">Kecekapan Inden</h6>
                                                    <h3 class="mb-0 text-primary">88.4%</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 mb-4 mb-lg-0">
                                            <h6 class="fw-bold mb-3">Tred Prestasi (Indeks Bulanan)</h6>
                                            <div id="performanceTrendChart" style="min-height: 300px;"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h6 class="fw-bold mb-3">Prestasi Teratas Pembekal</h6>
                                            <div id="supplierPerformanceChart" style="min-height: 300px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reports Page -->
                <div class="page-content" id="laporan-content">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Laporan Sistem</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-pdf fa-2x text-danger mb-3"></i>
                                            <h6>Laporan Bulanan</h6>
                                            <button class="btn btn-sm btn-outline-danger mt-2">Muat Turun</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-excel fa-2x text-success mb-3"></i>
                                            <h6>Laporan Tahunan</h6>
                                            <button class="btn btn-sm btn-outline-success mt-2">Muat Turun</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-chart-bar fa-2x text-primary mb-3"></i>
                                            <h6>Analisis Statistik</h6>
                                            <button class="btn btn-sm btn-outline-primary mt-2">Lihat</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-print fa-2x text-secondary mb-3"></i>
                                            <h6>Cetak Laporan</h6>
                                            <button class="btn btn-sm btn-outline-secondary mt-2">Cetak</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Laporan Aktiviti</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Tarikh</th>
                                                            <th>Aktiviti</th>
                                                            <th>Jenis</th>
                                                            <th>Butiran</th>
                                                            <th>Pengguna</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>17/02/2026</td>
                                                            <td>Inden Dibuat</td>
                                                            <td><span class="badge bg-info">Inden</span></td>
                                                            <td>Inden #IN-2026-0456</td>
                                                            <td>Admin</td>
                                                        </tr>
                                                        <tr>
                                                            <td>16/02/2026</td>
                                                            <td>Banduan Didaftar</td>
                                                            <td><span class="badge bg-success">Banduan</span></td>
                                                            <td>ID: INM-7823</td>
                                                            <td>Operator</td>
                                                        </tr>
                                                        <tr>
                                                            <td>15/02/2026</td>
                                                            <td>Bahan Ditambah</td>
                                                            <td><span class="badge bg-warning">Bahan</span></td>
                                                            <td>Bahan "Kain"</td>
                                                            <td>Admin</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Statistik Laporan</h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="reportStatsChart" style="height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics Page -->
                <div class="page-content" id="analitik-content">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Analitik Lanjutan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div id="analyticsChart" style="height: 400px;"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">KPI Utama</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="kpi-item mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <span>Kadar Penggunaan Institusi</span>
                                                    <span class="fw-bold">78%</span>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar" style="width: 78%"></div>
                                                </div>
                                            </div>
                                            <div class="kpi-item mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <span>Kadar Pengulangan Jenayah</span>
                                                    <span class="fw-bold">12%</span>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-success" style="width: 12%"></div>
                                                </div>
                                            </div>
                                            <div class="kpi-item mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <span>Kepuasan Banduan</span>
                                                    <span class="fw-bold">65%</span>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-warning" style="width: 65%"></div>
                                                </div>
                                            </div>
                                            <div class="kpi-item">
                                                <div class="d-flex justify-content-between">
                                                    <span>Kecekapan Operasi</span>
                                                    <span class="fw-bold">88%</span>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-info" style="width: 88%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Trend Jenayah</h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="crimeTrendChart" style="height: 300px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Analisis Demografi Banduan</h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="demographicChart" style="height: 300px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Page -->
                <div class="page-content" id="pengguna-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Pengurusan Pengguna</h5>
                                <p class="text-muted mb-0">25 pengguna aktif</p>
                            </div>
                            <button class="btn btn-sm btn-primary" id="addUserBtn">
                                <i class="fas fa-user-plus me-1"></i>Tambah Pengguna
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h6 class="mb-0">Admin</h6>
                                            <h2 class="mb-0">3</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h6 class="mb-0">Penyelia</h6>
                                            <h2 class="mb-0">8</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h6 class="mb-0">Operator</h6>
                                            <h2 class="mb-0">12</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h6 class="mb-0">Pemerhati</h6>
                                            <h2 class="mb-0">2</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover" id="users-table">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Jawatan</th>
                                            <th>Institusi</th>
                                            <th>Status</th>
                                            <th>Tarikh Daftar</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name=Admin+Prison&background=1a5632&color=fff&size=32"
                                                        class="rounded-circle me-2" width="32" height="32">
                                                    <div>
                                                        <div class="fw-medium">Admin Prison</div>
                                                        <small class="text-muted">admin</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>pengarah.hq@gmail.com</td>
                                            <td><span class="badge bg-primary">Administrator</span></td>
                                            <td>Semua Institusi</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                            <td>01/01/2025</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button class="btn btn-outline-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name=Supervisor+A&background=198754&color=fff&size=32"
                                                        class="rounded-circle me-2" width="32" height="32">
                                                    <div>
                                                        <div class="fw-medium">Supervisor A</div>
                                                        <small class="text-muted">supervisor_a</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>supervisor@prison.gov.my</td>
                                            <td><span class="badge bg-success">Penyelia</span></td>
                                            <td>Penjara Kajang</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                            <td>15/02/2025</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button class="btn btn-outline-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Page -->
                <div class="page-content" id="tetapan-content">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Tetapan Sistem</h5>
                                </div>
                                <div class="card-body">
                                    <form id="systemSettingsForm">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Sistem</label>
                                            <input type="text" class="form-control" value="Sistem Pengurusan Penjara">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Versi</label>
                                            <input type="text" class="form-control" value="2.1.0" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Zon Masa</label>
                                            <select class="form-select">
                                                <option selected>UTC+08:00 (Malaysia Time)</option>
                                                <option>UTC+00:00 (GMT)</option>
                                                <option>UTC-05:00 (EST)</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Format Tarikh</label>
                                            <select class="form-select">
                                                <option selected>DD/MM/YYYY</option>
                                                <option>MM/DD/YYYY</option>
                                                <option>YYYY-MM-DD</option>
                                            </select>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="notificationsSwitch"
                                                checked>
                                            <label class="form-check-label"
                                                for="notificationsSwitch">Pemberitahuan</label>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="autoSaveSwitch" checked>
                                            <label class="form-check-label" for="autoSaveSwitch">Auto Save</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Simpan Tetapan</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Tetapan Keselamatan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-title">Kata Laluan</h6>
                                                    <p class="text-muted small">Kemaskini kata laluan anda</p>
                                                    <button class="btn btn-outline-primary btn-sm">Tukar Kata
                                                        Laluan</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-title">2-Faktor Autentikasi</h6>
                                                    <p class="text-muted small">Tambah lapisan keselamatan</p>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="2faSwitch">
                                                        <label class="form-check-label" for="2faSwitch">Aktifkan
                                                            2FA</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Log Aktiviti</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Masa</th>
                                                            <th>Aktiviti</th>
                                                            <th>IP Address</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>17/02/2026 10:30</td>
                                                            <td>Log Masuk</td>
                                                            <td>192.168.1.100</td>
                                                            <td><span class="badge bg-success">Berjaya</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>17/02/2026 09:15</td>
                                                            <td>Kemaskini Tetapan</td>
                                                            <td>192.168.1.100</td>
                                                            <td><span class="badge bg-success">Berjaya</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>16/02/2026 16:45</td>
                                                            <td>Cubaan Log Masuk</td>
                                                            <td>203.0.113.5</td>
                                                            <td><span class="badge bg-danger">Gagal</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Messages Page -->
                <div class="page-content" id="mesej-content">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Senarai Perbualan</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <a href="#" class="list-group-item list-group-item-action active">
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Supervisor+A&background=198754&color=fff&size=40"
                                                    class="rounded-circle me-3" width="40" height="40">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Supervisor A</h6>
                                                    <small class="text-muted">Hai, ada mesyuarat esok...</small>
                                                </div>
                                                <small class="text-muted">10:30</small>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Operator+B&background=0dcaf0&color=fff&size=40"
                                                    class="rounded-circle me-3" width="40" height="40">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Operator B</h6>
                                                    <small class="text-muted">Stok bahan perlu ditambah...</small>
                                                </div>
                                                <small class="text-muted">09:15</small>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Manager+C&background=6f42c1&color=fff&size=40"
                                                    class="rounded-circle me-3" width="40" height="40">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Manager C</h6>
                                                    <small class="text-muted">Laporan siap belum?</small>
                                                </div>
                                                <small class="text-muted">Semalam</small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Supervisor+A&background=198754&color=fff&size=32"
                                        class="rounded-circle me-3" width="32" height="32">
                                    <div>
                                        <h6 class="mb-0">Supervisor A</h6>
                                        <small class="text-muted">Aktif sekarang</small>
                                    </div>
                                    <div class="ms-auto">
                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary ms-2">
                                            <i class="fas fa-video"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body message-body">
                                    <div class="message-container" id="message-container">
                                        <div class="message received">
                                            <div class="message-content">
                                                <p>Hai Admin, ada mesyuarat esok pukul 10 pagi di Penjara Kajang.</p>
                                                <small class="text-muted">10:30 AM</small>
                                            </div>
                                        </div>
                                        <div class="message sent">
                                            <div class="message-content">
                                                <p>Baik, terima kasih atas makluman. Saya akan hadir.</p>
                                                <small class="text-muted">10:32 AM</small>
                                            </div>
                                        </div>
                                        <div class="message received">
                                            <div class="message-content">
                                                <p>Jangan lupa bawa laporan analitik bulanan.</p>
                                                <small class="text-muted">10:33 AM</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="message-input mt-3">
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button">
                                                <i class="fas fa-paperclip"></i>
                                            </button>
                                            <input type="text" class="form-control"
                                                placeholder="Tulis mesej anda di sini...">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Page -->
                <div class="page-content" id="kalendar-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Kalendar Aktiviti</h5>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" id="prevMonth">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-primary" id="nextMonth">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" id="todayBtn">Hari Ini</button>
                                <button class="btn btn-sm btn-outline-primary" id="addEventBtn">
                                    <i class="fas fa-plus me-1"></i>Tambah Acara
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="fullCalendar"></div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Acara Akan Datang</h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Mesyuarat Pengurusan</h6>
                                                    <small class="text-muted">16 Februari 2026, 10:00 AM</small>
                                                </div>
                                                <span class="badge bg-primary">Mesyuarat</span>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Lawatan Pemeriksaan</h6>
                                                    <small class="text-muted">18 Februari 2026, 2:00 PM</small>
                                                </div>
                                                <span class="badge bg-success">Lawatan</span>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Latihan Kakitangan</h6>
                                                    <small class="text-muted">20 Februari 2026, 9:00 AM</small>
                                                </div>
                                                <span class="badge bg-warning">Latihan</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Statistik Acara</h6>
                                </div>
                                <div class="card-body">
                                    <div id="calendarStatsChart" style="height: 200px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Admin List Page -->
            <div class="page-content" id="admin-list-content">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Senarai Admin</h5>
                            <p class="text-muted mb-0">Senarai Pendaftaran Pengguna</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <select id="role-filter" class="form-select form-select-sm me-2" style="width: auto;">
                                <option value="">Semua Peranan</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <button class="btn btn-sm btn-primary" id="addAdminBtn" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                                <i class="fas fa-plus me-1"></i>Pendaftaran Baru
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="admin-list-table">
                                <thead>
                                    <tr>
                                        <th>BIL</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Peranan</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Position List Page -->
            <div class="page-content" id="position-list-content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Senarai Jawatan</h5>
                                <button class="btn btn-sm btn-primary" id="addPositionBtn" data-bs-toggle="modal" data-bs-target="#addPositionModal">
                                    <i class="fas fa-plus me-1"></i>Tambah Jawatan
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="position-list-table">
                                        <thead>
                                            <tr>
                                                <th>BIL</th>
                                                <th>Kod</th>
                                                <th>Jawatan</th>
                                                <th>Gred</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Populated by JS -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Statistik Jawatan</h5>
                            </div>
                            <div class="card-body">
                                <div id="positionChart" style="min-height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Supplier List Page -->
            <div class="page-content" id="supplier-list-content">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Senarai Pembekal</h5>
                        <button class="btn btn-sm btn-primary" id="addSupplierBtn" data-bs-toggle="modal" data-bs-target="#addSupplierModal"><i class="fas fa-plus me-1"></i>Tambah Pembekal</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="supplier-list-table">
                                <thead>
                                    <tr>
                                        <th>BIL</th>
                                        <th>Nama Syarikat</th>
                                        <th>PIC <i class="fas fa-info-circle text-muted ms-1" style="cursor:help;" data-bs-toggle="tooltip" data-bs-placement="top" title="Orang untuk dihubungi"></i></th>
                                        <th>No. Telefon</th>
                                        <th>Emel</th>
                                        <th>Negeri</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category List Page -->
            <div class="page-content" id="category-list-content">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Senarai Kategori Item</h5>
                        <button class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Tambah Kategori</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="category-list-table">
                                <thead>
                                    <tr>
                                        <th>BIL</th>
                                        <th>Kod</th>
                                        <th>Nama Kategori</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item List Page -->
            <div class="page-content" id="item-list-content">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Senarai Item</h5>
                        <button class="btn btn-sm btn-primary" id="addItemBtn" data-bs-toggle="modal" data-bs-target="#addItemModal"><i class="fas fa-plus me-1"></i>Tambah Item</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="item-list-table">
                                <thead>
                                    <tr>
                                        <th>BIL</th>
                                        <th>Nama Item</th>
                                        <th>Kategori</th>
                                        <th>Subkategori</th>
                                        <th>Had siling</th>
                                        <th>Harga seunit</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- UOM List Page -->
            <div class="page-content" id="uom-list-content">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Senarai Unit Ukuran (UOM)</h5>
                        <button class="btn btn-sm btn-primary" id="addUomBtn" data-bs-toggle="modal" data-bs-target="#addUomModal"><i class="fas fa-plus me-1"></i>Tambah UOM</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="uom-list-table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>BIL</th>
                                        <th>Kod UOM</th>
                                        <th>Keterangan</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Guide Page -->
            <div class="page-content" id="quick-guide-content">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Panduan Pantas Sistem</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-primary">
                                    <div class="card-body">
                                        <div class="text-primary mb-3">
                                            <i class="fas fa-desktop fa-2x"></i>
                                        </div>
                                        <h6>Navigasi Asas</h6>
                                        <p class="small text-muted">Gunakan sidebar untuk bertukar antara modul
                                            Institusi, Banduan, dan Bahan Mentah.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-success">
                                    <div class="card-body">
                                        <div class="text-success mb-3">
                                            <i class="fas fa-plus-circle fa-2x"></i>
                                        </div>
                                        <h6>Tambah Data</h6>
                                        <p class="small text-muted">Klik butang "Tambah" di setiap halaman modul untuk
                                            memasukkan data baru ke dalam sistem.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-info">
                                    <div class="card-body">
                                        <div class="text-info mb-3">
                                            <i class="fas fa-file-alt fa-2x"></i>
                                        </div>
                                        <h6>Penjanaan Laporan</h6>
                                        <p class="small text-muted">Akses modul Laporan untuk memuat turun statistik
                                            bulanan dalam format PDF atau Excel.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Memerlukan bantuan lanjut? Sila hubungi Ibu Pejabat Penjara Malaysia Kajang-Semenyih di talian <strong>03-8732 8000</strong>.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Page -->
            <div class="page-content" id="profil-content">
                <div class="row justify-content-center">
                    <div class="col-lg-5 mb-4">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <div class="position-relative d-inline-block mb-3">
                                    <img src="{{ auth()->user()?->image ? asset('storage/' . auth()->user()->image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()?->name ?? 'Pengarah HQ') . '&background=1a5632&color=fff&size=150' }}"
                                        alt="Profile Picture" class="rounded-circle img-thumbnail" id="profileAvatar"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                    <button
                                        class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle"
                                        id="btnChangeAvatar" title="Tukar Gambar">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                    <input type="file" id="avatarInput" style="display: none;" accept="image/*">
                                </div>
                                <h4 class="mb-0" id="profileNameDisplay">{{ auth()->user()?->name ?? 'Pengarah HQ' }}
                                </h4>
                                <p class="text-muted">Pentadbir Sistem</p>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-primary" id="btnEditProfile">
                                        <i class="fas fa-edit me-2"></i>Kemaskini Profil
                                    </button>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-4">
                                <div class="row text-center mb-3">
                                    <div class="col-6 border-end">
                                        <h5 class="mb-0">Aktif</h5>
                                        <small class="text-muted">Status</small>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-0">Aktif</h5>
                                        <small class="text-muted">Status</small>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 px-3">
                                    <button class="btn btn-warning btn-sm"
                                        onclick="window.prisonSystem.navigateTo('tukar-kata-laluan')">
                                        <i class="fas fa-key me-2"></i>Tukar Kata Laluan
                                    </button>
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
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                        <span><i class="fas fa-envelope me-2 text-primary"></i>Email</span>
                                        <span class="fw-medium">{{ auth()->user()?->email ?? 'pengarah.hq@gmail.com'
                                            }}</span>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                        <span><i class="fas fa-phone me-2 text-primary"></i>No. Telefon</span>
                                        <span class="fw-medium">{{ auth()->user()?->phone_number ?? '-' }}</span>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                        <span><i class="fas fa-building me-2 text-primary"></i>Institusi</span>
                                        <span
                                            class="fw-medium" id="displayProfileInstitution">{{ auth()->user()?->institution?->name ?? 'Ibu Pejabat Penjara' }}</span>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                        <span><i class="fas fa-calendar-alt me-2 text-primary"></i>Tarikh Sertai</span>
                                        <span class="fw-medium">01 Jan 2025</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-10">
                        <!-- Update Profile Tab -->
                        <div class="card mb-4" id="cardUpdateProfile" style="display: none;">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Kemaskini Maklumat Profil</h5>
                                <button class="btn btn-sm btn-link text-decoration-none"
                                    id="btnCancelEdit">Batal</button>
                            </div>
                            <div class="card-body">
                                <form id="formUpdateProfile" action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Penuh</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ auth()->user()?->name }}" id="inputProfileName" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ auth()->user()?->email }}" id="inputProfileEmail" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Institusi</label>
                                            <select class="form-select" name="institution_id" id="inputProfileInstitution">
                                                <option value="">Pilih Institusi</option>
                                                @foreach($institutions as $inst)
                                                    <option value="{{ $inst->id }}" {{ (auth()->user()->institution_id == $inst->id) ? 'selected' : '' }}>
                                                        {{ $inst->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password Page -->
            <div class="page-content" id="tukar-kata-laluan-content">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="fas fa-key me-2 text-warning"></i>Tukar Kata
                                    Laluan</h5>
                            </div>
                            <div class="card-body">
                                <form id="formChangePasswordStandalone" action="{{ route('profile.password') }}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Kata Laluan Semasa</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="current_password"
                                                id="currentPassword" required>
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kata Laluan Baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password" id="newPassword"
                                                required>
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sahkan Kata Laluan Baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                id="confirmPassword" required>
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="alert alert-info py-2">
                                        <small><i class="fas fa-info-circle me-1"></i> Kata laluan mestilah mengandungi
                                            sekurang-kurangnya 8 aksara termasuk huruf dan nombor.</small>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-shield-alt me-2"></i>Kemaskini Kata Laluan
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="window.prisonSystem.navigateTo('profil')">Kembali ke
                                            Profil</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== Content Area End ========== -->

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">&copy; 2026 <strong>Sistem Inventori Dan Pengurusan Makanan</strong>. Hak cipta
                                terpelihara.</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-0">Versi 2.2.0 | Dikemaskini: 17 Feb 2026 | <span id="server-status"
                                    class="text-success"><i class="fas fa-circle"></i> Server Aktif</span></p>
                        </div>
                    </div>
                    <div class="row mt-2 border-top pt-2">
                        <div class="col-12 text-center">
                            <p class="text-muted small mb-0">Jabatan Penjara Malaysia tidak bertanggungjawab terhadap
                                sebarang kehilangan atau kerosakan yang dialami kerana menggunakan maklumat yang dicapai
                                dalam laman ini.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </main>
        <!-- ========== Main Content End ========== -->
    </div>

    <!-- Add Institution Modal -->
    <div class="modal fade" id="addInstitutionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Institusi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addInstitutionForm">
                        <div class="mb-3">
                            <label for="institutionName" class="form-label">Nama Institusi</label>
                            <input type="text" class="form-control" id="institutionName" required>
                        </div>
                        <div class="mb-3">
                            <label for="institutionType" class="form-label">Jenis Institusi</label>
                            <select class="form-select" id="institutionType" required>
                                <option value="Penjara">Penjara</option>
                                <option value="Pusat Koreksional">Pusat Koreksional</option>
                                <option value="Penjara Reman">Penjara Reman</option>
                                <option value="Pusat Pemulihan">Pusat Pemulihan</option>
                                <option value="Sekolah Henry Gurney">Sekolah Henry Gurney</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="institutionPhone" class="form-label fw-semibold">No telefon</label>
                            <input type="tel" class="form-control" id="institutionPhone" placeholder="Cth: 012-3456789">
                        </div>
                        <div class="mb-3">
                            <label for="institutionCapacity" class="form-label">Kapasiti</label>
                            <input type="number" class="form-control" id="institutionCapacity" required>
                        </div>
                        <div class="mb-3">
                            <label for="institutionStatus" class="form-label fw-semibold">
                                <i class="fas fa-toggle-on me-1 text-success"></i>Status
                            </label>
                            <select class="form-select" id="institutionStatus" required>
                                <option value="active" selected>Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                                <option value="maintenance">Penyelenggaraan</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="institutionState" class="form-label">Negeri</label>
                            <select class="form-select" id="institutionState" required>
                                <option value="">Pilih Negeri</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="institutionAddress" class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt me-1 text-danger"></i>Alamat
                            </label>
                            <textarea class="form-control" id="institutionAddress" rows="2" placeholder="Alamat penuh institusi (pilihan)"></textarea>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="institutionPostcode" class="form-label fw-semibold">Poskod</label>
                                <input type="text" class="form-control" id="institutionPostcode" maxlength="5" placeholder="Cth: 43000">
                            </div>
                            <div class="col-md-6">
                                <label for="institutionDistrict" class="form-label fw-semibold">Daerah</label>
                                <select class="form-select" id="institutionDistrict">
                                    <option value="">Pilih Daerah (pilihan)</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveInstitutionBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Admin Modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pendaftaran Pentadbir Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addAdminForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="adminName" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="adminName" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="adminEmail" class="form-label">Emel</label>
                                <input type="email" class="form-control" id="adminEmail" name="email" required readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="adminPhone" class="form-label">No. Telefon</label>
                                <input type="text" class="form-control" id="adminPhone" name="phone_number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="adminStatus" class="form-label">Status</label>
                                <select class="form-select" id="adminStatus" name="status" required>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="adminInstitution" class="form-label">Institusi</label>
                                <select class="form-select" id="adminInstitution" name="institution_id" required>
                                    <option value="">Pilih Institusi</option>
                                    <!-- Options will be populated -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="adminRole" class="form-label">Peranan</label>
                                <select class="form-select" id="adminRole" name="role_id" required>
                                    <option value="">Pilih Peranan</option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                    <!-- Dynamic based on roles/roles table, using 1/2 as placeholder -->
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="adminImage" class="form-label">Gambar (Pilihan)</label>
                                <input class="form-control" type="file" id="adminImage" name="image" accept="image/*">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveAdminBtn">Daftar Admin</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Detail Modal -->
    <div class="modal fade" id="adminDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white p-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-lg bg-white-50 rounded-circle p-1 me-3">
                            <img id="adm-avatar" src="" class="rounded-circle" width="60" height="60" alt="Admin Avatar">
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="adm-name">Nama Admin</h5>
                            <span class="badge bg-white-20 text-white mt-1" id="adm-role-badge">Administrator</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="detail-group">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Maklumat Peribadi</label>
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="text-muted small">E-mel</div>
                                            <div class="fw-medium" id="adm-email">-</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="text-muted small">No. Telefon</div>
                                            <div class="fw-medium" id="adm-phone">-</div>
                                        </div>
                                        <div class="mb-0">
                                            <div class="text-muted small">Tarikh Daftar</div>
                                            <div class="fw-medium" id="adm-join-date">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-group">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Penugasan</label>
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="text-muted small">Institusi</div>
                                            <div class="fw-medium" id="adm-institution">-</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="text-muted small">Jawatan</div>
                                            <div class="fw-medium" id="adm-position">-</div>
                                        </div>
                                        <div class="mb-0">
                                            <div class="text-muted small">Status Akaun</div>
                                            <span class="badge" id="adm-status-badge">Aktif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary px-4" id="adm-edit-btn">
                        <i class="fas fa-edit me-2"></i>Kemaskini
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Supplier Detail Modal -->
    <div class="modal fade" id="supplierDetailModal" tabindex="-1" aria-labelledby="supplierDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #1a5632 0%, #2e7d57 100%);">
                    <div>
                        <h5 class="modal-title text-white" id="supplierDetailModalLabel">
                            <i class="fas fa-building me-2"></i><span id="sdm-company-name">-</span>
                        </h5>
                        <small class="text-white-50">Maklumat Terperinci Pembekal</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- Status Banner -->
                    <div class="px-4 py-3 border-bottom d-flex align-items-center gap-3" id="sdm-status-banner">
                        <span class="badge fs-6" id="sdm-status-badge">-</span>
                        <small class="text-muted">Tarikh Daftar: <strong id="sdm-created-at">-</strong></small>
                    </div>
                    <div class="row g-0">
                        <!-- Left column -->
                        <div class="col-md-6 border-end">
                            <div class="p-4">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3" style="font-size:0.75rem; letter-spacing:0.05em;">
                                    <i class="fas fa-address-card me-1"></i> Maklumat Syarikat
                                </h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-3">
                                        <div class="text-muted small">Nama Syarikat</div>
                                        <div class="fw-semibold" id="sdm-detail-company">-</div>
                                    </li>
                                    <li class="mb-3">
                                        <div class="text-muted small">PIC</div>
                                        <div class="fw-semibold" id="sdm-contact-person">-</div>
                                    </li>
                                    <li class="mb-3">
                                        <div class="text-muted small"><i class="fas fa-envelope me-1 text-primary"></i>Email</div>
                                        <div><a id="sdm-email" href="#" class="text-decoration-none">-</a></div>
                                    </li>
                                    <li class="mb-0">
                                        <div class="text-muted small"><i class="fas fa-phone me-1 text-success"></i>No. Telefon</div>
                                        <div class="fw-semibold" id="sdm-phone">-</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Right column -->
                        <div class="col-md-6">
                            <div class="p-4">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3" style="font-size:0.75rem; letter-spacing:0.05em;">
                                    <i class="fas fa-map-marker-alt me-1"></i> Maklumat Alamat
                                </h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-3">
                                        <div class="text-muted small">Alamat</div>
                                        <div class="fw-semibold" id="sdm-address">-</div>
                                    </li>
                                    <li class="mb-3">
                                        <div class="text-muted small">Poskod</div>
                                        <div class="fw-semibold" id="sdm-postcode">-</div>
                                    </li>
                                    <li class="mb-3">
                                        <div class="text-muted small">Daerah</div>
                                        <div class="fw-semibold" id="sdm-district">-</div>
                                    </li>
                                    <li class="mb-0">
                                        <div class="text-muted small">Negeri</div>
                                        <div class="fw-semibold" id="sdm-state">-</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="sdm-edit-btn">
                        <i class="fas fa-edit me-1"></i>Kemaskini
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Position Modal -->
    <div class="modal fade" id="addPositionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pendaftaran Jawatan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addPositionForm">
                        <div class="mb-3">
                            <label for="posCode" class="form-label">Kod Jawatan</label>
                            <input type="text" class="form-control" id="posCode" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="posName" class="form-label">Nama Jawatan</label>
                            <input type="text" class="form-control" id="posName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="posGrade" class="form-label">Gred (*cth: KX44)</label>
                            <input type="text" class="form-control" id="posGrade" name="grade" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="savePositionBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Acara Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addEventForm">
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Tajuk Acara</label>
                            <input type="text" class="form-control" id="eventTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Tarikh</label>
                            <input type="date" class="form-control" id="eventDate" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="eventStart" class="form-label">Masa Mula</label>
                                <input type="time" class="form-control" id="eventStart" required>
                            </div>
                            <div class="col-md-6">
                                <label for="eventEnd" class="form-label">Masa Tamat</label>
                                <input type="time" class="form-control" id="eventEnd" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="eventType" class="form-label">Jenis Acara</label>
                            <select class="form-select" id="eventType" required>
                                <option value="meeting">Mesyuarat</option>
                                <option value="visit">Lawatan</option>
                                <option value="training">Latihan</option>
                                <option value="inspection">Pemeriksaan</option>
                                <option value="other">Lain-lain</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="eventDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEventBtn">Simpan Acara</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalTitle">Maklumat Butiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewModalBody">
                    <!-- Content will be populated by JS -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Kemaskini Maklumat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editEntityId">
                        <input type="hidden" id="editEntityType">
                        <div id="editFormFields">
                            <!-- Fields will be populated by JS -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditBtn">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Log Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <div class="modal-body">
                        <p>Adakah anda pasti ingin log keluar dari sistem?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Log Keluar</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pembekal Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Syarikat</label>
                                <input type="text" class="form-control" name="company_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">PIC</label>
                                <input type="text" class="form-control" name="contact_person" required>
                                <div class="form-text text-muted small">Orang untuk dihubungi</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Emel</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. Telefon</label>
                                <input type="text" class="form-control" name="phone_number" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="address" rows="2" required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Poskod</label>
                                <input type="text" class="form-control" name="postcode" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Negeri</label>
                                <select class="form-select" name="state_id" id="supplierState" required>
                                    <option value="">Pilih Negeri</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Daerah</label>
                                <select class="form-select" name="district_id" id="supplierDistrict" required>
                                    <option value="">Pilih Daerah</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveSupplierBtn">Simpan Pembekal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Item Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="addItemForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Item</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    <!-- Options will be populated by JS if possible, or just hardcode for demo -->
                                    <option value="1">Bahan Mentah - Makanan Basah</option>
                                    <option value="2">Bahan Mentah - Makanan Kering</option>
                                    <option value="3">Peralatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Kuantiti Semasa</label>
                                <input type="number" step="0.01" class="form-control" name="current_quantity" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Unit (UOM)</label>
                                <select class="form-select" name="uom_id" id="item_uom_select" required>
                                    <option value="">Pilih Unit</option>
                                    @foreach($uoms as $uom)
                                        <option value="{{ $uom->id }}">{{ $uom->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Harga Seunit (RM)</label>
                                <input type="number" step="0.01" class="form-control" name="price_per_unit" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveItemBtn">Simpan Item</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Uom Modal -->
    <div class="modal fade" id="addUomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="uomModalTitle">Tambah UOM Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="addUomForm">
                        <input type="hidden" name="id" id="uom_id">
                        <div class="mb-3">
                            <label class="form-label">Kod UOM</label>
                            <input type="text" class="form-control" name="code" id="uom_code" required placeholder="Contoh: kg, unit, biji">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="description" id="uom_description" rows="3" placeholder="Penerangan terperinci mengenai unit ukuran ini"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveUomBtn">Simpan UOM</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Action Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmModalTitle"><i class="fas fa-exclamation-triangle me-2"></i>Pengesahan Tindakan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-trash-alt fa-3x text-danger" id="confirmModalIcon"></i>
                    </div>
                    <p class="fs-5 mb-0 text-dark" id="confirmModalMessage">Adakah anda pasti?</p>
                </div>
                <div class="modal-footer bg-light justify-content-center">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger px-4" id="confirmModalBtn">Mengesahkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.0/dist/apexcharts.min.js"></script>

    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('data.js') }}"></script>
    <script>
        // Override hardcoded institutions with database data
        if (window.prisonData) {
            window.prisonData.institutions = @json($institutions ?? []);
            
            @if(isset($rawMaterials))
            // Override rawMaterials with database items for charts and materials table
            window.prisonData.rawMaterials = @json($rawMaterials);
            @endif
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
                                html += `
                                    <div class="search-result-item">
                                        <div class="search-result-icon"><i class="fas ${config.icon}"></i></div>
                                        <div class="search-result-content">
                                            <h6>${item.title}</h6>
                                            <small>${item.subtitle}</small>
                                        </div>
                                    </div>
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

        // ===== INDEN PAGE LOGIC =====
        document.addEventListener('DOMContentLoaded', function() {
            let indenTable = null;

            function initIndenTable() {
                if ($.fn.DataTable.isDataTable('#inden-table')) {
                    $('#inden-table').DataTable().destroy();
                }
                indenTable = $('#inden-table').DataTable({
                    responsive: true,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/ms.json',
                        emptyTable: 'Tiada rekod inden dijumpai.',
                        loadingRecords: 'Memuatkan...',
                        zeroRecords: 'Tiada rekod yang sepadan dijumpai.'
                    },
                    order: [[3, 'desc']],
                    columnDefs: [
                        { orderable: false, targets: [7] }
                    ]
                });
            }

            function getStatusBadge(status) {
                const map = {
                    'Pending':     '<span class="badge bg-warning text-dark">Menunggu</span>',
                    'In Progress': '<span class="badge bg-info">Dalam Proses</span>',
                    'Completed':   '<span class="badge bg-success">Selesai</span>',
                    'Rejected':    '<span class="badge bg-danger">Ditolak</span>',
                };
                return map[status] || `<span class="badge bg-secondary">${status}</span>`;
            }

            function getApprovalBadge(val) {
                if (val === 1) return '<span class="badge bg-success">Disahkan</span>';
                if (val === 2) return '<span class="badge bg-danger">Ditolak</span>';
                return '<span class="badge bg-secondary">Belum Disahkan</span>';
            }

            function loadInden() {
                const institutionId = document.getElementById('indenInstitusiFilter').value;
                const status        = document.getElementById('indenStatusFilter').value;
                const dateFrom      = document.getElementById('indenDateFrom').value;
                const dateTo        = document.getElementById('indenDateTo').value;

                document.getElementById('indenLoadingBadge').classList.remove('d-none');

                const params = new URLSearchParams();
                if (institutionId) params.append('institution_id', institutionId);
                if (status)        params.append('status', status);
                if (dateFrom)      params.append('date_from', dateFrom);
                if (dateTo)        params.append('date_to', dateTo);

                fetch('/api/hq/inden?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    document.getElementById('indenLoadingBadge').classList.add('d-none');

                    // Update stat cards
                    document.getElementById('indenStatTotal').textContent     = data.stats.total;
                    document.getElementById('indenStatPending').textContent   = data.stats.pending;
                    document.getElementById('indenStatCompleted').textContent = data.stats.completed;
                    document.getElementById('indenStatAmount').textContent    = parseFloat(data.stats.total_amount).toLocaleString('ms-MY', {minimumFractionDigits:2, maximumFractionDigits:2});

                    // Rebuild table
                    if ($.fn.DataTable.isDataTable('#inden-table')) {
                        $('#inden-table').DataTable().destroy();
                    }

                    let rows = '';
                    if (data.orders.length === 0) {
                        rows = '<tr><td colspan="8" class="text-center text-muted py-4"><i class="fas fa-inbox me-2"></i>Tiada rekod inden dijumpai.</td></tr>';
                        document.getElementById('inden-table-body').innerHTML = rows;
                        initIndenTable();
                        return;
                    }

                    data.orders.forEach(o => {
                        rows += `<tr>
                            <td><span class="fw-medium">${o.order_no}</span></td>
                            <td>${o.institution_name ?? '-'}</td>
                            <td>${o.supplier_name ?? '-'}</td>
                            <td>${o.order_date ?? '-'}</td>
                            <td class="text-end">RM ${parseFloat(o.total_amount).toLocaleString('ms-MY', {minimumFractionDigits:2})}</td>
                            <td>${getStatusBadge(o.order_status)}</td>
                            <td>${getApprovalBadge(o.approval_status)}</td>
                            <td>
                                <a href="/borang-inden/${o.id}" class="btn btn-sm btn-outline-primary" title="Lihat Borang" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>`;
                    });

                    document.getElementById('inden-table-body').innerHTML = rows;
                    initIndenTable();
                })
                .catch(err => {
                    document.getElementById('indenLoadingBadge').classList.add('d-none');
                    document.getElementById('inden-table-body').innerHTML = '<tr><td colspan="8" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle me-2"></i>Ralat semasa memuatkan data.</td></tr>';
                    console.error('Inden fetch error:', err);
                });
            }

            // Prevent form submit
            const filterForm = document.getElementById('indenFilterForm');
            if(filterForm) {
                filterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    loadInden();
                });
            }

            // Tapis button
            const btnTapis = document.getElementById('indenTapisBtn');
            if(btnTapis) {
                btnTapis.addEventListener('click', loadInden);
            }

            // Reset button
            const btnReset = document.getElementById('indenResetBtn');
            if(btnReset) {
                btnReset.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('indenInstitusiFilter').value = '';
                    document.getElementById('indenStatusFilter').value    = '';
                    document.getElementById('indenDateFrom').value        = '';
                    document.getElementById('indenDateTo').value          = '';
                    loadInden();
                });
            }

            // Auto-load when switching to inden page (tap into SPA nav)
            document.addEventListener('click', function(e) {
                const link = e.target.closest('[data-page]');
                if (link && link.getAttribute('data-page') === 'inden') {
                    setTimeout(loadInden, 100);
                }
            });
        });
        // ===== END INDEN PAGE LOGIC =====
    </script>
    <script src="{{ asset('script.js') }}"></script>
</body>

</html>
