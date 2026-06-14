<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Profil</title>

  <link href="{{ url('frontend/assets/img/LOGOMYSIPMA.png') }}" rel="icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/aos/aos.css') }}" rel="stylesheet">

  <link href="{{ asset('frontend/Nexa/assets/css/main2.css') }}" rel="stylesheet">

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
      padding: 20px 24px;
      color: #ffffff;
      width: 100%;
      max-width: 600px;
    }

    .profile-display-section {
      width: 100%;
    }

    .profile-display-section h3 {
      color: #62e2ff !important;
      margin-bottom: 12px;
      text-align: center;
      font-weight: 700;
    }

    .profile-display-layout {
      display: flex;
      gap: 24px;
      align-items: flex-start;
    }

    .profile-display-left {
      flex: 0 0 100px;
      display: flex;
      justify-content: center;
    }

    .avatar-display {
      width: 100px;
      height: 100px;
      border-radius: 12px;
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(98, 226, 255, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(255, 255, 255, 0.6);
      font-size: 12px;
      overflow: hidden;
    }

    .avatar-display img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .profile-display-right {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .info-item {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .info-item label {
      color: rgba(255, 255, 255, 0.7);
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .info-item p {
      color: #ffffff;
      font-size: 14px;
      margin: 0;
      padding: 4px 8px;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 4px;
      border-left: 3px solid #62e2ff;
    }

    .button-container {
      display: flex;
      justify-content: center;
      margin-top: 12px;
      width: 100%;
    }

    .button-container button {
      background: linear-gradient(145deg, #00b894, #008870) !important;
      color: white;
      padding: 8px 24px !important;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 14px;
      transition: 0.3s;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0, 184, 148, 0.3);
    }

    .button-container button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0, 184, 148, 0.4);
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
      .profile-display-layout {
        flex-direction: column;
        gap: 10px;
        align-items: center;
      }

      .profile-display-left {
        flex: 0 0 auto;
      }

      .profile-display-right {
        width: 100%;
      }

      .profile-card {
        padding: 16px;
      }
    }
  </style>
</head>

<body class="profile-page">

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
            <div class="profile-display-section">
                <h3>Profil Anda</h3>
                <div class="profile-display-layout">
                    <!-- Avatar Display -->
                    <div class="profile-display-left">
                        <div id="avatarDisplay" class="avatar-display">
                            <img src="{{ $avatarUrl }}" alt="Avatar Image">
                        </div>
                    </div>
                    <!-- Info Display -->
                    <div class="profile-display-right">
                        <div class="info-item">
                            <label>Nama:</label>
                            <p id="displayNama">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="info-item">
                            <label>Emel:</label>
                            <p id="displayEmail">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="info-item">
                            <label>Institusi:</label>
                            <p id="displayInstitusi">{{ $institutionName }}</p>
                        </div>
                        <div class="info-item">
                            <label>Jawatan:</label>
                            <p id="displayJawatan">{{ $positionName }}</p>
                        </div>
                        <div class="info-item">
                            <label>Peranan:</label>
                            <p id="displayPeranan">{{ $roleName }}</p>
                        </div>
                        <div class="info-item">
                            <label>Telefon:</label>
                            <p id="displayTelefon">{{ Auth::user()->phone_number ?? '-' }}</p>
                        </div>
                        <div class="info-item">
                            <label>Alamat:</label>
                            <p id="displayAlamat">{{ $fullAddress ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button onclick="goBackToForm()">Kemaskini Profil</button>
            </div>

            <!-- Notification -->
            <div id="statusMsg"></div>
        </div>
    </div>

  <script>
    /* Particle Network Logic */
    !function(a){var b="object"==typeof self&&self.self===self&&self||"object"==typeof global&&global.global===global&&global;"function"==typeof define&&define.amd?define(["exports"],function(c){b.ParticleNetwork=a(b,c)}):"object"==typeof module&&module.exports?module.exports=a(b,{}):b.ParticleNetwork=a(b,{})}(function(a,b){var c=function(a){this.canvas=a.canvas,this.g=a.g,this.particleColor=a.options.particleColor,this.x=Math.random()*this.canvas.width,this.y=Math.random()*this.canvas.height,this.velocity={x:(Math.random()-.5)*a.options.velocity,y:(Math.random()-.5)*a.options.velocity}};return c.prototype.update=function(){(this.x>this.canvas.width+20||this.x<-20)&&(this.velocity.x=-this.velocity.x),(this.y>this.canvas.height+20||this.y<-20)&&(this.velocity.y=-this.velocity.y),this.x+=this.velocity.x,this.y+=this.velocity.y},c.prototype.h=function(){this.g.beginPath(),this.g.fillStyle=this.particleColor,this.g.globalAlpha=.7,this.g.arc(this.x,this.y,1.5,0,2*Math.PI),this.g.fill()},b=function(a,b){this.i=a,this.i.size={width:this.i.offsetWidth,height:this.i.offsetHeight},b=void 0!==b?b:{},this.options={particleColor:void 0!==b.particleColor?b.particleColor:"#fff",background:void 0!==b.background?b.background:"#1a252f",interactive:void 0!==b.interactive?b.interactive:!0,velocity:this.setVelocity(b.speed),density:this.j(b.density)},this.init()},b.prototype.init=function(){this.k=document.createElement("div"),this.i.appendChild(this.k),this.l(this.k,{position:"absolute",top:0,left:0,bottom:0,right:0,"z-index":1}),this.l(this.k,{background:this.options.background}),this.canvas=document.createElement("canvas"),this.i.appendChild(this.canvas),this.g=this.canvas.getContext("2d"),this.canvas.width=this.i.size.width,this.canvas.height=this.i.size.height,this.l(this.canvas,{"z-index":"5",position:"relative"}),this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/ this.options.density;a++)this.o.push(new c(this));requestAnimationFrame(this.update.bind(this))},b.prototype.update=function(){this.g.clearRect(0,0,this.canvas.width,this.canvas.height);for(var a=0;a<this.o.length;a++){this.o[a].update(),this.o[a].h();for(var b=this.o.length-1;b>a;b--){var c=Math.sqrt(Math.pow(this.o[a].x-this.o[b].x,2)+Math.pow(this.o[a].y-this.o[b].y,2));c>120||(this.g.beginPath(),this.g.strokeStyle=this.options.particleColor,this.g.globalAlpha=(120-c)/120,this.g.lineWidth=.7,this.g.moveTo(this.o[a].x,this.o[a].y),this.g.lineTo(this.o[b].x,this.o[b].y),this.g.stroke())}}requestAnimationFrame(this.update.bind(this))},b.prototype.setVelocity=function(a){return"fast"===a?1:"slow"===a?.33:0.66},b.prototype.j=function(a){return"high"===a?5e3:1e4},b.prototype.l=function(a,b){for(var c in b)a.style[c]=b[c]},b});

    // Initialize particles after DOM is ready
    function initializeParticles() {
      const particleCanvas = document.getElementById('particle-canvas');
      if (particleCanvas && particleCanvas.offsetWidth > 0 && particleCanvas.offsetHeight > 0) {
        new ParticleNetwork(particleCanvas, {
          particleColor: '#62e2ff',
          background: '#000000',
          interactive: true,
          speed: 'high',
          density: 'high'
        });
      } else {
        setTimeout(initializeParticles, 100);
      }
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initializeParticles);
    } else {
      initializeParticles();
    }

    function goBackToForm() {
      window.location.href = "{{ route('profile.edit') }}";
    }

    function showStatus(msg, type = 'info') {
      const statusDiv = document.getElementById('statusMsg');
      statusDiv.textContent = msg;
      statusDiv.className = type;
      
      setTimeout(() => {
        statusDiv.textContent = '';
        statusDiv.className = '';
      }, 3000);
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
            <p>Ibu Pejabat Penjara Malaysia<br>Kajangâ€“Semenyih<br>By Pass 43000 Kajang, Selangor</p>
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
        <span>Hak Cipta Terpelihara</span> Â©<strong class="px-1 sitename">2026 MySIPMa</strong> 
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
</body>
</html>
