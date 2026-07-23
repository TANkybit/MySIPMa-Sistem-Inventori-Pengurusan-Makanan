<!DOCTYPE html>
<html lang="ms" data-bs-theme="light">

<head>
  <script>document.documentElement.setAttribute('data-bs-theme',localStorage.getItem('theme')||'light')</script>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Penilaian Prestasi Pembekal - MySIPMa</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

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
    .logo-glow:hover { filter: brightness(170%); transform: scale(1.02); }

    .page-container { padding: 60px 0; flex: 1; }
    .page-header { margin-bottom: 40px; }
    .page-header h1 { font-weight: 800; font-size: 2.5rem; margin-bottom: 10px; }

    [data-bs-theme="light"] body { background:#f8f9fa; color:#111827; }
    [data-bs-theme="light"] h1,[data-bs-theme="light"] h2,[data-bs-theme="light"] h3,[data-bs-theme="light"] h4 { color:#111827; }
    [data-bs-theme="light"] .card-form { background:#fff; border-color:#e5e7eb; }
    [data-bs-theme="light"] #header { background:rgba(255,255,255,.8) !important; border-bottom:1px solid #e5e7eb !important; }

    .card-form {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 24px;
      padding: 30px;
      box-shadow: 0 18px 48px rgba(0, 0, 0, .3);
    }

    .criteria-table th, .criteria-table td {
      border-color: var(--border);
      color: var(--text);
    }

    [data-bs-theme="light"] .criteria-table th,
    [data-bs-theme="light"] .criteria-table td { color: #111827; }
    [data-bs-theme="light"] .criteria-table th { background: #f3f4f6; }
    [data-bs-theme="light"] .criteria-table { border-color: #e5e7eb; }

    .score-display { min-width: 30px; text-align: center; font-size: 1.25rem; }

    .rating-badge {
      padding: 8px 24px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 1.1rem;
    }

    .form-label-custom {
      font-weight: 600;
      font-size: 0.85rem;
      margin-bottom: 4px;
    }

    .summary-card {
      background: var(--surface-soft);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 20px;
    }

    [data-bs-theme="light"] .summary-card { background: #f8f9fa; border-color: #e5e7eb; }

    @media (min-width: 1200px) {
      .header .container > .logo-glow,
      .header .container > .d-xl-flex { position: relative; z-index: 2; }
      .header .navmenu { position: relative; flex: 1; text-align: center; }
      .navmenu a { color: #ffffff !important; }
      .navmenu a:hover, .navmenu a.active { color: #10b981 !important; }
      .text-white-50:hover { color: #10b981 !important; }
    }
  </style>
</head>

<body>

  <header id="header" class="header d-flex align-items-center sticky-top"
    style="background: rgba(2,2,4,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container d-flex align-items-center">
      <a href="{{ route('user.dashboard') }}" class="logo-glow d-flex align-items-center">
        <img src="{{ asset('frontend/Nexa/assets/img/WORDINGMYSIPMA2.png') }}" style="height: 55px; width: auto;" alt="MySIPMa logo">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('user.dashboard') }}">Papan Pemuka</a></li>
          <li><a href="{{ route('user.senarai.inden') }}">Senarai Inden</a></li>
          <li><a href="{{ route('user.inventori') }}">Inventori</a></li>
          @if(Auth::user()->hasPermission('pengesahan_inden'))
          <li><a href="{{ route('user.pengesahan.inden') }}">Pengesahan Inden</a></li>
          @endif
          @if(Auth::user()->hasPermission('borang_inden'))
          <li><a href="{{ route('borang.inden') }}">Borang Inden</a></li>
          @endif
          @if(Auth::user()->hasPermission('penerimaan_inden'))
          <li><a href="{{ route('borang.penerimaan') }}">Penerimaan</a></li>
          @endif
          @if(Auth::user()->hasPermission('penilaian_prestasi'))
          <li><a href="{{ route('user.penilaian_prestasi') }}" class="active">Penilaian Prestasi</a></li>
          @endif
          <li class="d-xl-none"><a href="{{ route('profile') }}">Profil</a></li>
          <li class="d-xl-none"><a href="#" id="navLogoutBtn" class="text-danger">Log Keluar</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-none d-xl-flex align-items-center gap-3">
        @if(Auth::user()->hasPermission('pengesahan_inden'))
        <a href="{{ route('user.pengesahan.inden') }}" class="position-relative text-white fs-5 me-3"
          style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color=''">
          <i class="bi bi-bell-fill"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            {{ $pendingApprovals ?? 0 }}
          </span>
        </a>
        @endif
        @if(Auth::user()->hasPermission('penerimaan_inden'))
        <a href="{{ route('borang.penerimaan') }}" class="position-relative text-white fs-5 me-3"
          style="transition: color 0.3s;" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color=''">
          <i class="bi bi-truck"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            {{ $pendingPenerimaan ?? 0 }}
          </span>
        </a>
        @endif
        <button class="btn btn-icon" id="themeToggle" style="background:none;border:none;color:var(--text);font-size:1.2rem;padding:4px 8px"><i class="bi bi-moon-fill"></i></button>
        <a href="{{ route('profile') }}" class="text-white-50 text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color=''"><i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name ?? 'Pengguna' }}</a>
        <button type="button" class="btn btn-custom btn-logout btn-sm px-3 py-2" id="desktopLogoutBtn"><i class="bi bi-box-arrow-right me-2"></i>Log Keluar</button>
      </div>
    </div>
  </header>

  <main class="page-container">
    <div class="container" data-aos="fade-up">

      <div class="page-header text-center">
        <h1>Penilaian Prestasi Pembekal</h1>
        <p class="muted">Borang Penilaian Prestasi Pembekal (BK-PSPK-09-03)</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-10">

          <div id="alertContainer"></div>

          <div class="card-form">
            <form id="evaluationForm">
              @csrf
              <!-- Order Selection -->
              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label-custom">No. Inden / Pesanan</label>
                  <select class="form-select" name="order_id" id="evalOrderId" required>
                    <option value="">Pilih Pesanan</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label-custom">Tarikh Penilaian</label>
                  <input type="date" class="form-control" name="evaluation_date" value="{{ date('Y-m-d') }}" required>
                </div>
              </div>

              <!-- Supplier Info -->
              <div id="evalSupplierInfo" class="alert d-none mb-4" style="background:var(--surface-soft);border:1px solid var(--border);border-radius:12px;">
                <div class="row align-items-center">
                  <div class="col-md-4">
                    <div class="small text-muted">Pembekal</div>
                    <div id="evalSupplierName" class="fw-bold fs-6">-</div>
                    <input type="hidden" name="supplier_id" id="evalSupplierId">
                  </div>
                  <div class="col-md-4">
                    <div class="small text-muted">Institusi</div>
                    <div id="evalInstitutionName" class="fw-bold fs-6">-</div>
                    <input type="hidden" name="institution_id" id="evalInstitutionId">
                  </div>
                  <div class="col-md-4">
                    <div class="small text-muted">Nama Penilai</div>
                    <input type="text" class="form-control form-control-sm mt-1 bg-transparent" name="evaluator_name" value="{{ Auth::user()->name }}" readonly>
                  </div>
                </div>
              </div>

              <!-- Criteria Table -->
              <div class="table-responsive">
                <table class="table table-bordered align-middle text-center criteria-table">
                  <thead>
                    <tr>
                      <th style="width: 50%" class="text-start py-3 ps-3">Kriteria Penilaian</th>
                      <th style="width: 50%" class="py-3">Skala (1 - 7)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-start ps-3">
                        <div class="fw-bold">1. Kuantiti Bekalan</div>
                        <div class="small text-muted">Mencukupi dan mengikut pesanan</div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center justify-content-center gap-3 px-3">
                          <input type="range" class="form-range slider-score" min="1" max="7" step="1" name="criteria_quantity" value="4" style="max-width:250px;">
                          <span class="fw-bold score-display" id="score_quantity">4</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-start ps-3">
                        <div class="fw-bold">2. Masa Penghantaran</div>
                        <div class="small text-muted">Menepati masa yang ditetapkan</div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center justify-content-center gap-3 px-3">
                          <input type="range" class="form-range slider-score" min="1" max="7" step="1" name="criteria_delivery" value="4" style="max-width:250px;">
                          <span class="fw-bold score-display" id="score_delivery">4</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-start ps-3">
                        <div class="fw-bold">3. Harga Bekalan</div>
                        <div class="small text-muted">Berpatutan dan kompetitif</div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center justify-content-center gap-3 px-3">
                          <input type="range" class="form-range slider-score" min="1" max="7" step="1" name="criteria_price" value="4" style="max-width:250px;">
                          <span class="fw-bold score-display" id="score_price">4</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-start ps-3">
                        <div class="fw-bold">4. Kualiti Bekalan</div>
                        <div class="small text-muted">Bahan mentah segar dan berkualiti</div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center justify-content-center gap-3 px-3">
                          <input type="range" class="form-range slider-score" min="1" max="7" step="1" name="criteria_quality" value="4" style="max-width:250px;">
                          <span class="fw-bold score-display" id="score_quality">4</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-start ps-3">
                        <div class="fw-bold">5. Kerjasama</div>
                        <div class="small text-muted">Responsif dan mudah dihubungi</div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center justify-content-center gap-3 px-3">
                          <input type="range" class="form-range slider-score" min="1" max="7" step="1" name="criteria_cooperation" value="4" style="max-width:250px;">
                          <span class="fw-bold score-display" id="score_cooperation">4</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Summary & Remarks -->
              <div class="row mt-4 g-3">
                <div class="col-md-6">
                  <div class="summary-card h-100">
                    <h6 class="fw-bold mb-3">Ringkasan Skor</h6>
                    <div class="d-flex justify-content-between mb-2">
                      <span class="text-muted">Jumlah Skor:</span>
                      <span class="fw-bold fs-5" id="evalTotalScore">20 / 35</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <span class="text-muted">Peratusan:</span>
                      <span class="fw-bold fs-4" style="color:var(--accent);" id="evalPercentage">57.1%</span>
                    </div>
                    <div class="text-center">
                      <span class="rating-badge" id="evalRatingBadge" style="background-color: #ffc107; color: #000;">SEDERHANA</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="summary-card h-100">
                    <div class="mb-3">
                      <label class="form-label-custom">Pegawai Penilai</label>
                      <input type="text" class="form-control bg-transparent" name="evaluator_name" value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div>
                      <label class="form-label-custom">Ulasan / Catatan</label>
                      <textarea class="form-control" name="remarks" rows="3" placeholder="Masukkan ulasan tambahan jika perlu..."></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Submit -->
              <div class="text-center mt-4">
                <button type="button" class="btn btn-lg px-5 py-3" id="saveEvaluationBtn"
                  style="background: var(--accent); color: #fff; border: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem;">
                  <i class="bi bi-check2-circle me-2"></i>Hantar Penilaian
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>

    </div>
  </main>

  <!-- Success Modal -->
  <div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background:var(--surface);border:1px solid var(--border);border-radius:20px;">
        <div class="modal-body text-center py-5">
          <div class="mb-3">
            <i class="bi bi-check-circle-fill" style="font-size:4rem;color:var(--accent);"></i>
          </div>
          <h4 class="fw-bold mb-2">Penilaian Berjaya!</h4>
          <p class="text-muted mb-4" id="successMessage">Penilaian prestasi pembekal telah berjaya dihantar.</p>
          <button type="button" class="btn btn-lg px-4" id="successOkBtn" style="background:var(--accent);color:#fff;border:none;border-radius:12px;font-weight:600;">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Logout Confirmation Modal -->
  <div class="modal fade" id="logoutConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content" style="background:var(--surface);border:1px solid var(--border);border-radius:20px;">
        <div class="modal-body text-center py-4">
          <i class="bi bi-box-arrow-right fs-1 text-danger mb-3 d-block"></i>
          <h5 class="fw-bold mb-2">Log Keluar</h5>
          <p class="text-muted small mb-4">Anda pasti ingin log keluar?</p>
          <div class="d-flex gap-2 justify-content-center">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
              @csrf
              <button type="submit" class="btn btn-danger px-4">Log Keluar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Theme toggle
    document.getElementById('themeToggle')?.addEventListener('click', function() {
      const html = document.documentElement;
      const theme = html.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light';
      html.setAttribute('data-bs-theme', theme);
      localStorage.setItem('theme', theme);
      this.querySelector('i').className = theme === 'light' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
    });

    // Initialize theme icon
    (function initThemeIcon() {
      const theme = document.documentElement.getAttribute('data-bs-theme');
      const btn = document.getElementById('themeToggle');
      if (btn) {
        btn.querySelector('i').className = theme === 'light' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
      }
    })();

    function getScoreLabel(val) {
      if (val >= 6) return 'Cemerlang';
      if (val >= 5) return 'Sangat Baik';
      if (val >= 3) return 'Baik';
      if (val >= 2) return 'Sederhana';
      return 'Lemah';
    }

    function getScoreColor(val) {
      if (val >= 6) return '#059669';
      if (val >= 5) return '#10b981';
      if (val >= 3) return '#eab308';
      if (val >= 2) return '#f59e0b';
      return '#ef4444';
    }

    // Sliders score
    function initSliders() {
      document.querySelectorAll('.slider-score').forEach(slider => {
        const id = slider.getAttribute('name').replace('criteria_', 'score_');
        const display = document.getElementById(id);
        if (display) {
          const val = parseInt(slider.value);
          display.textContent = val;
          display.style.color = getScoreColor(val);
          display.title = getScoreLabel(val);
        }
        slider.addEventListener('input', function() {
          const val = parseInt(this.value);
          if (display) {
            display.textContent = val;
            display.style.color = getScoreColor(val);
            display.title = getScoreLabel(val);
          }
          calculateScore();
        });
      });
    }

    function calculateScore() {
      const qty = parseInt(document.querySelector('input[name="criteria_quantity"]').value) || 0;
      const del = parseInt(document.querySelector('input[name="criteria_delivery"]').value) || 0;
      const pri = parseInt(document.querySelector('input[name="criteria_price"]').value) || 0;
      const qlty = parseInt(document.querySelector('input[name="criteria_quality"]').value) || 0;
      const coop = parseInt(document.querySelector('input[name="criteria_cooperation"]').value) || 0;

      const total = qty + del + pri + qlty + coop;
      const percentage = ((total / 35) * 100).toFixed(1);

      document.getElementById('evalTotalScore').textContent = total + ' / 35';
      document.getElementById('evalPercentage').textContent = percentage + '%';

      const badge = document.getElementById('evalRatingBadge');
      if (percentage >= 81) {
        badge.textContent = 'CEMERLANG';
        badge.style.background = '#1a5632';
        badge.style.color = '#fff';
      } else if (percentage >= 51) {
        badge.textContent = 'SEDERHANA';
        badge.style.background = '#f59e0b';
        badge.style.color = '#000';
      } else {
        badge.textContent = 'LEMAH';
        badge.style.background = '#ef4444';
        badge.style.color = '#fff';
      }
    }

    // Load orders
    async function loadOrders() {
      try {
        const res = await fetch('/evaluations/orders');
        const json = await res.json();
        if (json.success) {
          const select = document.getElementById('evalOrderId');
          select.innerHTML = '<option value="">Pilih Pesanan</option>';
          window.evaluationOrders = json.data;
          json.data.forEach(order => {
            const opt = document.createElement('option');
            opt.value = order.id;
            opt.textContent = order.order_number + ' (' + order.order_date + ')';
            select.appendChild(opt);
          });
        }
      } catch (err) {
        console.error('Error loading orders:', err);
        showAlert('danger', 'Gagal memuatkan senarai pesanan.');
      }
    }

    function showAlert(type, message) {
      const container = document.getElementById('alertContainer');
      const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
      container.innerHTML = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
      setTimeout(() => { container.innerHTML = ''; }, 5000);
    }

    // Order select change
    document.addEventListener('DOMContentLoaded', function() {
      initSliders();
      loadOrders();
      calculateScore();

      document.getElementById('evalOrderId').addEventListener('change', function() {
        const orderId = this.value;
        if (!orderId) {
          document.getElementById('evalSupplierInfo').classList.add('d-none');
          return;
        }
        const order = (window.evaluationOrders || []).find(o => o.id == orderId);
        if (order) {
          document.getElementById('evalSupplierName').textContent = order.supplier ? order.supplier.company_name : '-';
          document.getElementById('evalSupplierId').value = order.supplier_id || '';
          document.getElementById('evalInstitutionName').textContent = order.institution ? order.institution.name : '-';
          document.getElementById('evalInstitutionId').value = order.institution_id || '';
          document.getElementById('evalSupplierInfo').classList.remove('d-none');
        } else {
          document.getElementById('evalSupplierInfo').classList.add('d-none');
        }
      });

      // Save
      document.getElementById('saveEvaluationBtn').addEventListener('click', async function() {
        const form = document.getElementById('evaluationForm');
        if (!form.checkValidity()) {
          form.reportValidity();
          return;
        }

        const formData = new FormData(form);
        const originalContent = this.innerHTML;
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghantar...';
        this.disabled = true;

        try {
          const response = await fetch('/evaluations', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
              'Accept': 'application/json'
            },
            body: formData
          });

          const result = await response.json();
          if (result.success) {
            const msg = result.message || 'Penilaian prestasi pembekal berjaya dihantar.';
            document.getElementById('successMessage').textContent = msg;
            new bootstrap.Modal(document.getElementById('successModal')).show();
            form.reset();
            document.getElementById('evalSupplierInfo').classList.add('d-none');
            calculateScore();
            loadOrders();
          } else {
            const errorMsg = result.errors ? Object.values(result.errors).flat().join('\n') : (result.message || 'Ralat menyimpan penilaian.');
            showAlert('danger', errorMsg);
          }
        } catch (error) {
          console.error('Error:', error);
          showAlert('danger', 'Ralat sistem ketika menyimpan penilaian.');
        } finally {
          this.innerHTML = originalContent;
          this.disabled = false;
        }
      });

      // Success modal close
      document.getElementById('successOkBtn').addEventListener('click', function() {
        bootstrap.Modal.getInstance(document.getElementById('successModal')).hide();
      });
    });

    // Logout
    document.querySelectorAll('#navLogoutBtn, #desktopLogoutBtn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        new bootstrap.Modal(document.getElementById('logoutConfirmModal')).show();
      });
    });
  </script>

</body>
</html>