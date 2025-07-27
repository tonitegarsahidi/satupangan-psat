@extends('admin/template-base')

@section('page-title', 'Edit Register SPPB')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <!-- Edit User Form -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Register SPPB</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form action="{{ route('register-sppb.update', $registerSppb->id) }}"  method="POST">
                            @method('PUT')
                            @csrf

                            {{-- BUSINESS ID FIELD (Dropdown) --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="business_id">Business*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'business_id'])
                                    <select name="business_id" id="business_id" class="form-select">
                                        <option value="">Select Business</option>
                                        {{-- Assuming $businesses is passed from controller --}}
                                        @foreach ($businesses as $business)
                                            <option value="{{ $business->id }}" {{ old('business_id', $registerSppb->business_id) == $business->id ? 'selected' : '' }}>
                                                {{ $business->nama_usaha }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- STATUS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'status'])
                                    <input type="text" name="status" class="form-control" id="status"
                                        placeholder="e.g., DRAFT" value="{{ old('status', $registerSppb->status) }}">
                                </div>
                            </div>

                            {{-- IS_ENABLED RADIO BUTTONS --}}
                            <div class="row mb-3">
                                @php
                                    $oldIsEnabled = old('is_enabled', $registerSppb->is_enabled);
                                @endphp
                                <label class="col-sm-2 col-form-label" for="is_enabled">Is Enabled*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'is_enabled'])
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_enabled" id="is_enabled_true" value="1"
                                            {{ $oldIsEnabled == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_enabled_true">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_enabled" id="is_enabled_false" value="0"
                                            {{ $oldIsEnabled == 0 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_enabled_false">No</label>
                                    </div>
                                </div>
                            </div>

                            {{-- NOMOR REGISTRASI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nomor_registrasi">Nomor Registrasi</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nomor_registrasi'])
                                    <input type="text" name="nomor_registrasi" class="form-control" id="nomor_registrasi"
                                        placeholder="e.g., REG-SPPB-001" value="{{ old('nomor_registrasi', $registerSppb->nomor_registrasi) }}">
                                </div>
                            </div>

                            {{-- TANGGAL TERBIT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_terbit">Tanggal Terbit</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'tanggal_terbit'])
                                    <input type="date" name="tanggal_terbit" class="form-control" id="tanggal_terbit"
                                        value="{{ old('tanggal_terbit', $registerSppb->tanggal_terbit) }}">
                                </div>
                            </div>

                            {{-- TANGGAL TERAKHIR FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_terakhir">Tanggal Terakhir</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'tanggal_terakhir'])
                                    <input type="date" name="tanggal_terakhir" class="form-control" id="tanggal_terakhir"
                                        value="{{ old('tanggal_terakhir', $registerSppb->tanggal_terakhir) }}">
                                </div>
                            </div>

                            {{-- IS_UNITUSAHA RADIO BUTTONS --}}
                            <div class="row mb-3">
                                @php
                                    $oldIsUnitusaha = old('is_unitusaha', $registerSppb->is_unitusaha);
                                @endphp
                                <label class="col-sm-2 col-form-label" for="is_unitusaha">Is Unit Usaha*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'is_unitusaha'])
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_unitusaha" id="is_unitusaha_true" value="1"
                                            {{ $oldIsUnitusaha == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_unitusaha_true">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_unitusaha" id="is_unitusaha_false" value="0"
                                            {{ $oldIsUnitusaha == 0 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_unitusaha_false">No</label>
                                    </div>
                                </div>
                            </div>

                            {{-- NAMA UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_unitusaha">Nama Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_unitusaha'])
                                    <input type="text" name="nama_unitusaha" class="form-control" id="nama_unitusaha"
                                        placeholder="e.g., PT. Contoh Jaya" value="{{ old('nama_unitusaha', $registerSppb->nama_unitusaha) }}">
                                </div>
                            </div>

                            {{-- ALAMAT UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="alamat_unitusaha">Alamat Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'alamat_unitusaha'])
                                    <input type="text" name="alamat_unitusaha" class="form-control" id="alamat_unitusaha"
                                        placeholder="e.g., Jl. Contoh No. 1" value="{{ old('alamat_unitusaha', $registerSppb->alamat_unitusaha) }}">
                                </div>
                            </div>

                            {{-- PROVINSI UNITUSAHA FIELD (Dropdown) --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="provinsi_unitusaha">Provinsi Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'provinsi_unitusaha'])
                                    <select name="provinsi_unitusaha" id="provinsi_unitusaha" class="form-select">
                                        <option value="">Select Provinsi</option>
                                        {{-- Assuming $provinsis is passed from controller --}}
                                        @foreach ($provinsis as $provinsi)
                                            <option value="{{ $provinsi->id }}" {{ old('provinsi_unitusaha', $registerSppb->provinsi_unitusaha) == $provinsi->id ? 'selected' : '' }}>
                                                {{ $provinsi->nama_provinsi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- KOTA UNITUSAHA FIELD (Dropdown) --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kota_unitusaha">Kota Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'kota_unitusaha'])
                                    <select name="kota_unitusaha" id="kota_unitusaha" class="form-select">
                                        <option value="">Select Kota</option>
                                        {{-- Assuming $kotas is passed from controller --}}
                                        @foreach ($kotas as $kota)
                                            <option value="{{ $kota->id }}" {{ old('kota_unitusaha', $registerSppb->kota_unitusaha) == $kota->id ? 'selected' : '' }}>
                                                {{ $kota->nama_kota }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- NIB UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nib_unitusaha">NIB Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nib_unitusaha'])
                                    <input type="text" name="nib_unitusaha" class="form-control" id="nib_unitusaha"
                                        placeholder="e.g., 1234567890" value="{{ old('nib_unitusaha', $registerSppb->nib_unitusaha) }}">
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
