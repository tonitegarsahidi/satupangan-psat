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

                        @if (Auth::user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR']))
                            <div class="alert alert-warning alert-dismissible fade show text-dark" role="alert">
                                <strong>Aksi yang dpat dilakukan :</strong><br/>
                                Silakan review dan update status dari pengajuan QR Badan Pangan Nasional berikut

                                <div class="row">
                                    <div class="col-md-10">
                                        <form action="{{ route('qr-badan-pangan.update-status', ['id' => $data->id]) }}"
                                            method="POST" class="mb-4">
                                            @csrf
                                            @method('POST')

                                            {{-- <div class="row"> --}}
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        {{-- <label for="status" class="form-label">Update Status</label> --}}
                                                        <select class="form-select" id="status" name="status"
                                                            @if ($data->status == 'approved' || $data->status == 'rejected') disabled @endif>
                                                            @if ($data->status == 'pending')
                                                                <option value="pending" selected>Pending</option>
                                                                <option value="reviewed">Reviewed</option>
                                                                <option value="approved">Approved</option>
                                                                <option value="rejected">Rejected</option>
                                                            @elseif ($data->status == 'reviewed')
                                                                <option value="reviewed" selected>Reviewed</option>
                                                                <option value="approved">Approved</option>
                                                                <option value="rejected">Rejected</option>
                                                            @else
                                                                <option value="{{ $data->status }}" selected>
                                                                    {{ ucfirst($data->status) }}</option>
                                                            @endif
                                                        </select>
                                                        @if ($data->status == 'approved' || $data->status == 'rejected')
                                                            <small class="form-text text-muted">Status cannot be changed
                                                                once it's approved or rejected.</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6 d-flex align-items-end">
                                                    <button type="submit" class="btn btn-primary"
                                                        @if ($data->status == 'approved' || $data->status == 'rejected') disabled @endif>
                                                        Update Status
                                                    </button>
                                                </div>
                                            {{-- </div> --}}
                                        </form>
                                    </div>
                                </div>
                            </div>


                        @endif

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
                                        @if ($data->qr_code)
                                            <div id="qrcode" class="mb-3"></div>
                                            <p class="text-muted">URL: {{ env('APP_URL', 'http://localhost') }}/qr/{{ $data->qr_code }}</p>
                                            <button class="btn btn-sm btn-outline-primary" onclick="downloadQRCode()">Download QR Code</button>
                                        @else
                                            <p class="text-muted">QR Code will be generated when status is approved</p>
                                        @endif
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

                                        {{-- @if ($data->referensiIzinrumahPengemasan)
                                        <tr>
                                            <td>Izin Rumah Pengemasan</td>
                                            <td>
                                                <a href="{{ route('register-izinrumah-pengemasan.detail', ['id' => $data->referensiIzinrumahPengemasan->id]) }}">
                                                    {{ $data->referensiIzinrumahPengemasan->nomor_izin ?? $data->referensiIzinrumahPengemasan->id }}
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
                                        @endif --}}

                                        {{-- @if ($data->referensiSertifikatKeamananPangan)
                                        <tr>
                                            <td>Sertifikat Keamanan Pangan</td>
                                            <td>
                                                <a href="{{ route('register-sertifikat-keamanan-pangan.detail', ['id' => $data->referensiSertifikatKeamananPangan->id]) }}">
                                                    {{ $data->referensiSertifikatKeamananPangan->nomor_sertifikat ?? $data->referensiSertifikatKeamananPangan->id }}
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
                                        @endif --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <!-- Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('qr-badan-pangan.index') }}" class="btn btn-secondary">Back to List</a>
                                @if (Auth::user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR']) ||
                                        (Auth::user()->hasAnyRole(['ROLE_USER_BUSINESS']) && $data->status == 'pending'))
                                    <a href="{{ route('qr-badan-pangan.edit', ['id' => $data->id]) }}"
                                        class="btn btn-primary">Edit</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($data->qr_code)
                const qrCodeElement = document.getElementById('qrcode');
                const url = '{{ env('APP_URL', 'http://localhost') }}/qr/{{ $data->qr_code }}';

                QRCode.toCanvas(qrCodeElement, url, {
                    width: 200,
                    height: 200,
                    margin: 1,
                    color: {
                        dark: '#000000',
                        light: '#FFFFFF'
                    }
                }, function(error) {
                    if (error) {
                        console.error(error);
                        qrCodeElement.innerHTML = 'Error generating QR code';
                    }
                });
            @endif
        });

        function downloadQRCode() {
            const canvas = document.querySelector('#qrcode canvas');
            if (canvas) {
                const url = canvas.toDataURL('image/png');
                const link = document.createElement('a');
                link.download = 'qr-code-{{ $data->qr_code }}.png';
                link.href = url;
                link.click();
            }
        }
    </script>
    @endpush
@endsection
