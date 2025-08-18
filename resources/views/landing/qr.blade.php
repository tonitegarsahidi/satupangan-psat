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

        /* Style for clickable images */
        .clickable-image {
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .clickable-image:hover {
            transform: scale(1.1);
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
    @include('components.landing.navbar')

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4 text-center">QR Code Detail</h1>
            <p class="lead text-center">Informasi detail dari QR Code yang Anda scan</p>
        </div>
    </div>

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
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
