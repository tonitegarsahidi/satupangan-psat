@extends('admin/template-base')

@section('page-title', 'Add New Business')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">


            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Business</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('business.store') }}">
                            @csrf

                            {{-- NAMA PERUSAHAAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_perusahaan">Nama Perusahaan*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_perusahaan'])
                                    <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan"
                                        placeholder="contoh: PT. Contoh Jaya" value="{{ old('nama_perusahaan') }}" required>
                                </div>
                            </div>

                            {{-- ALAMAT PERUSAHAAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="alamat_perusahaan">Alamat Perusahaan*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'alamat_perusahaan'])
                                    <textarea name="alamat_perusahaan" class="form-control" id="alamat_perusahaan" rows="3"
                                        placeholder="contoh: Jl. Contoh No. 1" required>{{ old('alamat_perusahaan') }}</textarea>
                                </div>
                            </div>

                            {{-- JABATAN PERUSAHAAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="jabatan_perusahaan">Jabatan Perusahaan*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'jabatan_perusahaan'])
                                    <input type="text" name="jabatan_perusahaan" class="form-control" id="jabatan_perusahaan"
                                        placeholder="contoh: Direktur" value="{{ old('jabatan_perusahaan') }}" required>
                                </div>
                            </div>

                            {{-- NIB FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nib">NIB*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nib'])
                                    <input type="text" name="nib" class="form-control" id="nib"
                                        placeholder="contoh: 1234567890" value="{{ old('nib') }}" required>
                                </div>
                            </div>

                            {{-- IS UMKM FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="is_umkm">UMKM</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_umkm" id="is_umkm" value="1"
                                            {{ old('is_umkm') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_umkm">
                                            Ini adalah UMKM
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @include('components.provinsi-kota', [
                                'provinsis' => $provinsis,
                                'kotas' => $kotas ?? [],
                                'selectedProvinsiId' => old('provinsi_id'),
                                'selectedKotaId' => old('kota_id'),
                                'provinsiFieldName' => 'provinsi_id',
                                'kotaFieldName' => 'kota_id',
                                'provinsiLabel' => 'Provinsi Perusahaan',
                                'kotaLabel' => 'Kota Perusahaan',
                                'required' => true,
                                'ajaxUrl' => '/business/kota-by-provinsi/'
                            ])

                            {{-- JENIS PSAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jenis PSAT*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'jenispsat_id'])
                                    <div class="row">
                                        @foreach($jenispsats as $jenispsat)
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="jenispsat_id[]" value="{{ $jenispsat->id }}" id="jenispsat_{{ $jenispsat->id }}"
                                                        {{ in_array($jenispsat->id, old('jenispsat_id', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="jenispsat_{{ $jenispsat->id }}">
                                                        {{ $jenispsat->nama_jenis_pangan_segar }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
