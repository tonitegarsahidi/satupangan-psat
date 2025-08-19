<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batas Cemaran & Residu Detail - PanganAman</title>

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

        .card-header {
            background-color: var(--primary-color);
            color: var(--text-light);
            padding: 1.25rem 2rem;
            font-weight: 600;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header i {
            font-size: 1.5rem;
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

        /* Table Styles */
        .table-container {
            background-color: var(--bg-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #E0E0E0;
        }

        .table th {
            background-color: rgba(46, 139, 87, 0.1);
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
        }

        .table th:first-child {
            border-top-left-radius: var(--radius-lg);
        }

        .table th:last-child {
            border-top-right-radius: var(--radius-lg);
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background-color: rgba(46, 139, 87, 0.05);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: var(--radius-lg);
        }

        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: var(--radius-lg);
        }

        .table a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .table a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .table a i {
            margin-right: 0.25rem;
        }

        .table .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: var(--radius-sm);
        }

        .table .btn-warning {
            background-color: var(--secondary-color);
            color: var(--primary-dark);
        }

        .table .btn-warning:hover {
            background-color: #FFC700;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .table .sort-icon {
            margin-left: 0.5rem;
            color: #999;
        }

        .table .no-data {
            text-align: center;
            padding: 3rem;
            color: #666;
            font-style: italic;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            padding: 0.75rem 1rem;
            margin-bottom: 2rem;
            list-style: none;
            background-color: var(--bg-white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
        }

        .breadcrumb-item {
            font-size: 0.9rem;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            display: inline-block;
            padding-right: 0.5rem;
            color: #6c757d;
            content: "/";
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
            background-color: #F8F8F8;
            border-radius: var(--radius-md);
            margin-top: 2rem;
        }

        .empty-state i {
            font-size: 3rem;
            color: #999;
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 1.1rem;
            color: #777;
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

            .table-container {
                overflow-x: auto;
            }

            .table {
                min-width: 700px; /* Ensure table is scrollable on smaller screens */
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

            .card-header {
                font-size: 1.1rem;
                padding: 1rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    @include('components.landing.navbar')

    @include('components.landing.hero', [
        'title' => 'Batas Cemaran & Residu',
        'subtitle' => 'Informasi batas maksimum cemaran untuk ' . $jenisPangan->nama_jenis_pangan_segar
    ])

    <!-- Main Content -->
    <main class="section">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('landing.panduan.batas_cemaran') }}">Batas Cemaran & Residu</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $jenisPangan->nama_jenis_pangan_segar }}</li>
                </ol>
            </nav>

            <!-- Jenis Pangan Info -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Informasi Jenis Pangan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama Jenis Pangan:</strong> {{ $jenisPangan->nama_jenis_pangan_segar }}</p>
                            @if($bahanPanganExamples->count() > 0)
                                <p><strong>Contoh Bahan Pangan:</strong> {{ implode(', ', $bahanPanganExamples->pluck('nama_bahan_pangan_segar')->toArray()) }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($jenisPangan->kelompok)
                                <p><strong>Kelompok Pangan:</strong> {{ $jenisPangan->kelompok->nama_kelompok_pangan }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Batas Cemaran Logam Berat -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-flask"></i> Batas Cemaran Logam Berat
                </div>
                <div class="card-body">
                    @if($logamBeratData->count() > 0)
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Cemaran Logam Berat</th>
                                        <th>Batas Maksimum</th>
                                        <th>Satuan</th>
                                        <th>Metode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logamBeratData as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->cemaranLogamBerat->nama_cemaran_logam_berat ?? '-' }}</td>
                                            <td>{{ $item->value_max ?? '-' }}</td>
                                            <td>{{ $item->satuan ?? '-' }}</td>
                                            <td>{{ $item->metode ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-exclamation-circle"></i>
                            <p>Tidak ada data batas cemaran logam berat untuk kategori ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Batas Cemaran Mikroba -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-microscope"></i> Batas Cemaran Mikroba
                </div>
                <div class="card-body">
                    @if($mikrobaData->count() > 0)
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Cemaran Mikroba</th>
                                        <th>Batas Maksimum</th>
                                        <th>Satuan</th>
                                        <th>Metode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mikrobaData as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->cemaranMikroba->nama_cemaran_mikroba ?? '-' }}</td>
                                            <td>{{ $item->value_max ?? '-' }}</td>
                                            <td>{{ $item->satuan ?? '-' }}</td>
                                            <td>{{ $item->metode ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-exclamation-circle"></i>
                            <p>Tidak ada data batas cemaran mikroba untuk kategori ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Batas Cemaran Mikrotoksin -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-vial"></i> Batas Cemaran Mikrotoksin
                </div>
                <div class="card-body">
                    @if($mikrotoksinData->count() > 0)
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Cemaran Mikrotoksin</th>
                                        <th>Batas Maksimum</th>
                                        <th>Satuan</th>
                                        <th>Metode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mikrotoksinData as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->cemaranMikrotoksin->nama_cemaran_mikrotoksin ?? '-' }}</td>
                                            <td>{{ $item->value_max ?? '-' }}</td>
                                            <td>{{ $item->satuan ?? '-' }}</td>
                                            <td>{{ $item->metode ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-exclamation-circle"></i>
                            <p>Tidak ada data batas cemaran mikrotoksin untuk kategori ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Batas Cemaran Pestisida -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-spray-can"></i> Batas Cemaran Pestisida
                </div>
                <div class="card-body">
                    @if($pestisidaData->count() > 0)
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Cemaran Pestisida</th>
                                        <th>Batas Maksimum</th>
                                        <th>Satuan</th>
                                        <th>Metode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pestisidaData as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->cemaranPestisida->nama_cemaran_pestisida ?? '-' }}</td>
                                            <td>{{ $item->value_max ?? '-' }}</td>
                                            <td>{{ $item->satuan ?? '-' }}</td>
                                            <td>{{ $item->metode ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-exclamation-circle"></i>
                            <p>Tidak ada data batas cemaran pestisida untuk kategori ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center mt-5">
                <a href="{{ route('landing.panduan.batas_cemaran') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
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
