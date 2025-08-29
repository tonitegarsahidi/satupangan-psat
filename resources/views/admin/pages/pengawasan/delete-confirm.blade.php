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
                                    <td>{{ $data->lokasiKota ? $data->lokasiKota->nama_kota : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Province</th>
                                    <td>{{ $data->lokasiProvinsi ? $data->lokasiProvinsi->nama_provinsi : '-' }}</td>
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
                                    <td>{{ $data->jenisPsat ? $data->jenisPsat->nama_jenis_pangan_segar : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">PSAT Product</th>
                                    <td>{{ $data->produkPsat ? $data->produkPsat->nama_bahan_pangan_segar : '-' }}</td>
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
                                <!-- Lampiran Section -->
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 1</th>
                                    <td>
                                        @if($data->lampiran1)
                                            <a href="{{ $data->lampiran1 }}" target="_blank">Download Lampiran 1</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 2</th>
                                    <td>
                                        @if($data->lampiran2)
                                            <a href="{{ $data->lampiran2 }}" target="_blank">Download Lampiran 2</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 3</th>
                                    <td>
                                        @if($data->lampiran3)
                                            <a href="{{ $data->lampiran3 }}" target="_blank">Download Lampiran 3</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 4</th>
                                    <td>
                                        @if($data->lampiran4)
                                            <a href="{{ $data->lampiran4 }}" target="_blank">Download Lampiran 4</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 5</th>
                                    <td>
                                        @if($data->lampiran5)
                                            <a href="{{ $data->lampiran5 }}" target="_blank">Download Lampiran 5</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 6</th>
                                    <td>
                                        @if($data->lampiran6)
                                            <a href="{{ $data->lampiran6 }}" target="_blank">Download Lampiran 6</a>
                                        @else
                                            -
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
