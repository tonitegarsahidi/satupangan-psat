@extends('admin/template-base')

@section('page-title', 'Edit Pengawasan Tindakan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- Display validation errors at the top --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <h5><i class="fas fa-exclamation-triangle me-2"></i> Harap perbaiki kesalahan berikut:</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <!-- Edit Pengawasan Tindakan Form -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Pengawasan Tindakan</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    @include('admin.components.notification.error')
                    <div class="card-body">
                        <form action="{{ route('pengawasan-tindakan.update', $pengawasanTindakan->id) }}"  method="POST">
                            @method('PUT')
                            @csrf

                            {{-- PENGAWASAN REKAP ID FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="pengawasan_rekap_id">Rekap Pengawasan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'pengawasan_rekap_id',
                                    ])

                                    {{-- input form --}}
                                    <select name="pengawasan_rekap_id" class="form-select" id="pengawasan_rekap_id" required>
                                        <option value="">-- Pilih Rekap Pengawasan --</option>
                                        @foreach ($pengawasanRekaps as $rekap)
                                            <option value="{{ $rekap['id'] }}"
                                                data-judul-rekap="{{ $rekap['judul_rekap'] }}"
                                                data-created-at="{{ $rekap['formatted_date'] }}"
                                                data-jenis-psat="{{ $rekap['jenis_psat_nama'] }}"
                                                data-produk-psat="{{ $rekap['produk_psat_nama'] }}"
                                                {{ old('pengawasan_rekap_id', isset($pengawasanTindakan->pengawasan_rekap_id) ? $pengawasanTindakan->pengawasan_rekap_id : '') == $rekap['id'] ? 'selected' : '' }}>
                                                {{ $rekap['judul_rekap'] }} - {{ $rekap['formatted_date'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- REKAP DETAILS SECTION (DYNAMICALLY SHOWN) --}}
                            <div id="rekap-details-section" class="row mb-3" style="display: none;">
                                <div class="col-sm-12">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">
                                                <i class="bx bx-info-circle me-2"></i>
                                                Detail Rekap Pengawasan Terpilih
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <strong>Judul Rekap:</strong>
                                                    <p id="selected-judul-rekap" class="mb-1">...</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Tanggal Dibuat:</strong>
                                                    <p id="selected-created-at" class="mb-1">...</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Jenis PSAT:</strong>
                                                    <p id="selected-jenis-psat" class="mb-1">...</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Nama Produk PSAT:</strong>
                                                    <p id="selected-produk-psat" class="mb-1">...</p>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <strong>Detail Lengkap:</strong>
                                                    <p class="mb-1">
                                                        <a id="rekap-detail-link" href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="bx bx-show me-1"></i>
                                                            Lihat Detail Rekap
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- USER ID PEMIMPIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="user_id_pimpinan">Pimpinan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'user_id_pimpinan',
                                    ])

                                    {{-- input form --}}
                                    <select name="user_id_pimpinan" class="form-select" id="user_id_pimpinan" required>
                                        <option value="">-- Pilih Pimpinan --</option>
                                        @foreach ($pimpinans as $pimpinan)
                                            <option value="{{ $pimpinan->id }}"
                                                {{ old('user_id_pimpinan', isset($pengawasanTindakan->user_id_pimpinan) ? $pengawasanTindakan->user_id_pimpinan : '') == $pimpinan->id ? 'selected' : '' }}>
                                                {{ $pimpinan->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- TINDAK LANJUT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tindak_lanjut">Tindak Lanjut*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'tindak_lanjut',
                                    ])

                                    {{-- input form --}}
                                    <textarea name="tindak_lanjut" class="form-control" id="tindak_lanjut" rows="3"
                                        placeholder="Enter follow-up action" required>{{ old('tindak_lanjut', isset($pengawasanTindakan->tindak_lanjut) ? $pengawasanTindakan->tindak_lanjut : '') }}</textarea>
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
                                        <option value="">-- Pilih Status --</option>
                                        @foreach (\App\Models\PengawasanTindakan::getStatusOptions() as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('status', isset($pengawasanTindakan->status) ? $pengawasanTindakan->status : '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- PIC TINDAKAN IDS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="pic_tindakan_ids">PIC Tindakan</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'pic_tindakan_ids',
                                    ])

                                    {{-- input form --}}
                                    <select name="pic_tindakan_ids[]" class="form-select" id="pic_tindakan_ids" multiple>
                                        <option value="">-- Pilih PIC --</option>
                                        @foreach ($pimpinans as $pimpinan)
                                            <option value="{{ $pimpinan->id }}"
                                                {{ (old('pic_tindakan_ids', isset($pengawasanTindakan->pic_tindakan_ids) ? $pengawasanTindakan->pic_tindakan_ids : []) && in_array($pimpinan->id, old('pic_tindakan_ids', isset($pengawasanTindakan->pic_tindakan_ids) ? $pengawasanTindakan->pic_tindakan_ids : [])) ? 'selected' : '' }}>
                                                {{ $pimpinan->name }}
                                            </option>
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
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'is_active',
                                    ])

                                    {{-- input form --}}
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_true" value="1"
                                            {{ old('is_active', isset($pengawasanTindakan->is_active) ? $pengawasanTindakan->is_active : '') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active_true">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_false" value="0"
                                            {{ old('is_active', isset($pengawasanTindakan->is_active) ? $pengawasanTindakan->is_active : '') == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active_false">Tidak</label>
                                    </div>
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

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
const pengawasanRekapSelect = document.getElementById('pengawasan_rekap_id');
const rekapDetailsSection = document.getElementById('rekap-details-section');
const selectedJudulRekapElement = document.getElementById('selected-judul-rekap');
const selectedCreatedAtElement = document.getElementById('selected-created-at');
const selectedJenisPsatElement = document.getElementById('selected-jenis-psat');
const selectedProdukPsatElement = document.getElementById('selected-produk-psat');
const rekapDetailLinkElement = document.getElementById('rekap-detail-link');

pengawasanRekapSelect.addEventListener('change', function() {
   const selectedOption = this.options[this.selectedIndex];

   if (this.value === '') {
       // Hide the section if no option is selected
       rekapDetailsSection.style.display = 'none';
   } else {
       // Show the section and populate data
       const judulRekap = selectedOption.getAttribute('data-judul-rekap') || 'N/A';
       const createdAt = selectedOption.getAttribute('data-created-at') || 'N/A';
       const jenisPsat = selectedOption.getAttribute('data-jenis-psat') || 'N/A';
       const produkPsat = selectedOption.getAttribute('data-produk-psat') || 'N/A';
       const rekapId = this.value;

       selectedJudulRekapElement.textContent = judulRekap;
       selectedCreatedAtElement.textContent = createdAt;
       selectedJenisPsatElement.textContent = jenisPsat;
       selectedProdukPsatElement.textContent = produkPsat;
       rekapDetailLinkElement.href = `{{ url('pengawasan-rekap/detail') }}/${rekapId}`;

       rekapDetailsSection.style.display = 'block';
   }
});

// Trigger change event on page load if a value is already selected (for edit mode)
if (pengawasanRekapSelect.value !== '') {
   pengawasanRekapSelect.dispatchEvent(new Event('change'));
}
});
</script>

@endsection
