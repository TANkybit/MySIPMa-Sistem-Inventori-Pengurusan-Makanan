<!DOCTYPE html>
<html lang="ms" data-bs-theme="light">

<head>
  <script>document.documentElement.setAttribute('data-bs-theme',localStorage.getItem('theme')||'light')</script>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Papan Pemuka Pengguna - MySIPMa</title>

  <link rel="icon" type="image/png" href="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/css/main2.css') }}" rel="stylesheet">
  <link href="{{ asset('css/user-theme.css') }}" rel="stylesheet">

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
        left: 50%;
        position: absolute;
        transform: translateX(-50%);
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
    @keyframes logoPulse { 0% { filter: brightness(180%) drop-shadow(2px 3px 0 rgba(0,0,0,.8)) drop-shadow(1px 1px 0 rgba(0,0,0,.5)) drop-shadow(0 0 8px rgba(16,185,129,.3)); transform: scale(1); } 50% { filter: brightness(210%) drop-shadow(2px 3px 0 rgba(0,0,0,.9)) drop-shadow(1px 1px 0 rgba(0,0,0,.6)) drop-shadow(0 0 16px rgba(16,185,129,.6)) drop-shadow(0 0 30px rgba(16,185,129,.2)); transform: scale(1.03); } 100% { filter: brightness(180%) drop-shadow(2px 3px 0 rgba(0,0,0,.8)) drop-shadow(1px 1px 0 rgba(0,0,0,.5)) drop-shadow(0 0 8px rgba(16,185,129,.3)); transform: scale(1); } }
    @keyframes logoShine { 0% { filter: brightness(150%) drop-shadow(0 0 0 transparent); } 50% { filter: brightness(200%) drop-shadow(0 0 8px rgba(16,185,129,.5)); } 100% { filter: brightness(150%) drop-shadow(0 0 0 transparent); } }
    [data-bs-theme="light"] .logo-glow { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    [data-bs-theme="light"] .logo-glow:hover { transform: scale(1.08) !important; }
    [data-bs-theme="light"] .logo-glow img { filter: brightness(180%) drop-shadow(2px 3px 0 rgba(0,0,0,.8)) drop-shadow(1px 1px 0 rgba(0,0,0,.5)) drop-shadow(-1px -1px 0 rgba(255,255,255,.4)) !important; animation: logoPulse 3s ease-in-out infinite; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    [data-bs-theme="light"] .logo-glow:hover img { filter: brightness(250%) drop-shadow(3px 4px 0 rgba(0,0,0,.9)) drop-shadow(2px 2px 0 rgba(0,0,0,.6)) drop-shadow(0 0 20px rgba(16,185,129,.6)) drop-shadow(0 0 40px rgba(16,185,129,.3)) !important; transform: scale(1.08) !important; animation: logoShine 1s ease-in-out infinite; }
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
  </style>
</head>

<body>

  <header id="header" class="header d-flex align-items-center sticky-top"
    style="background: rgba(2,2,4,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="#" class="logo-glow d-flex align-items-center me-auto me-xl-0" id="logoLogoutTrigger">
        <img src="{{ asset('frontend/Nexa/assets/img/WORDINGMYSIPMA2.png') }}" style="height: 55px; width: auto;"
          alt="MySIPMa logo">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('user.dashboard') }}"
              class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a></li>
          <li><a href="{{ route('user.senarai.inden') }}"
              class="{{ request()->routeIs('user.senarai.inden') ? 'active' : '' }}">Senarai Inden</a></li>
          @if(Auth::user()->hasPermission('pengesahan_inden'))
          <li><a href="{{ route('user.pengesahan.inden') }}"
              class="{{ request()->routeIs('user.pengesahan.inden') ? 'active' : '' }}">Pengesahan Inden</a></li>
          @endif
          @if(Auth::user()->hasPermission('borang_inden'))
          <li><a href="{{ route('borang.inden') }}"
               class="{{ request()->routeIs('borang.inden*') ? 'active' : '' }}">Borang Inden</a></li>
          @endif
          @if(Auth::user()->hasPermission('penerimaan_inden'))
          <li><a href="{{ route('borang.penerimaan') }}" class="{{ request()->routeIs('borang.penerimaan') ? 'active' : '' }}">Penerimaan</a></li>
          @endif
          <li class="d-xl-none"><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">Profil</a></li>
          <li class="d-xl-none"><a href="#" id="navLogoutBtn" class="text-danger">Log Keluar</a></li>
          </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-none d-xl-flex align-items-center gap-3">
        @if(Auth::user()->hasPermission('pengesahan_inden'))
        <a href="{{ route('user.pengesahan.inden') }}" class="position-relative text-white fs-5 me-3"
          style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'"
          onmouseout="this.style.color=''">
          <i class="bi bi-bell-fill"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="font-size: 0.65rem;">
            {{ $pendingApprovals ?? 0 }}
            <span class="visually-hidden">Inden belum disah</span>
          </span>
        </a>
        @endif
        @if(Auth::user()->hasPermission('penerimaan_inden'))
        <a href="{{ route('borang.penerimaan') }}" class="position-relative text-white fs-5 me-3"
          style="transition: color 0.3s;" onmouseover="this.style.color='#f59e0b'"
          onmouseout="this.style.color=''">
          <i class="bi bi-truck"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="font-size: 0.65rem;">
            {{ $pendingPenerimaan ?? 0 }}
            <span class="visually-hidden">Penerimaan belum diproses</span>
          </span>
        </a>
        @endif
        <button class="btn btn-icon" id="themeToggle" style="background:none;border:none;color:var(--text);font-size:1.2rem;padding:4px 8px"><i class="bi bi-moon-fill"></i></button>
        <a href="{{ route('profile') }}" class="text-white-50 text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color=''"><i
            class="bi bi-person-circle me-2"></i>{{ Auth::user()->name ?? 'Pengguna' }}</a>
        <button type="button" class="btn btn-custom btn-logout btn-sm px-3 py-2" id="desktopLogoutBtn"><i
              class="bi bi-box-arrow-right me-2"></i>Log Keluar</button>
      </div>
    </div>
  </header>

  <main class="dashboard-container">
    <div class="container" data-aos="fade-up">

      <div class="dashboard-header text-center">
        <h1>Papan Pemuka</h1>
        <p class="muted">Selamat datang, {{ Auth::user()->name ?? 'Pengguna' }}. Pantau statistik dan status inden anda
          di sini.</p>
      </div>

      <div class="row g-4 justify-content-center">
        <!-- Stat Card 1 -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon">
              <i class="bi bi-file-earmark-text"></i>
            </div>
            <h3 class="stat-title">Jumlah Inden</h3>
            <p class="stat-value" data-count="{{ $totalOrders ?? 0 }}">{{ $totalOrders ?? 0 }}</p>
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
            <p class="stat-value" data-count="{{ $pendingApprovals ?? 0 }}">{{ $pendingApprovals ?? 0 }}</p>
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
            <p class="stat-value" data-count="{{ $inProgressOrders ?? 0 }}">{{ $inProgressOrders ?? 0 }}</p>
            <p class="text-white-50 small mb-0 mt-2">Diluluskan dan sedang diproses / dihantar</p>
          </div>
        </div>

        @if(Auth::user()->hasPermission('penerimaan_inden'))
        <!-- Stat Card Penerimaan -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon" style="color: #f59e0b; background: rgba(245,158,11,.1);">
              <i class="bi bi-box-seam"></i>
            </div>
            <h3 class="stat-title">Penerimaan</h3>
            <p class="stat-value" data-count="{{ $pendingPenerimaan ?? 0 }}">{{ $pendingPenerimaan ?? 0 }}</p>
            <p class="text-white-50 small mb-0 mt-2">Belum diterima</p>
          </div>
        </div>
        @endif

        <!-- Stat Card 4 -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="glow-ring"></div>
            <div class="stat-icon" style="color: #22c55e; background: rgba(34,197,94,.1);">
              <i class="bi bi-check2-circle"></i>
            </div>
            <h3 class="stat-title">Selesai</h3>
            <p class="stat-value" data-count="{{ $completedOrders ?? 0 }}">{{ $completedOrders ?? 0 }}</p>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
          @if(Auth::user()->hasPermission('borang_inden'))
          <div class="action-card">
            <div>
              <h4 class="mb-1">Cipta Inden Baru</h4>
              <p class="muted mb-0">Isi borang inden digital untuk membuat permohonan baru.</p>
            </div>
            <a href="{{ route('borang.inden') }}" class="btn btn-custom">Borang Inden <i
                class="bi bi-arrow-right-short fs-5 align-middle"></i></a>
          </div>
          @endif
          @if(Auth::user()->hasPermission('penerimaan_inden'))
          <div class="action-card">
            <div>
              <h4 class="mb-1">Penerimaan Barang</h4>
              <p class="muted mb-0">Rekod penerimaan barang daripada pembekal berdasarkan pesanan inden.</p>
            </div>
            <a href="{{ route('borang.penerimaan') }}" class="btn btn-custom">Penerimaan <i
                class="bi bi-arrow-right-short fs-5 align-middle"></i></a>
          </div>
          @endif
          @if(Auth::user()->hasPermission('pengesahan_inden'))
          <div class="action-card">
            <div>
              <h4 class="mb-1">Pengesahan Inden</h4>
              <p class="muted mb-0">Sahkan dan luluskan permohonan inden yang menunggu kelulusan.</p>
            </div>
            <a href="{{ route('user.pengesahan.inden') }}" class="btn btn-custom">Pengesahan <i
                class="bi bi-arrow-right-short fs-5 align-middle"></i></a>
          </div>
          @endif
        </div>
      </div>

    </div>
  </main>

  <footer class="text-center py-4" style="border-top: 1px solid rgba(255,255,255,0.05); margin-top: auto;">
    <p class="mb-0 text-white-50"><small>&copy; 2026 MySIPMa. Hak Cipta Terpelihara.</small></p>
  </footer>

  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/js/mobile-nav.js') }}"></script>
    <script src="{{ asset('js/session-timeout.js') }}"></script>
  <script src="{{ asset('js/user-theme.js') }}"></script>

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
</body>

</html>
