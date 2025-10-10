@extends('admin/template-base')

@section('page-title', 'Edit Pengawasan Tindakan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- Display validation errors at the top --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="fas fa-exclamation-triangle me-2"></i> Harap perbaiki kesalahan berikut:</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Display session errors if any --}}
        @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="fas fa-exclamation-triangle me-2"></i> Terjadi Kesalahan:</h5>
                <ul class="mb-0">
                    @foreach (session('errors')->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                        <form action="{{ route('pengawasan-tindakan.update', $pengawasanTindakan->id) }}" method="POST" novalidate onsubmit="console.log('Form submitted'); console.log('Form is valid:', this.checkValidity());">
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
                                    <div class="card bg-light" style="background-color: rgba(255, 235, 125, 0.2) !important; border-width:2px">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">
                                                <i class="bx bx-info-circle me-2"></i>
                                                <strong> Rekap Pengawasan Terpilih</strong>
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td class="bg-primary text-white" style="width:300px"><strong>Judul Rekap</strong></td>
                                                        <td class="bg-white"><p id="selected-judul-rekap" class="mb-0">...</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-primary text-white" style="width:300px"><strong>Tanggal Dibuat</strong></td>
                                                        <td class="bg-white"><p id="selected-created-at" class="mb-0">...</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-primary text-white"  style="width:300px"><strong>Jenis PSAT</strong></td>
                                                        <td class="bg-white"><p id="selected-jenis-psat" class="mb-0">...</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-primary text-white"  style="width:300px"><strong>Nama Produk PSAT</strong></td>
                                                        <td class="bg-white"><p id="selected-produk-psat" class="mb-0">...</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bg-primary text-white"  style="width:300px"><strong>Detail Lengkap</strong></td>
                                                        <td class="bg-white">
                                                            <a id="rekap-detail-link" href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="bx bx-show me-1"></i>
                                                                Lihat Detail Rekap
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- USER ID PEMIMPIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="user_id_pimpinan">Penanggung Jawab*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'user_id_pimpinan',
                                    ])

                                    {{-- input form --}}
                                    <select name="user_id_pimpinan" class="form-select" id="user_id_pimpinan" required>
                                        <option value="">-- Pilih Petugas Penanggung Jawab --</option>
                                        @foreach ($petugass as $petugas)
                                            <option value="{{ $petugas->id }}"
                                                {{ old('user_id_pimpinan', isset($pengawasanTindakan->user_id_pimpinan) ? $pengawasanTindakan->user_id_pimpinan : '') == $petugas->id ? 'selected' : '' }}>
                                                {{ $petugas->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- TINDAK LANJUT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tindak_lanjut">Arahan Tindak Lanjut*</label>
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
                                                {{ (old('status') ?: (isset($pengawasanTindakan->status) ? $pengawasanTindakan->status : '')) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
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

                            {{-- TINDAKAN LANJUTAN SECTION --}}
                            <div class="row mb-3" id="tindakan-lanjutan-section" style="display: none;">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0">Edit Tindakan Lanjutan</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="tindakan-lanjutan-container">
                                                <!-- Dynamic Penugasan forms will be added here -->
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-secondary" id="add-penugasan-btn">
                                                        <i class="bx bx-plus me-1"></i>
                                                        Tambah Penugasan Tindakan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" onclick="console.log('Form submit button clicked'); console.log('Form data:', new FormData(this.closest('form')));">
                                        <i class="bx bx-save me-1"></i>Perbarui
                                    </button>
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
    console.log('Edit form loaded successfully');

    // Test form submission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submission intercepted');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);

            // Check if all required fields are filled
            const requiredFields = this.querySelectorAll('[required]');
            let missingFields = [];
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    missingFields.push(field.name || field.id);
                }
            });

            if (missingFields.length > 0) {
                console.log('Missing required fields:', missingFields);
                alert('Fields yang masih kosong: ' + missingFields.join(', '));
                e.preventDefault();
                return false;
            }

            console.log('All required fields are filled, allowing submission...');
        });
    } else {
        console.error('Form not found!');
    }
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

// TINDAKAN LANJUTAN FUNCTIONALITY
const tindakanLanjutanContainer = document.getElementById('tindakan-lanjutan-container');
const addPenugasanBtn = document.getElementById('add-penugasan-btn');
let penugasanCount = 0;

// Function to create a new penugasan form
function createPenugasanForm() {
    penugasanCount++;
    const penugasanId = `penugasan-${penugasanCount}`;

    const penugasanHtml = `
        <div class="penugasan-form mb-3" id="${penugasanId}">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Penugasan ${penugasanCount}</h6>
                    <button type="button" class="btn btn-sm btn-danger remove-penugasan" data-penugasan-id="${penugasanId}">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Petugas PIC*</label>
                            <select name="penugasan_pic_id[]" class="form-select pic-select" required>
                                <option value="">-- Pilih Petugas PIC --</option>
                                @foreach ($petugass as $petugas)
                                    <option value="{{ $petugas->id }}">{{ $petugas->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Arahan Tindak Lanjut*</label>
                            <textarea name="penugasan_arahan[]" class="form-control arahan-input" rows="3" required
                                placeholder="Masukkan arahan tindak lanjut"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    tindakanLanjutanContainer.insertAdjacentHTML('beforeend', penugasanHtml);

    // Add event listener to remove button
    const removeBtn = document.querySelector(`#${penugasanId} .remove-penugasan`);
    removeBtn.addEventListener('click', function() {
        document.getElementById(`${penugasanId}`).remove();
    });
}

// Add event listener to add button
addPenugasanBtn.addEventListener('click', function() {
    createPenugasanForm();
});

// Add initial penugasan form
createPenugasanForm();

// TINDAKAN LANJUTAN VISIBILITY CONTROL
const statusSelect = document.getElementById('status');
const tindakanLanjutanSection = document.getElementById('tindakan-lanjutan-section');
const butuhTindakanLanjutanValue = '{{ config('pengawasan.pengawasan_tindakan_statuses.BUTUH_TINDAKAN_LANJUTAN') }}';

// Function to check if section should be visible
function checkTindakanLanjutanVisibility() {
    const selectedValue = statusSelect.value;
    if (selectedValue === 'BUTUH_TINDAKAN_LANJUTAN') {
        tindakanLanjutanSection.style.display = 'block';
    } else {
        tindakanLanjutanSection.style.display = 'none';
    }
}

// Add event listener to status select
statusSelect.addEventListener('change', checkTindakanLanjutanVisibility);

// Check visibility on page load
checkTindakanLanjutanVisibility();
</script>

@endsection
