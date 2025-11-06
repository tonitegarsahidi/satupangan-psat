@extends('admin/template-base')

@section('page-title', 'Add New Pengawasan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Tambah Pengawasan</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        {{-- Validation Errors Notification --}}
                        @if ($errors->any() || session('loginError'))
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0">
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    @endif
                                    @if(session('loginError'))
                                        <li>{{ session('loginError') }}</li>
                                    @endif
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('pengawasan.store') }}" enctype="multipart/form-data">
                            @csrf


                            {{-- LOKASI ALAMAT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lokasi_alamat">Alamat Lokasi*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'lokasi_alamat'])

                                    {{-- input form --}}
                                    <input type="text" name="lokasi_alamat" class="form-control" id="lokasi_alamat"
                                        placeholder="Enter location address" value="{{ old('lokasi_alamat') }}">
                                </div>
                            </div>

                            {{-- LOKASI PROVINSI & KOTA FIELD --}}
                            @include('components.provinsi-kota', [
                                'provinsis' => $provinsis,
                                'kotas' => $kotas ?? [],
                                'selectedProvinsiId' => old('lokasi_provinsi_id'),
                                'selectedKotaId' => old('lokasi_kota_id'),
                                'provinsiFieldName' => 'lokasi_provinsi_id',
                                'kotaFieldName' => 'lokasi_kota_id',
                                'provinsiLabel' => 'Provinsi',
                                'kotaLabel' => 'Kota',
                                'required' => true,
                                'ajaxUrl' => '/register/kota-by-provinsi/'
                            ])

                            {{-- TANGGAL MULAI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_mulai">Tanggal Mulai*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'tanggal_mulai'])

                                    {{-- input form --}}
                                    <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai"
                                        value="{{ old('tanggal_mulai') }}">
                                </div>
                            </div>

                            {{-- TANGGAL SELESAI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tanggal_selesai">Tanggal Selesai</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'tanggal_selesai'])

                                    {{-- input form --}}
                                    <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai"
                                        value="{{ old('tanggal_selesai') }}">
                                </div>
                            </div>

                            {{-- JENIS PSAT & PRODUK PSAT FIELD --}}
                            @include('components.jenis-psat-produk-psat', [
                                'jenisPsats' => $jenisPsats,
                                'produkPsats' => $produkPsats ?? [],
                                'selectedJenisId' => old('jenis_psat_id'),
                                'selectedProdukId' => old('produk_psat_id'),
                                'jenisFieldName' => 'jenis_psat_id',
                                'produkFieldName' => 'produk_psat_id',
                                'jenisLabel' => 'Jenis PSAT',
                                'produkLabel' => 'Produk PSAT',
                                'required' => true,
                                'ajaxUrl' => '/register/produk-psat-by-jenis/'
                            ])

                            {{-- HASIL PENGAWASAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="hasil_pengawasan">Hasil Pengawasan*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'hasil_pengawasan'])

                                    {{-- input form --}}
                                    <textarea name="hasil_pengawasan" class="form-control" id="hasil_pengawasan" rows="3"
                                        placeholder="Enter supervision result">{{ old('hasil_pengawasan') }}</textarea>
                                </div>
                            </div>

                            {{-- LAMPIRAN FIELDS - 2 COLUMNS LAYOUT --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="col-sm-4 col-form-label" for="lampiran1">Lampiran 1</label>
                                    <div class="col-sm-8">
                                        {{-- form validation error --}}
                                        @include('admin.components.notification.error-validation', ['field' => 'lampiran1'])

                                        {{-- input form --}}
                                        <input type="file" name="lampiran1" class="form-control" id="lampiran1"
                                            accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                        <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-sm-4 col-form-label" for="lampiran2">Lampiran 2</label>
                                    <div class="col-sm-8">
                                        {{-- form validation error --}}
                                        @include('admin.components.notification.error-validation', ['field' => 'lampiran2'])

                                        {{-- input form --}}
                                        <input type="file" name="lampiran2" class="form-control" id="lampiran2"
                                            accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                        <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="col-sm-4 col-form-label" for="lampiran3">Lampiran 3</label>
                                    <div class="col-sm-8">
                                        {{-- form validation error --}}
                                        @include('admin.components.notification.error-validation', ['field' => 'lampiran3'])

                                        {{-- input form --}}
                                        <input type="file" name="lampiran3" class="form-control" id="lampiran3"
                                            accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                        <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-sm-4 col-form-label" for="lampiran4">Lampiran 4</label>
                                    <div class="col-sm-8">
                                        {{-- form validation error --}}
                                        @include('admin.components.notification.error-validation', ['field' => 'lampiran4'])

                                        {{-- input form --}}
                                        <input type="file" name="lampiran4" class="form-control" id="lampiran4"
                                            accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                        <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="col-sm-4 col-form-label" for="lampiran5">Lampiran 5</label>
                                    <div class="col-sm-8">
                                        {{-- form validation error --}}
                                        @include('admin.components.notification.error-validation', ['field' => 'lampiran5'])

                                        {{-- input form --}}
                                        <input type="file" name="lampiran5" class="form-control" id="lampiran5"
                                            accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                        <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-sm-4 col-form-label" for="lampiran6">Lampiran 6</label>
                                    <div class="col-sm-8">
                                        {{-- form validation error --}}
                                        @include('admin.components.notification.error-validation', ['field' => 'lampiran6'])

                                        {{-- input form --}}
                                        <input type="file" name="lampiran6" class="form-control" id="lampiran6"
                                            accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                        <small class="text-muted">Accepted formats: PDF, JPEG, JPG, DOC, DOCX, PNG</small>
                                    </div>
                                </div>
                            </div>

                            {{-- STATUS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'status'])

                                    {{-- input form --}}
                                    <select name="status" class="form-select" id="status">
                                        <option value="DRAFT" {{ old('status') == 'DRAFT' ? 'selected' : '' }}>Draft</option>
                                        <option value="PROSES" {{ old('status') == 'PROSES' ? 'selected' : '' }}>In Process</option>
                                        <option value="SELESAI" {{ old('status') == 'SELESAI' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>

                            {{-- TINDAKAN REKOMENDASIKAN FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tindakan_rekomendasikan">Tindakan Rekomendasi</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'tindakan_rekomendasikan'])

                                    {{-- input form --}}
                                    <textarea name="tindakan_rekomendasikan" class="form-control" id="tindakan_rekomendasikan" rows="3"
                                        placeholder="Enter recommended action">{{ old('tindakan_rekomendasikan') }}</textarea>
                                </div>
                            </div>

                            {{-- PENGAWASAN ITEMS SECTION --}}
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Pengawasan Items</h5>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="addPengawasanItem()">
                                        <i class='tf-icons bx bx-plus me-1'></i>Tambah Item
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="pengawasanItemsContainer">
                                        <!-- Dynamic items will be added here -->
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <small class="text-muted">* Klik "Tambah Item" untuk menambahkan pengujian</small>
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

    @push('scripts')
    <script>
        let itemCounter = 0;

        // Rapid test options
        const rapidTestOptions = [
            {name: 'Rapid Test Aflatoksin', parameter: 'Deteksi Aflatoksin B1'},
            {name: 'Rapid Test Logam Berat', parameter: 'Deteksi Logam Berat (Pb, Cd, Hg)'},
            {name: 'Rapid Test Mikroba', parameter: 'Deteksi Total Mikroba (TVC)'},
            {name: 'Rapid Test Pestisida', parameter: 'Deteksi Sisa Pestisida Organofosfat'},
            {name: 'Uji Visual', parameter: 'Pemeriksaan Kondisi Fisik'},
            {name: 'Uji Bau', parameter: 'Pemeriksaan Kualitas Bau'},
            {name: 'Rapid Test Formalin', parameter: 'Deteksi Formaldehida'},
            {name: 'Rapid Test Bleaching Chlorine', parameter: 'Deteksi Sodium Hypochlorite'}
        ];

        // Lab test options
        const labTestOptions = [
            {name: 'Uji Mikroba', parameter: 'Analisis Total Mikroba (TVC)', unit: 'CFU/g', maxValue: 100000},
            {name: 'Uji Mikrotoksin', parameter: 'Analisis Aflatoksin', unit: 'µg/kg', maxValue: 20},
            {name: 'Uji Pestisida', parameter: 'Analisis Sisa Pestisida', unit: 'mg/kg', maxValue: 1},
            {name: 'Uji Logam Berat', parameter: 'Analisis Logam Berat', unit: 'mg/kg', maxValue: 0.3}
        ];

        function addPengawasanItem() {
            itemCounter++;
            const itemId = `item_${itemCounter}`;
            const container = document.getElementById('pengawasanItemsContainer');

            const itemHtml = `
                <div class="card mb-3" id="${itemId}">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Pengawasan Item #${itemCounter}</h6>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removePengawasanItem('${itemId}')">
                            <i class='tf-icons bx bx-trash'></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Pengujian</label>
                                    <select class="form-select" name="${itemId}[type]" id="${itemId}_type" onchange="toggleItemTypeFields('${itemId}')">
                                        <option value="">Pilih jenis pengujian</option>
                                        <option value="rapid">Rapid Test</option>
                                        <option value="lab">Laboratorium Test</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Sampel</label>
                                    <input type="number" class="form-control" name="${itemId}[jumlah_sampel]" id="${itemId}_jumlah_sampel" min="1" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="row" id="${itemId}_rapid_fields">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Test</label>
                                    <select class="form-select" name="${itemId}[test_name]" id="${itemId}_test_name">
                                        <option value="">Pilih test</option>
                                        @foreach ($rapidTestOptions as $option)
                                            <option value="{{ $option['name'] }}">{{ $option['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Parameter Test</label>
                                    <input type="text" class="form-control" name="${itemId}[test_parameter]" id="${itemId}_test_parameter" placeholder="Misal : Deteksi Aflatoksin B1">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Hasil Test</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="${itemId}[is_positif]" id="${itemId}_positif_yes" value="1">
                                            <label class="form-check-label" for="${itemId}_positif_yes">Positif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="${itemId}[is_positif]" id="${itemId}_positif_no" value="0" checked>
                                            <label class="form-check-label" for="${itemId}_positif_no">Negatif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control" name="${itemId}[keterangan]" id="${itemId}_keterangan" rows="2" placeholder="Masukkan keterangan (opsional)"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="${itemId}_lab_fields" style="display: none;">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Test</label>
                                    <select class="form-select" name="${itemId}[test_name]" id="${itemId}_test_name" onchange="updateLabTestDetails('${itemId}')">
                                        <option value="">Pilih test</option>
                                        @foreach ($labTestOptions as $option)
                                            <option value="{{ $option['name'] }}">{{ $option['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Parameter Test</label>
                                    <input type="text" class="form-control" name="${itemId}[test_parameter]" id="${itemId}_test_parameter" placeholder="Misal : Analisis Total Mikroba (TVC)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nilai Numerik</label>
                                    <input type="number" step="0.01" class="form-control" name="${itemId}[value_numeric]" id="${itemId}_value_numeric" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" class="form-control" name="${itemId}[value_unit]" id="${itemId}_value_unit" placeholder="mg/kg, µg/kg, dst">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Memenuhi Syarat</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="${itemId}[is_memenuhisyarat]" id="${itemId}_memenuhi_yes" value="1">
                                            <label class="form-check-label" for="${itemId}_memenuhi_yes">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="${itemId}[is_memenuhisyarat]" id="${itemId}_memenuhi_no" value="0" checked>
                                            <label class="form-check-label" for="${itemId}_memenuhi_no">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control" name="${itemId}[keterangan]" id="${itemId}_keterangan" rows="2" placeholder="Masukkan keterangan (opsional)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', itemHtml);
        }

        function removePengawasanItem(itemId) {
            const element = document.getElementById(itemId);
            if (element) {
                element.remove();
            }
        }

        function toggleItemTypeFields(itemId) {
            const typeSelect = document.getElementById(`${itemId}_type`);
            const rapidFields = document.getElementById(`${itemId}_rapid_fields`);
            const labFields = document.getElementById(`${itemId}_lab_fields`);

            if (typeSelect.value === 'rapid') {
                rapidFields.style.display = 'block';
                labFields.style.display = 'none';
            } else if (typeSelect.value === 'lab') {
                rapidFields.style.display = 'none';
                labFields.style.display = 'block';
            } else {
                rapidFields.style.display = 'none';
                labFields.style.display = 'none';
            }
        }

        function updateLabTestDetails(itemId) {
            const testSelect = document.getElementById(`${itemId}_test_name`);
            const parameterInput = document.getElementById(`${itemId}_test_parameter`);
            const unitInput = document.getElementById(`${itemId}_value_unit`);

            // Get selected test details
            const selectedOption = testSelect.options[testSelect.selectedIndex];
            const testName = selectedOption.value;

            // Set parameter based on test name
            switch(testName) {
                case 'Uji Mikroba':
                    parameterInput.value = 'Analisis Total Mikroba (TVC)';
                    unitInput.value = 'CFU/g';
                    break;
                case 'Uji Mikrotoksin':
                    parameterInput.value = 'Analisis Aflatoksin';
                    unitInput.value = 'µg/kg';
                    break;
                case 'Uji Pestisida':
                    parameterInput.value = 'Analisis Sisa Pestisida';
                    unitInput.value = 'mg/kg';
                    break;
                case 'Uji Logam Berat':
                    parameterInput.value = 'Analisis Logam Berat';
                    unitInput.value = 'mg/kg';
                    break;
                default:
                    parameterInput.value = '';
                    unitInput.value = '';
            }
        }

        // Initialize with one empty item
        document.addEventListener('DOMContentLoaded', function() {
            addPengawasanItem();
        });
    </script>
    @endpush
@endsection
