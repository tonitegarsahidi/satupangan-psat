@extends('admin/template-base')

@section('page-title', 'Add New Cemaran Mikrotoksin')


@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">


            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Cemaran Mikrotoksin</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.master-cemaran-mikrotoksin.store') }}">
                            @csrf

                            {{-- KODE PROVINSI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kode_cemaran_mikrotoksin">Kode Cemaran Mikrotoksin</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'kode_cemaran_mikrotoksin'])

                                    {{-- input form --}}
                                    <input type="text" name="kode_cemaran_mikrotoksin" class="form-control" id="kode_cemaran_mikrotoksin"
                                        placeholder="contoh:  CMT001" value="{{ old('kode_cemaran_mikrotoksin', isset($kode_cemaran_mikrotoksin) ? $kode_cemaran_mikrotoksin : '') }}">
                                </div>
                            </div>

                            {{-- NAMA PROVINSI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_cemaran_mikrotoksin">Nama Cemaran Mikrotoksin*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_cemaran_mikrotoksin'])

                                    {{-- input form --}}
                                    <input type="text" name="nama_cemaran_mikrotoksin" class="form-control" id="nama_cemaran_mikrotoksin"
                                        placeholder="contoh:  Aflatoksin" value="{{ old('nama_cemaran_mikrotoksin', isset($nama_cemaran_mikrotoksin) ? $nama_cemaran_mikrotoksin : '') }}">
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
