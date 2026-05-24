<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengarah Institusi Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link active" href="{{ route('pengarah.institusi.dashboard') }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-title mt-4">PENGURUSAN DATA</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengarah.institusi.dashboard') }}">
                            <i class="fas fa-building"></i>
                            <span>Institusi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('suppliers.index') }}">
                            <i class="fas fa-truck"></i>
                            <span>Pembekal</span>
                        </a>
                    </li>
                    <li class="nav-title mt-4">LAPORAN</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile') }}">
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
                        <h1>Dashboard</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('pengarah.institusi.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active">Pengarah Institusi</li>
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
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('pengarah.institusi.dashboard') }}" class="row g-3 align-items-end">
                                        <div class="col-lg-6 col-md-8">
                                            <label for="institution_id" class="form-label">Pilih Institusi</label>
                                            <select id="institution_id" name="institution_id" class="form-select">
                                                <option value="">Pilih institusi</option>
                                                @foreach($institutions as $institution)
                                                    <option value="{{ $institution->id }}" {{ optional($selectedInstitution)->id == $institution->id ? 'selected' : '' }}>{{ $institution->name }}</option>
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
                            <div class="card p-4">
                                <h6 class="text-uppercase text-muted mb-3">Institusi Terpilih</h6>
                                <h3 class="mb-0">{{ optional($selectedInstitution)->name ?? 'Tiada institusi dipilih' }}</h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4">
                                <h6 class="text-uppercase text-muted mb-3">Jumlah Pesanan</h6>
                                <h3 class="mb-0">{{ $orders->count() }}</h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4">
                                <h6 class="text-uppercase text-muted mb-3">Jumlah Pembekal</h6>
                                <h3 class="mb-0">{{ $suppliers->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <button id="tab-dashboard" class="btn btn-primary">Dashboard</button>
                                <button id="tab-inventory" class="btn btn-outline-primary">Inventori</button>
                                <button id="tab-suppliers" class="btn btn-outline-primary">Pembekal</button>
                            </div>
                            <div id="dashboard-section">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Ringkasan Pesanan</h5>
                                        <p class="text-muted">Lihat semua pesanan untuk institusi terpilih.</p>
                                        <div class="table-responsive">
                                            <table id="orders-table" class="table table-bordered table-striped">
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
                            </div>
                            <div id="inventory-section" class="d-none">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Inventori Pesanan</h5>
                                        <div class="table-responsive">
                                            <table id="inventory-table" class="table table-bordered table-striped">
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
                            </div>
                            <div id="suppliers-section" class="d-none">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Senarai Pembekal</h5>
                                        <div class="table-responsive">
                                            <table id="suppliers-table" class="table table-bordered table-striped">
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
                            </div>
                        </div>
                    </div>
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

        function setActiveTab(tabId) {
            ['tab-dashboard', 'tab-inventory', 'tab-suppliers'].forEach(id => {
                const button = document.getElementById(id);
                if (!button) return;
                button.classList.toggle('btn-primary', id === tabId);
                button.classList.toggle('btn-outline-primary', id !== tabId);
            });
        }

        function showSection(sectionId) {
            ['dashboard-section', 'inventory-section', 'suppliers-section'].forEach(id => {
                const section = document.getElementById(id);
                if (!section) return;
                section.classList.toggle('d-none', id !== sectionId);
            });
            setActiveTab('tab-' + sectionId.replace('-section', ''));
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (typeof $ === 'function' && $.fn.DataTable) {
                $('#orders-table').DataTable();
                $('#inventory-table').DataTable();
                $('#suppliers-table').DataTable();
            }

            handleSidebarToggle();
            handleThemeToggle();

            document.getElementById('tab-dashboard').addEventListener('click', function () {
                showSection('dashboard-section');
            });
            document.getElementById('tab-inventory').addEventListener('click', function () {
                showSection('inventory-section');
            });
            document.getElementById('tab-suppliers').addEventListener('click', function () {
                showSection('suppliers-section');
            });
        });
    </script>
</body>
</html>
