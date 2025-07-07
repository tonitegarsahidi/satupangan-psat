<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatuPangan - Sistem Pengendalian Keamanan Pangan Segar Asal Tumbuhan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .jumbotron {
            background-color: #F0F0F0 !important; /* Abu-abu terang */
            color: #2E8B57; /* Hijau gelap */
            padding: 80px 0;
        }
        .jumbotron .row {
            display: flex;
            align-items: center;
        }
        .jumbotron h1 {
            font-weight: bold;
            color: #2E8B57; /* Hijau gelap */
        }
        .jumbotron p {
            font-size: 1.2rem;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card i {
            color: #FFD700 !important; /* Kuning keemasan */
        }
        .card h5 {
            color: #2E8B57; /* Hijau gelap */
            font-weight: bold;
        }
        .border-bottom {
            border-color: #FFD700 !important; /* Kuning keemasan */
        }
        .footer {
            background-color: #2E8B57 !important; /* Hijau gelap */
            color: #F0F0F0 !important; /* Abu-abu terang */
        }
    </style>
    <style>
        /* Custom CSS for hover dropdown */
        @media all and (min-width: 992px) {
            .navbar .nav-item .dropdown-menu {
                display: none;
                margin-top: 0;
            }
            .navbar .nav-item:hover .dropdown-menu {
                display: block;
            }
        }
    </style>
    <style>
        /* Custom CSS for hover dropdown */
        @media all and (min-width: 992px) {
            .navbar .nav-item .dropdown-menu {
                display: none;
                margin-top: 0;
            }
            .navbar .nav-item:hover .dropdown-menu {
                display: block;
            }
        }
    </style>

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

</head>

<body>
    @include('landing.navbar')

    {{-- JUMBOTRON --}}

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('assets/img/illustrations/satu pangan illustration.png')}}" alt="SatuPangan Hero Image"
                        class="img-fluid rounded">
                </div>
                <div class="col-md-6">
                    <h1 class="display-4 text-right">SatuPangan</h1>
                    <p class="text-right">Platform digital terpadu untuk mendukung pengendalian keamanan Pangan Segar Asal Tumbuhan (PSAT) di Indonesia.</p>
                    <p class="text-right">Sebagai bagian penelitian Disertasi oleh Dhani Hermansyah S.TP. M.P.</p>
                </div>
            </div>
        </div>
    </div>

<div class="container px-4 py-5" id="about">
    <h2 class="pb-3 text-center border-bottom">Tentang SatuPangan</h2>
    <div class="row row-cols-1 g-4 pt-4">
        <div class="col text-center">
            <p>SatuPangan adalah sebuah platform digital terpadu untuk mendukung pengendalian keamanan Pangan Segar Asal Tumbuhan (PSAT) di Indonesia. Aplikasi ini dirancang untuk digunakan oleh masyarakat umum, pelaku usaha, serta petugas pengawas dari pemerintah pusat maupun daerah. Melalui sistem ini, pelaporan, verifikasi, edukasi, serta perizinan keamanan pangan dilakukan secara transparan, cepat, dan efisien.</p>
            <p>SatuPangan dikembangkan sebagai solusi sistem digital untuk mendukung Badan Pangan Nasional dan otoritas terkait dalam menjaga keamanan pangan berbasis data, teknologi, dan partisipasi publik. Aplikasi ini menghubungkan pelaku usaha, masyarakat, dan pemerintah dalam satu ekosistem pangan segar yang aman, legal, dan terlacak.</p>
        </div>
    </div>
</div>

<div class="container px-4 py-5" id="features">
    <h2 class="pb-3 text-center border-bottom">Fitur Utama</h2>

    <div class="row row-cols-1 row-cols-md-3 g-4 pt-4">
        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-data bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Registrasi dan Database Produk PSAT</h5>
                    <p class="mb-0">Input, verifikasi, dan penerbitan QR Code untuk produk yang memiliki izin edar.</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-qr-scan bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Cek Keamanan Produk</h5>
                    <p class="mb-0">Konsumen dapat memindai QR Code untuk memastikan legalitas dan keamanan pangan.</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-file-find bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Pelaporan & Pengawasan Terpadu</h5>
                    <p class="mb-0">Laporan pelanggaran dari masyarakat ditindaklanjuti secara real-time oleh petugas OKKP.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 pt-4">
        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-chat bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Pembinaan & Konsultasi</h5>
                    <p class="mb-0">Pelaku usaha dan masyarakat dapat melakukan konsultasi seputar standar dan prosedur keamanan pangan.</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-bell bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Notifikasi & Peringatan Dini</h5>
                    <p class="mb-0">Sistem mengingatkan pengguna akan masa berlaku izin, laporan penting, hingga potensi kasus keamanan pangan.</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-shield-alt-2 bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Keamanan & Kinerja</h5>
                    <p class="mb-0">Penyimpanan data terenkripsi, real-time sync, backup otomatis harian, dapat diakses lintas perangkat dan optimal di jaringan lambat.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container px-4 py-5" id="contact">
    <h2 class="pb-3 text-center border-bottom">Hubungi Kami</h2>
    <div class="row row-cols-1 g-4 pt-4">
        <div class="col text-center">
            <p>Untuk pertanyaan, laporan, atau dukungan teknis:</p>
            <p><strong>Email:</strong> kontak@satupangan.id</p>
            <p><strong>Whatsapp:</strong> +62-812-xxx-xxxx</p>
            <p><strong>Alamat:</strong> Sekretariat Sistem PSAT, Jakarta, Indonesia</p>
            <p><strong>Media Sosial:</strong> @satupangan.id</p>
        </div>
    </div>
</div>

    {{-- FOOTER --}}
    <footer class="footer text-center py-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    SatuPangan - Dikembangkan untuk mendukung keamanan pangan di Indonesia.
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
