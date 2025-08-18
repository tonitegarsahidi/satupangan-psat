<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Data Keamanan Pangan - PanganAman</title>

    <!-- Modern CSS Frameworks -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        /* CSS Variables for consistent theming */
        :root {
            --primary-color: #2E8B57;
            --primary-light: #3fa863;
            --primary-dark: #236846;
            --secondary-color: #FFD700;
            --text-dark: #333333;
            --text-light: #F0F0F0;
            --bg-light: #FAFAFA;
            --bg-white: #FFFFFF;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 1rem;
        }

        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        h3 { font-size: 1.5rem; }
        h4 { font-size: 1.25rem; }
        h5 { font-size: 1.125rem; }

        p {
            margin-bottom: 1rem;
            color: #555;
        }

        /* Container */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navigation */
        .navbar {
            background-color: var(--primary-color);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-light);
            font-weight: 600;
            font-size: 1.5rem;
        }

        .navbar-brand img {
            width: 45px;
            height: 45px;
            margin-right: 12px;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: var(--transition);
            padding: 0.5rem 0;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--secondary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--secondary-color);
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: var(--bg-white);
            min-width: 200px;
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius-md);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            margin-top: 0.5rem;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 0.75rem 1.25rem;
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background-color: rgba(46, 139, 87, 0.1);
            color: var(--primary-color);
        }

        .btn {
            padding: 0.625rem 1.5rem;
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #FFC700;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background-color: var(--text-light);
            color: var(--primary-color);
        }

        .btn-secondary:hover {
            background-color: #E8E8E8;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #FAFAFA 0%, #F0F7F0 100%);
            padding: 140px 0 80px;
            margin-top: 70px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="none"/><path d="M0 0L100 100M100 0L0 100" stroke="%23E0E0E0" stroke-width="0.5" opacity="0.3"/></svg>');
            background-size: 40px 40px;
            opacity: 0.3;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            animation: fadeInDown 0.8s ease-out;
        }

        .hero-content p {
            font-size: 1.25rem;
            color: #555;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease-out;
        }

        /* Section Styles */
        .section {
            padding: 60px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--secondary-color);
        }

        /* Card Styles */
        .card {
            background-color: var(--bg-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-title i {
            color: var(--primary-color);
            font-size: 1.75rem;
        }

        .card-text {
            color: #666;
            margin-bottom: 1.5rem;
        }

        /* Form Styles */
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #E0E0E0;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            transition: var(--transition);
            margin-bottom: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.1);
        }

        /* Search Results */
        .search-result {
            background-color: var(--bg-white);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border-left: 4px solid var(--primary-color);
            transition: var(--transition);
        }

        .search-result:hover {
            box-shadow: var(--shadow-md);
        }

        .result-row {
            display: flex;
            margin-bottom: 0.75rem;
        }

        .result-label {
            font-weight: 600;
            color: var(--primary-color);
            min-width: 150px;
        }

        .result-value {
            color: #555;
        }

        .result-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-warning {
            background-color: #FFF3CD;
            color: #856404;
            border: 1px solid #FFEEBA;
        }

        .alert-success {
            background-color: #D4EDDA;
            color: #155724;
            border: 1px solid #C3E6CB;
        }

        .alert-danger {
            background-color: #F8D7DA;
            color: #721C24;
            border: 1px solid #F5C6CB;
        }

        /* Toggle Section */
        .toggle-container {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
        }

        .toggle-card {
            display: flex;
            align-items: center;
            padding: 1.5rem 2rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            cursor: pointer;
        }

        .toggle-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .toggle-icon {
            font-size: 2rem;
            margin-right: 1.5rem;
        }

        .toggle-card.primary {
            background-color: var(--primary-color);
            color: var(--text-light);
        }

        .toggle-card.primary .toggle-icon {
            color: var(--secondary-color);
        }

        .toggle-card.secondary {
            background-color: #6C757D;
            color: var(--text-light);
        }

        .toggle-card.secondary .toggle-icon {
            color: var(--text-light);
        }

        .toggle-text h4 {
            margin-bottom: 0.25rem;
        }

        .toggle-text a {
            color: inherit;
            font-weight: 600;
            text-decoration: underline;
        }

        /* QR Scanner Styles */
        #reader {
            width: 100%;
            max-width: 500px;
            margin: 2rem auto;
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        #scan-result {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: var(--radius-sm);
            background-color: #F5F5F5;
        }

        /* Footer */
        .footer {
            background-color: var(--primary-dark);
            color: var(--text-light);
            padding: 2rem 0;
            text-align: center;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Navigation */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero {
                padding: 120px 0 60px;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .section {
                padding: 50px 0;
            }
        }

        @media (max-width: 768px) {
            .navbar-menu {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background-color: var(--primary-color);
                flex-direction: column;
                padding: 2rem;
                transition: left 0.3s ease;
            }

            .navbar-menu.active {
                left: 0;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .hero {
                padding: 100px 0 50px;
            }

            .hero-content h1 {
                font-size: 1.75rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .result-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .result-label {
                min-width: auto;
            }

            .toggle-container {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Modern Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('home.index') }}" class="navbar-brand">
                <img src="{{asset('assets/img/logo/logo.png')}}" alt="PanganAman Logo">
                <span>PanganAman</span>
            </a>

            <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </button>

            <div class="navbar-menu" id="navbar-menu">
                <a href="{{ route('home.index') }}" class="nav-link">Home</a>
                <a href="#about" class="nav-link">Tentang Kami</a>
                <a href="#features" class="nav-link">Fitur</a>
                <a href="#contact" class="nav-link">Kontak</a>

                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle">Layanan <i class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-menu">
                        <a href="{{ route('landing.layanan.cek_data') }}" class="dropdown-item">Cek Data Keamanan Pangan</a>
                        <a href="{{ route('landing.layanan.lapor_keamanan') }}" class="dropdown-item">Lapor Keamanan Pangan</a>
                        <a href="{{ route('landing.layanan.registrasi_izin') }}" class="dropdown-item">Registrasi Izin Produk Pangan</a>
                        <a href="{{ route('landing.layanan.permintaan_informasi') }}" class="dropdown-item">Permintaan Informasi</a>
                    </div>
                </div>

                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle">Informasi Panduan <i class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-menu">
                        <a href="{{ route('landing.panduan.alur_prosedur') }}" class="dropdown-item">Alur Prosedur</a>
                        <a href="{{ route('landing.panduan.standar_keamanan') }}" class="dropdown-item">Standar Keamanan Mutu Pangan</a>
                        <a href="{{ route('landing.panduan.batas_cemaran') }}" class="dropdown-item">Batas Cemaran & Residu</a>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register.list') }}" class="btn btn-secondary">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1><strong>Cek Data Keamanan Pangan</strong></h1>
                <p>Informasi mengenai cara mengecek data keamanan pangan segar asal tumbuhan.</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <p class="text-center mb-5">Di halaman ini, Anda dapat mengecek data keamanan pangan segar asal tumbuhan.</p>

                    <!-- Section 1: Pencarian Berdasarkan Kata Kunci -->
                    <div id="keyword-search-section">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">
                                    <i class="fas fa-search"></i>
                                    Pencarian Berdasarkan Kata Kunci
                                </h3>
                                <p class="card-text">Cari berdasarkan merk / nama komoditas / nama perusahaan</p>

                                <form method="POST" action="{{ route('landing.layanan.cek_data.search') }}">
                                    @csrf
                                    <input type="text" class="form-control" name="search"
                                           placeholder="Masukkan kata kunci pencarian..." value="{{ $search ?? '' }}" required>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="toggle-container">
                            <div class="toggle-card primary">
                                <i class="fas fa-qrcode toggle-icon"></i>
                                <div class="toggle-text">
                                    <h4>Punya QR Code Badan Pangan?</h4>
                                    <a href="#" id="show-qr-section">Klik disini untuk scan QR Code</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Scan QR / Barcode Badan Pangan -->
                    <div id="qr-scan-section" style="display: none;">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">
                                    <i class="fas fa-camera"></i>
                                    Scan QR / Barcode Badan Pangan
                                </h3>
                                <p class="card-text">Scan QR Code pada produk PSAT untuk langsung melihat detail keamanan pangan</p>

                                <button class="btn btn-primary btn-lg" id="start-scan-btn">
                                    <i class="fas fa-camera"></i> Mulai Scan QR / Barcode
                                </button>

                                <div id="reader"></div>
                                <div id="scan-result"></div>
                            </div>
                        </div>

                        <div class="toggle-container">
                            <div class="toggle-card secondary">
                                <i class="fas fa-search toggle-icon"></i>
                                <div class="toggle-text">
                                    <h4>Tidak punya QR Code?</h4>
                                    <a href="#" id="show-keyword-section">Kembali ke Pencarian Kata Kunci</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil pencarian -->
                    @if ($results !== null)
                        @if ($results->count() > 0)
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        <i class="fas fa-list"></i>
                                        Hasil Pencarian
                                    </h3>
                                    <p class="card-text">Menemukan {{ $results->count() }} hasil untuk "{{ $search }}"</p>

                                    @foreach ($results as $result)
                                        <div class="search-result">
                                            <div class="result-row">
                                                <div class="result-label">Kode QR:</div>
                                                <div class="result-value">{{ $result->qr_code }}</div>
                                            </div>
                                            <div class="result-row">
                                                <div class="result-label">Nama Komoditas:</div>
                                                <div class="result-value">{{ $result->nama_komoditas }}</div>
                                            </div>
                                            <div class="result-row">
                                                <div class="result-label">Merk Dagang:</div>
                                                <div class="result-value">{{ $result->merk_dagang }}</div>
                                            </div>
                                            <div class="result-row">
                                                <div class="result-label">Jenis PSAT:</div>
                                                <div class="result-value">{{ $result->jenisPsat->nama_jenis_pangan_segar }}</div>
                                            </div>
                                            <div class="result-row">
                                                <div class="result-label">Nama Perusahaan:</div>
                                                <div class="result-value">{{ $result->business->nama_perusahaan ?? '-' }}</div>
                                            </div>
                                            <div class="result-actions">
                                                <a href="{{ route('qr.detail', $result->qr_code) }}"
                                                   class="btn btn-primary">
                                                    <i class="fas fa-search"></i> Detail
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Tidak ditemukan hasil untuk "{{ $search }}". Coba dengan kata kunci lain.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </main>

    @include('components.landing.footer')

    <!-- html5-qrcode library -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <!-- Custom JavaScript -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const navbarMenu = document.getElementById('navbar-menu');

            mobileMenuToggle.addEventListener('click', function() {
                navbarMenu.classList.toggle('active');
                mobileMenuToggle.classList.toggle('active');
            });

            // Close mobile menu when clicking on a link
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    navbarMenu.classList.remove('active');
                    mobileMenuToggle.classList.remove('active');
                });
            });
        });

        // Toggle between keyword search and QR scan sections
        const keywordSearchSection = document.getElementById("keyword-search-section");
        const qrScanSection = document.getElementById("qr-scan-section");
        const showQrSection = document.getElementById("show-qr-section");
        const showKeywordSection = document.getElementById("show-keyword-section");

        showQrSection.addEventListener("click", function(e) {
            e.preventDefault();
            keywordSearchSection.style.display = "none";
            qrScanSection.style.display = "block";
        });

        showKeywordSection.addEventListener("click", function(e) {
            e.preventDefault();
            qrScanSection.style.display = "none";
            keywordSearchSection.style.display = "block";
        });

        // QR Scanner functionality
        const scanBtn = document.getElementById("start-scan-btn");
        const readerElem = document.getElementById("reader");
        const resultElem = document.getElementById("scan-result");

        let html5QrCode = null;

        const startScanner = async () => {
            // Clear previous result & reader
            resultElem.innerHTML = "";
            readerElem.innerHTML = "";

            // If already scanning, stop first
            if (html5QrCode) {
                try {
                    await html5QrCode.stop();
                    await html5QrCode.clear();
                } catch (err) {
                    console.warn("Gagal menghentikan scanner sebelumnya:", err);
                }
            }

            const devices = await Html5Qrcode.getCameras();
            if (!devices || devices.length === 0) {
                resultElem.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Tidak ditemukan perangkat kamera.
                </div>`;
                return;
            }

            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                },
                (decodedText, decodedResult) => {
                    html5QrCode.stop().then(() => {
                        html5QrCode.clear();
                        readerElem.innerHTML = '';
                        html5QrCode = null; // penting! supaya bisa scan ulang

                        console.log(`QR Code scanned: ${decodedText}`);

                        // Check if scanned text matches the URL pattern for redirect
                        const appUrl = '{{ config('app.url') }}';
                        const qrPattern = new RegExp(`^${appUrl}/qr/([^/]+)$`);
                        const match = decodedText.match(qrPattern);

                        if (match) {
                            // It's a QR code URL, redirect to the detail page
                            console.log(`QR Code detected, redirecting to: ${decodedText}`);
                            window.location.href = decodedText;
                        } else {
                            // Display the scanned text
                            resultElem.innerHTML = `
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <strong>Hasil Scan:</strong> ${decodedText}
                        </div>`;
                        }
                    });
                },
                (errorMessage) => {
                    // Optional: handle scan error (misalnya tidak terbaca)
                    console.log(`Scan error: ${errorMessage}`);
                }
            ).catch(err => {
                console.error(`Camera start error: ${err}`);
                resultElem.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                Gagal memulai kamera: ${err}
            </div>`;
            });
        };

        scanBtn.addEventListener("click", startScanner);
    </script>
</body>

</html>
