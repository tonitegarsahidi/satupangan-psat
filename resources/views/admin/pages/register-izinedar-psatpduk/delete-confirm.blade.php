@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Confirm Delete Register Izin EDAR PSATPDUK')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE AND ADD BUTTON --}}
            <div class="d-flex justify-content-between">

                <div class="bd-highlight">
                    <h3 class="card-header">Are you sure want to delete this Register Izin EDAR PSATPDUK?</h3>
                </div>

            </div>


            {{-- ROW FOR ADDITIONAL FUNCTIONALITY BUTTON --}}
            <div class="m-4">

                <form action="{{ route('register-izinedar-psatpduk.delete', $data->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>

                    <button type="submit" class="btn btn-danger me-2"
                        title="delete register izinedar psatpduk">
                        <i class='tf-icons bx bx-trash me-2'></i>Confirm Delete
                    </button>
                </form>
            </div>

            {{-- DETAIL OF THE DATA WHICH WANT TO BE DELETED --}}
            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Business Name</th>
                                    <td><a href="{{ route('business.profile.index') }}">{{ $data->business->nama_perusahaan ?? '-' }}</a></td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Status</th>
                                    <td>
                                        @if ($data->status == 'DISETUJUI')
                                            <span class="badge rounded-pill bg-success">{{ $data->status }}</span>
                                        @elseif ($data->status == 'DITOLAK')
                                            <span class="badge rounded-pill bg-danger">{{ $data->status }}</span>
                                        @elseif ($data->status == 'DIAJUKAN')
                                            <span class="badge rounded-pill bg-info">{{ $data->status }}</span>
                                        @elseif ($data->status == 'DIPERIKSA')
                                            <span class="badge rounded-pill bg-warning">{{ $data->status }}</span>
                                        @else
                                            {{ $data->status }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Nomor SPPB</th>
                                    <td>{{ $data->nomor_sppb ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Nomor Izin EDAR PL</th>
                                    <td>{{ $data->nomor_izinedar_pduk ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tanggal Terbit</th>
                                    <td>{{ $data->tanggal_terbit ? \Carbon\Carbon::parse($data->tanggal_terbit)->locale('id')->translatedFormat('j F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tanggal Terakhir</th>
                                    <td>{{ $data->tanggal_terakhir ? \Carbon\Carbon::parse($data->tanggal_terakhir)->locale('id')->translatedFormat('j F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Jenis PSAT</th>
                                    <td>{{ $data->jenisPsat->nama_jenis_pangan_segar ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Nama Komoditas>
                                    <td>{{ $data->nama_komoditas ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Nama Latin</th>
                                    <td>{{ $data->nama_latin ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Negara Asal</th>
                                    <td>{{ $data->negara_asal ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Merk Dagang</th>
                                    <td>{{ $data->merk_dagang ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Jenis Kemasan</th>
                                    <td>{{ $data->jenis_kemasan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Ukuran Berat>
                                    <td>{{ $data->ukuran_berat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Kategori Label</th>
                                    <td>{{ $data->kategorilabel ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Foto 1</th>
                                    <td>
                                        @if($data->foto_1)
                                            <a href="{{ $data->foto_1 }}" target="_blank">
                                                <img src="{{ $data->foto_1 }}" alt="Foto 1" style="max-width: 400px; height: auto;">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Foto 2</th>
                                    <td>
                                        @if($data->foto_2)
                                            <a href="{{ $data->foto_2 }}" target="_blank">
                                                <img src="{{ $data->foto_2 }}" alt="Foto 2" style="max-width: 400px; height: auto;">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Foto 3</th>
                                    <td>
                                        @if($data->foto_3)
                                            <a href="{{ $data->foto_3 }}" target="_blank">
                                                <img src="{{ $data->foto_3 }}" alt="Foto 3" style="max-width: 400px; height: auto;">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Foto 4</th>
                                    <td>
                                        @if($data->foto_4)
                                            <a href="{{ $data->foto_4 }}" target="_blank">
                                                <img src="{{ $data->foto_4 }}" alt="Foto 4" style="max-width: 400px; height: auto;">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Foto 5</th>
                                    <td>
                                        @if($data->foto_5)
                                            <a href="{{ $data->foto_5 }}" target="_blank">
                                                <img src="{{ $data->foto_5 }}" alt="Foto 5" style="max-width: 400px; height: auto;">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Foto 6</th>
                                    <td>
                                        @if($data->foto_6)
                                            <a href="{{ $data->foto_6 }}" target="_blank">
                                                <img src="{{ $data->foto_6 }}" alt="Foto 6" style="max-width: 400px; height: auto;">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">OKKP Penanggung Jawab</th>
                                    <td>{{ $data->okkpPenanggungjawab->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Nama Unit Usaha</th>
                                    <td>{{ $data->nama_unitusaha ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Alamat Unit Usaha</th>
                                    <td>{{ $data->alamat_unitusaha ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Alamat Unit Penanganan</th>
                                    <td>{{ $data->alamat_unitpenanganan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Provinsi Unit Usaha</th>
                                    <td>{{ $data->provinsiUnitusaha->nama_provinsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Kota Unit Usaha</th>
                                    <td>{{ $data->kotaUnitusaha->nama_kota ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">NIB Unit Usaha</th>
                                    <td>{{ $data->nib_unitusaha ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">File NIB</th>
                                    <td>
                                        @if($data->file_nib)
                                            <a href="{{ $data->file_nib }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-file-pdf me-1"></i> Lihat File NIB
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">File SPPB</th>
                                    <td>
                                        @if($data->file_sppb)
                                            <a href="{{ $data->file_sppb }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-file-pdf me-1"></i> Lihat File SPPB
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">File Izin EDAR PSATPDUK</th>
                                    <td>
                                        @if($data->file_izinedar_psatpduk)
                                            <a href="{{ $data->file_izinedar_psatpduk }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-file-pdf me-1"></i> Lihat File Izin EDAR PSATPDUK
                                            </a>
                                        @else
                                            -
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
