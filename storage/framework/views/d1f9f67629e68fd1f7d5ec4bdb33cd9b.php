<!DOCTYPE html>
<html lang="ms" data-bs-theme="light">

<head>
  <script>document.documentElement.setAttribute('data-bs-theme',localStorage.getItem('theme')||'light')</script>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Senarai Inden - MySIPMa</title>

  <link rel="icon" type="image/png" href="<?php echo e(asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png')); ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png')); ?>">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link href="<?php echo e(asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('frontend/Nexa/assets/css/main2.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('css/user-theme.css')); ?>" rel="stylesheet">
  
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <style>
    :root {
      --bg: #020204;
      --surface: #11151f;
      --surface-soft: #161a26;
      --border: #2c333f;
      --text: #e2e8f0;
      --muted: #94a3b8;
      --accent: #10b981;
    }
    
    body {
      background: radial-gradient(circle at top, rgba(255,255,255,.05) 0%, transparent 40%), linear-gradient(180deg,#020204 0%,#07090f 40%,#0b1018 100%);
      color: var(--text);
      font-family: "Roboto", sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    h1, h2, h3, h4 {
      font-family: "Montserrat", sans-serif;
      color: #fff;
    }

    .logo-glow {
      width: auto;
      height: auto;
      filter: brightness(150%);
      transition: all 0.3s ease;
    }

    .logo-glow:hover {
      filter: brightness(170%);
      transform: scale(1.02);
    }

    .dashboard-container {
      padding: 60px 0;
      flex: 1;
    }

    .dashboard-header {
      margin-bottom: 40px;
    }

    .dashboard-header h1 {
      font-weight: 800;
      font-size: 2.5rem;
      margin-bottom: 10px;
    }

    @media (min-width: 1200px) {
      .header .container > .logo-glow,
      .header .container > .d-xl-flex {
        position: relative;
        z-index: 2;
      }

      .header .navmenu {
        position: relative;
        flex: 1;
        text-align: center;
      }

      .navmenu a { color: #ffffff !important; }
      .navmenu a:hover,
      .navmenu a.active { color: #10b981 !important; }
      .text-white-50:hover { color: #10b981 !important; }
    }

    .card-table {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 24px;
      padding: 30px;
      box-shadow: 0 18px 48px rgba(0,0,0,.3);
    }

    .btn-custom {
      background: var(--accent);
      color: #0f172a;
      border: none;
      border-radius: 999px;
      padding: 12px 24px;
      font-weight: 700;
      text-decoration: none;
      transition: all 0.3s;
    }

    .btn-custom:hover {
      background: #0ea5e9;
      color: #fff;
      transform: scale(1.05);
    }

    .btn-logout {
      background: transparent;
      border: 1px solid rgba(255,255,255,0.2);
      color: #fff;
    }

    .btn-logout:hover {
      background: rgba(255,255,255,0.1);
      border-color: #fff;
    }

    /* Dark Mode DataTables Overrides */
    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label,
    div.dataTables_wrapper div.dataTables_info {
        color: var(--muted) !important;
    }
    .table-dark-custom {
        color: var(--text) !important;
        border-color: var(--border) !important;
    }
    .table-dark-custom th {
      background: linear-gradient(135deg, #065f46, #047857) !important;
      color: #fff !important;
      border-bottom: 2px solid var(--border) !important;
    }
    .table-dark-custom td {
        background-color: transparent !important;
        border-bottom: 1px solid var(--border) !important;
        vertical-align: middle;
        color: #ffffff !important;
    }
    .table-dark-custom tbody tr:hover td {
        background-color: rgba(255,255,255,0.05) !important;
    }
    .page-item.disabled .page-link {
        background-color: transparent !important;
        border-color: var(--border) !important;
        color: var(--muted) !important;
    }
    .page-item .page-link {
        background-color: var(--surface-soft) !important;
        border-color: var(--border) !important;
        color: var(--text) !important;
    }
    .page-item.active .page-link {
        background-color: var(--accent) !important;
        border-color: var(--accent) !important;
        color: #0f172a !important;
    }
    .form-control-sm, .form-select-sm {
        background-color: var(--surface-soft) !important;
        border: 1px solid var(--border) !important;
        color: var(--text) !important;
    }
    @keyframes logoPulse { 0% { filter: brightness(180%) drop-shadow(2px 3px 0 rgba(0,0,0,.8)) drop-shadow(1px 1px 0 rgba(0,0,0,.5)) drop-shadow(0 0 8px rgba(16,185,129,.3)); transform: scale(1); } 50% { filter: brightness(210%) drop-shadow(2px 3px 0 rgba(0,0,0,.9)) drop-shadow(1px 1px 0 rgba(0,0,0,.6)) drop-shadow(0 0 16px rgba(16,185,129,.6)) drop-shadow(0 0 30px rgba(16,185,129,.2)); transform: scale(1.03); } 100% { filter: brightness(180%) drop-shadow(2px 3px 0 rgba(0,0,0,.8)) drop-shadow(1px 1px 0 rgba(0,0,0,.5)) drop-shadow(0 0 8px rgba(16,185,129,.3)); transform: scale(1); } }
    @keyframes logoShine { 0% { filter: brightness(150%) drop-shadow(0 0 0 transparent); } 50% { filter: brightness(200%) drop-shadow(0 0 8px rgba(16,185,129,.5)); } 100% { filter: brightness(150%) drop-shadow(0 0 0 transparent); } }
    [data-bs-theme="light"] .logo-glow img { filter: brightness(180%) drop-shadow(2px 3px 0 rgba(0,0,0,.8)) drop-shadow(1px 1px 0 rgba(0,0,0,.5)) drop-shadow(-1px -1px 0 rgba(255,255,255,.4)) !important; animation: logoPulse 3s ease-in-out infinite; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    [data-bs-theme="light"] .logo-glow:hover img { filter: brightness(250%) drop-shadow(3px 4px 0 rgba(0,0,0,.9)) drop-shadow(2px 2px 0 rgba(0,0,0,.6)) drop-shadow(0 0 20px rgba(16,185,129,.6)) drop-shadow(0 0 40px rgba(16,185,129,.3)) !important; transform: scale(1.08) !important; animation: logoShine 1s ease-in-out infinite; }
    [data-bs-theme="light"] .logo-glow { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    [data-bs-theme="light"] .logo-glow:hover { transform: scale(1.08) !important; }
    .mobile-nav-toggle { font-size:24px; cursor:pointer; }
    .mobile-nav-toggle.bi::before { color:#fff; }
    [data-bs-theme="light"] .mobile-nav-toggle.bi::before { color:#111827; }
    [data-bs-theme="light"] body { background:#f8f9fa; color:#111827; }
    [data-bs-theme="light"] h1,[data-bs-theme="light"] h2,[data-bs-theme="light"] h3,[data-bs-theme="light"] h4 { color:#111827; }
    [data-bs-theme="light"] .table-dark-custom { color:#111827 !important; border-color:#e5e7eb !important; }
    [data-bs-theme="light"] .table-dark-custom th { background:#f3f4f6 !important; color:#111827 !important; border-color:#e5e7eb !important; }
    [data-bs-theme="light"] .table-dark-custom td { background:#fff !important; color:#111827 !important; border-color:#e5e7eb !important; }
    [data-bs-theme="light"] .table-dark-custom tbody tr:hover td { background:#f9fafb !important; }
    [data-bs-theme="light"] div.dataTables_wrapper div.dataTables_length label,[data-bs-theme="light"] div.dataTables_wrapper div.dataTables_filter label,[data-bs-theme="light"] div.dataTables_wrapper div.dataTables_info { color:#6b7280 !important; }
    [data-bs-theme="light"] .page-item .page-link { background:#fff !important; border-color:#e5e7eb !important; color:#374151 !important; }
    [data-bs-theme="light"] .page-item.active .page-link { background:#10b981 !important; border-color:#10b981 !important; color:#fff !important; }
    [data-bs-theme="light"] .form-control-sm,[data-bs-theme="light"] .form-select-sm { background:#fff !important; border-color:#d1d5db !important; color:#111827 !important; }
    [data-bs-theme="light"] #header { background:rgba(255,255,255,.8) !important; border-bottom:1px solid #e5e7eb !important; }
    [data-bs-theme="light"] .dropdown-menu { background:#fff; border-color:#e5e7eb; color:#111827; }
    [data-bs-theme="light"] .dropdown-item { color:#374151; }
    [data-bs-theme="light"] .dropdown-item:hover,[data-bs-theme="light"] .dropdown-item:focus { background:#f3f4f6; color:#111827; }
    [data-bs-theme="light"] select option { color:#111827; background:#fff; }

    /* Mobile nav links */
    .navmenu ul li a.text-danger { color:#f87171 !important; }
    .navmenu ul li a.text-danger:hover { color:#ef4444 !important; }
    [data-bs-theme="light"] .navmenu ul li a.text-danger { color:#dc2626 !important; }

    /* Logout confirmation modal */
    #logoutConfirmModal .modal-content { background:var(--surface); border:1px solid var(--border); border-radius:20px; color:var(--text); }
    [data-bs-theme="light"] #logoutConfirmModal .modal-content { background:#fff; border-color:#e5e7eb; color:#111827; }
    #logoutConfirmModal .modal-header { border-bottom:1px solid var(--border); }
    [data-bs-theme="light"] #logoutConfirmModal .modal-header { border-bottom-color:#e5e7eb; }
    #logoutConfirmModal .modal-title { font-weight:700; }
    #logoutConfirmModal .btn-cancel { background:rgba(255,255,255,.08); border:1px solid var(--border); color:var(--text); }
    #logoutConfirmModal .btn-cancel:hover { background:rgba(255,255,255,.15); }
    [data-bs-theme="light"] #logoutConfirmModal .btn-cancel { background:#f3f4f6; border-color:#d1d5db; color:#374151; }
    [data-bs-theme="light"] #logoutConfirmModal .btn-cancel:hover { background:#e5e7eb; }
  </style>

<body>

  <header id="header" class="header d-flex align-items-center sticky-top" style="background: rgba(2,2,4,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="#" class="logo-glow d-flex align-items-center" id="logoLogoutTrigger">
        <img src="<?php echo e(asset('frontend/Nexa/assets/img/WORDINGMYSIPMA2.png')); ?>" style="height: 55px; width: auto;" alt="MySIPMa logo">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="<?php echo e(route('user.dashboard')); ?>" class="<?php echo e(request()->routeIs('user.dashboard') ? 'active' : ''); ?>">Papan Pemuka</a></li>
          <li><a href="<?php echo e(route('user.senarai.inden')); ?>" class="<?php echo e(request()->routeIs('user.senarai.inden') ? 'active' : ''); ?>">Senarai Inden</a></li>
          <li><a href="<?php echo e(route('user.inventori')); ?>" class="<?php echo e(request()->routeIs('user.inventori') ? 'active' : ''); ?>">Inventori</a></li>
          <?php if(Auth::user()->hasPermission('pengesahan_inden')): ?>
          <li><a href="<?php echo e(route('user.pengesahan.inden')); ?>" class="<?php echo e(request()->routeIs('user.pengesahan.inden') ? 'active' : ''); ?>">Pengesahan Inden</a></li>
          <?php endif; ?>
          <?php if(Auth::user()->hasPermission('borang_inden')): ?>
          <li><a href="<?php echo e(route('borang.inden')); ?>" class="<?php echo e(request()->routeIs('borang.inden*') ? 'active' : ''); ?>">Borang Inden</a></li>
          <?php endif; ?>
          <?php if(Auth::user()->hasPermission('penerimaan_inden')): ?>
          <li><a href="<?php echo e(route('borang.penerimaan')); ?>" class="<?php echo e(request()->routeIs('borang.penerimaan') ? 'active' : ''); ?>">Penerimaan</a></li>
          <?php endif; ?>
          <li class="d-xl-none"><a href="<?php echo e(route('profile')); ?>" class="<?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">Profil</a></li>
          <li class="d-xl-none"><a href="#" id="navLogoutBtn" class="text-danger">Log Keluar</a></li>
          </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-none d-xl-flex align-items-center gap-3">
        <!-- Notification Bell -->
        <?php if(Auth::user()->hasPermission('pengesahan_inden')): ?>
        <a href="<?php echo e(route('user.pengesahan.inden')); ?>" class="position-relative text-white fs-5 me-3" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color=''">
          <i class="bi bi-bell-fill"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            <?php echo e($pendingApprovals ?? 0); ?>

            <span class="visually-hidden">Inden belum disah</span>
          </span>
        </a>
        <?php endif; ?>
        <?php if(Auth::user()->hasPermission('penerimaan_inden')): ?>
        <a href="<?php echo e(route('borang.penerimaan')); ?>" class="position-relative text-white fs-5 me-3" style="transition: color 0.3s;" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color=''">
          <i class="bi bi-truck"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            <?php echo e($pendingPenerimaan ?? 0); ?>

            <span class="visually-hidden">Penerimaan belum diproses</span>
          </span>
        </a>
        <?php endif; ?>
        <button class="btn btn-icon" id="themeToggle" style="background:none;border:none;color:var(--text);font-size:1.2rem;padding:4px 8px"><i class="bi bi-moon-fill"></i></button>
        <a href="<?php echo e(route('profile')); ?>" class="text-white-50 text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color=''"><i class="bi bi-person-circle me-2"></i><?php echo e(Auth::user()->name ?? 'Pengguna'); ?></a>
        <button type="button" class="btn btn-custom btn-logout btn-sm px-3 py-2" id="desktopLogoutBtn"><i class="bi bi-box-arrow-right me-2"></i>Log Keluar</button>
      </div>
    </div>
  </header>

  <main class="dashboard-container">
    <div class="container" data-aos="fade-up">
      
      <div class="dashboard-header text-center">
        <h1>Senarai Inden</h1>
        <p class="muted">Paparan rekod semua borang inden yang telah dihantar.</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card-table">
            <div class="table-responsive">
              <table id="senaraiIndenTable" class="table table-dark-custom w-100">
                <thead>
                  <tr>
                    <th>Bil</th>
                    <th>No. Inden</th>
                    <th>Tarikh</th>
                    <th>Institusi</th>
                    <th>Pembekal</th>
                    <th>Emel Pembekal</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__empty_1 = true; $__currentLoopData = ($orders ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                      $orderBadge = match ($order->order_status) {
                          'Completed' => 'bg-success',
                          'In Progress' => 'bg-info text-dark',
                          'Pending' => 'bg-warning text-dark',
                          'Rejected' => 'bg-danger',
                          default => 'bg-secondary',
                      };
                      $statusLabel = match ($order->order_status) {
                          'Completed' => 'Selesai',
                          'In Progress' => 'Dalam Proses',
                          'Pending' => 'Menunggu',
                          'Rejected' => 'Ditolak',
                          default => $order->order_status ?? '-',
                      };
                    ?>
                    <tr>
                      <td><?php echo e($loop->iteration); ?></td>
                      <td><a href="<?php echo e(Auth::user()->hasPermission('borang_inden') ? route('borang.inden.edit', $order->id) : route('borang.inden.show', $order->id)); ?>" class="text-success fw-semibold text-decoration-none"><?php echo e($order->order_no); ?></a></td>
                      <td><?php echo e($order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') : '-'); ?></td>
                      <td><?php echo e($order->institution_name ?? '-'); ?></td>
                      <td><?php echo e($order->supplier_name ?? '-'); ?></td>
                      <td><?php echo e($order->supplier_email ?? '-'); ?></td>
                      <td>RM <?php echo e(number_format((float) $order->total_amount, 2)); ?></td>
                      <td><span class="badge <?php echo e($orderBadge); ?>"><?php echo e($statusLabel); ?></span></td>
                      <td>
                        <?php if($order->order_status === 'Completed'): ?>
                          <a href="<?php echo e(route('borang.penerimaan.cetak', $order->id)); ?>" target="_blank" class="btn btn-sm" style="background:var(--accent);color:#0f172a;border-radius:999px;padding:4px 12px;font-size:.8rem;font-weight:600;text-decoration:none;"><i class="bi bi-printer me-1"></i>Cetak Penerimaan</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                      <td colspan="9" class="text-center text-white-50 py-4">Tiada rekod inden ditemui.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

  <footer class="text-center py-4" style="border-top: 1px solid rgba(255,255,255,0.05); margin-top: auto;">
    <p class="mb-0 text-white-50"><small>&copy; 2026 MySIPMa. Hak Cipta Terpelihara.</small></p>
  </footer>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?php echo e(asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
  <script src="<?php echo e(asset('frontend/Nexa/assets/js/mobile-nav.js')); ?>"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  
  <script>
    $(document).ready(function() {
        <?php if(($orders ?? collect())->isNotEmpty()): ?>
        $('#senaraiIndenTable').DataTable({
            pageLength: 5,
            pagingType: 'full_numbers',
            lengthChange: true,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
            dom: '<"row align-items-center mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row align-items-center mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ms.json',
                emptyTable: "Tiada data tersedia",
                info: "Memaparkan _START_ hingga _END_ daripada _TOTAL_ rekod",
                infoEmpty: "Memaparkan 0 hingga 0 daripada 0 rekod",
                lengthMenu: "Papar _MENU_ rekod",
                search: "Cari:",
                paginate: {
                    first: "<i class='bi bi-chevron-double-left'></i>",
                    last: "<i class='bi bi-chevron-double-right'></i>",
                    next: "<i class='bi bi-chevron-right'></i>",
                    previous: "<i class='bi bi-chevron-left'></i>"
                }
            }
        });
        <?php endif; ?>
    });
  </script>
    <script src="<?php echo e(asset('js/table-download-pdf.js')); ?>"></script>
    <script src="<?php echo e(asset('js/session-timeout.js')); ?>"></script>
  <script src="<?php echo e(asset('js/user-theme.js')); ?>"></script>

  <!-- Logout confirmation modal -->
  <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutConfirmModalLabel"><i class="bi bi-box-arrow-right me-2"></i>Log Keluar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p class="mb-0">Adakah anda pasti ingin log keluar dari sistem?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-cancel btn-sm px-3" data-bs-dismiss="modal">Batal</button>
          <form action="<?php echo e(route('logout')); ?>" method="POST" id="logoutForm" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-danger btn-sm px-3"><i class="bi bi-box-arrow-right me-1"></i>Log Keluar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function () {
      var logoutModal = new bootstrap.Modal(document.getElementById('logoutConfirmModal'));
      var desktopBtn = document.getElementById('desktopLogoutBtn');
      var navBtn = document.getElementById('navLogoutBtn');
      var logoBtn = document.getElementById('logoLogoutTrigger');
      if (desktopBtn) desktopBtn.addEventListener('click', function () { logoutModal.show(); });
      if (navBtn) navBtn.addEventListener('click', function (e) { e.preventDefault(); logoutModal.show(); });
      if (logoBtn) logoBtn.addEventListener('click', function (e) { e.preventDefault(); logoutModal.show(); });
    })();
  </script>
</body>
</html>
<?php /**PATH C:\laragon\www\MySIPMA_2\resources\views/senarai_inden.blade.php ENDPATH**/ ?>