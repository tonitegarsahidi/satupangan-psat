@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Konfirmasi Hapus Laporan Pengaduan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="card">

            <div class="d-flex justify-content-between">
                <div class="bd-highlight">
                    <h3 class="card-header">Apakah Anda yakin ingin menghapus Laporan Pengaduan ini?</h3>
                </div>
            </div>

            <div class="m-4">
                <form action="{{ route('admin.laporan-pengaduan.delete', $data->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Kembali</a>

                    <button type="submit" class="btn btn-danger me-2"
                        title="delete laporan">
                        <i class='tf-icons bx bx-trash me-2'></i>Konfirmasi Hapus
                    </button>
                </form>
            </div>

            <div class="row m-2">
                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th class="bg-dark text-white">Nama Pelapor</th>
                                    <td>{{ $data->nama_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Isi Laporan</th>
                                    <td>{{ $data->isi_laporan }}</td>
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
