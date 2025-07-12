@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail Laporan Pengaduan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="card">

            <div class="d-flex justify-content-between">
                <div class="bd-highlight">
                    <h3 class="card-header">Detail Laporan Pengaduan dengan id : {{ $data->id }}</h3>
                </div>
            </div>

            <div class="row m-2">
                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" class="bg-dark text-white">Nama Pelapor</th>
                                    <td>{{ $data->nama_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">NIK Pelapor</th>
                                    <td>{{ $data->nik_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Nomor Telepon</th>
                                    <td>{{ $data->nomor_telepon_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Email</th>
                                    <td>{{ $data->email_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Lokasi Kejadian</th>
                                    <td>{{ $data->lokasi_kejadian }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Provinsi</th>
                                    <td>{{ optional($data->provinsi)->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Kota</th>
                                    <td>{{ optional($data->kota)->nama_kota ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Isi Laporan</th>
                                    <td>{{ $data->isi_laporan }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Tindak Lanjut Pertama</th>
                                    <td>{{ $data->tindak_lanjut_pertama }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Is Active</th>
                                    <td>
                                        @if ($data->is_active)
                                            <span class="badge rounded-pill bg-success"> Aktif </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger"> Tidak Aktif </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if (config('constant.CRUD.DISPLAY_TIMESTAMPS'))
                            @include('components.crud-timestamps', $data)
                        @endif

                    </div>
                </div>
            </div>

            <div class="m-4">
                <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Kembali</a>
                <a class="btn btn-primary me-2" href="{{ route('admin.laporan-pengaduan.edit', ['id' => $data->id]) }}"
                    title="update laporan">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('admin.laporan-pengaduan.delete', ['id' => $data->id]) }}"
                    title="delete laporan">
                    <i class='tf-icons bx bx-trash me-2'></i>Delete</a>
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
