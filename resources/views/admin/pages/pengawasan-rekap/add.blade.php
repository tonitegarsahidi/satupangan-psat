@extends('admin/template-base')

@section('page-title', 'Add New Pengawasan Rekap')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Tambah Pengawasan Rekap</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('pengawasan-rekap.store') }}">
                            @csrf

                            {{-- PENGAWASAN ID FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="pengawasan_id">Pengawasan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'pengawasan_id'])

                                    {{-- input form --}}
                                    <select name="pengawasan_id" class="form-select" id="pengawasan_id" required>
                                        <option value="">-- Select Pengawasan --</option>
                                        @foreach ($pengawasans ?? [] as $pengawasan)
                                            <option value="{{ $pengawasan->id }}">{{ $pengawasan->lokasi_alamat }} - {{ $pengawasan->jenisPsat->nama_jenis_pangan_segar ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- USER ID ADMIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="user_id_admin">Admin*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'user_id_admin'])

                                    {{-- input form --}}
                                    <select name="user_id_admin" class="form-select" id="user_id_admin" required>
                                        <option value="">-- Select Admin --</option>
                                        @foreach ($admins ?? [] as $admin)
                                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- JENIS PSAT & PRODUK PSAT FIELD --}}
                            @include('components.jenis-psat-produk-psat', [
                                'jenisPsats' => $jenisPsats,
                                'produkPsats' => $produkPsats ?? [],
                                'selectedJenisId' => old('jenis_psat_id'),
                                'selectedProdukId' => old('produk_psat_id'),
                                'jenisFieldName' => 'jenis_psat_id',
                                'produkFieldName' => 'produk_psat_id',
                                'jenisLabel' => 'Jenis PSAT*',
                                'produkLabel' => 'Produk PSAT*',
                                'required' => true,
                                'ajaxUrl' => '/register/produk-psat-by-jenis/'
                            ])

                            {{-- HASIL REKAP FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="hasil_rekap">Hasil Rekap*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'hasil_rekap'])

                                    {{-- input form --}}
                                    <textarea name="hasil_rekap" class="form-control" id="hasil_rekap" rows="3"
                                        placeholder="Enter recap result" required>{{ old('hasil_rekap') }}</textarea>
                                </div>
                            </div>

                            {{-- STATUS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'status'])

                                    {{-- input form --}}
                                    <select name="status" class="form-select" id="status" required>
                                        <option value="DRAFT" {{ old('status') == 'DRAFT' ? 'selected' : '' }}>Draft</option>
                                        <option value="PROSES" {{ old('status') == 'PROSES' ? 'selected' : '' }}>In Process</option>
                                        <option value="SELESAI" {{ old('status') == 'SELESAI' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>

                            {{-- PIC TINDAKAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="pic_tindakan_id">PIC Tindakan</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'pic_tindakan_id'])

                                    {{-- input form --}}
                                    <select name="pic_tindakan_id" class="form-select" id="pic_tindakan_id">
                                        <option value="">-- Select PIC --</option>
                                        @foreach ($pics ?? [] as $pic)
                                            <option value="{{ $pic->id }}">{{ $pic->name }}</option>
                                        @endforeach
                                    </select>
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
