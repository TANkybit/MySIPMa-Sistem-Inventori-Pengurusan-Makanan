<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Log Masuk - MySIPMa</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- SEO / OG -->
  <meta property="og:title" content="MySIPMa" />
  <meta property="og:description" content="Sistem Inventori & Pengurusan Makanan" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://mysipma.com" />
  <!-- SEO / OG -->
  <meta property="og:title" content="MySIPMa" />
  <meta property="og:description" content="Sistem Inventori & Pengurusan Makanan" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://mysipma.com" />
  <meta property="og:image" content="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />

  <!-- Favicons -->
  <link rel="icon" type="image/png" href="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}">


  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
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
    :root {
      --accent-color: #00b894;
      --bg-dark: #070708;
    }

    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      background-color: #070708; /* Solid black for background */
      font-family: 'Montserrat', sans-serif;
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
    }

    /* Foreground Content Layer */
    #main {
      position: relative;
      z-index: 2;
      display: flex;
      align-items: center;
      min-height: calc(100vh - 80px);
    }

    /* Glassmorphism Login Card */
    .login-card {
    /* Guna putih yang sangat nipis (0.1) untuk nampak lutsinar */
    background: rgba(255, 255, 255, 0.2) !important; 
    
    /* Kesan kabur di belakang kotak */
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    
    /* Garisan tepi yang sangat halus */
    border: 1px solid rgba(255, 255, 255, 0.15); 
    
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    padding: 40px !important;
    color: #ffffff; /* Pastikan teks kembali putih supaya nampak kontra */
  }

  /* Pastikan label juga berwarna putih/cerah semula */
  .form-label {
    color: rgba(255, 255, 255, 0.8) !important;
  }

  /* Tambahan: Jadikan input sedikit lutsinar juga jika mahu */
  .form-control {
    background: rgba(255, 255, 255, 0.9) !important;
    border: none;
    border-radius: 8px;
    color: #1a1a1a;
  }

    .login-logo {
      width: 100px;
      height: auto;
      margin-bottom: 20px;
      filter: drop-shadow(0 0 10px rgba(0, 210, 255, 0.3));
    }

    .input-group-text {
      border-radius: 8px 0 0 8px;
      background: #fff !important;
      color: #636e72;
    }

    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #636e72;
      cursor: pointer;
      z-index: 10;
    }

    .btn-login {
      background-color: var(--accent-color);
      color: white;
      border: none;
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      font-weight: 600;
      transition: 0.3s;
      margin-top: 10px;
    }

    .btn-login:hover {
      background-color: #00a383;
      box-shadow: 0 0 20px rgba(0, 184, 148, 0.4);
      color: white;
    }

    .footer-links a {
      color: #00d2ff;
      text-decoration: none;
      font-size: 0.85rem;
    }

    .footer-links a:hover {
      text-decoration: underline;
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
  </style>
</head>

<body>

  <div id="particle-canvas"></div>

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('index') }}" class="logo-glow d-flex align-items-center me-auto me-xl-0">        
        <img src="{{ asset('frontend/Nexa/assets/img/WORDINGMYSIPMA2.png') }}" 
          style="height: 55px; width: auto;" 
          alt="MySIPMa logo">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('index') }}#hero">Laman Utama</a></li>
          <li><a href="{{ route('index') }}#about">Tentang Kami</a></li>
          <li><a href="{{ route('index') }}#contact">Hubungi Kami</a></li>
          <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Log Masuk</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        <a href="https://x.com/penjaramalaysia" target="_blank"><i class="bi bi-twitter-x"></i></a>
        <a href="https://www.facebook.com/jabatanpenjaramalaysia/" target="_blank"><i class="bi bi-facebook"></i></a>
        <a href="https://www.instagram.com/jabatanpenjaramalaysia" target="_blank"><i class="bi bi-instagram"></i></a>
        <a href="https://www.youtube.com/@pridetv9182" target="_blank"><i class="bi bi-youtube"></i></a>
      </div>

    </div>
  </header>

  <main id="main">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6" data-aos="zoom-in">
          
          <div class="card login-card text-center">
            <img src="{{ url('frontend/Nexa/assets/img/LOGOMYSIPMA.png') }}" class="login-logo mx-auto" alt="MySIPMa">
            <h3 class="mb-4">Selamat Datang</h3>

            <form id="loginForm" method="POST" action="">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="text-start mb-3">
    <label for="email" class="form-label text-light small">Emel</label>
    <div class="input-group">
      <span class="input-group-text"><i class="bi bi-envelope"></i></span>
      <input type="email" id="email" class="form-control" placeholder="Masukkan emel anda" required>
    </div>
    <div id="emailError" class="text-danger small mt-1" style="display:none;"></div>
  </div>

  <div class="text-start mb-2">
    <label class="form-label text-light small">Kata Laluan</label>
    <div class="position-relative">
      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-lock"></i></span>
        <input type="password" id="password" class="form-control" placeholder="Masukkan Kata Laluan" required>
      </div>
      <button type="button" id="togglePassword" class="password-toggle">
        <i class="bi bi-eye"></i>
      </button>
    </div>
    <div id="passError" class="text-danger small mt-1" style="display:none;"></div>
  </div>

  <div id="attemptsInfo" class="text-center mb-2" style="display:none;">
    <small id="attemptsText" class="text-warning"></small>
  </div>
  <div id="cooldownInfo" class="text-center mb-2" style="display:none;">
    <small id="cooldownText" class="text-danger"></small>
  </div>

  <div class="text-end mb-4">
    <a href="{{ route('password.request') }}" class="small" style="color: #00d2ff;">Lupa Kata Laluan?</a>
  </div>

  <button type="button" id="loginBtn" class="btn-login">Log Masuk</button>
