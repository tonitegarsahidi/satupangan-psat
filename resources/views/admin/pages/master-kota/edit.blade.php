@extends('admin/template-base')

@section('page-title', 'Edit Kota')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <!-- Edit User Form -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Kota</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form action="{{ route('admin.master-kota.update', $kota->id) }}"  method="POST">
                            @method('PUT')
                            @csrf

                            {{-- PROVINSI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="provinsi_id">Provinsi*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'provinsi_id'])
                                    <select name="provinsi_id" id="provinsi_id" class="form-control">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($provinsis as $provinsi)
                                            <option value="{{ $provinsi->id }}" {{ old('provinsi_id', $kota->provinsi_id) == $provinsi->id ? 'selected' : '' }}>
                                                {{ $provinsi->nama_provinsi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- KODE KOTA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kode_kota">Kode Kota</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'kode_kota',
                                    ])
                                    <input type="text" name="kode_kota" class="form-control" id="kode_kota"
                                        placeholder="e.g., 1101"
                                        value="{{ old('kode_kota', isset($kota->kode_kota) ? $kota->kode_kota : '') }}">
                                </div>
                            </div>

                            {{-- NAMA PROVINSI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_kota">Nama Kota*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nama_kota',
                                    ])
                                    <input type="text" name="nama_kota" class="form-control" id="nama_kota"
                                        placeholder="e.g., Banda Aceh"
                                        value="{{ old('nama_kota', isset($kota->nama_kota) ? $kota->nama_kota : '') }}">
                                </div>
                            </div>

                            {{-- IS_ACTIVE RADIO BUTTONS --}}
                            <div class="row mb-3">
                                @php
                                    $oldIsActive = old('is_active', $kota->is_active);
                                @endphp
                                <label class="col-sm-2 col-form-label" for="is_active">Is Active*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'is_active',
                                    ])

                                    {{-- input form --}}
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_true"
                                            value="1" {{ $oldIsActive == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active_true">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_false"
                                            value="0" {{ $oldIsActive == 0 ? 'checked' : '' }}>
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
