<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
  <script>document.documentElement.setAttribute('data-bs-theme',localStorage.getItem('theme')||'light')</script>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Kemaskini</title>

  <link href="{{ url('frontend/assets/img/LOGOMYSIPMA.png') }}" rel="icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <link href="{{ asset('frontend/Nexa/assets/css/main2.css') }}" rel="stylesheet">
  <link href="{{ asset('css/user-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/css/index.css') }}" rel="stylesheet">

  <style>
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

    .btn-custom {
      background: #10b981;
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

    .profile-nav-link.active {
      color: #10b981 !important;
    }

    /* Full height layout */
    html, body {
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    /* Background Particle Layer */
    #particle-canvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
      pointer-events: none;
    }

    /* Foreground Content Layer */
    body > .container {
      position: relative;
      z-index: 2;
    }

    .profile-view-container {
      position: relative;
      z-index: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: calc(100vh - 80px);
      padding: 10px;
    }

    .profile-view-container > h1 {
      color: #ffffff;
      margin-bottom: 30px;
      font-weight: 700;
      text-align: center;
    }

    /* Glassmorphism Card */
    .profile-card {
      background: rgba(255, 255, 255, 0.2) !important;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 16px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
      padding: 16px 20px;
      color: #ffffff;
      width: 100%;
      max-width: 640px;
    }

    /* Tab Navigation */
    .tab-nav {
      display: flex;
      gap: 12px;
      margin-bottom: 12px;
      border-bottom: 2px solid rgba(255, 255, 255, 0.1);
      padding-bottom: 8px;
    }

    .tab-button {
      background: none;
      border: none;
      color: rgba(255, 255, 255, 0.6);
      padding: 0 4px;
      cursor: pointer;
      font-weight: 600;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: 0.3s;
      border-bottom: 2px solid transparent;
      position: relative;
      bottom: -10px;
    }

    .tab-button:hover {
      color: rgba(255, 255, 255, 0.9);
    }

    .tab-button.active {
      color: #62e2ff;
      border-bottom-color: #62e2ff;
    }

    .tab-panel {
      display: none;
    }

    .tab-panel.active {
      display: block;
    }

    .tab-panel > h3 {
      color: #10b981 !important;
      margin-bottom: 10px;
      text-align: center;
      font-weight: 700;
    }

    /* Profile Layout for Forms */
    .profile-layout {
      display: flex;
      gap: 12px;
      margin-bottom: 10px;
      align-items: flex-start;
    }

    .profile-left {
      flex: 0 0 70px;
      display: flex;
      flex-direction: column;
      gap: 6px;
      align-items: center;
    }

    #avatarPreviu {
      width: 70px;
      height: 70px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.1);
      border: 2px dashed rgba(98, 226, 255, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(255, 255, 255, 0.6);
      font-size: 9px;
      overflow: hidden;
      text-align: center;
      padding: 4px;
      min-height: 70px;
    }

    #avatarPreviu img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .custom-file-label {
      background: linear-gradient(135deg, #00b894, #00d2a3);
      color: white;
      padding: 5px 10px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      transition: 0.3s;
      display: block;
      text-align: center;
      font-size: 12px;
      width: 100%;
    }

    .custom-file-label:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 184, 148, 0.3);
    }

    #avatarInput {
      display: none;
    }

    .profile-right {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .form-group label {
      color: rgba(255, 255, 255, 0.8);
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      background: rgba(255, 255, 255, 0.95) !important;
      border: none;
      border-radius: 6px;
      padding: 5px 10px;
      color: #1a1a1a;
      font-size: 14px;
      transition: 0.3s;
      font-family: 'Montserrat', sans-serif;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(98, 226, 255, 0.2);
      background: rgba(255, 255, 255, 1) !important;
    }

    .form-group input:read-only {
      background: rgba(255, 255, 255, 0.6) !important;
      color: rgba(26, 26, 26, 0.6);
      cursor: not-allowed;
    }

    /* Password Input Wrapper */
    .password-input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .password-input-wrapper input {
      width: 100%;
      padding-right: 30px;
    }

    .password-toggle-btn {
      position: absolute;
      right: 8px;
      background: none;
      border: none;
      color: #999;
      cursor: pointer;
      font-size: 0.8rem;
      padding: 0.15rem 0.3rem;
      transition: color 0.3s ease;
    }

    .password-toggle-btn:hover {
      color: #00b894;
    }

    .strength-indicator {
      font-size: 10px;
      padding: 2px 0;
      font-weight: 600;
    }

    .strength-indicator.weak {
      color: #ff6b6b;
    }

    .strength-indicator.medium {
      color: #ffa502;
    }

    .strength-indicator.strong {
      color: #62e2ff;
    }

    .strength-indicator.very-strong {
      color: #00b894;
    }

    .button-container {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-top: 8px;
      width: 100%;
    }

    .button-container button,
    .tab-panel > button {
      background: linear-gradient(135deg, #00b894, #00d2a3) !important;
      color: white;
      padding: 8px 28px !important;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 14px;
      transition: 0.3s;
      cursor: pointer;
      box-shadow: 0 8px 20px rgba(0, 184, 148, 0.3);
    }

    .button-container button:hover,
    .tab-panel > button:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(0, 184, 148, 0.5);
    }

    #statusMsg {
      margin-top: 15px;
      padding: 12px 20px;
      border-radius: 8px;
      text-align: center;
      font-weight: 600;
      display: none;
    }

    #statusMsg.success {
      display: block;
      background: rgba(0, 184, 148, 0.2);
      border: 1px solid #00b894;
      color: #00d2a3;
    }

    #statusMsg.error {
      display: block;
      background: rgba(255, 71, 87, 0.2);
      border: 1px solid #ff4757;
      color: #ff6b7a;
    }

