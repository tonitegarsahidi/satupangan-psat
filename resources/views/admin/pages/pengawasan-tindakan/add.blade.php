@extends('admin/template-base')

@section('page-title', 'Add New Pengawasan Tindakan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Tambah Pengawasan Tindakan</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('pengawasan-tindakan.store') }}">
                            @csrf

                            {{-- PENGAWASAN REKAP ID FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="pengawasan_rekap_id">Rekap Pengawasan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'pengawasan_rekap_id'])

                                    {{-- input form --}}
                                    <select name="pengawasan_rekap_id" class="form-select" id="pengawasan_rekap_id" required>
                                        <option value="">-- Pilih Rekap Pengawasan --</option>
                                        @foreach ($pengawasanRekaps as $rekap)
                                            <option value="{{ $rekap->id }}"
                                                data-info="{{ $rekap->pengawasan ? $rekap->pengawasan->lokasi_alamat : 'N/A' }}">
                                                {{ $rekap->pengawasan ? $rekap->pengawasan->lokasi_alamat : 'N/A' }} - {{ $rekap->created_at->format('d/m/Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- USER ID PEMIMPIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="user_id_pimpinan">Pimpinan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'user_id_pimpinan'])

                                    {{-- input form --}}
                                    <select name="user_id_pimpinan" class="form-select" id="user_id_pimpinan" required>
                                        <option value="">-- Pilih Pimpinan --</option>
                                        @foreach ($pimpinans as $pimpinan)
                                            <option value="{{ $pimpinan->id }}">{{ $pimpinan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- TINDAK LANJUT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tindak_lanjut">Tindak Lanjut*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'tindak_lanjut'])

                                    {{-- input form --}}
                                    <textarea name="tindak_lanjut" class="form-control" id="tindak_lanjut" rows="3"
                                        placeholder="Enter follow-up action" required>{{ old('tindak_lanjut') }}</textarea>
                                </div>
                            </div>

                            {{-- STATUS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'status'])

                                    {{-- input form --}}
                                    <select name="status" class="form-select" id="status" required>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach (\App\Models\PengawasanTindakan::getStatusOptions() as $value => $label)
                                            <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- PIC TINDAKAN IDS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="pic_tindakan_ids">PIC Tindakan</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'pic_tindakan_ids'])

                                    {{-- input form --}}
                                    <select name="pic_tindakan_ids[]" class="form-select" id="pic_tindakan_ids" multiple>
                                        <option value="">-- Pilih PIC --</option>
                                        @foreach ($pimpinans as $pimpinan)
                                            <option value="{{ $pimpinan->id }}">{{ $pimpinan->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Klik Ctrl/Cmd untuk memilih beberapa PIC</small>
                                </div>
                            </div>

                            {{-- IS ACTIVE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="is_active">Aktif*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'is_active'])

                                    {{-- input form --}}
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_true" value="1"
                                            {{ old('is_active') == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_active_true">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_false" value="0"
                                            {{ old('is_active') == 0 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_active_false">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
