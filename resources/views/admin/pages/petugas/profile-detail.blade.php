@extends('admin/template-base', ['searchNavbar' => false])

@section('page-title', 'Detail Petugas')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE --}}
            <div class="d-flex justify-content-between">

                <div class="bd-highlight">
                    <h3 class="card-header">Detail Petugas - {{ $user->name }}</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Nama Lengkap</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                @if ($profile)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Nomor Telepon</th>
                                    <td>{{ $profile->no_telepon ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Jenis Kelamin</th>
                                    <td>{{ $profile->jenis_kelamin ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tempat Lahir</th>
                                    <td>{{ $profile->tempat_lahir ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tanggal Lahir</th>
                                    <td>{{ $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Provinsi</th>
                                    <td>{{ $provinsiNama ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Kota</th>
                                    <td>{{ $kotaNama ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Alamat</th>
                                    <td>{{ $profile->alamat ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Kode Pos</th>
                                    <td>{{ $profile->kode_pos ?: '-' }}</td>
                                </tr>
                                @endif
                                @if ($petugas)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Unit Kerja</th>
                                    <td>{{ $petugas->unit_kerja ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Jabatan</th>
                                    <td>{{ $petugas->jabatan ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tipe Petugas</th>
                                    <td>
                                        @if ($petugas->is_kantor_pusat == '1')
                                            <span class="badge rounded-pill bg-primary">Petugas Pusat</span>
                                        @else
                                            <span class="badge rounded-pill bg-success">Petugas Daerah</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Penempatan</th>
                                    <td>
                                        @if ($petugas->is_kantor_pusat == '0' && $petugas->penempatan)
                                            {{ \App\Models\MasterProvinsi::find($petugas->penempatan)->nama_provinsi ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            </tbody>


                        @if (config('constant.CRUD.DISPLAY_TIMESTAMPS'))
                            @include('components.crud-timestamps', ['data' => $user])
                        @endif

                    </div>

                </div>

            </div>

            {{-- ROW FOR BACK BUTTON --}}
            <div class="m-4">
                <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>
            </div>

        </div>
    </div>

@endsection

@section('footer-code')

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

@endsection
