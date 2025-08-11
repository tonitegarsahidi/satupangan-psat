@extends('admin/template-base')

@section('page-title', 'Add New Bahan Pangan Segar')


@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">


            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Bahan Pangan Segar</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.master-bahan-pangan-segar.store') }}">
                            @csrf

                            {{-- JENIS ID FIELD (DROPDOWN) --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="jenis_id">Jenis Pangan Segar*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'jenis_id'])

                                    {{-- input form --}}
                                    <select name="jenis_id" id="jenis_id" class="form-select">
                                        <option value="">-- Select Jenis Pangan Segar --</option>
                                        @foreach ($jenisPanganSegars as $jenisPanganSegar)
                                            <option value="{{ $jenisPanganSegar->id }}" {{ old('jenis_id') == $jenisPanganSegar->id ? 'selected' : '' }}>
                                                {{ $jenisPanganSegar->nama_jenis_pangan_segar }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- KODE BAHAN PANGAN SEGAR FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kode_bahan_pangan_segar">Kode Bahan Pangan Segar</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'kode_bahan_pangan_segar'])

                                    {{-- input form --}}
                                    <input type="text" name="kode_bahan_pangan_segar" class="form-control" id="kode_bahan_pangan_segar"
                                        placeholder="contoh:  11" value="{{ old('kode_bahan_pangan_segar', isset($kode_bahan_pangan_segar) ? $kode_bahan_pangan_segar : '') }}">
                                </div>
                            </div>

                            {{-- NAMA BAHAN PANGAN SEGAR FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_bahan_pangan_segar">Nama Bahan Pangan Segar*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_bahan_pangan_segar'])

                                    {{-- input form --}}
                                    <input type="text" name="nama_bahan_pangan_segar" class="form-control" id="nama_bahan_pangan_segar"
                                        placeholder="contoh:  Beras Putih" value="{{ old('nama_bahan_pangan_segar', isset($nama_bahan_pangan_segar) ? $nama_bahan_pangan_segar : '') }}">
                                </div>
                            </div>

                            {{-- IS_ACTIVE RADIO BUTTONS --}}
                            <div class="row mb-3">
                                @php
                                    $oldIsActive = old('is_active', 1); // Default to 1 (true)
                                @endphp
                                <label class="col-sm-2 col-form-label" for="is_active">Is Active*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'is_active'])

                                    {{-- input form --}}
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_true" value="1"
                                            {{ $oldIsActive == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_active_true">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_false" value="0"
                                            {{ $oldIsActive == 0 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_active_false">No</label>
                                    </div>
                                </div>
                            </div>





                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
