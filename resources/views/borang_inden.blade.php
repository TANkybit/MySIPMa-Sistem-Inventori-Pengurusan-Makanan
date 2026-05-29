<!DOCTYPE html>
<html lang="ms">
<head>
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
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
          onmouseout="this.style.color='white'">
          <i class="bi bi-bell-fill"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="font-size: 0.65rem;">
            {{ $pendingApprovals ?? 0 }}
            <span class="visually-hidden">Inden belum disah</span>
          </span>
        </a>
        @endif
        <a href="{{ route('profile') }}" class="text-white-50 text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'"
          onmouseout="this.style.color='rgba(255,255,255,0.5)'"><i
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

    <form method="POST" action="{{ route('borang.inden.store') }}">
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
        </div>
        <div class="row g-4">
          <div class="col-md-4">
            <label class="form-label">No. Pesanan <span class="text-danger">*</span></label>
            <input class="form-control" id="noPesanan" type="text" value="{{ old('no_pesanan', $inden->no_pesanan ?? '') }}" placeholder="Akan dijana automatik" readonly>
          </div>
          <div class="col-md-4">
            <label class="form-label">No. Kontrak</label>
            <input class="form-control" id="noKontrak" type="text" value="{{ old('no_kontrak', $inden->no_kontrak ?? '') }}" placeholder="Akan dijana automatik" readonly>
          </div>
          <div class="col-md-4">
            <label class="form-label">Tarikh Pesanan <span class="text-danger">*</span></label>
            <input class="form-control date-input @error('tarikh_pesanan') is-invalid @enderror" name="tarikh_pesanan" type="text" inputmode="numeric" pattern="^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/[0-9]{4}$" value="{{ $formatTarikh(old('tarikh_pesanan', $inden->tarikh_pesanan ?? now()->format('d/m/Y'))) }}" placeholder="dd/mm/yyyy" {{ $fieldState }} required>
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
            @error('sesi_kod')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Kepada (Institusi) <span class="text-danger">*</span></label>
              <select class="form-select @error('institution_id') is-invalid @enderror" name="institution_id" id="institutionSelect" {{ $isReadOnly ? 'disabled' : '' }} required>
                <option value="">-- Pilih Institusi --</option>
                @foreach($institutions as $inst)
                  <option value="{{ $inst->id }}" data-code="{{ $inst->code }}" data-location="{{ $inst->location_code }}" {{ old('institution_id', $inden->institution_id ?? '') == $inst->id ? 'selected' : '' }}>{{ $inst->name }}</option>
                @endforeach
              </select>
            @error('institution_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Pembekal <span class="text-danger">*</span></label>
            <select class="form-select @error('supplier_id') is-invalid @enderror" name="supplier_id" id="supplierSelect" {{ $isReadOnly ? 'disabled' : '' }} required>
              <option value="">-- Pilih Pembekal --</option>
              @foreach($suppliers as $sup)
                <option value="{{ $sup->id }}" data-address="{{ $sup->address }}" data-postcode="{{ $sup->postcode }}" data-contact="{{ $sup->contact_person ?? $sup->company_name }}" {{ old('supplier_id', $inden->supplier_id ?? '') == $sup->id ? 'selected' : '' }}>{{ $sup->company_name }}</option>
              @endforeach
            </select>
            @error('supplier_id')
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
        </div>
        <div class="items-wrap">
          <div class="items-toolbar">
            <div>
              <h3 class="h5 mb-1">Item Pesanan</h3>
              <p class="muted mb-0">Contoh barang daripada PDF: ikan basah, daging lembu, kobis, bawang, halia, kacang merah dan ubi kentang.</p>
            </div>
          </div>
          <div class="p-3">
            <table id="itemDataTable" class="table table-dark-custom w-100">
              <thead>
                <tr>
                  <th>Bil</th>
                  <th>Perihal Barang</th>
                  <th>Unit</th>
                  <th>Kuantiti Pesanan</th>
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
                <input class="form-control @error('wakil_pembekal') is-invalid @enderror" name="wakil_pembekal" type="text" value="{{ old('wakil_pembekal', $inden->wakil_pembekal ?? $inden->nama_pembekal ?? '') }}" placeholder="Nama wakil pembekal" {{ $fieldState }} required>
                @error('wakil_pembekal')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Tarikh Pembekal <span class="text-danger">*</span></label>
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
        <a href="{{ route('user.dashboard') }}" class="btn btn-round btn-soft">Kembali ke Dashboard</a>
        <div class="d-flex flex-wrap gap-2">
          <button class="btn btn-round btn-soft" type="button" onclick="window.print()">Cetak Ringkasan</button>
          @unless ($isReadOnly)
            <button class="btn btn-round btn-add" type="submit">Hantar</button>
          @endunless
        </div>
      </div>
      </div>
    </form>
  </div>
  </main>

  <template id="itemTemplate">
    <tr class="item-card">
      <td><span class="item-index"></span></td>
      <td>
        <select class="form-select item-name" required data-placeholder="Cari nama barang"></select>
      </td>
      <td>
        <input class="form-control item-unit" type="text" value="Unit" readonly required>
      </td>
      <td>
        <input class="form-control item-order-qty item-calc" type="number" min="0" step="0.01" value="0" required>
      </td>
      <td>
        <input class="form-control item-unit-price item-calc" type="number" min="0" step="0.01" value="0" required>
      </td>
      <td>
        <input class="form-control item-total" type="text" value="RM 0.00" readonly>
        <input class="form-control item-received-qty item-calc d-none" type="number" min="0" step="0.01" value="0">
        <textarea class="form-control item-notes ulasan-field d-none" placeholder="Catatan penerimaan atau spesifikasi" data-max-words="250"></textarea>
      </td>
      <td>
        <div class="d-flex flex-wrap gap-2">
          <button class="btn btn-sm btn-soft edit-item" type="button">Kemaskini</button>
          <button class="btn btn-sm btn-outline-danger remove-item" type="button">Padam</button>
        </div>
      </td>
    </tr>
  </template>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/js/mobile-nav.js') }}"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    (function () {
      const itemList = document.getElementById('itemList');
      const itemTemplate = document.getElementById('itemTemplate');
      const musterInputs = document.querySelectorAll('.muster-input');
      const form = document.querySelector('form[action$="store"]');
      const databaseItems = @json($indenItems ?? []);
      const isReadOnly = @json($isReadOnly);
      const itemSearchUrl = "{{ route('items.search') }}";
      let itemDataTable = null;
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      if (isReadOnly) {
        document.querySelectorAll('input, textarea').forEach((input) => input.setAttribute('readonly', 'readonly'));
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

        // Auto-generate No. Pesanan
        const institutionSelect = document.getElementById('institutionSelect');
        const noPesananInput = document.getElementById('noPesanan');
        const noKontrakInput = document.getElementById('noKontrak');
        let generateTimeout = null;

        function generateOrderNo() {
          const instId = institutionSelect?.value;
          if (!instId) {
            noPesananInput.value = '';
            return;
          }
          if (generateTimeout) clearTimeout(generateTimeout);
          generateTimeout = setTimeout(() => {
            fetch('{{ route("borang.inden.generate") }}?institution_id=' + instId)
              .then(r => r.json())
              .then(d => { if (d.success) noPesananInput.value = d.order_no; })
              .catch(() => {});
          }, 300);
        }

        function generateContractNo() {
          fetch('{{ route("borang.inden.contract") }}')
            .then(r => r.json())
            .then(d => { if (d.success) noKontrakInput.value = d.contract_no; })
            .catch(() => {});
        }

        if (institutionSelect) institutionSelect.addEventListener('change', generateOrderNo);
        if (!noPesananInput.value) generateOrderNo();
        if (!noKontrakInput.value) generateContractNo();

        const dateInputs = document.querySelectorAll('.date-input');
        const timeInputs = document.querySelectorAll('input[type="time"]');
        const now = new Date();
        const localDate = formatDateForDisplay(now);

        dateInputs.forEach(input => {
          input.addEventListener('input', function () {
            this.value = this.value.replace(/[^\d/]/g, '').slice(0, 10);
            this.setCustomValidity('');
            updateTimeMinimum(this.value, localDate, now, timeInputs);
          });

          input.addEventListener('change', function() {
            updateTimeMinimum(this.value, localDate, now, timeInputs);
          });
        });

        dateInputs.forEach(input => {
          if (!input.value) input.value = localDate;
          input.dispatchEvent(new Event('change'));
        });

        const localTime = now.toTimeString().substring(0, 5);
        timeInputs.forEach(input => {
          if (!input.value) input.value = localTime;
        });
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
        if (dateValue === localDate) {
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
          const nameSelect = card.querySelector('.item-name');
          nameSelect.name = `items[${index}][name]`;
          card.querySelector('.item-unit').name = `items[${index}][unit]`;
          card.querySelector('.item-order-qty').name = `items[${index}][orderQty]`;
          card.querySelector('.item-unit-price').name = `items[${index}][unitPrice]`;
          card.querySelector('.item-notes').name = `items[${index}][notes]`;
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
        const cards = getItemRows();
        let orderQtyTotal = 0, receivedQtyTotal = 0, grandTotal = 0;
        cards.forEach((card) => {
          const orderQty = numberValue(card.querySelector('.item-order-qty'));
          const unitPrice = numberValue(card.querySelector('.item-unit-price'));
          const receivedQty = numberValue(card.querySelector('.item-received-qty'));
          const qtyForTotal = receivedQty > 0 ? receivedQty : orderQty;
          const lineTotal = qtyForTotal * unitPrice;
          orderQtyTotal += orderQty;
          receivedQtyTotal += receivedQty;
          grandTotal += lineTotal;
          card.querySelector('.item-total').value = formatCurrency(lineTotal);
        });
        document.getElementById('summaryItemCount').textContent = cards.length;
        document.getElementById('summaryOrderQty').textContent = formatNumber(orderQtyTotal);
        document.getElementById('summaryReceivedQty').textContent = formatNumber(receivedQtyTotal);
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
          ordering: false,
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
            $('.dt-item-actions').html(@json($isReadOnly ? '' : '<button class="btn btn-round btn-add" id="addItemButton" type="button">Tambah Item</button>'));
            $('#addItemButton').on('click', function () { addItem(); });
          }
        });
      }

      function initItemSelect(select, defaults = {}) {
        if (!window.jQuery || !$.fn.select2) return;

        const selectedName = defaults.name || '';
        if (selectedName) {
          const option = new Option(selectedName, selectedName, true, true);
          option.dataset.uom = defaults.unit || 'Unit';
          option.dataset.price = defaults.unitPrice ?? 0;
          select.appendChild(option);
        }

        $(select).select2({
          ajax: {
            url: itemSearchUrl,
            dataType: 'json',
            delay: 250,
            data: params => ({ q: params.term || '' }),
            processResults: data => data
          },
          dropdownParent: $('#itemDataTable').parent(),
          minimumInputLength: 0,
          placeholder: select.dataset.placeholder || 'Cari nama barang',
          width: 'resolve'
        });

        $(select).on('select2:select', function (event) {
          const selected = event.params.data || {};
          const card = select.closest('.item-card');
          card.querySelector('.item-unit').value = selected.uom || 'Unit';
          card.querySelector('.item-unit-price').value = selected.price_per_unit ?? 0;
          updateSummary();
        });
      }

      function wireItemCard(card) {
        card.querySelectorAll('.item-calc').forEach((input) => input.addEventListener('input', updateSummary));
        wireUlasanCounter(card);
        initItemSelect(card.querySelector('.item-name'), {
          name: card.dataset.itemName || '',
          unit: card.dataset.itemUnit || 'Unit',
          unitPrice: card.dataset.itemPrice || 0
        });
        const removeButton = card.querySelector('.remove-item');
        const editButton = card.querySelector('.edit-item');

        if (isReadOnly) {
          removeButton.classList.add('d-none');
          editButton.classList.add('d-none');
          card.querySelectorAll('input').forEach((input) => input.setAttribute('readonly', 'readonly'));
          card.querySelectorAll('select').forEach((select) => select.setAttribute('disabled', 'disabled'));
          return;
        }

        editButton.addEventListener('click', function () {
          $(card.querySelector('.item-name')).select2('open');
        });

        removeButton.addEventListener('click', function () {
          if (itemDataTable) {
            itemDataTable.row(card).remove().draw(false);
          } else {
            card.remove();
          }
          updateItemIndices();
          updateSummary();
          if (!getItemRows().length) addItem({ name: '', unit: 'Unit', orderQty: 0, unitPrice: 0, receivedQty: 0, notes: '' });
        });
      }

      function addItem(defaults = {}) {
        const card = itemTemplate.content.firstElementChild.cloneNode(true);
        const unitInput = card.querySelector('.item-unit');

        card.dataset.itemName = defaults.name || '';
        card.dataset.itemUnit = defaults.unit || 'Unit';
        card.dataset.itemPrice = defaults.unitPrice ?? 0;
        unitInput.value = defaults.unit || 'Unit';
        card.querySelector('.item-order-qty').value = defaults.orderQty ?? 0;
        card.querySelector('.item-unit-price').value = defaults.unitPrice ?? 0;
        card.querySelector('.item-received-qty').value = defaults.receivedQty ?? 0;
        card.querySelector('.item-notes').value = defaults.notes || '';
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
            const parsedDate = parseDisplayDate(input.value.trim());
            input.setCustomValidity('');
            if (!parsedDate) {
              input.classList.add('is-invalid');
              input.setCustomValidity('Sila masukkan tarikh dalam format dd/mm/yyyy.');
              isValid = false;
              errors.push(`${labelText} mesti dalam format dd/mm/yyyy.`);
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
              const nameInput = card.querySelector('.item-name');
              const qtyInput = card.querySelector('.item-order-qty');
              const priceInput = card.querySelector('.item-unit-price');
              
              if (!nameInput.value.trim()) {
                nameInput.classList.add('is-invalid');
                isValid = false;
                hasItemError = true;
              } else {
                nameInput.classList.remove('is-invalid');
              }
              
              const qtyVal = Number(qtyInput.value);
              if (qtyInput.value.trim() === '' || isNaN(qtyVal) || qtyVal < 0) {
                qtyInput.classList.add('is-invalid');
                isValid = false;
                hasItemError = true;
              } else {
                qtyInput.classList.remove('is-invalid');
              }
              
              const priceVal = Number(priceInput.value);
              if (priceInput.value.trim() === '' || isNaN(priceVal) || priceVal < 0) {
                priceInput.classList.add('is-invalid');
                isValid = false;
                hasItemError = true;
              } else {
                priceInput.classList.remove('is-invalid');
              }
            });
            
            if (hasItemError) {
              errors.push('Sila pastikan perihal barang, kuantiti, dan harga seunit untuk semua item diisi dengan betul.');
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
        addItem({ name: '', unit: 'Unit', orderQty: 0, unitPrice: 0, receivedQty: 0, notes: '' });
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
    })();
  </script>
</body>
</html>
