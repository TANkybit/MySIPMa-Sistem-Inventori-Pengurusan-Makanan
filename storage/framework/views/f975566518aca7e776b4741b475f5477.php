<?php
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
        'dashboard' => 'pengarah.institusi.dashboard',
        'ringkasan' => 'pengarah.institusi.ringkasan',
        'institusi' => 'pengarah.institusi.institusi',
        'pembekal' => 'pengarah.institusi.pembekal',
        'senarai_user' => 'pengarah.institusi.senarai_pengguna',
        'profil' => 'pengarah.institusi.profil',
    ];
    $pageTitle = $pageTitles[$activePage] ?? 'Papan Pemuka';
    $currentRoute = $pageRoutes[$activePage] ?? 'pengarah.institusi.dashboard';
    $institutionQuery = request()->only('institution_id');
?>

<!DOCTYPE html>
<html lang="ms" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?> Pengarah Institusi</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="session-lifetime" content="<?php echo e(config('session.lifetime')); ?>">
    <meta name="session-warning" content="<?php echo e(config('session-timeout.warning_time')); ?>">
    <meta name="session-grace" content="<?php echo e(config('session-timeout.grace_period')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('style.css')); ?>">
</head>
<body>
    <div class="wrapper">
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <a href="<?php echo e(route('pengarah.institusi.dashboard')); ?>" class="logo">
                    <div class="logo-icon">
                        <img src="<?php echo e(asset('MySIPMa_logo_wWalls.png')); ?>" alt="MySIPMa Logo" height="50" class="me-2">
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
                        <a class="nav-link <?php echo e(request()->routeIs('pengarah.institusi.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('pengarah.institusi.dashboard', $institutionQuery)); ?>">
                            <i class="fas fa-home"></i>
                            <span>Papan Pemuka</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">PENGURUSAN DATA</li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('pengarah.institusi.ringkasan') ? 'active' : ''); ?>" href="<?php echo e(route('pengarah.institusi.ringkasan')); ?>">
                            <i class="fas fa-file-invoice"></i>
                            <span>Ringkasan Pesanan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('pengarah.institusi.institusi') ? 'active' : ''); ?>" href="<?php echo e(route('pengarah.institusi.institusi')); ?>">
                            <i class="fas fa-boxes"></i>
                            <span>Inventori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('pengarah.institusi.pembekal') ? 'active' : ''); ?>" href="<?php echo e(route('pengarah.institusi.pembekal')); ?>">
                            <i class="fas fa-truck"></i>
                            <span>Pembekal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('pengarah.institusi.senarai_pengguna') ? 'active' : ''); ?>" href="<?php echo e(route('pengarah.institusi.senarai_pengguna')); ?>">
                            <i class="fas fa-users"></i>
                            <span>Senarai Pengguna</span>
                        </a>
                    </li>

                    <li class="nav-title mt-4">LAPORAN</li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('pengarah.institusi.profil') ? 'active' : ''); ?>" href="<?php echo e(route('pengarah.institusi.profil')); ?>">
                            <i class="fas fa-user"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(auth()->user()?->name ?? 'Pengarah Institusi')); ?>&background=1a5632&color=fff&size=80" alt="<?php echo e(auth()->user()?->name ?? 'Pengarah Institusi'); ?>" class="user-avatar">
                    <div class="user-info">
                        <h6><?php echo e(auth()->user()?->name ?? 'Pengarah Institusi'); ?></h6>
                        <small class="text-muted">Pengarah Institusi</small>
                    </div>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
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
                        <h1><?php echo e($pageTitle); ?></h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo e(route('pengarah.institusi.dashboard')); ?>"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item">Pengarah Institusi</li>
                                <li class="breadcrumb-item active"><?php echo e($pageTitle); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="header-right">
                    <div class="search-box me-3 position-relative">
                        <input type="text" id="globalSearchInput" data-context="institusi" data-filter-id="<?php echo e(optional($selectedInstitution)->id); ?>" class="form-control" placeholder="Cari Maklumat...">
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
                    <?php if($activePage === 'dashboard'): ?>
                    
                    

                    <?php echo $__env->make('partials.low_stock_notification', [
                        'lowStockItems' => $lowStockItems ?? collect(),
                        'inventoryUrl' => route('pengarah.institusi.institusi'),
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="row g-3 mb-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4 h-100">
                                <h6 class="text-uppercase text-muted mb-3">Institusi Terpilih</h6>
                                <h3 class="mb-0"><?php echo e(optional($selectedInstitution)->name ?? 'Tiada institusi dipilih'); ?></h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4 h-100">
                                <h6 class="text-uppercase text-muted mb-3">Jumlah Pesanan</h6>
                                <h3 class="mb-0"><?php echo e($orders->count()); ?></h3>
                                <div class="small text-muted mt-2">Jumlah Item: <strong><?php echo e(number_format($inventoryTotals['total_quantity'] ?? 0, 2)); ?></strong> &nbsp;•&nbsp; Nilai: <strong>RM <?php echo e(number_format($inventoryTotals['total_value'] ?? 0, 2)); ?></strong></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4 h-100">
                                <h6 class="text-uppercase text-muted mb-3">Jumlah Pembekal</h6>
                                <h3 class="mb-0"><?php echo e($suppliers->count()); ?></h3>
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
                    <?php endif; ?>

                    <?php if($activePage === 'dashboard'): ?>
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
                                    <div class="card-header bg-white border-0 pt-4 pb-0">
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
                                                <thead class="table-light">
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
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pb-2 pt-4 px-4">
                                        <h5 class="card-title fw-bold mb-0"><i class="fas fa-clock text-warning me-2"></i>5 Pesanan Terkini</h5>
                                        <a href="<?php echo e(route('pengarah.institusi.ringkasan')); ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0" id="recentOrdersTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="ps-4">No. Pesanan</th>
                                                        <th>Tarikh</th>
                                                        <th>Status</th>
                                                        <th>Pembekal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td colspan="4" class="text-center py-4 text-muted">Memuatkan...</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data carta dihantar terus ke JavaScript -->
                        <script>window.dashboardChartData = <?php echo $dashboardData ?? '{}'; ?>;</script>

                    <?php elseif($activePage === 'ringkasan'): ?>
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
                                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($order->id); ?></td>
                                                    <td><?php echo e($order->order_no); ?></td>
                                                    <td><?php echo e($order->order_date); ?></td>
                                                    <td><?php echo e(number_format($order->total_amount, 2)); ?></td>
                                                    <td>
                                                        <?php
                                                            $statusMalay = match($order->status) {
                                                                'Pending' => 'Menunggu',
                                                                'In Progress' => 'Dalam Proses',
                                                                'Completed' => 'Selesai',
                                                                'Rejected' => 'Ditolak',
                                                                default => $order->status
                                                            };
                                                        ?>
                                                        <span class="badge <?php echo e($order->status == 'Pending' ? 'bg-warning' : ($order->status == 'In Progress' ? 'bg-primary' : ($order->status == 'Completed' ? 'bg-success' : 'bg-danger'))); ?>">
                                                            <?php echo e($statusMalay); ?>

                                                        </span>
                                                    </td>
                                                    <td><?php echo e(optional($order->supplier)->company_name); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php elseif($activePage === 'institusi'): ?>
                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div>
                                                <h5 class="card-title mb-0">Inventori Pesanan</h5>
                                                <p class="text-muted small mb-0">Lihat ringkasan item yang dipesan untuk institusi terpilih.</p>
                                            </div>
                                            <form id="inventoryFilterForm" method="GET" action="<?php echo e(route('pengarah.institusi.institusi')); ?>" class="d-flex gap-2 align-items-center">
                                                <label class="mb-0 small text-muted">Tahun:</label>
                                                <select name="year" id="inventoryFilterYear" class="form-select form-select-sm" style="width:120px;">
                                                    <option value="">Semua</option>
                                                    <?php for($y = now()->year; $y >= now()->year - 5; $y--): ?>
                                                        <option value="<?php echo e($y); ?>" <?php echo e(request('year') == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                                                    <?php endfor; ?>
                                                </select>

                                                <label class="mb-0 small text-muted ms-2">Bulan:</label>
                                                <select name="month" id="inventoryFilterMonth" class="form-select form-select-sm" style="width:140px;">
                                                    <option value="">Semua</option>
                                                    <?php $__currentLoopData = [1=>'Jan',2=>'Feb',3=>'Mac',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Ogo',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Dis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($m); ?>" <?php echo e(request('month') == $m ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                    <?php $__empty_1 = true; $__currentLoopData = $inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            <td><?php echo e($loop->iteration); ?></td>
                                                            <td><?php echo e(optional($item->item)->name ?? 'Item tidak dijumpai'); ?></td>
                                                            <td><?php echo e(number_format($item->total_ordered_quantity, 2)); ?></td>
                                                            <td><?php echo e(number_format($item->total_ordered_price, 2)); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <tr><td colspan="4" class="text-center text-muted py-4">Tiada data inventori untuk tempoh dipilih.</td></tr>
                                                    <?php endif; ?>
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
                                            <?php $__empty_1 = true; $__currentLoopData = $lowStockItems->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <div class="fw-medium"><?php echo e($l['name']); ?></div>
                                                        <div class="text-muted small"><?php echo e($l['category'] ?? '-'); ?></div>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold"><?php echo e($l['stock']); ?></div>
                                                        <div class="text-muted small">Min: <?php echo e($l['minStock']); ?></div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <div class="list-group-item text-center text-muted">Tiada item kritikal.</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-3 text-end">
                                            <button class="btn btn-sm btn-outline-warning" id="btnViewCriticalFromInstitusi"><i class="fas fa-eye me-1"></i>Lihat Semua</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php elseif($activePage === 'pembekal'): ?>
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
                                            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($supplier->id); ?></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="supplier-detail-btn fw-bold text-primary text-decoration-none" 
                                                           data-company="<?php echo e($supplier->company_name); ?>"
                                                           data-contact="<?php echo e($supplier->contact_person); ?>"
                                                           data-email="<?php echo e($supplier->email); ?>"
                                                           data-phone="<?php echo e($supplier->phone_number); ?>"
                                                           data-address="<?php echo e($supplier->address); ?>"
                                                           data-postcode="<?php echo e($supplier->postcode); ?>"
                                                           data-state="<?php echo e(optional($supplier->state)->name); ?>"
                                                           data-source="<?php echo e($supplier->createdBy?->effectiveRoleName() === 'Admin' ? 'HQ' : 'Institusi'); ?>">
                                                            <i class="fas fa-building me-1"></i> <?php echo e($supplier->company_name); ?>

                                                        </a>
                                                    </td>
                                                    <td><?php echo e($supplier->contact_person); ?></td>
                                                    <td><?php echo e($supplier->email); ?></td>
                                                    <td><?php echo e(optional($supplier->state)->name); ?></td>
                                                    <td>
                                                        <?php if($supplier->createdBy?->effectiveRoleName() === 'Admin'): ?>
                                                            <span class="badge bg-primary">HQ</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Institusi</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php elseif($activePage === 'senarai_user'): ?>
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
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e($user->name); ?></td>
                                                    <td><?php echo e($user->email); ?></td>
                                                    <td><?php echo e($user->phone_number); ?></td>
                                                    <td>
                                                        <?php echo e(optional($user->position)->name ?? '-'); ?> 
                                                        <br>
                                                        <small class="text-muted">Peranan: <?php echo e($user->effectiveRoleName()); ?></small>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php elseif($activePage === 'profil'): ?>
                        <div class="row justify-content-center">
                            <div class="col-lg-5 mb-4">
                                <div class="card text-center h-100">
                                    <div class="card-body">
                                        <div class="position-relative d-inline-block mb-3">
                                            <img src="<?php echo e(auth()->user()?->image ? asset('storage/' . auth()->user()->image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()?->name ?? 'Pengarah Institusi') . '&background=1a5632&color=fff&size=150'); ?>"
                                                alt="Profile Picture"
                                                class="rounded-circle img-thumbnail"
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                        <h4 class="mb-0"><?php echo e(auth()->user()?->name ?? 'Pengarah Institusi'); ?></h4>
                                        <p class="text-muted"><?php echo e(auth()->user()?->position?->name ?? 'Pengarah Institusi'); ?></p>
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
                                                <h5 class="mb-0"><?php echo e(auth()->user()?->status ? 'Aktif' : 'Tidak Aktif'); ?></h5>
                                                <small class="text-muted">Status</small>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="mb-0"><?php echo e(auth()->user()?->effectiveRoleName()); ?></h5>
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
                                                <span class="fw-medium"><?php echo e(auth()->user()?->email ?? '-'); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-phone me-2 text-primary"></i>No. Telefon</span>
                                                <span class="fw-medium"><?php echo e(auth()->user()?->phone_number ?? '-'); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-building me-2 text-primary"></i>Institusi</span>
                                                <span class="fw-medium"><?php echo e(auth()->user()?->institution?->name ?? '-'); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-briefcase me-2 text-primary"></i>Jawatan</span>
                                                <span class="fw-medium"><?php echo e(auth()->user()?->position?->name ?? '-'); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <span><i class="fas fa-calendar-alt me-2 text-primary"></i>Tarikh Sertai</span>
                                                <span class="fw-medium"><?php echo e(auth()->user()?->created_at ? \Carbon\Carbon::parse(auth()->user()->created_at)->format('d/m/Y') : '-'); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-10">
                                <?php if(session('success')): ?>
                                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                                <?php endif; ?>

                                <?php if($errors->any()): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <div class="card mb-4" id="cardUpdateProfile" style="display: none;">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Kemaskini Maklumat Profil</h5>
                                        <button class="btn btn-sm btn-link text-decoration-none" id="btnCancelEdit">Batal</button>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nama Penuh</label>
                                                    <input type="text" class="form-control" name="name" value="<?php echo e(auth()->user()?->name); ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">E-mel</label>
                                                    <input type="email" class="form-control" name="email" value="<?php echo e(auth()->user()?->email); ?>" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">No. Telefon</label>
                                                    <input type="text" class="form-control" name="phone_number" value="<?php echo e(auth()->user()?->phone_number); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Institusi</label>
                                                    <select class="form-select" name="institution_id">
                                                        <option value="">Pilih Institusi</option>
                                                        <?php $__currentLoopData = $institutions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $institution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($institution->id); ?>" <?php echo e(auth()->user()?->institution_id == $institution->id ? 'selected' : ''); ?>>
                                                                <?php echo e($institution->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                        <form action="<?php echo e(route('profile.password')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
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
                    <?php endif; ?>
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
                        if (labels.length > 0) {
                            topItemsTableBody.innerHTML = labels.map((label, idx) => `
                                <tr>
                                    <td class="ps-4 text-muted">${idx + 1}</td>
                                    <td class="fw-medium text-dark">${label}</td>
                                    <td class="text-end pe-4"><span class="badge bg-success rounded-pill px-3 py-2 fs-6">${data[idx] ?? 0}</span></td>
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
                            const rows = j.data || [];
                            if (recentOrdersTableBody) {
                                recentOrdersTableBody.innerHTML = '';
                                rows.forEach((o, idx) => {
                                    const tr = document.createElement('tr');
                                    tr.innerHTML = `
                                        <td>${idx+1}</td>
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
    <script src="<?php echo e(asset('js/table-download.js')); ?>"></script>
    <script src="<?php echo e(asset('js/session-timeout.js')); ?>"></script>
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
<?php /**PATH C:\laragon\www\MySIPMa\resources\views/pengarah_institusi_dashboard.blade.php ENDPATH**/ ?>