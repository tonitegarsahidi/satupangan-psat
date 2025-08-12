@extends('admin/template-base')

@section('page-title', 'Delete QR Badan Pangan')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Delete QR Badan Pangan</h4>
                        <p class="card-subtitle mb-4">Are you sure you want to delete this QR Badan Pangan?</p>

                        <div class="alert alert-danger">
                            <h5>Warning!</h5>
                            <p>This action cannot be undone. This will permanently delete the QR Badan Pangan and all its associated data.</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="mb-3">Basic Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 200px;">QR Code</th>
                                        <td>{{ $data->qr_code ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($data->status == 'approved')
                                                <span class="badge rounded-pill bg-success">{{ $data->status }}</span>
                                            @elseif ($data->status == 'rejected')
                                                <span class="badge rounded-pill bg-danger">{{ $data->status }}</span>
                                            @elseif ($data->status == 'pending')
                                                <span class="badge rounded-pill bg-info">{{ $data->status }}</span>
                                            @elseif ($data->status == 'reviewed')
                                                <span class="badge rounded-pill bg-warning">{{ $data->status }}</span>
                                            @else
                                                {{ $data->status ?: '-' }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Published</th>
                                        <td>
                                            @if ($data->is_published)
                                                <span class="badge rounded-pill bg-success">Yes</span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d M Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d M Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">QR Code</h5>
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>QR Code akan ditampilkan di sini</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="mb-3">Commodity Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 200px;">Nama Komoditas</th>
                                        <td>{{ $data->nama_komoditas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Latin</th>
                                        <td>{{ $data->nama_latin }}</td>
                                    </tr>
                                    <tr>
                                        <th>Merk Dagang</th>
                                        <td>{{ $data->merk_dagang }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis PSAT</th>
                                        <td>{{ $data->jenisPsat ? $data->jenisPsat->nama_jenis_pangan_segar : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Business Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 200px;">Business</th>
                                        <td>{{ $data->business ? $data->business->nama_perusahaan : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Address</th>
                                        <td>{{ $data->business ? $data->business->alamat_perusahaan : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIB</th>
                                        <td>{{ $data->business ? $data->business->nib : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="mb-3">References</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Reference Type</th>
                                            <th>Reference Number</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data->referensiSppb)
                                            <tr>
                                                <td>SPPB</td>
                                                <td>
                                                    <a
                                                        href="{{ route('register-sppb.detail', ['id' => $data->referensiSppb->id]) }}">
                                                        {{ $data->referensiSppb->nomor_registrasi ?? $data->referensiSppb->id }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge rounded-pill
                                                    @if ($data->referensiSppb->status == 'approved') bg-success
                                                    @elseif ($data->referensiSppb->status == 'rejected')
                                                        bg-danger
                                                    @elseif ($data->referensiSppb->status == 'pending')
                                                        bg-info
                                                    @else
                                                        bg-secondary @endif
                                                ">
                                                        {{ $data->referensiSppb->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif

                                        @if ($data->referensiIzinedarPsatpl)
                                            <tr>
                                                <td>Izin EDAR PSATPL</td>
                                                <td>
                                                    <a
                                                        href="{{ route('register-izinedar-psatpl.detail', ['id' => $data->referensiIzinedarPsatpl->id]) }}">
                                                        {{ $data->referensiIzinedarPsatpl->nomor_izinedar_pl ?? $data->referensiIzinedarPsatpl->id }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge rounded-pill
                                                    @if ($data->referensiIzinedarPsatpl->status == 'approved') bg-success
                                                    @elseif ($data->referensiIzinedarPsatpl->status == 'rejected')
                                                        bg-danger
                                                    @elseif ($data->referensiIzinedarPsatpl->status == 'pending')
                                                        bg-info
                                                    @else
                                                        bg-secondary @endif
                                                ">
                                                        {{ $data->referensiIzinedarPsatpl->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif

                                        @if ($data->referensiIzinedarPsatpd)
                                            <tr>
                                                <td>Izin EDAR PSATPD</td>
                                                <td>
                                                    <a
                                                        href="{{ route('register-izinedar-psatpd.detail', ['id' => $data->referensiIzinedarPsatpd->id]) }}">
                                                        {{ $data->referensiIzinedarPsatpd->nomor_izinedar_pd ?? $data->referensiIzinedarPsatpd->id }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge rounded-pill
                                                    @if ($data->referensiIzinedarPsatpd->status == 'approved') bg-success
                                                    @elseif ($data->referensiIzinedarPsatpd->status == 'rejected')
                                                        bg-danger
                                                    @elseif ($data->referensiIzinedarPsatpd->status == 'pending')
                                                        bg-info
                                                    @else
                                                        bg-secondary @endif
                                                ">
                                                        {{ $data->referensiIzinedarPsatpd->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif

                                        @if ($data->referensiIzinedarPsatpduk)
                                            <tr>
                                                <td>Izin EDAR PSATPDUK</td>
                                                <td>
                                                    <a
                                                        href="{{ route('register-izinedar-psatpduk.detail', ['id' => $data->referensiIzinedarPsatpduk->id]) }}">
                                                        {{ $data->referensiIzinedarPsatpduk->nomor_izinedar_pduk ?? $data->referensiIzinedarPsatpduk->id }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge rounded-pill
                                                    @if ($data->referensiIzinedarPsatpduk->status == 'approved') bg-success
                                                    @elseif ($data->referensiIzinedarPsatpduk->status == 'rejected')
                                                        bg-danger
                                                    @elseif ($data->referensiIzinedarPsatpduk->status == 'pending')
                                                        bg-info
                                                    @else
                                                        bg-secondary @endif
                                                ">
                                                        {{ $data->referensiIzinedarPsatpduk->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <form action="{{ route('qr-badan-pangan.destroy', ['id' => $data->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger me-2">Delete</button>
                                    <a href="{{ route('qr-badan-pangan.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
