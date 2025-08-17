<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batas Cemaran & Residu - PanganAman</title>
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
            padding: 80px 0;
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
</head>

<body>
    @include('landing.navbar')

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4 text-center">Batas Cemaran & Residu</h1>
            <p class="lead text-center">Informasi mengenai batas maksimum cemaran dan residu pada pangan segar asal tumbuhan.</p>
        </div>
    </div>

    <div class="container px-4 py-5">
        <div class="row row-cols-1 g-4 pt-4">
            <div class="col">
                <p>Di halaman ini, Anda dapat menemukan informasi mengenai batas maksimum cemaran dan residu yang diizinkan pada pangan segar asal tumbuhan.</p>
                <p>Ini adalah panduan penting untuk memastikan produk PSAT aman untuk dikonsumsi dan memenuhi standar kesehatan.</p>

                <h3 class="mt-4 mb-3">Daftar Bahan Pangan Segar</h3>

                <!-- Filter Section -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('landing.panduan.batas_cemaran') }}" class="form-inline">
                            @php
                                $currentFilter = request()->input('jenis_filter', '');
                                $currentSortBy = request()->input('sort_by', 'nama_bahan_pangan_segar');
                                $currentSortOrder = request()->input('sort_order', 'asc');
                            @endphp

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Filter Jenis:</span>
                                </div>
                                <select name="jenis_filter" class="form-control" onchange="this.form.submit()">
                                    <option value="">Semua Jenis</option>
                                    @foreach($jenisOptions as $jenis)
                                        <option value="{{ $jenis->nama_jenis_pangan_segar }}"
                                                @if($currentFilter == $jenis->nama_jenis_pangan_segar) selected @endif>
                                            {{ $jenis->nama_jenis_pangan_segar }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    @if($currentFilter)
                                        <a href="{{ route('landing.panduan.batas_cemaran') }}?sort_by={{ $currentSortBy }}&sort_order={{ $currentSortOrder }}"
                                           class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i> Hapus Filter
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-success">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">
                                    <a href="{{ route('landing.panduan.batas_cemaran') }}?jenis_filter={{ request()->input('jenis_filter', '') }}&sort_by=jenis.nama_jenis_pangan_segar&sort_order={{ $sortBy === 'jenis.nama_jenis_pangan_segar' && $sortOrder === 'asc' ? 'desc' : 'asc' }}" class="text-decoration-none text-dark">
                                        Jenis
                                        @if($sortBy === 'jenis.nama_jenis_pangan_segar')
                                            <i class="fas fa-sort-{{ $sortOrder === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="{{ route('landing.panduan.batas_cemaran') }}?jenis_filter={{ request()->input('jenis_filter', '') }}&sort_by=nama_bahan_pangan_segar&sort_order={{ $sortBy === 'nama_bahan_pangan_segar' && $sortOrder === 'asc' ? 'desc' : 'asc' }}" class="text-decoration-none text-dark">
                                        Nama Bahan Pangan Segar
                                        @if($sortBy === 'nama_bahan_pangan_segar')
                                            <i class="fas fa-sort-{{ $sortOrder === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bahanPangan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->jenis->nama_jenis_pangan_segar ?? '-' }}</td>
                                <td>{{ $item->nama_bahan_pangan_segar }}</td>
                                <td>
                                    <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data bahan pangan segar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
