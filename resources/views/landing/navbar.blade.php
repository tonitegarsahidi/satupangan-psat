    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2E8B57;"> {{-- Hijau gelap --}}
        <div class="container">
            <img src="{{asset('assets/img/logo/satupangan_logo.png')}}" alt="SatuPangan Logo" style="width: 45px">
            &nbsp;
            <a class="navbar-brand" href="{{ route('home.index') }}"><h3>SatuPangan</h3></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home.index') }}#about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home.index') }}#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home.index') }}#contact">Hubungi Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn ml-2" style="background-color: #FFD700; color: #2E8B57;" href="{{ route('login') }}">Login</a> {{-- Kuning keemasan --}}
                    </li>
                    <li class="nav-item">
                        <a class="btn ml-2" style="background-color: #F0F0F0; color: #2E8B57;" href="{{ route('register') }}">Register</a> {{-- Abu-abu terang --}}
                    </li>
                </ul>
            </div>
        </div>
    </nav>
