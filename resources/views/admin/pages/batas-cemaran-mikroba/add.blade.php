@extends('admin/template-base')

@section('page-title', 'Add New Batas Cemaran Mikroba')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Batas Cemaran Mikroba</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.batas-cemaran-mikroba.store') }}">
                            @csrf

                            {{-- JENIS PSAT FIELD --}}
                            <div class="mb-3">
                                <label class="form-label" for="jenis_psat">Jenis Pangan*</label>
                                <div class="form-control-wrapper">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'jenis_psat'])

                                    {{-- input form --}}
                                    <select name="jenis_psat" id="jenis_psat" class="form-select" required>
                                        <option value="">-- Select Jenis Pangan --</option>
                                        @foreach ($jenisPangans as $jenisPangan)
                                            <option value="{{ $jenisPangan->id }}">{{ $jenisPangan->nama_jenis_pangan_segar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- CEMARAN MIKROBA FIELD --}}
                            <div class="mb-3">
                                <label class="form-label" for="cemaran_mikroba">Cemaran Mikroba*</label>
                                <div class="form-control-wrapper">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'cemaran_mikroba'])

                                    {{-- input form --}}
                                    <select name="cemaran_mikroba" id="cemaran_mikroba" class="form-select" required>
                                        <option value="">-- Select Cemaran Mikroba --</option>
                                        @foreach ($cemaranMikrobas as $cemaranMikroba)
                                            <option value="{{ $cemaranMikroba->id }}">{{ $cemaranMikroba->nama_cemaran_mikroba }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- VALUE MIN FIELD --}}
                            <div class="mb-3">
                                <label class="form-label" for="value_min">Minimum Value*</label>
                                <div class="form-control-wrapper">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'value_min'])

                                    {{-- input form --}}
                                    <input type="number" name="value_min" class="form-control" id="value_min"
                                        placeholder="contoh: 0.1" value="{{ old('value_min') }}" step="any" required>
                                </div>
                            </div>

                            {{-- VALUE MAX FIELD --}}
                            <div class="mb-3">
                                <label class="form-label" for="value_max">Maximum Value*</label>
                                <div class="form-control-wrapper">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'value_max'])

                                    {{-- input form --}}
                                    <input type="number" name="value_max" class="form-control" id="value_max"
                                        placeholder="contoh: 0.5" value="{{ old('value_max') }}" step="any" required>
                                </div>
                            </div>

                            {{-- SATUAN FIELD --}}
                            <div class="mb-3">
                                <label class="form-label" for="satuan">Satuan*</label>
                                <div class="form-control-wrapper">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'satuan'])

                                    {{-- input form --}}
                                    <input type="text" name="satuan" class="form-control" id="satuan"
                                        placeholder="contoh: CFU/g" value="{{ old('satuan') }}" required>
                                </div>
                            </div>

                            {{-- METODE FIELD --}}
                            <div class="mb-3">
                                <label class="form-label" for="metode">Metode*</label>
                                <div class="form-control-wrapper">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'metode'])

                                    {{-- input form --}}
                                    <input type="text" name="metode" class="form-control" id="metode"
                                        placeholder="contoh: ISO 4833" value="{{ old('metode') }}" required>
                                </div>
                            </div>

                            {{-- KETERANGAN FIELD --}}
                            <div class="mb-3">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <div class="form-control-wrapper">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'keterangan'])

                                    {{-- input form --}}
                                    <textarea name="keterangan" class="form-control" id="keterangan" rows="3"
                                        placeholder="contoh: Batas maksimum untuk mikroba dalam pangan">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>

                            {{-- IS_ACTIVE RADIO BUTTONS --}}
                            <div class="mb-3">
                                @php
                                    $oldIsActive = old('is_active', 1); // Default to 1 (true)
                                @endphp
                                <label class="form-label" for="is_active">Is Active*</label>
                                <div class="form-control-wrapper">
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

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