/* Footer Styling */
    #footer {
      position: relative;
      z-index: 100;
      background: #222426 !important;
      margin-top: 20px;
      padding: 20px 0 10px 0;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    #footer .address {
      margin-bottom: 10px;
    }

    #footer h4 {
      color: #ffffff;
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 13px;
    }

    #footer p {
      color: rgba(255, 255, 255, 0.7);
      font-size: 11px;
      line-height: 1.4;
    }

    #footer .icon {
      font-size: 18px;
      margin-bottom: 8px;
      color: #62e2ff;
      margin-right: 10px;
    }

    #footer .social-links {
      gap: 8px;
    }

    #footer .social-links a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 30px;
      height: 30px;
      background: rgba(98, 226, 255, 0.1);
      border: 1px solid rgba(98, 226, 255, 0.3);
      border-radius: 50%;
      color: #62e2ff;
      font-size: 12px;
      transition: 0.3s;
    }

    #footer .social-links a:hover {
      background: rgba(98, 226, 255, 0.2);
      border-color: #62e2ff;
      transform: translateY(-3px);
    }

    #footer .copyright {
      color: rgba(255, 255, 255, 0.6);
      font-size: 11px;
      padding-top: 10px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    #footer .copyright p {
      margin: 0;
    }

    #footer .sitename {
      color: #62e2ff;
      font-weight: 600;
    }

    #footer a {
      color: #62e2ff;
      text-decoration: none;
      transition: 0.3s;
    }

    #footer a:hover {
      color: #ffffff;
    }

    @media (max-width: 768px) {
      .profile-layout {
        flex-direction: column;
        gap: 8px;
        align-items: center;
      }

      .profile-left {
        flex: 0 0 auto;
      }

      .profile-right {
        width: 100%;
      }

      .profile-card {
        padding: 12px;
      }

      .tab-nav {
        flex-wrap: wrap;
      }

      .button-container {
        flex-wrap: wrap;
      }
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top"
    style="background: rgba(2,2,4,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ route('index') }}" class="logo-glow d-flex align-items-center me-auto me-xl-0">
        <img src="{{ asset('frontend/Nexa/assets/img/WORDINGMYSIPMA2.png') }}" style="height: 55px; width: auto;"
          alt="MySIPMa logo">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          @if(Auth::user()->role?->role_name === 'admin hq')
          <li><a href="{{ route('admin.dashboard') }}"
              class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
          @else
          <li><a href="{{ route('user.dashboard') }}"
              class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a></li>
          @endif
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
        <a href="{{ route('profile') }}" class="profile-nav-link active text-decoration-none" style="transition: color 0.3s;"><i
            class="bi bi-person-circle me-2"></i>{{ Auth::user()->name ?? 'Pengguna' }}</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-custom btn-logout btn-sm px-3 py-2"><i
              class="bi bi-box-arrow-right me-2"></i>Log Keluar</button>
        </form>
      </div>
    </div>
  </header>
  
    <div id="particle-canvas"></div>
    <div class="container profile-view-container">

        <div class="profile-card">
            <!-- Navigasi Tab -->
            <div class="tab-nav">
            <button class="tab-button active" onclick="switchTab('profil', this)">Profil</button>
            <button class="tab-button" onclick="switchTab('laluan', this)">Kata Laluan</button>
            </div>

            <!-- PANEL PROFIL -->
            <div id="panel-profil" class="tab-panel active">
            <h3>Kemaskini Profil</h3>
            
            <div class="profile-layout">
                <!-- Bahagian Kiri -->
                <div class="profile-left">
                <div id="avatarPreviu">(Tiada gambar dipilih)</div>
                <label for="avatarInput" class="custom-file-label">Pilih Gambar</label>
                <input type="file" id="avatarInput" accept="image/*" onchange="previewAvatar(event)">
                </div>

                <!-- Bahagian Kanan -->
                <div class="profile-right">
                <div class="form-group">
                    <label>Nama:</label>
                    <input type="text" id="namaInput" placeholder="Masukkan nama anda">
                </div>

                <div class="form-group">
                    <label>Emel:</label>
                    <input type="email" id="emailInput" placeholder="Masukkan emel anda" readonly>
                </div>

                <div class="form-group">
                    <label>Institusi:</label>
                    <select id="institusiInput" required>
                        <option value="">-- Pilih Institusi --</option>
                        @foreach($institutions as $inst)
                            <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Jawatan:</label>
                    <input type="text" id="jawatanInput" readonly>
                </div>
                
                <div class="form-group">
                    <label>Peranan:</label>
                    <input type="text" id="perananInput" placeholder="Masukkan peranan anda" readonly>
                </div>

                <div class="form-group">
                    <label>Telefon:</label>
                    <input type="tel" id="telefonInput" placeholder="Masukkan no. telefon anda">
                </div>

                <div class="form-group">
                    <label>Alamat:</label>
                    <input type="text" id="alamatInput" readonly>
                </div>
                </div>
            </div>

                <div class="button-container">
                    <button onclick="handleUpdateProfile()">Kemaskini</button>
                </div>
                </div>

            <!-- PANEL KATA LALUAN -->
            <div id="panel-laluan" class="tab-panel">
            <h3>Tukar Kata Laluan</h3>
            
            <div class="form-group">
                <label>Kata Laluan Asal:</label>
                <div class="password-input-wrapper">
                  <input type="password" id="oldPass" placeholder="Masukkan kata laluan asal">
                  <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('oldPass')"><i class="fas fa-eye"></i></button>
                </div>
            </div>

            <div class="form-group">
                <label>Kata Laluan Baru:</label>
                <div class="password-input-wrapper">
                  <input type="password" id="newPass" oninput="checkStrength(this.value)" placeholder="Masukkan kata laluan baru">
                  <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('newPass')"><i class="fas fa-eye"></i></button>
                </div>
                <div id="strengthText" class="strength-indicator">Kekuatan: -</div>
            </div>

            <div class="form-group">
                <label>Sahkan Kata Laluan:</label>
                <div class="password-input-wrapper">
                  <input type="password" id="confirmPass" placeholder="Sahkan kata laluan baru">
                  <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('confirmPass')"><i class="fas fa-eye"></i></button>
                </div>
            </div>

            <button onclick="handleSetPassword()" style="width: 100%; margin-top: 8px; padding: 8px 28px; font-size: 14px; border-radius: 6px;">Tetapkan</button>
            </div>

            <!-- Notifikasi -->
            <div id="statusMsg"></div>
        </div>
    </div>

  <script>
    /* Particle Network Logic */
    !function(a){var b="object"==typeof self&&self.self===self&&self||"object"==typeof global&&global.global===global&&global;"function"==typeof define&&define.amd?define(["exports"],function(c){b.ParticleNetwork=a(b,c)}):"object"==typeof module&&module.exports?module.exports=a(b,{}):b.ParticleNetwork=a(b,{})}(function(a,b){var c=function(a){this.canvas=a.canvas,this.g=a.g,this.particleColor=a.options.particleColor,this.x=Math.random()*this.canvas.width,this.y=Math.random()*this.canvas.height,this.velocity={x:(Math.random()-.5)*a.options.velocity,y:(Math.random()-.5)*a.options.velocity}};return c.prototype.update=function(){(this.x>this.canvas.width+20||this.x<-20)&&(this.velocity.x=-this.velocity.x),(this.y>this.canvas.height+20||this.y<-20)&&(this.velocity.y=-this.velocity.y),this.x+=this.velocity.x,this.y+=this.velocity.y},c.prototype.h=function(){this.g.beginPath(),this.g.fillStyle=this.particleColor,this.g.globalAlpha=.7,this.g.arc(this.x,this.y,1.5,0,2*Math.PI),this.g.fill()},b=function(a,b){this.i=a,this.i.size={width:this.i.offsetWidth,height:this.i.offsetHeight},b=void 0!==b?b:{},this.options={particleColor:void 0!==b.particleColor?b.particleColor:"#fff",background:void 0!==b.background?b.background:"#1a252f",interactive:void 0!==b.interactive?b.interactive:!0,velocity:this.setVelocity(b.speed),density:this.j(b.density)},this.init()},b.prototype.init=function(){this.k=document.createElement("div"),this.i.appendChild(this.k),this.l(this.k,{position:"absolute",top:0,left:0,bottom:0,right:0,"z-index":1}),this.l(this.k,{background:this.options.background}),this.canvas=document.createElement("canvas"),this.i.appendChild(this.canvas),this.g=this.canvas.getContext("2d"),this.canvas.width=this.i.size.width,this.canvas.height=this.i.size.height,this.l(this.canvas,{"z-index":"5",position:"relative"}),this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/ this.options.density;a++)this.o.push(new c(this));requestAnimationFrame(this.update.bind(this))},b.prototype.update=function(){this.g.clearRect(0,0,this.canvas.width,this.canvas.height);for(var a=0;a<this.o.length;a++){this.o[a].update(),this.o[a].h();for(var b=this.o.length-1;b>a;b--){var c=Math.sqrt(Math.pow(this.o[a].x-this.o[b].x,2)+Math.pow(this.o[a].y-this.o[b].y,2));c>120||(this.g.beginPath(),this.g.strokeStyle=this.options.particleColor,this.g.globalAlpha=(120-c)/120,this.g.lineWidth=.7,this.g.moveTo(this.o[a].x,this.o[a].y),this.g.lineTo(this.o[b].x,this.o[b].y),this.g.stroke())}}requestAnimationFrame(this.update.bind(this))},b.prototype.setVelocity=function(a){return"fast"===a?1:"slow"===a?.33:0.66},b.prototype.j=function(a){return"high"===a?5e3:1e4},b.prototype.l=function(a,b){for(var c in b)a.style[c]=b[c]},b});

    // Variable untuk track status message timeout
    let statusTimeout = null;

    // Initialize particles after DOM is ready
    function initializeParticles() {
      const particleCanvas = document.getElementById('particle-canvas');
      if (particleCanvas && particleCanvas.offsetWidth > 0 && particleCanvas.offsetHeight > 0) {
        var themeAttr = document.documentElement.getAttribute('data-bs-theme') || 'light';
        new ParticleNetwork(particleCanvas, {
          particleColor: '#62e2ff',
          background: themeAttr === 'light' ? '#e9ecef' : '#000000',
          interactive: true,
          speed: '2',
          density: '8000'
        });
      } else {
        // Retry if dimensions aren't available yet
        setTimeout(initializeParticles, 100);
      }
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initializeParticles);
    } else {
      initializeParticles();
    }

    // Load existing profile data on page load
    function loadProfileData() {
      fetch('{{ route("profile.me") }}')
        .then(response => response.json())
        .then(data => {
          document.getElementById('namaInput').value = data.name || '';
          document.getElementById('emailInput').value = data.email || '';
          document.getElementById('institusiInput').value = data.institution_id || '';
          document.getElementById('jawatanInput').value = data.position_name || '';
          document.getElementById('perananInput').value = (data.username || '').replace(/\b\w/g, c => c.toUpperCase());
          document.getElementById('telefonInput').value = data.phone_number || '';
          document.getElementById('alamatInput').value = data.full_address || '';
          
          // Display avatar if exists
          if (data.avatar_url) {
            document.getElementById('avatarPreviu').innerHTML = '<img src="' + data.avatar_url + '" alt="Current Avatar">';
          }
        })
        .catch(err => console.log('Error loading profile:', err));
    }

    document.addEventListener('DOMContentLoaded', loadProfileData);

    if (typeof AOS !== 'undefined') {
      AOS.init();
    }

    function switchTab(id, button) {
      // Hide all panels
      document.getElementById('panel-profil').classList.remove('active');
      document.getElementById('panel-laluan').classList.remove('active');
      
      // Remove active class from all buttons
      document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
      });

      // Show selected panel
      document.getElementById('panel-' + id).classList.add('active');
      
      // Add active class to clicked button
      button.classList.add('active');
    }

    function previewAvatar(e) {
      const file = e.target.files[0];
      const previewDiv = document.getElementById('avatarPreviu');
      
      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          previewDiv.innerHTML = '<img src="' + event.target.result + '" alt="Avatar Preview">';
        };
        reader.readAsDataURL(file);
      } else {
        previewDiv.textContent = '(Tiada gambar dipilih)';
      }
    }

    function showStatus(msg, type = 'info') {
      const statusDiv = document.getElementById('statusMsg');
      
      // Clear existing timeout jika ada
      if (statusTimeout) {
        clearTimeout(statusTimeout);
      }
      
      statusDiv.textContent = msg;
      statusDiv.className = type;
      
      // Set timeout 6 detik (6000ms) sebelum hilang
      statusTimeout = setTimeout(() => {
        statusDiv.textContent = '';
        statusDiv.className = '';
        statusTimeout = null;
      }, 6000);
    }

    function togglePasswordVisibility(inputId) {
      const input = document.getElementById(inputId);
      const button = event.target.closest('.password-toggle-btn');
      const icon = button.querySelector('i');
      
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

    function validatePassword(password) {
  const missingRequirements = [];
  
  if (password.length < 8) {
    missingRequirements.push('8 aksara');
  }
  if (!/[a-z]/.test(password)) {
    missingRequirements.push('1 huruf kecil');
  }
  if (!/[A-Z]/.test(password)) {
    missingRequirements.push('1 huruf besar');
  }
  if (!/[0-9]/.test(password)) {
    missingRequirements.push('1 angka');
  }
  if (!/[!@#$%^&*]/.test(password)) {
    missingRequirements.push('1 simbol (!@#$%^&*)');
  }
  
  // Jika tiada error, pulangkan array kosong
  if (missingRequirements.length === 0) {
    return [];
  }
  
  // Gabungkan senarai kekurangan dengan perkataan 'Sekurang-kurangnya' di hadapan
  return [`Sekurang-kurangnya ${missingRequirements.join(', ')}`];
}

    function checkStrength(val) {
      const strengthDiv = document.getElementById('strengthText');
      let strength = 'Lemah';
      let className = 'weak';

      if (val.length >= 8) {
        strength = 'Sederhana';
        className = 'medium';
      }
      if (val.length >= 10 && /[0-9]/.test(val) && /[A-Z]/.test(val) && /[a-z]/.test(val)) {
        strength = 'Kuat';
        className = 'strong';
      }
      if (/[!@#$%^&*]/.test(val) && /[0-9]/.test(val) && /[A-Z]/.test(val) && /[a-z]/.test(val)) {
        strength = 'Sangat Kuat';
        className = 'very-strong';
      }

      strengthDiv.textContent = 'Kekuatan: ' + strength;
      strengthDiv.className = 'strength-indicator ' + className;
    }

    function handleUpdateProfile() {
      const nama = document.getElementById('namaInput').value.trim();
      const institusi_id = document.getElementById('institusiInput').value;
      const telefon = document.getElementById('telefonInput').value.trim();
      const avatarFile = document.getElementById('avatarInput').files[0];
      
      if (!nama) {
        showStatus('Sila isi nama!', 'error');
        return;
      }
      if (!institusi_id) {
        showStatus('Sila isi institusi!', 'error');
        return;
      }
      if (!telefon) {
        showStatus('Sila isi no. telefon!', 'error');
        return;
      }

      // If avatar file is selected, upload it first
      if (avatarFile) {
        const formData = new FormData();
        formData.append('avatar', avatarFile);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("profile.avatar") }}', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            return response.text().then(text => {
              throw new Error('HTTP ' + response.status + ': ' + text.substring(0, 100));
            });
          }
          return response.json();
        })
        .then(data => {
          if (!data.success) {
            showStatus(data.message || 'Gagal memuat naik gambar.', 'error');
            return;
          }
          // After avatar upload succeeds, update profile info
          updateProfileInfo(nama, institusi_id, telefon);
        })
        .catch(err => {
          console.error('Avatar upload error:', err);
          showStatus('Ralat memuat naik gambar: ' + err.message, 'error');
        });
      } else {
        // No avatar selected, just update profile info
        updateProfileInfo(nama, institusi_id, telefon);
      }
    }

    function updateProfileInfo(nama, institusi_id, telefon) {
      const email = document.getElementById('emailInput').value.trim();
      fetch('{{ route("profile.update") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          name: nama,
          email: email,
          phone_number: telefon,
          institution_id: institusi_id ? parseInt(institusi_id) : null
        })
      })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => { throw new Error(err.message || 'Ralat pelayan'); });
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          showStatus('Profil berjaya dikemaskini.', 'success');
          
          // Redirect to profile view page after 1 second
          setTimeout(function() {
            window.location.href = "{{ route('profile') }}";
          }, 1000);
        } else {
          showStatus(data.message || 'Gagal mengemas kini profil.', 'error');
        }
      })
      .catch(err => {
        showStatus('Ralat mengemas kini profil: ' + err.message, 'error');
      });
    }

    function handleSetPassword() {
      const oldPass = document.getElementById('oldPass').value;
      const newPass = document.getElementById('newPass').value;
      const confirmPass = document.getElementById('confirmPass').value;
      
      if (!oldPass) {
        showStatus('Sila masukkan kata laluan asal!', 'error');
        return;
      }
      if (!newPass) {
        showStatus('Sila masukkan kata laluan baru!', 'error');
        return;
      }
      if (oldPass === newPass) {
        showStatus('Kata laluan baru mesti berbeza dari yang lama!', 'error');
        return;
      }
      if (newPass !== confirmPass) {
        showStatus('Kata laluan tidak sepadan!', 'error');
        return;
      }
      
      const validationErrors = validatePassword(newPass);
      if (validationErrors.length > 0) {
        showStatus('Kata laluan tidak memenuhi syarat: ' + validationErrors.join(', '), 'error');
        return;
      }

      // Send password change request to server
      fetch('{{ route("profile.password") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          current_password: oldPass,
          password: newPass,
          password_confirmation: confirmPass
        })
      })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => { throw new Error(err.errors?.current_password?.[0] || err.message || 'Ralat pelayan'); });
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          showStatus('Kata laluan berjaya ditukar.', 'success');
          
          // Reset form
          document.getElementById('oldPass').value = '';
          document.getElementById('newPass').value = '';
          document.getElementById('confirmPass').value = '';
          document.getElementById('strengthText').textContent = 'Kekuatan: -';
          document.getElementById('strengthText').className = 'strength-indicator';
        } else {
          showStatus(data.errors?.current_password?.[0] || data.message || 'Gagal menukar kata laluan.', 'error');
        }
      })
      .catch(err => {
        showStatus('Ralat menukar kata laluan: ' + err.message, 'error');
      });
    }
  </script>

  <!-- Footer Section -->

