@extends('admin/template-base')

@section('page-title', 'Edit QR Badan Pangan')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit QR Badan Pangan</h4>
                        <p class="card-subtitle mb-4">Update the information for this QR Badan Pangan</p>

                        <form action="{{ route('qr-badan-pangan.update', ['id' => $qrBadanPangan->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Business Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="business_id" class="form-label">Business</label>
                                    <select class="form-select" id="business_id" name="business_id" required>
                                        <option value="">Select Business</option>
                                        @if($qrBadanPangan->business)
                                            <option value="{{ $qrBadanPangan->business->id }}" selected>{{ $qrBadanPangan->business->nama_perusahaan }}</option>
                                        @endif
                                    </select>
                                    @error('business_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="current_assignee" class="form-label">Assign To</label>
                                    <select class="form-select" id="current_assignee" name="current_assignee">
                                        <option value="">Select Assignee</option>
                                        @foreach($assignees as $assignee)
                                            <option value="{{ $assignee->id }}" {{ $qrBadanPangan->current_assignee == $assignee->id ? 'selected' : '' }}>{{ $assignee->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('current_assignee')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Commodity Information -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="nama_komoditas" class="form-label">Nama Komoditas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_komoditas" name="nama_komoditas" value="{{ $qrBadanPangan->nama_komoditas }}" required>
                                    @error('nama_komoditas')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="nama_latin" class="form-label">Nama Latin <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_latin" name="nama_latin" value="{{ $qrBadanPangan->nama_latin }}" required>
                                    @error('nama_latin')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="merk_dagang" class="form-label">Merk Dagang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="merk_dagang" name="merk_dagang" value="{{ $qrBadanPangan->merk_dagang }}" required>
                                    @error('merk_dagang')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jenis PSAT -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="jenis_psat" class="form-label">Jenis PSAT</label>
                                    <select class="form-select" id="jenis_psat" name="jenis_psat">
                                        <option value="">Select Jenis PSAT</option>
                                        @foreach($jenispsats as $jenispsat)
                                            <option value="{{ $jenispsat->id }}" {{ $qrBadanPangan->jenis_psat == $jenispsat->id ? 'selected' : '' }}>{{ $jenispsat->nama_jenis_pangan_segar }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_psat')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- References -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="referensi_sppb" class="form-label">Referensi SPPB</label>
                                    <select class="form-select" id="referensi_sppb" name="referensi_sppb">
                                        <option value="">Select SPPB</option>
                                        @foreach($sppbs as $sppb)
                                            <option value="{{ $sppb->id }}" {{ $qrBadanPangan->referensi_sppb == $sppb->id ? 'selected' : '' }}>{{ $sppb->nama_komoditas ?? 'SPPB-' . $sppb->id }}</option>
                                        @endforeach
                                    </select>
                                    @error('referensi_sppb')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="referensi_izinedar_psatpl" class="form-label">Referensi Izin EDAR PSATPL</label>
                                    <select class="form-select" id="referensi_izinedar_psatpl" name="referensi_izinedar_psatpl">
                                        <option value="">Select Izin EDAR PSATPL</option>
                                        @foreach($izinedarPsatpls as $izinedarPsatpl)
                                            <option value="{{ $izinedarPsatpl->id }}" {{ $qrBadanPangan->referensi_izinedar_psatpl == $izinedarPsatpl->id ? 'selected' : '' }}>{{ $izinedarPsatpl->nama_komoditas ?? 'Izin EDAR PSATPL-' . $izinedarPsatpl->id }}</option>
                                        @endforeach
                                    </select>
                                    @error('referensi_izinedar_psatpl')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="referensi_izinedar_psatpd" class="form-label">Referensi Izin EDAR PSATPD</label>
                                    <select class="form-select" id="referensi_izinedar_psatpd" name="referensi_izinedar_psatpd">
                                        <option value="">Select Izin EDAR PSATPD</option>
                                        @foreach($izinedarPsatpds as $izinedarPsatpd)
                                            <option value="{{ $izinedarPsatpd->id }}" {{ $qrBadanPangan->referensi_izinedar_psatpd == $izinedarPsatpd->id ? 'selected' : '' }}>{{ $izinedarPsatpd->nama_komoditas ?? 'Izin EDAR PSATPD-' . $izinedarPsatpd->id }}</option>
                                        @endforeach
                                    </select>
                                    @error('referensi_izinedar_psatpd')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="referensi_izinedar_psatpduk" class="form-label">Referensi Izin EDAR PSATPDUK</label>
                                    <select class="form-select" id="referensi_izinedar_psatpduk" name="referensi_izinedar_psatpduk">
                                        <option value="">Select Izin EDAR PSATPDUK</option>
                                        @foreach($izinedarPsatpduks as $izinedarPsatpduk)
                                            <option value="{{ $izinedarPsatpduk->id }}" {{ $qrBadanPangan->referensi_izinedar_psatpduk == $izinedarPsatpduk->id ? 'selected' : '' }}>{{ $izinedarPsatpduk->nama_komoditas ?? 'Izin EDAR PSATPDUK-' . $izinedarPsatpduk->id }}</option>
                                        @endforeach
                                    </select>
                                    @error('referensi_izinedar_psatpduk')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="referensi_izinrumah_pengemasan" class="form-label">Referensi Izin Rumah Pengemasan</label>
                                    <select class="form-select" id="referensi_izinrumah_pengemasan" name="referensi_izinrumah_pengemasan">
                                        <option value="">Select Izin Rumah Pengemasan</option>
                                        @foreach($izinrumahPengemasans as $izinrumahPengemasan)
                                            <option value="{{ $izinrumahPengemasan->id }}" {{ $qrBadanPangan->referensi_izinrumah_pengemasan == $izinrumahPengemasan->id ? 'selected' : '' }}>{{ $izinrumahPengemasan->nama_komoditas ?? 'Izin Rumah Pengemasan-' . $izinrumahPengemasan->id }}</option>
                                        @endforeach
                                    </select>
                                    @error('referensi_izinrumah_pengemasan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="referensi_sertifikat_keamanan_pangan" class="form-label">Referensi Sertifikat Keamanan Pangan</label>
                                    <select class="form-select" id="referensi_sertifikat_keamanan_pangan" name="referensi_sertifikat_keamanan_pangan">
                                        <option value="">Select Sertifikat Keamanan Pangan</option>
                                        @foreach($sertifikatKeamananPangans as $sertifikatKeamananPangan)
                                            <option value="{{ $sertifikatKeamananPangan->id }}" {{ $qrBadanPangan->referensi_sertifikat_keamanan_pangan == $sertifikatKeamananPangan->id ? 'selected' : '' }}>{{ $sertifikatKeamananPangan->nama_komoditas ?? 'Sertifikat Keamanan Pangan-' . $sertifikatKeamananPangan->id }}</option>
                                        @endforeach
                                    </select>
                                    @error('referensi_sertifikat_keamanan_pangan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- References -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="referensi_sppb" class="form-label">Referensi SPPB</label>
                                    <select class="form-select" id="referensi_sppb" name="referensi_sppb">
                                        <option value="">Select SPPB</option>
                                        <option value="{{ $qrBadanPangan->referensi_sppb }}" {{ $qrBadanPangan->referensi_sppb ? 'selected' : '' }}>Current Reference</option>
                                    </select>
                                    @error('referensi_sppb')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="referensi_izinedar_psatpl" class="form-label">Referensi Izin EDAR PSATPL</label>
                                    <select class="form-select" id="referensi_izinedar_psatpl" name="referensi_izinedar_psatpl">
                                        <option value="">Select Izin EDAR PSATPL</option>
                                        <option value="{{ $qrBadanPangan->referensi_izinedar_psatpl }}" {{ $qrBadanPangan->referensi_izinedar_psatpl ? 'selected' : '' }}>Current Reference</option>
                                    </select>
                                    @error('referensi_izinedar_psatpl')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="referensi_izinedar_psatpd" class="form-label">Referensi Izin EDAR PSATPD</label>
                                    <select class="form-select" id="referensi_izinedar_psatpd" name="referensi_izinedar_psatpd">
                                        <option value="">Select Izin EDAR PSATPD</option>
                                        <option value="{{ $qrBadanPangan->referensi_izinedar_psatpd }}" {{ $qrBadanPangan->referensi_izinedar_psatpd ? 'selected' : '' }}>Current Reference</option>
                                    </select>
                                    @error('referensi_izinedar_psatpd')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="referensi_izinedar_psatpduk" class="form-label">Referensi Izin EDAR PSATPDUK</label>
                                    <select class="form-select" id="referensi_izinedar_psatpduk" name="referensi_izinedar_psatpduk">
                                        <option value="">Select Izin EDAR PSATPDUK</option>
                                        <option value="{{ $qrBadanPangan->referensi_izinedar_psatpduk }}" {{ $qrBadanPangan->referensi_izinedar_psatpduk ? 'selected' : '' }}>Current Reference</option>
                                    </select>
                                    @error('referensi_izinedar_psatpduk')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="referensi_izinrumah_pengemasan" class="form-label">Referensi Izin Rumah Pengemasan</label>
                                    <select class="form-select" id="referensi_izinrumah_pengemasan" name="referensi_izinrumah_pengemasan">
                                        <option value="">Select Izin Rumah Pengemasan</option>
                                        <option value="{{ $qrBadanPangan->referensi_izinrumah_pengemasan }}" {{ $qrBadanPangan->referensi_izinrumah_pengemasan ? 'selected' : '' }}>Current Reference</option>
                                    </select>
                                    @error('referensi_izinrumah_pengemasan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="referensi_sertifikat_keamanan_pangan" class="form-label">Referensi Sertifikat Keamanan Pangan</label>
                                    <select class="form-select" id="referensi_sertifikat_keamanan_pangan" name="referensi_sertifikat_keamanan_pangan">
                                        <option value="">Select Sertifikat Keamanan Pangan</option>
                                        <option value="{{ $qrBadanPangan->referensi_sertifikat_keamanan_pangan }}" {{ $qrBadanPangan->referensi_sertifikat_keamanan_pangan ? 'selected' : '' }}>Current Reference</option>
                                    </select>
                                    @error('referensi_sertifikat_keamanan_pangan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- File Attachments -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="mb-3">File Attachments</h5>
                                </div>
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        $fileField = 'file_lampiran' . $i;
                                    @endphp
                                    <div class="col-md-6 mb-3">
                                        <label for="{{ $fileField }}" class="form-label">File Lampiran {{ $i }}</label>
                                        <input type="file" class="form-control" id="{{ $fileField }}" name="{{ $fileField }}" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                        @if ($qrBadanPangan->$fileField)
                                            <div class="mt-2">
                                                <small class="text-muted">Current file:
                                                    <a href="{{ $qrBadanPangan->$fileField }}" target="_blank">Download</a>
                                                </small>
                                            </div>
                                        @endif
                                        @error($fileField)
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endfor
                            </div>

                            <!-- Status and Published -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="pending" {{ $qrBadanPangan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="reviewed" {{ $qrBadanPangan->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                        <option value="approved" {{ $qrBadanPangan->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $qrBadanPangan->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="is_published" class="form-label">Published</label>
                                    <select class="form-select" id="is_published" name="is_published">
                                        <option value="0" {{ !$qrBadanPangan->is_published ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $qrBadanPangan->is_published ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('is_published')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-2">Update</button>
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
