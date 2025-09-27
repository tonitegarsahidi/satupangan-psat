@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail of Pengawasan Tindakan')

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
                    <h3 class="card-header">Detail of Pengawasan Tindakan with id : {{ $data->id }}</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Rekap Pengawasan</th>
                                    <td>
                                        @if ($data->rekap)
                                            <a href="{{ route('pengawasan-rekap.detail', ['id' => $data->rekap->id]) }}"
                                               class="text-primary text-decoration-none">
                                                <div>
                                                    @if ($data->rekap->judul_rekap)
                                                        <strong>{{ $data->rekap->judul_rekap }}</strong><br>
                                                    @endif
                                                    @if ($data->rekap->jenisPsat)
                                                        <small class="text-muted">Jenis: {{ $data->rekap->jenisPsat->nama_jenis_pangan_segar }}</small><br>
                                                    @endif
                                                    @if ($data->rekap->produkPsat)
                                                        <small class="text-muted">Produk: {{ $data->rekap->produkPsat->nama_bahan_pangan_segar }}</small>
                                                    @endif
                                                </div>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Pimpinan</th>
                                    <td>
                                        @if ($data->pimpinan)
                                            {{ $data->pimpinan->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tindak Lanjut</th>
                                    <td>{{ $data->tindak_lanjut ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Status</th>
                                    <td>
                                        <span class="badge rounded-pill bg-info">{{ $data->statusLabel() }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">PIC Tindakan</th>
                                    <td>
                                        @if ($data->picTindakans && $data->picTindakans->count() > 0)
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($data->picTindakans as $pic)
                                                    <li>{{ $pic->pic->name }}</li>
                                                @endforeach
                                            </ul>
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
                                    <th scope="col" class="bg-dark text-white">Tindakan Lanjutan</th>
                                    <td>
                                        @if ($data->tindakanLanjutan->count() > 0)
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($data->tindakanLanjutan as $tindakanLanjutanItem)
                                                    <li>
                                                        <div>
                                                            <strong>{{ $tindakanLanjutanItem->arahan_tindak_lanjut ?: '-' }}</strong><br>
                                                            <small class="text-muted">PIC: {{ $tindakanLanjutanItem->pic ? $tindakanLanjutanItem->pic->name : '-' }}</small>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Attachments</th>
                                    <td>
                                        @if ($data->attachments && $data->attachments->count() > 0)
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($data->attachments as $attachment)
                                                    <li>
                                                        <a href="{{ asset($attachment->file_path) }}" target="_blank" class="text-primary">
                                                            <i class='bx bx-file'></i> {{ $attachment->file_name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
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

            {{-- SECTION FOR TINDAKAN LANJUTAN --}}
            @if($data->tindakanLanjutan && $data->tindakanLanjutan->count() > 0)
            <div class="row m-2">
                <div class="col-12">
                    <h4 class="card-header">Tindakan Lanjutan</h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Pesan</th>
                                    <th>PIC</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->tindakanLanjutan as $tindakanLanjutan)
                                <tr>
                                    <td>{{ $tindakanLanjutan->arahan_tindak_lanjut ?: '-' }}</td>
                                    <td>{{ $tindakanLanjutan->pic ? $tindakanLanjutan->pic->name : '-' }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-info">{{ $tindakanLanjutan->getStatusLabel() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pengawasan-tindakan-lanjutan.detail', ['id' => $tindakanLanjutan->id]) }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-eye me-1"></i> Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                <a class="btn btn-primary me-2" href="{{ route('pengawasan-tindakan.edit', ['id' => $data->id]) }}"
                    title="update this pengawasan tindakan">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('pengawasan-tindakan.delete', ['id' => $data->id]) }}"
                    title="delete pengawasan tindakan">
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
