<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Detail - PanganAman</title>

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

        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
            padding: 1.5rem 2rem;
        }

        .table th {
            color: var(--primary-color);
            font-weight: 600;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-secondary {
            background-color: #6c757d;
        }

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

        .qr-container {
            text-align: center;
            margin: 20px 0;
        }

        .qr-code {
            max-width: 200px;
            height: auto;
        }

        .no-data {
            text-align: center;
            padding: 50px 0;
            color: #6c757d;
        }

        .no-data i {
            font-size: 64px;
            margin-bottom: 20px;
        }

        /* Style for clickable images */
        .clickable-image {
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .clickable-image:hover {
            transform: scale(1.1);
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

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1.1rem;
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
        'title' => 'QR Code Detail',
        'subtitle' => 'Informasi detail dari QR Code yang Anda scan'
    ])

    <div class="container px-4 py-5">
        <div class="row">
            <div class="col-12">
                @if ($data)
                    <h1>Kode: {{ $data->qr_code }}</h1>

                    <!-- Section Informasi Komoditas -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0">Informasi Komoditas</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 200px;">Nama Komoditas</th>
                                            <td>{{ $data->nama_komoditas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Latin</th>
                                            <td>{{ $data->nama_latin }}</td>
                                        </tr>
                                        <tr>
                                            <th>Merk Dagang</th>
                                            <td>{{ $data->merk_dagang }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis PSAT</th>
                                            <td>{{ $data->jenisPsat ? $data->jenisPsat->nama_jenis_pangan_segar : '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="mb-3">Informasi Pelaku Usaha</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 200px;">Perusahaan</th>
                                            <td>{{ $data->business ? $data->business->nama_perusahaan : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat Perusahaan</th>
                                            <td>{{ $data->business ? $data->business->alamat_perusahaan : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIB</th>
                                            <td>{{ $data->business ? $data->business->nib : '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if ($data->foto_1 || $data->foto_2 || $data->foto_3 || $data->foto_4 || $data->foto_5 || $data->foto_6)
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h5>Foto Produk</h5>
                                        <div class="row">
                                            @if ($data->foto_1)
                                                <div class="col-md-2 mb-3">
                                                    <img src="{{ asset($data->foto_1) }}" alt="Foto 1" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->foto_1) }}', 'Foto 1')">
                                                </div>
                                            @endif
                                            @if ($data->foto_2)
                                                <div class="col-md-2 mb-3">
                                                    <img src="{{ asset($data->foto_2) }}" alt="Foto 2" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->foto_2) }}', 'Foto 2')">
                                                </div>
                                            @endif
                                            @if ($data->foto_3)
                                                <div class="col-md-2 mb-3">
                                                    <img src="{{ asset($data->foto_3) }}" alt="Foto 3" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->foto_3) }}', 'Foto 3')">
                                                </div>
                                            @endif
                                            @if ($data->foto_4)
                                                <div class="col-md-2 mb-3">
                                                    <img src="{{ asset($data->foto_4) }}" alt="Foto 4" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->foto_4) }}', 'Foto 4')">
                                                </div>
                                            @endif
                                            @if ($data->foto_5)
                                                <div class="col-md-2 mb-3">
                                                    <img src="{{ asset($data->foto_5) }}" alt="Foto 5" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->foto_5) }}', 'Foto 5')">
                                                </div>
                                            @endif
                                            @if ($data->foto_6)
                                                <div class="col-md-2 mb-3">
                                                    <img src="{{ asset($data->foto_6) }}" alt="Foto 6" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->foto_6) }}', 'Foto 6')">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Section SPPB -->
                    @if ($data->referensiSppb)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="mb-0">Informasi SPPB</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Nomor Register SPPB</th>
                                                <td>{{ $data->referensiSppb->nomor_registrasi ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jenis PSAT</th>
                                                <td>{{$data->jenispsats ? $data->jenispsats->nama_jenis_pangan_segar : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Komoditas</th>
                                                <td>{{ $data->referensiSppb->nama_komoditas ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Ruang Lingkup Penanganan</th>
                                                <td>{{ $data->referensiSppb->penanganan->nama_penanganan ?? '-' }}
                                                    {{ $data->referensiSppb->penanganan_keterangan ? "(".$data->referensiSppb->penanganan_keterangan.")" : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Terbit</th>
                                                <td>{{ $data->referensiSppb->tanggal_terbit ? \Carbon\Carbon::parse($data->referensiSppb->tanggal_terbit)->format('d M Y') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Terakhir</th>
                                                <td>{{ $data->referensiSppb->tanggal_terakhir ? \Carbon\Carbon::parse($data->referensiSppb->tanggal_terakhir)->format('d M Y') : '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Section Izin Edar PSATPL -->
                    @if ($data->referensiIzinedarPsatpl)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="mb-0">Informasi Izin EDAR PSATPL</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Nomor Izin EDAR PL</th>
                                                <td>{{ $data->referensiIzinedarPsatpl->nomor_izinedar_pl ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Komoditas</th>
                                                <td>{{ $data->referensiIzinedarPsatpl->nama_komoditas ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Latin</th>
                                                <td>{{ $data->referensiIzinedarPsatpl->nama_latin ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Negara Asal</th>
                                                <td>{{ $data->referensiIzinedarPsatpl->negara_asal ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Merk Dagang</th>
                                                <td>{{ $data->referensiIzinedarPsatpl->merk_dagang ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Kemasan</th>
                                                <td>{{ $data->referensiIzinedarPsatpl->jenis_kemasan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ukuran Berat</th>
                                                <td>{{ $data->referensiIzinedarPsatpl->ukuran_berat ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Klaim</th>
                                                <td>{{ $data->referensiIzinedarPsatpl->klaim ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if ($data->referensiIzinedarPsatpl->foto_1 || $data->referensiIzinedarPsatpl->foto_2 || $data->referensiIzinedarPsatpl->foto_3 || $data->referensiIzinedarPsatpl->foto_4 || $data->referensiIzinedarPsatpl->foto_5 || $data->referensiIzinedarPsatpl->foto_6)
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h5>Foto Produk</h5>
                                            <div class="row">
                                                @if ($data->referensiIzinedarPsatpl->foto_1)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpl->foto_1) }}" alt="Foto 1" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpl->foto_1) }}', 'Foto 1')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpl->foto_2)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpl->foto_2) }}" alt="Foto 2" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpl->foto_2) }}', 'Foto 2')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpl->foto_3)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpl->foto_3) }}" alt="Foto 3" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpl->foto_3) }}', 'Foto 3')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpl->foto_4)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpl->foto_4) }}" alt="Foto 4" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpl->foto_4) }}', 'Foto 4')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpl->foto_5)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpl->foto_5) }}" alt="Foto 5" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpl->foto_5) }}', 'Foto 5')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpl->foto_6)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpl->foto_6) }}" alt="Foto 6" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpl->foto_6) }}', 'Foto 6')">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Tanggal Terbit</th>
                                                <td>{{ $data->referensiIzinedarPsatpl->tanggal_terbit ? \Carbon\Carbon::parse($data->referensiIzinedarPsatpl->tanggal_terbit)->format('d M Y') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Terakhir</th>
                                                <td>{{ $data->referensiIzinedarPsatpl->tanggal_terakhir ? \Carbon\Carbon::parse($data->referensiIzinedarPsatpl->tanggal_terakhir)->format('d M Y') : '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Status</th>
                                                <td>
                                                    <span class="badge
                                                        @if ($data->referensiIzinedarPsatpl->status == 'approved') badge-success
                                                        @elseif ($data->referensiIzinedarPsatpl->status == 'rejected') badge-danger
                                                        @elseif ($data->referensiIzinedarPsatpl->status == 'pending') badge-info
                                                        @else badge-secondary @endif
                                                    ">
                                                        {{ $data->referensiIzinedarPsatpl->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Section Izin Edar PSATPD -->
                    @if ($data->referensiIzinedarPsatpd)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="mb-0">Informasi Izin EDAR PSATPD</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Nomor Izin EDAR PD</th>
                                                <td>{{ $data->referensiIzinedarPsatpd->nomor_izinedar_pd ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Komoditas</th>
                                                <td>{{ $data->referensiIzinedarPsatpd->nama_komoditas ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Latin</th>
                                                <td>{{ $data->referensiIzinedarPsatpd->nama_latin ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Negara Asal</th>
                                                <td>{{ $data->referensiIzinedarPsatpd->negara_asal ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Merk Dagang</th>
                                                <td>{{ $data->referensiIzinedarPsatpd->merk_dagang ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Kemasan</th>
                                                <td>{{ $data->referensiIzinedarPsatpd->jenis_kemasan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ukuran Berat</th>
                                                <td>{{ $data->referensiIzinedarPsatpd->ukuran_berat ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Klaim</th>
                                                <td>{{ $data->referensiIzinedarPsatpd->klaim ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if ($data->referensiIzinedarPsatpd->foto_1 || $data->referensiIzinedarPsatpd->foto_2 || $data->referensiIzinedarPsatpd->foto_3 || $data->referensiIzinedarPsatpd->foto_4 || $data->referensiIzinedarPsatpd->foto_5 || $data->referensiIzinedarPsatpd->foto_6)
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h5>Foto Produk</h5>
                                            <div class="row">
                                                @if ($data->referensiIzinedarPsatpd->foto_1)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpd->foto_1) }}" alt="Foto 1" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpd->foto_1) }}', 'Foto 1')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpd->foto_2)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpd->foto_2) }}" alt="Foto 2" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpd->foto_2) }}', 'Foto 2')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpd->foto_3)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpd->foto_3) }}" alt="Foto 3" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpd->foto_3) }}', 'Foto 3')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpd->foto_4)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpd->foto_4) }}" alt="Foto 4" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpd->foto_4) }}', 'Foto 4')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpd->foto_5)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpd->foto_5) }}" alt="Foto 5" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpd->foto_5) }}', 'Foto 5')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpd->foto_6)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpd->foto_6) }}" alt="Foto 6" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpd->foto_6) }}', 'Foto 6')">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Tanggal Terbit</th>
                                                <td>{{ $data->referensiIzinedarPsatpd->tanggal_terbit ? \Carbon\Carbon::parse($data->referensiIzinedarPsatpd->tanggal_terbit)->format('d M Y') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Terakhir</th>
                                                <td>{{ $data->referensiIzinedarPsatpd->tanggal_terakhir ? \Carbon\Carbon::parse($data->referensiIzinedarPsatpd->tanggal_terakhir)->format('d M Y') : '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Status</th>
                                                <td>
                                                    <span class="badge
                                                        @if ($data->referensiIzinedarPsatpd->status == 'approved') badge-success
                                                        @elseif ($data->referensiIzinedarPsatpd->status == 'rejected') badge-danger
                                                        @elseif ($data->referensiIzinedarPsatpd->status == 'pending') badge-info
                                                        @else badge-secondary @endif
                                                    ">
                                                        {{ $data->referensiIzinedarPsatpd->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Section Izin Edar PSATPDUK -->
                    @if ($data->referensiIzinedarPsatpduk)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="mb-0">Informasi Izin EDAR PSATPDUK</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Nomor Izin EDAR PDUK</th>
                                                <td>{{ $data->referensiIzinedarPsatpduk->nomor_izinedar_pduk ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Komoditas</th>
                                                <td>{{ $data->referensiIzinedarPsatpduk->nama_komoditas ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Latin</th>
                                                <td>{{ $data->referensiIzinedarPsatpduk->nama_latin ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Negara Asal</th>
                                                <td>{{ $data->referensiIzinedarPsatpduk->negara_asal ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Merk Dagang</th>
                                                <td>{{ $data->referensiIzinedarPsatpduk->merk_dagang ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Kemasan</th>
                                                <td>{{ $data->referensiIzinedarPsatpduk->jenis_kemasan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ukuran Berat</th>
                                                <td>{{ $data->referensiIzinedarPsatpduk->ukuran_berat ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kategori Label</th>
                                                <td>{{ $data->referensiIzinedarPsatpduk->kategorilabel ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if ($data->referensiIzinedarPsatpduk->foto_1 || $data->referensiIzinedarPsatpduk->foto_2 || $data->referensiIzinedarPsatpduk->foto_3 || $data->referensiIzinedarPsatpduk->foto_4 || $data->referensiIzinedarPsatpduk->foto_5 || $data->referensiIzinedarPsatpduk->foto_6)
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h5>Foto Produk</h5>
                                            <div class="row">
                                                @if ($data->referensiIzinedarPsatpduk->foto_1)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpduk->foto_1) }}" alt="Foto 1" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpduk->foto_1) }}', 'Foto 1')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpduk->foto_2)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpduk->foto_2) }}" alt="Foto 2" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpduk->foto_2) }}', 'Foto 2')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpduk->foto_3)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpduk->foto_3) }}" alt="Foto 3" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpduk->foto_3) }}', 'Foto 3')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpduk->foto_4)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpduk->foto_4) }}" alt="Foto 4" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpduk->foto_4) }}', 'Foto 4')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpduk->foto_5)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpduk->foto_5) }}" alt="Foto 5" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpduk->foto_5) }}', 'Foto 5')">
                                                    </div>
                                                @endif
                                                @if ($data->referensiIzinedarPsatpduk->foto_6)
                                                    <div class="col-md-2 mb-3">
                                                        <img src="{{ asset($data->referensiIzinedarPsatpduk->foto_6) }}" alt="Foto 6" class="img-fluid rounded clickable-image" onclick="showImageModal('{{ asset($data->referensiIzinedarPsatpduk->foto_6) }}', 'Foto 6')">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Tanggal Terbit</th>
                                                <td>{{ $data->referensiIzinedarPsatpduk->tanggal_terbit ? \Carbon\Carbon::parse($data->referensiIzinedarPsatpduk->tanggal_terbit)->format('d M Y') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Terakhir</th>
                                                <td>{{ $data->referensiIzinedarPsatpduk->tanggal_terakhir ? \Carbon\Carbon::parse($data->referensiIzinedarPsatpduk->tanggal_terakhir)->format('d M Y') : '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width: 200px;">Status</th>
                                                <td>
                                                    <span class="badge
                                                        @if ($data->referensiIzinedarPsatpduk->status == 'approved') badge-success
                                                        @elseif ($data->referensiIzinedarPsatpduk->status == 'rejected') badge-danger
                                                        @elseif ($data->referensiIzinedarPsatpduk->status == 'pending') badge-info
                                                        @else badge-secondary @endif
                                                    ">
                                                        {{ $data->referensiIzinedarPsatpduk->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Section Informasi Dasar (dipindah ke bawah) -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Informasi Dasar</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 200px;">Status</th>
                                            <td>
                                                @if ($data->status == 'approved')
                                                    <span class="badge badge-success">{{ $data->status }}</span>
                                                @elseif ($data->status == 'rejected')
                                                    <span class="badge badge-danger">{{ $data->status }}</span>
                                                @elseif ($data->status == 'pending')
                                                    <span class="badge badge-info">{{ $data->status }}</span>
                                                @elseif ($data->status == 'reviewed')
                                                    <span class="badge badge-warning">{{ $data->status }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $data->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Published</th>
                                            <td>
                                                @if ($data->is_published)
                                                    <span class="badge badge-success">Ya</span>
                                                @else
                                                    <span class="badge badge-secondary">Tidak</span>
                                                @endif
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <th>Dibuat Pada</th>
                                            <td>{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d M Y H:i') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Diupdate Pada</th>
                                            <td>{{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d M Y H:i') : '-' }}</td>
                                        </tr> --}}
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="no-data">
                        <i class='bx bx-error bx-tada'></i>
                        <h3>Tidak ada data QR-Code</h3>
                        <p>QR Code yang Anda cari tidak ditemukan atau mungkin sudah tidak tersedia.</p>
                        <a href="{{ route('landing.layanan.cek_data') }}" class="btn btn-primary">Kembali ke Halaman Cek Data</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('components.landing.footer')

    <!-- Custom JavaScript -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const navbarMenu = document.getElementById('navbar-menu');

            if (mobileMenuToggle && navbarMenu) {
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
            }
        });
    </script>

    <!-- Image Modal JavaScript -->
    <script>
        function showImageModal(imageSrc, imageAlt) {
            // Create modal if it doesn't exist
            let imageModal = document.getElementById('imageModal');
            if (!imageModal) {
                imageModal = document.createElement('div');
                imageModal.id = 'imageModal';
                imageModal.className = 'modal fade';
                imageModal.setAttribute('tabindex', '-1');
                imageModal.setAttribute('aria-labelledby', 'imageModalLabel');
                imageModal.setAttribute('aria-hidden', 'true');

                imageModal.innerHTML = `
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">${imageAlt}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="${imageSrc}" alt="${imageAlt}" class="img-fluid">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                `;

                document.body.appendChild(imageModal);
            }

            // Update modal content
            const modalImage = imageModal.querySelector('.modal-body img');
            const modalTitle = imageModal.querySelector('.modal-title');
            modalImage.src = imageSrc;
            modalImage.alt = imageAlt;
            modalTitle.textContent = imageAlt;

            // Show the modal
            $(imageModal).modal('show');
        }
    </script>
</body>

</html>

