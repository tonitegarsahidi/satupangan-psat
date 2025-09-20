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
                        <h5 class="mb-0">Buat Tindakan Pengawasan Baru</h5>
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
                                            <option value="{{ $rekap['id'] }}"
                                                data-judul-rekap="{{ $rekap['judul_rekap'] }}"
                                                data-created-at="{{ $rekap['formatted_date'] }}"
                                                data-jenis-psat="{{ $rekap['jenis_psat_nama'] }}"
                                                data-produk-psat="{{ $rekap['produk_psat_nama'] }}"
                                                {{ isset($pengawasanRekapId) && $pengawasanRekapId == $rekap['id'] ? 'selected' : '' }}>
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
                                <label class="col-sm-2 col-form-label" for="user_id_petugas">Penanggung Jawab*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'user_id_petugas'])

                                    {{-- input form --}}
                                    <select name="user_id_petugas" class="form-select" id="user_id_petugas" required>
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

                            {{-- PIC TINDAKAN IDS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="pic_tindakan_ids">PIC Tindakan</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'pic_tindakan_ids'])

                                    {{-- input form --}}
                                    <select name="pic_tindakan_ids[]" class="form-select" id="pic_tindakan_ids" multiple>
                                        <option value="">-- Pilih PIC --</option>
                                        @foreach ($petugass as $petugas)
                                            <option value="{{ $petugas->id }}">{{ $petugas->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Klik Ctrl/Cmd untuk memilih beberapa PIC</small>
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
