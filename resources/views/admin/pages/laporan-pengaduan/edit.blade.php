@extends('admin/template-base')

@section('page-title', 'Edit Laporan Pengaduan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <!-- Edit Laporan Pengaduan Form -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Laporan Pengaduan</h5>
                        <small class="text-muted float-end">* : wajib diisi</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form action="{{ route('admin.laporan-pengaduan.update', $laporan->id) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_pelapor">Nama Pelapor*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_pelapor'])
                                    <input type="text" name="nama_pelapor" class="form-control" id="nama_pelapor"
                                        placeholder="Nama Pelapor"
                                        value="{{ old('nama_pelapor', $laporan->nama_pelapor) }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nik_pelapor">NIK Pelapor</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nik_pelapor'])
                                    <input type="text" name="nik_pelapor" class="form-control" id="nik_pelapor"
                                        placeholder="NIK Pelapor"
                                        value="{{ old('nik_pelapor', $laporan->nik_pelapor) }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nomor_telepon_pelapor">Nomor Telepon</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nomor_telepon_pelapor'])
                                    <input type="text" name="nomor_telepon_pelapor" class="form-control" id="nomor_telepon_pelapor"
                                        placeholder="Nomor Telepon"
                                        value="{{ old('nomor_telepon_pelapor', $laporan->nomor_telepon_pelapor) }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="email_pelapor">Email</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'email_pelapor'])
                                    <input type="email" name="email_pelapor" class="form-control" id="email_pelapor"
                                        placeholder="Email"
                                        value="{{ old('email_pelapor', $laporan->email_pelapor) }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lokasi_kejadian">Lokasi Kejadian</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'lokasi_kejadian'])
                                    <input type="text" name="lokasi_kejadian" class="form-control" id="lokasi_kejadian"
                                        placeholder="Lokasi Kejadian"
                                        value="{{ old('lokasi_kejadian', $laporan->lokasi_kejadian) }}">
                                </div>
                            </div>

                            @include('components.provinsi-kota', [
                                'provinsis' => $provinsis,
                                'kotas' => $kotas ?? [],
                                'selectedProvinsiId' => old('provinsi_id', $laporan->provinsi_id ?? null),
                                'selectedKotaId' => old('kota_id', $laporan->kota_id ?? null),
                                'provinsiFieldName' => 'provinsi_id',
                                'kotaFieldName' => 'kota_id',
                                'provinsiLabel' => 'Provinsi',
                                'kotaLabel' => 'Kota',
                                'required' => true,
                                'ajaxUrl' => '/register/kota-by-provinsi/'
                            ])

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="isi_laporan">Isi Laporan*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'isi_laporan'])
                                    <textarea name="isi_laporan" class="form-control" id="isi_laporan" rows="3" placeholder="Isi Laporan">{{ old('isi_laporan', $laporan->isi_laporan) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tindak_lanjut_pertama">Tindak Lanjut Pertama</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'tindak_lanjut_pertama'])
                                    <textarea name="tindak_lanjut_pertama" class="form-control" id="tindak_lanjut_pertama" rows="2" placeholder="Tindak Lanjut Pertama">{{ old('tindak_lanjut_pertama', $laporan->tindak_lanjut_pertama) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                @php
                                    $oldIsActive = old('is_active', $laporan->is_active);
                                @endphp
                                <label class="col-sm-2 col-form-label" for="is_active">Is Active*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'is_active'])
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
