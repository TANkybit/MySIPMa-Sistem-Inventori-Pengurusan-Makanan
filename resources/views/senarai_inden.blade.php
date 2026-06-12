<!DOCTYPE html>
<html lang="ms">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Senarai Inden - MySIPMa</title>

  <link rel="icon" type="image/png" href="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/css/main2.css') }}" rel="stylesheet">
  
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
        left: 50%;
        position: absolute;
        transform: translateX(-50%);
      }
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
        background-color: var(--surface-soft) !important;
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
  </style>
</head>

<body>

  <header id="header" class="header d-flex align-items-center sticky-top" style="background: rgba(2,2,4,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ route('index') }}" class="logo-glow d-flex align-items-center me-auto me-xl-0">
        <img src="{{ asset('frontend/Nexa/assets/img/WORDINGMYSIPMA2.png') }}" style="height: 55px; width: auto;" alt="MySIPMa logo">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a></li>
          <li><a href="{{ route('user.senarai.inden') }}" class="{{ request()->routeIs('user.senarai.inden') ? 'active' : '' }}">Senarai Inden</a></li>
          @if(Auth::user()->hasPermission('pengesahan_inden'))
          <li><a href="{{ route('user.pengesahan.inden') }}" class="{{ request()->routeIs('user.pengesahan.inden') ? 'active' : '' }}">Pengesahan Inden</a></li>
          @endif
          @if(Auth::user()->hasPermission('borang_inden'))
          <li><a href="{{ route('borang.inden') }}" class="{{ request()->routeIs('borang.inden*') ? 'active' : '' }}">Borang Inden</a></li>
          @endif
          @if(Auth::user()->hasPermission('penerimaan_inden'))
          <li><a href="{{ route('borang.penerimaan') }}" class="{{ request()->routeIs('borang.penerimaan') ? 'active' : '' }}">Penerimaan</a></li>
          @endif
          </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-none d-xl-flex align-items-center gap-3">
        <!-- Notification Bell -->
        @if(Auth::user()->hasPermission('pengesahan_inden'))
        <a href="{{ route('user.pengesahan.inden') }}" class="position-relative text-white fs-5 me-3" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='white'">
          <i class="bi bi-bell-fill"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            {{ $pendingApprovals ?? 0 }}
            <span class="visually-hidden">Inden belum disah</span>
          </span>
        </a>
        @endif
        <a href="{{ route('profile') }}" class="text-white-50 text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='rgba(255,255,255,0.5)'"><i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name ?? 'Pengguna' }}</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-custom btn-logout btn-sm px-3 py-2"><i class="bi bi-box-arrow-right me-2"></i>Log Keluar</button>
        </form>
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
                  @forelse (($orders ?? collect()) as $order)
                    @php
                      $orderBadge = match ($order->order_status) {
                          'Completed' => 'bg-success',
                          'In Progress' => 'bg-info text-dark',
                          'Pending' => 'bg-warning text-dark',
                          default => 'bg-secondary',
                      };
                    @endphp
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td><a href="{{ route('borang.inden.show', $order->id) }}" class="text-success fw-semibold text-decoration-none">{{ $order->order_no }}</a></td>
                      <td>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') : '-' }}</td>
                      <td>{{ $order->institution_name ?? '-' }}</td>
                      <td>{{ $order->supplier_name ?? '-' }}</td>
                      <td>{{ $order->supplier_email ?? '-' }}</td>
                      <td>RM {{ number_format((float) $order->total_amount, 2) }}</td>
                      <td><span class="badge {{ $orderBadge }}">{{ $order->order_status ?? '-' }}</span></td>
                      <td>
                        @if($order->order_status === 'Completed')
                          <a href="{{ route('borang.penerimaan.cetak', $order->id) }}" target="_blank" class="btn btn-sm" style="background:var(--accent);color:#0f172a;border-radius:999px;padding:4px 12px;font-size:.8rem;font-weight:600;text-decoration:none;"><i class="bi bi-printer me-1"></i>Cetak Penerimaan</a>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="9" class="text-center text-white-50 py-4">Tiada rekod inden ditemui.</td>
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
    <p class="mb-0 text-white-50"><small>&copy; 2026 MySIPMa. Hak Cipta Terpelihara.</small></p>
  </footer>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/js/mobile-nav.js') }}"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  
  <script>
    $(document).ready(function() {
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
    });
  </script>
    <script src="{{ asset('js/session-timeout.js') }}"></script>
</body>
</html>
