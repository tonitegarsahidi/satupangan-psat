@extends('admin/template-base')

@section('page-title', 'Profil Bisnis')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="p-2 bd-highlight">
                        <h3 class="card-header">Profil Bisnis</h3>
                    </div>
                    @if (isset($alerts))
                        @include('admin.components.notification.general', $alerts)
                    @endif
                    <!-- Business Information -->
                    <div class="card-body">
                        <form id="formBusinessSettings" method="POST" action="{{ route('business.profile.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <h5 class="mb-3">Informasi Perusahaan</h5>
                            <div class="row">
                                <!-- Nama Perusahaan -->
                                <div class="mb-3 col-md-6">
                                    <label for="nama_perusahaan" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nama_perusahaan',
                                    ])
                                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                                        value="{{ old('nama_perusahaan', $business->nama_perusahaan ?? '') }}"
                                        placeholder="Masukkan nama perusahaan" required />
                                </div>

                                <!-- Jabatan di Perusahaan -->
                                <div class="mb-3 col-md-6">
                                    <label for="jabatan_perusahaan" class="form-label">Jabatan di Perusahaan</label>
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'jabatan_perusahaan',
                                    ])
                                    <input type="text" class="form-control" id="jabatan_perusahaan" name="jabatan_perusahaan"
                                        value="{{ old('jabatan_perusahaan', $business->jabatan_perusahaan ?? '') }}"
                                        placeholder="Masukkan jabatan Anda di perusahaan" />
                                </div>

                                <!-- NIB -->
                                <div class="mb-3 col-md-6">
                                    <label for="nib" class="form-label">NIB (Nomor Induk Berusaha)</label>
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'nib',
                                    ])
                                    <input type="text" class="form-control" id="nib" name="nib"
                                        value="{{ old('nib', $business->nib ?? '') }}"
                                        placeholder="Nomor Induk Berusaha" />
                                </div>

                                <!-- Apakah Anda UMKM? -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Apakah Anda UMKM?</label>
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'is_umkm',
                                    ])
                                    <div class="d-flex align-items-center">
                                        <div class="form-check form-switch me-3">
                                            <input class="form-check-input" type="checkbox" name="is_umkm" id="is_umkm"
                                                value="1" {{ old('is_umkm', $business->is_umkm ? 'checked' : '') }}>
                                            <label class="form-check-label" for="is_umkm">UMKM</label>
                                        </div>
                                        {{-- <span class="text-muted">Tidak</span> --}}
                                    </div>
                                    <small class="text-muted">Centang jika usaha Anda termasuk UMKM (Usaha Mikro, Kecil, dan Menengah).</small>
                                </div>

                                <!-- Alamat Perusahaan -->
                                <div class="mb-3 col-md-6">
                                    <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan</label>
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'alamat_perusahaan',
                                    ])
                                    <input type="text" class="form-control" id="alamat_perusahaan" name="alamat_perusahaan"
                                        value="{{ old('alamat_perusahaan', $business->alamat_perusahaan ?? '') }}"
                                        placeholder="Masukkan alamat perusahaan" />
                                </div>

                                <!-- Jenis PSAT -->
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Jenis PSAT <span class="text-danger">*</span></label>
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'jenispsat_id',
                                    ])
                                    <div class="row">
                                        @foreach ($jenispsats as $jenispsat)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="jenispsat_id[]"
                                                        value="{{ $jenispsat->id }}" id="jenispsat_{{ $jenispsat->id }}"
                                                        {{ (is_array(old('jenispsat_id')) && in_array($jenispsat->id, old('jenispsat_id'))) || $selectedJenispsats->contains($jenispsat->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="jenispsat_{{ $jenispsat->id }}">
                                                        {{ $jenispsat->nama_jenis_pangan_segar }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="text-muted">Pilih satu atau lebih jenis PSAT yang relevan dengan bisnis Anda.</small>
                                </div>
                            </div>

                            <!-- Save and Cancel Buttons -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                                <button type="reset" class="btn btn-outline-secondary">Batal</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Business Information -->
                </div>
            </div>
        </div>

    </div>
@endsection
