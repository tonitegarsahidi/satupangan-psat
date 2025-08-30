@extends('admin/template-base')

@section('page-title', 'Edit Pengawasan Rekap')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <!-- Edit Pengawasan Rekap Form -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Pengawasan Rekap</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form action="{{ route('pengawasan-rekap.update', $pengawasanRekap->id) }}"  method="POST">
                            @method('PUT')
                            @csrf

                            {{-- PROVINSI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="provinsi_id">Provinsi</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'provinsi_id',
                                    ])

                                    {{-- input form --}}
                                    <select name="provinsi_id" class="form-select" id="provinsi_id">
                                        <option value="">-- Select Provinsi --</option>
                                        @foreach ($provinsis ?? [] as $provinsi)
                                            <option value="{{ $provinsi->id }}" {{ old('provinsi_id', $pengawasanRekap->provinsi_id) == $provinsi->id ? 'selected' : '' }}>
                                                {{ $provinsi->nama_provinsi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- JENIS PSAT & PRODUK PSAT FIELD --}}
                            @include('components.jenis-psat-produk-psat', [
                                'jenisPsats' => $jenisPsats,
                                'produkPsats' => $produkPsats ?? [],
                                'selectedJenisId' => old('jenis_psat_id', $pengawasanRekap->jenis_psat_id),
                                'selectedProdukId' => old('produk_psat_id', $pengawasanRekap->produk_psat_id),
                                'jenisFieldName' => 'jenis_psat_id',
                                'produkFieldName' => 'produk_psat_id',
                                'jenisLabel' => 'Jenis PSAT*',
                                'produkLabel' => 'Produk PSAT*',
                                'required' => true,
                                'ajaxUrl' => '/register/produk-psat-by-jenis/'
                            ])

                            {{-- HASIL REKAP FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="hasil_rekap">Hasil Rekap*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'hasil_rekap',
                                    ])

                                    {{-- input form --}}
                                    <textarea name="hasil_rekap" class="form-control" id="hasil_rekap" rows="3"
                                        placeholder="Enter recap result" required>{{ old('hasil_rekap', $pengawasanRekap->hasil_rekap) }}</textarea>
                                </div>
                            </div>

                            {{-- LAMPIRAN FIELDS --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Lampiran</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran1">Lampiran 1</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran1'])
                                            <input type="text" class="form-control" id="lampiran1" name="lampiran1"
                                                placeholder="Enter attachment 1 path" value="{{ old('lampiran1', $pengawasanRekap->lampiran1) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran2">Lampiran 2</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran2'])
                                            <input type="text" class="form-control" id="lampiran2" name="lampiran2"
                                                placeholder="Enter attachment 2 path" value="{{ old('lampiran2', $pengawasanRekap->lampiran2) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran3">Lampiran 3</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran3'])
                                            <input type="text" class="form-control" id="lampiran3" name="lampiran3"
                                                placeholder="Enter attachment 3 path" value="{{ old('lampiran3', $pengawasanRekap->lampiran3) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran4">Lampiran 4</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran4'])
                                            <input type="text" class="form-control" id="lampiran4" name="lampiran4"
                                                placeholder="Enter attachment 4 path" value="{{ old('lampiran4', $pengawasanRekap->lampiran4) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran5">Lampiran 5</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran5'])
                                            <input type="text" class="form-control" id="lampiran5" name="lampiran5"
                                                placeholder="Enter attachment 5 path" value="{{ old('lampiran5', $pengawasanRekap->lampiran5) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran6">Lampiran 6</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran6'])
                                            <input type="text" class="form-control" id="lampiran6" name="lampiran6"
                                                placeholder="Enter attachment 6 path" value="{{ old('lampiran6', $pengawasanRekap->lampiran6) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- STATUS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'status',
                                    ])

                                    {{-- input form --}}
                                    <select name="status" class="form-select" id="status" required>
                                        <option value="DRAFT" {{ old('status', $pengawasanRekap->status) == 'DRAFT' ? 'selected' : '' }}>Draft</option>
                                        <option value="PROSES" {{ old('status', $pengawasanRekap->status) == 'PROSES' ? 'selected' : '' }}>In Process</option>
                                        <option value="SELESAI" {{ old('status', $pengawasanRekap->status) == 'SELESAI' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