</form>

            <div class="footer-links mt-4">
              <a href="{{ route('index') }}">← Kembali ke Halaman Utama</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>

  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/js/main.js') }}"></script>
  <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
  <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
  

  <script>
    /* Particle Network Logic */
    !function(a){var b="object"==typeof self&&self.self===self&&self||"object"==typeof global&&global.global===global&&global;"function"==typeof define&&define.amd?define(["exports"],function(c){b.ParticleNetwork=a(b,c)}):"object"==typeof module&&module.exports?module.exports=a(b,{}):b.ParticleNetwork=a(b,{})}(function(a,b){var c=function(a){this.canvas=a.canvas,this.g=a.g,this.particleColor=a.options.particleColor,this.x=Math.random()*this.canvas.width,this.y=Math.random()*this.canvas.height,this.velocity={x:(Math.random()-.5)*a.options.velocity,y:(Math.random()-.5)*a.options.velocity}};return c.prototype.update=function(){(this.x>this.canvas.width+20||this.x<-20)&&(this.velocity.x=-this.velocity.x),(this.y>this.canvas.height+20||this.y<-20)&&(this.velocity.y=-this.velocity.y),this.x+=this.velocity.x,this.y+=this.velocity.y},c.prototype.h=function(){this.g.beginPath(),this.g.fillStyle=this.particleColor,this.g.globalAlpha=.7,this.g.arc(this.x,this.y,1.5,0,2*Math.PI),this.g.fill()},b=function(a,b){this.i=a,this.i.size={width:this.i.offsetWidth,height:this.i.offsetHeight},b=void 0!==b?b:{},this.options={particleColor:void 0!==b.particleColor?b.particleColor:"#fff",background:void 0!==b.background?b.background:"#1a252f",interactive:void 0!==b.interactive?b.interactive:!0,velocity:this.setVelocity(b.speed),density:this.j(b.density)},this.init()},b.prototype.init=function(){this.k=document.createElement("div"),this.i.appendChild(this.k),this.l(this.k,{position:"absolute",top:0,left:0,bottom:0,right:0,"z-index":1}),this.l(this.k,{background:this.options.background}),this.canvas=document.createElement("canvas"),this.i.appendChild(this.canvas),this.g=this.canvas.getContext("2d"),this.canvas.width=this.i.size.width,this.canvas.height=this.i.size.height,this.l(this.canvas,{"z-index":"5",position:"relative"}),this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/ this.options.density;a++)this.o.push(new c(this));requestAnimationFrame(this.update.bind(this))},b.prototype.update=function(){this.g.clearRect(0,0,this.canvas.width,this.canvas.height);for(var a=0;a<this.o.length;a++){this.o[a].update(),this.o[a].h();for(var b=this.o.length-1;b>a;b--){var c=Math.sqrt(Math.pow(this.o[a].x-this.o[b].x,2)+Math.pow(this.o[a].y-this.o[b].y,2));c>120||(this.g.beginPath(),this.g.strokeStyle=this.options.particleColor,this.g.globalAlpha=(120-c)/120,this.g.lineWidth=.7,this.g.moveTo(this.o[a].x,this.o[a].y),this.g.lineTo(this.o[b].x,this.o[b].y),this.g.stroke())}}requestAnimationFrame(this.update.bind(this))},b.prototype.setVelocity=function(a){return"fast"===a?1:"slow"===a?.33:0.66},b.prototype.j=function(a){return"high"===a?5e3:1e4},b.prototype.l=function(a,b){for(var c in b)a.style[c]=b[c]},b});

    new ParticleNetwork(document.getElementById('particle-canvas'), {
      particleColor: '#62e2ff',
      background: '#000000',
      interactive: true,
      speed: 'high',
      density: 'high'
    });

    AOS.init();

