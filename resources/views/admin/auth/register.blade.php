@extends('admin.template-blank')

@section('page-title', 'Register Now!')

@section('header-code')
    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
@endsection


@section('main-content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">

                        @include('admin.auth.logo')

                        <!-- /Logo -->
                        <h4 class="mb-2">Sobat Pangan dimulai disini 🚀</h4>
                        <p class="mb-4">Mulai perjalanan Pangan Anda sekarang!</p>

                         <!-- Notification element -->
                         @if ($errors->any() || session('loginError'))
                         <div class="alert alert-danger" role="alert">
                             <ul>
                                 @if ($errors->any())
                                     @foreach ($errors->all() as $error)
                                         <li>{{ $error }}</li>
                                     @endforeach
                                 @endif
                                 @if (session('loginError'))
                                     <li>{{ session('loginError') }}</li>
                                 @endif
                             </ul>
                         </div>
                     @endif

                        <form id="formAuthentication" class="mb-3"  action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"  value="{{old('name')}}"
                                    placeholder="Masukkan nama lengkap Anda" autofocus required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"  value="{{old('email')}}"
                                    placeholder="Masukkan email aktif Anda" required />
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('jenis_kelamin') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('jenis_kelamin') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{old('no_hp')}}"
                                    placeholder="Masukkan nomor HP aktif Anda" required />
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{old('pekerjaan')}}"
                                    placeholder="Masukkan pekerjaan Anda" required />
                            </div>
                            <div class="mb-3">
                                <label for="alamat_domisili" class="form-label">Alamat Domisili <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="alamat_domisili" name="alamat_domisili" value="{{old('alamat_domisili')}}"
                                    placeholder="Masukkan alamat domisili Anda" required />
                            </div>
                            <div class="mb-3">
                                <label for="provinsi_id" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <select id="provinsi_id" name="provinsi_id" class="form-select" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinsis as $provinsi)
                                        <option value="{{ $provinsi->id }}"
                                            {{ old('provinsi_id') == $provinsi->id ? 'selected' : '' }}>
                                            {{ $provinsi->nama_provinsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kota_id" class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <select id="kota_id" name="kota_id" class="form-select" required>
                                    <option value="">Pilih Kabupaten/Kota</option>
                                    @foreach ($kotas as $kota)
                                        <option value="{{ $kota->id }}"
                                            {{ old('kota_id') == $kota->id ? 'selected' : '' }}>
                                            {{ $kota->nama_kota }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" value="{{old('password')}}"
                                        placeholder="Masukkan password" aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            {{-- <div class="mb-3 form-password_confirmation-toggle">
                                <label class="form-label" for="password_confirmation">password_confirmation</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"  value="{{old('password_confirmation')}}" r
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password_confirmation" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div> --}}

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions"
                                        name="agree" />
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to
                                        <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100">Daftar</button>
                        </form>

                        <p class="text-center">
                            <span>Sudah punya akun?</span>
                            <a href="{{route('login')}}">
                                <span>Masuk di sini</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>
@endsection

@section('footer-code')
<script>
    // Dependent dropdown: Provinsi -> Kota
    document.getElementById('provinsi_id').addEventListener('change', function() {
        var provinsiId = this.value;
        var kotaSelect = document.getElementById('kota_id');
        kotaSelect.innerHTML = '<option value="">Memuat...</option>';
        if (provinsiId) {
            fetch('/register/kota-by-provinsi/' + provinsiId)
                .then(response => response.json())
                .then(data => {
                    kotaSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                    data.forEach(function(kota) {
                        var option = document.createElement('option');
                        option.value = kota.id;
                        option.text = kota.nama_kota;
                        kotaSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    kotaSelect.innerHTML = '<option value="">Gagal memuat kota</option>';
                });
        } else {
            kotaSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        }
    });
</script>
@endsection
