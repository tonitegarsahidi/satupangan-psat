@extends('admin/template-base')

@section('page-title', 'Edit Pengawasan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <!-- Edit Pengawasan Form -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Pengawasan</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form action="{{ route('pengawasan.update', $pengawasan->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf


                            {{-- LOKASI ALAMAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lokasi_alamat">Alamat Lokasi*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'lokasi_alamat',
                                    ])

                                    {{-- input form --}}
                                    <input type="text" name="lokasi_alamat" class="form-control" id="lokasi_alamat"
                                        placeholder="Enter location address"
                                        value="{{ old('lokasi_alamat', isset($pengawasan->lokasi_alamat) ? $pengawasan->lokasi_alamat : '') }}">
                                </div>
                            </div>

                            {{-- LOKASI PROVINSI & KOTA FIELD --}}
                            @include('components.provinsi-kota', [
                                'provinsis' => $provinsis,
                                'kotas' => $kotas ?? [],
                                'selectedProvinsiId' => old('lokasi_provinsi_id', isset($pengawasan->lokasi_provinsi_id) ? $pengawasan->lokasi_provinsi_id : null),
                                'selectedKotaId' => old('lokasi_kota_id', isset($pengawasan->lokasi_kota_id) ? $pengawasan->lokasi_kota_id : null),
                                'provinsiFieldName' => 'lokasi_provinsi_id',
                                'kotaFieldName' => 'lokasi_kota_id',
                                'provinsiLabel' => 'Provinsi',
                                'kotaLabel' => 'Kota',
                                'required' => true,
                                'ajaxUrl' => '/register/kota-by-provinsi/'
                            ])

                            {{-- TANGGAL MULAI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_mulai">Tanggal Mulai*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'tanggal_mulai',
                                    ])

                                    {{-- input form --}}
                                    <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai"
                                        value="{{ old('tanggal_mulai', isset($pengawasan->tanggal_mulai) ? $pengawasan->tanggal_mulai : '') }}">
                                </div>
                            </div>

                            {{-- TANGGAL SELESAI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_selesai">Tanggal Selesai</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'tanggal_selesai',
                                    ])

                                    {{-- input form --}}
                                    <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai"
                                        value="{{ old('tanggal_selesai', isset($pengawasan->tanggal_selesai) ? $pengawasan->tanggal_selesai : '') }}">
                                </div>
                            </div>

                            {{-- JENIS PSAT & PRODUK PSAT FIELD --}}
                            @include('components.jenis-psat-produk-psat', [
                                'jenisPsats' => $jenisPsats,
                                'produkPsats' => $produkPsats ?? [],
                                'selectedJenisId' => old('jenis_psat_id', isset($pengawasan->jenis_psat_id) ? $pengawasan->jenis_psat_id : null),
                                'selectedProdukId' => old('produk_psat_id', isset($pengawasan->produk_psat_id) ? $pengawasan->produk_psat_id : null),
                                'jenisFieldName' => 'jenis_psat_id',
                                'produkFieldName' => 'produk_psat_id',
                                'jenisLabel' => 'Jenis PSAT',
                                'produkLabel' => 'Produk PSAT',
                                'required' => true,
                                'ajaxUrl' => '/register/produk-psat-by-jenis/'
                            ])

                            {{-- HASIL PENGAWASAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="hasil_pengawasan">Hasil Pengawasan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'hasil_pengawasan',
                                    ])

                                    {{-- input form --}}
                                    <textarea name="hasil_pengawasan" class="form-control" id="hasil_pengawasan" rows="3"
                                        placeholder="Enter supervision result">{{ old('hasil_pengawasan', isset($pengawasan->hasil_pengawasan) ? $pengawasan->hasil_pengawasan : '') }}</textarea>
                                </div>
                            </div>

                            {{-- LAMPIRAN 1 FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lampiran1">Lampiran 1</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'lampiran1',
                                    ])

                                    {{-- Existing file display --}}
                                    @if(isset($pengawasan->lampiran1) && $pengawasan->lampiran1)
                                        <div class="mb-2">
                                            <small class="text-muted">Current file:</small>
                                            <a href="{{ $pengawasan->lampiran1 }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                View Current File
                                            </a>
                                        </div>
                                    @endif

                                    {{-- input form --}}
                                    <input type="file" name="lampiran1" class="form-control" id="lampiran1"
                                        accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG. Leave empty to keep current file.</small>
                                </div>
                            </div>

                            {{-- LAMPIRAN 2 FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lampiran2">Lampiran 2</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'lampiran2',
                                    ])

                                    {{-- Existing file display --}}
                                    @if(isset($pengawasan->lampiran2) && $pengawasan->lampiran2)
                                        <div class="mb-2">
                                            <small class="text-muted">Current file:</small>
                                            <a href="{{ $pengawasan->lampiran2 }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                View Current File
                                            </a>
                                        </div>
                                    @endif

                                    {{-- input form --}}
                                    <input type="file" name="lampiran2" class="form-control" id="lampiran2"
                                        accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG. Leave empty to keep current file.</small>
                                </div>
                            </div>

                            {{-- LAMPIRAN 3 FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lampiran3">Lampiran 3</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'lampiran3',
                                    ])

                                    {{-- Existing file display --}}
                                    @if(isset($pengawasan->lampiran3) && $pengawasan->lampiran3)
                                        <div class="mb-2">
                                            <small class="text-muted">Current file:</small>
                                            <a href="{{ $pengawasan->lampiran3 }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                View Current File
                                            </a>
                                        </div>
                                    @endif

                                    {{-- input form --}}
                                    <input type="file" name="lampiran3" class="form-control" id="lampiran3"
                                        accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG. Leave empty to keep current file.</small>
                                </div>
                            </div>

                            {{-- LAMPIRAN 4 FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lampiran4">Lampiran 4</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'lampiran4',
                                    ])

                                    {{-- Existing file display --}}
                                    @if(isset($pengawasan->lampiran4) && $pengawasan->lampiran4)
                                        <div class="mb-2">
                                            <small class="text-muted">Current file:</small>
                                            <a href="{{ $pengawasan->lampiran4 }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                View Current File
                                            </a>
                                        </div>
                                    @endif

                                    {{-- input form --}}
                                    <input type="file" name="lampiran4" class="form-control" id="lampiran4"
                                        accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG. Leave empty to keep current file.</small>
                                </div>
                            </div>

                            {{-- LAMPIRAN 5 FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lampiran5">Lampiran 5</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'lampiran5',
                                    ])

                                    {{-- Existing file display --}}
                                    @if(isset($pengawasan->lampiran5) && $pengawasan->lampiran5)
                                        <div class="mb-2">
                                            <small class="text-muted">Current file:</small>
                                            <a href="{{ $pengawasan->lampiran5 }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                View Current File
                                            </a>
                                        </div>
                                    @endif

                                    {{-- input form --}}
                                    <input type="file" name="lampiran5" class="form-control" id="lampiran5"
                                        accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG. Leave empty to keep current file.</small>
                                </div>
                            </div>

                            {{-- LAMPIRAN 6 FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lampiran6">Lampiran 6</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'lampiran6',
                                    ])

                                    {{-- Existing file display --}}
                                    @if(isset($pengawasan->lampiran6) && $pengawasan->lampiran6)
                                        <div class="mb-2">
                                            <small class="text-muted">Current file:</small>
                                            <a href="{{ $pengawasan->lampiran6 }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                View Current File
                                            </a>
                                        </div>
                                    @endif

                                    {{-- input form --}}
                                    <input type="file" name="lampiran6" class="form-control" id="lampiran6"
                                        accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG. Leave empty to keep current file.</small>
                                </div>
                            </div>

                            {{-- STATUS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'status',
                                    ])

                                    {{-- input form --}}
                                    <select name="status" class="form-select" id="status">
                                        <option value="DRAFT" {{ old('status', isset($pengawasan->status) ? $pengawasan->status : '') == 'DRAFT' ? 'selected' : '' }}>Draft</option>
                                        <option value="PROSES" {{ old('status', isset($pengawasan->status) ? $pengawasan->status : '') == 'PROSES' ? 'selected' : '' }}>In Process</option>
                                        <option value="SELESAI" {{ old('status', isset($pengawasan->status) ? $pengawasan->status : '') == 'SELESAI' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>

                            {{-- TINDAKAN REKOMENDASIKAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tindakan_rekomendasikan">Tindakan Rekomendasi</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'tindakan_rekomendasikan',
                                    ])

                                    {{-- input form --}}
                                    <textarea name="tindakan_rekomendasikan" class="form-control" id="tindakan_rekomendasikan" rows="3"
                                        placeholder="Enter recommended action">{{ old('tindakan_rekomendasikan', isset($pengawasan->tindakan_rekomendasikan) ? $pengawasan->tindakan_rekomendasikan : '') }}</textarea>
                                </div>
                            </div>


                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
