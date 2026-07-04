<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Laman Utama - MySIPMa</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

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

  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/css/main2.css') }}" rel="stylesheet">

<style>
  .index-page {
    --nav-color: rgba(255,255,255,0.85);
  }

  .index-page .navmenu a,
  .index-page .navmenu a:focus {
    color: var(--nav-color) !important;
  }

  .index-page .navmenu li:hover>a,
  .index-page .navmenu .active,
  .index-page .navmenu .active:focus {
    color: var(--nav-hover-color) !important;
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

  .about .content .features-list .feature-item .text h4 {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
  }

  #contact {
    padding-top: 40px !important;
    padding-bottom: 40px !important;
  }
  #contact .section-title {
    margin-bottom: 20px !important;
  }
  #contact .container > .contact-wrapper {
    gap: 20px;
  }
  #contact .contact-info-panel {
    padding: 20px !important;
  }
  #contact .contact-info-header h3 {
    font-size: 1.3rem !important;
    margin-bottom: 6px !important;
  }
  #contact .contact-info-header p {
    font-size: 0.85rem !important;
    margin-bottom: 0 !important;
  }
  #contact .contact-info-cards {
    gap: 8px !important;
    margin: 14px 0 !important;
  }
  #contact .info-card {
    padding: 10px 12px !important;
    gap: 10px !important;
  }
  #contact .info-card .icon-container {
    width: 36px !important;
    height: 36px !important;
    min-width: 36px !important;
  }
  #contact .info-card h4 {
    font-size: 0.85rem !important;
    margin-bottom: 1px !important;
  }
  #contact .info-card p {
    font-size: 0.78rem !important;
    margin-bottom: 0 !important;
  }
  #contact .social-links-panel {
    padding: 10px 0 0 !important;
  }
  #contact .social-links-panel h5 {
    font-size: 0.85rem !important;
    margin-bottom: 6px !important;
  }
  #contact .social-icons a {
    width: 32px !important;
    height: 32px !important;
    font-size: 0.9rem !important;
  }
  #contact .form-container {
    padding: 20px !important;
  }
  #contact .form-container h3 {
    font-size: 1.1rem !important;
    margin-bottom: 14px !important;
  }
  #contact .form-container iframe {
    height: 180px !important;
  }
  #contact .form-floating {
    margin-bottom: 10px !important;
  }
  #contact .form-floating > .form-control {
    min-height: 42px !important;
    padding: 8px 12px !important;
  }
  #contact .form-floating > textarea.form-control {
    min-height: 80px !important;
    height: 80px !important;
  }
  #contact .form-floating > label {
    padding: 8px 12px !important;
    font-size: 0.85rem !important;
  }
  #contact .btn-submit {
    font-size: 0.9rem !important;
    padding: 10px 20px !important;
  }

  #recaptchaModal .modal-content {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  }

  #recaptchaModal .modal-header {
    background: linear-gradient(135deg, #1565c0 0%, #1976d2 50%, #42a5f5 100%);
    color: #fff;
    border: none;
    padding: 24px 24px 20px;
    text-align: center;
    flex-direction: column;
    align-items: center;
  }

  #recaptchaModal .modal-header .btn-close {
    position: absolute;
    top: 12px;
    right: 12px;
    filter: brightness(0) invert(1);
  }

  #recaptchaModal .modal-title {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 6px;
  }

  #recaptchaModal .modal-subtitle {
    font-size: 0.9rem;
    opacity: 0.9;
    margin: 0;
    font-weight: 400;
  }

  #recaptchaModal .modal-body {
    padding: 30px 24px 20px;
    background: #fff;
  }
</style>
</head>

