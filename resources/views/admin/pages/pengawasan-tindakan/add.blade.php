@extends('admin/template-base')

@section('page-title', 'Add New Pengawasan Tindakan')

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

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Buat Tindakan Pengawasan Baru</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('pengawasan-tindakan.store') }}">
                            @csrf


                            {{-- USER ID PEMIMPIN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="user_id_pimpinan">Penanggung Jawab*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'user_id_pimpinan'])

                                    {{-- input form --}}
                                    <select name="user_id_pimpinan" class="form-select" id="user_id_pimpinan" required>
                                        <option value="">-- Pilih Petugas Penanggung Jawab --</option>
                                        @foreach ($petugass as $petugas)
                                            <option value="{{ $petugas->id }}">{{ $petugas->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- TINDAK LANJUT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tindak_lanjut">Arahan Tindak Lanjut*</label>
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
                                <label class="col-sm-2 col-form-label" for="status">Status Tindak Lanjut*</label>
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

                            {{-- TINDAKAN LANJUTAN SECTION --}}
                            <div class="row mb-3" id="tindakan-lanjutan-section" style="display: none;">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0">Buat Tindakan Lanjutan</h5>
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
});
</script>

@endsection
