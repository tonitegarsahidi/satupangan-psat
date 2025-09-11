@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail of Pengawasan Rekap')

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
                    <h3 class="card-header">Detail of Pengawasan Rekap with id : {{ $data->id }}</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Admin</th>
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
                                    <th scope="col" class="bg-dark text-white">Provinsi</th>
                                    <td>{{ $data->provinsi ? $data->provinsi->nama_provinsi : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Judul Rekap</th>
                                    <td>{{ $data->judul_rekap ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Hasil Rekap</th>
                                    <td>{{ $data->hasil_rekap ?: '-' }}</td>
                                </tr>
                                @if($data->lampiran1)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 1</th>
                                    <td><a href="{{ env('APP_URL') }}/{{ $data->lampiran1 }}" target="_blank" class="btn btn-sm btn-primary">Download Lampiran 1</a></td>
                                </tr>
                                @endif
                                @if($data->lampiran2)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 2</th>
                                    <td><a href="{{ env('APP_URL') }}/{{ $data->lampiran2 }}" target="_blank" class="btn btn-sm btn-primary">Download Lampiran 2</a></td>
                                </tr>
                                @endif
                                @if($data->lampiran3)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 3</th>
                                    <td><a href="{{ env('APP_URL') }}/{{ $data->lampiran3 }}" target="_blank" class="btn btn-sm btn-primary">Download Lampiran 3</a></td>
                                </tr>
                                @endif
                                @if($data->lampiran4)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 4</th>
                                    <td><a href="{{ env('APP_URL') }}/{{ $data->lampiran4 }}" target="_blank" class="btn btn-sm btn-primary">Download Lampiran 4</a></td>
                                </tr>
                                @endif
                                @if($data->lampiran5)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 5</th>
                                    <td><a href="{{ env('APP_URL') }}/{{ $data->lampiran5 }}" target="_blank" class="btn btn-sm btn-primary">Download Lampiran 5</a></td>
                                </tr>
                                @endif
                                @if($data->lampiran6)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran 6</th>
                                    <td><a href="{{ env('APP_URL') }}/{{ $data->lampiran6 }}" target="_blank" class="btn btn-sm btn-primary">Download Lampiran 6</a></td>
                                </tr>
                                @endif
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
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

            {{-- MINITABLE FOR PENGAWASANS --}}
            @if($data->pengawasans && $data->pengawasans->count() > 0)
            <div class="row m-2">
                <div class="col-12">
                    <h4 class="card-header">Data Pengawasan Terkait</h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Kota</th>
                                    <th>Lokasi Alamat</th>
                                    <th>Jenis PSAT</th>
                                    <th>Produk PSAT</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->pengawasans as $index => $pengawasan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pengawasan->tanggal_mulai ? date('d/m/Y', strtotime($pengawasan->tanggal_mulai)) : '-' }}</td>
                                    <td>{{ $pengawasan->lokasiKota ? $pengawasan->lokasiKota->nama_kota : '-' }}</td>
                                    <td>{{ $pengawasan->lokasi_alamat ?: '-' }}</td>
                                    <td>{{ $pengawasan->jenisPsat ? $pengawasan->jenisPsat->nama_jenis_pangan_segar : '-' }}</td>
                                    <td>{{ $pengawasan->produkPsat ? $pengawasan->produkPsat->nama_bahan_pangan_segar : '-' }}</td>
                                    <td>{{ $pengawasan->status ?: '-' }}</td>
                                    <td><a href="{{ route('pengawasan.detail', ['id' => $pengawasan->id]) }}" class="btn btn-sm btn-primary"><i class="bx bx-show"></i> Detail</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="row m-2">
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle me-2"></i>
                        Tidak ada data pengawasan terkait untuk rekap ini.
                    </div>
                </div>
            </div>
            @endif

            @if (config('constant.CRUD.DISPLAY_TIMESTAMPS'))
                @include('components.crud-timestamps', $data)
            @endif

            {{-- ROW FOR ADDITIONAL FUNCTIONALITY BUTTON --}}
            <div class="m-4">
                <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>
                <a class="btn btn-primary me-2" href="{{ route('pengawasan-rekap.edit', ['id' => $data->id]) }}"
                    title="update this pengawasan rekap">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('pengawasan-rekap.delete', ['id' => $data->id]) }}"
                    title="delete pengawasan rekap">
                    <i class='tf-icons bx bx-trash me-2'></i>Delete</a>
            </div>

        </div>
    </div>

@endsection

@section('footer-code')
    <style>
        .table-responsive .table td {
            word-wrap: break-word;
            white-space: normal;
            word-break: break-word;
            vertical-align: top;
            max-width: none;
        }
        .table-responsive .table th {
            vertical-align: top;
            white-space: nowrap;
        }
        /* Ensure table cells can expand vertically */
        .table-responsive .table {
            table-layout: fixed;
        }
        .table-responsive .table td a {
            word-break: break-all;
            display: inline-block;
        }
    </style>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

@endsection
