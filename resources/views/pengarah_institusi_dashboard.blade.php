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
                        <a class="nav-link active" href="#" data-page="dashboard">
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
                        <a class="nav-link" href="#" data-page="pembekal">
                            <i class="fas fa-truck"></i>
                            <span>Pembekal</span>
                        </a>
                    </li>
                    <li class="nav-title mt-4">LAPORAN</li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-page="profil">
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
                    <div id="dashboard-group">
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
                            <div class="d-flex flex-wrap gap-2 mb-3 tab-buttons">
                                <button data-page="dashboard" class="btn btn-primary">Dashboard</button>
                                <button data-page="institusi" class="btn btn-outline-primary">Institusi</button>
                                <button data-page="pembekal" class="btn btn-outline-primary">Pembekal</button>
                            </div>
                            <div class="page-content active" id="dashboard-content">
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
                            <div class="page-content" id="institusi-content">
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
                            <div class="page-content" id="pembekal-content">
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
</div><!-- end dashboard-group -->
﻿            <div class="page-content" id="profil-content">
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

        function initSPARouting() {
            const navLinks = document.querySelectorAll('[data-page]');
            const pageContents = document.querySelectorAll('.page-content');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');
                    
                    // Update active nav-links
                    document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
                    const relatedNav = document.querySelector(`.nav-link[data-page="${page}"]`);
                    if(relatedNav) relatedNav.classList.add('active');
                    
                    // Update inline tab buttons if present
                    document.querySelectorAll('.tab-buttons button').forEach(btn => {
                        btn.classList.remove('btn-primary');
                        btn.classList.add('btn-outline-primary');
                        if (btn.getAttribute('data-page') === page) {
                            btn.classList.remove('btn-outline-primary');
                            btn.classList.add('btn-primary');
                        }
                    });

                    // Toggle page contents
                    pageContents.forEach(content => {
                        content.classList.remove('active');
                        content.classList.add('d-none');
                    });
                    const targetContent = document.getElementById(`${page}-content`);
                    
                    if (['dashboard', 'institusi', 'pembekal'].includes(page)) {
                        document.getElementById('dashboard-group').classList.remove('d-none');
                    } else {
                        document.getElementById('dashboard-group').classList.add('d-none');
                    }
                    if(targetContent) {
                        targetContent.classList.remove('d-none');
                        targetContent.classList.add('active');
                    }
                });
            });
            
            // Initial hide of all non-active page-contents (fallback)
            pageContents.forEach(content => {
                if(!content.classList.contains('active')) {
                    content.classList.add('d-none');
                }
            });

            // Mock window.prisonSystem for profile component compatibility
            window.prisonSystem = {
                navigateTo: function(page) {
                    const targetLink = document.querySelector(`[data-page="${page}"]`);
                    if (targetLink) {
                        targetLink.click();
                    } else {
                        document.querySelectorAll('.page-content').forEach(content => {
                            content.classList.remove('active');
                            content.classList.add('d-none');
                        });
                        const targetContent = document.getElementById(`${page}-content`);
                    
                        if (['dashboard', 'institusi', 'pembekal'].includes(page)) {
                            document.getElementById('dashboard-group').classList.remove('d-none');
                        } else {
                            document.getElementById('dashboard-group').classList.add('d-none');
                        }
                        if(targetContent) {
                            targetContent.classList.remove('d-none');
                            targetContent.classList.add('active');
                        }
                    }
                }
            };
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (typeof $ === 'function' && $.fn.DataTable) {
                $('#orders-table').DataTable();
                $('#inventory-table').DataTable();
                $('#suppliers-table').DataTable();
            }

            handleSidebarToggle();
            handleThemeToggle();
            initSPARouting();

            // Profile Edit Form Toggles
            const btnEditProfile = document.getElementById('btnEditProfile');
            const btnCancelEdit = document.getElementById('btnCancelEdit');
            const cardUpdateProfile = document.getElementById('cardUpdateProfile');

            if (btnEditProfile && cardUpdateProfile) {
                btnEditProfile.addEventListener('click', () => {
                    cardUpdateProfile.style.display = 'block';
                    cardUpdateProfile.scrollIntoView({ behavior: 'smooth' });
                });
            }

            if (btnCancelEdit && cardUpdateProfile) {
                btnCancelEdit.addEventListener('click', (e) => {
                    e.preventDefault();
                    cardUpdateProfile.style.display = 'none';
                });
            }

            // Avatar Upload Trigger
            const btnChangeAvatar = document.getElementById('btnChangeAvatar');
            const avatarInput = document.getElementById('avatarInput');
            if (btnChangeAvatar && avatarInput) {
                btnChangeAvatar.addEventListener('click', () => {
                    avatarInput.click();
                });
            }
        });
    </script>
</body>
</html>
