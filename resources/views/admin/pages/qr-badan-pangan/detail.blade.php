@extends('admin/template-base')

@section('page-title', 'Detail QR Badan Pangan')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail QR Badan Pangan</h4>
                        <p class="card-subtitle mb-4">View detailed information about this QR Badan Pangan</p>

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
                                        <td>{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d M Y H:i') : '-' }}</td>
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
                                                <a href="{{ route('register-sppb.detail', ['id' => $data->referensiSppb->id]) }}">
                                                    {{ $data->referensiSppb->nomor ?? $data->referensiSppb->id }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill
                                                    @if ($data->referensiSppb->status == 'approved')
                                                        bg-success
                                                    @elseif ($data->referensiSppb->status == 'rejected')
                                                        bg-danger
                                                    @elseif ($data->referensiSppb->status == 'pending')
                                                        bg-info
                                                    @else
                                                        bg-secondary
                                                    @endif
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
                                                <a href="{{ route('register-izinedar-psatpl.detail', ['id' => $data->referensiIzinedarPsatpl->id]) }}">
                                                    {{ $data->referensiIzinedarPsatpl->nomor ?? $data->referensiIzinedarPsatpl->id }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill
                                                    @if ($data->referensiIzinedarPsatpl->status == 'approved')
                                                        bg-success
                                                    @elseif ($data->referensiIzinedarPsatpl->status == 'rejected')
                                                        bg-danger
                                                    @elseif ($data->referensiIzinedarPsatpl->status == 'pending')
                                                        bg-info
                                                    @else
                                                        bg-secondary
                                                    @endif
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
                                                <a href="{{ route('register-izinedar-psatpd.detail', ['id' => $data->referensiIzinedarPsatpd->id]) }}">
                                                    {{ $data->referensiIzinedarPsatpd->nomor ?? $data->referensiIzinedarPsatpd->id }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill
                                                    @if ($data->referensiIzinedarPsatpd->status == 'approved')
                                                        bg-success
                                                    @elseif ($data->referensiIzinedarPsatpd->status == 'rejected')
                                                        bg-danger
                                                    @elseif ($data->referensiIzinedarPsatpd->status == 'pending')
                                                        bg-info
                                                    @else
                                                        bg-secondary
                                                    @endif
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
                                                <a href="{{ route('register-izinedar-psatpduk.detail', ['id' => $data->referensiIzinedarPsatpduk->id]) }}">
                                                    {{ $data->referensiIzinedarPsatpduk->nomor ?? $data->referensiIzinedarPsatpduk->id }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill
                                                    @if ($data->referensiIzinedarPsatpduk->status == 'approved')
                                                        bg-success
                                                    @elseif ($data->referensiIzinedarPsatpduk->status == 'rejected')
                                                        bg-danger
                                                    @elseif ($data->referensiIzinedarPsatpduk->status == 'pending')
                                                        bg-info
                                                    @else
                                                        bg-secondary
                                                    @endif
                                                ">
                                                    {{ $data->referensiIzinedarPsatpduk->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endif

                                        @if ($data->referensiIzinrumahPengemasan)
                                        <tr>
                                            <td>Izin Rumah Pengemasan</td>
                                            <td>
                                                <a href="{{ route('register-izinrumah-pengemasan.detail', ['id' => $data->referensiIzinrumahPengemasan->id]) }}">
                                                    {{ $data->referensiIzinrumahPengemasan->nomor ?? $data->referensiIzinrumahPengemasan->id }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill
                                                    @if ($data->referensiIzinrumahPengemasan->status == 'approved')
                                                        bg-success
                                                    @elseif ($data->referensiIzinrumahPengemasan->status == 'rejected')
                                                        bg-danger
                                                    @elseif ($data->referensiIzinrumahPengemasan->status == 'pending')
                                                        bg-info
                                                    @else
                                                        bg-secondary
                                                    @endif
                                                ">
                                                    {{ $data->referensiIzinrumahPengemasan->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endif

                                        @if ($data->referensiSertifikatKeamananPangan)
                                        <tr>
                                            <td>Sertifikat Keamanan Pangan</td>
                                            <td>
                                                <a href="{{ route('register-sertifikat-keamanan-pangan.detail', ['id' => $data->referensiSertifikatKeamananPangan->id]) }}">
                                                    {{ $data->referensiSertifikatKeamananPangan->nomor ?? $data->referensiSertifikatKeamananPangan->id }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill
                                                    @if ($data->referensiSertifikatKeamananPangan->status == 'approved')
                                                        bg-success
                                                    @elseif ($data->referensiSertifikatKeamananPangan->status == 'rejected')
                                                        bg-danger
                                                    @elseif ($data->referensiSertifikatKeamananPangan->status == 'pending')
                                                        bg-info
                                                    @else
                                                        bg-secondary
                                                    @endif
                                                ">
                                                    {{ $data->referensiSertifikatKeamananPangan->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <!-- Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('qr-badan-pangan.index') }}" class="btn btn-secondary">Back to List</a>
                                @if (Auth::user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR'])
                                    || (Auth::user()->hasAnyRole(['ROLE_USER_BUSINESS']) && $data->status == 'pending'))
                                    <a href="{{ route('qr-badan-pangan.edit', ['id' => $data->id]) }}" class="btn btn-primary">Edit</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
