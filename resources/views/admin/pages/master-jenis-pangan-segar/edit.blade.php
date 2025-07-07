@extends('admin/template-base')

@section('page-title', 'Edit Jenis Pangan Segar')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <!-- Edit User Form -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Jenis Pangan Segar</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form action="{{ route('admin.master-jenis-pangan-segar.update', $jenisPanganSegar->id) }}"  method="POST">
                            @method('PUT')
                            @csrf

                            {{-- KELOMPOK ID FIELD (DROPDOWN) --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kelompok_id">Kelompok Pangan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'kelompok_id'])

                                    {{-- input form --}}
                                    <select name="kelompok_id" id="kelompok_id" class="form-select">
                                        <option value="">-- Select Kelompok Pangan --</option>
                                        @foreach ($kelompokPangans as $kelompokPangan)
                                            <option value="{{ $kelompokPangan->id }}" {{ old('kelompok_id', $jenisPanganSegar->kelompok_id) == $kelompokPangan->id ? 'selected' : '' }}>
                                                {{ $kelompokPangan->nama_kelompok_pangan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- KODE JENIS PANGAN SEGAR FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kode_jenis_pangan_segar">Kode Jenis Pangan Segar</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'kode_jenis_pangan_segar',
                                    ])

                                    {{-- input form --}}
                                    <input type="text" name="kode_jenis_pangan_segar" class="form-control" id="kode_jenis_pangan_segar"
                                        placeholder="e.g., 11"
                                        value="{{ old('kode_jenis_pangan_segar', isset($jenisPanganSegar->kode_jenis_pangan_segar) ? $jenisPanganSegar->kode_jenis_pangan_segar : '') }}">
                                </div>
                            </div>

                            {{-- NAMA JENIS PANGAN SEGAR FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_jenis_pangan_segar">Nama Jenis Pangan Segar*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nama_jenis_pangan_segar',
                                    ])

                                    {{-- input form --}}
                                    <input type="text" name="nama_jenis_pangan_segar" class="form-control" id="nama_jenis_pangan_segar"
                                        placeholder="e.g., Beras"
                                        value="{{ old('nama_jenis_pangan_segar', isset($jenisPanganSegar->nama_jenis_pangan_segar) ? $jenisPanganSegar->nama_jenis_pangan_segar : '') }}">
                                </div>
                            </div>

                            {{-- IS_ACTIVE RADIO BUTTONS --}}
                            <div class="row mb-3">
                                @php
                                    $oldIsActive = old('is_active', $jenisPanganSegar->is_active);
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
