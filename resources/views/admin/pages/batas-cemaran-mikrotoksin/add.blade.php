@extends('admin/template-base')

@section('page-title', 'Add New Batas Cemaran Mikrotoksin')


@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">


            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Batas Cemaran Mikrotoksin</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form action="{{ route('admin.batas-cemaran-mikrotoksin.store') }}"  method="POST">
                            @csrf

                            {{-- JENIS PSAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="jenis_psat">Jenis Pangan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'jenis_psat',
                                    ])

                                    {{-- input form --}}
                                    <select name="jenis_psat" id="jenis_psat" class="form-select" required>
                                        <option value="">-- Select Jenis Pangan --</option>
                                        @foreach ($jenisPangans as $jenisPangan)
                                            <option value="{{ $jenisPangan->id }}">{{ $jenisPangan->nama_jenis_pangan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- CEMARAN MIKROTOKSIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="cemaran_mikrotoksin">Cemaran Mikrotoksin*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'cemaran_mikrotoksin',
                                    ])

                                    {{-- input form --}}
                                    <select name="cemaran_mikrotoksin" id="cemaran_mikrotoksin" class="form-select" required>
                                        <option value="">-- Select Cemaran Mikrotoksin --</option>
                                        @foreach ($cemaranMikrotoksins as $cemaranMikrotoksin)
                                            <option value="{{ $cemaranMikrotoksin->id }}">{{ $cemaranMikrotoksin->nama_cemaran_mikrotoksin }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- VALUE MIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="value_min">Minimum Value*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'value_min',
                                    ])

                                    {{-- input form --}}
                                    <input type="number" name="value_min" class="form-control" id="value_min"
                                        placeholder="contoh: 0.01" value="{{ old('value_min') }}" step="any" required>
                                </div>
                            </div>

                            {{-- VALUE MAX FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="value_max">Maximum Value*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'value_max',
                                    ])

                                    {{-- input form --}}
                                    <input type="number" name="value_max" class="form-control" id="value_max"
                                        placeholder="contoh: 0.05" value="{{ old('value_max') }}" step="any" required>
                                </div>
                            </div>

                            {{-- SATUAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="satuan">Satuan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'satuan',
                                    ])

                                    {{-- input form --}}
                                    <input type="text" name="satuan" class="form-control" id="satuan"
                                        placeholder="contoh: µg/kg" value="{{ old('satuan') }}" required>
                                </div>
                            </div>

                            {{-- METODE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="metode">Metode*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'metode',
                                    ])

                                    {{-- input form --}}
                                    <input type="text" name="metode" class="form-control" id="metode"
                                        placeholder="contoh: HPLC" value="{{ old('metode') }}" required>
                                </div>
                            </div>

                            {{-- KETERANGAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="keterangan">Keterangan</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'keterangan',
                                    ])

                                    {{-- input form --}}
                                    <textarea name="keterangan" class="form-control" id="keterangan" rows="3"
                                        placeholder="contoh: Batas maksimum untuk mikrotoksin dalam pangan">{{ old('keterangan') }}</textarea>
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
