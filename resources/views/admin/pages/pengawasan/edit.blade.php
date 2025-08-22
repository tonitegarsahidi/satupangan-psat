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
                        <form action="{{ route('pengawasan.update', $pengawasan->id) }}"  method="POST">
                            @method('PUT')
                            @csrf

                            {{-- USER ID INITIATOR FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="user_id_initiator">Initiator</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'user_id_initiator',
                                    ])

                                    {{-- input form --}}
                                    <select name="user_id_initiator" class="form-select" id="user_id_initiator">
                                        <option value="{{ auth()->id() }}">{{ auth()->user()->name }}</option>
                                    </select>
                                </div>
                            </div>

                            {{-- LOKASI ALAMAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lokasi_alamat">Location Address*</label>
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

                            {{-- LOKASI KOTA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lokasi_kota_id">City*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'lokasi_kota_id',
                                    ])

                                    {{-- input form --}}
                                    <select name="lokasi_kota_id" class="form-select" id="lokasi_kota_id">
                                        <option value="">Select City</option>
                                        @foreach ($kotaList ?? [] as $kota)
                                            <option value="{{ $kota->id }}" {{ old('lokasi_kota_id', isset($pengawasan->lokasi_kota_id) ? $pengawasan->lokasi_kota_id : '') == $kota->id ? 'selected' : '' }}>
                                                {{ $kota->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- LOKASI PROVINSI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lokasi_provinsi_id">Province*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'lokasi_provinsi_id',
                                    ])

                                    {{-- input form --}}
                                    <select name="lokasi_provinsi_id" class="form-select" id="lokasi_provinsi_id">
                                        <option value="">Select Province</option>
                                        @foreach ($provinsiList ?? [] as $provinsi)
                                            <option value="{{ $provinsi->id }}" {{ old('lokasi_provinsi_id', isset($pengawasan->lokasi_provinsi_id) ? $pengawasan->lokasi_provinsi_id : '') == $provinsi->id ? 'selected' : '' }}>
                                                {{ $provinsi->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- TANGGAL MULAI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_mulai">Start Date*</label>
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
                                <label class="col-sm-2 col-form-label" for="tanggal_selesai">End Date</label>
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

                            {{-- JENIS PSAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="jenis_psat_id">PSAT Type*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'jenis_psat_id',
                                    ])

                                    {{-- input form --}}
                                    <select name="jenis_psat_id" class="form-select" id="jenis_psat_id">
                                        <option value="">Select PSAT Type</option>
                                        @foreach ($jenisPsatList ?? [] as $jenisPsat)
                                            <option value="{{ $jenisPsat->id }}" {{ old('jenis_psat_id', isset($pengawasan->jenis_psat_id) ? $pengawasan->jenis_psat_id : '') == $jenisPsat->id ? 'selected' : '' }}>
                                                {{ $jenisPsat->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- PRODUK PSAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="produk_psat_id">PSAT Product*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'produk_psat_id',
                                    ])

                                    {{-- input form --}}
                                    <select name="produk_psat_id" class="form-select" id="produk_psat_id">
                                        <option value="">Select PSAT Product</option>
                                        @foreach ($produkPsatList ?? [] as $produkPsat)
                                            <option value="{{ $produkPsat->id }}" {{ old('produk_psat_id', isset($pengawasan->produk_psat_id) ? $pengawasan->produk_psat_id : '') == $produkPsat->id ? 'selected' : '' }}>
                                                {{ $produkPsat->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- HASIL PENGAWASAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="hasil_pengawasan">Supervision Result*</label>
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
                                <label class="col-sm-2 col-form-label" for="tindakan_rekomendasikan">Recommended Action</label>
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

                            {{-- IS ACTIVE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="is_active">Is Active*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'is_active',
                                    ])

                                    {{-- input form --}}
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_true" value="1"
                                            {{ old('is_active', isset($pengawasan->is_active) ? $pengawasan->is_active : '') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active_true">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_false" value="0"
                                            {{ old('is_active', isset($pengawasan->is_active) ? $pengawasan->is_active : '') == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active_false">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
