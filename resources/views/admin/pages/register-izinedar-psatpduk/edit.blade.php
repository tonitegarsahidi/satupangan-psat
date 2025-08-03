@extends('admin/template-base')

@section('page-title', 'Edit Register Izin EDAR PSATPDUK')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <!-- Edit User Form -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Register Izin EDAR PSATPDUK</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form method="POST" action="{{ route('register-izinedar-psatpduk.update', $registerIzinedarPsatpduk->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            {{-- BUSINESS ID FIELD (Hidden) --}}
                            <input type="hidden" name="business_id" id="business_id" value="{{ $registerIzinedarPsatpduk->business_id }}">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Business*</label>
                                <div class="col-sm-10">
                                    <div class="form-control-plaintext">{{ $registerIzinedarPsatpduk->business->nama_usaha }}</div>
                                </div>
                            </div>

                            {{-- TAMPILKAN AREA INI HANYA UNTUK ADMIN/OPERATOR/SUPERVISOR --}}
                            @if (auth()->user()->hasAnyRole(['ROLE_ADMIN', 'ROLE_OPERATOR', 'ROLE_SUPERVISOR']))
                            {{-- STATUS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'status'])
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">-- Select Status --</option>
                                        <option value="DIAJUKAN" {{ old('status', $registerIzinedarPsatpduk->status) == 'DIAJUKAN' ? 'selected' : '' }}>DIAJUKAN</option>
                                        <option value="DISETUJUI" {{ old('status', $registerIzinedarPsatpduk->status) == 'DISETUJUI' ? 'selected' : '' }}>DISETUJUI</option>
                                        <option value="DITOLAK" {{ old('status', $registerIzinedarPsatpduk->status) == 'DITOLAK' ? 'selected' : '' }}>DITOLAK</option>
                                        <option value="DIPERIKSA" {{ old('status', $registerIzinedarPsatpduk->status) == 'DIPERIKSA' ? 'selected' : '' }}>DIPERIKSA</option>
                                    </select>
                                </div>
                            </div>


                            {{-- IS ENABLED FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="is_enabled">Is Enabled</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'is_enabled'])
                                    <div class="form-check">
                                        <input type="hidden" name="is_enabled" value="0">
                                        <input type="checkbox" name="is_enabled" class="form-check-input" id="is_enabled" value="1" {{ old('is_enabled', $registerIzinedarPsatpduk->is_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_enabled">Enable this registration</label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- NOMOR SPPB FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nomor_sppb">Nomor SPPB</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nomor_sppb'])
                                    <input type="text" name="nomor_sppb" class="form-control" id="nomor_sppb"
                                        placeholder="e.g., SPPB-001" value="{{ old('nomor_sppb', $registerIzinedarPsatpduk->nomor_sppb) }}">
                                </div>
                            </div>

                            {{-- NOMOR IZIN EDAR PL FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nomor_izinedar_pl">Nomor Izin EDAR PL</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nomor_izinedar_pl'])
                                    <input type="text" name="nomor_izinedar_pl" class="form-control" id="nomor_izinedar_pl"
                                        placeholder="e.g., IZIN-EDAR-001" value="{{ old('nomor_izinedar_pl', $registerIzinedarPsatpduk->nomor_izinedar_pl) }}">
                                </div>
                            </div>

                            {{-- NAMA UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_unitusaha">Nama Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_unitusaha'])
                                    <input type="text" name="nama_unitusaha" class="form-control" id="nama_unitusaha"
                                        placeholder="e.g., PT. Contoh Jaya" value="{{ old('nama_unitusaha', $registerIzinedarPsatpduk->nama_unitusaha) }}">
                                </div>
                            </div>

                            {{-- ALAMAT UNITUSAHA FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="alamat_unitusaha">Alamat Unit Usaha</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'alamat_unitusaha'])
                                    <input type="text" name="alamat_unitusaha" class="form-control" id="alamat_unitusaha"
                                        placeholder="e.g., Jl. Contoh No. 1" value="{{ old('alamat_unitusaha', $registerIzinedarPsatpduk->alamat_unitusaha) }}">
                                </div>
                            </div>

                            {{-- ALAMAT UNIT PENANGANAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="alamat_unitpenanganan">Alamat Unit Penanganan</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'alamat_unitpenanganan'])
                                    <input type="text" name="alamat_unitpenanganan" class="form-control" id="alamat_unitpenanganan"
                                        placeholder="e.g., Jl. Contoh No. 1" value="{{ old('alamat_unitpenanganan', $registerIzinedarPsatpduk->alamat_unitpenanganan) }}">
                                </div>
                            </div>

                            @include('components.provinsi-kota', [
                                'provinsis' => $provinsis,
                                'kotas' => $kotas ?? [],
                                'selectedProvinsiId' => old('provinsi_unitusaha', $registerIzinedarPsatpduk->provinsi_unitusaha),
                                'selectedKotaId' => old('kota_unitusaha', $registerIzinedarPsatpduk->kota_unitusaha),
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
                                        placeholder="e.g., 1234567890" value="{{ old('nib_unitusaha', $registerIzinedarPsatpduk->nib_unitusaha) }}">
                                </div>
                            </div>

                            {{-- JENIS PSAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jenis PSAT</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'jenis_psat'])
                                    <select name="jenis_psat" id="jenis_psat" class="form-control">
                                        <option value="">-- Select Jenis PSAT --</option>
                                        @foreach($jenispsats as $jenispsat)
                                            <option value="{{ $jenispsat->id }}" {{ old('jenis_psat', $registerIzinedarPsatpduk->jenis_psat) == $jenispsat->id ? 'selected' : '' }}>
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
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_komoditas'])
                                    <input type="text" name="nama_komoditas" class="form-control" id="nama_komoditas"
                                        placeholder="e.g., Melon" value="{{ old('nama_komoditas', $registerIzinedarPsatpduk->nama_komoditas) }}">
                                </div>
                            </div>

                            {{-- NAMA LATIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_latin">Nama Latin</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_latin'])
                                    <input type="text" name="nama_latin" class="form-control" id="nama_latin"
                                        placeholder="e.g., Cucumis melo" value="{{ old('nama_latin', $registerIzinedarPsatpduk->nama_latin) }}">
                                </div>
                            </div>

                            {{-- NEGARA ASAL FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="negara_asal">Negara Asal</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'negara_asal'])
                                    <input type="text" name="negara_asal" class="form-control" id="negara_asal"
                                        placeholder="e.g., Indonesia" value="{{ old('negara_asal', $registerIzinedarPsatpduk->negara_asal) }}">
                                </div>
                            </div>

                            {{-- MERK DAGANG FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="merk_dagang">Merk Dagang</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'merk_dagang'])
                                    <input type="text" name="merk_dagang" class="form-control" id="merk_dagang"
                                        placeholder="e.g., SatuPangan" value="{{ old('merk_dagang', $registerIzinedarPsatpduk->merk_dagang) }}">
                                </div>
                            </div>

                            {{-- JENIS KEMASAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="jenis_kemasan">Jenis Kemasan</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'jenis_kemasan'])
                                    <input type="text" name="jenis_kemasan" class="form-control" id="jenis_kemasan"
                                        placeholder="e.g., Plastik Wrap" value="{{ old('jenis_kemasan', $registerIzinedarPsatpduk->jenis_kemasan) }}">
                                </div>
                            </div>

                            {{-- UKURAN BERAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="ukuran_berat">Ukuran Berat</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'ukuran_berat'])
                                    <input type="text" name="ukuran_berat" class="form-control" id="ukuran_berat"
                                        placeholder="e.g., 1.5 kg per buah" value="{{ old('ukuran_berat', $registerIzinedarPsatpduk->ukuran_berat) }}">
                                </div>
                            </div>

                            {{-- KLAIM FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="klaim">Klaim</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'klaim'])
                                    <input type="text" name="klaim" class="form-control" id="klaim"
                                        placeholder="e.g., Organik, Tanpa Pestisida" value="{{ old('klaim', $registerIzinedarPsatpduk->klaim) }}">
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
                                                    @if($registerIzinedarPsatpduk->foto_1)
                                                        <div class="mb-2">
                                                            <a href="{{ $registerIzinedarPsatpduk->foto_1 }}" target="_blank">
                                                                <img src="{{ $registerIzinedarPsatpduk->foto_1 }}" alt="Foto 1" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="foto_1" class="form-control">
                                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah.</small>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_1']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Kemasan (wajib)</label>
                                                    @if($registerIzinedarPsatpduk->foto_2)
                                                        <div class="mb-2">
                                                            <a href="{{ $registerIzinedarPsatpduk->foto_2 }}" target="_blank">
                                                                <img src="{{ $registerIzinedarPsatpduk->foto_2 }}" alt="Foto 2" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="foto_2" class="form-control">
                                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah.</small>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_2']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Label (wajib)</label>
                                                    @if($registerIzinedarPsatpduk->foto_3)
                                                        <div class="mb-2">
                                                            <a href="{{ $registerIzinedarPsatpduk->foto_3 }}" target="_blank">
                                                                <img src="{{ $registerIzinedarPsatpduk->foto_3 }}" alt="Foto 3" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="foto_3" class="form-control">
                                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah.</small>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_3']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Tambahan 1</label>
                                                    @if($registerIzinedarPsatpduk->foto_4)
                                                        <div class="mb-2">
                                                            <a href="{{ $registerIzinedarPsatpduk->foto_4 }}" target="_blank">
                                                                <img src="{{ $registerIzinedarPsatpduk->foto_4 }}" alt="Foto 4" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="foto_4" class="form-control">
                                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah.</small>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_4']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Tambahan 2</label>
                                                    @if($registerIzinedarPsatpduk->foto_5)
                                                        <div class="mb-2">
                                                            <a href="{{ $registerIzinedarPsatpduk->foto_5 }}" target="_blank">
                                                                <img src="{{ $registerIzinedarPsatpduk->foto_5 }}" alt="Foto 5" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="foto_5" class="form-control">
                                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah.</small>
                                                    @include(
                                                        'admin.components.notification.error-validation',
                                                        ['field' => 'foto_5']
                                                    )
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto Tambahan 3</label>
                                                    @if($registerIzinedarPsatpduk->foto_6)
                                                        <div class="mb-2">
                                                            <a href="{{ $registerIzinedarPsatpduk->foto_6 }}" target="_blank">
                                                                <img src="{{ $registerIzinedarPsatpduk->foto_6 }}" alt="Foto 6" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="foto_6" class="form-control">
                                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah.</small>
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

                            {{-- FILE NIB FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="file_nib">File NIB</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'file_nib'])
                                    @if($registerIzinedarPsatpduk->file_nib)
                                        <div class="mb-2">
                                            <a href="{{ $registerIzinedarPsatpduk->file_nib }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-file-pdf me-1"></i> Lihat File NIB
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" name="file_nib" class="form-control" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 2MB. Kosongkan jika tidak ingin mengubah.</small>
                                </div>
                            </div>

                            {{-- FILE SPPB FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="file_sppb">File SPPB</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'file_sppb'])
                                    @if($registerIzinedarPsatpduk->file_sppb)
                                        <div class="mb-2">
                                            <a href="{{ $registerIzinedarPsatpduk->file_sppb }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-file-pdf me-1"></i> Lihat File SPPB
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" name="file_sppb" class="form-control" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 2MB. Kosongkan jika tidak ingin mengubah.</small>
                                </div>
                            </div>

                            {{-- FILE IZIN EDAR PSATPDUK FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="file_izinedar_psatpduk">File Izin EDAR PSATPDUK</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'file_izinedar_psatpduk'])
                                    @if($registerIzinedarPsatpduk->file_izinedar_psatpduk)
                                        <div class="mb-2">
                                            <a href="{{ $registerIzinedarPsatpduk->file_izinedar_psatpduk }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-file-pdf me-1"></i> Lihat File Izin EDAR PSATPDUK
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" name="file_izinedar_psatpduk" class="form-control" accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                    <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 2MB. Kosongkan jika tidak ingin mengubah.</small>
                                </div>
                            </div>

                            {{-- OKKP PENANGGUNGJAWAB FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="okkp_penangungjawab">OKKP Penanggung Jawab</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'okkp_penangungjawab',
                                    ])
                                    <select name="okkp_penangungjawab" id="okkp_penangungjawab" class="form-control"
                                        required>
                                        <option value="">-- Select OKKP Penanggung Jawab --</option>
                                        @foreach ($assignees as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('okkp_penangungjawab', $registerIzinedarPsatpduk->okkp_penangungjawab) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- TANGGAL TERBIT SERTIFIKAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_terbit">Tanggal Terbit Sertifikat</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'tanggal_terbit'])
                                    <input type="date" name="tanggal_terbit" class="form-control" id="tanggal_terbit"
                                        value="{{ old('tanggal_terbit', $registerIzinedarPsatpduk->tanggal_terbit) }}">
                                </div>
                            </div>

                            {{-- TANGGAL BERAKHIR SERTIFIKAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_terakhir">Tanggal Berakhir Sertifikat</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'tanggal_terakhir'])
                                    <input type="date" name="tanggal_terakhir" class="form-control" id="tanggal_terakhir"
                                        value="{{ old('tanggal_terakhir', $registerIzinedarPsatpduk->tanggal_terakhir) }}">
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
