@extends('admin/template-base')

@section('page-title', 'Add New Register Izin EDAR PSATPL')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Register Izin EDAR PSATPL</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('register-izinedar-psatpl.store') }}">
                            @csrf

                            {{-- BUSINESS ID FIELD (Hidden) --}}
                            <input type="hidden" name="business_id" id="business_id" value="{{ $business->id }}">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Business*</label>
                                <div class="col-sm-10">
                                    <div class="form-control-plaintext">{{ $business->nama_usaha }}</div>
                                </div>
                            </div>


                            {{-- NOMOR REGISTRASI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nomor_registrasi">Nomor Registrasi</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nomor_registrasi',
                                    ])
                                    <input type="text" name="nomor_registrasi" class="form-control" id="nomor_registrasi"
                                        placeholder="e.g., IZIN-EDAR-001" value="{{ old('nomor_registrasi') }}">
                                </div>
                            </div>


                            {{-- ALAMAT UNIT USAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="alamat_unitusaha">Alamat Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'alamat_unitusaha',
                                    ])
                                    <input type="text" name="alamat_unitusaha" class="form-control" id="alamat_unitusaha"
                                        placeholder="e.g., Jl. Contoh No. 1" value="{{ old('alamat_unitusaha') }}">
                                </div>
                            </div>

                            {{-- ALAMAT UNIT PENANGANAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="alamat_unitpenanganan">Alamat Unit
                                    Penanganan</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'alamat_unitpenanganan',
                                    ])
                                    <input type="text" name="alamat_unitpenanganan" class="form-control"
                                        id="alamat_unitpenanganan" placeholder="e.g., Jl. Contoh No. 1"
                                        value="{{ old('alamat_unitpenanganan') }}">
                                </div>
                            </div>

                            @include('components.provinsi-kota', [
                                'provinsis' => $provinsis,
                                'kotas' => $kotas ?? [],
                                'selectedProvinsiId' => old('provinsi_unitusaha'),
                                'selectedKotaId' => old('kota_unitusaha'),
                                'provinsiFieldName' => 'provinsi_unitusaha',
                                'kotaFieldName' => 'kota_unitusaha',
                                'provinsiLabel' => 'Provinsi Unit Usaha',
                                'kotaLabel' => 'Kota Unit Usaha',
                                'required' => false,
                                'ajaxUrl' => '/register/kota-by-provinsi/',
                            ])


                            {{-- NIB UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nib_unitusaha">NIB Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nib_unitusaha',
                                    ])
                                    <input type="text" name="nib_unitusaha" class="form-control" id="nib_unitusaha"
                                        placeholder="e.g., 1234567890" value="{{ old('nib_unitusaha') }}">
                                </div>
                            </div>


                            {{-- JENIS PSAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jenis PSAT</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'jenis_psat',
                                    ])
                                    <select name="jenis_psat" id="jenis_psat" class="form-control">
                                        <option value="">-- Select Jenis PSAT --</option>
                                        @foreach ($jenispsats as $jenispsat)
                                            <option value="{{ $jenispsat->id }}"
                                                {{ old('jenis_psat') == $jenispsat->id ? 'selected' : '' }}>
                                                {{ $jenispsat->nama_jenis_pangan_segar }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- NAMA KOMODITAS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_komoditas">Nama Komoditas</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nama_komoditas',
                                    ])
                                    <input type="text" name="nama_komoditas" class="form-control" id="nama_komoditas"
                                        placeholder="e.g., Melon" value="{{ old('nama_komoditas') }}">
                                </div>
                            </div>

                            {{-- NAMA LATIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_latin">Nama Latin</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nama_latin',
                                    ])
                                    <input type="text" name="nama_latin" class="form-control" id="nama_latin"
                                        placeholder="e.g., Cucumis melo" value="{{ old('nama_latin') }}">
                                </div>
                            </div>

                            {{-- NEGARA ASAL FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="negara_asal">Negara Asal</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'negara_asal',
                                    ])
                                    <input type="text" name="negara_asal" class="form-control" id="negara_asal"
                                        placeholder="e.g., Indonesia" value="{{ old('negara_asal') }}">
                                </div>
                            </div>

                            {{-- MERK DAGANG FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="merk_dagang">Merk Dagang</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'merk_dagang',
                                    ])
                                    <input type="text" name="merk_dagang" class="form-control" id="merk_dagang"
                                        placeholder="e.g., SatuPangan" value="{{ old('merk_dagang') }}">
                                </div>
                            </div>

                            {{-- JENIS KEMASAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="jenis_kemasan">Jenis Kemasan</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'jenis_kemasan',
                                    ])
                                    <input type="text" name="jenis_kemasan" class="form-control" id="jenis_kemasan"
                                        placeholder="e.g., Plastik Wrap" value="{{ old('jenis_kemasan') }}">
                                </div>
                            </div>

                            {{-- UKURAN BERAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="ukuran_berat">Ukuran Berat</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'ukuran_berat',
                                    ])
                                    <input type="text" name="ukuran_berat" class="form-control" id="ukuran_berat"
                                        placeholder="e.g., 1.5 kg per buah" value="{{ old('ukuran_berat') }}">
                                </div>
                            </div>

                            {{-- KLAIM FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="klaim">Klaim</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'klaim',
                                    ])
                                    <input type="text" name="klaim" class="form-control" id="klaim"
                                        placeholder="e.g., Organik, Tanpa Pestisida" value="{{ old('klaim') }}">
                                </div>
                            </div>

                            {{-- FOTO FIELDS GROUP --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Foto Produk</label>
                                <div class="col-sm-10">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Produk (wajib)</label>
                                                    <input type="file" name="foto_1" class="form-control" required>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_1']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Kemasan (wajib)</label>
                                                    <input type="file" name="foto_2" class="form-control" required>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_2']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Label (wajib)</label>
                                                    <input type="file" name="foto_3" class="form-control" required>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_3']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Tambahan 1</label>
                                                    <input type="file" name="foto_4" class="form-control">
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_4']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Tambahan 2</label>
                                                    <input type="file" name="foto_5" class="form-control">
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_5']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Tambahan 3</label>
                                                    <input type="file" name="foto_6" class="form-control">
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_6']
                                                    )
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- OKKP PENANGGUNGJAWAB FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="okkp_penangungjawab">OKKP Penanggung
                                    Jawab</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'okkp_penangungjawab',
                                    ])
                                    <select name="okkp_penangungjawab" id="okkp_penangungjawab" class="form-control"
                                        required>
                                        <option value="">-- Select OKKP Penanggung Jawab --</option>
                                        @foreach ($assignees as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('okkp_penangungjawab') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- TANGGAL TERBIT SERTIFIKAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_terbit">Tanggal Terbit
                                    Sertifikat</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'tanggal_terbit',
                                    ])
                                    <input type="date" name="tanggal_terbit" class="form-control" id="tanggal_terbit"
                                        value="{{ old('tanggal_terbit') }}">
                                </div>
                            </div>

                            {{-- TANGGAL BERAKHIR SERTIFIKAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_terakhir">Tanggal Berakhir
                                    Sertifikat</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'tanggal_terakhir',
                                    ])
                                    <input type="date" name="tanggal_terakhir" class="form-control"
                                        id="tanggal_terakhir" value="{{ old('tanggal_terakhir') }}">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Removed unit usaha checkbox functionality since the checkbox has been removed
        });
    </script>
@endsection
