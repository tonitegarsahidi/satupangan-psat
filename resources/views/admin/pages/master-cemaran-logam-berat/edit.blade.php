@extends('admin/template-base')

@section('page-title', 'Edit Cemaran Logam Berat')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <!-- Edit User Form -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Cemaran Logam Berat</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form action="{{ route('admin.master-cemaran-logam-berat.update', $cemaranLogamBerat->id) }}"  method="POST">
                            @method('PUT')
                            @csrf

                            {{-- KODE PROVINSI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kode_cemaran_logam_berat">Kode Cemaran Logam Berat</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'kode_cemaran_logam_berat',
                                    ])

                                    {{-- input form --}}
                                    <input type="text" name="kode_cemaran_logam_berat" class="form-control" id="kode_cemaran_logam_berat"
                                        placeholder="contoh:  CLB001"
                                        value="{{ old('kode_cemaran_logam_berat', isset($cemaranLogamBerat->kode_cemaran_logam_berat) ? $cemaranLogamBerat->kode_cemaran_logam_berat : '') }}">
                                </div>
                            </div>

                            {{-- NAMA PROVINSI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_cemaran_logam_berat">Nama Cemaran Logam Berat*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nama_cemaran_logam_berat',
                                    ])

                                    {{-- input form --}}
                                    <input type="text" name="nama_cemaran_logam_berat" class="form-control" id="nama_cemaran_logam_berat"
                                        placeholder="contoh:  Timbal"
                                        value="{{ old('nama_cemaran_logam_berat', isset($cemaranLogamBerat->nama_cemaran_logam_berat) ? $cemaranLogamBerat->nama_cemaran_logam_berat : '') }}">
                                </div>
                            </div>

                            {{-- IS_ACTIVE RADIO BUTTONS --}}
                            <div class="row mb-3">
                                @php
                                    $oldIsActive = old('is_active', $cemaranLogamBerat->is_active);
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
