@extends('admin/template-base')

@section('page-title', 'Add New Pengawasan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Tambah Pengawasan</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('pengawasan.store') }}">
                            @csrf

                            {{-- USER ID INITIATOR FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="user_id_initiator">Pembuat</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'user_id_initiator'])

                                    {{-- input form --}}
                                    <select name="user_id_initiator" class="form-select" id="user_id_initiator">
                                        <option value="{{ auth()->id() }}">{{ auth()->user()->name }}</option>
                                    </select>
                                </div>
                            </div>

                            {{-- LOKASI ALAMAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lokasi_alamat">Alamat Lokasi*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'lokasi_alamat'])

                                    {{-- input form --}}
                                    <input type="text" name="lokasi_alamat" class="form-control" id="lokasi_alamat"
                                        placeholder="Enter location address" value="{{ old('lokasi_alamat') }}">
                                </div>
                            </div>

                            {{-- LOKASI PROVINSI & KOTA FIELD --}}
                            @include('components.provinsi-kota', [
                                'provinsis' => $provinsis,
                                'kotas' => $kotas ?? [],
                                'selectedProvinsiId' => old('lokasi_provinsi_id'),
                                'selectedKotaId' => old('lokasi_kota_id'),
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
                                    @include('admin.components.notification.error-validation', ['field' => 'tanggal_mulai'])

                                    {{-- input form --}}
                                    <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai"
                                        value="{{ old('tanggal_mulai') }}">
                                </div>
                            </div>

                            {{-- TANGGAL SELESAI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_selesai">Tanggal Selesai</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'tanggal_selesai'])

                                    {{-- input form --}}
                                    <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai"
                                        value="{{ old('tanggal_selesai') }}">
                                </div>
                            </div>

                            {{-- JENIS PSAT & PRODUK PSAT FIELD --}}
                            @include('components.jenis-psat-produk-psat', [
                                'jenisPsats' => $jenisPsats,
                                'produkPsats' => $produkPsats ?? [],
                                'selectedJenisId' => old('jenis_psat_id'),
                                'selectedProdukId' => old('produk_psat_id'),
                                'jenisFieldName' => 'nama_jenis_pangan_segar',
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
                                    @include('admin.components.notification.error-validation', ['field' => 'hasil_pengawasan'])

                                    {{-- input form --}}
                                    <textarea name="hasil_pengawasan" class="form-control" id="hasil_pengawasan" rows="3"
                                        placeholder="Enter supervision result">{{ old('hasil_pengawasan') }}</textarea>
                                </div>
                            </div>

                            {{-- STATUS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'status'])

                                    {{-- input form --}}
                                    <select name="status" class="form-select" id="status">
                                        <option value="DRAFT" {{ old('status') == 'DRAFT' ? 'selected' : '' }}>Draft</option>
                                        <option value="PROSES" {{ old('status') == 'PROSES' ? 'selected' : '' }}>In Process</option>
                                        <option value="SELESAI" {{ old('status') == 'SELESAI' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>

                            {{-- TINDAKAN REKOMENDASIKAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tindakan_rekomendasikan">Tindakan Rekomendasi</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'tindakan_rekomendasikan'])

                                    {{-- input form --}}
                                    <textarea name="tindakan_rekomendasikan" class="form-control" id="tindakan_rekomendasikan" rows="3"
                                        placeholder="Enter recommended action">{{ old('tindakan_rekomendasikan') }}</textarea>
                                </div>
                            </div>

                            {{-- IS ACTIVE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="is_active">Aktif*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'is_active'])

                                    {{-- input form --}}
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_true" value="1"
                                            {{ old('is_active') == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_active_true">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_false" value="0"
                                            {{ old('is_active') == 0 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_active_false">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
