<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Detail - PanganAman</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .jumbotron {
            background-color: #F0F0F0 !important;
            /* Abu-abu terang */
            color: #2E8B57;
            /* Hijau gelap */
            padding: 60px 0;
        }

        .jumbotron h1 {
            font-weight: bold;
            color: #2E8B57;
            /* Hijau gelap */
        }

        .jumbotron p {
            font-size: 1.2rem;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        .table th {
            color: #2E8B57;
            font-weight: bold;
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
            background-color: #2E8B57 !important;
            /* Hijau gelap */
            color: #F0F0F0 !important;
            /* Abu-abu terang */
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
            <h1 class="display-4 text-center">QR Code Detail</h1>
            <p class="lead text-center">Informasi detail dari QR Code yang Anda scanp>
        </div>
    </div>

    <div class="container px-4 py-5">
        <div class="row">
            <div class="col-12">
                @if ($data)
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Informasi QR Code: {{ $data->qr_code }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Informasi Dasar</h5>
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
                                        <tr>
                                            <th>Dibuat Pada</th>
                                            <td>{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d M Y H:i') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Diupdate Pada</th>
                                            <td>{{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d M Y H:i') : '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="mb-3">QR Code</h5>
                                    <div class="card">
                                        <div class="card-body text-center">
                                            @if ($data->qr_code)
                                                <div class="qr-container">
                                                    <img src="{{ asset('qrcode/' . $data->qr_code . '.png') }}" alt="QR Code" class="qr-code">
                                                </div>
                                                <p class="text-muted small mt-2">URL: {{ env('APP_URL', 'http://localhost') }}/qr/{{ $data->qr_code }}</p>
                                            @else
                                                <p class="text-muted">QR Code tidak tersedia</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Informasi Komoditas</h5>
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
                                    <h5 class="mb-3">Informasi Bisnis</h5>
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

                            @if ($data->referensiSppb || $data->referensiIzinedarPsatpl || $data->referensiIzinedarPsatpd || $data->referensiIzinedarPsatpduk)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="mb-3">Referensi</h5>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Jenis Referensi</th>
                                                    <th>Nomor Referensi</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data->referensiSppb)
                                                    <tr>
                                                        <td>SPPB</td>
                                                        <td>
                                                            <a href="{{ route('register-sppb.detail', ['id' => $data->referensiSppb->id]) }}">
                                                                {{ $data->referensiSppb->nomor_registrasi ?? $data->referensiSppb->id }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <span class="badge
                                                                @if ($data->referensiSppb->status == 'approved') badge-success
                                                                @elseif ($data->referensiSppb->status == 'rejected') badge-danger
                                                                @elseif ($data->referensiSppb->status == 'pending') badge-info
                                                                @else badge-secondary @endif
                                                            ">
                                                                {{ $data->referensiSppb->status }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if ($data->referensiIzinedarPsatpl)
                                                    <tr>
                                                        <td>Izin EDAR PSATPL</td>
                                                        <td>
                                                            <a href="{{ route('register-izinedar-psatpl.detail', ['id' => $data->referensiIzinedarPsatpl->id]) }}">
                                                                {{ $data->referensiIzinedarPsatpl->nomor_izinedar_pl ?? $data->referensiIzinedarPsatpl->id }}
                                                            </a>
                                                        </td>
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
                                                @endif

                                                @if ($data->referensiIzinedarPsatpd)
                                                    <tr>
                                                        <td>Izin EDAR PSATPD</td>
                                                        <td>
                                                            <a href="{{ route('register-izinedar-psatpd.detail', ['id' => $data->referensiIzinedarPsatpd->id]) }}">
                                                                {{ $data->referensiIzinedarPsatpd->nomor_izinedar_pd ?? $data->referensiIzinedarPsatpd->id }}
                                                            </a>
                                                        </td>
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
                                                @endif

                                                @if ($data->referensiIzinedarPsatpduk)
                                                    <tr>
                                                        <td>Izin EDAR PSATPDUK</td>
                                                        <td>
                                                            <a href="{{ route('register-izinedar-psatpduk.detail', ['id' => $data->referensiIzinedarPsatpduk->id]) }}">
                                                                {{ $data->referensiIzinedarPsatpduk->nomor_izinedar_pduk ?? $data->referensiIzinedarPsatpduk->id }}
                                                            </a>
                                                        </td>
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
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
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
