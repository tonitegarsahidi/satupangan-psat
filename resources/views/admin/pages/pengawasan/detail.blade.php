@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail of Pengawasan')

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
                    <h3 class="card-header">Detail of Pengawasan with id : {{ $data->id }}</h3>
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
                                    <th scope="col" class="bg-dark text-white">Supervision Result</th>
                                    <td>{{ $data->hasil_pengawasan ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Recommended Action</th>
                                    <td>{{ $data->tindakan_rekomendasikan ?: '-' }}</td>
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
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Initiator</th>
                                    <td>{{ $data->initiator ? $data->initiator->name : '-' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        @if (config('constant.CRUD.DISPLAY_TIMESTAMPS'))
                            @include('components.crud-timestamps', $data)
                        @endif

                    </div>

                </div>

            </div>



            {{-- ROW FOR ADDITIONAL FUNCTIONALITY BUTTON --}}
            <div class="m-4">
                <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>
                <a class="btn btn-primary me-2" href="{{ route('admin.pengawasan.edit', ['id' => $data->id]) }}"
                    title="update this pengawasan">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('admin.pengawasan.delete', ['id' => $data->id]) }}"
                    title="delete pengawasan">
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
