@extends('admin/template-base')

@section('page-title', 'Add New Register SPPB')


@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">


            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Register SPPB</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('register-sppb.store') }}">
                            @csrf

                            {{-- BUSINESS ID FIELD (Hidden) --}}
                            <input type="hidden" name="business_id" id="business_id" value="{{ $business->id }}">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Business*</label>
                                <div class="col-sm-10">
                                    <div class="form-control-plaintext">{{ $business->nama_usaha }}</div>
                                </div>
                            </div>




                            {{-- NAMA UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_unitusaha">Nama Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_unitusaha'])
                                    <input type="text" name="nama_unitusaha" class="form-control" id="nama_unitusaha"
                                        placeholder="e.g., PT. Contoh Jaya" value="{{ old('nama_unitusaha', $business->nama_perusahaan ?? '') }}">
                                </div>
                            </div>

                            {{-- ALAMAT UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="alamat_unitusaha">Alamat Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'alamat_unitusaha'])
                                    <input type="text" name="alamat_unitusaha" class="form-control" id="alamat_unitusaha"
                                        placeholder="e.g., Jl. Contoh No. 1" value="{{ old('alamat_unitusaha', $business->alamat_perusahaan ?? '') }}">
                                </div>
                            </div>

                            @include('components.provinsi-kota', [
                                'provinsis' => $provinsis,
                                'kotas' => $kotas ?? [],
                                'selectedProvinsiId' => old('provinsi_unitusaha', $business->provinsi_id ?? ''),
                                'selectedKotaId' => old('kota_unitusaha', $business->kota_id ?? ''),
                                'provinsiFieldName' => 'provinsi_unitusaha',
                                'kotaFieldName' => 'kota_unitusaha',
                                'provinsiLabel' => 'Provinsi Unit Usaha',
                                'kotaLabel' => 'Kota Unit Usaha',
                                'required' => false,
                                'ajaxUrl' => '/register/kota-by-provinsi/'
                            ])

                            {{-- NIB UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nib_unitusaha">NIB Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nib_unitusaha'])
                                    <input type="text" name="nib_unitusaha" class="form-control" id="nib_unitusaha"
                                        placeholder="e.g., 1234567890" value="{{ old('nib_unitusaha', $business->nib ?? '') }}">
                                </div>
                            </div>

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
                                                        {{ in_array($jenispsat->id, old('jenispsat_id', $business->jenispsats->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="jenispsat_{{ $jenispsat->id }}">
                                                        {{ $jenispsat->nama_jenis_pangan_segar }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- NAMA KOMODITAS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_komoditas">Nama Komoditas</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_komoditas'])
                                    <input type="text" name="nama_komoditas" class="form-control" id="nama_komoditas"
                                        placeholder="e.g., Beras" value="{{ old('nama_komoditas') }}">
                                </div>
                            </div>

                            {{-- RUANG LINGKUP PENANGANAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="ruang_lingkup_penanganan">Ruang Lingkup Penanganan*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'ruang_lingkup_penanganan'])
                                    <select name="ruang_lingkup_penanganan" id="ruang_lingkup_penanganan" class="form-control" required>
                                        <option value="">-- Select Penanganan --</option>
                                        @foreach($penanganans as $penanganan)
                                            <option value="{{ $penanganan->id }}" {{ old('ruang_lingkup_penanganan') == $penanganan->id ? 'selected' : '' }}>
                                                {{ $penanganan->nama_penanganan }}
                                            </option>
                                        @endforeach
                                    </select>
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
