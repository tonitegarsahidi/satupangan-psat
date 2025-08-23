@extends('admin/template-base')

@section('page-title', 'Delete Pengawasan Rekap')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE --}}
            <div class="d-flex justify-content-between">

                <div class="bd-highlight">
                    <h3 class="card-header">Delete Pengawasan Rekap</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Pengawasan</th>
                                    <td>{{ $data->pengawasan ? $data->pengawasan->lokasi_alamat : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Admin</th>
                                    <td>{{ $data->admin ? $data->admin->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Jenis PSAT</th>
                                    <td>{{ $data->jenisPsat ? $data->jenisPsat->nama_jenis_pangan_segar : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Produk PSAT</th>
                                    <td>{{ $data->produkPsat ? $data->produkPsat->nama_bahan_pangan_segar : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Hasil Rekap</th>
                                    <td>{{ $data->hasil_rekap ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Status</th>
                                    <td>
                                        @if ($data->status == 'DRAFT')
                                            <span class="badge rounded-pill bg-secondary"> {{ $data->status }} </span>
                                        @elseif ($data->status == 'PROSES')
                                            <span class="badge rounded-pill bg-warning"> {{ $data->status }} </span>
                                        @else
                                            <span class="badge rounded-pill bg-success"> {{ $data->status }} </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">PIC Tindakan</th>
                                    <td>{{ $data->picTindakan ? $data->picTindakan->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Aktif</th>
                                    <td>
                                        @if ($data->is_active)
                                            <span class="badge rounded-pill bg-success"> Yes </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger"> No </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

            {{-- DELETE CONFIRMATION MESSAGE --}}
            <div class="alert alert-warning m-4" role="alert">
                <h4 class="alert-heading">Warning!</h4>
                <p>Are you sure you want to delete this Pengawasan Rekap? This action cannot be undone.</p>
                <hr>
                <p class="mb-0">Please confirm if you want to proceed with the deletion.</p>
            </div>

            {{-- ROW FOR DELETE BUTTON --}}
            <div class="m-4">
                <form action="{{ route('pengawasan-rekap.destroy', $data->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger me-2">
                        <i class='tf-icons bx bx-trash me-2'></i>Confirm Delete
                    </button>
                    <a onclick="goBack()" class="btn btn-outline-secondary">
                        <i class='tf-icons bx bx-left-arrow-alt me-2'></i>Cancel
                    </a>
                </form>
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