<body class="index-page">

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

  <main class="main">

    <section id="hero" class="hero section">
      <div class="hero-background">
        <img src="{{ asset('frontend/Nexa/assets/img/PEJABATPENJARA.png') }}" alt="Background Image" class="img-fluid" loading="lazy">
        <div class="hero-overlay"></div>
      </div> 

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center text-center">
          <div class="col-lg-10">
            <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
              <h1>Selamat Datang ke 
                <span style="color: #FFE082; text-shadow: 0 0 10px #FFB30066, 0 0 20px #FFA000;">MySIPMa</span></h1>
              <p>Sistem Inventori Dan Pengurusan Makanan</p>

              <div class="hero-btns" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('borang.inden') }}" class="btn btn-primary">Borang Inden</a>
                {{-- <a href="{{ route('sejarah') }}" class="btn btn-outline glightbox" target="_blank">
                  <i class="bi bi-play-circle"></i> 
                  Ketahui Lebih Lanjut
                </a> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="about" class="about section">
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Tentang Kami</span>
        <h2>Tentang Kami</h2>
        <p>Laman web ini dibangunkan sebagai platform digital bersepadu bagi pemantauan stok bahan mentah catuan makanan di institusi penjara. 
           Melaluinya, pihak pengurusan boleh merekod dan memantau penggunaan bahan mentah basah serta kering secara real-time bagi memastikan rekod inventori sentiasa tepat tanpa perlu pengiraan manual.
           Sistem ini merangkumi pengurusan had siling pesanan dan pemantauan tarikh luput bagi memastikan setiap bahan diuruskan dengan cekap tanpa berlaku pembaziran atau kerosakan.
           Selain itu, amaran automatik disediakan bagi memberi notifikasi awal apabila stok berada pada tahap rendah atau pesanan menghampiri had yang ditetapkan.
           Rumusan data dan laporan dijana secara automatik bagi meningkatkan ketelusan, kawalan, dan keberkesanan pengurusan bekalan makanan di peringkat institusi mahupun Ibu Pejabat Penjara Malaysia.</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gx-0 gx-lg-5 gy-5 align-items-center">
          <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="200">
            <div class="image-wrapper">
              <div class="image-box">
                <img src="{{ asset('frontend/Nexa/assets/img/STORE3.png') }}" class="img-fluid" alt="Penjara Malaysia" loading="lazy">
              </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
            <div class="content">
              <div class="features-list">
                <div class="feature-item" data-aos="zoom-in" data-aos-delay="300">
                  <div class="icon-box">
                    <i class="bi bi-check2-circle"></i>
                  </div>
                  <div class="text">
                    <h3><b>Objektif Laman Web</b></h3>
                    <p>• Memantau penggunaan bahan mentah basah dan kering secara real-time oleh pihak institusi, 
                         Pejabat Pengarah Penjara Negeri dan Ibu Pejabat Penjara Malaysia.</p><br>
                    <p>• Memberi amaran secara automatik apabila penggunaan atau pesanan sesuatu item menghampiri atau melebihi had siling yang ditetapkan.</p><br>
                    <p>• Meningkatkan ketelusan, kawalan dan kecekapan dalam pengurusan pesanan dan penggunaan bahan mentah.</p>
                  </div>
                </div>

                <div class="container cta-buttons">
                  <a href="{{ route('borang.inden') }}" class="btn-learn-more">Pergi ke Borang Inden</a>
                  <a href="{{ route('login') }}" class="btn-get-started">Log Masuk</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="contact" class="contact section">
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Hubungi Kami</span>
        <h2>Hubungi Kami</h2>
      </div>

      <div class="container">
        <div class="contact-wrapper">
          <div class="contact-info-panel">
            <div class="contact-info-header">
              <h3>Hubungi Kami</h3>
              <p>Hubungi kami melalui cara-cara di bawah. Kami sedia membantu.</p>
            </div>

            <div class="contact-info-cards">
              <div class="info-card">
                <div class="icon-container"><i class="bi bi-pin-map-fill"></i></div>
                <div class="card-content">
                  <h4>Lokasi</h4>
                  <p>Kajang-Semenyih By Pass, 43000 Kajang, Selangor</p>
                </div>
              </div>

              <div class="info-card">
                <div class="icon-container"><i class="bi bi-envelope-open"></i></div>
                <div class="card-content">
                  <h4>Emel</h4>
                  <p>admin@mysipma.com</p>
                </div>
              </div>

              <div class="info-card">
                <div class="icon-container"><i class="bi bi-telephone-fill"></i></div>
                <div class="card-content">
                  <h4>Telefon</h4>
                  <p>03-8732 8000</p>
                </div>
              </div>

              <div class="info-card">
                <div class="icon-container"><i class="bi bi-clock-history"></i></div>
                <div class="card-content">
                  <h4>Waktu Operasi</h4>
                  <p>Isnin - Jumaat 8:00 pagi - 5:00 petang</p>
                </div>
              </div>
            </div>

            <div class="social-links-panel">
              <h5>Follow Us</h5>
              <div class="social-icons">
                <a href="https://www.facebook.com/jabatanpenjaramalaysia/" class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
                <a href="https://x.com/penjaramalaysia" class="twitter" target="_blank"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.instagram.com/jabatanpenjaramalaysia" class="instagram" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="https://www.youtube.com/@pridetv9182" class="youtube" target="_blank"><i class="bi bi-youtube"></i></a>
              </div>
            </div>
          </div>

          <div class="form-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.629398860716!2d101.8048!3d2.9231!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdcc8e21774e17%3A0x6c5c02604646732!2sIbu%20Pejabat%20Penjara%20Malaysia!5e0!3m2!1sen!2smy!4v1700000000000!5m2!1sen!2smy" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
              <h3>Hantar Mesej Kepada Kami</h3>

              <form action="{{ route('contact.send') }}" method="post" class="php-email-form" data-recaptcha-site-key="{{ config('recaptcha.site_key') }}">
                @csrf
                <input type="hidden" name="g-recaptcha-response" id="recaptchaToken">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="nameInput" name="name" placeholder="Full Name" required="">
                  <label for="nameInput">Nama Penuh</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="email" class="form-control" id="emailInput" name="email" placeholder="Email Address" required="">
                  <label for="emailInput">Alamat Emel</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="subjectInput" name="subject" placeholder="Subject" required="">
                  <label for="subjectInput">Tajuk</label>
                </div>

                <div class="form-floating mb-3">
                  <textarea class="form-control" id="messageInput" name="message" rows="5" placeholder="Your Message" style="height: 150px" required=""></textarea>
                  <label for="messageInput">Mesej Anda</label>
                </div>

                <div class="my-3">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Mesej Berjaya Dihantar. Terima Kasih!</div>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn-submit">Hantar Mesej <i class="bi bi-send-fill ms-2"></i></button>
                </div>
              </form>

              <div class="modal fade" id="recaptchaModal" tabindex="-1" aria-labelledby="recaptchaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="recaptchaModalLabel">Sahkan Captcha</h5>
                      <p class="modal-subtitle">Sila lengkapkan captcha untuk menghantar mesej anda</p>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div id="recaptchaContainer" class="d-flex justify-content-center"></div>
                      <div id="recaptchaError" class="text-danger mt-3" style="display: none;"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </section>

  </main>

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
        <span>Kolaborasi Bersama <a href="https://pmj.mypolycc.edu.my" target="_blank">Politeknik Mersing, Johor</a></span>
      </p>
    </div>
  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

  <script src="{{ asset('frontend/Nexa/assets/js/main.js') }}"></script>
  <script src="https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit" async defer></script>

  <script>
    (function () {
      "use strict";

      const form = document.querySelector(".php-email-form");
      if (!form) {
        return;
      }

      const siteKey = form.getAttribute("data-recaptcha-site-key");
      const loadingEl = form.querySelector(".loading");
      const errorEl = form.querySelector(".error-message");
      const sentEl = form.querySelector(".sent-message");
      const tokenInput = document.getElementById("recaptchaToken");
      const modalEl = document.getElementById("recaptchaModal");
      const modal = new bootstrap.Modal(modalEl);
      const modalErrorEl = document.getElementById("recaptchaError");
      let widgetId = null;
      let submitting = false;

      function resetMessages() {
        if (loadingEl) {
          loadingEl.classList.remove("d-block");
        }
        if (errorEl) {
          errorEl.classList.remove("d-block");
          errorEl.textContent = "";
        }
        if (sentEl) {
          sentEl.classList.remove("d-block");
        }
        if (modalErrorEl) {
          modalErrorEl.style.display = "none";
          modalErrorEl.textContent = "";
        }
      }

      function showError(message) {
        if (!errorEl) {
          return;
        }
        errorEl.textContent = message;
        errorEl.classList.add("d-block");
      }

      function showModalError(message) {
        if (!modalErrorEl) {
          return;
        }
        modalErrorEl.textContent = message;
        modalErrorEl.style.display = "block";
      }

      function submitForm() {
        if (submitting) {
          return;
        }
        submitting = true;
        resetMessages();

        if (loadingEl) {
          loadingEl.classList.add("d-block");
        }

        const action = form.getAttribute("action");
        const formData = new FormData(form);

        fetch(action, {
          method: "POST",
          body: formData,
          headers: { "X-Requested-With": "XMLHttpRequest" },
        })
          .then(async (response) => {
            const text = await response.text();
            if (response.ok) {
              return text;
            }
            throw new Error(text || `${response.status} ${response.statusText}`);
          })
          .then((data) => {
            if (data.trim() === "OK") {
              if (sentEl) {
                sentEl.classList.add("d-block");
                setTimeout(function () {
                  sentEl.classList.remove("d-block");
                }, 3000);
              }
              form.reset();
              if (widgetId !== null && typeof grecaptcha !== "undefined") {
                grecaptcha.reset(widgetId);
              }
              if (tokenInput) {
                tokenInput.value = "";
              }
            } else {
              showError(data || "Gagal menghantar mesej. Sila cuba lagi.");
            }
          })
          .catch((error) => {
            showError(error.message || "Ralat berlaku. Sila cuba lagi.");
          })
          .finally(() => {
            submitting = false;
            if (loadingEl) {
              loadingEl.classList.remove("d-block");
            }
          });
      }

      function openRecaptchaModal() {
        resetMessages();

        if (!siteKey) {
          showError("Kunci reCAPTCHA tidak dijumpai. Sila hubungi pentadbir.");
          return;
        }

        if (typeof grecaptcha === "undefined") {
          showError("reCAPTCHA gagal dimuatkan. Sila cuba lagi.");
          return;
        }

        if (widgetId === null) {
          widgetId = grecaptcha.render("recaptchaContainer", {
            sitekey: siteKey,
            callback: function (token) {
              if (tokenInput) {
                tokenInput.value = token;
              }
              modal.hide();
              submitForm();
            },
            "expired-callback": function () {
              if (tokenInput) {
                tokenInput.value = "";
              }
              showModalError("Sesi reCAPTCHA tamat. Sila cuba lagi.");
            },
            "error-callback": function () {
              showModalError("reCAPTCHA gagal. Sila cuba lagi.");
            },
          });
        } else {
          grecaptcha.reset(widgetId);
        }

        modal.show();
      }

      function validateForm() {
        resetMessages();
        var name = document.getElementById('nameInput').value.trim();
        var email = document.getElementById('emailInput').value.trim();
        var subject = document.getElementById('subjectInput').value.trim();
        var message = document.getElementById('messageInput').value.trim();
        if (!name) { showError('Sila masukkan nama penuh.'); return false; }
        if (!email) { showError('Sila masukkan alamat emel.'); return false; }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showError('Sila masukkan format emel yang sah.'); return false; }
        if (!subject) { showError('Sila masukkan tajuk.'); return false; }
        if (!message) { showError('Sila masukkan mesej anda.'); return false; }
        return true;
      }

      form.addEventListener("submit", function (event) {
        event.preventDefault();
        if (submitting) {
          return;
        }
        if (!validateForm()) {
          return;
        }
        openRecaptchaModal();
      });

      window.onRecaptchaLoad = function () {
        // Explicit render happens when the modal opens.
      };
    })();
  </script>

  <!-- Tidio Chat Widget -->
  <script src="//code.tidio.co/pgrnfjdqogbuoyxl5zjtvxtwclzdz9wv.js" async></script>

</body>
</html>