@extends('admin/template-base')

@section('page-title', 'Delete Pengawasan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE --}}
            <div class="d-flex justify-content-between">

                <div class="bd-highlight">
                    <h3 class="card-header">Delete Pengawasan</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Location Address</th>
                                    <td>{{ $data->lokasi_alamat }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">City</th>
                                    <td>{{ $data->lokasiKota ? $data->lokasiKota->nama : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Province</th>
                                    <td>{{ $data->lokasiProvinsi ? $data->lokasiProvinsi->nama : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Start Date</th>
                                    <td>{{ $data->tanggal_mulai ? \Carbon\Carbon::parse($data->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">End Date</th>
                                    <td>{{ $data->tanggal_selesai ? \Carbon\Carbon::parse($data->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">PSAT Type</th>
                                    <td>{{ $data->jenisPsat ? $data->jenisPsat->nama : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">PSAT Product</th>
                                    <td>{{ $data->produkPsat ? $data->produkPsat->nama : '-' }}</td>
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
                                    <th scope="col" class="bg-dark text-white">Is Active</th>
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
                <p>Are you sure you want to delete this Pengawasan? This action cannot be undone.</p>
                <hr>
                <p class="mb-0">Please confirm if you want to proceed with the deletion.</p>
            </div>

            {{-- ROW FOR DELETE BUTTON --}}
            <div class="m-4">
                <form action="{{ route('pengawasan.destroy', $data->id) }}" method="POST">
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
