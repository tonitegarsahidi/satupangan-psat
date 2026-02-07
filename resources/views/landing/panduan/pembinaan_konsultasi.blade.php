<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembinaan & Konsultasi - PanganAman</title>

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

        /* List Group Styles */
        .list-group {
            padding-left: 0;
            list-style: none;
        }

        .list-group-item {
            padding: 1rem 1.5rem;
            margin-bottom: 0.75rem;
            background-color: #F5F5F5;
            border-radius: var(--radius-sm);
            border-left: 4px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            transition: var(--transition);
        }

        .list-group-item:hover {
            background-color: #E8F5E9;
            transform: translateX(5px);
        }

        .list-group-item i {
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-top: 0.25rem;
        }

        .list-group-item-content {
            flex: 1;
        }

        .list-group-item-title {
            font-weight: 600;
            color: var(--primary-color);
            flex: 1;
            margin-right: 1rem;
        }

        .list-group-item-description {
            font-size: 0.95rem;
            color: #666;
        }

        /* Download Button */
        .download-btn {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .download-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
            color: white;
            text-decoration: none;
        }

        .download-btn.disabled {
            background-color: #ccc;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Service Cards */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .service-card {
            background-color: var(--bg-white);
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            text-align: center;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(46, 139, 87, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            transition: var(--transition);
        }

        .service-card:hover .service-icon {
            background-color: var(--primary-color);
        }

        .service-icon i {
            font-size: 2rem;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .service-card:hover .service-icon i {
            color: var(--text-light);
        }

        .service-title {
            font-size: 1.25rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .service-description {
            color: #666;
            line-height: 1.6;
        }

        /* Contact Info */
        .contact-info {
            background-color: #E8F5E9;
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-top: 2rem;
            border-left: 5px solid var(--primary-color);
        }

        .contact-info h4 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
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

            .service-grid {
                grid-template-columns: 1fr;
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
        }
    </style>
</head>

<body>
    @include('components.landing.navbar')

    @include('components.landing.hero', [
        'title' => 'Pembinaan & Konsultasi',
        'subtitle' => 'Pelaku usaha dan masyarakat dapat mengetahui seputar standar dan prosedur keamanan pangan dengan baik dan benar.'
    ])

    <!-- Main Content -->
    <main class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <p class="text-center mb-5">Di halaman ini, Anda dapat menemukan informasi lengkap mengenai pembinaan dan konsultasi keamanan pangan segar asal tumbuhan.</p>
                    <p class="text-center mb-5">Ini mencakup berbagai layanan dan sumber daya untuk membantu pelaku usaha dan masyarakat memahami serta mematuhi standar keamanan pangan yang berlaku.</p>

                    <!-- Services Section -->
                    <div class="service-grid">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h3 class="service-title">Pelatihan & Edukasi</h3>
                            <p class="service-description">Program pelatihan untuk pelaku usaha tentang standar keamanan pangan, cara budidaya yang baik, dan prosedur penanganan pangan yang higienis.</p>
                        </div>

                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <h3 class="service-title">Bimbingan Teknis</h3>
                            <p class="service-description">Bimbingan teknis langsung untuk membantu pelaku usaha memahami dan menerapkan standar keamanan pangan di lapangan.</p>
                        </div>

                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h3 class="service-title">Konsultasi Ahli</h3>
                            <p class="service-description">Konsultasi dengan ahli keamanan pangan untuk mendapatkan solusi terbaik mengenai isu keamanan pangan yang dihadapi.</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">
                                <i class="fas fa-list-check"></i>
                                Dokumen Panduan dan Regulasi
                            </h3>
                            <p class="card-text">Berikut adalah daftar dokumen panduan dan regulasi terkait keamanan pangan yang dapat diunduh:</p>

                            <ol class="list-group">
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Maklumat Pelayanan Otoritas Kompeten Keamanan Pangan Pusat (OKKPP)</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/standar-pelayanan" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Direktori Laboratorium Pengujian Pangan Segar Tahun 2023</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/informasi%20publik/Kepegawaian/standar_keamanan_dan_mutu_pangan/Direktori%20Laboratorium%20Pengujian%20Pangan%20Segar%20Tahun%202023.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Panduan Pencantuman Label Pangan Segar</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/Panduan%20Pencantuman%20Label%20Pangan%20Segar%20%281%29.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Panduan Pencantuman Label Pangan Segar (versi e-Book)</div>
                                    </div>
                                    <span class="download-btn disabled">
                                        <i class="fas fa-ban"></i> Link tidak tersedia
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Panduan Implementasi Persyaratan Mutu dan Label Beras</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/Panduan%20Implementasi%20Persyaratan%20Mutu%20dan%20Label%20Beras_compressed.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Panduan Penerapan dan Penilaian Sistem Manajemen Pengawasan Keamanan Pangan Segar Daerah Provinsi dan Kabupaten/Kota</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/panduan-perbadan-no-12-tahun-20232.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Tips Cerdas Keamanan Pangan dan Baca Label</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/informasi%20publik/Kepegawaian/standar_keamanan_dan_mutu_pangan/Tips%20Cerdas%20Keamanan%20Pangan%20dan%20Baca%20Label.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 1 Tahun 2023 tentang Label Pangan Segar</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/PERBADAN%201%20TAHUN%202023_LABEL%20PANGAN%20SEGAR_BN%20140-2023.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 2 Tahun 2023 tentang Persyaratan Mutu dan Label Beras</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/PERBADAN%202%20TAHUN%202023_PERSYARATAN%20MUTU%20DAN%20LABEL%20BERAS_BN%20176-2023.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 12 Tahun 2023 tentang Penyelenggaraan Urusan Pemerintahan Konkuren Bidang Pangan Sub Urusan Keamanan Pangan</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%2012%20Tahun%202023%20tentang%20Penyelenggaraan%20Urusan%20Pemerintahan%20Konkuren%20Bidang%20Pangan%20Sub%20Urusan%20Keamanan%20Pangan.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">SK Kepala Badan Pangan Nasional tentang Pedoman Klasifikasi Pangan Segar</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/SK%20Pedoman%20Klasifikasi%20Pangan%20Segar.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Pedoman Klasifikasi Pangan Segar</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/Pedoman%20Klasifikasi%20Pangan%20Segar.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Peraturan Badan Pangan Nasional RI Nomor 2 Tahun 2024 tentang Pengawasan Pemenuhan Persyaratan Keamanan, Mutu, Gizi, Label, dan Iklan Pangan Segar</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/peraturan-badan-pangan-nasional-nomor-2-tahun-2024-tentang-pengawasan-terhadap-pemenuhan-persyaratan-keamanan-mutu-gizi-label-dan-iklan-pangan-segar.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Panduan KIE Keamanan, Mutu, Gizi, Label dan Iklan Pangan Segar</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/panduan-kie-keamanan-mutu-gizi-label-dan-iklan-pangan-segar.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 9 Tahun 2024 tentang Perubahan atas Perbadan Pengawasan Keamanan Pangan Nomor 2 Tahun 2024</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%209%20Tahun%202024%20tentang%20Perubahan%20atas%20Perbadan%20Pengawasan%20Keamanan%20Pangan%20Nomor%202%20Tahun%202024.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 10 Tahun 2024 tentang Batas Maksimal Cemaran dalam Pangan Segar di Peredaran</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%2010%20Tahun%202024%20tentang%20Batas%20Maksimal%20Cemaran%20dalam%20Pangan%20Segar%20di%20Peredaran.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 13 Tahun 2024 tentang Standar Mutu Produk Pangan Lokal dalam rangka Penganekaragaman Pangan</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%2013%20Tahun%202024%20tentang%20Standar%20Mutu%20Produk%20Pangan%20Lokal%20dalam%20rangka%20Penganekaragaman%20Pangan.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 15 Tahun 2024 tentang Batas Maksimal Residu Pestisida dalam Pangan Segar Asal Tumbuhan</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%2015%20Tahun%202024%20tentang%20Batas%20Maksimal%20Residu%20Pestisida%20dalam%20Pangan%20Segar%20Asal%20Tumbuhan.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Peraturan Badan Nomor 10 Tahun 2025 tentang Standar Produk pada Penyelenggaraan Perizinan Berusaha Berbasis Risiko Subsektor Pangan Segar</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/Perbadan%20Nomor%2010%20Tahun%202025%20tentang%20Standar%20Produk%20pada%20Penyelenggaraan%20Perizinan%20Berusaha%20Berbasis%20Risiko%20Subsektor%20Pangan%20Segar.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-group-item-content">
                                        <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 12 Tahun 2025 tentang Bahan Tambahan Pangan dan Bahan Penolong dalam Pangan Segar</div>
                                    </div>
                                    <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%2012%20Tahun%202025%20tentang%20Bahan%20Tambahan%20Pangan%20dan%20Bahan%20Penolong%20dalam%20Pangan%20Segar.pdf" target="_blank" class="download-btn">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="contact-info">
                        <h4><i class="fas fa-phone-alt"></i> Hubungi Kami untuk Konsultasi</h4>
                        <div class="contact-item">
                            <i class="fas fa-user-tie"></i>
                            <span><strong>Fasilitator Ahli:</strong> Tim ahli keamanan pangan dari Badan Pangan Nasional</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span><strong>Email:</strong> pembinaan@panganaman.my.id</span>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <span><strong>WhatsApp:</strong> +62-812-xxx-xxxx</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <span><strong>Jam Layanan:</strong> Senin - Jumat, 08:00 - 16:00 WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('components.landing.footer')

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
    </script>
</body>

</html>
