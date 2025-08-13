<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengendalian Keamanan Pangan Segar Asal Tumbuhan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .jumbotron {
            background-color: #F0F0F0 !important; /* Abu-abu terang */
            color: #2E8B57; /* Hijau gelap */
            padding: 80px 0;
        }
        .jumbotron .row {
            display: flex;
            align-items: center;
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

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

</head>

<body>
    @include('landing.navbar')

    {{-- JUMBOTRON --}}

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('assets/img/illustrations/satu pangan illustration.png')}}" alt="PanganAman Hero Image"
                        class="img-fluid rounded">
                </div>
                <div class="col-md-6">
                    <h3 class="display-5 text-right"><strong> Pengendalian Keamanan<br/>Pangan Segar Asal Tumbuhan</strong></h3>
                    <p class="text-right">Platform digital terpadu untuk mendukung pengendalian keamanan Pangan Segar Asal Tumbuhan (PSAT) di Indonesia.</p>
                </div>
            </div>
        </div>
    </div>

<div class="container px-4 py-5" id="about">
    <h2 class="pb-3 text-center border-bottom">Tentang Sistem Pengendalian Keamanan Pangan Segar Asal Tumbuhan</h2>
    <div class="row row-cols-1 g-4 pt-4">
        <div class="col text-center">
            <p>Sistem ini adalah sebuah platform digital terpadu untuk mendukung pengendalian keamanan Pangan Segar Asal Tumbuhan (PSAT) di Indonesia. Aplikasi ini dirancang untuk digunakan oleh masyarakat umum, pelaku usaha, serta petugas pengawas dari pemerintah pusat maupun daerah. Melalui sistem ini, pelaporan, verifikasi, edukasi, serta perizinan keamanan pangan dilakukan secara transparan, cepat, dan efisien.</p>
            <p>Sistem ini dikembangkan sebagai solusi sistem digital untuk mendukung Badan Pangan Nasional dan otoritas terkait dalam menjaga keamanan pangan berbasis data, teknologi, dan partisipasi publik. Aplikasi ini menghubungkan pelaku usaha, masyarakat, dan pemerintah dalam satu ekosistem pangan segar yang aman, legal, dan terlacak.</p>
        </div>
    </div>
</div>

<div class="container px-4 py-5" id="features">
    <h2 class="pb-3 text-center border-bottom">Fitur Utama</h2>

    <div class="row row-cols-1 row-cols-md-3 g-4 pt-4">
        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-data bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Registrasi dan Database Produk PSAT</h5>
                    <p class="mb-0">Input, verifikasi, dan penerbitan QR Code untuk produk yang memiliki izin edar.</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-qr-scan bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Cek Keamanan Produk</h5>
                    <p class="mb-0">Konsumen dapat memindai QR Code untuk memastikan legalitas dan keamanan pangan.</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-file-find bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Pelaporan & Pengawasan Terpadu</h5>
                    <p class="mb-0">Laporan pelanggaran dari masyarakat ditindaklanjuti secara real-time oleh petugas OKKP.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 pt-4">
        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-chat bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Pembinaan & Konsultasi</h5>
                    <p class="mb-0">Pelaku usaha dan masyarakat dapat melakukan konsultasi seputar standar dan prosedur keamanan pangan.</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-bell bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Notifikasi & Peringatan Dini</h5>
                    <p class="mb-0">Sistem mengingatkan pengguna akan masa berlaku izin, laporan penting, hingga potensi kasus keamanan pangan.</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 p-3 d-flex flex-column align-items-center text-center">
                <i class="bx bx-shield-alt-2 bx-md mb-3"></i>
                <div>
                    <h5 class="fw-bold">Titik Kritis Penanganan PSAT</h5>
                    <p class="mb-0">Informasi mengenai titik kritis keamanan pangan dalam penanganan PSAT produk sayuran dan buah impor.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container px-4 py-5" id="contact">
    <h2 class="pb-3 text-center border-bottom">Hubungi Kami</h2>
    <div class="row row-cols-1 g-4 pt-4">
        <div class="col text-center">
            <p>Untuk pertanyaan, laporan, atau dukungan teknis:</p>
            <p><strong>Email:</strong> kontak@panganaman.my.id</p>
            <p><strong>Whatsapp:</strong> +62-812-xxx-xxxx</p>
            <p><strong>Alamat:</strong> Sekretariat Sistem PSAT, Jakarta, Indonesia</p>
            <p><strong>Media Sosial:</strong> @panganaman.my.id</p>
        </div>
    </div>
