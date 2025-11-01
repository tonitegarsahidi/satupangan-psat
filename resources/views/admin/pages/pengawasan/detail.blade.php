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
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Alamat Lokasi</th>
                                    <td>{{ $data->lokasi_alamat }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Kota</th>
                                    <td>{{ $data->lokasiKota ? $data->lokasiKota->nama_kota : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Provinsi</th>
                                    <td>{{ $data->lokasiProvinsi ? $data->lokasiProvinsi->nama_provinsi : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tanggal Mulai</th>
                                    <td>{{ $data->tanggal_mulai ? \Carbon\Carbon::parse($data->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tanggal Selesai</th>
                                    <td>{{ $data->tanggal_selesai ? \Carbon\Carbon::parse($data->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
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
                                    <th scope="col" class="bg-dark text-white">Hasil Pengawasan</th>
                                    <td><div style="min-height: 150px; vertical-align: top; white-space: normal;">{{ $data->hasil_pengawasan ?: '-' }}</div></td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tindakan Rekomendasi</th>
                                    <td><div style="min-height: 75px; vertical-align: top; white-space: normal;">{{ $data->tindakan_rekomendasikan ?: '-' }}</div></td>
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
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Pembuat</th>
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



            <!-- Rapid Test Items -->
            <div class="row m-2">
                <div class="col-md-12 col-xs-12">
                    <h4 class="card-header">Detail Rapid Test Items</h4>
                    @if ($data->items->where('type', 'rapid')->count() > 0)
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Test Parameter</th>
                                        <th>Komoditas</th>
                                        <th>Value String</th>
                                        <th>Is Positif</th>
                                        <th>Is Memenuhi Syarat</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->items->where('type', 'rapid') as $item)
                                        <tr>
                                            <td>{{ $item->test_name ?: '-' }}</td>
                                            <td>{{ $item->test_parameter ?: '-' }}</td>
                                            <td>{{ $item->komoditas ? $item->komoditas->nama_bahan_pangan_segar : '-' }}</td>
                                            <td>{{ $item->value_string ?: '-' }}</td>
                                            <td>
                                                @if ($item->is_positif)
                                                    <span class="badge rounded-pill bg-danger">Yes</span>
                                                @else
                                                    <span class="badge rounded-pill bg-success">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->is_memenuhisyarat)
                                                    <span class="badge rounded-pill bg-success">Yes</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">No</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->keterangan ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No Rapid Test Items found for this Pengawasan.</p>
                    @endif
                </div>
            </div>

            <!-- Laboratorium Test Items -->
            <div class="row m-2">
                <div class="col-md-12 col-xs-12">
                    <h4 class="card-header">Detail Laboratorium Test Items</h4>
                    @if ($data->items->where('type', 'lab')->count() > 0)
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Test Parameter</th>
                                        <th>Komoditas</th>
                                        <th>Value Numeric</th>
                                        <th>Value Unit</th>
                                        <th>Is Positif</th>
                                        <th>Is Memenuhi Syarat</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->items->where('type', 'lab') as $item)
                                        <tr>
                                            <td>{{ $item->test_name ?: '-' }}</td>
                                            <td>{{ $item->test_parameter ?: '-' }}</td>
                                            <td>{{ $item->komoditas ? $item->komoditas->nama_bahan_pangan_segar : '-' }}</td>
                                            <td>{{ $item->value_numeric ?: '-' }}</td>
                                            <td>{{ $item->value_unit ?: '-' }}</td>
                                            <td>
                                                @if ($item->is_positif)
                                                    <span class="badge rounded-pill bg-danger">Yes</span>
                                                @else
                                                    <span class="badge rounded-pill bg-success">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->is_memenuhisyarat)
                                                    <span class="badge rounded-pill bg-success">Yes</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">No</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->keterangan ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No Laboratorium Test Items found for this Pengawasan.</p>
                    @endif
                </div>
            </div>

            {{-- ROW FOR ADDITIONAL FUNCTIONALITY BUTTON --}}
            <div class="m-4">
                <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>
                <a class="btn btn-primary me-2" href="{{ route('pengawasan.edit', ['id' => $data->id]) }}"
                    title="update this pengawasan">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('pengawasan.delete', ['id' => $data->id]) }}"
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
