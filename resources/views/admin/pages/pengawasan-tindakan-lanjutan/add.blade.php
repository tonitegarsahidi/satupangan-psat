@extends('admin/template-base')

@section('page-title', 'Add New Pengawasan Tindakan Lanjutan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Tambah Pengawasan Tindakan Lanjutan</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('pengawasan-tindakan-lanjutan.store') }}">
                            @csrf

                            {{-- PENGAWASAN TINDAKAN ID FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="pengawasan_tindakan_id">Tindakan Asal*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'pengawasan_tindakan_id'])

                                    {{-- input form --}}
                                    <select name="pengawasan_tindakan_id" class="form-select" id="pengawasan_tindakan_id" required>
                                        <option value="">-- Pilih Tindakan Asal --</option>
                                        @foreach ($pengawasanTindakans as $tindakan)
                                            <option value="{{ $tindakan['id'] }}"
                                                data-tindak-lanjut="{{ $tindakan['tindak_lanjut'] }}"
                                                data-created-at="{{ $tindakan['formatted_date'] }}"
                                                data-pimpinan="{{ $tindakan['pimpinan_nama'] }}"
                                                data-rekap-judul="{{ $tindakan['rekap_judul'] }}"
                                                {{ isset($pengawasanTindakanId) && $pengawasanTindakanId == $tindakan['id'] ? 'selected' : '' }}>
                                                {{ $tindakan['tindak_lanjut'] }} - {{ $tindakan['formatted_date'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- TINDAKAN DETAILS SECTION (DYNAMICALLY SHOWN) --}}
                            <div id="tindakan-details-section" class="row mb-3" style="display: none;">
                                <div class="col-sm-12">
                                    <div class="card bg-light" style="background-color: rgba(255, 235, 125, 0.2) !important; border-width:2px">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">
                                                <i class="bx bx-info-circle me-2"></i>
                                                <strong> Tindakan Asal Terpilih</strong>
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td class="bg-primary text-white" style="width:300px"><strong>Tindak Lanjut</strong></td>
                                                        <td class="bg-white"><p id="selected-tindak-lanjut" class="mb-0">...</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-primary text-white" style="width:300px"><strong>Tanggal Dibuat</strong></td>
                                                        <td class="bg-white"><p id="selected-created-at" class="mb-0">...</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-primary text-white"  style="width:300px"><strong>PIC Tindakan</strong></td>
                                                        <td class="bg-white"><p id="selected-pimpinan" class="mb-0">...</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-primary text-white"  style="width:300px"><strong>Rekap Pengawasan</strong></td>
                                                        <td class="bg-white"><p id="selected-rekap-judul" class="mb-0">...</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-primary text-white"  style="width:300px"><strong>Detail Lengkap</strong></td>
                                                        <td class="bg-white">
                                                            <a id="tindakan-detail-link" href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="bx bx-show me-1"></i>
                                                                Lihat Detail Tindakan
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- USER ID PIC FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="user_id_pic">PIC Tindakan Lanjutan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'user_id_pic'])

                                    {{-- input form --}}
                                    <select name="user_id_pic" class="form-select" id="user_id_pic" required>
                                        <option value="">-- Pilih PIC --</option>
                                        @foreach ($pics as $pic)
                                            <option value="{{ $pic->id }}">{{ $pic->name }}</option>
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
                                        @foreach (\App\Models\PengawasanTindakanLanjutan::getStatusOptions() as $value => $label)
                                            <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
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

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
const pengawasanTindakanSelect = document.getElementById('pengawasan_tindakan_id');
const tindakanDetailsSection = document.getElementById('tindakan-details-section');
const selectedTindakLanjutElement = document.getElementById('selected-tindak-lanjut');
const selectedCreatedAtElement = document.getElementById('selected-created-at');
const selectedPimpinanElement = document.getElementById('selected-pimpinan');
const selectedRekapJudulElement = document.getElementById('selected-rekap-judul');
const tindakanDetailLinkElement = document.getElementById('tindakan-detail-link');

pengawasanTindakanSelect.addEventListener('change', function() {
   const selectedOption = this.options[this.selectedIndex];

   if (this.value === '') {
       // Hide the section if no option is selected
       tindakanDetailsSection.style.display = 'none';
   } else {
       // Show the section and populate data
       const tindakLanjut = selectedOption.getAttribute('data-tindak-lanjut') || 'N/A';
       const createdAt = selectedOption.getAttribute('data-created-at') || 'N/A';
       const pimpinan = selectedOption.getAttribute('data-pimpinan') || 'N/A';
       const rekapJudul = selectedOption.getAttribute('data-rekap-judul') || 'N/A';
       const tindakanId = this.value;

       selectedTindakLanjutElement.textContent = tindakLanjut;
       selectedCreatedAtElement.textContent = createdAt;
       selectedPimpinanElement.textContent = pimpinan;
       selectedRekapJudulElement.textContent = rekapJudul;
       tindakanDetailLinkElement.href = `{{ url('pengawasan-tindakan/detail') }}/${tindakanId}`;

       tindakanDetailsSection.style.display = 'block';
   }
});

// Trigger change event on page load if a value is already selected (for edit mode)
if (pengawasanTindakanSelect.value !== '') {
   pengawasanTindakanSelect.dispatchEvent(new Event('change'));
}
});
</script>

@endsection
