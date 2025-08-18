<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Data Keamanan Pangan - PanganAman</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .jumbotron {
            background-color: #F0F0F0 !important;
            /* Abu-abu terang */
            color: #2E8B57;
            /* Hijau gelap */
            padding: 80px 0;
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
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card i {
            color: #FFD700 !important;
            /* Kuning keemasan */
        }

        .card h5 {
            color: #2E8B57;
            /* Hijau gelap */
            font-weight: bold;
        }

        .border-bottom {
            border-color: #FFD700 !important;
            /* Kuning keemasan */
        }

        .footer {
            background-color: #2E8B57 !important;
            /* Hijau gelap */
            color: #F0F0F0 !important;
            /* Abu-abu terang */
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
            <h1 class="display-4 text-center">Cek Data Keamanan Pangan</h1>
            <p class="lead text-center">Informasi mengenai cara mengecek data keamanan pangan.</p>
        </div>
    </div>

    <div class="container px-4 py-5">
        <div class="row row-cols-1 g-4 pt-4">
            <div class="col">
                <p>Di halaman ini, Anda dapat menemukan informasi dan panduan tentang bagaimana cara mengecek data
                    keamanan pangan segar asal tumbuhan.</p>
                <p>Fitur ini memungkinkan konsumen untuk memindai QR Code pada produk PSAT atau mencari berdasarkan
                    kata kunci untuk memastikan legalitas dan keamanannya.</p>

                <!-- Form pencarian kata kunci -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Cari Data Keamanan Pangan</h5>
                        <p class="text-muted mb-3">Cari berdasarkan merk / nama komoditas / nama perusahaan</p>
                        <form method="POST" action="{{ route('landing.layanan.cek_data.search') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control"
                                       name="search" placeholder="Masukkan kata kunci pencarian..."
                                       value="{{ $search ?? '' }}" required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Hasil pencarian -->
                @if($results !== null)
                    @if($results->count() > 0)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Hasil Pencarian</h5>
                                <p class="text-muted">Menemukan {{ $results->count() }} hasil untuk "{{ $search }}"</p>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode QR</th>
                                                <th>Nama Komoditas</th>
                                                <th>Merk Dagang</th>
                                                <th>Jenis PSAT</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($results as $result)
                                                <tr>
                                                    <td>{{ $result->qr_code }}</td>
                                                    <td>{{ $result->nama_komoditas }}</td>
                                                    <td>{{ $result->merk_dagang }}</td>
                                                    <td>{{ $result->jenis_psat }}</td>
                                                    <td>{{ $result->business->nama_perusahaan ?? '-' }}</td>
                                                    <td>
                                                        <a href="{{ route('qr.detail', $result->qr_code) }}"
                                                           class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> Lihat Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Tidak ditemukan hasil untuk "{{ $search }}". Coba dengan kata kunci lain.
                        </div>
                    @endif
                @endif

                <!-- Tombol dan area scanner -->
                <div class="mt-4">
                    <button class="btn btn-success" id="start-scan-btn">Scan QR / Barcode</button>
                    <div id="reader" style="width: 100%; max-width: 500px; margin-top: 20px;"></div>
                    <div id="scan-result" class="mt-3"></div>
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

    <!-- html5-qrcode library -->
    <script src="https://unpkg.com/html5-qrcode"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const scanBtn = document.getElementById("start-scan-btn");
        const readerElem = document.getElementById("reader");
        const resultElem = document.getElementById("scan-result");

        let html5QrCode = null;

        const startScanner = async () => {
            // Clear previous result & reader
            resultElem.innerHTML = "";
            readerElem.innerHTML = "";

            // If already scanning, stop first
            if (html5QrCode) {
                try {
                    await html5QrCode.stop();
                    await html5QrCode.clear();
                } catch (err) {
                    console.warn("Gagal menghentikan scanner sebelumnya:", err);
                }
            }

            const devices = await Html5Qrcode.getCameras();
            if (!devices || devices.length === 0) {
                resultElem.innerHTML = `
                    <div class="alert alert-warning">Tidak ditemukan perangkat kamera.</div>`;
                return;
            }

            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            (decodedText, decodedResult) => {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                    readerElem.innerHTML = '';
                    html5QrCode = null; // penting! supaya bisa scan ulang

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
        ).catch(err => {
            console.error(`Camera start error: ${err}`);
            resultElem.innerHTML = `
                <div class="alert alert-danger">Gagal memulai kamera: ${err}</div>`;
        });
        };

        scanBtn.addEventListener("click", startScanner);
    });
</script>

</body>

</html>
