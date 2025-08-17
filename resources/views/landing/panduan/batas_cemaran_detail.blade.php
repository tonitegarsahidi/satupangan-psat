<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batas Cemaran & Residu Detail - PanganAman</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .jumbotron {
            background-color: #F0F0F0 !important; /* Abu-abu terang */
            color: #2E8B57; /* Hijau gelap */
            padding: 60px 0;
        }
        .jumbotron h1 {
            font-weight: bold;
            color: #2E8B57; /* Hijau gelap */
        }
        .jumbotron p {
            font-size: 1.1rem;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease-in-out;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background-color: #2E8B57;
            color: white;
            font-weight: bold;
        }
        .card i {
            color: #FFD700 !important; /* Kuning keemasan */
        }
        .border-bottom {
            border-color: #FFD700 !important; /* Kuning keemasan */
        }
        .footer {
            background-color: #2E8B57 !important; /* Hijau gelap */
            color: #F0F0F0 !important; /* Abu-abu terang */
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .empty-state {
            text-align: center;
            padding: 30px;
            color: #6c757d;
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
</head>

<body>
    @include('landing.navbar')

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4 text-center">Batas Cemaran & Residu Detail</h1>
            <p class="lead text-center">Informasi detail mengenai batas maksimum cemaran dan residu pada pangan segar asal tumbuhan untuk kategori: {{ $jenisPangan->nama_jenis_pangan_segar }}</p>
        </div>
    </div>

    <div class="container px-4 py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('landing.panduan.batas_cemaran') }}">Batas Cemaran & Residu</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $jenisPangan->nama_jenis_pangan_segar }}</li>
            </ol>
        </nav>

        <!-- Jenis Pangan Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Jenis Pangan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama Jenis Pangan:</strong> {{ $jenisPangan->nama_jenis_pangan_segar }}</p>
                                <p><strong>Kode:</strong> {{ $jenisPangan->kode_jenis_pangan_segar }}</p>
                                <p><strong>Status:</strong>
                                    <span class="badge {{ $jenisPangan->is_active ? 'badge-success' : 'badge-danger' }}">
                                        {{ $jenisPangan->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                @if($jenisPangan->kelompok)
                                    <p><strong>Kelompok Pangan:</strong> {{ $jenisPangan->kelompok->nama_kelompok_pangan }}</p>
                                @endif
                                <p><strong>Dibuat pada:</strong> {{ \Carbon\Carbon::parse($jenisPangan->created_at)->translatedFormat('d F Y') }}</p>
                                <p><strong>Terakhir diperbarui:</strong> {{ \Carbon\Carbon::parse($jenisPangan->updated_at)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contoh Bahan Pangan Segar -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-apple-alt"></i> Contoh Bahan Pangan Segar</h5>
                    </div>
                    <div class="card-body">
                        @if($bahanPanganExamples->count() > 0)
                            <div class="row">
                                @foreach($bahanPanganExamples as $example)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $example->nama_bahan_pangan_segar }}</h6>
                                                <p class="card-text">
                                                    <small class="text-muted">ID: {{ $example->id }}</small>
                                                </p>
                                                <p class="card-text">
                                                    <span class="badge {{ $example->is_active ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $example->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($bahanPanganExamples->count() >= 5)
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Menampilkan 5 contoh pertama dari total {{ $bahanPanganExamples->count() }} bahan pangan segar dalam kategori ini.
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                <p>Tidak ada contoh bahan pangan segar yang ditemukan untuk kategori ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Batas Cemaran Logam Berat -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-flask"></i> Batas Cemaran Logam Berat</h5>
                    </div>
                    <div class="card-body">
                        @if($logamBeratData->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Cemaran Logam Berat</th>
                                            <th>Batas Maksimum (mg/kg)</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($logamBeratData as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->cemaranLogamBerat->nama_cemaran_logam_berat ?? '-' }}</td>
                                                <td>{{ $item->batas_maksimum ?? '-' }}</td>
                                                <td>{{ $item->satuan ?? '-' }}</td>
                                                <td>{{ $item->keterangan ?? '-' }}</td>
                                                <td>
                                                    <span class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                <p>Tidak ada data batas cemaran logam berat untuk kategori ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Batas Cemaran Mikroba -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-microscope"></i> Batas Cemaran Mikroba</h5>
                    </div>
                    <div class="card-body">
                        @if($mikrobaData->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Cemaran Mikroba</th>
                                            <th>Batas Maksimum (CFU/g)</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mikrobaData as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->cemaranMikroba->nama_cemaran_mikroba ?? '-' }}</td>
                                                <td>{{ $item->batas_maksimum ?? '-' }}</td>
                                                <td>{{ $item->satuan ?? '-' }}</td>
                                                <td>{{ $item->keterangan ?? '-' }}</td>
                                                <td>
                                                    <span class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                <p>Tidak ada data batas cemaran mikroba untuk kategori ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Batas Cemaran Mikrotoksin -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-vial"></i> Batas Cemaran Mikrotoksin</h5>
                    </div>
                    <div class="card-body">
                        @if($mikrotoksinData->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Cemaran Mikrotoksin</th>
                                            <th>Batas Maksimum (mg/kg)</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mikrotoksinData as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->cemaranMikrotoksin->nama_cemaran_mikrotoksin ?? '-' }}</td>
                                                <td>{{ $item->batas_maksimum ?? '-' }}</td>
                                                <td>{{ $item->satuan ?? '-' }}</td>
                                                <td>{{ $item->keterangan ?? '-' }}</td>
                                                <td>
                                                    <span class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                <p>Tidak ada data batas cemaran mikrotoksin untuk kategori ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Batas Cemaran Pestisida -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-spray-can"></i> Batas Cemaran Pestisida</h5>
                    </div>
                    <div class="card-body">
                        @if($pestisidaData->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Cemaran Pestisida</th>
                                            <th>Batas Maksimum (mg/kg)</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pestisidaData as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->cemaranPestisida->nama_cemaran_pestisida ?? '-' }}</td>
                                                <td>{{ $item->batas_maksimum ?? '-' }}</td>
                                                <td>{{ $item->satuan ?? '-' }}</td>
                                                <td>{{ $item->keterangan ?? '-' }}</td>
                                                <td>
                                                    <span class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                <p>Tidak ada data batas cemaran pestisida untuk kategori ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <a href="{{ route('landing.panduan.batas_cemaran') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <footer class="footer text-center py-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    PanganAman - Dikembangkan untuk mendukung keamanan pangan di Indonesia.
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
