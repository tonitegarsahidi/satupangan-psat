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
                    <div class="d-grid gap-3">
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Registrasi Pengunjung Biasa</a>
                        <a href="{{ route('register-business') }}" class="btn btn-outline-success btn-lg">Registrasi Pengusaha</a>
                        <a href="{{ route('register-petugas') }}" class="btn btn-outline-info btn-lg">Registrasi Petugas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
