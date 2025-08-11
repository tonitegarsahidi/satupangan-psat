@extends('admin/template-base')

@section('page-title', 'Add New QR Badan Pangan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add QR Badan Pangan</h5>
                        <small class="text-muted float-end">* : must be filled</small>

                        <!-- Notification element -->
                        @if ($errors->any() || session('loginError'))
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    @endif
                                    @if (session('loginError'))
                                        <li>{{ session('loginError') }}</li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('qr-badan-pangan.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- BUSINESS ID FIELD (Hidden) --}}
                            <input type="hidden" name="business_id" id="business_id" value="{{ $business->id }}">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Business*</label>
                                <div class="col-sm-10">
                                    <a href="{{ route('business.profile.index') }}" class="form-control-plaintext text-primary" style="cursor: pointer; text-decoration: none;">
                                        {{ $business->nama_perusahaan }}
                                    </a>
                                </div>
                            </div>


                            {{-- QR CODE FIELD --}}
                            {{-- <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="qr_code">QR Code</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'qr_code',
                                    ])
                                    <input type="text" name="qr_code" class="form-control" id="qr_code"
                                        placeholder="e.g., QR-001" value="{{ old('qr_code') }}">
                                </div>
                            </div> --}}


                            {{-- JENIS PSAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jenis PSAT</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'jenis_psat',
                                    ])
                                    <select name="jenis_psat" id="jenis_psat" class="form-control">
                                        <option value="">-- Select Jenis PSAT --</option>
                                        @foreach ($jenispsats as $jenispsat)
                                            <option value="{{ $jenispsat->id }}"
                                                {{ old('jenis_psat') == $jenispsat->id ? 'selected' : '' }}>
                                                {{ $jenispsat->nama_jenis_pangan_segar }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- NAMA KOMODITAS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_komoditas">Nama Komoditas*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nama_komoditas',
                                    ])
                                    <input type="text" name="nama_komoditas" class="form-control" id="nama_komoditas"
                                        placeholder="e.g., Melon" value="{{ old('nama_komoditas') }}" required>
                                </div>
                            </div>

                            {{-- NAMA LATIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_latin">Nama Latin*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nama_latin',
                                    ])
                                    <input type="text" name="nama_latin" class="form-control" id="nama_latin"
                                        placeholder="e.g., Cucumis melo" value="{{ old('nama_latin') }}" required>
                                </div>
                            </div>

                            {{-- MERK DAGANG FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="merk_dagang">Merk Dagang*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'merk_dagang',
                                    ])
                                    <input type="text" name="merk_dagang" class="form-control" id="merk_dagang"
                                        placeholder="e.g., PanganAman" value="{{ old('merk_dagang') }}" required>
                                </div>
                            </div>

                            {{-- REFERENSI FIELDS GROUP --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Referensi Dokumen</label>
                                <div class="col-sm-10">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Referensi SPPB</label>
                                                    <select name="referensi_sppb" class="form-control">
                                                        <option value="">-- Select SPPB --</option>
                                                        @foreach ($sppbs as $sppb)
                                                            <option value="{{ $sppb->id }}"
                                                                {{ old('referensi_sppb') == $sppb->id ? 'selected' : '' }}>
                                                                {{ $sppb->nomor_sppb }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'referensi_sppb']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Referensi Izin EDAR PSATPL</label>
                                                    <select name="referensi_izinedar_psatpl" class="form-control">
                                                        <option value="">-- Select Izin EDAR PSATPL --</option>
                                                        @foreach ($izinedarPsatpls as $izinedarPsatpl)
                                                            <option value="{{ $izinedarPsatpl->id }}"
                                                                {{ old('referensi_izinedar_psatpl') == $izinedarPsatpl->id ? 'selected' : '' }}>
                                                                {{ $izinedarPsatpl->nomor_izinedar_pl }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'referensi_izinedar_psatpl']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Referensi Izin EDAR PSATPD</label>
                                                    <select name="referensi_izinedar_psatpd" class="form-control">
                                                        <option value="">-- Select Izin EDAR PSATPD --</option>
                                                        @foreach ($izinedarPsatpds as $izinedarPsatpd)
                                                            <option value="{{ $izinedarPsatpd->id }}"
                                                                {{ old('referensi_izinedar_psatpd') == $izinedarPsatpd->id ? 'selected' : '' }}>
                                                                {{ $izinedarPsatpd->nomor_izinedar_pd }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'referensi_izinedar_psatpd']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Referensi Izin EDAR PSATPDUK</label>
                                                    <select name="referensi_izinedar_psatpduk" class="form-control">
                                                        <option value="">-- Select Izin EDAR PSATPDUK --</option>
                                                        @foreach ($izinedarPsatpduks as $izinedarPsatpduk)
                                                            <option value="{{ $izinedarPsatpduk->id }}"
                                                                {{ old('referensi_izinedar_psatpduk') == $izinedarPsatpduk->id ? 'selected' : '' }}>
                                                                {{ $izinedarPsatpduk->nomor_izinedar_pduk }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'referensi_izinedar_psatpduk']
                                                    )
                                                </div>
                                                {{-- <div class="col-md-6 mb-3">
                                                    <label class="form-label">Referensi Izin Rumah Pengemasan</label>
                                                    <select name="referensi_izinrumah_pengemasan" class="form-control">
                                                        <option value="">-- Select Izin Rumah Pengemasan --</option>
                                                        @foreach ($izinrumahPengemasans as $izinrumahPengemasan)
                                                            <option value="{{ $izinrumahPengemasan->id }}"
                                                                {{ old('referensi_izinrumah_pengemasan') == $izinrumahPengemasan->id ? 'selected' : '' }}>
                                                                {{ $izinrumahPengemasan->nomor_izin }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'referensi_izinrumah_pengemasan']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Referensi Sertifikat Keamanan Pangan</label>
                                                    <select name="referensi_sertifikat_keamanan_pangan" class="form-control">
                                                        <option value="">-- Select Sertifikat Keamanan Pangan --</option>
                                                        @foreach ($sertifikatKeamananPangans as $sertifikatKeamananPangan)
                                                            <option value="{{ $sertifikatKeamananPangan->id }}"
                                                                {{ old('referensi_sertifikat_keamanan_pangan') == $sertifikatKeamananPangan->id ? 'selected' : '' }}>
                                                                {{ $sertifikatKeamananPangan->nomor_sertifikat }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'referensi_sertifikat_keamanan_pangan']
                                                    )
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- FILE LAMPIRAN FIELDS GROUP --}}
                            {{-- <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">File Lampiran (Jika dibutuhkan)</label>
                                <div class="col-sm-10">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">File Lampiran 1</label>
                                                    <input type="file" name="file_lampiran1" class="form-control" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                                    <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 2MB</small>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'file_lampiran1']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">File Lampiran 2</label>
                                                    <input type="file" name="file_lampiran2" class="form-control" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                                    <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 2MB</small>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'file_lampiran2']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">File Lampiran 3</label>
                                                    <input type="file" name="file_lampiran3" class="form-control" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                                    <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 2MB</small>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'file_lampiran3']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">File Lampiran 4</label>
                                                    <input type="file" name="file_lampiran4" class="form-control" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                                    <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 2MB</small>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'file_lampiran4']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">File Lampiran 5</label>
                                                    <input type="file" name="file_lampiran5" class="form-control" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                                    <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 2MB</small>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'file_lampiran5']
                                                    )
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- CURRENT ASSIGNEE FIELD --}}
                            {{-- <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="current_assignee">Assign To</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'current_assignee',
                                    ])
                                    <select name="current_assignee" id="current_assignee" class="form-control">
                                        <option value="">-- Select Assignee --</option>
                                        @foreach ($assignees as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('current_assignee') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Ajukan QR Badan Pangan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
