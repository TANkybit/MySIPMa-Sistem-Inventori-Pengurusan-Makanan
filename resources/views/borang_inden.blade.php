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
    .form-control::placeholder, .form-select option { color: rgba(226,232,240,.7); }
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
    @media (max-width: 767.98px) { .hero,.section-card { padding:22px; } .section-head,.items-toolbar,.action-row { flex-direction:column; align-items:flex-start; } }
    
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
    $inden = $indenHeader ?? null;
    $isReadOnly = $readOnly ?? false;
    $fieldState = $isReadOnly ? 'readonly' : '';
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
          <li><a href="{{ route('user.pengesahan.inden') }}"
              class="{{ request()->routeIs('user.pengesahan.inden') ? 'active' : '' }}">Pengesahan Inden</a></li>
          <li><a href="{{ route('borang.inden') }}"
              class="{{ request()->routeIs('borang.inden') ? 'active' : '' }}">Borang Inden</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-none d-xl-flex align-items-center gap-3">
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

    <form method="POST" action="{{ route('borang.inden.store') }}" novalidate>
      @csrf
      <div class="card-box section-card mb-4">
        <div class="section-head">
          <div>
            <h2 class="h4 mb-1">Maklumat Pesanan</h2>
            <p class="muted mb-0">Maklumat kepala borang daripada PDF disusun semula kepada satu seksyen yang lebih jelas.</p>
          </div>
          <div class="chip">Langkah 1</div>
        </div>
        <div class="row g-4">
          <div class="col-md-6">
            <label class="form-label">No. Pesanan <span class="text-danger">*</span></label>
            <input class="form-control @error('no_pesanan') is-invalid @enderror" name="no_pesanan" type="text" value="{{ old('no_pesanan', $inden->no_pesanan ?? '') }}" placeholder="Contoh: PSU/SU/BK/26/2/5" {{ $fieldState }} required>
            @error('no_pesanan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">No. Kontrak <span class="text-danger">*</span></label>
            <input class="form-control @error('no_kontrak') is-invalid @enderror" name="no_kontrak" type="text" value="{{ old('no_kontrak', $inden->no_kontrak ?? '') }}" placeholder="Contoh: TJP 15/2023" {{ $fieldState }} required>
            @error('no_kontrak')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">Tarikh Pesanan <span class="text-danger">*</span></label>
            <input class="form-control @error('tarikh_pesanan') is-invalid @enderror" name="tarikh_pesanan" type="date" value="{{ old('tarikh_pesanan', $inden->tarikh_pesanan ?? '') }}" {{ $fieldState }} required>
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
            <input class="form-control @error('sesi_kod') is-invalid @enderror" name="sesi_kod" type="text" value="{{ old('sesi_kod', $inden->sesi_kod ?? '') }}" placeholder="Contoh: KHAMIS - M2/M4" {{ $fieldState }} required>
            @error('sesi_kod')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Kepada (Institusi) <span class="text-danger">*</span></label>
            <input class="form-control @error('kepada_institusi') is-invalid @enderror" name="kepada_institusi" type="text" value="{{ old('kepada_institusi', $inden->kepada_institusi ?? '') }}" placeholder="Contoh: Pengarah Penjara Sungai Udang" {{ $fieldState }} required>
            @error('kepada_institusi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Pembekal <span class="text-danger">*</span></label>
            <input class="form-control @error('nama_pembekal') is-invalid @enderror" name="nama_pembekal" type="text" value="{{ old('nama_pembekal', $inden->nama_pembekal ?? '') }}" placeholder="Contoh: JIWA REMAJA SDN BHD" {{ $fieldState }} required>
            @error('nama_pembekal')
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

      <div class="card-box section-card mb-4">
        <div class="section-head">
          <div>
            <h2 class="h4 mb-1">Ringkasan Muster</h2>
            <p class="muted mb-0">Muster khas, muster ditolak parol, parol dan muster penuh dihimpunkan dalam satu tempat.</p>
          </div>
          <div class="chip">Langkah 2</div>
        </div>
        <div class="row g-4">
          <div class="col-md-3">
            <label class="form-label">Muster Khas (Daging) <span class="text-danger">*</span></label>
            <input class="form-control muster-input @error('muster_khas_daging') is-invalid @enderror" id="musterKhas" name="muster_khas_daging" type="number" min="0" step="1" value="{{ old('muster_khas_daging', $inden->muster_khas_daging ?? 0) }}" {{ $fieldState }} required>
            @error('muster_khas_daging')
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
            <label class="form-label">Parol <span class="text-danger">*</span></label>
            <input class="form-control muster-input @error('parol') is-invalid @enderror" id="parol" name="parol" type="number" min="0" step="1" value="{{ old('parol', $inden->parol ?? 0) }}" {{ $fieldState }} required>
            @error('parol')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-3">
            <label class="form-label">Muster Penuh <span class="text-danger">*</span></label>
            <input class="form-control muster-input @error('muster_penuh') is-invalid @enderror" id="musterPenuh" name="muster_penuh" type="number" min="0" step="1" value="{{ old('muster_penuh', $inden->muster_penuh ?? 0) }}" {{ $fieldState }} required>
            @error('muster_penuh')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="row g-3 mt-1 d-none">
          <div class="col-md-4"><div class="card-box p-3"><small class="text-muted d-block">Jumlah Asas</small><strong id="baseMusterTotal">0</strong></div></div>
          <div class="col-md-4"><div class="card-box p-3"><small class="text-muted d-block">Pelarasan Parol</small><strong id="parolAdjustment">0</strong></div></div>
          <div class="col-md-4"><div class="card-box p-3"><small class="text-muted d-block">Anggaran Bilangan Akhir</small><strong id="finalMusterTotal">0</strong></div></div>
        </div>
      </div>

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
            @unless ($isReadOnly)
              <button class="btn btn-round btn-add" id="addItemButton" type="button">Tambah Item</button>
            @endunless
          </div>
          <div id="itemList"></div>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-lg-7">
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
              <div class="col-md-6"><label class="form-label">Jawatan / Cop</label><input class="form-control" type="text" value="{{ $inden->jawatan_cop ?? '' }}" placeholder="Contoh: Peg. Penjara KA19" {{ $fieldState }}></div>
              <div class="col-md-6">
                <label class="form-label">Nama Wakil Pembekal <span class="text-danger">*</span></label>
                <input class="form-control @error('wakil_pembekal') is-invalid @enderror" name="wakil_pembekal" type="text" value="{{ old('wakil_pembekal', $inden->wakil_pembekal ?? $inden->nama_pembekal ?? '') }}" placeholder="Nama wakil pembekal" {{ $fieldState }} required>
                @error('wakil_pembekal')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Tarikh Pembekal <span class="text-danger">*</span></label>
                <input class="form-control @error('tarikh_pembekal') is-invalid @enderror" name="tarikh_pembekal" type="date" value="{{ old('tarikh_pembekal', $inden->tarikh_pembekal ?? '') }}" {{ $fieldState }} required>
                @error('tarikh_pembekal')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6 d-none"><label class="form-label">Nama Saksi</label><input class="form-control" type="text" placeholder="Nama saksi"></div>
              <div class="col-md-6 d-none"><label class="form-label">Nama Penerima</label><input class="form-control" type="text" placeholder="Nama penerima"></div>
              <div class="col-md-6 d-none"><label class="form-label">Jawatan / Cop Saksi</label><input class="form-control" type="text" placeholder="Jawatan atau cop saksi"></div>
              <div class="col-md-6 d-none"><label class="form-label">Jawatan / Cop Penerima</label><input class="form-control" type="text" placeholder="Jawatan atau cop penerima"></div>
              <div class="col-md-6 d-none"><label class="form-label">Tarikh Saksi</label><input class="form-control" type="date"></div>
              <div class="col-md-6 d-none"><label class="form-label">Tarikh Penerima</label><input class="form-control" type="date"></div>
              <div class="col-12">
                <label class="form-label">Ulasan / Catatan Umum</label>
                <textarea class="form-control @error('catatan_inden') is-invalid @enderror" name="catatan_inden" placeholder="Masukkan catatan tambahan jika perlu" {{ $fieldState }}>{{ old('catatan_inden', $inden->catatan_inden ?? '') }}</textarea>
                @error('catatan_inden')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="totals-box h-100">
            <h2 class="h4 mb-3">Ringkasan Automatik</h2>
            <p class="mb-4" style="color: rgba(255,255,255,.78);">Jumlah item, kuantiti dan harga dikira automatik untuk kurangkan pengiraan manual.</p>
            <div class="totals-row"><span>Jumlah Item</span><strong id="summaryItemCount">0</strong></div>
            <div class="totals-row"><span>Jumlah Kuantiti Pesanan</span><strong id="summaryOrderQty">0</strong></div>
            <div class="totals-row d-none"><span>Jumlah Kuantiti Terima</span><strong id="summaryReceivedQty">0</strong></div>
            <div class="totals-row"><span>Jumlah Harga</span><strong id="summaryGrandTotal">RM 0.00</strong></div>
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
    </form>
  </div>
  </main>

  <template id="itemTemplate">
    <div class="item-card">
      <div class="item-actions">
        <div class="d-flex align-items-center gap-3">
          <span class="item-index"></span>
          <div><h3 class="h6 mb-1">Item Barang</h3><p class="muted mb-0">Isi nama barang, unit, kuantiti dan harga seunit.</p></div>
        </div>
        <button class="btn btn-round btn-soft remove-item" type="button">Buang</button>
      </div>
      <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Perihal Barang</label><input class="form-control item-name" type="text" placeholder="Contoh: Ikan Basah" required></div>
        <div class="col-md-2"><label class="form-label">Unit</label><select class="form-select item-unit" required><option value="Kg.">Kg.</option><option value="Gm.">Gm.</option><option value="Unit">Unit</option><option value="Pek">Pek</option><option value="Lain-lain">Lain-lain</option></select></div>
        <div class="col-md-2"><label class="form-label">Kuantiti Pesanan</label><input class="form-control item-order-qty item-calc" type="number" min="0" step="0.01" value="0" required></div>
        <div class="col-md-2"><label class="form-label">Harga Seunit</label><input class="form-control item-unit-price item-calc" type="number" min="0" step="0.01" value="0" required></div>
        <div class="col-md-2"><label class="form-label">Jumlah Harga</label><input class="form-control item-total" type="text" value="RM 0.00" readonly></div>
        <!-- Hidden elements -->
        <div class="col-md-2 d-none"><label class="form-label">Kuantiti Terima</label><input class="form-control item-received-qty item-calc" type="number" min="0" step="0.01" value="0"></div>
        <div class="col-md-8 d-none"><label class="form-label">Ulasan / Catatan</label><input class="form-control item-notes" type="text" placeholder="Catatan penerimaan atau spesifikasi"></div>
      </div>
    </div>
  </template>

  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/js/mobile-nav.js') }}"></script>
  <script>
    (function () {
      const itemList = document.getElementById('itemList');
      const itemTemplate = document.getElementById('itemTemplate');
      const addItemButton = document.getElementById('addItemButton');
      const musterInputs = document.querySelectorAll('.muster-input');
      const databaseItems = @json($indenItems ?? []);
      const isReadOnly = @json($isReadOnly);

      if (isReadOnly) {
        document.querySelectorAll('input, textarea').forEach((input) => input.setAttribute('readonly', 'readonly'));
        document.querySelectorAll('select').forEach((select) => select.setAttribute('disabled', 'disabled'));
      } else {
        const dateInputs = document.querySelectorAll('input[type="date"]');
        const timeInputs = document.querySelectorAll('input[type="time"]');
        const now = new Date();
        const localDate = new Date(now.getTime() - (now.getTimezoneOffset() * 60000)).toISOString().split('T')[0];

        dateInputs.forEach(input => {
            input.setAttribute('min', localDate);

            input.addEventListener('change', function() {
                if (this.value === localDate) {
                    const localTime = now.toTimeString().substring(0, 5);
                    timeInputs.forEach(t => t.setAttribute('min', localTime));
                } else {
                    timeInputs.forEach(t => t.removeAttribute('min'));
                }
            });
        });

        dateInputs.forEach(input => {
            if (!input.value) input.value = localDate;
            input.dispatchEvent(new Event('change'));
        });
      }

      function numberValue(input) { return Number.parseFloat(input.value) || 0; }
      function formatNumber(value) { return new Intl.NumberFormat('en-MY', { minimumFractionDigits: value % 1 === 0 ? 0 : 2, maximumFractionDigits: 2 }).format(value || 0); }
      function formatCurrency(value) { return 'RM ' + new Intl.NumberFormat('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value || 0); }

      function updateItemIndices() {
        itemList.querySelectorAll('.item-card').forEach((card, index) => {
          card.querySelector('.item-index').textContent = index + 1;
          card.querySelector('.item-name').name = `items[${index}][name]`;
          card.querySelector('.item-unit').name = `items[${index}][unit]`;
          card.querySelector('.item-order-qty').name = `items[${index}][orderQty]`;
          card.querySelector('.item-unit-price').name = `items[${index}][unitPrice]`;
          card.querySelector('.item-notes').name = `items[${index}][notes]`;
        });
      }

      function updateMusterSummary() {
        const base = numberValue(document.getElementById('musterKhas')) + numberValue(document.getElementById('musterTolakParol')) + numberValue(document.getElementById('musterPenuh'));
        const parol = numberValue(document.getElementById('parol'));
        document.getElementById('baseMusterTotal').textContent = formatNumber(base);
        document.getElementById('parolAdjustment').textContent = formatNumber(parol);
        document.getElementById('finalMusterTotal').textContent = formatNumber(Math.max(base - parol, 0));
      }

      function updateSummary() {
        const cards = itemList.querySelectorAll('.item-card');
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

      function wireItemCard(card) {
        card.querySelectorAll('.item-calc').forEach((input) => input.addEventListener('input', updateSummary));
        const removeButton = card.querySelector('.remove-item');

        if (isReadOnly) {
          removeButton.classList.add('d-none');
          card.querySelectorAll('input').forEach((input) => input.setAttribute('readonly', 'readonly'));
          card.querySelectorAll('select').forEach((select) => select.setAttribute('disabled', 'disabled'));
          return;
        }

        removeButton.addEventListener('click', function () {
          card.remove();
          updateItemIndices();
          updateSummary();
          if (!itemList.children.length) addItem({ name: '', unit: 'Unit', orderQty: 0, unitPrice: 0, receivedQty: 0, notes: '' });
        });
      }

      function addItem(defaults = {}) {
        const card = itemTemplate.content.firstElementChild.cloneNode(true);
        const unitSelect = card.querySelector('.item-unit');

        if (defaults.unit && !Array.from(unitSelect.options).some((option) => option.value === defaults.unit)) {
          unitSelect.add(new Option(defaults.unit, defaults.unit));
        }

        card.querySelector('.item-name').value = defaults.name || '';
        unitSelect.value = defaults.unit || 'Unit';
        card.querySelector('.item-order-qty').value = defaults.orderQty ?? 0;
        card.querySelector('.item-unit-price').value = defaults.unitPrice ?? 0;
        card.querySelector('.item-received-qty').value = defaults.receivedQty ?? 0;
        card.querySelector('.item-notes').value = defaults.notes || '';
        itemList.appendChild(card);
        wireItemCard(card);
        updateItemIndices();
        updateSummary();
      }

      if (addItemButton) {
        addItemButton.addEventListener('click', function () { addItem(); });
      }
      musterInputs.forEach((input) => input.addEventListener('input', updateMusterSummary));

      // Client-side Validation Handler
      const form = document.querySelector('form[action$="store"]');
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
          const clientErrorAlert = document.getElementById('clientErrorAlert');
          const clientErrorList = document.getElementById('clientErrorList');
          clientErrorList.innerHTML = '';
          clientErrorAlert.classList.add('d-none');
          
          let isValid = true;
          const errors = [];
          
          // 1. Check all standard required inputs in step 1 & step 4
          const requiredInputs = form.querySelectorAll('input[required]:not(.item-calc):not(.item-name), textarea[required]');
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
          const itemCards = itemList.querySelectorAll('.item-card');
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

      updateMusterSummary();
      updateSummary();
    })();
  </script>
</body>
</html>
