@extends('admin.template-blank')

@section('page-title', 'Pilih Jenis Registrasi')

@section('main-content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner" style="max-width: 600px; margin: auto;">
            <div class="card">
                <div class="card-body text-center">
                    @include('admin.auth.logo')
                    <h4 class="mb-4">Pilih Jenis Registrasi</h4>
                    <div class="d-grid gap-4">
                        <div>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg text-black fw-bold w-100">
                                <span class="tf-icons bx bx-user"></span>&nbsp;
                                <strong>Registrasi Pengunjung Biasa</strong>
                                <p class="text-muted mt-2 mb-0">laporan pengaduan</p>
                            </a>

                        </div>
                        <div>
                            <a href="{{ route('register-business') }}" class="btn btn-outline-success btn-lg text-black fw-bold w-100">
                                <span class="tf-icons bx bx-store"></span>&nbsp;
                                <strong>Registrasi Pelaku Usaha</strong>
                                <p class="text-muted mt-2 mb-0">Pengajuan QR Code Badan Pangan</p>
                            </a>

                        </div>
                        <div>
                            <a href="{{ route('register-petugas') }}" class="btn btn-outline-info btn-lg text-black fw-bold w-100">
                                <span class="tf-icons bx bx-shield"></span>&nbsp;
                                <strong>Registrasi Petugas</strong>
                                <p class="text-muted mt-2 mb-0">untuk petugas Badan Pangan</p>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
