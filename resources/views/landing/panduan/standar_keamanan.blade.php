<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standar Keamanan Mutu Pangan - PanganAman</title>
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
            <h1 class="display-4 text-center">Standar Keamanan Mutu Pangan</h1>
            <p class="lead text-center">Informasi mengenai standar keamanan dan mutu pangan segar asal tumbuhan.</p>
        </div>
    </div>

    <div class="container px-4 py-5">
        <div class="row row-cols-1 g-4 pt-4">
            <div class="col">
                <p>Di halaman ini, Anda dapat menemukan informasi lengkap mengenai standar keamanan dan mutu pangan segar asal tumbuhan yang berlaku di Indonesia.</p>
                <p>Ini mencakup berbagai regulasi dan pedoman yang harus dipatuhi oleh pelaku usaha untuk memastikan produk yang aman dan berkualitas.</p>
                <!-- Tambahkan konten spesifik untuk "Standar Keamanan Mutu Pangan" di sini -->
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
