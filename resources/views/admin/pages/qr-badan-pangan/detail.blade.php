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
                                        <th>Created At>
                                        <td>{{ $data->created_at ? $data->created_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $data->updated_at ? $data->updated_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Workflow Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 200px;">Requested By</th>
                                        <td>{{ $data->requestedBy ? $data->requestedBy->name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Requested At>
                                        <td>{{ $data->requested_at ? $data->requested_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Current Assignee</th>
                                        <td>{{ $data->currentAssignee ? $data->currentAssignee->name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Reviewed By>
                                        <td>{{ $data->reviewedBy ? $data->reviewedBy->name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Reviewed At>
                                        <td>{{ $data->reviewed_at ? $data->reviewed_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Approved By</th>
                                        <td>{{ $data->approvedBy ? $data->approvedBy->name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Approved At>
                                        <td>{{ $data->approved_at ? $data->approved_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="mb-3">Commodity Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 200px;">Nama Komoditas>
                                        <td>{{ $data->nama_komoditas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Latin>
                                        <td>{{ $data->nama_latin }}</td>
                                    </tr>
                                    <tr>
                                        <th>Merk Dagang</th>
                                        <td>{{ $data->merk_dagang }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis PSAT>
                                        <td>{{ $data->jenisPsat ? $data->jenisPsat->nama_jenis_pangan_segar : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Business Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 200px;">Business>
                                        <td>{{ $data->business ? $data->business->nama_perusahaan : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Address</th>
                                        <td>{{ $data->business ? $data->business->alamat_perusahaan : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIB>
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
                                            <th>Reference ID>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>SPPB</td>
                                            <td>{{ $data->referensiSppb ? $data->referensiSppb->id : '-' }}</td>
                                            <td>{{ $data->referensiSppb ? $data->referensiSppb->status : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Izin EDAR PSATPL</td>
                                            <td>{{ $data->referensiIzinedarPsatpl ? $data->referensiIzinedarPsatpl->id : '-' }}</td>
                                            <td>{{ $data->referensiIzinedarPsatpl ? $data->referensiIzinedarPsatpl->status : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Izin EDAR PSATPD</td>
                                            <td>{{ $data->referensiIzinedarPsatpd ? $data->referensiIzinedarPsatpd->id : '-' }}</td>
                                            <td>{{ $data->referensiIzinedarPsatpd ? $data->referensiIzinedarPsatpd->status : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Izin EDAR PSATPDUK</td>
                                            <td>{{ $data->referensiIzinedarPsatpduk ? $data->referensiIzinedarPsatpduk->id : '-' }}</td>
                                            <td>{{ $data->referensiIzinedarPsatpduk ? $data->referensiIzinedarPsatpduk->status : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Izin Rumah Pengemasan</td>
                                            <td>{{ $data->referensiIzinrumahPengemasan ? $data->referensiIzinrumahPengemasan->id : '-' }}</td>
                                            <td>{{ $data->referensiIzinrumahPengemasan ? $data->referensiIzinrumahPengemasan->status : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sertifikat Keamanan Pangan</td>
                                            <td>{{ $data->referensiSertifikatKeamananPangan ? $data->referensiSertifikatKeamananPangan->id : '-' }}</td>
                                            <td>{{ $data->referensiSertifikatKeamananPangan ? $data->referensiSertifikatKeamananPangan->status : '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="mb-3">File Attachments</h5>
                                <div class="row">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $fileField = 'file_lampiran' . $i;
                                        @endphp
                                        @if ($data->$fileField)
                                            <div class="col-md-4 mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6 class="card-title">File Lampiran {{ $i }}</h6>
                                                        <a href="{{ $data->$fileField }}" target="_blank" class="btn btn-sm btn-primary">
                                                            <i class='bx bx-download'></i> Download
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endfor
                                </div>
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