</div>

    {{-- FOOTER --}}
    <footer class="footer text-center py-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    Sistem Pengendalian Keamanan Pangan Segar Asal Tumbuhan - Dikembangkan untuk mendukung keamanan pangan di Indonesia.
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
        // Add logging to track card click events
        document.addEventListener("DOMContentLoaded", function() {
            console.log("Landing page loaded - initializing card click handlers");

            // Card click handlers with logging
            const cards = document.querySelectorAll('.card.h-100');
            cards.forEach((card, index) => {
                card.style.cursor = 'pointer';
                card.addEventListener('click', function() {
                    const cardTitle = this.querySelector('h5').textContent;
                    console.log(`Card clicked: ${cardTitle} (index: ${index})`);

                    // Toggle content section based on card
                    toggleContentSection(index, cardTitle);
                });
            });

            // Setup QR scanner using event delegation
            setupQRScanner();

            // Also initialize QR scanner directly for compatibility
            setTimeout(initializeQRScanner, 500);
        });

        function toggleContentSection(cardIndex, cardTitle) {
            console.log(`Toggling content section for card: ${cardTitle}`);

            // Remove any existing content sections
            const existingSections = document.querySelectorAll('.card-content-section');
            existingSections.forEach(section => section.remove());

            // Create new content section
            const contentSection = document.createElement('div');
            contentSection.className = 'container px-4 py-5 mt-4 card-content-section';
            contentSection.style.backgroundColor = '#b8ffdc';
            contentSection.style.borderRadius = '30px';

            let content = '';

            switch(cardIndex) {
                case 1: // Cek Keamanan Produk (second card in first row)
                    content = generateCekKeamananProdukContent();
                    break;
                case 0: // Registrasi dan Database Produk PSAT (first card in first row)
                    content = generateRegistrasiContent();
                    break;
                case 2: // Pelaporan & Pengawasan Terpadu (third card in first row)
                    content = generatePelaporanContent();
                    break;
                case 5: // Keamanan & Kinerja (third card in second row)
                    content = generateTitikKritisContent();
                    break;
                default:
                    content = '<p class="text-center">Informasi tidak tersedia.</p>';
            }

            contentSection.innerHTML = content;
            document.querySelector('#about').insertAdjacentElement('afterend', contentSection);

            // Auto scroll to the newly added content section
            setTimeout(() => {
                contentSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                console.log(`Scrolled to content section for: ${cardTitle}`);
            }, 100);

            console.log(`Content section added for: ${cardTitle}`);
        }

        function generateCekKeamananProdukContent() {
            return `
                <div class="row">
                    <div class="col-md-6">
                        <h4><i class="bx bx-qr-scan"></i> Scan QR/Barcode</h4>
                        <p>Gunakan kamera untuk memindai QR Code atau Barcode produk</p>
                        <button class="btn btn-success" id="start-scan-btn">
                            <i class="bx bx-qr-scan"></i> Mulai Scan
                        </button>
                        <div id="reader" style="width: 100%; max-width: 500px; margin-top: 20px;"></div>
                        <div id="scan-result" class="mt-3"></div>
                    </div>
                    <div class="col-md-6">
                        <h4><i class="bx bx-search"></i> Cek Kode QR</h4>
                        <p>Masukkan 10 digit kode QR untuk mengecek keamanan produk</p>
                        <div class="input-group">
                            <input type="text" class="form-control" id="qr-code-input" placeholder="Masukkan 10 digit kode QR" maxlength="10">
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="checkQRCode()">
                                    <i class="bx bx-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // QR Scanner functionality - simplified approach
        function setupQRScanner() {
            // Use event delegation to handle clicks on dynamically created buttons
            document.addEventListener('click', function(event) {
                if (event.target.id === 'start-scan-btn' || event.target.closest('#start-scan-btn')) {
                    event.preventDefault();
                    startQRScanner();
                }
            });
        }

        // QR Scanner functionality - direct approach
        function initializeQRScanner() {
            const scanBtn = document.getElementById("start-scan-btn");

            if (!scanBtn) {
                console.log("QR Scanner button not found yet, will retry later");
                return false;
            }

            // Remove any existing event listeners
            scanBtn.replaceWith(scanBtn.cloneNode(true));
            const newScanBtn = document.getElementById("start-scan-btn");

            newScanBtn.addEventListener("click", function() {
                startQRScanner();
            });

            return true;
        }

        async function startQRScanner() {
            const readerElem = document.getElementById("reader");
            const resultElem = document.getElementById("scan-result");

            if (!readerElem || !resultElem) {
                console.error("QR Scanner elements not found");
                return;
            }

            // Clear previous result & reader
            resultElem.innerHTML = "";
            readerElem.innerHTML = "";

            try {
                const devices = await Html5Qrcode.getCameras();
                if (!devices || devices.length === 0) {
                    resultElem.innerHTML = `<div class="alert alert-warning">Tidak ditemukan perangkat kamera.</div>`;
                    return;
                }

                const html5QrCode = new Html5Qrcode("reader");

                await html5QrCode.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: 250 },
                    (decodedText, decodedResult) => {
                        html5QrCode.stop().then(() => {
                            html5QrCode.clear();
                            readerElem.innerHTML = '';

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
                );
            } catch (err) {
                console.error(`Camera start error: ${err}`);
                resultElem.innerHTML = `<div class="alert alert-danger">Gagal memulai kamera: ${err}</div>`;
            }
        }

        function generateRegistrasiContent() {
            return `
                <h4><i class="bx bx-file-text"></i> Alur Prosedur Pengajuan QR Code Keamanan Pangan</h4>
                <ol class="list-group list-group-numbered" style="counter-reset: list-number 0;">
                    <li class="list-group-item">1. User membuat akun pelaku usaha di <a href="{{ route('register-business') }}" class="text-primary">Sini</a></li>
                    <li class="list-group-item">2. Untuk usaha UMKM cukup mengisi data Izin Edar PSAT PDUK</li>
                    <li class="list-group-item">3.Untuk usaha Non UMKM, mengisi data SPPB dan data Izin Edar PSAT (PL untuk produk impor, PD untuk produk lokal)</li>
                    <li class="list-group-item">4. User mengisi form pengajuan QR Badan Pangan</li>
                    <li class="list-group-item">5. Petugas akan mereview, dan memberikan approval/penolakan dari permintaan ini</li>
                    <li class="list-group-item">6. Jika disetujui, QR code akan terbit dan dapat disematkan di kemasan Anda</li>
                </ol>
            `;
        }

        function generatePelaporanContent() {
            return `
                <h4><i class="bx bx-file-find"></i> Pelaporan & Pengawasan Terpadu</h4>
                <ol class="list-group list-group-numbered" style="counter-reset: list-number 0;">
                    <li class="list-group-item">1. Pengguna membuat akun di <a href="{{ route('register') }}" class="text-primary">sini</a></li>
                    <li class="list-group-item">2. Pengguna mengisi form laporan pengaduan</li>
                    <li class="list-group-item">3. Petugas akan memberikan tanggapan dari laporan pengaduan tersebut</li>
                </ol>
            `;
        }

        function generateTitikKritisContent() {
            return `
                <h4><i class="bx bx-shield-alt-2"></i> Titik Kritis Keamanan Pangan dalam Penanganan PSAT</h4>

                <h5>Titik kritis keamanan pangan dalam penanganan PSAT produk Sayuran</h5>
                <ol class="list-group list-group-numbered mb-4" style="counter-reset: list-number 0;">
                    <li class="list-group-item">1. Suhu Penyimpanan tidak sesuai (Suhu optimal 0˚ – 4˚ C)</li>
                    <li class="list-group-item">2. Pencucian tidak menggunakan air bersih</li>
                    <li class="list-group-item">3. Ruang/gudang penyimpanan kotor/tidak higienis</li>
                    <li class="list-group-item">4. Penggunaan pestisida tidak sesuai aturan pakai</li>
                    <li class="list-group-item">5. Personel yang menangani tidak higienis</li>
                    <li class="list-group-item">6. Tempat/display penjualan kotor/tidak higienis</li>
                    <li class="list-group-item">7. Suhu di tempat penjualan/display tidak sesuai</li>
                    <li class="list-group-item">8. Penggunaan pupuk tidak sesuai aturan</li>
                </ol>

                <h5>Titik kritis keamanan pangan dalam penanganan PSAT produk buah impor</h5>
                <ol class="list-group list-group-numbered" style="counter-reset: list-number 0;">
                    <li class="list-group-item">1. Penyimpanan melebihi kapasitas ruang/gudang penyimpanan</li>
                    <li class="list-group-item">2. Muatan melebihi kapasitas dan tumpukan barang di kontainer tidak rapi</li>
                    <li class="list-group-item">3. Ruang/gudang penyimpanan kotor/tidak higienis</li>
                    <li class="list-group-item">4. Ada produk yang rusak/busuk/tidak sesuai pada saat penerimaan</li>
                    <li class="list-group-item">5. Suhu di mobil pengangkut tidak sesuai (suhu optimal ..)</li>
                    <li class="list-group-item">6. Kendaraan pengangkut kotor/tidak higienis</li>
                    <li class="list-group-item">7. Personil yang menangani tidak higienis</li>
                    <li class="list-group-item">8. Suhu di tempat penjualan/display tidak sesuai</li>
                    <li class="list-group-item">9. Terjadi kontaminasi silang dengan produk lain</li>
                </ol>
            `;
        }

        function checkQRCode() {
            const qrCodeInput = document.getElementById('qr-code-input');
            const qrCode = qrCodeInput.value.trim();

            if (qrCode.length !== 10) {
                alert('Kode QR harus terdiri dari 10 digit');
                return;
            }

            if (!/^[a-zA-Z0-9]+$/.test(qrCode)) {
                alert('Kode QR hanya boleh berisi huruf dan angka');
                return;
            }

            // Redirect to QR detail page
            const baseUrl = '{{ config("app.url") }}';
            const redirectUrl = `${baseUrl}/qr/${qrCode}`;
            console.log(`Redirecting to QR detail: ${redirectUrl}`);
            window.location.href = redirectUrl;
        }

    </script>
</body>

</html>
