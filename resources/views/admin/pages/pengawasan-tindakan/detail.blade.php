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
                    <div style="overflow-x: visible; width: 100%;">
                        <table class="table table-hover" style="table-layout: auto; width: 100%;">
                            <tbody>
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
                                        @if ($data->statusLabel() == config('pengawasan.pengawasan_tindakan_statuses.SETUJUI_SELESAI'))
                                        <span class="badge rounded-pill bg-success">{{ $data->statusLabel() }}</span>
                                    @else
                                        <span class="badge rounded-pill bg-warning">{{ $data->statusLabel() }}</span>
                                    @endif
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
                                {{-- <tr>
                                    <th scope="col" class="bg-dark text-white">Aktif</th>
                                    <td>
                                        @if ($data->is_active)
                                            <span class="badge rounded-pill bg-success"> Yes </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger"> No </span>
                                        @endif
                                    </td>
                                </tr> --}}
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
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 15%;">PIC</th>
                                    <th style="width: 40%; max-width: 40%;">Pesan</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 30%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->tindakanLanjutan as $tindakanLanjutan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tindakanLanjutan->pic ? $tindakanLanjutan->pic->name : '-' }}</td>
                                    <td style="max-width: 40%; word-wrap: break-word; word-break: break-word;">
                                        {{ $tindakanLanjutan->arahan_tindak_lanjut ?: '-' }}
                                    </td>
                                    <td>
                                        @if($tindakanLanjutan->is_active)
                                            <span class="badge rounded-pill bg-success">Selesai</span>
                                        @else
                                            <span class="badge rounded-pill bg-warning">Belum Selesai</span>
                                        @endif
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

     <style>
         .table td {
             word-wrap: break-word;
             word-break: break-word;
             white-space: normal;
             vertical-align: top;
         }

         .table th {
             word-wrap: break-word;
             word-break: break-word;
             white-space: normal;
             vertical-align: top;
         }

         /* Ensure long URLs and text in links wrap properly */
         .table td a {
             word-break: break-all;
         }
     </style>

     <script>
         function goBack() {
             window.history.back();
         }
     </script>

@endsection
