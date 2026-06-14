<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Borang Penerimaan - MySIPMa</title>
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
    .hero-title { font-size: clamp(2rem,4vw,3rem); font-weight:800; line-height:1.05; margin:10px 0 14px; }
    .muted { color: var(--muted); line-height:1.7; }
    .form-label { color:#cbd5e1; font-size:.92rem; font-weight:700; margin-bottom:8px; }
    .form-control,.form-select { background: #111827; border:1px solid rgba(255,255,255,.08); border-radius:14px; color: var(--text); min-height:48px; padding:12px 14px; }
    .form-control::placeholder { color: rgba(255,255,255,.35); opacity: 1; }
    .form-control:focus,.form-select:focus { border-color: rgba(16,185,129,.45); box-shadow:0 0 0 .2rem rgba(16,185,129,.16); background: #111827; color: var(--text); }
    .btn-custom { background: var(--accent); color:#0f172a; border:0; border-radius:999px; padding:12px 24px; font-weight:700; text-decoration:none; transition:all .3s; }
    .btn-custom:hover { background:#0ea5e9; color:#fff; transform:scale(1.05); }
    .btn-logout { background:transparent; border:1px solid rgba(255,255,255,.2); color:#fff; }
    .btn-logout:hover { background:rgba(255,255,255,.1); border-color:#fff; }
    .select2-container { width:100% !important; }
    .select2-container--default .select2-selection--single { background:#111827; border:1px solid rgba(255,255,255,.08); border-radius:14px; color:var(--text); min-height:48px; padding:9px 12px; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { color:var(--text); line-height:28px; padding-left:0; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height:46px; }
    .select2-dropdown { background:#111827; border:1px solid rgba(255,255,255,.12); color:var(--text); }
    .select2-search__field { background:#0b1020; border:1px solid rgba(255,255,255,.12) !important; color:var(--text); }
    .select2-results__option--highlighted { background:var(--accent) !important; color:#0f172a !important; }
    table.dataTable > thead > tr > th { border-bottom:1px solid rgba(255,255,255,.12) !important; }
    table.dataTable > tbody > tr { background:transparent !important; }
    .table-dark-custom { color:var(--text) !important; border-color:var(--border) !important; }
    .table-dark-custom th { background:var(--surface-soft) !important; color:#fff !important; }
    .table-dark-custom td { background:transparent !important; border-bottom:1px solid rgba(255,255,255,.08) !important; color:#fff !important; vertical-align:middle; }
    .totals-box { background: linear-gradient(180deg,#111827 0%,#0b1020 100%); border-radius:20px; color:#fff; padding:24px; }
    .items-wrap { border:1px solid rgba(255,255,255,.08); border-radius:20px; overflow:hidden; }
    .item-card { border-bottom:1px solid rgba(255,255,255,.08); padding:20px; background: var(--surface-soft); }
    .item-card:last-child { border-bottom:0; }
    .section-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
    .order-info-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:24px; padding:20px; background: var(--surface-strong); border-radius:16px; border:1px solid rgba(255,255,255,.06); }
    .order-info-item label { color:var(--muted); font-size:.8rem; text-transform:uppercase; letter-spacing:.5px; font-weight:700; }
    .order-info-item p { color:#fff; font-size:1rem; font-weight:600; margin:4px 0 0; }
    .item-index { align-items:center; background: var(--accent); border-radius:999px; color:#0f172a; display:inline-flex; font-size:.8rem; font-weight:700; height:34px; justify-content:center; width:34px; }
    .invalid-feedback { color: #f87171; font-size: 0.85rem; margin-top: 6px; font-weight: 500; display: none; }
    .is-invalid + .invalid-feedback, .is-invalid ~ .invalid-feedback { display: block; }
    .form-control.is-invalid, .form-select.is-invalid { border-color: #f87171 !important; }
    .action-row { display:flex; flex-wrap:wrap; gap:12px; justify-content:space-between; align-items:center; margin-top:24px; }
    .word-counter { color: rgba(255,255,255,.55); font-size: .85rem; }
    .wrong-toggle { width:22px;height:22px;border-radius:6px;border:2px solid rgba(255,255,255,.2);background:transparent;cursor:pointer; }
    .wrong-toggle:checked { background-color:var(--accent);border-color:var(--accent); }
    .date-input { background:#111827;border:1px solid rgba(255,255,255,.08);border-radius:14px;color:var(--text);min-height:48px;padding:12px 14px; }
    .date-input:focus { border-color:rgba(16,185,129,.45);box-shadow:0 0 0 .2rem rgba(16,185,129,.16);background:#111827;color:var(--text); }
    @media (max-width: 767.98px) { .hero,.section-card { padding:22px; } }
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
        @if(Auth::user()->hasPermission('pengesahan_inden'))
        <a href="{{ route('user.pengesahan.inden') }}" class="position-relative text-white fs-5 me-3" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='white'">
          <i class="bi bi-bell-fill"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            {{ $pendingApprovals ?? 0 }}
            <span class="visually-hidden">Inden belum disah</span>
          </span>
        </a>
        @endif
        @if(Auth::user()->hasPermission('penerimaan_inden'))
        <a href="{{ route('borang.penerimaan') }}" class="position-relative text-white fs-5 me-3" style="transition: color 0.3s;" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color='white'">
          <i class="bi bi-truck"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            {{ $pendingPenerimaan ?? 0 }}
            <span class="visually-hidden">Penerimaan belum diproses</span>
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

  <main class="main">
  <div class="container page-shell">
    <div class="card-box hero">
      <h1 class="hero-title">Borang Penerimaan Barang</h1>
      <p class="muted mb-0">Rekod penerimaan barang daripada pembekal berdasarkan pesanan inden.</p>
    </div>

    @if (session('success'))
      <div class="alert alert-success border-0 rounded-4 mb-4">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger border-0 rounded-4 mb-4">
        <ul class="mb-0 ps-3">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('borang.penerimaan.store') }}">
      @csrf

      <!-- Pilih Pesanan -->
      <div class="card-box section-card mb-4">
        <div class="section-head">
          <h4 class="mb-0">Pilih Pesanan Inden</h4>
        </div>
        <div class="mb-3">
          <label class="form-label">No. Pesanan Inden</label>
          <select class="form-select" name="order_id" id="orderSelect" required>
            <option value="">-- Pilih No. Inden --</option>
            @foreach($orders as $order)
              <option value="{{ $order->id }}" data-supplier="{{ $order->supplier_name ?? '-' }}" data-date="{{ $order->formatted_date ?? $order->order_date ?? '-' }}" data-institution="{{ $order->institution_name ?? '-' }}" {{ (request('order_id') == $order->id) ? 'selected' : '' }}>{{ $order->order_no }} - {{ $order->supplier_name ?? '-' }} ({{ $order->formatted_date ?? $order->order_date ?? '-' }})</option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- Maklumat Pesanan -->
      <div id="orderInfoPanel" class="card-box section-card mb-4" style="display:none;">
        <h4 class="mb-3">Maklumat Pesanan</h4>
        <div class="order-info-grid">
          <div class="order-info-item">
            <label>No. Pesanan</label>
            <p id="infoOrderNo">-</p>
          </div>
          <div class="order-info-item">
            <label>Tarikh Pesanan</label>
            <p id="infoOrderDate">-</p>
          </div>
          <div class="order-info-item">
            <label>Pembekal</label>
            <p id="infoSupplier">-</p>
          </div>
          <div class="order-info-item">
            <label>Institusi</label>
            <p id="infoInstitution">-</p>
          </div>
          <div class="order-info-item">
            <label>No. Kontrak</label>
            <p id="infoContractNo">-</p>
          </div>
        </div>
      </div>

      <!-- Penerimaan -->
      <div id="receiptPanel" class="card-box section-card" style="display:none;">
        <div class="section-head">
          <h4 class="mb-0">Butir Penerimaan Barang</h4>
        </div>

        <div class="row mb-4">
          <div class="col-md-4">
            <label class="form-label">Tarikh Terima</label>
            <input class="form-control date-input" name="received_date" type="text" inputmode="numeric" value="{{ date('d/m/Y') }}" placeholder="dd/mm/yyyy">
          </div>
          <div class="col-md-4">
            <label class="form-label">Diterima Oleh</label>
            <input type="text" class="form-control" name="received_by" value="{{ Auth::user()->name }}" readonly>
          </div>
        </div>

        <div class="items-wrap">
          <div class="p-3" style="background:var(--surface-strong);">
            <div class="row fw-bold text-uppercase small" style="color:var(--muted);">
              <div class="col-1">#</div>
              <div class="col-3">Nama Barang</div>
              <div class="col-2">Unit</div>
              <div class="col-2">Kuantiti Dipesan</div>
              <div class="col-2">Kuantiti Diterima</div>
              <div class="col-1">Catatan</div>
              <div class="col-1 text-center">Salah</div>
            </div>
          </div>
          <div id="itemsContainer">
            <!-- Populated via JS after selecting order -->
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-6">
            <label class="form-label">Catatan Penerimaan</label>
            <textarea class="form-control" name="remarks" id="remarksTextarea" rows="3" placeholder="Sebarang catatan mengenai penerimaan..." maxlength="1250"></textarea>
            <div class="d-flex justify-content-between mt-1">
              <small class="word-counter" id="wordCount">0 / 250 patah perkataan</small>
              <small id="wordWarning" class="text-danger" style="display:none;">Had 250 patah perkataan telah dicapai!</small>
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Status Penerimaan</label>
            <select class="form-select" name="status">
              <option value="Lengkap">Lengkap</option>
              <option value="Sebahagian">Sebahagian</option>
              <option value="Berlebih">Berlebih</option>
              <option value="Rosak">Rosak / Tidak Lengkap</option>
            </select>
          </div>
        </div>

        <div class="action-row">
          <a href="{{ route('borang.penerimaan') }}" class="btn btn-custom" style="background:rgba(255,255,255,.1); color:#fff;">Set Semula</a>
          <button type="submit" class="btn btn-custom" id="submitBtn">Simpan Penerimaan</button>
        </div>
      </div>
    </form>
  </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ms.js"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <script>
    const uomList = @json($uoms);
    const itemSearchUrl = "{{ route('items.search') }}";

    $(document).ready(function() {
      if (typeof flatpickr !== 'undefined') {
        document.querySelectorAll('.date-input').forEach(function(el) {
          flatpickr(el, {
            dateFormat: 'd/m/Y',
            allowInput: true,
            locale: 'ms',
          });
        });
      }

      $('#orderSelect').select2({
        placeholder: '-- Pilih No. Inden --',
        allowClear: true,
        width: '100%'
      });

      $('#orderSelect').on('change', function() {
        const orderId = $(this).val();
        if (!orderId) {
          $('#orderInfoPanel, #receiptPanel').hide();
          $('#itemsContainer').empty();
          return;
        }
        loadOrderDetails(orderId);
      });

      function loadOrderDetails(orderId) {
        $.ajax({
          url: '/borang-penerimaan/' + orderId + '/items',
          method: 'GET',
          success: function(res) {
            if (!res.success) return;
            const data = res.data;
            $('#infoOrderNo').text(data.order_no);
            $('#infoOrderDate').text(data.formatted_date || data.order_date);
            $('#infoSupplier').text(data.supplier_name);
            $('#infoInstitution').text(data.institution_name);
            $('#infoContractNo').text(data.contract_no || '-');
            $('#orderInfoPanel').show();

            let html = '';
            if (data.items && data.items.length > 0) {
              data.items.forEach(function(item, idx) {
                html += `
                    <div class="item-card" data-item-id="${item.id}">
                    <div class="row align-items-center g-2">
                      <div class="col-1"><span class="item-index">${idx + 1}</span></div>
                      <div class="col-3"><strong>${item.name}</strong></div>
                      <div class="col-2">${item.unit || 'Unit'}</div>
                      <div class="col-2">${item.ordered_qty}</div>
                      <div class="col-2">
                        <input type="number" name="items[${item.id}][received_qty]" class="form-control" value="${item.received_qty || 0}" min="0" step="0.01" style="min-height:38px;">
                        <input type="hidden" name="items[${item.id}][item_id]" value="${item.item_id}">
                        <input type="hidden" name="items[${item.id}][ordered_qty]" value="${item.ordered_qty}">
                      </div>
                      <div class="col-1">
                        <input type="text" name="items[${item.id}][remarks]" class="form-control" placeholder="Catatan" style="min-height:38px;">
                      </div>
                      <div class="col-1 text-center">
                        <div class="form-check d-flex justify-content-center">
                          <input class="form-check-input wrong-toggle" type="checkbox" name="items[${item.id}][is_wrong]" value="1">
                        </div>
                      </div>
                    </div>
                    <div class="row g-2 mt-2 wrong-replacement" style="display:none;">
                      <div class="col-md-4">
                        <select name="items[${item.id}][replace_name]" class="form-select replace-item-select" data-placeholder="Cari nama barang gantian" style="min-height:38px;">
                          <option value=""></option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <select name="items[${item.id}][replace_unit]" class="form-select replace-unit-select" style="min-height:38px;">
                          <option value="">-- Pilih Unit --</option>
                          ${uomList.map(u => `<option value="${u.code}">${u.code}</option>`).join('')}
                        </select>
                      </div>
                      <div class="col-md-3">
                        <input type="number" name="items[${item.id}][replace_qty]" class="form-control" placeholder="Kuantiti" min="0" step="0.01" style="min-height:38px;">
                      </div>
                      <div class="col-md-2 d-flex align-items-center">
                        <small class="text-warning">Barang gantian</small>
                      </div>
                    </div>
                  </div>
                `;
              });
            } else {
              html = '<div class="p-4 text-center text-muted">Tiada item ditemui untuk pesanan ini.</div>';
            }
            $('#itemsContainer').html(html);
            $('#receiptPanel').show();
          },
          error: function() {
            alert('Gagal memuatkan data pesanan.');
          }
        });
      }

      // Toggle wrong-item replacement fields
      $(document).on('change', '.wrong-toggle', function() {
        const $card = $(this).closest('.item-card');
        const $panel = $card.find('.wrong-replacement');
        $panel.toggle(this.checked);
        if (this.checked) {
          $card.find('.replace-item-select').each(function() {
            if (!$(this).data('select2')) {
              $(this).select2({
                ajax: {
                  url: itemSearchUrl,
                  dataType: 'json',
                  delay: 250,
                  data: params => ({ q: params.term || '' }),
                  processResults: data => data
                },
                dropdownParent: $card,
                minimumInputLength: 0,
                placeholder: 'Cari nama barang gantian',
                width: '100%'
              });
              $(this).on('select2:select', function(e) {
                const selected = e.params.data;
                const unitSelect = $card.find('.replace-unit-select');
                if (selected.uom && unitSelect.find(`option[value="${selected.uom}"]`).length) {
                  unitSelect.val(selected.uom);
                }
              });
            }
          });
        }
      });

      // Word counter for remarks
      $('#remarksTextarea').on('input', function() {
        const text = $(this).val().trim();
        const words = text ? text.split(/\s+/).filter(w => w.length > 0) : [];
        const count = words.length;
        $('#wordCount').text(count + ' / 250 patah perkataan');
        if (count > 250) {
          $('#wordWarning').show();
          $('#wordCount').addClass('text-danger');
        } else {
          $('#wordWarning').hide();
          $('#wordCount').removeClass('text-danger');
        }
      });

      // Auto-load if preselected
      const preselected = $('#orderSelect').val();
      if (preselected) {
        loadOrderDetails(preselected);
      }
    });
  </script>
    <script src="{{ asset('js/session-timeout.js') }}"></script>
</body>
</html>