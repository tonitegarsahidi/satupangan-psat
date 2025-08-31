<!-- Modern Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('home.index') }}" class="navbar-brand">
                <img src="{{asset('assets/img/logo/logo.png')}}" alt="PanganAman Logo">
                <span>PanganAman</span>
            </a>

            <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </button>

            <div class="navbar-menu" id="navbar-menu">
                <a href="{{ route('home.index') }}" class="nav-link">Home</a>
                <a href="{{ route('home.index') }}#about" class="nav-link">Tentang Kami</a>
                <a href="{{ route('home.index') }}#features" class="nav-link">Fitur</a>
                <a href="{{ route('home.index') }}#contact" class="nav-link">Kontak</a>

                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle">Layanan <i class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-menu">
                        <a href="{{ route('landing.layanan.cek_data') }}" class="dropdown-item">Cek Data Keamanan Pangan</a>
                        <a href="{{ route('landing.layanan.lapor_keamanan') }}" class="dropdown-item">Lapor Keamanan Pangan</a>
                        <a href="{{ route('landing.layanan.registrasi_izin') }}" class="dropdown-item">Registrasi Izin Produk Pangan</a>
                        <a href="{{ route('landing.layanan.permintaan_informasi') }}" class="dropdown-item">Permintaan Informasi</a>
                    </div>
                </div>

                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle">Informasi Panduan <i class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-menu">
                        <a href="{{ route('landing.panduan.alur_prosedur') }}" class="dropdown-item">Alur Prosedur</a>
                        <a href="{{ route('landing.panduan.standar_keamanan') }}" class="dropdown-item">Standar Keamanan Mutu Pangan</a>
                        <a href="{{ route('landing.panduan.batas_cemaran') }}" class="dropdown-item">Batas Cemaran & Residu</a>
                        <a href="{{ route('landing.panduan.pembinaan_konsultasi') }}" class="dropdown-item">Pembinaan & Konsultasi</a>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register.list') }}" class="btn btn-secondary">Register</a>
            </div>
        </div>
    </nav>
