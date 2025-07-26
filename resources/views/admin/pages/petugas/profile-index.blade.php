@extends('admin/template-base')

@section('page-title', 'Data Petugas')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="p-2 bd-highlight">
                        <h3 class="card-header">Data Petugas</h3>
                    </div>
                    @if (isset($alerts))
                        @include('admin.components.notification.general', $alerts)
                    @endif
                    <!-- Work Information -->
                    <div class="card-body">
                        <form id="formPetugasSettings" method="POST" action="{{ route('petugas.profile.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <h5 class="mb-3">Informasi Kedinasan</h5>
                            <div class="row">
                                <!-- Unit Kerja -->
                                <div class="mb-3 col-md-6">
                                    <label for="unit_kerja" class="form-label">Unit Kerja <span class="text-danger">*</span></label>
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'unit_kerja',
                                    ])
                                    <input type="text" class="form-control" id="unit_kerja" name="unit_kerja"
                                        value="{{ old('unit_kerja', $petugas->unit_kerja ?? '') }}"
                                        placeholder="Masukkan unit kerja" required />
                                </div>

                                <!-- Jabatan -->
                                <div class="mb-3 col-md-6">
                                    <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'jabatan',
                                    ])
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                        value="{{ old('jabatan', $petugas->jabatan ?? '') }}"
                                        placeholder="Masukkan jabatan" required />
                                </div>

                                <!-- Tipe Petugas -->
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Tipe Petugas <span class="text-danger">*</span></label>
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'is_kantor_pusat',
                                    ])
                                    <div>
                                        <input type="radio" id="pusat" name="is_kantor_pusat" value="1" 
                                            {{ old('is_kantor_pusat', $petugas->is_kantor_pusat ?? '1') == '1' ? 'checked' : '' }}>
                                        <label for="pusat" class="me-3">Petugas Pusat</label>
                                        <input type="radio" id="daerah" name="is_kantor_pusat" value="0" 
                                            {{ old('is_kantor_pusat', $petugas->is_kantor_pusat ?? '') == '0' ? 'checked' : '' }}>
                                        <label for="daerah">Petugas Daerah</label>
                                    </div>
                                </div>

                                <!-- Penempatan -->
                                <div class="mb-3 col-md-6" id="penempatan-group" style="display: none;">
                                    <label for="penempatan" class="form-label">Penempatan (Provinsi)</label>
                                    @include('admin.components.notification.error-validation', [
                                        'field' => 'penempatan',
                                    ])
                                    <select id="penempatan" name="penempatan" class="select2 form-select">
                                        <option value="">Pilih Provinsi Penempatan</option>
                                        @foreach ($provinsis as $provinsi)
                                            <option value="{{ $provinsi->id }}"
                                                {{ old('penempatan', $petugas->penempatan ?? '') == $provinsi->id ? 'selected' : '' }}>
                                                {{ $provinsi->nama_provinsi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Save and Cancel Buttons -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                                <button type="reset" class="btn btn-outline-secondary">Batal</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Work Information -->
                </div>
            </div>
        </div>

    </div>
@endsection


@section('footer-code')
<script>
    // Toggle penempatan field
    function togglePenempatan() {
        var pusat = document.getElementById('pusat');
        var penempatanGroup = document.getElementById('penempatan-group');
        if (pusat.checked) {
            penempatanGroup.style.display = 'none';
        } else {
            penempatanGroup.style.display = 'block';
        }
    }
    document.getElementById('pusat').addEventListener('change', togglePenempatan);
    document.getElementById('daerah').addEventListener('change', togglePenempatan);
    // Initial state
    togglePenempatan();
</script>

@endsection