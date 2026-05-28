@php
    $activePage = $activePage ?? 'dashboard';
    $pageTitles = [
        'dashboard' => 'Dashboard',
        'institusi' => 'Institusi',
        'pembekal' => 'Pembekal',
        'profil' => 'Profil Saya',
    ];
    $pageRoutes = [
        'dashboard' => 'pengarah.institusi.dashboard',
        'institusi' => 'pengarah.institusi.institusi',
        'pembekal' => 'pengarah.institusi.pembekal',
        'profil' => 'pengarah.institusi.profil',
    ];
    $pageTitle = $pageTitles[$activePage] ?? 'Dashboard';
    $currentRoute = $pageRoutes[$activePage] ?? 'pengarah.institusi.dashboard';
    $institutionQuery = request()->only('institution_id');
@endphp

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} Pengarah Institusi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <li class="nav-title">MAIN</li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.institusi.dashboard') ? 'active' : '' }}" href="{{ route('pengarah.institusi.dashboard', $institutionQuery) }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">PENGURUSAN DATA</li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.institusi.institusi') ? 'active' : '' }}" href="{{ route('pengarah.institusi.institusi', $institutionQuery) }}">
                            <i class="fas fa-building"></i>
                            <span>Institusi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengarah.institusi.pembekal') ? 'active' : '' }}" href="{{ route('pengarah.institusi.pembekal', $institutionQuery) }}">
                            <i class="fas fa-truck"></i>
                            <span>Pembekal</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">LAPORAN</li>
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
                    <div class="search-box me-3">
                        <input type="text" class="form-control" placeholder="Cari...">
                        <i class="fas fa-search"></i>
                    </div>
                    <button class="btn btn-icon" id="themeToggle">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </header>

            <div class="content-body">
                <div class="container-fluid py-4">
                    @if($activePage !== 'profil')
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
                                                    <td>{{ $order->status }}</td>
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
                                                <th>Nama Item</th>
                                                <th>Jumlah Dipesan</th>
                                                <th>Jumlah Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($inventoryItems as $item)
                                                <tr>
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
                                                <th>Contact Person</th>
                                                <th>Email</th>
                                                <th>Negeri</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($suppliers as $supplier)
                                                <tr>
                                                    <td>{{ $supplier->id }}</td>
                                                    <td>{{ $supplier->company_name }}</td>
                                                    <td>{{ $supplier->contact_person }}</td>
                                                    <td>{{ $supplier->email }}</td>
                                                    <td>{{ optional($supplier->state)->name }}</td>
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
                                                <span><i class="fas fa-envelope me-2 text-primary"></i>Email</span>
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
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
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
                $('#orders-table, #inventory-table, #suppliers-table').DataTable({
                    responsive: true,
                });
            }

            handleSidebarToggle();
            handleThemeToggle();

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
        });
    </script>
</body>
</html>