<footer id="footer" class="footer light-background">
    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div class="address">
            <h4>Address</h4>
            <p>Ibu Pejabat Penjara Malaysia<br>Kajang–Semenyih<br>By Pass 43000 Kajang, Selangor</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
            <h4>Contact</h4>
            <p><strong>Phone:</strong> 03-8732 8000<br><strong>Email:</strong> admin@mysipma.com</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>Waktu Operasi</h4>
            <p><strong>Isnin - Jumaat:</strong> 8:00 pagi - 5:00 petang<br><strong>Sabtu & Ahad:</strong> Tutup</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <h4>Follow Us</h4>
          <div class="social-links d-flex">
            <a href="https://x.com/penjaramalaysia" target="_blank"><i class="bi bi-twitter-x"></i></a>
            <a href="https://www.facebook.com/jabatanpenjaramalaysia/" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/jabatanpenjaramalaysia" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://www.youtube.com/@pridetv9182" target="_blank"><i class="bi bi-youtube"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <div class="container text-center mt-4">
        <h4>Disclaimer</h4>
        <p>Jabatan Penjara Malaysia tidak bertanggungjawab terhadap sebarang kehilangan atau kerosakan yang dialami kerana menggunakan maklumat yang dicapai dalam laman ini.</p>
      </div><br>
      <p>
        <span>Hak Cipta Terpelihara</span> ©<strong class="px-1 sitename">2026 MySIPMa</strong> 
        <span>Kolaborasi Bersama <a href="https://pmj.mypolycc.edu.my" target="_blank">Politeknik Mersing</a></span>
      </p>
    </div>
  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

  <script src="{{ asset('frontend/Nexa/assets/js/particles.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/js/main.js') }}"></script>

    <script src="{{ asset('js/session-timeout.js') }}"></script>
  <script src="{{ asset('js/user-theme.js') }}"></script>
</body>
</html>

