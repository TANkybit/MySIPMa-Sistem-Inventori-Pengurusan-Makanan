<!DOCTYPE html>
<html lang="ms" data-bs-theme="light">

<head>
  <script>document.documentElement.setAttribute('data-bs-theme',localStorage.getItem('theme')||'light')</script>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Borang Inden - MySIPMa</title>
  <link rel="icon" type="image/png" href="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/css/main2.css') }}" rel="stylesheet">
  <link href="{{ asset('css/user-theme.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
  <style>
    :root { --bg:#020204; --surface:#11151f; --surface-soft:#161a26; --surface-strong:#0c1119; --border:#2c333f; --text:#e2e8f0; --muted:#94a3b8; --accent:#10b981; --accent-soft:rgba(16,185,129,.16); }
    body { background: radial-gradient(circle at top, rgba(255,255,255,.05) 0%, transparent 40%), linear-gradient(180deg,#020204 0%,#07090f 40%,#0b1018 100%); color: var(--text); font-family: "Roboto", sans-serif; }
    h1,h2,h3,h4 { font-family: "Montserrat", sans-serif; color: #fff; }
    .logo-glow { width: auto; height: auto; filter: brightness(150%); transition: all 0.3s ease; }
    .logo-glow:hover { filter: brightness(170%); transform: scale(1.02); }
    .page-shell { padding: 32px 0 56px; }
    .card-box { background: var(--surface); border:1px solid var(--border); border-radius:24px; box-shadow:0 18px 48px rgba(0,0,0,.55); }
    @media (min-width: 1200px) { .header .container > .logo-glow, .header .container > .d-xl-flex { position: relative; z-index: 2; } .header .navmenu { left: 50%; position: absolute; transform: translateX(-50%); } }
    .hero, .section-card { padding:28px; }
    .hero { margin-bottom:24px; }
    .hero-title { font-size: clamp(2rem,4vw,3rem); font-weight:800; line-height:1.05; margin:10px 0 14px; }
    .muted { color: var(--muted); line-height:1.7; }
    .chip { background: rgba(255,255,255,.08); border-radius:999px; color: var(--text); font-size:.82rem; font-weight:700; padding:8px 12px; white-space:nowrap; border:1px solid rgba(255,255,255,.08); }
    .section-head { align-items:flex-start; display:flex; justify-content:space-between; gap:12px; margin-bottom:18px; }
    .form-label { color:#cbd5e1; font-size:.92rem; font-weight:700; margin-bottom:8px; }
    .form-control,.form-select { background: #111827; border:1px solid rgba(255,255,255,.08); border-radius:14px; color: var(--text); min-height:48px; padding:12px 14px; }
    textarea.form-control { min-height:110px; }
    .form-control::placeholder, .form-select option { color: rgba(255,255,255,.35); opacity: 1; }
    .form-control:focus,.form-select:focus { border-color: rgba(16,185,129,.45); box-shadow:0 0 0 .2rem rgba(16,185,129,.16); background: #111827; color: var(--text); }
    .items-wrap { border:1px solid rgba(255,255,255,.08); border-radius:20px; overflow:hidden; }
    .items-toolbar { align-items:center; background: #111827; border-bottom:1px solid rgba(255,255,255,.08); display:flex; flex-wrap:wrap; gap:12px; justify-content:space-between; padding:18px 20px; }
    .item-card { border-bottom:1px solid rgba(255,255,255,.08); padding:20px; background: var(--surface-soft); }
    .item-card:last-child { border-bottom:0; }
    .item-index { align-items:center; background: var(--accent); border-radius:999px; color:#0f172a; display:inline-flex; font-size:.8rem; font-weight:700; height:34px; justify-content:center; width:34px; }
    .item-actions { align-items:center; display:flex; gap:10px; justify-content:space-between; margin-bottom:16px; }
    .btn-round { border-radius:999px; font-weight:700; padding:10px 16px; }
    .btn-add { background: var(--accent); border:0; color:#0f172a; }
    .btn-soft { background: rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); color: var(--text); }
    .btn-custom { background: var(--accent); color:#0f172a; border:0; border-radius:999px; padding:12px 24px; font-weight:700; text-decoration:none; transition:all .3s; }
    .btn-custom:hover { background:#0ea5e9; color:#fff; transform:scale(1.05); }
    .btn-logout { background:transparent; border:1px solid rgba(255,255,255,.2); color:#fff; }
    .btn-logout:hover { background:rgba(255,255,255,.1); border-color:#fff; }
    .totals-box { background: linear-gradient(180deg,#111827 0%,#0b1020 100%); border-radius:20px; color:#fff; padding:24px; }
    .totals-box p { color: rgba(255,255,255,.78); }
    .totals-row { align-items:center; display:flex; justify-content:space-between; margin-bottom:12px; }
    .totals-row:last-child { border-top:1px solid rgba(255,255,255,.12); margin-top:14px; padding-top:14px; }
    .action-row { align-items:center; display:flex; flex-wrap:wrap; gap:12px; justify-content:space-between; margin-top:24px; }
    .borang-menu { display:grid; gap:12px; grid-template-columns: repeat(4, minmax(0, 1fr)); margin-bottom:24px; }
    .borang-menu button { align-items:flex-start; background:var(--surface); border:1px solid var(--border); border-radius:18px; color:var(--text); display:flex; flex-direction:column; gap:6px; padding:16px; text-align:left; transition:all .2s ease; }
    .borang-menu button.active, .borang-menu button:hover { border-color:rgba(16,185,129,.55); box-shadow:0 16px 36px rgba(16,185,129,.12); transform:translateY(-2px); }
    .borang-menu button.active .menu-title { color:var(--accent); }
    .borang-menu .menu-step { color:var(--accent); font-size:.78rem; font-weight:800; text-transform:uppercase; }
    .borang-menu .menu-title { color:#fff; font-family:"Montserrat", sans-serif; font-weight:800; }
    .borang-page { display:none; }
    .borang-page.active { display:block; }
    .borang-step-actions { align-items:center; display:flex; flex-wrap:wrap; gap:12px; justify-content:space-between; margin-top:24px; }
    .word-helper { color: rgba(255,255,255,.55); display:flex; justify-content:flex-end; font-size:.82rem; margin-top:6px; }
    .word-helper.text-danger { color:#f87171 !important; }
    .date-format-hint { color:var(--muted); font-size:.8rem; margin-top:6px; }
    .item-table-toolbar { align-items:center; display:flex; flex-wrap:wrap; gap:12px; justify-content:space-between; margin-bottom:16px; }
    .item-table-toolbar .dataTables_length label, .item-table-toolbar .dataTables_filter label { color:var(--muted) !important; }
    .item-table-toolbar .dataTables_filter { margin-left:auto; }
    .dt-item-actions { display:flex; justify-content:flex-end; }
    table.dataTable > thead > tr > th { border-bottom:1px solid rgba(255,255,255,.12) !important; }
    table.dataTable > tbody > tr { background:transparent !important; }
    .table-dark-custom { color:var(--text) !important; border-color:var(--border) !important; }
    .table-dark-custom th { background:var(--surface-soft) !important; color:#fff !important; }
    .table-dark-custom td { background:transparent !important; border-bottom:1px solid rgba(255,255,255,.08) !important; color:#fff !important; vertical-align:middle; }
    .dataTables_wrapper .page-link { background:var(--surface-soft) !important; border-color:var(--border) !important; color:var(--text) !important; }
    .dataTables_wrapper .page-item.active .page-link { background:var(--accent) !important; border-color:var(--accent) !important; color:#0f172a !important; }
    .dataTables_wrapper .form-select-sm, .dataTables_wrapper .form-control-sm { background:#111827 !important; border:1px solid rgba(255,255,255,.08) !important; color:var(--text) !important; }
    .select2-container { width:100% !important; }
    .select2-container--default .select2-selection--single { background:#111827; border:1px solid rgba(255,255,255,.08); border-radius:14px; color:var(--text); min-height:48px; padding:9px 12px; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { color:var(--text); line-height:28px; padding-left:0; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height:46px; }
    .select2-dropdown { background:#111827; border:1px solid rgba(255,255,255,.12); color:var(--text); }
    .select2-search__field { background:#0b1020; border:1px solid rgba(255,255,255,.12) !important; color:var(--text); }
    .select2-results__option--highlighted { background:var(--accent) !important; color:#0f172a !important; }
    @media (max-width: 767.98px) { .hero,.section-card { padding:22px; } .section-head,.items-toolbar,.action-row { flex-direction:column; align-items:flex-start; } }
    @media (max-width: 991.98px) { .borang-menu { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 575.98px) { .borang-menu { grid-template-columns: 1fr; } }
    
    /* Disabled selects in read-only mode — keep dark theme */
    select:disabled, input:disabled, textarea:disabled {
      background: #111827 !important;
      color: var(--text) !important;
      opacity: 0.7;
      -webkit-text-fill-color: var(--text);
    }

    /* Sleek Validation Styles */
    .invalid-feedback { color: #f87171; font-size: 0.85rem; margin-top: 6px; font-weight: 500; display: none; }
    .is-invalid + .invalid-feedback, .is-invalid ~ .invalid-feedback { display: block; }
    .form-control.is-invalid, .form-select.is-invalid { border-color: #f87171 !important; box-shadow: 0 0 0 .2rem rgba(248,113,113,.16) !important; background-image: none !important; }
    .was-validated .form-control:invalid, .was-validated .form-select:invalid { border-color: #f87171 !important; box-shadow: 0 0 0 .2rem rgba(248,113,113,.16) !important; }
    .was-validated .form-control:invalid ~ .invalid-feedback, .was-validated .form-select:invalid ~ .invalid-feedback { display: block; }
    .was-validated .form-control:valid, .was-validated .form-select:valid { border-color: var(--accent) !important; box-shadow: 0 0 0 .2rem rgba(16,185,129,.1) !important; }
  </style>
</head>
<body>
  @php
    $inden = optional($indenHeader ?? null);
    $isReadOnly = $readOnly ?? false;
    $fieldState = $isReadOnly ? 'readonly' : '';
    $formatTarikh = function ($value) {
      if (!$value) return '';
      if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', (string) $value)) return $value;
      try {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
      } catch (\Throwable $e) {
        return $value;
      }
    };
  @endphp

  <header id="header" class="header d-flex align-items-center sticky-top" style="background: rgba(2,2,4,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05);">
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
          <li><a href="{{ route('borang.penerimaan') }}"
              class="{{ request()->routeIs('borang.penerimaan') ? 'active' : '' }}">Penerimaan</a></li>
          @endif
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
        <a href="{{ route('profile') }}" class="text-white-50 text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'"
          onmouseout="this.style.color=''"><i
            class="bi bi-person-circle me-2"></i>{{ Auth::user()->name ?? 'Pengguna' }}</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-custom btn-logout btn-sm px-3 py-2"><i
              class="bi bi-box-arrow-right me-2"></i>Log Keluar</button>
        </form>
      </div>
    </div>
  </header>
  <main class="main">
  <div class="container page-shell">
    <div class="card-box hero">
      <h1 class="hero-title">{{ $isReadOnly ? 'Lihat Borang Inden' : 'Borang Inden Digital' }}</h1>
      <p class="muted mb-0">{{ $isReadOnly ? 'Paparan ini adalah mod lihat sahaja. Data dipaparkan terus daripada rekod inden yang dipilih.' : 'Halaman ini memaparkan data borang inden berdasarkan rekod pangkalan data.' }}</p>
    </div>

    @if (session('success'))
      <div class="alert alert-success border-0 rounded-4 mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger border-0 rounded-4 mb-4">
        <h5 class="alert-heading fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Sila semak semula maklumat borang sebelum dihantar:</h5>
        <ul class="mb-0 ps-3">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Client-side Error Alert Container (hidden by default) -->
    <div id="clientErrorAlert" class="alert alert-danger border-0 rounded-4 mb-4 d-none">
      <h5 class="alert-heading fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Sila semak semula maklumat borang sebelum dihantar:</h5>
      <ul id="clientErrorList" class="mb-0 ps-3"></ul>
    </div>

    <form id="borangIndenForm" method="POST" action="{{ route('borang.inden.store') }}">
      @csrf
      <div class="borang-menu" role="tablist" aria-label="Navigasi Borang Inden">
        <button class="active" type="button" data-borang-target="maklumat" role="tab" aria-selected="true">
          <span class="menu-step">Bahagian 1</span>
          <span class="menu-title">Maklumat Pesanan</span>
        </button>
        <button type="button" data-borang-target="muster" role="tab" aria-selected="false">
          <span class="menu-step">Bahagian 2</span>
          <span class="menu-title">Ringkasan Muster</span>
        </button>
        <button type="button" data-borang-target="barang" role="tab" aria-selected="false">
          <span class="menu-step">Bahagian 3</span>
          <span class="menu-title">Senarai Barang</span>
        </button>
        <button type="button" data-borang-target="perakuan" role="tab" aria-selected="false">
          <span class="menu-step">Bahagian 4</span>
          <span class="menu-title">Perakuan Pembekal</span>
        </button>
      </div>

      <div class="borang-page active" data-borang-page="maklumat">
      <div class="card-box section-card mb-4">
        <div class="section-head">
          <div>
            <h2 class="h4 mb-1">Maklumat Pesanan</h2>
            <p class="muted mb-0">Maklumat kepala borang daripada PDF disusun semula kepada satu seksyen yang lebih jelas.</p>
          </div>
          <div class="chip">Langkah 1</div>
          <span class="small ms-3" id="draftStatus1" style="color:var(--muted);"></span>
          <span class="small d-none ms-1" id="draftSavedIndicator1" style="color:var(--accent);"><i class="bi bi-check-circle-fill me-1"></i>Draf disimpan</span>
        </div>
        <div class="row g-4">
          <div class="col-md-4">
            <label class="form-label">No. Pesanan <span class="text-danger">*</span></label>
            <input class="form-control" id="noPesanan" type="text" value="{{ old('no_pesanan', $inden->no_pesanan ?? '') }}" placeholder="Akan dijana automatik" readonly>
          </div>
          <div class="col-md-4">
            <label class="form-label">Pembekal <span class="text-danger">*</span></label>
            @if($isReadOnly)
              <input class="form-control" type="text" value="{{ $inden->nama_pembekal ?? '' }}" readonly>
              <input type="hidden" name="supplier_id" value="{{ $inden->supplier_id ?? '' }}">
            @else
            <select class="form-select @error('supplier_id') is-invalid @enderror" name="supplier_id" id="supplierSelect" required>
              <option value="">-- Pilih Pembekal --</option>
              @foreach($suppliers as $sup)
                <option value="{{ $sup->id }}" data-address="{{ $sup->address }}" data-postcode="{{ $sup->postcode }}" data-contact="{{ $sup->contact_person ?? $sup->company_name }}" {{ old('supplier_id', $inden->supplier_id ?? '') == $sup->id ? 'selected' : '' }}>{{ $sup->company_name }}</option>
              @endforeach
            </select>
            @endif
            @error('supplier_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">Tarikh Pesanan <span class="text-danger">*</span></label>
            <div class="d-flex align-items-center gap-2">
              <input class="form-control date-input flex-grow-1 @error('tarikh_pesanan') is-invalid @enderror" name="tarikh_pesanan" type="text" inputmode="numeric" value="{{ $formatTarikh(old('tarikh_pesanan', $inden->tarikh_pesanan ?? now()->format('d/m/Y'))) }}" placeholder="dd/mm/yyyy" required>
              <span id="tarikhDayName" class="badge bg-accent text-dark fs-6 px-3 py-2" style="background:#10b981; white-space:nowrap;">--</span>
            </div>
            <div class="date-format-hint">Format: dd/mm/yyyy</div>
            @error('tarikh_pesanan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">Masa <span class="text-danger">*</span></label>
            <input class="form-control @error('masa') is-invalid @enderror" name="masa" type="time" value="{{ old('masa', $inden->masa ?? '') }}" {{ $fieldState }} required>
            @error('masa')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">Sesi / Kod <span class="text-danger">*</span></label>
            {{-- TODO: Checkbox selection may be needed in future. Keep commented for reference.
            <div class="d-flex gap-3 flex-wrap mt-1">
              @php
                $selectedSessions = old('sesi_kod', $inden->sesi_kod ?? '');
                $selectedArr = is_array($selectedSessions) ? $selectedSessions : explode('/', $selectedSessions);
              @endphp
              @foreach($mealSessions as $code => $desc)
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="sesi_kod[]" value="{{ $code }}" id="sesi_{{ $code }}"
                    {{ in_array($code, $selectedArr) ? 'checked' : '' }}
                    {{ $isReadOnly ? 'disabled' : '' }}>
                  <label class="form-check-label" for="sesi_{{ $code }}">{{ $code }} - {{ $desc }}</label>
                </div>
              @endforeach
            </div>
            --}}
            <input class="form-control @error('sesi_kod') is-invalid @enderror" name="sesi_kod" type="text" value="{{ old('sesi_kod', $inden->sesi_kod ?? '') }}" placeholder="e.g. M1/M2/M3/M4" {{ $fieldState }} required>
            @error('sesi_kod')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Kepada (Institusi) <span class="text-danger">*</span></label>
            @php
              $selectedInst = $institutions->firstWhere('id', old('institution_id', $inden->institution_id ?? $userInstitutionId));
            @endphp
            <input class="form-control" type="text" value="{{ $selectedInst->name ?? 'N/A' }}" readonly>
            <input type="hidden" name="institution_id" value="{{ old('institution_id', $inden->institution_id ?? $userInstitutionId) }}" id="institutionIdHidden">
            <input type="hidden" id="institutionCode" value="{{ $selectedInst->code ?? '' }}">
            <input type="hidden" id="institutionLocation" value="{{ $selectedInst->location_code ?? '' }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">No. Kontrak <span class="text-danger">*</span></label>
            @if($isReadOnly)
              <input class="form-control" type="text" value="{{ $inden->no_kontrak ?? '' }}" readonly>
              <input type="hidden" name="contract_id" value="{{ $inden->contract_id ?? '' }}">
            @else
            <select class="form-select @error('contract_id') is-invalid @enderror" name="contract_id" id="contractSelect" required>
              <option value="">-- Pilih Kontrak --</option>
            </select>
            @endif
            @error('contract_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12">
            <label class="form-label">Alamat Pembekal <span class="text-danger">*</span></label>
            <textarea class="form-control @error('alamat_pembekal') is-invalid @enderror" name="alamat_pembekal" placeholder="Masukkan alamat pembekal" {{ $fieldState }} required>{{ old('alamat_pembekal', trim(($inden->alamat_pembekal ?? '') . ' ' . ($inden->poskod_pembekal ?? ''))) }}</textarea>
            @error('alamat_pembekal')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
      <div class="borang-step-actions">
        <span></span>
        <button class="btn btn-round btn-add" type="button" data-borang-next="muster">Seterusnya</button>
      </div>
      </div>

      <div class="borang-page" data-borang-page="muster">
      <div class="card-box section-card mb-4">
        <div class="section-head">
          <div>
            <h2 class="h4 mb-1">Ringkasan Muster</h2>
            <p class="muted mb-0">Masukkan mana-mana nilai untuk mendapatkan pengiraan secara automatik berdasarkan formula Muster Penuh − Parol = Muster Ditolak Parol.</p>
          </div>
          <div class="chip">Langkah 2</div>
          <span class="small ms-3" id="draftStatus2" style="color:var(--muted);"></span>
          <span class="small d-none ms-1" id="draftSavedIndicator2" style="color:var(--accent);"><i class="bi bi-check-circle-fill me-1"></i>Draf disimpan</span>
        </div>
        <div class="row g-4">
          <div class="col-md-3">
            <label class="form-label">Muster Penuh <span class="text-danger">*</span></label>
            <input class="form-control muster-input @error('muster_penuh') is-invalid @enderror" id="musterPenuh" name="muster_penuh" type="number" min="0" step="1" value="{{ old('muster_penuh', $inden->muster_penuh ?? 0) }}" {{ $fieldState }} required>
            @error('muster_penuh')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-3">
            <label class="form-label">Parol <span class="text-danger">*</span></label>
            <input class="form-control muster-input @error('parol') is-invalid @enderror" id="parol" name="parol" type="number" min="0" step="1" value="{{ old('parol', $inden->parol ?? 0) }}" {{ $fieldState }} required>
            @error('parol')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-3">
            <label class="form-label">Muster Ditolak Parol <span class="text-danger">*</span></label>
            <input class="form-control muster-input @error('muster_ditolak_parol') is-invalid @enderror" id="musterTolakParol" name="muster_ditolak_parol" type="number" min="0" step="1" value="{{ old('muster_ditolak_parol', $inden->muster_ditolak_parol ?? 0) }}" {{ $fieldState }} required>
            @error('muster_ditolak_parol')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-3">
            <label class="form-label">Muster Khas (Daging) <span class="text-danger">*</span></label>
            <input class="form-control muster-input @error('muster_khas_daging') is-invalid @enderror" id="musterKhas" name="muster_khas_daging" type="number" min="0" step="1" value="{{ old('muster_khas_daging', $inden->muster_khas_daging ?? 0) }}" {{ $fieldState }} required>
            @error('muster_khas_daging')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <input id="musterExclusion" type="hidden" value="0">
        </div>
        <div class="row g-3 mt-1 d-none">
          <div class="col-md-4"><div class="card-box p-3"><small class="text-muted d-block">Jumlah Asas</small><strong id="baseMusterTotal">0</strong></div></div>
          <div class="col-md-4"><div class="card-box p-3"><small class="text-muted d-block">Pelarasan Parol</small><strong id="parolAdjustment">0</strong></div></div>
          <div class="col-md-4"><div class="card-box p-3"><small class="text-muted d-block">Anggaran Bilangan Akhir</small><strong id="finalMusterTotal">0</strong></div></div>
        </div>
      </div>
      <div class="borang-step-actions">
        <button class="btn btn-round btn-soft" type="button" data-borang-prev="maklumat">Kembali</button>
        <button class="btn btn-round btn-add" type="button" data-borang-next="barang">Seterusnya</button>
      </div>
      </div>

      <div class="borang-page" data-borang-page="barang">
      <div class="card-box section-card mb-4">
        <div class="section-head">
          <div>
            <h2 class="h4 mb-1">Senarai Barang</h2>
            <p class="muted mb-0">Bahagian panjang dalam PDF dipermudahkan kepada item baris demi baris dengan kiraan automatik.</p>
          </div>
          <div class="chip">Langkah 3</div>
          <span class="small ms-3" id="draftStatus3" style="color:var(--muted);"></span>
          <span class="small d-none ms-1" id="draftSavedIndicator3" style="color:var(--accent);"><i class="bi bi-check-circle-fill me-1"></i>Draf disimpan</span>
        </div>
        <div class="items-wrap">
          <div class="items-toolbar">
            <div>
              <h3 class="h5 mb-1">Item Pesanan</h3>
              <p class="muted mb-0">Contoh barang daripada PDF: ikan basah, daging lembu, kobis, bawang, halia, kacang merah dan ubi kentang.</p>
            </div>
            @unless ($isReadOnly)
            <button class="btn btn-round btn-add" type="button" id="tambahItemBtn"><i class="bi bi-plus-lg me-1"></i>Tambah Item</button>
            @endunless
          </div>
          <div class="p-3">
            <table id="itemDataTable" class="table table-dark-custom w-100">
              <thead>
                <tr>
                  <th>Bil</th>
                  <th>Perihal Barang</th>
                  <th>Kuantiti Pesanan</th>
                  <th>Unit</th>
                  <th>Harga Seunit</th>
                  <th>Jumlah Harga</th>
                  <th>Tindakan</th>
                </tr>
              </thead>
              <tbody id="itemList"></tbody>
            </table>
          </div>
        </div>
        <div class="totals-box mt-4">
          <h2 class="h4 mb-3">Ringkasan Automatik</h2>
          <p class="mb-4" style="color: rgba(255,255,255,.78);">Jumlah item, kuantiti dan harga dikira automatik untuk kurangkan pengiraan manual.</p>
          <div class="totals-row"><span>Jumlah Item</span><strong id="summaryItemCount">0</strong></div>
          <div class="totals-row"><span>Jumlah Kuantiti Pesanan</span><strong id="summaryOrderQty">0</strong></div>
          <div class="totals-row d-none"><span>Jumlah Kuantiti Terima</span><strong id="summaryReceivedQty">0</strong></div>
          <div class="totals-row"><span>Jumlah Harga</span><strong id="summaryGrandTotal">RM 0.00</strong></div>
        </div>
      </div>
      <div class="borang-step-actions">
        <button class="btn btn-round btn-soft" type="button" data-borang-prev="muster">Kembali</button>
        <button class="btn btn-round btn-add" type="button" data-borang-next="perakuan">Seterusnya</button>
      </div>
      </div>

      <div class="borang-page" data-borang-page="perakuan">
      <div class="row g-4">
        <div class="col-12">
          <div class="card-box section-card h-100">
            <div class="section-head">
              <div>
                <h2 class="h4 mb-1">Perakuan Pembekal</h2>
                <p class="muted mb-0">Nama, jawatan dan tarikh untuk pembekal, saksi dan penerima diasingkan dengan jelas.</p>
              </div>
              <div class="chip">Langkah 4</div>
            </div>
            <div class="row g-4">
              <div class="col-md-6"><label class="form-label">Disediakan Oleh</label><input class="form-control" type="text" value="{{ old('disediakan_oleh', $inden->disediakan_oleh ?? Auth::user()->name ?? '') }}" placeholder="Nama pegawai yang diberi kuasa memesan" readonly></div>
              <div class="col-md-6"><label class="form-label">Jawatan / Cop</label><input class="form-control" type="text" value="{{ old('jawatan_cop', $inden->jawatan_cop ?? ($userPositionName ? $userPositionName . ' Gred ' . $userGrade : '')) }}" readonly></div>
              <div class="col-md-6">
                <label class="form-label">Nama Wakil Pembekal <span class="text-danger">*</span></label>
                <input class="form-control" name="wakil_pembekal" type="text" value="{{ old('wakil_pembekal', $inden->wakil_pembekal ?? $inden->nama_pembekal ?? '') }}" placeholder="Akan diisi automatik" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Tarikh Pembekal</label>
                <input class="form-control date-input @error('tarikh_pembekal') is-invalid @enderror" name="tarikh_pembekal" type="text" inputmode="numeric" pattern="^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/[0-9]{4}$" value="{{ $formatTarikh(old('tarikh_pembekal', $inden->tarikh_pembekal ?? now()->format('d/m/Y'))) }}" placeholder="dd/mm/yyyy" {{ $fieldState }} required>
                <div class="date-format-hint">Format: dd/mm/yyyy</div>
                @error('tarikh_pembekal')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6 d-none"><label class="form-label">Nama Saksi</label><input class="form-control" type="text" placeholder="Nama saksi"></div>
              <div class="col-md-6 d-none"><label class="form-label">Nama Penerima</label><input class="form-control" type="text" placeholder="Nama penerima"></div>
              <div class="col-md-6 d-none"><label class="form-label">Jawatan / Cop Saksi</label><input class="form-control" type="text" placeholder="Jawatan atau cop saksi"></div>
              <div class="col-md-6 d-none"><label class="form-label">Jawatan / Cop Penerima</label><input class="form-control" type="text" placeholder="Jawatan atau cop penerima"></div>
              <div class="col-md-6 d-none"><label class="form-label">Tarikh Saksi</label><input class="form-control" type="text" inputmode="numeric" placeholder="dd/mm/yyyy"></div>
              <div class="col-md-6 d-none"><label class="form-label">Tarikh Penerima</label><input class="form-control" type="text" inputmode="numeric" placeholder="dd/mm/yyyy"></div>
              <div class="col-12">
                <label class="form-label">Ulasan / Catatan Umum</label>
                <textarea class="form-control ulasan-field @error('catatan_inden') is-invalid @enderror" name="catatan_inden" placeholder="Masukkan catatan tambahan jika perlu" data-max-words="250" {{ $fieldState }}>{{ old('catatan_inden', $inden->catatan_inden ?? '') }}</textarea>
                <div class="word-helper"><span class="word-count">0</span>/250 patah perkataan</div>
                @error('catatan_inden')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="action-row">
        <div class="d-flex align-items-center gap-3">
          <a href="{{ route('user.dashboard') }}" class="btn btn-round btn-soft">Kembali ke Dashboard</a>
          <span id="draftStatus" class="small" style="color:var(--muted);"></span>
          <span id="draftSavedIndicator" class="small d-none" style="color:var(--accent);"><i class="bi bi-check-circle-fill me-1"></i>Draf disimpan</span>
        </div>
        <div class="d-flex flex-wrap gap-2 align-items-center">
          @if($inden->inden_id)
          <button class="btn btn-round btn-soft" type="button" onclick="window.open('{{ route('borang.inden.cetak', ['order' => $inden->inden_id]) }}', '_blank')">Cetak Ringkasan</button>
          @endif
          @unless ($isReadOnly)
            <button class="btn btn-round btn-add" type="submit">Hantar</button>
          @endunless
        </div>
      </div>
      </div>
    </form>
  </div>

  {{-- Item Modal (Add / Edit) --}}
  <div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background:#11151f; border:1px solid rgba(255,255,255,.08); color:#e2e8f0;">
        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold" id="itemModalTitle">Tambah Item</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editItemIndex" value="-1">
          <div class="mb-3">
            <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
            <input class="form-control" id="itemModalName" type="text" placeholder="Nama barang">
          </div>
          <div class="row g-3">
            <div class="col-6">
              <label class="form-label">Kuantiti <span class="text-danger">*</span></label>
              <input class="form-control" id="itemModalQty" type="number" min="0" step="0.01" value="0">
            </div>
            <div class="col-6">
              <label class="form-label">Unit <span class="text-danger">*</span></label>
              <input class="form-control" id="itemModalUnit" type="text" placeholder="e.g. KG">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga Seunit (RM)</label>
            <input class="form-control" id="itemModalPrice" type="number" min="0" step="0.01" value="0">
          </div>
        </div>
        <div class="modal-footer border-0">
          <button class="btn btn-round btn-soft" type="button" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-round btn-add" type="button" id="itemModalSave">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Delete Confirmation Modal --}}
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content" style="background:#11151f; border:1px solid rgba(255,255,255,.08); color:#e2e8f0;">
        <div class="modal-body text-center py-4">
          <i class="bi bi-exclamation-triangle-fill text-danger fs-1 mb-3 d-block"></i>
          <h5 class="fw-bold mb-2">Pengesahan Padam</h5>
          <p class="mb-0" style="color:var(--muted);">Anda pasti mahu memadam item ini?</p>
        </div>
        <div class="modal-footer border-0 justify-content-center">
          <button class="btn btn-round btn-soft" type="button" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-round" type="button" id="deleteConfirmBtn" style="background:#dc3545; color:#fff;">Padam</button>
        </div>
      </div>
    </div>
  </div>

  </main>

<template id="itemTemplate">
  <tr class="item-card">
    <td data-order="0"><span class="item-index"></span></td>
    <td data-order=""><input class="form-control item-name" type="text" readonly>
      <input class="item-contract-id" type="hidden" name="items[0][contract_item_id]">
      <input type="hidden" class="item-name-hidden" name="items[0][name]">
    </td>
    <td data-order="0"><input class="form-control item-order-qty item-calc" type="number" min="0" step="0.01" value="0" required></td>
    <td data-order=""><input class="form-control item-unit" type="text" readonly>
      <input type="hidden" class="item-unit-hidden" name="items[0][unit]">
    </td>
    <td data-order="0"><input class="form-control item-unit-price" type="text" readonly>
      <input type="hidden" class="item-unit-price-hidden" name="items[0][unitPrice]">
    </td>
    <td data-order="0"><input class="form-control item-total" type="text" value="RM 0.00" readonly></td>
    <td data-order=""><div class="d-flex flex-wrap gap-1">
        <button class="btn btn-sm btn-outline-info edit-item" type="button" title="Edit"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-outline-danger remove-item" type="button" title="Padam"><i class="bi bi-trash"></i></button>
      </div></td>
  </tr>
</template>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/js/mobile-nav.js') }}"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ms.js"></script>
  <script>
    (function () {
      const itemList = document.getElementById('itemList');
      const itemTemplate = document.getElementById('itemTemplate');
      const musterInputs = document.querySelectorAll('.muster-input');
      const form = document.getElementById('borangIndenForm');
      const databaseItems = @json(old('items', $indenItems ?? []));
      const isReadOnly = @json($isReadOnly);
      let itemDataTable = null;
      let isRestoringDraft = false;
      let hasUnsavedChanges = false;
      let autoSaveTimer = null;
      const AUTO_SAVE_MS = 60000;
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      const dayNames = ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'];
      function parseDateValue(value) {
        if (!value) return null;
        var d = new Date(value + 'T00:00:00');
        return isNaN(d.getTime()) ? null : d;
      }
      function updateDayName(dateInput) {
        var parsed = dateInput.type === 'date' ? parseDateValue(dateInput.value) : parseDisplayDate(dateInput.value);
        var daySpan = document.getElementById('tarikhDayName');
        if (daySpan && parsed) {
          daySpan.textContent = dayNames[parsed.getDay()] || '--';
        }
      }

      if (isReadOnly) {
        document.querySelectorAll('input, textarea').forEach((input) => {
          if (input.name !== 'tarikh_pesanan') input.setAttribute('readonly', 'readonly');
        });
        document.querySelectorAll('select').forEach((select) => select.setAttribute('disabled', 'disabled'));
      } else {
        const supplierSelect = document.getElementById('supplierSelect');
        const addressField = document.querySelector('textarea[name="alamat_pembekal"]');
        const wakilField = document.querySelector('input[name="wakil_pembekal"]');
        if (supplierSelect && addressField) {
          function fillSupplierAddress() {
            const selected = supplierSelect.options[supplierSelect.selectedIndex];
            if (selected && selected.value) {
              const addr = (selected.dataset.address || '').trim();
              const postcode = (selected.dataset.postcode || '').trim();
              addressField.value = addr + (addr && postcode ? ' ' : '') + postcode;
              if (wakilField) wakilField.value = selected.dataset.contact || '';
            }
          }
          supplierSelect.addEventListener('change', fillSupplierAddress);
        }

        // Auto-generate No. Pesanan & load contracts
        const instIdInput = document.getElementById('institutionIdHidden');
        const contractSelect = document.getElementById('contractSelect');
        const noPesananInput = document.getElementById('noPesanan');

        function getInstId() { return instIdInput?.value || ''; }

        function generateOrderNo() {
          const instId = getInstId();
          if (!instId) {
            noPesananInput.value = '';
            return;
          }
          fetch('{{ route("borang.inden.generate") }}?institution_id=' + instId)
            .then(r => r.json())
            .then(d => { if (d.success) noPesananInput.value = d.order_no; })
            .catch(() => {});
        }

        function loadContracts() {
          const instId = getInstId();
          const supId = document.getElementById('supplierSelect')?.value || '';
          if (!contractSelect) return;
          contractSelect.innerHTML = '<option value="">-- Pilih Kontrak --</option>';
          if (!instId || !supId) return;
          fetch('{{ route("borang.inden.contracts") }}?institution_id=' + instId + '&supplier_id=' + supId)
            .then(r => r.json())
            .then(contracts => {
              contracts.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.textContent = c.contract_no;
                opt.dataset.supplierId = c.supplier_id;
                contractSelect.appendChild(opt);
              });
              @if(!empty($inden) && $inden->contract_id)
                contractSelect.value = '{{ $inden->contract_id }}';
                contractSelect.dispatchEvent(new Event('change'));
              @else
                // Auto-select first (only) contract for the chosen supplier
                if (contracts.length > 0) {
                  contractSelect.value = contracts[0].id;
                  contractSelect.dispatchEvent(new Event('change'));
                }
              @endif
            })
            .catch(() => {});
        }

        function loadContractItems(contractId) {
          if (!contractId) return;
          fetch('{{ url("borang-inden/contract-items") }}/' + contractId)
            .then(r => r.json())
            .then(items => {
              if (itemDataTable) {
                itemDataTable.clear().draw();
              } else {
                itemList.innerHTML = '';
              }
              items.forEach(ci => {
                addItem({
                  contract_item_id: ci.id,
                  name: ci.item_name,
                  unit: ci.uom_code || 'Unit',
                  orderQty: 0,
                  unitPrice: ci.unit_price,
                });
              });
            })
            .catch(() => {});
        }

        // Supplier change → reload contracts
        if (supplierSelect) {
          supplierSelect.addEventListener('change', function() {
            loadContracts();
            if (typeof fillSupplierAddress === 'function') fillSupplierAddress();
            if (!isRestoringDraft) {
              if (itemDataTable) {
                itemDataTable.clear().draw();
              } else {
                itemList.innerHTML = '';
              }
            }
            if (!isRestoringDraft) updateSummary();
          });
        }

        if (contractSelect) {
          contractSelect.addEventListener('change', function() {
            if (isRestoringDraft) return;
            loadContractItems(this.value);
          });
        }
        if (!noPesananInput.value) generateOrderNo();
        @if(!($savedDraft ?? null))
        loadContracts();
        @endif
        // Fill supplier address on load if pre-selected (edit mode)
        if (typeof fillSupplierAddress === 'function') fillSupplierAddress();

        const dateInputs = document.querySelectorAll('.date-input');
        const timeInputs = document.querySelectorAll('input[type="time"]');
        const now = new Date();
        const localDate = formatDateForDisplay(now);

        var todayStr = now.toISOString().slice(0, 10);

        dateInputs.forEach(function (input) {
          input.addEventListener('input', function () {
            this.value = this.value.replace(/[^\d/]/g, '').slice(0, 10);
            this.setCustomValidity('');
            updateTimeMinimum(this.value, localDate, now, timeInputs);
            updateDayName(this);
          });

          input.addEventListener('change', function() {
            updateTimeMinimum(this.value, localDate, now, timeInputs);
            updateDayName(this);
          });
        });

        dateInputs.forEach(function (input) {
          if (!input.value) input.value = localDate;
          input.dispatchEvent(new Event('change'));
          updateDayName(input);
        });

        const localTime = now.toTimeString().substring(0, 5);
        timeInputs.forEach(input => {
          if (!input.value) input.value = localTime;
        });

        // ── Flatpickr date pickers ──
        if (typeof flatpickr !== 'undefined') {
          document.querySelectorAll('.date-input:not([readonly])').forEach(function (el) {
            flatpickr(el, {
              dateFormat: 'd/m/Y',
              allowInput: true,
              locale: 'ms',
              onChange: function (selectedDates, dateStr) {
                hasUnsavedChanges = true;
                triggerAutoSave();
                updateTimeMinimum(dateStr, localDate, now, timeInputs);
                updateDayName(el);
              },
            });
          });
        }
      }

      function numberValue(input) { return Number.parseFloat(input.value) || 0; }
      function formatNumber(value) { return new Intl.NumberFormat('en-MY', { minimumFractionDigits: value % 1 === 0 ? 0 : 2, maximumFractionDigits: 2 }).format(value || 0); }
      function formatCurrency(value) { return 'RM ' + new Intl.NumberFormat('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value || 0); }
      function formatDateForDisplay(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        return `${day}/${month}/${date.getFullYear()}`;
      }
      function parseDisplayDate(value) {
        const match = /^(\d{2})\/(\d{2})\/(\d{4})$/.exec(value || '');
        if (!match) return null;
        const parsed = new Date(Number(match[3]), Number(match[2]) - 1, Number(match[1]));
        if (parsed.getFullYear() !== Number(match[3]) || parsed.getMonth() !== Number(match[2]) - 1 || parsed.getDate() !== Number(match[1])) return null;
        parsed.setHours(0, 0, 0, 0);
        return parsed;
      }
      function updateTimeMinimum(dateValue, localDate, now, timeInputs) {
        var todayStr = now.toISOString().slice(0, 10);
        var isToday = dateValue === localDate || dateValue === todayStr;
        if (isToday) {
          const localTime = now.toTimeString().substring(0, 5);
          timeInputs.forEach(t => t.setAttribute('min', localTime));
        } else {
          timeInputs.forEach(t => t.removeAttribute('min'));
        }
      }
      function countWords(value) {
        return (value.trim().match(/\S+/g) || []).length;
      }
      function updateWordCounter(textarea) {
        const maxWords = Number(textarea.dataset.maxWords || 250);
        const count = countWords(textarea.value);
        const helper = textarea.parentElement.querySelector('.word-helper');
        const counter = textarea.parentElement.querySelector('.word-count');
        if (counter) counter.textContent = count;
        if (helper) helper.classList.toggle('text-danger', count > maxWords);
        textarea.setCustomValidity(count > maxWords ? `Ulasan tidak boleh melebihi ${maxWords} patah perkataan.` : '');
      }
      function wireUlasanCounter(scope = document) {
        scope.querySelectorAll('.ulasan-field').forEach((textarea) => {
          updateWordCounter(textarea);
          textarea.addEventListener('input', () => updateWordCounter(textarea));
        });
      }
      function showBorangPage(pageName) {
        document.querySelectorAll('[data-borang-page]').forEach((page) => {
          page.classList.toggle('active', page.dataset.borangPage === pageName);
        });
        document.querySelectorAll('[data-borang-target]').forEach((button) => {
          const isActive = button.dataset.borangTarget === pageName;
          button.classList.toggle('active', isActive);
          button.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });
      }
      function validateVisiblePage(pageName) {
        const page = document.querySelector(`[data-borang-page="${pageName}"]`);
        if (!page) return true;
        for (const field of page.querySelectorAll('input, textarea, select')) {
          if (!field.checkValidity()) {
            field.reportValidity();
            return false;
          }
        }
        return true;
      }

      function getItemRows() {
        if (itemDataTable) {
          return Array.from(itemDataTable.rows().nodes());
        }

        return Array.from(itemList.querySelectorAll('.item-card'));
      }

      function updateItemIndices() {
        getItemRows().forEach((card, index) => {
          card.querySelector('.item-index').textContent = index + 1;
          card.querySelector('.item-contract-id').name = `items[${index}][contract_item_id]`;
          card.querySelector('.item-name-hidden').name = `items[${index}][name]`;
          card.querySelector('.item-unit-hidden').name = `items[${index}][unit]`;
          card.querySelector('.item-order-qty').name = `items[${index}][orderQty]`;
          card.querySelector('.item-unit-price-hidden').name = `items[${index}][unitPrice]`;
        });
      }

      let isUpdatingMuster = false;

      function updateMusterSummary(event) {
        if (isUpdatingMuster) return;
        isUpdatingMuster = true;

        try {
          const changed = event?.target?.id || '';
          const penuhEl = document.getElementById('musterPenuh');
          const parolEl = document.getElementById('parol');
          const ditolakEl = document.getElementById('musterTolakParol');
          const khasEl = document.getElementById('musterKhas');
          const exclusionEl = document.getElementById('musterExclusion');

          let penuh = numberValue(penuhEl);
          let parol = numberValue(parolEl);
          let ditolak = numberValue(ditolakEl);
          let khas = numberValue(khasEl);
          let exclusion = numberValue(exclusionEl);

          if (changed === 'musterPenuh' || changed === 'parol') {
            if (penuh > 0 && parol > 0) {
              ditolak = Math.max(penuh - parol, 0);
              ditolakEl.value = ditolak;
            }
          } else if (changed === 'musterTolakParol') {
            if (penuh > 0 && ditolak > 0) {
              parolEl.value = Math.max(penuh - ditolak, 0);
            } else if (parol > 0 && ditolak > 0) {
              penuhEl.value = parol + ditolak;
            }
          }

          if (changed === 'musterKhas' && khas > 0) {
            ditolak = numberValue(ditolakEl);
            exclusion = ditolak > 0 ? Math.max(ditolak - khas, 0) : 0;
            exclusionEl.value = exclusion;
          }

          penuh = numberValue(penuhEl);
          parol = numberValue(parolEl);
          ditolak = numberValue(ditolakEl);
          khas = numberValue(khasEl);
          exclusion = numberValue(exclusionEl);

          if (ditolak > 0 && exclusion > 0 && changed !== 'musterKhas') {
            khas = Math.max(ditolak - exclusion, 0);
            khasEl.value = khas;
          }
        } finally {
          isUpdatingMuster = false;
        }
      }

      function updateSummary() {
        if (!isRestoringDraft) {
          hasUnsavedChanges = true;
          if (typeof triggerAutoSave === 'function') triggerAutoSave();
        }
        const cards = getItemRows();
        let orderQtyTotal = 0, grandTotal = 0;
        cards.forEach((card) => {
          const orderQty = numberValue(card.querySelector('.item-order-qty'));
          const unitPrice = numberValue(card.querySelector('.item-unit-price-hidden'));
          const lineTotal = orderQty * unitPrice;
          orderQtyTotal += orderQty;
          grandTotal += lineTotal;
          card.querySelector('.item-total').value = formatCurrency(lineTotal);
          var tdTotal = card.cells[5];
          if (tdTotal) tdTotal.setAttribute('data-order', lineTotal);
        });
        document.getElementById('summaryItemCount').textContent = cards.length;
        document.getElementById('summaryOrderQty').textContent = formatNumber(orderQtyTotal);
        document.getElementById('summaryGrandTotal').textContent = formatCurrency(grandTotal);
      }

      function initItemDataTable() {
        if (!window.jQuery || !$.fn.DataTable) return;
        if ($.fn.DataTable.isDataTable('#itemDataTable')) {
          itemDataTable = $('#itemDataTable').DataTable();
          return;
        }

        itemDataTable = $('#itemDataTable').DataTable({
          pagingType: 'full_numbers',
          pageLength: 5,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'Semua']],
          ordering: true,
          language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ms.json',
            emptyTable: 'Tiada item pesanan.',
            lengthMenu: 'Papar _MENU_ rekod',
            search: 'Cari:',
            paginate: {
              first: "<i class='bi bi-chevron-double-left'></i>",
              previous: "<i class='bi bi-chevron-left'></i>",
              next: "<i class='bi bi-chevron-right'></i>",
              last: "<i class='bi bi-chevron-double-right'></i>"
            }
          },
          dom: '<"item-table-toolbar"<"dt-length-wrap"l><"dt-filter-wrap"f><"dt-item-actions">>' +
            '<"row"<"col-12"tr>>' +
            '<"row align-items-center mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
          initComplete: function () {
              $('.dt-item-actions').html('');
          }
        });
      }

      let deleteTargetRow = null;
      let editTargetRow = null;

      function wireItemCard(card) {
        card.querySelectorAll('.item-calc').forEach((input) => input.addEventListener('input', updateSummary));

        if (isReadOnly) {
          card.querySelectorAll('.edit-item, .remove-item').forEach((btn) => btn.classList.add('d-none'));
          card.querySelectorAll('input').forEach((input) => input.setAttribute('readonly', 'readonly'));
          return;
        }

        card.querySelector('.edit-item').addEventListener('click', function () {
          editTargetRow = card;
          const name = card.querySelector('.item-name').value;
          const qty = card.querySelector('.item-order-qty').value;
          const unit = card.querySelector('.item-unit').value;
          const price = card.querySelector('.item-unit-price-hidden').value;
          document.getElementById('itemModalTitle').textContent = 'Edit Item';
          document.getElementById('editItemIndex').value = Array.from(getItemRows()).indexOf(card);
          document.getElementById('itemModalName').value = name;
          document.getElementById('itemModalQty').value = qty;
          document.getElementById('itemModalUnit').value = unit;
          document.getElementById('itemModalPrice').value = price;
          // Lock name/unit for contract items
          const isContractItem = card.querySelector('.item-contract-id').value !== '0' && !!card.querySelector('.item-contract-id').value;
          document.getElementById('itemModalName').readOnly = isContractItem;
          document.getElementById('itemModalUnit').readOnly = isContractItem;
          new bootstrap.Modal(document.getElementById('itemModal')).show();
        });

        card.querySelector('.remove-item').addEventListener('click', function () {
          deleteTargetRow = card;
          new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
      }

      function addItem(defaults = {}) {
        const card = itemTemplate.content.firstElementChild.cloneNode(true);
        card.querySelector('.item-contract-id').value = defaults.contract_item_id ?? '';
        card.querySelector('.item-name').value = defaults.name || '';
        card.querySelector('.item-name-hidden').value = defaults.name || '';
        card.querySelector('.item-unit').value = defaults.unit || 'Unit';
        card.querySelector('.item-unit-hidden').value = defaults.unit || 'Unit';
        card.querySelector('.item-order-qty').value = defaults.orderQty ?? 0;
        card.querySelector('.item-unit-price').value = formatCurrency(defaults.unitPrice ?? 0);
        card.querySelector('.item-unit-price-hidden').value = defaults.unitPrice ?? 0;
        // Set data-order attributes for sorting
        var cells = card.querySelectorAll('td');
        if (cells.length >= 5) {
          cells[1].setAttribute('data-order', defaults.name || '');
          cells[2].setAttribute('data-order', defaults.orderQty ?? 0);
          cells[3].setAttribute('data-order', defaults.unit || '');
          cells[4].setAttribute('data-order', defaults.unitPrice ?? 0);
        }
        if (itemDataTable) {
          itemDataTable.row.add(card).draw(false);
        } else {
          itemList.appendChild(card);
        }
        wireItemCard(card);
        updateItemIndices();
        updateSummary();
      }

      musterInputs.forEach((input) => input.addEventListener('input', (e) => updateMusterSummary(e)));
      wireUlasanCounter();
      initItemDataTable();

      // Tambah Item button
      const tambahBtn = document.getElementById('tambahItemBtn');
      if (tambahBtn) {
        tambahBtn.addEventListener('click', function () {
          editTargetRow = null;
          document.getElementById('itemModalTitle').textContent = 'Tambah Item';
          document.getElementById('editItemIndex').value = -1;
          document.getElementById('itemModalName').value = '';
          document.getElementById('itemModalName').readOnly = false;
          document.getElementById('itemModalQty').value = 0;
          document.getElementById('itemModalUnit').value = '';
          document.getElementById('itemModalUnit').readOnly = false;
          document.getElementById('itemModalPrice').value = 0;
          new bootstrap.Modal(document.getElementById('itemModal')).show();
        });
      }

      // Item Modal Save
      document.getElementById('itemModalSave').addEventListener('click', function () {
        const name = document.getElementById('itemModalName').value.trim();
        const qty = parseFloat(document.getElementById('itemModalQty').value) || 0;
        const unit = document.getElementById('itemModalUnit').value.trim();
        const price = parseFloat(document.getElementById('itemModalPrice').value) || 0;
        if (!name) { alert('Sila isi nama barang.'); return; }
        if (!unit) { alert('Sila isi unit.'); return; }
        const editIdx = parseInt(document.getElementById('editItemIndex').value);

        if (editIdx >= 0) {
          // Edit existing row
          const rows = getItemRows();
          const card = rows[editIdx];
          card.querySelector('.item-name').value = name;
          card.querySelector('.item-name-hidden').value = name;
          card.querySelector('.item-order-qty').value = qty;
          card.querySelector('.item-unit').value = unit;
          card.querySelector('.item-unit-hidden').value = unit;
          card.querySelector('.item-unit-price').value = formatCurrency(price);
          card.querySelector('.item-unit-price-hidden').value = price;
          updateSummary();
        } else {
          // Add new custom item (contract_item_id = 0 means custom)
          addItem({ contract_item_id: 0, name: name, unit: unit, orderQty: qty, unitPrice: price });
        }
        bootstrap.Modal.getInstance(document.getElementById('itemModal')).hide();
      });

      // Delete confirmation
      document.getElementById('deleteConfirmBtn').addEventListener('click', function () {
        if (deleteTargetRow) {
          if (itemDataTable) {
            itemDataTable.row(deleteTargetRow).remove().draw(false);
          } else {
            deleteTargetRow.remove();
          }
          deleteTargetRow = null;
          updateItemIndices();
          updateSummary();
        }
        bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
      });

      document.querySelectorAll('[data-borang-target]').forEach((button) => {
        button.addEventListener('click', () => showBorangPage(button.dataset.borangTarget));
      });

      document.querySelectorAll('[data-borang-next], [data-borang-prev]').forEach((button) => {
        button.addEventListener('click', () => {
          const currentPage = button.closest('[data-borang-page]')?.dataset.borangPage;
          const targetPage = button.dataset.borangNext || button.dataset.borangPrev;
          if (button.dataset.borangNext && !validateVisiblePage(currentPage)) return;
          showBorangPage(targetPage);
          window.scrollTo({ top: document.querySelector('.borang-menu').offsetTop - 90, behavior: 'smooth' });
        });
      });

      if (form) {
        form.addEventListener('invalid', function (event) {
          const page = event.target.closest('[data-borang-page]');
          if (page) showBorangPage(page.dataset.borangPage);
        }, true);
      }

      // Client-side Validation Handler
      if (form && !isReadOnly) {
        // Real-time input validation to remove is-invalid class as user types/interacts
        form.querySelectorAll('input, textarea, select').forEach(input => {
          input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
              this.classList.remove('is-invalid');
            }
          });
          input.addEventListener('change', function() {
            if (this.value.trim() !== '') {
              this.classList.remove('is-invalid');
            }
          });
        });

        // Sanitize leading zeros on number inputs when user finishes typing (blur)
        form.addEventListener('blur', function(event) {
          if (event.target && event.target.matches('input[type="number"], .muster-input, .item-calc')) {
            const input = event.target;
            let val = input.value.trim();
            if (val !== '') {
              const parsed = parseFloat(val);
              if (!isNaN(parsed)) {
                input.value = parsed;
                // Trigger input event to update dynamic calculations and summaries
                input.dispatchEvent(new Event('input', { bubbles: true }));
              }
            }
          }
        }, true);

        form.addEventListener('submit', function (event) {
          if (itemDataTable) {
            itemDataTable.page.len(-1).draw();
          }
          updateItemIndices();

          // Ensure every item has a contract_item_id value (custom items use 0)
          getItemRows().forEach(function (card) {
            var cid = card.querySelector('.item-contract-id');
            if (cid && (cid.value === '' || cid.value === undefined || cid.value === null)) {
              cid.value = '0';
            }
          });

          const clientErrorAlert = document.getElementById('clientErrorAlert');
          const clientErrorList = document.getElementById('clientErrorList');
          clientErrorList.innerHTML = '';
          clientErrorAlert.classList.add('d-none');
          
          let isValid = true;
          const errors = [];
          
          // 1. Check all standard required inputs in step 1 & step 4
          const requiredInputs = form.querySelectorAll('input[required]:not(.item-calc):not(.item-name):not(.item-unit), textarea[required]');
          requiredInputs.forEach(input => {
            const labelText = input.previousElementSibling ? input.previousElementSibling.textContent.replace(' *', '').trim() : input.name;
            if (!input.value.trim()) {
              input.classList.add('is-invalid');
              isValid = false;
              errors.push(`${labelText} wajib diisi.`);
            } else {
              input.classList.remove('is-invalid');
            }
          });

          form.querySelectorAll('.date-input').forEach(input => {
            const labelText = input.previousElementSibling ? input.previousElementSibling.textContent.replace(' *', '').trim() : input.name;
            let parsedDate = null;
            if (input.type === 'date') {
              const val = input.value.trim();
              if (val) parsedDate = new Date(val + 'T00:00:00');
            } else {
              parsedDate = parseDisplayDate(input.value.trim());
            }
            input.setCustomValidity('');
            if (!parsedDate || isNaN(parsedDate.getTime())) {
              input.classList.add('is-invalid');
              input.setCustomValidity('Sila masukkan tarikh yang sah.');
              isValid = false;
              errors.push(`${labelText} mesti diisi dengan tarikh yang sah.`);
            } else if (parsedDate < today) {
              input.classList.add('is-invalid');
              input.setCustomValidity('Tarikh tidak boleh sebelum hari ini.');
              isValid = false;
              errors.push(`${labelText} tidak boleh sebelum hari ini.`);
            } else {
              input.classList.remove('is-invalid');
            }
          });

          form.querySelectorAll('.ulasan-field').forEach(textarea => {
            updateWordCounter(textarea);
            const maxWords = Number(textarea.dataset.maxWords || 250);
            if (countWords(textarea.value) > maxWords) {
              textarea.classList.add('is-invalid');
              isValid = false;
              errors.push('Ulasan / Catatan tidak boleh melebihi 250 patah perkataan.');
            } else {
              textarea.classList.remove('is-invalid');
            }
          });

          // 2. Check muster inputs
          musterInputs.forEach(input => {
            const labelText = input.previousElementSibling ? input.previousElementSibling.textContent.replace(' *', '').trim() : input.name;
            const val = Number(input.value);
            if (input.value.trim() === '' || isNaN(val) || val < 0 || !Number.isInteger(val)) {
              input.classList.add('is-invalid');
              isValid = false;
              errors.push(`${labelText} mestilah nombor bulat yang sah (0 atau lebih).`);
            } else {
              input.classList.remove('is-invalid');
            }
          });

          // 3. Check dynamically added items
          const itemCards = getItemRows();
          if (itemCards.length === 0) {
            isValid = false;
            errors.push('Sila tambah sekurang-kurangnya satu item pesanan.');
          } else {
            let hasItemError = false;
            itemCards.forEach((card) => {
              const qtyInput = card.querySelector('.item-order-qty');
              
              const qtyVal = Number(qtyInput.value);
              if (qtyInput.value.trim() === '' || isNaN(qtyVal) || qtyVal < 0) {
                qtyInput.classList.add('is-invalid');
                isValid = false;
                hasItemError = true;
              } else {
                qtyInput.classList.remove('is-invalid');
              }
            });
            
            if (hasItemError) {
              errors.push('Sila pastikan kuantiti pesanan untuk semua item diisi dengan betul.');
            }
          }
          
          if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
            const firstInvalid = form.querySelector('.is-invalid');
            const invalidPage = firstInvalid?.closest('[data-borang-page]');
            if (invalidPage) showBorangPage(invalidPage.dataset.borangPage);
            
            // Build error list
            errors.forEach(err => {
              const li = document.createElement('li');
              li.textContent = err;
              clientErrorList.appendChild(li);
            });
            
            clientErrorAlert.classList.remove('d-none');
            clientErrorAlert.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            form.classList.add('was-validated');
          } else {
            form.classList.remove('was-validated');
          }
        });
      }

      if (databaseItems.length) {
        databaseItems.forEach((item) => addItem(item));
      } else if (!isReadOnly) {
        // For new orders, contract selection will load items
      }

      (function initMuster() {
        const ditolak = numberValue(document.getElementById('musterTolakParol'));
        const khas = numberValue(document.getElementById('musterKhas'));
        if (ditolak > 0 && khas > 0) {
          document.getElementById('musterExclusion').value = Math.max(ditolak - khas, 0);
        }
      })();
      updateMusterSummary();
      updateSummary();

      // ── Draft Save Feature ──────────────────────────────────────────────
      const savedDraft = @json($savedDraft ?? null);

      function collectFormData() {
        return {
          contract_id: document.getElementById('contractSelect')?.value || '',
          tarikh_pesanan: document.querySelector('input[name="tarikh_pesanan"]')?.value || '',
          masa: document.querySelector('input[name="masa"]')?.value || '',
          sesi_kod: document.querySelector('input[name="sesi_kod"]')?.value || '',
          institution_id: document.getElementById('institutionIdHidden')?.value || '',
          supplier_id: document.getElementById('supplierSelect')?.value || '',
          wakil_pembekal: document.querySelector('input[name="wakil_pembekal"]')?.value || '',
          alamat_pembekal: document.querySelector('textarea[name="alamat_pembekal"]')?.value || '',
          muster_khas_daging: document.getElementById('musterKhas')?.value || 0,
          muster_ditolak_parol: document.getElementById('musterTolakParol')?.value || 0,
          parol: document.getElementById('parol')?.value || 0,
          muster_penuh: document.getElementById('musterPenuh')?.value || 0,
          tarikh_pembekal: document.querySelector('input[name="tarikh_pembekal"]')?.value || '',
          catatan_inden: document.querySelector('textarea[name="catatan_inden"]')?.value || '',
          items: collectItemsData(),
        };
      }

      function collectItemsData() {
        return getItemRows().map(function (card) {
          return {
            contract_item_id: card.querySelector('.item-contract-id')?.value || '',
            name: card.querySelector('.item-name-hidden')?.value || card.querySelector('.item-name')?.value || '',
            unit: card.querySelector('.item-unit-hidden')?.value || card.querySelector('.item-unit')?.value || '',
            orderQty: card.querySelector('.item-order-qty')?.value || 0,
            unitPrice: card.querySelector('.item-unit-price-hidden')?.value || 0,
          };
        });
      }

      function showDraftToast(msg) {
        var els = document.querySelectorAll('#draftSavedIndicator, #draftSavedIndicator1, #draftSavedIndicator2, #draftSavedIndicator3');
        els.forEach(function (el) {
          el.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i>' + msg;
          el.classList.remove('d-none');
          clearTimeout(el._hideTimer);
          el._hideTimer = setTimeout(function () { el.classList.add('d-none'); }, 4000);
        });
      }

      function setDraftStatusText(text) {
        var els = document.querySelectorAll('#draftStatus, #draftStatus1, #draftStatus2, #draftStatus3');
        els.forEach(function (el) { if (el) el.textContent = text; });
      }

      function saveDraft() {
        var data = collectFormData();
        fetch('{{ route("borang.inden.draft.save") }}', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: JSON.stringify(data),
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res.success) {
            hasUnsavedChanges = false;
            var d = new Date(res.saved_at);
            var time = d.toLocaleTimeString('ms-MY', { hour: '2-digit', minute: '2-digit' });
            setDraftStatusText('Draf disimpan pada ' + time);
            showDraftToast('\u2713 Draf disimpan');
          }
        })
        .catch(function (e) { console.error('Draft save failed', e); });
      }

      function populateItemRows(items) {
        if (itemDataTable) {
          itemDataTable.clear().draw();
        } else {
          itemList.innerHTML = '';
        }
        if (items && items.length) {
          items.forEach(function (item) { addItem(item); });
        }
      }

      function loadContractsAndRestore(contractId, items) {
        var instIdEl = document.getElementById('institutionIdHidden');
        var supIdEl = document.getElementById('supplierSelect');
        var instId = instIdEl ? instIdEl.value : '';
        var supId = supIdEl ? supIdEl.value : '';
        var contractSelect = document.getElementById('contractSelect');
        contractSelect.innerHTML = '<option value="">-- Pilih Kontrak --</option>';
        if (!instId || !supId) { isRestoringDraft = false; return; }

        var url = '{{ route("borang.inden.contracts") }}?institution_id=' + encodeURIComponent(instId)
                + '&supplier_id=' + encodeURIComponent(supId);

        fetch(url)
          .then(function (r) { return r.json(); })
          .then(function (contracts) {
            contracts.forEach(function (c) {
              var opt = document.createElement('option');
              opt.value = c.id;
              opt.textContent = c.contract_no;
              contractSelect.appendChild(opt);
            });
            if (contractId && Array.from(contractSelect.options).some(function (o) { return o.value == contractId; })) {
              contractSelect.value = contractId;
            } else if (contracts.length > 0) {
              contractSelect.value = contracts[0].id;
            }
            if (items) populateItemRows(items);
            isRestoringDraft = false;
            updateSummary();
            updateMusterSummary();
            wireUlasanCounter();
          })
          .catch(function () { isRestoringDraft = false; });
      }

      function restoreDraft(data) {
        if (!data || isReadOnly) return;
        isRestoringDraft = true;

        function setField(name, val) {
          var el = document.querySelector('[name="' + name + '"]');
          if (el && val !== undefined && val !== null && val !== '') el.value = val;
        }

        setField('tarikh_pesanan', data.tarikh_pesanan);
        if (data.tarikh_pesanan) {
          var tpInput = document.querySelector('input[name="tarikh_pesanan"]');
          if (tpInput) updateDayName(tpInput);
        }
        setField('masa', data.masa);
        setField('sesi_kod', data.sesi_kod);
        setField('wakil_pembekal', data.wakil_pembekal);
        setField('alamat_pembekal', data.alamat_pembekal);
        setField('muster_khas_daging', data.muster_khas_daging);
        setField('muster_ditolak_parol', data.muster_ditolak_parol);
        setField('parol', data.parol);
        setField('muster_penuh', data.muster_penuh);
        setField('tarikh_pembekal', data.tarikh_pembekal);
        setField('catatan_inden', data.catatan_inden);

        if (data.supplier_id) {
          document.getElementById('supplierSelect').value = data.supplier_id;
          // Fill supplier address / wakil inline (fillSupplierAddress is block-scoped and inaccessible)
          var sel = document.getElementById('supplierSelect');
          if (sel) {
            var opt = sel.options[sel.selectedIndex];
            if (opt && opt.value) {
              var addrField = document.querySelector('textarea[name="alamat_pembekal"]');
              if (addrField) {
                var addr = (opt.dataset.address || '').trim();
                var pcode = (opt.dataset.postcode || '').trim();
                addrField.value = addr + (addr && pcode ? ' ' : '') + pcode;
              }
              var wakilField = document.querySelector('input[name="wakil_pembekal"]');
              if (wakilField) wakilField.value = opt.dataset.contact || '';
            }
          }
          loadContractsAndRestore(data.contract_id, data.items);
        } else {
          if (data.items) populateItemRows(data.items);
          isRestoringDraft = false;
          updateSummary();
          updateMusterSummary();
          wireUlasanCounter();
        }

        hasUnsavedChanges = false;
        setDraftStatusText('Draf dipulihkan');
      }

      // ── Auto-save on any input (debounced 800ms) ──
      var debounceTimer = null;
      function triggerAutoSave() {
        hasUnsavedChanges = true;
        if (debounceTimer) clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
          saveDraft();
          debounceTimer = null;
        }, 800);
      }

      if (!isReadOnly && form) {
        form.querySelectorAll('input, textarea, select').forEach(function (el) {
          el.addEventListener('input', triggerAutoSave);
          el.addEventListener('change', triggerAutoSave);
        });
      }

      // ── Fallback interval auto-save (60s) ──
      if (!isReadOnly && form) {
        autoSaveTimer = setInterval(function () {
          if (hasUnsavedChanges) saveDraft();
        }, AUTO_SAVE_MS);
      }

      // ── Save immediately when leaving the page ──
      function saveDraftOnLeave() {
        if (hasUnsavedChanges) {
          var data = collectFormData();
          fetch('{{ route("borang.inden.draft.save") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(data),
            keepalive: true,
          }).catch(function () {});
          hasUnsavedChanges = false;
        }
      }

      if (!isReadOnly) {
        window.addEventListener('beforeunload', saveDraftOnLeave);
        document.addEventListener('visibilitychange', function () {
          if (document.visibilityState === 'hidden') saveDraftOnLeave();
        });
      }

      // ── Load saved draft on page init ──
      if (savedDraft && !isReadOnly) {
        restoreDraft(savedDraft);
      } else if (isReadOnly) {
        setDraftStatusText('Mod lihatan sahaja');
      }

      // ── Clear draft on successful form submit ──
      if (form && !isReadOnly) {
        form.addEventListener('submit', function () {
          // Clear draft from server after submission
          fetch('{{ route("borang.inden.draft.delete") }}', {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          }).catch(function () {});
          if (autoSaveTimer) clearInterval(autoSaveTimer);
        });
      }
    })();
  </script>
    <script src="{{ asset('js/table-download.js') }}"></script>
    <script src="{{ asset('js/session-timeout.js') }}"></script>
  <script src="{{ asset('js/user-theme.js') }}"></script>
</body>
</html>
