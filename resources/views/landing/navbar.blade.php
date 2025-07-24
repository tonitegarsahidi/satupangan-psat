    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2E8B57;"> {{-- Hijau gelap --}}
        <div class="container">
            <img src="{{asset('assets/img/logo/logo.png')}}" alt="SatuPangan Logo" style="width: 45px">
            &nbsp;
            <a class="navbar-brand" href="{{ route('home.index') }}"><h3>SatuPangan</h3></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home.index') }}#about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home.index') }}#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('landing.contact') }}">Kontak</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownLayanan" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Layanan
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownLayanan">
                            <a class="dropdown-item" href="{{ route('landing.layanan.cek_data') }}">Cek Data Keamanan Pangan</a>
                            <a class="dropdown-item" href="{{ route('landing.layanan.lapor_keamanan') }}">Lapor Keamanan Pangan</a>
                            <a class="dropdown-item" href="{{ route('landing.layanan.registrasi_izin') }}">Registrasi Izin Produk Pangan</a>
                            <a class="dropdown-item" href="{{ route('landing.layanan.permintaan_informasi') }}">Permintaan Informasi</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownPanduan" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Informasi Panduan
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownPanduan">
                            <a class="dropdown-item" href="{{ route('landing.panduan.alur_prosedur') }}">Alur Prosedur</a>
                            <a class="dropdown-item" href="{{ route('landing.panduan.standar_keamanan') }}">Standar Keamanan Mutu Pangan</a>
                            <a class="dropdown-item" href="{{ route('landing.panduan.batas_cemaran') }}">Batas Cemaran & Residu</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="btn ml-2" style="background-color: #FFD700; color: #2E8B57;" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn ml-2" style="background-color: #F0F0F0; color: #2E8B57;" href="{{ route('register.list') }}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
