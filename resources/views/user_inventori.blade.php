<!DOCTYPE html>
<html lang="ms" data-bs-theme="light">

<head>
  <script>document.documentElement.setAttribute('data-bs-theme',localStorage.getItem('theme')||'light')</script>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Inventori - MySIPMa</title>

  <link rel="icon" type="image/png" href="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/css/main2.css') }}" rel="stylesheet">
  <link href="{{ asset('css/user-theme.css') }}" rel="stylesheet">

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
      background: #e0f2fe;
      border: 1px solid #bae6fd;
      border-radius: 24px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,.08);
    }

    [data-bs-theme="dark"] .card-table {
      background: var(--surface);
      border: 1px solid var(--border);
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

    /* Summary Cards */
    .summary-card {
      background: var(--surface);
      border: 2px solid transparent;
      border-radius: 24px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 18px 48px rgba(0,0,0,.3);
      height: 100%;
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      cursor: pointer;
      perspective: 800px;
    }

    .summary-card::before {
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

    .summary-card::after {
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

    .summary-card .glow-ring {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 60px;
      height: 60px;
      border: 3px solid rgba(16, 185, 129, .15);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      pointer-events: none;
      z-index: 0;
      opacity: 0;
      transition: opacity 0.4s ease;
    }

    .summary-card:hover .glow-ring {
      opacity: 1;
      animation: ringPulse 1.2s ease-out infinite;
    }

    .summary-card:hover {
      transform: translateY(-14px) scale(1.04) rotateX(2deg);
      box-shadow:
        0 25px 70px rgba(16, 185, 129, .4),
        0 0 40px rgba(16, 185, 129, .2),
        0 0 80px rgba(16, 185, 129, .1);
    }

    .summary-card:hover::before {
      background: linear-gradient(135deg, #10b981, #059669, #34d399, #10b981, #06b6d4, #10b981);
      background-size: 400% 400%;
      animation: gradientBorder 2s ease infinite;
    }

    .summary-card:hover::after {
      left: 120%;
    }

    .summary-card .stat-icon {
      font-size: 2.5rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 70px;
      height: 70px;
      border-radius: 18px;
      margin-bottom: 14px;
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .summary-card:hover .stat-icon {
      animation: iconFloat 1.2s ease-in-out infinite;
      box-shadow: 0 0 25px rgba(16, 185, 129, .5), 0 0 50px rgba(16, 185, 129, .2), 0 0 80px rgba(16, 185, 129, .1);
      border-radius: 20px;
      transform: scale(1.15);
    }

    .summary-card .card-value {
      font-size: 3.5rem;
      font-weight: 800;
      font-family: "Montserrat", sans-serif;
      line-height: 1.2;
      margin-bottom: 4px;
      transition: all 0.3s ease;
      position: relative;
      z-index: 1;
    }

    .summary-card:hover .card-value {
      animation: neonPulse 1.5s ease-in-out infinite;
    }

    .summary-card .card-label {
      color: var(--muted);
      font-size: 0.95rem;
      font-weight: 500;
      transition: color 0.3s ease;
      position: relative;
      z-index: 1;
    }

    .summary-card:hover .card-label {
      color: var(--accent);
    }

    @keyframes ringPulse {
      0% { transform: translate(-50%, -50%) scale(1); opacity: .6; }
      100% { transform: translate(-50%, -50%) scale(1.8); opacity: 0; }
    }

    @keyframes gradientBorder {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes iconFloat {
      0%, 100% { transform: translateY(0) scale(1.15); }
      50% { transform: translateY(-8px) scale(1.15); }
    }

    @keyframes neonPulse {
      0%, 100% { text-shadow: 0 0 8px currentColor; }
      50% { text-shadow: 0 0 20px currentColor, 0 0 40px currentColor; }
    }

    /* Colored summary card backgrounds - light blue theme */
    #inventStatsRow > .col-md-3:nth-child(1) .summary-card { background: #e0f2fe; border-color: #bae6fd; }
    #inventStatsRow > .col-md-3:nth-child(2) .summary-card { background: #fee2e2; border-color: #fecaca; }
    #inventStatsRow > .col-md-3:nth-child(3) .summary-card { background: #fef3c7; border-color: #fde68a; }
    #inventStatsRow > .col-md-3:nth-child(4) .summary-card { background: #d1fae5; border-color: #a7f3d0; }

    [data-bs-theme="light"] #inventStatsRow > .col-md-3:nth-child(1) .summary-card { background: #e0f2fe !important; }
    [data-bs-theme="light"] #inventStatsRow > .col-md-3:nth-child(2) .summary-card { background: #fee2e2 !important; }
    [data-bs-theme="light"] #inventStatsRow > .col-md-3:nth-child(3) .summary-card { background: #fef3c7 !important; }
    [data-bs-theme="light"] #inventStatsRow > .col-md-3:nth-child(4) .summary-card { background: #d1fae5 !important; }

    [data-bs-theme="dark"] #inventStatsRow > .col-md-3:nth-child(1) .summary-card { background: #172554; }
    [data-bs-theme="dark"] #inventStatsRow > .col-md-3:nth-child(2) .summary-card { background: #450a0a; }
    [data-bs-theme="dark"] #inventStatsRow > .col-md-3:nth-child(3) .summary-card { background: #451a03; }
    [data-bs-theme="dark"] #inventStatsRow > .col-md-3:nth-child(4) .summary-card { background: #052e16; }

    /* DataTables light theme */
    .table-inventori { color: #111827 !important; border-color: #e5e7eb !important; }
    .table-inventori th {
      background: #4b5563 !important;
      color: #fff !important;
      border-bottom: 2px solid var(--border) !important;
    }
    .table-inventori td {
      background: #fff !important;
      color: #111827 !important;
      border-bottom: 1px solid #e5e7eb !important;
      vertical-align: middle;
    }
    .table-inventori tbody tr:hover td { background: #f9fafb !important; }
    [data-bs-theme="dark"] .table-inventori { color: var(--text) !important; border-color: var(--border) !important; }
    [data-bs-theme="dark"] .table-inventori th {
      background: linear-gradient(135deg, #065f46, #047857) !important;
      color: #fff !important;
      border-color: var(--border) !important;
    }
    [data-bs-theme="dark"] .table-inventori td {
      background: transparent !important;
      color: #ffffff !important;
      border-color: var(--border) !important;
    }
    [data-bs-theme="dark"] .table-inventori tbody tr:hover td { background: rgba(255,255,255,0.05) !important; }

    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label,
    div.dataTables_wrapper div.dataTables_info {
      color: var(--muted) !important;
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

    [data-bs-theme="light"] div.dataTables_wrapper div.dataTables_length label,
    [data-bs-theme="light"] div.dataTables_wrapper div.dataTables_filter label,
    [data-bs-theme="light"] div.dataTables_wrapper div.dataTables_info { color:#6b7280 !important; }
    [data-bs-theme="light"] .page-item .page-link { background:#fff !important; border-color:#e5e7eb !important; color:#374151 !important; }
    [data-bs-theme="light"] .page-item.active .page-link { background:#10b981 !important; border-color:#10b981 !important; color:#fff !important; }
    [data-bs-theme="light"] .form-control-sm,[data-bs-theme="light"] .form-select-sm { background:#fff !important; border-color:#d1d5db !important; color:#111827 !important; }

    @keyframes logoPulse { 0% { filter: brightness(180%) drop-shadow(2px 3px 0 rgba(0,0,0,.8)) drop-shadow(1px 1px 0 rgba(0,0,0,.5)) drop-shadow(0 0 8px rgba(16,185,129,.3)); transform: scale(1); } 50% { filter: brightness(210%) drop-shadow(2px 3px 0 rgba(0,0,0,.9)) drop-shadow(1px 1px 0 rgba(0,0,0,.6)) drop-shadow(0 0 16px rgba(16,185,129,.6)) drop-shadow(0 0 30px rgba(16,185,129,.2)); transform: scale(1.03); } 100% { filter: brightness(180%) drop-shadow(2px 3px 0 rgba(0,0,0,.8)) drop-shadow(1px 1px 0 rgba(0,0,0,.5)) drop-shadow(0 0 8px rgba(16,185,129,.3)); transform: scale(1); } }
    @keyframes logoShine { 0% { filter: brightness(150%) drop-shadow(0 0 0 transparent); } 50% { filter: brightness(200%) drop-shadow(0 0 8px rgba(16,185,129,.5)); } 100% { filter: brightness(150%) drop-shadow(0 0 0 transparent); } }
    [data-bs-theme="light"] .logo-glow img { filter: brightness(180%) drop-shadow(2px 3px 0 rgba(0,0,0,.8)) drop-shadow(1px 1px 0 rgba(0,0,0,.5)) drop-shadow(-1px -1px 0 rgba(255,255,255,.4)) !important; animation: logoPulse 3s ease-in-out infinite; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    [data-bs-theme="light"] .logo-glow:hover img { filter: brightness(250%) drop-shadow(3px 4px 0 rgba(0,0,0,.9)) drop-shadow(2px 2px 0 rgba(0,0,0,.6)) drop-shadow(0 0 20px rgba(16,185,129,.6)) drop-shadow(0 0 40px rgba(16,185,129,.3)) !important; transform: scale(1.08) !important; animation: logoShine 1s ease-in-out infinite; }
    [data-bs-theme="light"] .logo-glow { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    [data-bs-theme="light"] .logo-glow:hover { transform: scale(1.08) !important; }
    .mobile-nav-toggle { font-size:24px; cursor:pointer; }
    .mobile-nav-toggle.bi::before { color:#fff; }
    [data-bs-theme="light"] .mobile-nav-toggle.bi::before { color:#111827; }
    [data-bs-theme="light"] body { background:var(--bg); color:var(--text); }
    [data-bs-theme="light"] h1,[data-bs-theme="light"] h2,[data-bs-theme="light"] h3,[data-bs-theme="light"] h4 { color:#111827; }
    [data-bs-theme="light"] #header { background:rgba(255,255,255,.8) !important; border-bottom:1px solid #e5e7eb !important; }
    [data-bs-theme="light"] .dropdown-menu { background:#fff; border-color:#e5e7eb; color:#111827; }
    [data-bs-theme="light"] .dropdown-item { color:#374151; }
    [data-bs-theme="light"] .dropdown-item:hover,[data-bs-theme="light"] .dropdown-item:focus { background:#f3f4f6; color:#111827; }
    [data-bs-theme="light"] select option { color:#111827; background:#fff; }
    [data-bs-theme="light"] .summary-card { border-color:var(--border); }
    [data-bs-theme="light"] .card-table { background: #e0f2fe; border-color: #bae6fd; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
    [data-bs-theme="dark"] .card-table { background: var(--surface); border-color: var(--border); }

    /* Mobile nav links */
    .navmenu ul li a.text-danger { color:#f87171 !important; }
    .navmenu ul li a.text-danger:hover { color:#ef4444 !important; }
    [data-bs-theme="light"] .navmenu ul li a.text-danger { color:#000 !important; }
    [data-bs-theme="light"] .navmenu ul li a.text-danger:hover { color:#dc2626 !important; }

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

    .progress-status {
      height: 8px;
      border-radius: 999px;
      background: rgba(0,0,0,.1);
      min-width: 80px;
    }
    [data-bs-theme="dark"] .progress-status {
      background: rgba(255,255,255,.1);
    }
    .progress-status .progress-bar {
      border-radius: 999px;
    }
  </style>

<body>

  <header id="header" class="header d-flex align-items-center sticky-top" style="background: rgba(2,2,4,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container position-relative d-flex align-items-center">
      <a href="#" class="logo-glow d-flex align-items-center" id="logoLogoutTrigger">
        <img src="{{ asset('frontend/Nexa/assets/img/WORDINGMYSIPMA2.png') }}" style="height: 55px; width: auto;" alt="MySIPMa logo">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Papan Pemuka</a></li>
          <li><a href="{{ route('user.senarai.inden') }}" class="{{ request()->routeIs('user.senarai.inden') ? 'active' : '' }}">Senarai Inden</a></li>
          <li><a href="{{ route('user.inventori') }}" class="{{ request()->routeIs('user.inventori') ? 'active' : '' }}">Inventori</a></li>
          @if(Auth::user()->hasPermission('pengesahan_inden'))
          <li><a href="{{ route('user.pengesahan.inden') }}" class="{{ request()->routeIs('user.pengesahan.inden') ? 'active' : '' }}">Pengesahan Inden</a></li>
          @endif
          @if(Auth::user()->hasPermission('borang_inden'))
          <li><a href="{{ route('borang.inden') }}" class="{{ request()->routeIs('borang.inden*') ? 'active' : '' }}">Borang Inden</a></li>
          @endif
          @if(Auth::user()->hasPermission('penerimaan_inden'))
          <li><a href="{{ route('borang.penerimaan') }}" class="{{ request()->routeIs('borang.penerimaan') ? 'active' : '' }}">Penerimaan</a></li>
          @endif
          @if(Auth::user()->hasPermission('penilaian_prestasi'))
          <li><a href="{{ route('user.penilaian_prestasi') }}" class="{{ request()->routeIs('user.penilaian_prestasi') ? 'active' : '' }}">Penilaian Prestasi</a></li>
          @endif
          <li class="d-xl-none"><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">Profil</a></li>
          <li class="d-xl-none"><a href="#" id="navLogoutBtn" class="text-danger">Log Keluar</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-none d-xl-flex align-items-center gap-3">
        @if(Auth::user()->hasPermission('pengesahan_inden'))
        <a href="{{ route('user.pengesahan.inden') }}" class="position-relative text-white fs-5 me-3" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color=''">
          <i class="bi bi-bell-fill"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            {{ $pendingApprovals ?? 0 }}
            <span class="visually-hidden">Inden belum disah</span>
          </span>
        </a>
        @endif
        @if(Auth::user()->hasPermission('penerimaan_inden'))
        <a href="{{ route('borang.penerimaan') }}" class="position-relative text-white fs-5 me-3" style="transition: color 0.3s;" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color=''">
          <i class="bi bi-truck"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            {{ $pendingPenerimaan ?? 0 }}
            <span class="visually-hidden">Penerimaan belum diproses</span>
          </span>
        </a>
        @endif
        <button class="btn btn-icon" id="themeToggle" style="background:none;border:none;color:var(--text);font-size:1.2rem;padding:4px 8px"><i class="bi bi-moon-fill"></i></button>
        <a href="{{ route('profile') }}" class="text-white-50 text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color=''"><i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name ?? 'Pengguna' }}</a>
        <button type="button" class="btn btn-custom btn-logout btn-sm px-3 py-2" id="desktopLogoutBtn"><i class="bi bi-box-arrow-right me-2"></i>Log Keluar</button>
      </div>
    </div>
  </header>

  <main class="dashboard-container">
    <div class="container" data-aos="fade-up">

      <div class="dashboard-header text-center">
        <h1>Inventori</h1>
        <p class="muted">Paparan stok item dan status penggunaan siling kontrak.</p>
      </div>

      <!-- Summary Cards -->
      <div class="row g-4 mb-5 justify-content-center" id="inventStatsRow">
        <div class="col-md-3">
          <div class="summary-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon" style="color: var(--accent); background: rgba(16,185,129,.1);">
              <i class="bi bi-boxes"></i>
            </div>
            <div class="card-value" style="color: var(--accent);">{{ $totalItems }}</div>
            <div class="card-label">Jumlah Item</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="summary-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon" style="color: #ef4444; background: rgba(239,68,68,.1);">
              <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="card-value" style="color: #ef4444;">{{ $hampirHabis }}</div>
            <div class="card-label">Hampir Habis</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="summary-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon" style="color: #f59e0b; background: rgba(245,158,11,.1);">
              <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="card-value" style="color: #f59e0b;">{{ $sederhana }}</div>
            <div class="card-label">Sederhana</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="summary-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon" style="color: #22c55e; background: rgba(34,197,94,.1);">
              <i class="bi bi-check2-circle"></i>
            </div>
            <div class="card-value" style="color: #22c55e;">{{ $banyakLagi }}</div>
            <div class="card-label">Banyak Lagi</div>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="card-table">
            <div class="table-responsive">
              <table id="inventoriTable" class="table table-inventori w-100">
                <thead>
                  <tr>
                    <th>Bil</th>
                    <th>Item</th>
                    <th>Stok Semasa</th>
                    <th>Unit</th>
                    <th>Kontrak No</th>
                    <th>Siling (Kuantiti)</th>
                    <th>Jumlah Guna</th>
                    <th>Baki</th>
                    <th>% Guna</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($items as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td class="fw-semibold">{{ $item->name }}</td>
                      <td>{{ number_format($item->current_quantity, 0) }}</td>
                      <td>{{ $item->uom_code }}</td>
                      <td>{{ $item->contract_no }}</td>
                      <td>{{ $item->siling_kuantiti }}</td>
                      <td>{{ number_format($item->jumlah_guna, 0) }}</td>
                      <td>{{ $item->baki }}</td>
                      <td>
                        @if($item->siling_kuantiti !== '-')
                        <div class="d-flex align-items-center gap-2">
                          <div class="progress progress-status flex-grow-1">
                            <div class="progress-bar" role="progressbar" style="width: {{ min($item->peratus_guna, 100) }}%; background-color: {{ $item->warna_status }};" aria-valuenow="{{ $item->peratus_guna }}" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <small class="text-muted" style="min-width: 38px; text-align: right;">{{ $item->peratus_guna }}%</small>
                        </div>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                      </td>
                      <td>
                        <span class="badge" style="background-color: {{ $item->warna_status }}; color: #fff; padding: 6px 12px; border-radius: 999px; font-weight: 600;">{{ $item->status }}</span>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="10" class="text-center text-muted py-4">Tiada item inventori ditemui.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

  <footer class="text-center py-4" style="border-top: 1px solid rgba(255,255,255,0.05); margin-top: auto;">
    <p class="mb-0 text-muted"><small>&copy; 2026 MySIPMa. Hak Cipta Terpelihara.</small></p>
  </footer>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/js/mobile-nav.js') }}"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function() {
        @if($items->isNotEmpty())
        $('#inventoriTable').DataTable({
            pageLength: 10,
            pagingType: 'full_numbers',
            lengthChange: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            dom: '<"row align-items-center mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row align-items-center mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            order: [[9, 'asc']],
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
        @endif
    });
  </script>
    <script src="{{ asset('js/table-download-pdf.js') }}"></script>
    <script src="{{ asset('js/session-timeout.js') }}"></script>
  <script src="{{ asset('js/user-theme.js') }}"></script>

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
          <form action="{{ route('logout') }}" method="POST" id="logoutForm" class="d-inline">
            @csrf
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

  <!-- 3D Tilt effect on summary cards -->
  <script>
    document.querySelectorAll('.summary-card').forEach(function(card) {
      card.addEventListener('mousemove', function(e) {
        var rect = card.getBoundingClientRect();
        var x = e.clientX - rect.left;
        var y = e.clientY - rect.top;
        var centerX = rect.width / 2;
        var centerY = rect.height / 2;
        var rotateX = ((y - centerY) / centerY) * -6;
        var rotateY = ((x - centerX) / centerX) * 6;
        card.style.transform = 'translateY(-14px) scale(1.04) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg)';
      });
      card.addEventListener('mouseleave', function() {
        card.style.transform = '';
      });
    });
  </script>
</body>
</html>
