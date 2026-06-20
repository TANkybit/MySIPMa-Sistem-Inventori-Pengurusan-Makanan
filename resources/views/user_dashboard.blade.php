<!DOCTYPE html>
<html lang="ms">

<head>
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
    }

    .stat-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 24px;
      padding: 30px;
      box-shadow: 0 18px 48px rgba(0, 0, 0, .3);
      height: 100%;
      transition: transform 0.3s ease, border-color 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      border-color: rgba(16, 185, 129, .4);
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--accent), transparent);
      opacity: 0.7;
    }

    .stat-icon {
      font-size: 2.5rem;
      color: var(--accent);
      margin-bottom: 20px;
      display: inline-block;
      padding: 15px;
      background: rgba(16, 185, 129, .1);
      border-radius: 16px;
    }

    .stat-title {
      color: var(--muted);
      font-size: 1rem;
      font-weight: 500;
      margin-bottom: 10px;
      min-height: 24px;
    }

    .stat-value {
      font-size: 3.5rem;
      font-weight: 800;
      line-height: 1;
      margin-bottom: 0;
      font-family: "Montserrat", sans-serif;
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
  </style>
</head>

<body>

  <header id="header" class="header d-flex align-items-center sticky-top"
    style="background: rgba(2,2,4,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ route('index') }}" class="logo-glow d-flex align-items-center me-auto me-xl-0">
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
          </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-none d-xl-flex align-items-center gap-3">
        @if(Auth::user()->hasPermission('pengesahan_inden'))
        <a href="{{ route('user.pengesahan.inden') }}" class="position-relative text-white fs-5 me-3"
          style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'"
          onmouseout="this.style.color='white'">
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
          onmouseout="this.style.color='white'">
          <i class="bi bi-truck"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="font-size: 0.65rem;">
            {{ $pendingPenerimaan ?? 0 }}
            <span class="visually-hidden">Penerimaan belum diproses</span>
          </span>
        </a>
        @endif
        <a href="{{ route('profile') }}" class="text-white-50 text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='rgba(255,255,255,0.5)'"><i
            class="bi bi-person-circle me-2"></i>{{ Auth::user()->name ?? 'Pengguna' }}</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-custom btn-logout btn-sm px-3 py-2"><i
              class="bi bi-box-arrow-right me-2"></i>Log Keluar</button>
        </form>
      </div>
    </div>
  </header>

  <main class="dashboard-container">
    <div class="container" data-aos="fade-up">

      <div class="dashboard-header text-center">
        <h1>Papan Pemuka</h1>
        <p class="muted">Selamat datang, {{ Auth::user()->name ?? 'Pengguna' }}! Pantau statistik dan status inden anda
          di sini.</p>
      </div>

      <div class="row g-4 justify-content-center">
        <!-- Stat Card 1 -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="stat-icon">
              <i class="bi bi-file-earmark-text"></i>
            </div>
            <h3 class="stat-title">Total Indens</h3>
            <p class="stat-value">{{ $totalOrders ?? 0 }}</p>
          </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="stat-icon" style="color: #f59e0b; background: rgba(245,158,11,.1);">
              <i class="bi bi-hourglass-split"></i>
            </div>
            <h3 class="stat-title">Pending</h3>
            <p class="stat-value">{{ $pendingApprovals ?? 0 }}</p>
            <p class="text-white-50 small mb-0 mt-2">Waiting for approval</p>
          </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="stat-icon" style="color: #38bdf8; background: rgba(56,189,248,.1);">
              <i class="bi bi-truck"></i>
            </div>
            <h3 class="stat-title">In Progress</h3>
            <p class="stat-value">{{ $inProgressOrders ?? 0 }}</p>
            <p class="text-white-50 small mb-0 mt-2">Approved and being processed/delivered</p>
          </div>
        </div>

        @if(Auth::user()->hasPermission('penerimaan_inden'))
        <!-- Stat Card Penerimaan -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="stat-icon" style="color: #f59e0b; background: rgba(245,158,11,.1);">
              <i class="bi bi-box-seam"></i>
            </div>
            <h3 class="stat-title">Penerimaan</h3>
            <p class="stat-value">{{ $pendingPenerimaan ?? 0 }}</p>
            <p class="text-white-50 small mb-0 mt-2">Belum diterima</p>
          </div>
        </div>
        @endif

        <!-- Stat Card 4 -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="stat-icon" style="color: #22c55e; background: rgba(34,197,94,.1);">
              <i class="bi bi-check2-circle"></i>
            </div>
            <h3 class="stat-title">Completed</h3>
            <p class="stat-value">{{ $completedOrders ?? 0 }}</p>
          </div>
        </div>

        <!-- Stat Card Rejected -->
        <div class="col-md-6 col-lg-3">
          <div class="stat-card text-center">
            <div class="stat-icon" style="color: #ef4444; background: rgba(239,68,68,.1);">
              <i class="bi bi-x-circle"></i>
            </div>
            <h3 class="stat-title">Rejected</h3>
            <p class="stat-value">{{ $rejectedOrders ?? 0 }}</p>
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
</body>

</html>
