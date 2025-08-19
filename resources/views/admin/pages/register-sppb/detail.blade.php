@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail of Register SPPB')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- ALERTS --}}
        @if (session('alerts'))
            @foreach (session('alerts') as $alert)
                <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show text-black" role="alert">
                    {{ $alert['message'] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endforeach
        @endif

        @if (Auth::user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR']))
            <div class="alert alert-warning alert-dismissible fade show text-dark" role="alert">
                <strong>Aksi yang dapat dilakukan :</strong><br />
                Silakan review dan update status dari pengajuan SPPB berikut

                <div class="row">
                    <div class="col-md-10">
                        <form action="{{ route('register-sppb.update-status', ['id' => $data->id]) }}"
                            method="POST" class="mb-4">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select class="form-select" id="status" name="status"
                                            @if ($data->status == config('workflow.sppb_statuses.DISETUJUI') || $data->status == config('workflow.sppb_statuses.DITOLAK')) disabled @endif>
                                            @if ($data->status == config('workflow.sppb_statuses.DIAJUKAN'))
                                                <option value="{{ config('workflow.sppb_statuses.DIAJUKAN') }}" selected>Diajukan</option>
                                                <option value="{{ config('workflow.sppb_statuses.DIPERIKSA') }}">Diperiksa</option>
                                                <option value="{{ config('workflow.sppb_statuses.DISETUJUI') }}">Disetujui</option>
                                                <option value="{{ config('workflow.sppb_statuses.DITOLAK') }}">Ditolak</option>
                                            @elseif ($data->status == config('workflow.sppb_statuses.DIPERIKSA'))
                                                <option value="{{ config('workflow.sppb_statuses.DIPERIKSA') }}" selected>Diperiksa</option>
                                                <option value="{{ config('workflow.sppb_statuses.DISETUJUI') }}">Disetujui</option>
                                                <option value="{{ config('workflow.sppb_statuses.DITOLAK') }}">Ditolak</option>
                                            @else
                                                <option value="{{ $data->status }}" selected>
                                                    {{ ucfirst($data->status) }}</option>
                                            @endif
                                        </select>
                                        @if ($data->status == config('workflow.sppb_statuses.DISETUJUI') || $data->status == config('workflow.sppb_statuses.DITOLAK'))
                                            <small class="form-text text-muted">Status cannot be changed
                                                once it's approved or rejected.</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary"
                                        @if ($data->status == config('workflow.sppb_statuses.DISETUJUI') || $data->status == config('workflow.sppb_statuses.DITOLAK')) disabled @endif>
                                        Update Status
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE AND ADD BUTTON --}}
            <div class="d-flex justify-content-between">

                <div class="bd-highlight">
                    <h3 class="card-header">Detail of Register SPPB with id : {{ $data->id }}</h3>
                </div>

            </div>

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
                                        @if ($data->status == config('workflow.sppb_statuses.DISETUJUI'))
                                            <span class="badge rounded-pill bg-success">{{ $data->status }}</span>
                                        @elseif ($data->status == config('workflow.sppb_statuses.DITOLAK'))
                                            <span class="badge rounded-pill bg-danger">{{ $data->status }}</span>
                                        @elseif ($data->status == config('workflow.sppb_statuses.DIAJUKAN'))
                                            <span class="badge rounded-pill bg-info">{{ $data->status }}</span>
                                        @elseif ($data->status == config('workflow.sppb_statuses.DIPERIKSA'))
                                            <span class="badge rounded-pill bg-warning">{{ $data->status }}</span>
                                        @else
                                            {{ $data->status }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Nomor Registrasi</th>
                                    <td>{{ $data->nomor_registrasi ?? '-' }}</td>
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
                                    <th scope="col" class="bg-dark text-white">JENIS PSAT</th>
                                    <td>
                                        @if($data->jenispsats && $data->jenispsats->isNotEmpty())
                                            <ol>
                                                @foreach($data->jenispsats as $jenispsat)
                                                    <li>{{ $jenispsat->nama_jenis_pangan_segar }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Nama Komoditas</th>
                                    <td>{{ $data->nama_komoditas ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Ruang Lingkup Penanganan</th>
                                    <td>{{ $data->penanganan->nama_penanganan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Nama Unit Usaha</th>
                                    <td>{{ $data->nama_unitusaha ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Alamat Unit Penanganan</th>
                                    <td>{{ $data->alamat_unit_penanganan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Alamat Unit Usaha</th>
                                    <td>{{ $data->alamat_unitusaha ?? '-' }}</td>
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
                <a class="btn btn-primary me-2" href="{{ route('register-sppb.edit', ['id' => $data->id]) }}"
                    title="update this register sppb">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('register-sppb.delete', ['id' => $data->id]) }}"
                    title="delete register sppb">
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
