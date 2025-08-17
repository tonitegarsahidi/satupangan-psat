@extends('admin/template-base')

@section('page-title', 'Edit Batas Cemaran Logam Berat')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Batas Cemaran Logam Berat</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.batas-cemaran-logam-berat.update', $batasCemaranLogamBerat->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- JENIS PSAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="jenis_psat">Jenis Pangan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'jenis_psat'])

                                    {{-- input form --}}
                                    <select name="jenis_psat" id="jenis_psat" class="form-select" required>
                                        <option value="">-- Select Jenis Pangan --</option>
                                        @foreach ($jenisPangans as $jenisPangan)
                                            <option value="{{ $jenisPangan->id }}" {{ $batasCemaranLogamBerat->jenis_psat == $jenisPangan->id ? 'selected' : '' }}>
                                                {{ $jenisPangan->nama_jenis_pangan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- CEMARAN LOGAM BERAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="cemaran_logam_berat">Cemaran Logam Berat*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'cemaran_logam_berat'])

                                    {{-- input form --}}
                                    <select name="cemaran_logam_berat" id="cemaran_logam_berat" class="form-select" required>
                                        <option value="">-- Select Cemaran Logam Berat --</option>
                                        @foreach ($cemaranLogamBerats as $cemaranLogamBerat)
                                            <option value="{{ $cemaranLogamBerat->id }}" {{ $batasCemaranLogamBerat->cemaran_logam_berat == $cemaranLogamBerat->id ? 'selected' : '' }}>
                                                {{ $cemaranLogamBerat->nama_cemaran_logam_berat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- VALUE MIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="value_min">Minimum Value*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'value_min'])

                                    {{-- input form --}}
                                    <input type="number" name="value_min" class="form-control" id="value_min"
                                        placeholder="contoh: 0.1" value="{{ old('value_min', $batasCemaranLogamBerat->value_min) }}" step="any" required>
                                </div>
                            </div>

                            {{-- VALUE MAX FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="value_max">Maximum Value*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'value_max'])

                                    {{-- input form --}}
                                    <input type="number" name="value_max" class="form-control" id="value_max"
                                        placeholder="contoh: 0.5" value="{{ old('value_max', $batasCemaranLogamBerat->value_max) }}" step="any" required>
                                </div>
                            </div>

                            {{-- SATUAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="satuan">Satuan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'satuan'])

                                    {{-- input form --}}
                                    <input type="text" name="satuan" class="form-control" id="satuan"
                                        placeholder="contoh: mg/kg" value="{{ old('satuan', $batasCemaranLogamBerat->satuan) }}" required>
                                </div>
                            </div>

                            {{-- METODE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="metode">Metode*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'metode'])

                                    {{-- input form --}}
                                    <input type="text" name="metode" class="form-control" id="metode"
                                        placeholder="contoh: AAS" value="{{ old('metode', $batasCemaranLogamBerat->metode) }}" required>
                                </div>
                            </div>

                            {{-- KETERANGAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="keterangan">Keterangan</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'keterangan'])

                                    {{-- input form --}}
                                    <textarea name="keterangan" class="form-control" id="keterangan" rows="3"
                                        placeholder="contoh: Batas maksimum untuk logam berat dalam pangan">{{ old('keterangan', $batasCemaranLogamBerat->keterangan) }}</textarea>
                                </div>
                            </div>

                            {{-- IS_ACTIVE RADIO BUTTONS --}}
                            <div class="row mb-3">
                                @php
                                    $oldIsActive = old('is_active', $batasCemaranLogamBerat->is_active); // Default to current value
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
