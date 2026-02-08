<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembinaan & Konsultasi - PanganAman</title>

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

        /* Container and Layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .section {
            padding: 4rem 0;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Card Styles */
        .card {
            background: var(--bg-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-text {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        /* Document Group Styles */
        .document-group {
            margin-bottom: 2.5rem;
        }

        .document-group-title {
            font-size: 1.25rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-light);
        }

        .document-group-title i {
            font-size: 1.5rem;
        }

        /* List Group Styles */
        .list-group {
            padding-left: 0;
            list-style: none;
        }

        .list-group-item {
            padding: 1.25rem 1.5rem;
            margin-bottom: 0.75rem;
            background-color: #F5F5F5;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .list-group-item:hover {
            background-color: #E8F5E9;
            transform: translateX(5px);
        }

        .list-group-item-content {
            flex: 1;
            min-width: 0;
        }

        .list-group-item-title {
            font-weight: 600;
            color: var(--primary-color);
            line-height: 1.4;
            font-size: 0.95rem;
        }

        /* Download Button */
        .download-btn {
            background-color: var(--primary-color);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
            border: none;
            cursor: pointer;
            min-width: 100px;
            justify-content: center;
        }

        .download-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            color: white;
            text-decoration: none;
        }

        .download-btn i {
            font-size: 1rem;
            line-height: 1;
        }

        /* Text Utilities */
        .text-center {
            text-align: center;
        }

        .mb-5 {
            margin-bottom: 3rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .card-title {
                font-size: 1.25rem;
            }

            .list-group-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem;
            }

            .list-group-item-content {
                width: 100%;
            }

            .list-group-item-title {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }

            .download-btn {
                align-self: flex-end;
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
                min-width: auto;
            }

            .document-group-title {
                font-size: 1.1rem;
            }

            .section {
                padding: 3rem 0;
            }
        }

        @media (max-width: 480px) {
            .download-btn {
                width: 100%;
                justify-content: center;
            }

            .list-group-item {
                padding: 0.875rem;
            }

            .document-group-title {
                font-size: 1rem;
            }

            .hero {
                padding: 3rem 0;
            }

            .card-body {
                padding: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="hero-title">Pembinaan & Konsultasi</h1>
            <p class="hero-subtitle">Pelaku usaha dan masyarakat dapat mengetahui seputar standar dan prosedur keamanan pangan dengan baik dan benar.</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <p>Ini mencakup berbagai layanan dan sumber daya untuk membantu pelaku usaha dan masyarakat memahami serta mematuhi standar keamanan pangan yang berlaku.</p>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt"></i>
                        Dokumen Panduan dan Regulasi
                    </h3>
                    <p class="card-text">Berikut adalah daftar dokumen panduan dan regulasi terkait keamanan pangan yang dapat diunduh:</p>

                    <!-- Kelompok Panduan -->
                    <div class="document-group">
                        <h4 class="document-group-title">
                            <i class="fas fa-book"></i>
                            Panduan
                        </h4>
                        <ol class="list-group">
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Direktori Laboratorium Pengujian Pangan Segar Tahun 2023</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/informasi%20publik/Kepegawaian/standar_keamanan_dan_mutu_pangan/Direktori%20Laboratorium%20Pengujian%20Pangan%20Segar%20Tahun%202023.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Panduan Pencantuman Label Pangan Segar</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/Panduan%20Pencantuman%20Label%20Pangan%20Segar%20%281%29.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Panduan Implementasi Persyaratan Mutu dan Label Beras</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/Panduan%20Implementasi%20Persyaratan%20Mutu%20dan%20Label%20Beras_compressed.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Panduan Penerapan dan Penilaian Sistem Manajemen Pengawasan Keamanan Pangan Segar Daerah Provinsi dan Kabupaten/Kota</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/panduan-perbadan-no-12-tahun-20232.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Panduan KIE Keamanan, Mutu, Gizi, Label dan Iklan Pangan Segar</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/panduan-kie-keamanan-mutu-gizi-label-dan-iklan-pangan-segar.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                        </ol>
                    </div>

                    <!-- Kelompok Peraturan -->
                    <div class="document-group">
                        <h4 class="document-group-title">
                            <i class="fas fa-gavel"></i>
                            Peraturan
                        </h4>
                        <ol class="list-group">
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 1 Tahun 2023 tentang Label Pangan Segar</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/PERBADAN%201%20TAHUN%202023_LABEL%20PANGAN%20SEGAR_BN%20140-2023.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 2 Tahun 2023 tentang Persyaratan Mutu dan Label Beras</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/PERBADAN%202%20TAHUN%202023_PERSYARATAN%20MUTU%20DAN%20LABEL%20BERAS_BN%20176-2023.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 12 Tahun 2023 tentang Penyelenggaraan Urusan Pemerintahan Konkuren Bidang Pangan Sub Urusan Keamanan Pangan</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%2012%20Tahun%202023%20tentang%20Penyelenggaraan%20Urusan%20Pemerintahan%20Konkuren%20Bidang%20Pangan%20Sub%20Urusan%20Keamanan%20Pangan.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">SK Kepala Badan Pangan Nasional tentang Pedoman Klasifikasi Pangan Segar</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/SK%20Pedoman%20Klasifikasi%20Pangan%20Segar.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Pedoman Klasifikasi Pangan Segar</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/Pedoman%20Klasifikasi%20Pangan%20Segar.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Peraturan Badan Pangan Nasional RI Nomor 2 Tahun 2024 tentang Pengawasan Pemenuhan Persyaratan Keamanan, Mutu, Gizi, Label, dan Iklan Pangan Segar</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/peraturan-badan-pangan-nasional-nomor-2-tahun-2024-tentang-pengawasan-terhadap-pemenuhan-persyaratan-keamanan-mutu-gizi-label-dan-iklan-pangan-segar.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 9 Tahun 2024 tentang Perubahan atas Perbadan Pengawasan Keamanan Pangan Nomor 2 Tahun 2024</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%209%20Tahun%202024%20tentang%20Perubahan%20atas%20Perbadan%20Pengawasan%20Keamanan%20Pangan%20Nomor%202%20Tahun%202024.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 10 Tahun 2024 tentang Batas Maksimal Cemaran dalam Pangan Segar di Peredaran</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%2010%20Tahun%202024%20tentang%20Batas%20Maksimal%20Cemaran%20dalam%20Pangan%20Segar%20di%20Peredaran.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 13 Tahun 2024 tentang Standar Mutu Produk Pangan Lokal dalam rangka Penganekaragaman Pangan</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%2013%20Tahun%202024%20tentang%20Standar%20Mutu%20Produk%20Pangan%20Lokal%20dalam%20rangka%20Penganekaragaman%20Pangan.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 15 Tahun 2024 tentang Batas Maksimal Residu Pestisida dalam Pangan Segar Asal Tumbuhan</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%2015%20Tahun%202024%20tentang%20Batas%20Maksimal%20Residu%20Pestisida%20dalam%20Pangan%20Segar%20Asal%20Tumbuhan.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Peraturan Badan Nomor 10 Tahun 2025 tentang Standar Produk pada Penyelenggaraan Perizinan Berusaha Berbasis Risiko Subsektor Pangan Segar</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/Perbadan%20Nomor%2010%20Tahun%202025%20tentang%20Standar%20Produk%20pada%20Penyelenggaraan%20Perizinan%20Berusaha%20Berbasis%20Risiko%20Subsektor%20Pangan%20Segar.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Peraturan Badan Pangan Nasional Nomor 12 Tahun 2025 tentang Bahan Tambahan Pangan dan Bahan Penolong dalam Pangan Segar</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/Peraturan%20Badan%20Pangan%20Nasional%20Nomor%2012%20Tahun%202025%20tentang%20Bahan%20Tambahan%20Pangan%20dan%20Bahan%20Penolong%20dalam%20Pangan%20Segar.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                        </ol>
                    </div>

                    <!-- Kelompok Tips -->
                    <div class="document-group">
                        <h4 class="document-group-title">
                            <i class="fas fa-lightbulb"></i>
                            Tips
                        </h4>
                        <ol class="list-group">
                            <li class="list-group-item">
                                <div class="list-group-item-content">
                                    <div class="list-group-item-title">Tips Cerdas Keamanan Pangan dan Baca Label</div>
                                </div>
                                <a href="https://badanpangan.go.id/storage/app/media/informasi%20publik/Kepegawaian/standar_keamanan_dan_mutu_pangan/Tips%20Cerdas%20Keamanan%20Pangan%20dan%20Baca%20Label.pdf" target="_blank" class="download-btn">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
