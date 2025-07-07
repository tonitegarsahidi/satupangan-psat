@extends('admin/template-base')

@section('page-title', 'Add New Kelompok Pangan')


@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">


            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Kelompok Pangan</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.master-kelompok-pangan.store') }}">
                            @csrf

                            {{-- KODE KELOMPOK PANGAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kode_kelompok_pangan">Kode Kelompok Pangan</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'kode_kelompok_pangan'])

                                    {{-- input form --}}
                                    <input type="text" name="kode_kelompok_pangan" class="form-control" id="kode_kelompok_pangan"
                                        placeholder="e.g., 11" value="{{ old('kode_kelompok_pangan', isset($kode_kelompok_pangan) ? $kode_kelompok_pangan : '') }}">
                                </div>
                            </div>

                            {{-- NAMA KELOMPOK PANGAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_kelompok_pangan">Nama Kelompok Pangan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_kelompok_pangan'])

                                    {{-- input form --}}
                                    <input type="text" name="nama_kelompok_pangan" class="form-control" id="nama_kelompok_pangan"
                                        placeholder="e.g., Serealia" value="{{ old('nama_kelompok_pangan', isset($nama_kelompok_pangan) ? $nama_kelompok_pangan : '') }}">
                                </div>
                            </div>

                            {{-- KETERANGAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="keterangan">Keterangan</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'keterangan'])

                                    {{-- input form --}}
                                    <textarea name="keterangan" class="form-control" id="keterangan" placeholder="e.g., Kelompok pangan yang termasuk serealia">{{ old('keterangan', isset($keterangan) ? $keterangan : '') }}</textarea>
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
