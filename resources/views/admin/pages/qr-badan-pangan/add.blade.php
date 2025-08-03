@extends('admin/template-base')

@section('page-title', 'Add New QR Badan Pangan')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New QR Badan Pangan</h4>
                        <p class="card-subtitle mb-4">Fill in the form below to add a new QR Badan Pangan</p>

                        <form action="{{ route('qr-badan-pangan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Business Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="business_id" class="form-label">Business</label>
                                    <select class="form-select" id="business_id" name="business_id" required>
                                        <option value="">Select Business</option>
                                        @if($business)
                                            <option value="{{ $business->id }}" selected>{{ $business->nama_perusahaan }}</option>
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
                                            <option value="{{ $assignee->id }}">{{ $assignee->name }}</option>
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
                                    <input type="text" class="form-control" id="nama_komoditas" name="nama_komoditas" required>
                                    @error('nama_komoditas')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="nama_latin" class="form-label">Nama Latin <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_latin" name="nama_latin" required>
                                    @error('nama_latin')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="merk_dagang" class="form-label">Merk Dagang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="merk_dagang" name="merk_dagang" required>
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
                                            <option value="{{ $jenispsat->id }}">{{ $jenispsat->nama_jenis_pangan_segar }}</option>
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
                                    </select>
                                    @error('referensi_sppb')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="referensi_izinedar_psatpl" class="form-label">Referensi Izin EDAR PSATPL</label>
                                    <select class="form-select" id="referensi_izinedar_psatpl" name="referensi_izinedar_psatpl">
                                        <option value="">Select Izin EDAR PSATPL</option>
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
                                    </select>
                                    @error('referensi_izinedar_psatpd')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="referensi_izinedar_psatpduk" class="form-label">Referensi Izin EDAR PSATPDUK</label>
                                    <select class="form-select" id="referensi_izinedar_psatpduk" name="referensi_izinedar_psatpduk">
                                        <option value="">Select Izin EDAR PSATPDUK</option>
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
                                    </select>
                                    @error('referensi_izinrumah_pengemasan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="referensi_sertifikat_keamanan_pangan" class="form-label">Referensi Sertifikat Keamanan Pangan</label>
                                    <select class="form-select" id="referensi_sertifikat_keamanan_pangan" name="referensi_sertifikat_keamanan_pangan">
                                        <option value="">Select Sertifikat Keamanan Pangan</option>
                                    </select>
                                    @error('referensi_sertifikat_keamanan_pangan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- File Attachments -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="mb-3">File Attachments</h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="file_lampiran1" class="form-label">File Lampiran 1</label>
                                    <input type="file" class="form-control" id="file_lampiran1" name="file_lampiran1" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    @error('file_lampiran1')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="file_lampiran2" class="form-label">File Lampiran 2</label>
                                    <input type="file" class="form-control" id="file_lampiran2" name="file_lampiran2" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    @error('file_lampiran2')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="file_lampiran3" class="form-label">File Lampiran 3</label>
                                    <input type="file" class="form-control" id="file_lampiran3" name="file_lampiran3" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    @error('file_lampiran3')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="file_lampiran4" class="form-label">File Lampiran 4</label>
                                    <input type="file" class="form-control" id="file_lampiran4" name="file_lampiran4" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    @error('file_lampiran4')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="file_lampiran5" class="form-label">File Lampiran 5</label>
                                    <input type="file" class="form-control" id="file_lampiran5" name="file_lampiran5" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    @error('file_lampiran5')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
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
