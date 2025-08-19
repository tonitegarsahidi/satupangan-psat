<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batas Cemaran & Residu - PanganAman</title>

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

        .btn-outline {
            background-color: transparent;
            border: 1px solid #E0E0E0;
            color: var(--text-dark);
        }

        .btn-outline:hover {
            background-color: #F5F5F5;
            border-color: var(--primary-color);
            color: var(--primary-color);
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

        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #E0E0E0;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            transition: var(--transition);
            margin-bottom: 1rem;
            background-color: var(--bg-white);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            appearance: none;
        }

        .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.1);
        }

        .input-group {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .input-group .form-control,
        .input-group .form-select {
            flex: 1;
        }

        .input-group-append {
            display: flex;
            align-items: center;
        }

        .input-group-append .btn {
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            margin-left: -1px;
        }

        .input-group-prepend {
            display: flex;
            align-items: center;
        }

        .input-group-prepend .input-group-text {
            padding: 0.75rem 1rem;
            background-color: #E0E0E0;
            border: 1px solid #E0E0E0;
            border-right: none;
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
            font-weight: 500;
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
                min-width: 800px;
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

            .section {
                padding: 40px 0;
            }

            .card-body {
                padding: 1.5rem;
            }

            .table th,
            .table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }

            .input-group {
                flex-direction: column;
            }

            .input-group .form-control,
            .input-group .form-select {
                width: 100%;
            }

            .input-group-append,
            .input-group-prepend {
                width: 100%;
            }

            .input-group-append .btn,
            .input-group-prepend .input-group-text {
                width: 100%;
                border-radius: var(--radius-sm);
                margin-top: 0.5rem;
            }
        }
    </style>
</head>

<body>
    @include('components.landing.navbar')

    @include('components.landing.hero', [
        'title' => 'Batas Cemaran & Residu',
        'subtitle' => 'Informasi mengenai batas maksimum cemaran dan residu pada pangan segar asal tumbuhan.'
    ])

    <!-- Main Content -->
    <main class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <p class="text-center mb-5">Di halaman ini, Anda dapat menemukan informasi mengenai batas maksimum cemaran dan residu yang diizinkan pada pangan segar asal tumbuhan.</p>
                    <p class="text-center mb-5">Ini adalah panduan penting untuk memastikan produk PSAT aman untuk dikonsumsi dan memenuhi standar kesehatan.</p>

                    <h3 class="text-center mb-4">Daftar Bahan Pangan Segar</h3>

                    <!-- Filter Section -->
                    <form method="GET" action="{{ route('landing.panduan.batas_cemaran') }}" class="mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Filter Jenis:</span>
                                    </div>
                                    <select name="jenis_filter" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua Jenis</option>
                                        @foreach($jenisOptions as $jenis)
                                            <option value="{{ $jenis->nama_jenis_pangan_segar }}"
                                                    @if($jenisFilter == $jenis->nama_jenis_pangan_segar) selected @endif>
                                                {{ $jenis->nama_jenis_pangan_segar }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        @if($jenisFilter)
                                            <a href="{{ route('landing.panduan.batas_cemaran') }}?sort_by={{ $sortBy }}&sort_order={{ $sortOrder }}"
                                               class="btn btn-outline">
                                                <i class="fas fa-times"></i> Hapus Filter
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Table Section -->
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">
                                        <a href="{{ route('landing.panduan.batas_cemaran') }}?jenis_filter={{ request()->input('jenis_filter', '') }}&sort_by=nama_jenis_pangan_segar&sort_order={{ $sortBy === 'nama_jenis_pangan_segar' && $sortOrder === 'asc' ? 'desc' : 'asc' }}" class="text-decoration-none text-dark">
                                            Kelompok Pangan
                                            @if($sortBy === 'nama_jenis_pangan_segar')
                                                <i class="fas fa-sort-{{ $sortOrder === 'asc' ? 'up' : 'down' }} sort-icon"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col">Jenis Pangan Segar</th>
                                    <th scope="col">Contoh Bahan Pangan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $groupedByKelompok = $jenisPangan->groupBy('kelompok.nama_kelompok_pangan');
                                    $rowIndex = 0;
                                @endphp

                                @foreach($groupedByKelompok as $kelompokNama => $jenisCollection)
                                    @php
                                        $rowIndex++;
                                        $firstItem = $jenisCollection->first();
                                    @endphp

                                    @foreach($jenisCollection as $index => $item)
                                        <tr>
                                            @if($index == 0)
                                                <!-- First row in this kelompok group - show kelompok name -->
                                                <td rowspan="{{ count($jenisCollection) }}">{{ $rowIndex }}</td>
                                                <td rowspan="{{ count($jenisCollection) }}">{{ $kelompokNama }}</td>
                                            @endif

                                            <td><strong>{{ $item->nama_jenis_pangan_segar }}</strong></td>
                                            <td>
                                                @foreach($item->bahanPangan as $bahan)
                                                    <div>{{ $bahan->nama_bahan_pangan_segar }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('landing.panduan.batas_cemaran_detail', $item->id) }}"
                                                   target="_blank"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-book"></i> Panduan
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach

                                @if($jenisPangan->isEmpty())
                                    <tr>
                                        <td colspan="5" class="no-data">Tidak ada data bahan pangan segar.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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
