<!DOCTYPE html>
<html lang="ms" data-bs-theme="light">

<head>
  <script>document.documentElement.setAttribute('data-bs-theme',localStorage.getItem('theme')||'light')</script>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Papan Pemuka Pengguna - MySIPMa</title>

  <link rel="icon" type="image/png" href="<?php echo e(asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png')); ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png')); ?>">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <link href="<?php echo e(asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('frontend/Nexa/assets/css/main2.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('css/user-theme.css')); ?>" rel="stylesheet">

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
      background: radial-gradient(circle at top, rgba(255, 255, 255, .05) 0%, transparent 40%), linear-gradient(180deg, #020204 0%, #07090f 40%, #0b1018 100%);
      color: var(--text);
      font-family: "Roboto", sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    h1,
    h2,
    h3,
    h4 {
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

    @keyframes cardPulse {
      0% { box-shadow: 0 20px 60px rgba(16, 185, 129, .25), 0 0 30px rgba(16, 185, 129, .1); }
      50% { box-shadow: 0 20px 60px rgba(16, 185, 129, .4), 0 0 50px rgba(16, 185, 129, .2); }
      100% { box-shadow: 0 20px 60px rgba(16, 185, 129, .25), 0 0 30px rgba(16, 185, 129, .1); }
    }

    @keyframes gradientBorder {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes iconFloat {
      0%, 100% { transform: translateY(0) scale(1.2) rotate(0deg); }
      25% { transform: translateY(-4px) scale(1.2) rotate(-5deg); }
      75% { transform: translateY(2px) scale(1.2) rotate(5deg); }
    }

    @keyframes neonPulse {
      0%, 100% { text-shadow: 0 0 10px rgba(16,185,129,.4), 0 0 20px rgba(16,185,129,.2), 0 0 40px rgba(16,185,129,.1); }
      50% { text-shadow: 0 0 20px rgba(16,185,129,.6), 0 0 40px rgba(16,185,129,.3), 0 0 80px rgba(16,185,129,.15), 0 0 120px rgba(16,185,129,.05); }
    }

    @keyframes bgShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes sparkle {
      0%, 100% { opacity: 0; transform: scale(0) rotate(0deg); }
      50% { opacity: 1; transform: scale(1) rotate(180deg); }
    }

    @keyframes ringPulse {
      0% { transform: scale(1); opacity: .6; }
      100% { transform: scale(1.8); opacity: 0; }
    }

    .stat-card {
      background: var(--surface);
      border: 2px solid transparent;
      border-radius: 24px;
      padding: 30px;
      box-shadow: 0 18px 48px rgba(0, 0, 0, .3);
      height: 100%;
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      cursor: pointer;
      perspective: 800px;
    }

    .stat-card::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: 22px;
      padding: 2px;
      background: linear-gradient(135deg, rgba(16,185,129,0), rgba(16,185,129,0));
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      transition: all 0.5s ease;
      pointer-events: none;
      z-index: 2;
    }

    .stat-card::after {
      content: '';
      position: absolute;
      top: -50%;
      left: -60%;
      width: 40%;
      height: 200%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
      transform: rotate(25deg);
      transition: left 0.7s ease;
      pointer-events: none;
      z-index: 1;
    }

    .stat-card .glow-ring {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      border: 2px solid rgba(16,185,129,.3);
      transform: translate(-50%, -50%) scale(1);
      opacity: 0;
      pointer-events: none;
      z-index: 0;
    }

    .stat-card:hover .glow-ring {
      animation: ringPulse 1.2s ease-out infinite;
    }

    .stat-card:hover {
      transform: translateY(-14px) scale(1.04) rotateX(2deg);
      box-shadow:
        0 25px 70px rgba(16, 185, 129, .4),
        0 0 40px rgba(16, 185, 129, .2),
        0 0 80px rgba(16, 185, 129, .1),
        inset 0 0 30px rgba(16, 185, 129, .05);
      animation: cardPulse 2s ease-in-out infinite;
    }

    .stat-card:hover::before {
      background: linear-gradient(135deg, #10b981, #059669, #34d399, #10b981, #06b6d4, #10b981);
      background-size: 400% 400%;
      animation: gradientBorder 2s ease infinite;
    }

    .stat-card:hover::after {
      left: 120%;
    }

    .stat-icon {
      font-size: 2.5rem;
      color: var(--accent);
      margin-bottom: 20px;
      display: inline-block;
      padding: 15px;
      background: rgba(16, 185, 129, .1);
      border-radius: 16px;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      z-index: 3;
    }

    .stat-card:hover .stat-icon {
      animation: iconFloat 1.2s ease-in-out infinite;
      background: rgba(16, 185, 129, .25);
      box-shadow: 0 0 25px rgba(16, 185, 129, .5), 0 0 50px rgba(16, 185, 129, .2), 0 0 80px rgba(16, 185, 129, .1);
      border-radius: 20px;
      transform: scale(1.15);
    }

    .stat-title {
      color: var(--muted);
      font-size: 1rem;
      font-weight: 500;
      margin-bottom: 10px;
      min-height: 24px;
      transition: all 0.3s ease;
      position: relative;
      z-index: 3;
    }

    .stat-card:hover .stat-title {
      color: var(--accent);
    }

    .stat-value {
      font-size: 3.5rem;
      font-weight: 800;
      line-height: 1;
      margin-bottom: 0;
      font-family: "Montserrat", sans-serif;
      transition: all 0.4s ease;
      position: relative;
      z-index: 3;
    }

    .stat-card:hover .stat-value {
      animation: neonPulse 1.5s ease-in-out infinite;
      color: #34d399;
    }

    .action-card {
      background: linear-gradient(135deg, rgba(16, 185, 129, .15) 0%, transparent 100%);
      border: 1px solid rgba(16, 185, 129, .3);
      border-radius: 20px;
      padding: 24px;
      margin-top: 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
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
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    .btn-logout:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: #fff;
    }
    [data-bs-theme="light"] .btn-logout:hover {
      background: rgba(16, 185, 129, 0.1);
      border-color: #10b981;
      color: #10b981;
    }
    [data-bs-theme="light"] .logo-glow { perspective:800px; transition: transform 0.3s ease; display:inline-block; }
    [data-bs-theme="light"] .logo-glow img {
      display:block; position:relative; z-index:1;
      filter: brightness(100%) drop-shadow(2px 3px 4px rgba(0,0,0,.3)) drop-shadow(6px 10px 20px rgba(0,0,0,.18)) !important;
      transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      transform-style: preserve-3d; backface-visibility: hidden;
    }
    [data-bs-theme="light"] .logo-glow:hover img {
      filter: brightness(108%) drop-shadow(4px 6px 8px rgba(0,0,0,.4)) drop-shadow(12px 20px 40px rgba(0,0,0,.28)) drop-shadow(20px 30px 60px rgba(0,0,0,.15)) !important;
      transform: scale(1.08) rotateX(6deg) rotateY(-6deg) translateZ(10px) !important;
    }
    .mobile-nav-toggle { font-size:24px; cursor:pointer; }
    .mobile-nav-toggle.bi::before { color:#fff; }
    [data-bs-theme="light"] .mobile-nav-toggle.bi::before { color:#111827; }
    [data-bs-theme="light"] body { background:#f8f9fa; color:#111827; }
    [data-bs-theme="light"] h1,[data-bs-theme="light"] h2,[data-bs-theme="light"] h3,[data-bs-theme="light"] h4 { color:#111827; }
    [data-bs-theme="light"] .card-box,[data-bs-theme="light"] .stat-card { background:#fff; border-color:#e5e7eb; box-shadow:0 4px 12px rgba(0,0,0,.08); }
    [data-bs-theme="light"] .stat-card:hover { box-shadow:0 25px 70px rgba(16,185,129,.3), 0 0 40px rgba(16,185,129,.15), 0 0 80px rgba(16,185,129,.08); }
    [data-bs-theme="light"] .stat-card:hover .stat-value { color:#059669; }
    [data-bs-theme="light"] .stat-card .glow-ring { border-color:rgba(16,185,129,.2); }
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

    /* Contract monitoring light theme */
    [data-bs-theme="light"] .card .text-white-50 { color:#6b7280 !important; }
    [data-bs-theme="light"] .table-dark { --bs-table-bg:transparent; --bs-table-color:#111827; }
    [data-bs-theme="light"] .table-dark tr { border-bottom-color:#e5e7eb !important; }
    [data-bs-theme="light"] .table-dark th { color:#6b7280 !important; }
    [data-bs-theme="light"] .table-dark td { color:#111827 !important; }
    [data-bs-theme="light"] .alert-warning { background:rgba(245,158,11,.08) !important; border-color:rgba(245,158,11,.2) !important; color:#92400e !important; }
    [data-bs-theme="light"] .chart-card { background:#fff; border-color:#e5e7eb !important; }

    /* ── Colored stat card backgrounds ── */
    #statsRow1 > .col-md-3:nth-child(1) .stat-card { background: #172554; }
    #statsRow1 > .col-md-3:nth-child(2) .stat-card { background: #451a03; }
    #statsRow1 > .col-md-3:nth-child(3) .stat-card { background: #164e63; }
    #statsRow1 > .col-md-3:nth-child(4) .stat-card { background: #052e16; }
    #statsRow1 > .col-md-3:nth-child(5) .stat-card { background: #1e1b4b; }
  </style>
</head>

<body>

  <header id="header" class="header d-flex align-items-center sticky-top"
    style="background: rgba(2,2,4,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container d-flex align-items-center">
      <a href="#" class="logo-glow d-flex align-items-center" id="logoLogoutTrigger">
        <img src="<?php echo e(asset('frontend/Nexa/assets/img/WORDINGMYSIPMA2.png')); ?>" style="height: 55px; width: auto;"
          alt="MySIPMa logo">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="<?php echo e(route('user.dashboard')); ?>"
              class="<?php echo e(request()->routeIs('user.dashboard') ? 'active' : ''); ?>">Papan Pemuka</a></li>
          <li><a href="<?php echo e(route('user.senarai.inden')); ?>"
              class="<?php echo e(request()->routeIs('user.senarai.inden') ? 'active' : ''); ?>">Senarai Inden</a></li>
          <li><a href="<?php echo e(route('user.inventori')); ?>"
              class="<?php echo e(request()->routeIs('user.inventori') ? 'active' : ''); ?>">Inventori</a></li>
          <?php if(Auth::user()->hasPermission('pengesahan_inden')): ?>
          <li><a href="<?php echo e(route('user.pengesahan.inden')); ?>"
              class="<?php echo e(request()->routeIs('user.pengesahan.inden') ? 'active' : ''); ?>">Pengesahan Inden</a></li>
          <?php endif; ?>
          <?php if(Auth::user()->hasPermission('borang_inden')): ?>
          <li><a href="<?php echo e(route('borang.inden')); ?>"
               class="<?php echo e(request()->routeIs('borang.inden*') ? 'active' : ''); ?>">Borang Inden</a></li>
          <?php endif; ?>
          <?php if(Auth::user()->hasPermission('penerimaan_inden')): ?>
          <li><a href="<?php echo e(route('borang.penerimaan')); ?>" class="<?php echo e(request()->routeIs('borang.penerimaan') ? 'active' : ''); ?>">Penerimaan</a></li>
          <?php endif; ?>
          <?php if(Auth::user()->hasPermission('penilaian_prestasi')): ?>
          <li><a href="<?php echo e(route('user.penilaian_prestasi')); ?>" class="<?php echo e(request()->routeIs('user.penilaian_prestasi') ? 'active' : ''); ?>">Penilaian Prestasi</a></li>
          <?php endif; ?>
          <li class="d-xl-none"><a href="<?php echo e(route('profile')); ?>" class="<?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">Profil</a></li>
          <li class="d-xl-none"><a href="#" id="navLogoutBtn" class="text-danger">Log Keluar</a></li>
          </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-none d-xl-flex align-items-center gap-3">
        <?php if(Auth::user()->hasPermission('pengesahan_inden')): ?>
        <a href="<?php echo e(route('user.pengesahan.inden')); ?>" class="position-relative text-white fs-5 me-3"
          style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'"
          onmouseout="this.style.color=''">
          <i class="bi bi-bell-fill"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="font-size: 0.65rem;">
            <?php echo e($pendingApprovals ?? 0); ?>

            <span class="visually-hidden">Inden belum disah</span>
          </span>
        </a>
        <?php endif; ?>
        <?php if(Auth::user()->hasPermission('penerimaan_inden')): ?>
        <a href="<?php echo e(route('borang.penerimaan')); ?>" class="position-relative text-white fs-5 me-3"
          style="transition: color 0.3s;" onmouseover="this.style.color='#f59e0b'"
          onmouseout="this.style.color=''">
          <i class="bi bi-truck"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="font-size: 0.65rem;">
            <?php echo e($pendingPenerimaan ?? 0); ?>

            <span class="visually-hidden">Penerimaan belum diproses</span>
          </span>
        </a>
        <?php endif; ?>
        <button class="btn btn-icon" id="themeToggle" style="background:none;border:none;color:var(--text);font-size:1.2rem;padding:4px 8px"><i class="bi bi-moon-fill"></i></button>
        <a href="<?php echo e(route('profile')); ?>" class="text-white-50 text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color=''"><i
            class="bi bi-person-circle me-2"></i><?php echo e(Auth::user()->name ?? 'Pengguna'); ?></a>
        <button type="button" class="btn btn-custom btn-logout btn-sm px-3 py-2" id="desktopLogoutBtn"><i
              class="bi bi-box-arrow-right me-2"></i>Log Keluar</button>
      </div>
    </div>
  </header>

  <main class="dashboard-container">
    <div class="container" data-aos="fade-up">

      <div class="dashboard-header text-center">
        <h1>Papan Pemuka</h1>
        <p class="muted">Selamat datang, <?php echo e(Auth::user()->name ?? 'Pengguna'); ?>. Pantau statistik dan status inden anda
          di sini.</p>
      </div>

      <div class="row g-4 justify-content-center" id="statsRow1">
        <!-- Stat Card 1 -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon">
              <i class="bi bi-file-earmark-text"></i>
            </div>
            <h3 class="stat-title">Jumlah Inden</h3>
            <p class="stat-value" data-count="<?php echo e($totalOrders ?? 0); ?>"><?php echo e($totalOrders ?? 0); ?></p>
          </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon" style="color: #f59e0b; background: rgba(245,158,11,.1);">
              <i class="bi bi-hourglass-split"></i>
            </div>
            <h3 class="stat-title">Menunggu</h3>
            <p class="stat-value" data-count="<?php echo e($pendingApprovals ?? 0); ?>"><?php echo e($pendingApprovals ?? 0); ?></p>
            <p class="text-white-50 small mb-0 mt-2">Menunggu kelulusan</p>
          </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon" style="color: #38bdf8; background: rgba(56,189,248,.1);">
              <i class="bi bi-truck"></i>
            </div>
            <h3 class="stat-title">Dalam Proses</h3>
            <p class="stat-value" data-count="<?php echo e($inProgressOrders ?? 0); ?>"><?php echo e($inProgressOrders ?? 0); ?></p>
            <p class="text-white-50 small mb-0 mt-2">Diluluskan dan sedang diproses / dihantar</p>
          </div>
        </div>

        <?php if(Auth::user()->hasPermission('penerimaan_inden')): ?>
        <!-- Stat Card Penerimaan -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon" style="color: #f59e0b; background: rgba(245,158,11,.1);">
              <i class="bi bi-box-seam"></i>
            </div>
            <h3 class="stat-title">Penerimaan</h3>
            <p class="stat-value" data-count="<?php echo e($pendingPenerimaan ?? 0); ?>"><?php echo e($pendingPenerimaan ?? 0); ?></p>
            <p class="text-white-50 small mb-0 mt-2">Belum diterima</p>
          </div>
        </div>
        <?php endif; ?>

        <!-- Stat Card 4 -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon" style="color: #22c55e; background: rgba(34,197,94,.1);">
              <i class="bi bi-check2-circle"></i>
            </div>
            <h3 class="stat-title">Selesai</h3>
            <p class="stat-value" data-count="<?php echo e($completedOrders ?? 0); ?>"><?php echo e($completedOrders ?? 0); ?></p>
          </div>
        </div>
      </div>

      
      <?php if(isset($predictions) && $predictions['summary']['total'] > 0): ?>
      <div class="row mt-5">
        <div class="col-12">
          <div class="d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-graph-up-arrow" style="font-size:1.5rem;color:var(--accent);"></i>
            <h3 class="mb-0" style="font-weight:700;">Ramalan Penggunaan Item</h3>
            <span class="badge rounded-pill px-3 py-2 ms-2" style="background:rgba(16,185,129,.15);color:#10b981;font-weight:600;font-size:0.75rem;">Linear Regression</span>
          </div>

          <div class="row g-4 justify-content-center mb-4" id="statsRow2">
            <div class="col-md-6 col-lg-3">
              <div class="stat-card text-center">
                <div class="glow-ring"></div>
                <div class="stat-icon" style="color: var(--accent); background: rgba(16,185,129,.1);">
                  <i class="bi bi-boxes"></i>
                </div>
                <h3 class="stat-title">Jumlah Item</h3>
                <p class="stat-value"><?php echo e($predictions['summary']['total']); ?></p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="stat-card text-center">
                <div class="glow-ring"></div>
                <div class="stat-icon" style="color: #ef4444; background: rgba(239,68,68,.1);">
                  <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h3 class="stat-title">Akan Habis</h3>
                <p class="stat-value" style="color:#ef4444;"><?php echo e($predictions['summary']['willRunOut']); ?></p>
                <p class="text-muted small mb-0 mt-2">< 12 bulan</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="stat-card text-center">
                <div class="glow-ring"></div>
                <div class="stat-icon" style="color: #f59e0b; background: rgba(245,158,11,.1);">
                  <i class="bi bi-hourglass-split"></i>
                </div>
                <h3 class="stat-title">Kritikal</h3>
                <p class="stat-value" style="color:#f59e0b;"><?php echo e($predictions['summary']['critical']); ?></p>
                <p class="text-muted small mb-0 mt-2">< 1 bulan</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="stat-card text-center">
                <div class="glow-ring"></div>
                <div class="stat-icon" style="color: #22c55e; background: rgba(34,197,94,.1);">
                  <i class="bi bi-check2-circle"></i>
                </div>
                <h3 class="stat-title">Selamat</h3>
                <p class="stat-value" style="color:#22c55e;"><?php echo e($predictions['summary']['safe']); ?></p>
                <p class="text-muted small mb-0 mt-2">> 12 bulan</p>
              </div>
            </div>
          </div>

          <div class="row g-4 mb-4">
            
            <div class="col-md-6">
              <div class="card h-100" style="background:var(--surface);border:1px solid var(--border);border-left:4px solid #ef4444;border-radius:16px;overflow:hidden;">
                <div class="card-header d-flex align-items-center gap-2" style="background:transparent;border-bottom:1px solid var(--border);padding:16px 20px;">
                  <i class="bi bi-exclamation-triangle-fill" style="color:#ef4444;"></i>
                  <h6 class="mb-0 fw-bold">5 Item Paling Cepat Habis</h6>
                </div>
                <div class="table-responsive">
                  <table class="table table-dark table-borderless mb-0" style="background:transparent;">
                    <thead>
                      <tr style="border-bottom:1px solid var(--border);">
                        <th class="text-muted small fw-semibold ps-4 py-3">Item</th>
                        <th class="text-muted small fw-semibold py-3">Stok</th>
                        <th class="text-muted small fw-semibold py-3">Guna/Bln</th>
                        <th class="text-muted small fw-semibold py-3">Bulan Lagi</th>
                        <th class="text-muted small fw-semibold text-center py-3">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $predictions['top5']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php
                      $barColor = match($p['status']) { 'critical' => '#ef4444', 'warning' => '#f59e0b', 'attention' => '#38bdf8', default => '#22c55e' };
                      ?>
                      <tr style="border-bottom:1px solid var(--border);">
                        <td class="ps-4 py-3 fw-medium"><?php echo e($p['name']); ?></td>
                        <td class="py-3"><?php echo e(number_format($p['stock'])); ?> <?php echo e($p['uom']); ?></td>
                        <td class="py-3"><?php echo e(number_format($p['avgMonthly'], 1)); ?> <?php echo e($p['uom']); ?></td>
                        <td class="py-3 fw-semibold"><?php echo e(fmtBulan($p['monthsUntilEmpty'])); ?></td>
                        <td class="text-center py-3">
                          <span class="badge rounded-pill px-3 py-2" style="background:<?php echo e($barColor); ?>20;color:<?php echo e($barColor); ?>;border:1px solid <?php echo e($barColor); ?>50;">
                            <?php echo e($p['statusText']); ?>

                          </span>
                        </td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            
            <div class="col-md-6">
              <div class="card h-100" style="background:var(--surface);border:1px solid var(--border);border-left:4px solid #22c55e;border-radius:16px;overflow:hidden;">
                <div class="card-header d-flex align-items-center gap-2" style="background:transparent;border-bottom:1px solid var(--border);padding:16px 20px;">
                  <i class="bi bi-check2-circle" style="color:#22c55e;"></i>
                  <h6 class="mb-0 fw-bold">5 Item Paling Lambat Habis</h6>
                </div>
                <div class="table-responsive">
                  <table class="table table-dark table-borderless mb-0" style="background:transparent;">
                    <thead>
                      <tr style="border-bottom:1px solid var(--border);">
                        <th class="text-muted small fw-semibold ps-4 py-3">Item</th>
                        <th class="text-muted small fw-semibold py-3">Stok</th>
                        <th class="text-muted small fw-semibold py-3">Guna/Bln</th>
                        <th class="text-muted small fw-semibold py-3">Bulan Lagi</th>
                        <th class="text-muted small fw-semibold text-center py-3">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__empty_1 = true; $__currentLoopData = $predictions['bottom5']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                      <?php
                      $barColor = match($p['status']) { 'critical' => '#ef4444', 'warning' => '#f59e0b', 'attention' => '#38bdf8', default => '#22c55e' };
                      ?>
                      <tr style="border-bottom:1px solid var(--border);">
                        <td class="ps-4 py-3 fw-medium"><?php echo e($p['name']); ?></td>
                        <td class="py-3"><?php echo e(number_format($p['stock'])); ?> <?php echo e($p['uom']); ?></td>
                        <td class="py-3"><?php echo e(number_format($p['avgMonthly'], 1)); ?> <?php echo e($p['uom']); ?></td>
                        <td class="py-3 fw-semibold"><?php echo e(fmtBulan($p['monthsUntilEmpty'])); ?></td>
                        <td class="text-center py-3">
                          <span class="badge rounded-pill px-3 py-2" style="background:<?php echo e($barColor); ?>20;color:<?php echo e($barColor); ?>;border:1px solid <?php echo e($barColor); ?>50;">
                            <?php echo e($p['statusText']); ?>

                          </span>
                        </td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                      <tr><td colspan="5" class="text-center text-muted py-4">Tiada data penggunaan.</td></tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          
          <?php if(count($predictions['top5']) > 0): ?>
          <div class="row">
            <div class="col-12">
              <div class="card" style="background:var(--surface);border:1px solid var(--border);border-top:3px solid #38bdf8;border-radius:16px;padding:24px;">
                <div class="d-flex align-items-center gap-2 mb-3">
                  <i class="bi bi-bar-chart-line" style="font-size:1.3rem;color:var(--accent);"></i>
                  <h5 class="mb-0" style="font-weight:600;">Ramalan 3 Bulan (5 Item Paling Cepat Habis)</h5>
                </div>
                <div style="position:relative;height:260px;">
                  <canvas id="forecastChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

      
      <?php if(isset($contractData) && $contractData['summary']['total'] > 0): ?>
      <div class="row mt-5">
        <div class="col-12">
          <div class="d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-file-earmark-text" style="font-size:1.5rem;color:var(--accent);"></i>
            <h3 class="mb-0" style="font-weight:700;">Pemantauan Had Kontrak</h3>
          </div>

          <?php if($contractData['hasCritical']): ?>
          <div class="alert alert-warning d-flex align-items-center gap-3 mb-4"
            style="background:rgba(245,158,11,.12);border:1px solid rgba(245,158,11,.3);border-radius:16px;color:var(--text);"
            role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-4" style="color:#f59e0b;"></i>
            <div>
              <strong>Perhatian!</strong>
              Terdapat <strong><?php echo e($contractData['summary']['near']); ?></strong> kontrak hampir mencapai had
              dan <strong><?php echo e($contractData['summary']['over']); ?></strong> kontrak telah melebihi had.
              Sila ambil tindakan sewajarnya.
            </div>
          </div>
          <?php endif; ?>

          <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
              <div class="card h-100 text-center p-3"
                style="background:var(--surface);border:1px solid var(--border);border-radius:16px;">
                <div class="text-white-50 small">Jumlah Kontrak</div>
                <div class="fs-3 fw-bold"><?php echo e($contractData['summary']['total']); ?></div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card h-100 text-center p-3"
                style="background:var(--surface);border:1px solid var(--border);border-radius:16px;">
                <div class="text-white-50 small">Selamat</div>
                <div class="fs-3 fw-bold" style="color:#22c55e;"><?php echo e($contractData['summary']['safe']); ?></div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card h-100 text-center p-3"
                style="background:var(--surface);border:1px solid var(--border);border-radius:16px;">
                <div class="text-white-50 small">Hampir Had</div>
                <div class="fs-3 fw-bold" style="color:#f59e0b;"><?php echo e($contractData['summary']['near']); ?></div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card h-100 text-center p-3"
                style="background:var(--surface);border:1px solid var(--border);border-radius:16px;">
                <div class="text-white-50 small">Melebihi Had</div>
                <div class="fs-3 fw-bold" style="color:#ef4444;"><?php echo e($contractData['summary']['over']); ?></div>
              </div>
            </div>
          </div>

          <div class="card"
            style="background:var(--surface);border:1px solid var(--border);border-radius:16px;overflow:hidden;">
            <div class="table-responsive">
              <table class="table table-dark table-borderless mb-0" style="background:transparent;">
                <thead>
                  <tr style="border-bottom:1px solid var(--border);">
                    <th class="text-white-50 small fw-semibold ps-4 py-3">No. Kontrak</th>
                    <th class="text-white-50 small fw-semibold py-3">Pembekal</th>
                    <th class="text-white-50 small fw-semibold py-3">Had (RM)</th>
                    <th class="text-white-50 small fw-semibold py-3">Diguna (RM)</th>
                    <th class="text-white-50 small fw-semibold py-3">Baki (RM)</th>
                    <th class="text-white-50 small fw-semibold py-3">Penggunaan</th>
                    <th class="text-white-50 small fw-semibold text-center py-3">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $contractData['contracts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                  $barColor = match($c['status']) {
                  'over' => '#ef4444',
                  'hit' => '#ef4444',
                  'near' => '#f59e0b',
                  default => '#22c55e'
                  };
                  ?>
                  <tr style="border-bottom:1px solid var(--border);">
                    <td class="ps-4 py-3 fw-medium"><?php echo e($c['contract_no']); ?></td>
                    <td class="py-3"><?php echo e($c['supplier']); ?></td>
                    <td class="py-3"><?php echo e(number_format($c['limit'], 2)); ?></td>
                    <td class="py-3"><?php echo e(number_format($c['used'], 2)); ?></td>
                    <td class="py-3"><?php echo e(number_format($c['remaining'], 2)); ?></td>
                    <td class="py-3" style="min-width:180px;">
                      <div class="d-flex align-items-center gap-2">
                        <div class="progress flex-grow-1" style="height:8px;background:rgba(255,255,255,.1);border-radius:4px;">
                          <div class="progress-bar" role="progressbar"
                            style="width:<?php echo e($c['percentage']); ?>%;background:<?php echo e($barColor); ?>;border-radius:4px;transition:width 0.6s ease;"
                            aria-valuenow="<?php echo e($c['percentage']); ?>" aria-valuemin="0" aria-valuemax="100">
                          </div>
                        </div>
                        <span class="small text-white-50" style="min-width:45px;"><?php echo e($c['percentage']); ?>%</span>
                      </div>
                    </td>
                    <td class="text-center py-3">
                      <span class="badge rounded-pill px-3 py-2 fs-6"
                        style="background:<?php echo e($barColor); ?>20;color:<?php echo e($barColor); ?>;border:1px solid <?php echo e($barColor); ?>50;">
                        <?php echo e($c['statusText']); ?>

                      </span>
                    </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      
      <?php if(isset($contractTrend) && count($contractTrend['datasets']) > 0): ?>
      <div class="row mt-4">
        <div class="col-12">
          <div class="card chart-card"
            style="background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:24px;">
            <div class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-graph-up" style="font-size:1.3rem;color:var(--accent);"></i>
              <h5 class="mb-0" style="font-weight:600;">Aliran Penggunaan Kontrak (6 Bulan)</h5>
            </div>
            <div style="position:relative;height:260px;">
              <canvas id="contractTrendChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
      <?php endif; ?>

      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
          <?php if(Auth::user()->hasPermission('borang_inden')): ?>
          <div class="action-card">
            <div>
              <h4 class="mb-1">Cipta Inden Baru</h4>
              <p class="muted mb-0">Isi borang inden digital untuk membuat permohonan baru.</p>
            </div>
            <a href="<?php echo e(route('borang.inden')); ?>" class="btn btn-custom">Borang Inden <i
                class="bi bi-arrow-right-short fs-5 align-middle"></i></a>
          </div>
          <?php endif; ?>
          <?php if(Auth::user()->hasPermission('penerimaan_inden')): ?>
          <div class="action-card">
            <div>
              <h4 class="mb-1">Penerimaan Barang</h4>
              <p class="muted mb-0">Rekod penerimaan barang daripada pembekal berdasarkan pesanan inden.</p>
            </div>
            <a href="<?php echo e(route('borang.penerimaan')); ?>" class="btn btn-custom">Penerimaan <i
                class="bi bi-arrow-right-short fs-5 align-middle"></i></a>
          </div>
          <?php endif; ?>
          <?php if(Auth::user()->hasPermission('pengesahan_inden')): ?>
          <div class="action-card">
            <div>
              <h4 class="mb-1">Pengesahan Inden</h4>
              <p class="muted mb-0">Sahkan dan luluskan permohonan inden yang menunggu kelulusan.</p>
            </div>
            <a href="<?php echo e(route('user.pengesahan.inden')); ?>" class="btn btn-custom">Pengesahan <i
                class="bi bi-arrow-right-short fs-5 align-middle"></i></a>
          </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </main>

  <footer class="text-center py-4" style="border-top: 1px solid rgba(255,255,255,0.05); margin-top: auto;">
    <p class="mb-0 text-white-50"><small>&copy; 2026 MySIPMa. Hak Cipta Terpelihara.</small></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="<?php echo e(asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
  <script src="<?php echo e(asset('frontend/Nexa/assets/js/mobile-nav.js')); ?>"></script>
    <script src="<?php echo e(asset('js/session-timeout.js')); ?>"></script>
  <script src="<?php echo e(asset('js/user-theme.js')); ?>"></script>

  <script>
    (function () {
      // 3D tilt on stat cards
      document.querySelectorAll('.stat-card').forEach(function(card) {
        card.addEventListener('mousemove', function(e) {
          var rect = card.getBoundingClientRect();
          var x = e.clientX - rect.left;
          var y = e.clientY - rect.top;
          var centerX = rect.width / 2;
          var centerY = rect.height / 2;
          var rotateX = (y - centerY) / 12;
          var rotateY = (centerX - x) / 12;
          card.style.transform = 'translateY(-14px) scale(1.04) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg)';
        });
        card.addEventListener('mouseleave', function() {
          card.style.transform = 'translateY(0) scale(1) rotateX(0) rotateY(0)';
        });
      });

      // Animated counter on load
      document.querySelectorAll('.stat-value[data-count]').forEach(function(el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        if (target === 0) return;
        var current = 0;
        var increment = Math.max(1, Math.ceil(target / 40));
        var timer = setInterval(function() {
          current += increment;
          if (current >= target) {
            current = target;
            clearInterval(timer);
          }
          el.textContent = current;
        }, 30);
      });
    })();
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var ctx = document.getElementById('contractTrendChart');
      if (!ctx) return;

      var isLight = document.documentElement.getAttribute('data-bs-theme') === 'light';
      var gridColor = isLight ? 'rgba(0,0,0,0.08)' : 'rgba(255,255,255,0.08)';
      var textColor = isLight ? '#6b7280' : '#94a3b8';

      var chartData = <?php echo json_encode($contractTrend ?? [], 15, 512) ?>;

      var datasets = chartData.datasets.map(function(ds) {
        var limitLine = {
          label: ds.label + ' (Had)',
          data: ds.limit ? chartData.labels.map(function() { return ds.limit; }) : [],
          fill: false,
          borderColor: '#ef4444',
          borderDash: [6, 4],
          borderWidth: 1.5,
          pointRadius: 0,
          pointHoverRadius: 0,
        };

        return {
          label: ds.label,
          data: ds.data,
          fill: false,
          tension: 0.3,
          borderWidth: 2.5,
          pointRadius: 4,
          pointHoverRadius: 6,
        };
      });

      var limitDatasets = [];
      chartData.datasets.forEach(function(ds) {
        if (ds.limit) {
          limitDatasets.push({
            label: ds.label + ' (Had)',
            data: chartData.labels.map(function() { return ds.limit; }),
            fill: false,
            borderColor: '#ef4444',
            borderDash: [6, 4],
            borderWidth: 1.5,
            pointRadius: 0,
            pointHoverRadius: 0,
          });
        }
      });

      var allDatasets = datasets.concat(limitDatasets);

      var chartColors = ['#10b981', '#38bdf8', '#f59e0b', '#8b5cf6', '#f472b6'];

      allDatasets.forEach(function(ds, i) {
        if (ds.borderDash) return;
        ds.borderColor = chartColors[i % chartColors.length];
        ds.backgroundColor = chartColors[i % chartColors.length] + '20';
      });

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: chartData.labels,
          datasets: allDatasets,
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                color: textColor,
                usePointStyle: true,
                padding: 16,
                font: { size: 11 },
              },
            },
            tooltip: {
              callbacks: {
                label: function(ctx) {
                  if (ctx.dataset.borderDash) {
                    return ctx.dataset.label + ': RM ' + ctx.parsed.y.toFixed(2);
                  }
                  return ctx.dataset.label + ': RM ' + ctx.parsed.y.toFixed(2);
                },
              },
            },
          },
          scales: {
            x: {
              ticks: { color: textColor, font: { size: 11 } },
              grid: { color: gridColor },
            },
            y: {
              beginAtZero: true,
              ticks: {
                color: textColor,
                font: { size: 11 },
                callback: function(val) { return 'RM ' + val.toFixed(0); },
              },
              grid: { color: gridColor },
            },
          },
        },
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var fCtx = document.getElementById('forecastChart');
      if (!fCtx) return;

      var isLight = document.documentElement.getAttribute('data-bs-theme') === 'light';
      var gridColor = isLight ? 'rgba(0,0,0,0.08)' : 'rgba(255,255,255,0.08)';
      var textColor = isLight ? '#6b7280' : '#94a3b8';

      var predictions = <?php echo json_encode($predictions ?? [], 15, 512) ?>;
      var top5 = predictions.top5 || [];
      if (top5.length === 0) return;

      var labels = predictions.forecastLabels || ['Bulan 1', 'Bulan 2', 'Bulan 3'];
      var chartColors = ['#10b981', '#38bdf8', '#f59e0b', '#8b5cf6', '#f472b6'];

      var datasets = top5.map(function(item, i) {
        return {
          label: item.name,
          data: item.forecast,
          borderColor: chartColors[i % chartColors.length],
          backgroundColor: chartColors[i % chartColors.length] + '20',
          fill: false,
          tension: 0.3,
          borderWidth: 2.5,
          pointRadius: 4,
          pointHoverRadius: 6,
        };
      });

      new Chart(fCtx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: datasets,
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: { color: textColor, usePointStyle: true, padding: 16, font: { size: 11 } },
            },
            tooltip: {
              callbacks: {
                label: function(ctx) {
                  return ctx.dataset.label + ': ' + ctx.parsed.y.toFixed(1) + ' unit';
                },
              },
            },
          },
          scales: {
            x: {
              ticks: { color: textColor, font: { size: 11 } },
              grid: { color: gridColor },
            },
            y: {
              beginAtZero: true,
              ticks: { color: textColor, font: { size: 11 } },
              grid: { color: gridColor },
            },
          },
        },
      });
    });
  </script>

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
<?php /**PATH C:\laragon\www\MySIPMA_2\resources\views/user_dashboard.blade.php ENDPATH**/ ?>