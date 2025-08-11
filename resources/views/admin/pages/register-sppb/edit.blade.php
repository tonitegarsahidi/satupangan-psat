@extends('admin/template-base')

@section('page-title', 'Edit Register SPPB')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <!-- Edit User Form -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Register SPPB</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form method="POST" action="{{ route('register-sppb.update', $registerSppb->id) }}">
                            @method('PUT')
                            @csrf

                            {{-- BUSINESS ID FIELD (Hidden) --}}
                            <input type="hidden" name="business_id" id="business_id" value="{{ $registerSppb->business_id }}">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Nama Unit Usaha</label>
                                <div class="col-sm-10">
                                    <div class="form-control-plaintext">{{ $registerSppb->business->nama_usaha }}</div>
                                </div>
                            </div>

                            {{-- NOMOR REGISTRASI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nomor_registrasi">Nomor Registrasi</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nomor_registrasi'])
                                    <input type="text" name="nomor_registrasi" class="form-control" id="nomor_registrasi"
                                        placeholder="contoh:  SPPB-001" value="{{ old('nomor_registrasi', $registerSppb->nomor_registrasi) }}">
                                </div>
                            </div>

                            {{-- NAMA UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_unitusaha">Nama Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_unitusaha'])
                                    <input type="text" name="nama_unitusaha" class="form-control" id="nama_unitusaha"
                                        placeholder="contoh:  PT. Contoh Jaya" value="{{ old('nama_unitusaha', $registerSppb->nama_unitusaha) }}">
                                </div>
                            </div>

                            {{-- ALAMAT UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="alamat_unitusaha">Alamat Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'alamat_unitusaha'])
                                    <input type="text" name="alamat_unitusaha" class="form-control" id="alamat_unitusaha"
                                        placeholder="contoh:  Jl. Contoh No. 1" value="{{ old('alamat_unitusaha', $registerSppb->alamat_unitusaha) }}">
                                </div>
                            </div>

                            {{-- ALAMAT UNIT PENANGANAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="alamat_unit_penanganan">Alamat Unit Penanganan</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'alamat_unit_penanganan'])
                                    <input type="text" name="alamat_unit_penanganan" class="form-control" id="alamat_unit_penanganan"
                                        placeholder="contoh:  Jl. Contoh No. 1" value="{{ old('alamat_unit_penanganan', $registerSppb->alamat_unit_penanganan) }}">
                                </div>
                            </div>

                            @include('components.provinsi-kota', [
                                'provinsis' => $provinsis,
                                'kotas' => $kotas ?? [],
                                'selectedProvinsiId' => old('provinsi_unitusaha', $registerSppb->provinsi_unitusaha),
                                'selectedKotaId' => old('kota_unitusaha', $registerSppb->kota_unitusaha),
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
                                        placeholder="contoh:  1234567890" value="{{ old('nib_unitusaha', $registerSppb->nib_unitusaha) }}">
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
                                                        {{ in_array($jenispsat->id, old('jenispsat_id', $registerSppb->jenispsats->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                                        placeholder="contoh:  Beras" value="{{ old('nama_komoditas', $registerSppb->nama_komoditas) }}">
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
                                            <option value="{{ $penanganan->id }}" {{ old('ruang_lingkup_penanganan', $registerSppb->penanganan_id) == $penanganan->id ? 'selected' : '' }}>
                                                {{ $penanganan->nama_penanganan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- PENANGANAN KETERANGAN FIELD (conditionally shown) --}}
                            <div class="row mb-3" id="penanganan_keterangan_row" style="display: {{ $registerSppb->penanganan && $registerSppb->penanganan->nama_penanganan === 'Pengolahan minimal lainnya (sebutkan)' ? 'flex' : 'none' }};">
                                <label class="col-sm-2 col-form-label" for="penanganan_keterangan">Keterangan Penanganan*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'penanganan_keterangan'])
                                    <input type="text" name="penanganan_keterangan" class="form-control" id="penanganan_keterangan"
                                        placeholder="Sebutkan jenis pengolahan minimal lainnya" value="{{ old('penanganan_keterangan', $registerSppb->penanganan_keterangan) }}" required>
                                </div>
                            </div>

                            {{-- TANGGAL TERBIT SERTIFIKAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_terbit">Tanggal Terbit Sertifikat</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'tanggal_terbit'])
                                    <input type="date" name="tanggal_terbit" class="form-control" id="tanggal_terbit"
                                        value="{{ old('tanggal_terbit', $registerSppb->tanggal_terbit) }}">
                                </div>
                            </div>

                            {{-- TANGGAL BERAKHIR SERTIFIKAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_terakhir">Tanggal Berakhir Sertifikat</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'tanggal_terakhir'])
                                    <input type="date" name="tanggal_terakhir" class="form-control" id="tanggal_terakhir"
                                        value="{{ old('tanggal_terakhir', $registerSppb->tanggal_terakhir) }}">
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