// Validation and Login Script
  document.addEventListener("DOMContentLoaded", function() {
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const loginBtn = document.getElementById("loginBtn");
    const togglePassword = document.getElementById("togglePassword");
    
    const emailError = document.getElementById("emailError");
    const passError = document.getElementById("passError");

    // Show/Hide Password Toggle
    togglePassword.addEventListener("click", function() {
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);
      this.querySelector('i').classList.toggle("bi-eye");
      this.querySelector('i').classList.toggle("bi-eye-slash");
    });

    let cooldownTimer = null;

    function startCooldown(seconds) {
      const attemptsInfo = document.getElementById('attemptsInfo');
      const cooldownInfo = document.getElementById('cooldownInfo');
      const cooldownText = document.getElementById('cooldownText');
      let remaining = seconds;

      attemptsInfo.style.display = 'none';
      cooldownInfo.style.display = 'block';
      loginBtn.disabled = true;
      loginBtn.innerHTML = 'Tunggu...';

      if (cooldownTimer) clearInterval(cooldownTimer);

      cooldownTimer = setInterval(() => {
        remaining--;
        if (remaining <= 0) {
          clearInterval(cooldownTimer);
          cooldownTimer = null;
          cooldownInfo.style.display = 'none';
          loginBtn.disabled = false;
          loginBtn.innerHTML = 'Log Masuk';
          return;
        }
        cooldownText.textContent = 'Sila tunggu ' + remaining + ' saat sebelum mencuba lagi.';
      }, 1000);
    }

    function validateAndLogin() {
      let email = emailInput.value.trim();
      let password = passwordInput.value.trim();
      let valid = true;

      // Reset states
      emailError.style.display = "none";
      passError.style.display = "none";

      // Email Validation
      if (email === "") {
        emailError.innerText = "Sila masukkan emel anda";
        emailError.style.display = "block";
        valid = false;
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        emailError.innerText = "Sila masukkan format emel yang sah";
        emailError.style.display = "block";
        valid = false;
      }

      // Password Validation
      if (password === "") {
        passError.innerText = "Sila masukkan kata laluan anda";
        passError.style.display = "block";
        valid = false;
      }

      if (valid) {
        loginBtn.innerHTML = 'Sedang Log Masuk...';
        loginBtn.disabled = true;

        fetch(window.location.pathname, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            email: email,
            password: password
          })
        })
        .then(response => response.json())
        .then(data => {
          loginBtn.innerHTML = 'Log Masuk';
          loginBtn.disabled = false;

          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Berjaya',
              text: data.message,
              timer: 500,
              showConfirmButton: false
            }).then(() => {
                window.location.href = data.redirect;
            });
          } else {
            const attemptsInfo = document.getElementById('attemptsInfo');
            const attemptsText = document.getElementById('attemptsText');

            if (data.cooldown_remaining > 0) {
              startCooldown(data.cooldown_remaining);
              Swal.fire({
                icon: 'warning',
                title: 'Terlalu Banyak Percubaan',
                text: 'Sila tunggu ' + data.cooldown_remaining + ' saat.'
              });
            } else if (data.attempts_remaining !== undefined) {
              attemptsInfo.style.display = 'block';
              attemptsText.textContent = 'Baki percubaan: ' + data.attempts_remaining;
              passError.innerText = data.message;
              passError.style.display = "block";
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Ralat',
                text: data.message
              });
              passError.innerText = data.message;
              passError.style.display = "block";
            }
          }
        })
        .catch(error => {
          loginBtn.innerHTML = 'Log Masuk';
          loginBtn.disabled = false;
          var errMsg = 'Sila cuba sebentar lagi. URL: ' + window.location.pathname + ' Error: ' + error.message;
          if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'error', title: 'Ralat Sistem', text: errMsg });
          } else {
            alert(errMsg);
          }
          console.error('Error:', error);
        });
      }
    }

    // Trigger on button click
    loginBtn.addEventListener("click", validateAndLogin);

    // Trigger on Enter key in password field
    passwordInput.addEventListener("keypress", function(e) {
      if (e.key === "Enter") {
        validateAndLogin();
      }
    });
  });
  </script>

  @if(session('swal'))
  <script>
    Swal.fire({!! session('swal') !!});
  </script>
  @endif
</body>
</html>
