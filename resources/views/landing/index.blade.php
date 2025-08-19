<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengendalian Keamanan Pangan Segar Asal Tumbuhan</title>

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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-image {
            position: relative;
            animation: fadeInRight 1s ease-out;
        }

        .hero-image img {
            width: 100%;
            max-width: 500px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
        }

        .hero-image:hover img {
            transform: scale(1.02);
            box-shadow: 0 12px 32px rgba(0,0,0,0.15);
        }

        .hero-text {
            animation: fadeInLeft 1s ease-out;
        }

        .hero-text h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-text p {
            font-size: 1.25rem;
            color: #555;
            margin-bottom: 2rem;
        }

        /* Section Styles */
        .section {
            padding: 80px 0;
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

        /* About Section */
        .about {
            background-color: var(--bg-white);
        }

        .about-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .about-content p {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        /* Features Section */
        .features {
            background-color: var(--bg-light);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background-color: var(--bg-white);
            border-radius: var(--radius-lg);
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: var(--secondary-color);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background-color: rgba(46, 139, 87, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            transition: var(--transition);
        }

        .feature-card:hover .feature-icon {
            background-color: var(--primary-color);
            transform: rotate(5deg);
        }

        .feature-icon i {
            font-size: 1.75rem;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .feature-card:hover .feature-icon i {
            color: var(--text-light);
        }

        .feature-title {
            font-size: 1.25rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .feature-description {
            color: #666;
            line-height: 1.6;
        }

        /* Contact Section */
        .contact {
            background-color: var(--bg-white);
        }

        .contact-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .contact-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .contact-item i {
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        /* Footer */
        .footer {
            background-color: var(--primary-dark);
            color: var(--text-light);
            padding: 2rem 0;
            text-align: center;
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Animations */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
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
            .hero-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: center;
            }

            .hero-image {
                order: 2;
            }

            .hero-text {
                order: 1;
            }

            .hero-text h1 {
                font-size: 2rem;
            }

            .contact-info {
                flex-direction: column;
                align-items: center;
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
                padding: 100px 0 60px;
            }

            .hero-text h1 {
                font-size: 1.75rem;
            }

            .hero-text p {
                font-size: 1.1rem;
            }

            .section {
                padding: 60px 0;
            }

            h1 { font-size: 2rem; }
            h2 { font-size: 1.75rem; }
            h3 { font-size: 1.375rem; }
        }

        /* QR Scanner Styles */
        .qr-scanner-container {
            display: none;
            background-color: var(--bg-white);
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: var(--shadow-lg);
        }

        .qr-scanner-container.active {
            display: block;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .qr-methods {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 1.5rem;
        }

        .qr-method {
            padding: 1.5rem;
            border: 2px solid #E0E0E0;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }

        .qr-method:hover {
            border-color: var(--primary-color);
            box-shadow: var(--shadow-md);
        }

        .qr-method h4 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qr-method p {
            margin-bottom: 1rem;
            color: #666;
        }

        .qr-input-group {
            display: flex;
            gap: 0.5rem;
        }

        .qr-input-group input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid #E0E0E0;
            border-radius: var(--radius-sm);
            font-size: 1rem;
        }

        .qr-input-group button {
            padding: 0.75rem 1.25rem;
            background-color: var(--primary-color);
            color: var(--text-light);
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
        }

        .qr-input-group button:hover {
            background-color: var(--primary-dark);
        }

        #reader {
            width: 100%;
            max-width: 500px;
            margin: 1rem auto;
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        #scan-result {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: var(--radius-sm);
            background-color: #F5F5F5;
        }

        .alert {
            padding: 1rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1rem;
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

        .alert-warning {
            background-color: #FFF3CD;
            color: #856404;
            border: 1px solid #FFEEBA;
        }

        .info-section {
            background-color: #E8F5E9;
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-top: 2rem;
            border-left: 5px solid var(--primary-color);
        }

        .info-section h4 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .list-group {
            padding-left: 0;
            list-style: none;
        }

        .list-group-item {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0.5rem;
            background-color: #F5F5F5;
            border-radius: var(--radius-sm);
            border-left: 3px solid var(--primary-color);
        }

        .mobile-menu-toggle.active .fa-bars {
            display: none;
        }

        .mobile-menu-toggle.active .fa-times {
            display: block;
        }

        .mobile-menu-toggle .fa-times {
            display: none;
        }
    </style>
</head>

<body>
    @include('components.landing.navbar')

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1><strong>Pengendalian Keamanan<br/>Pangan Segar Asal Tumbuhan</strong></h1>
                    <p>Platform digital terpadu untuk mendukung pengendalian keamanan Pangan Segar Asal Tumbuhan (PSAT) di Indonesia.</p>
                </div>
                <div class="hero-image">
                    <img src="{{asset('assets/img/illustrations/satu pangan illustration.png')}}" alt="PanganAman Hero Image">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about" id="about">
        <div class="container">
            <h2 class="section-title">Tentang Sistem Pengendalian Keamanan Pangan Segar Asal Tumbuhan</h2>
            <div class="about-content">
                <p>Sistem ini adalah sebuah platform digital terpadu untuk mendukung pengendalian keamanan Pangan Segar Asal Tumbuhan (PSAT) di Indonesia. Aplikasi ini dirancang untuk digunakan oleh masyarakat umum, pelaku usaha, serta petugas pengawas dari pemerintah pusat maupun daerah. Melalui sistem ini, pelaporan, verifikasi, edukasi, serta perizinan keamanan pangan dilakukan secara transparan, cepat, dan efisien.</p>
                <p>Sistem ini dikembangkan sebagai solusi sistem digital untuk mendukung Badan Pangan Nasional dan otoritas terkait dalam menjaga keamanan pangan berbasis data, teknologi, dan partisipasi publik. Aplikasi ini menghubungkan pelaku usaha, masyarakat, dan pemerintah dalam satu ekosistem pangan segar yang aman, legal, dan terlacak.</p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section features" id="features">
        <div class="container">
            <h2 class="section-title">Fitur Utama</h2>
            <div class="features-grid">
                <div class="feature-card" onclick="toggleFeatureContent(0)">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="feature-title">Alur Registrasi QR Badan Pangan</h3>
                    <p class="feature-description">Panduan alur penerbitan QR Code Badan Pangan untuk produk yang memiliki izin edar.</p>
                </div>

                <div class="feature-card" onclick="toggleFeatureContent(1)">
                    <div class="feature-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <h3 class="feature-title">Cek Keamanan Produk</h3>
                    <p class="feature-description">Konsumen dapat memindai QR Code untuk memastikan legalitas dan keamanan pangan.</p>
                </div>

                <div class="feature-card" onclick="toggleFeatureContent(2)">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3 class="feature-title">Pelaporan & Pengawasan Terpadu</h3>
                    <p class="feature-description">Laporan pelanggaran dari masyarakat ditindaklanjuti oleh petugas OKKP.</p>
                </div>

                <div class="feature-card" onclick="window.location.href='{{ route('landing.layanan.cek_data') }}'">
                    <div class="feature-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="feature-title">Database Produk Keamanan Pangan</h3>
                    <p class="feature-description">Database produk pangan yang telah terdaftar dan memiliki izin edar.</p>
                </div>

                <div class="feature-card" onclick="window.location.href='{{ route('landing.panduan.batas_cemaran') }}'">
                    <div class="feature-icon">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h3 class="feature-title">Batas Cemaran & Residu</h3>
                    <p class="feature-description">Informasi mengenai batas maksimum cemaran dan residu pada pangan segar asal tumbuhan berdasarkan kelompok dan jenisnya.</p>
                </div>

                <div class="feature-card" onclick="toggleFeatureContent(5)">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Titik Kritis Penanganan PSAT</h3>
                    <p class="feature-description">Informasi mengenai titik kritis keamanan pangan dalam penanganan PSAT produk sayuran dan buah impor.</p>
                </div>
            </div>

            <!-- Dynamic content area for features -->
            <div id="feature-content-area"></div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact" id="contact">
        <div class="container">
            <h2 class="section-title">Hubungi Kami</h2>
            <div class="contact-content">
                <p>Untuk pertanyaan, laporan, atau dukungan teknis:</p>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span><strong>Email:</strong> kontak@panganaman.my.id</span>
                    </div>
                    <div class="contact-item">
                        <i class="fab fa-whatsapp"></i>
                        <span><strong>Whatsapp:</strong> +62-812-xxx-xxxx</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><strong>Alamat:</strong> Sekretariat Sistem PSAT, Jakarta, Indonesia</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-at"></i>
                        <span><strong>Media Sosial:</strong> @panganaman.my.id</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

        // Feature content toggle
        function toggleFeatureContent(featureIndex) {
            console.log(`Feature card clicked: ${featureIndex}`);

            // Remove any existing feature content
            const existingContent = document.getElementById('feature-content-area');
            existingContent.innerHTML = '';

            // Create new content section
            const contentSection = document.createElement('div');
            contentSection.className = 'info-section';

            let content = '';

            switch(featureIndex) {
                case 1: // Cek Keamanan Produk
                    content = generateCekKeamananProdukContent();
                    break;
                case 0: // Registrasi dan Database Produk PSAT
                    content = generateRegistrasiContent();
                    break;
                case 2: // Pelaporan & Pengawasan Terpadu
                    content = generatePelaporanContent();
                    break;
                case 5: // Titik Kritis Penanganan PSAT
                    content = generateTitikKritisContent();
                    break;
                default:
                    content = '<p class="text-center">Informasi tidak tersedia.</p>';
            }

            contentSection.innerHTML = content;
            existingContent.appendChild(contentSection);

            // Auto scroll to the newly added content
            setTimeout(() => {
                contentSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);

            // Initialize QR scanner if needed
            if (featureIndex === 1) {
                setTimeout(initializeQRScanner, 500);
            }
        }

        function generateCekKeamananProdukContent() {
            return `
                <h4><i class="fas fa-qrcode"></i> Cek Keamanan Produk</h4>
                <div class="qr-methods">
                    <div class="qr-method">
                        <h4><i class="fas fa-camera"></i> Scan QR/Barcode</h4>
                        <p>Gunakan kamera untuk memindai QR Code atau Barcode produk</p>
                        <button class="btn btn-primary" id="start-scan-btn">
                            <i class="fas fa-qrcode"></i> Mulai Scan
                        </button>
                        <div id="reader" style="width: 100%; max-width: 500px; margin-top: 20px;"></div>
                        <div id="scan-result"></div>
                    </div>
                    <div class="qr-method">
                        <h4><i class="fas fa-search"></i> Cek Kode QR</h4>
                        <p>Masukkan 10 digit kode QR untuk mengecek keamanan produk</p>
                        <div class="qr-input-group">
                            <input type="text" id="qr-code-input" placeholder="Masukkan 10 digit kode QR" maxlength="10">
                            <button class="btn btn-primary" onclick="checkQRCode()">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        function generateRegistrasiContent() {
            return `
                <h4><i class="fas fa-file-alt"></i> Alur Prosedur Pengajuan QR Code Keamanan Pangan</h4>
                <ol class="list-group">
                    <li class="list-group-item">1. User membuat akun pelaku usaha di <a href="{{ route('register-business') }}" class="text-primary">Sini</a></li>
                    <li class="list-group-item">2. Untuk usaha UMKM cukup mengisi data Izin Edar PSAT PDUK</li>
                    <li class="list-group-item">3. Untuk usaha Non UMKM, mengisi data SPPB dan data Izin Edar PSAT (PL untuk produk impor, PD untuk produk lokal)</li>
                    <li class="list-group-item">4. User mengisi form pengajuan QR Badan Pangan</li>
                    <li class="list-group-item">5. Petugas akan mereview, dan memberikan approval/penolakan dari permintaan ini</li>
                    <li class="list-group-item">6. Jika disetujui, QR code akan terbit dan dapat disematkan di kemasan Anda</li>
                </ol>
            `;
        }

        function generatePelaporanContent() {
            return `
                <h4><i class="fas fa-file-search"></i> Pelaporan & Pengawasan Terpadu</h4>
                <ol class="list-group">
                    <li class="list-group-item">1. Pengguna membuat akun di <a href="{{ route('register') }}" class="text-primary">sini</a></li>
                    <li class="list-group-item">2. Pengguna mengisi form laporan pengaduan</li>
                    <li class="list-group-item">3. Petugas akan memberikan tanggapan dari laporan pengaduan tersebut</li>
                </ol>
            `;
        }

        function generateTitikKritisContent() {
            return `
                <h4><i class="fas fa-shield-alt"></i> Titik Kritis Keamanan Pangan dalam Penanganan PSAT</h4>

                <h5>Titik kritis keamanan pangan dalam penanganan PSAT produk Sayuran</h5>
                <ol class="list-group mb-4">
                    <li class="list-group-item">1. Suhu Penyimpanan tidak sesuai (Suhu optimal 0˚ – 4˚ C)</li>
                    <li class="list-group-item">2. Pencucian tidak menggunakan air bersih</li>
                    <li class="list-group-item">3. Ruang/gudang penyimpanan kotor/tidak higienis</li>
                    <li class="list-group-item">4. Penggunaan pestisida tidak sesuai aturan pakai</li>
                    <li class="list-group-item">5. Personel yang menangani tidak higienis</li>
                    <li class="list-group-item">6. Tempat/display penjualan kotor/tidak higienis</li>
                    <li class="list-group-item">7. Suhu di tempat penjualan/display tidak sesuai</li>
                    <li class="list-group-item">8. Penggunaan pupuk tidak sesuai aturan</li>
                </ol>

                <h5>Titik kritis keamanan pangan dalam penanganan PSAT produk buah impor</h5>
                <ol class="list-group">
                    <li class="list-group-item">1. Penyimpanan melebihi kapasitas ruang/gudang penyimpanan</li>
                    <li class="list-group-item">2. Muatan melebihi kapasitas dan tumpukan barang di kontainer tidak rapi</li>
                    <li class="list-group-item">3. Ruang/gudang penyimpanan kotor/tidak higienis</li>
                    <li class="list-group-item">4. Ada produk yang rusak/busuk/tidak sesuai pada saat penerimaan</li>
                    <li class="list-group-item">5. Suhu di mobil pengangkut tidak sesuai (suhu optimal ..)</li>
                    <li class="list-group-item">6. Kendaraan pengangkut kotor/tidak higienis</li>
                    <li class="list-group-item">7. Personil yang menangani tidak higienis</li>
                    <li class="list-group-item">8. Suhu di tempat penjualan/display tidak sesuai</li>
                    <li class="list-group-item">9. Terjadi kontaminasi silang dengan produk lain</li>
                </ol>
            `;
        }

        // QR Scanner functionality
        function initializeQRScanner() {
            const scanBtn = document.getElementById("start-scan-btn");

            if (!scanBtn) {
                console.log("QR Scanner button not found yet, will retry later");
                return false;
            }

            scanBtn.addEventListener("click", function() {
                startQRScanner();
            });

            return true;
        }

        async function startQRScanner() {
            const readerElem = document.getElementById("reader");
            const resultElem = document.getElementById("scan-result");

            if (!readerElem || !resultElem) {
                console.error("QR Scanner elements not found");
                return;
            }

            // Clear previous result & reader
            resultElem.innerHTML = "";
            readerElem.innerHTML = "";

            try {
                const devices = await Html5Qrcode.getCameras();
                if (!devices || devices.length === 0) {
                    resultElem.innerHTML = `<div class="alert alert-warning">Tidak ditemukan perangkat kamera.</div>`;
                    return;
                }

                const html5QrCode = new Html5Qrcode("reader");

                await html5QrCode.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: 250 },
                    (decodedText, decodedResult) => {
                        html5QrCode.stop().then(() => {
                            html5QrCode.clear();
                            readerElem.innerHTML = '';

                            console.log(`QR Code scanned: ${decodedText}`);

                            // Check if scanned text matches the URL pattern for redirect
                            const appUrl = '{{ config("app.url") }}';
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
                                        <strong>Hasil Scan:</strong> ${decodedText}
                                    </div>`;
                            }
                        });
                    },
                    (errorMessage) => {
                        // Optional: handle scan error (misalnya tidak terbaca)
                        console.log(`Scan error: ${errorMessage}`);
                    }
                );
            } catch (err) {
                console.error(`Camera start error: ${err}`);
                resultElem.innerHTML = `<div class="alert alert-danger">Gagal memulai kamera: ${err}</div>`;
            }
        }

        function checkQRCode() {
            const qrCodeInput = document.getElementById('qr-code-input');
            const qrCode = qrCodeInput.value.trim();

            if (qrCode.length !== 10) {
                alert('Kode QR harus terdiri dari 10 digit');
                return;
            }

            if (!/^[a-zA-Z0-9]+$/.test(qrCode)) {
                alert('Kode QR hanya boleh berisi huruf dan angka');
                return;
            }

            // Redirect to QR detail page
            const baseUrl = '{{ config("app.url") }}';
            const redirectUrl = `${baseUrl}/qr/${qrCode}`;
            console.log(`Redirecting to QR detail: ${redirectUrl}`);
            window.location.href = redirectUrl;
        }
    </script>
</body>

</html>
