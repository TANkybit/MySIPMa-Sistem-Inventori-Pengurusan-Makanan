<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sejarah - MySIPMa</title>
  
  <link href="{{ url('frontend/assets/img/LOGOMYSIPMA.png') }}" rel="icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/Nexa/assets/vendor/aos/aos.css') }}" rel="stylesheet">


  <style>
    :root {
      /* Tukar kod warna di bawah ini */
      --body-bg: #094f6268; /* Contoh: Hitam kelabu supaya nampak lebih profesional */
      --card-bg: #111111;
      --primary-blue: #00f7ff;
      --text-main: #e0e0e0;
      --header-footer-bg: #094f6268;
    }

    body {
      background-color: var(--body-bg) !important;
      font-family: 'Roboto', sans-serif;
      color: var(--text-main);
      margin: 0;
      padding: 0;
    }

    /* Logo Glow Effect */
    .logo-glow {
      filter: brightness(150%) drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
      transition: 0.3s;
    }

    .logo-glow:hover {
      filter: brightness(200%) drop-shadow(0 0 15px rgba(255, 255, 255, 0.6));
    }

    /* Header Styling */
    .header {
      background-color: var(--header-footer-bg) !important;
      border-bottom: 1px solid #8a08ae;
      padding: 15px 0;
    }

    .navmenu ul li a {
      color: #ffffff !important;
      font-weight: 500;
      transition: 0.3s;
    }

    .navmenu ul li a:hover {
      color: var(--primary-blue) !important;
    }

    /* Content Cards */
    .history-card {
      background: var(--card-bg);
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
      margin-bottom: 30px;
      border: 1px solid #222;
    }

    .section-title {
      color: var(--primary-blue);
      font-weight: 700;
      position: relative;
      padding-bottom: 10px;
      margin-bottom: 25px;
      text-transform: uppercase;
    }

    p {
      line-height: 1.8;
      text-align: justify;
      color: var(--text-main);
    }

    .highlight-box {
      background: #1a1a1a;
      border-left: 5px solid var(--primary-blue);
      padding: 20px;
      margin: 20px 0;
      border-radius: 0 10px 10px 0;
    }

    .highlight-box h5 {
      color: var(--primary-blue);
    }

    /* Footer Styling */
    .footer {
      background-color: var(--header-footer-bg) !important;
      border-top: 1px solid #222;
      padding: 40px 0;
      color: #ffffff;
    }

    .footer a {
      color: var(--primary-blue);
      text-decoration: none;
    }

    .text-muted {
      color: #000000 !important;
    }
  </style>
</head>

<body class="index-page">

  <main class="main">
    <section class="py-5" style="background: linear-gradient(45deg, #00b1d8, #0242aa); border-bottom: 1px solid #222;">
      <div class="container text-center">
        <h1 class="display-5 fw-bold text-white" data-aos="zoom-in">SEJARAH PENJARA MALAYSIA</h1>
      </div>
    </section>

    <section class="py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">

            <div class="history-card" data-aos="fade-up">
              <h2 class="section-title">Pengenalan</h2>
              <p>
                Sistem penjara sudah wujud semenjak <strong>Zaman Kesultanan Melayu</strong> lagi. Pesalah yang melakukan jenayah akan dipenjarakan mengikut hukuman yang ditetapkan oleh pembesar negeri. Pada kebiasaannya, banduan diletakkan di sesuatu bangunan dalam satu tempoh waktu yang panjang bergantung kepada kesalahan yang dilakukan.
              </p>
              <p>
                Langkah memberikan hukuman yang berat ini bertujuan membendung penentangan masyarakat tempatan kepada pembesar dan pemerintah, sekaligus memastikan keamanan negeri dipelihara dengan baik. Walau bagaimanapun, sejarah penjara moden di Malaysia bermula secara rasmi pada abad ke-18 seiring dengan perkembangan <strong>Syarikat India Timur British (EIC)</strong> yang membawa mandat dari London.
              </p>
            </div>

            <div class="history-card" data-aos="fade-up" data-aos-delay="100">
              <h2 class="section-title">Pembentukan Sistem Penjara</h2>
              <p>
                Sistem pemenjaraan moden bermula dengan penubuhan <em>Penal Settlement</em> di <strong>Bangkahulu (1787)</strong> dan kemudiannya di Pulau Pinang. Kapten Francis Light menamakan Pulau Pinang sebagai <em>Prince of Wales Island</em> pada 11 Ogos 1786.
              </p>
              
              <div class="highlight-box">
                <h5><i class="bi bi-info-circle-fill"></i> Fungsi Banduan India</h5>
                <p class="mb-0">Banduan dari India memainkan peranan kritikal sebagai sumber tenaga buruh murah. Mereka dikerahkan untuk membina infrastruktur utama tanah jajahan seperti pelabuhan, jalan raya, jalan keretapi, dan bangunan kerajaan.</p>
              </div>

              <p>
                Menjelang abad ke-19, British menguatkuasakan <strong>Undang-Undang Kesiksaan Pengangkutan</strong> (<em>Penal Transportation</em>). Langkah ini membolehkan migrasi paksaan dilakukan secara besar-besaran dari India ke Negeri-Negeri Selat untuk memenuhi kepentingan ekonomi British. Kesannya, pengurusan penjara awal lebih berfokus kepada buruh kasar berbanding pemulihan disiplin yang ketat.
              </p>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container text-center">
      <p class="mb-2">Hak Cipta Terpelihara ©2026 <strong>MySIPMa</strong></p>
      <p class="mb-0 text-muted small">
        Kolaborasi Bersama <a href="https://pmj.mypolycc.edu.my" target="_blank">Politeknik Mersing</a>
      </p>
    </div>
  </footer>

  <script src="{{ asset('frontend/Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/Nexa/assets/vendor/aos/aos.js') }}"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true
    });
  </script>

</body>
</html>