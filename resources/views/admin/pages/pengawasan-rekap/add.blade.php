@extends('admin/template-base')

@section('page-title', 'Add New Pengawasan Rekap')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Tambah Pengawasan Rekap</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">



                            {{-- MEMILIH DATA PENGAWASAN SECTION --}}
                            <div class="card mb-4" id="pengawasan-selection-section" style="background-color: #fffef0; border: 1px solid #ffeaa7;">
                                <div class="card-header" style="background-color: #fffaf0;">
                                    <h5 class="mb-0">Memilih Data Pengawasan</h5>
                                    <p class="text-muted mb-0 small">Pilih data pengawasan yang akan digunakan untuk rekapitulasi</p>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Filter Data Pengawasan</label>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="pengawasan_keyword_filter" placeholder="Kata kunci pencarian...">
                                                            <button class="btn btn-primary" type="button" id="search-pengawasan">
                                                                <i class="bx bx-search me-1"></i> Cari
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="input-group">
                                                            <label class="input-group-text" for="per_page_select">Per Halaman</label>
                                                            <select class="form-select" id="per_page_select">
                                                                <option value="10" selected>10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover" id="pengawasan-table">
                                                    <thead>
                                                        <tr>
                                                            <th width="30">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="select-all-pengawasan">
                                                                    <label class="form-check-label" for="select-all-pengawasan"></label>
                                                                </div>
                                                            </th>
                                                            <th>
                                                                <a href="#" class="text-decoration-none sort-link" data-field="jenis_psat.nama_jenis_pangan_segar">
                                                                    Jenis PSAT
                                                                    <span class="sort-icon" id="sort-jenis-psat" style="display:none;">
                                                                        <i class="bx bx-sort-up"></i>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a href="#" class="text-decoration-none sort-link" data-field="produk_psat.nama_bahan_pangan_segar">
                                                                    Produk PSAT
                                                                    <span class="sort-icon" id="sort-produk-psat" style="display:none;">
                                                                        <i class="bx bx-sort-up"></i>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a href="#" class="text-decoration-none sort-link" data-field="lokasi_provinsi.nama_provinsi">
                                                                    Provinsi
                                                                    <span class="sort-icon" id="sort-provinsi" style="display:none;">
                                                                        <i class="bx bx-sort-up"></i>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a href="#" class="text-decoration-none sort-link" data-field="lokasi_kota.nama_kota">
                                                                    Kota
                                                                    <span class="sort-icon" id="sort-kota" style="display:none;">
                                                                        <i class="bx bx-sort-up"></i>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a href="#" class="text-decoration-none sort-link" data-field="tanggal_mulai">
                                                                    Tanggal Mulai
                                                                    <span class="sort-icon" id="sort-tanggal-mulai" style="display:none;">
                                                                        <i class="bx bx-sort-up"></i>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a href="#" class="text-decoration-none sort-link" data-field="status">
                                                                    Tanggal Selesai
                                                                    <span class="sort-icon" id="sort-status" style="display:none;">
                                                                        <i class="bx bx-sort-up"></i>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a href="#" class="text-decoration-none sort-link" data-field="status">
                                                                    Status
                                                                    <span class="sort-icon" id="sort-status" style="display:none;">
                                                                        <i class="bx bx-sort-up"></i>
                                                                    </span>
                                                                </a>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="pengawasan-tbody">
                                                        <!-- Dynamic content will be loaded here -->
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Pagination Info and Controls -->
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div class="pagination-info">
                                                    <small class="text-muted">
                                                        Menampilkan <span id="pagination-from">0</span> sampai <span id="pagination-to">0</span>
                                                        dari <span id="pagination-total">0</span> data
                                                    </small>
                                                </div>
                                                <nav aria-label="Pengawasan pagination">
                                                    <ul class="pagination pagination-sm mb-0" id="pengawasan-pagination">
                                                        <!-- Pagination buttons will be generated here -->
                                                    </ul>
                                                </nav>
                                            </div>

                                            <div class="mt-3">
                                                <button type="button" class="btn btn-primary"  id="add-selected-pengawasan" disabled>
                                                    <i class="bx bx-plus me-1"></i> Tambahkan (<span id="selected-count">0</span>)
                                                </button>
                                                <div class="mt-2">
                                                    <div id="selection-feedback" class="text-muted small" style="display:none;">
                                                        <!-- Success/error messages will appear here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('pengawasan-rekap.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- DATA PENGAWASAN YANG DIPILIH SECTION --}}
                            <div class="card mb-4" id="selected-pengawasan-section" style="background-color: #f8f9fa; border: 1px solid #dee2e6; display: none;">
                                <div class="card-header" style="background-color: #e9ecef;">
                                    <h5 class="mb-0">Data Pengawasan Yang Dipilih</h5>
                                    <small class="text-muted">Data pengawasan yang telah dipilih untuk dikumpulkan dalam rekapitulasi ini</small>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm" id="selected-pengawasan-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Jenis PSAT</th>
                                                    <th>Produk PSAT</th>
                                                    <th>Provinsi</th>
                                                    <th>Kota</th>
                                                    <th>Tanggal Mulai</th>
                                                    <th>Tanggal Selesai</th>
                                                    <th>Status</th>
                                                    <th width="50">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="selected-pengawasan-tbody">
                                                <!-- Selected pengawasan data will be populated here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="selected-pengawasan-feedback" class="mt-2" style="display:none;">
                                        <!-- Feedback messages will appear here -->
                                    </div>
                                </div>
                            </div>

                            {{-- taruh section data terpilih ada disini, make sure mereka masuk ke sebuah hidden form yang juga akan ikut terkirim --}}


                            {{-- PROVINSI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="provinsi_id">Provinsi</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'provinsi_id'])

                                    {{-- input form --}}
                                    @if ($provinsis->count() == 1)
                                        {{-- Single province: show as read-only but still submit --}}
                                        <input type="text" class="form-control" value="{{ $provinsis->first()->nama_provinsi }}" readonly>
                                        <input type="hidden" name="provinsi_id" value="{{ $provinsis->first()->id }}">
                                    @else
                                        {{-- Multiple provinces: show select --}}
                                        <select name="provinsi_id" class="form-select" id="provinsi_id">
                                            <option value="">-- Select Provinsi --</option>
                                            @foreach ($provinsis ?? [] as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->nama_provinsi }}</option>
                                            @endforeach
                                        </select>
                                    @endif
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
                                'jenisLabel' => 'Jenis PSAT*',
                                'produkLabel' => 'Produk PSAT*',
                                'required' => true,
                                'ajaxUrl' => '/register/produk-psat-by-jenis/'
                            ])

                            {{-- JUDUL REKAP FIELD --}}
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label" for="judul_rekap">Judul Rekap</label>
                                                            <div class="col-sm-10">
                                                                {{-- form validation error --}}
                                                                @include('admin.components.notification.error-validation', ['field' => 'judul_rekap'])

                                                                {{-- input form --}}
                                                                <input type="text" class="form-control" id="judul_rekap" name="judul_rekap"
                                                                    placeholder="Enter recap title" maxlength="200" value="{{ old('judul_rekap') }}">
                                                                <small class="text-muted">Maksimal 200 karakter</small>
                                                            </div>
                                                        </div>

                            {{-- HASIL REKAP FIELD --}}
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label" for="hasil_rekap">Hasil Rekap*</label>
                                                            <div class="col-sm-10">
                                                                {{-- form validation error --}}
                                                                @include('admin.components.notification.error-validation', ['field' => 'hasil_rekap'])

                                                                {{-- input form --}}
                                                                <textarea name="hasil_rekap" class="form-control" id="hasil_rekap" rows="3"
                                                                    placeholder="Enter recap result" required>{{ old('hasil_rekap') }}</textarea>
                                                            </div>
                                                        </div>

                            {{-- LAMPIRAN FIELDS --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Lampiran</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran1">Lampiran 1</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran1'])
                                            <input type="file" class="form-control" id="lampiran1" name="lampiran1"
                                                accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                            <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 2MB</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran2">Lampiran 2</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran2'])
                                            <input type="file" class="form-control" id="lampiran2" name="lampiran2"
                                                accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                            <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 100MB</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran3">Lampiran 3</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran3'])
                                            <input type="file" class="form-control" id="lampiran3" name="lampiran3"
                                                accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                            <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 100MB</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran4">Lampiran 4</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran4'])
                                            <input type="file" class="form-control" id="lampiran4" name="lampiran4"
                                                accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                            <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 100MB</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran5">Lampiran 5</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran5'])
                                            <input type="file" class="form-control" id="lampiran5" name="lampiran5"
                                                accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                            <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 100MB</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran6">Lampiran 6</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran6'])
                                            <input type="file" class="form-control" id="lampiran6" name="lampiran6"
                                                accept=".pdf,.jpeg,.jpg,.doc,.docx,.png">
                                            <small class="text-muted">Format: PDF, JPEG, JPG, DOC, DOCX, PNG, Maks: 100MB</small>
                                        </div>
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
                                    <select name="status" class="form-select" id="status" required>
                                        <option value="DRAFT" {{ old('status') == 'DRAFT' ? 'selected' : '' }}>Draft</option>
                                        <option value="PROSES" {{ old('status') == 'PROSES' ? 'selected' : '' }}>In Process</option>
                                        <option value="SELESAI" {{ old('status') == 'SELESAI' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" id="submit-btn">Kirim</button>
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
        // Global variables for managing state
        let currentPage = 1;
        let currentSortField = 'tanggal_mulai';
        let currentSortOrder = 'desc';
        let currentKeyword = '';
        let currentPerPage = 10;
        let allPengawasanData = []; // Store all pengawasan data for selected table population

        $(document).ready(function() {

            // Load initial data
            loadPengawasanData();

            // Handle select all checkbox
            $(document).on('change', '#select-all-pengawasan', function() {
                $('.pengawasan-checkbox').prop('checked', $(this).prop('checked'));
                updateSelectedCount();
            });

            // Handle individual checkbox changes
            $(document).on('change', '.pengawasan-checkbox', function() {
                updateSelectedCount();

                // Update select all checkbox state
                var totalCheckboxes = $('.pengawasan-checkbox').length;
                var checkedCheckboxes = $('.pengawasan-checkbox:checked').length;

                $('#select-all-pengawasan').prop('checked', totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes);
            });

            // Handle keyword search
            $('#search-pengawasan').on('click', function() {
                currentKeyword = $('#pengawasan_keyword_filter').val();
                currentPage = 1; // Reset to first page
                loadPengawasanData();
            });

            // Handle per page change
            $('#per_page_select').on('change', function() {
                currentPerPage = $(this).val();
                currentPage = 1; // Reset to first page
                loadPengawasanData();
            });

            // Handle sort links
            $(document).on('click', '.sort-link', function(e) {
                e.preventDefault();
                var field = $(this).data('field');

                // Toggle sort order if same field, otherwise set to asc
                if (currentSortField === field) {
                    currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSortField = field;
                    currentSortOrder = 'asc';
                }

                updateSortIcons();
                loadPengawasanData();
            });

            // Handle pagination
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                currentPage = $(this).data('page');
                loadPengawasanData();
            });

            // Handle add selected button
            $(document).on('click', '#add-selected-pengawasan', function() {
                var selectedIds = [];
                var selectedData = [];
                $('.pengawasan-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                console.log('allPengawasanData:', allPengawasanData);
                console.log('selectedIds:', selectedIds);

                if (selectedIds.length === 0) {
                    showFeedback('danger', 'Silakan pilih minimal satu data pengawasan');
                    return;
                }

                // Confirm action
                if (!confirm('Apakah Anda yakin ingin menambahkan ' + selectedIds.length + ' data pengawasan ke dalam rekap?')) {
                    return;
                }

                // Add selected IDs to hidden inputs (clear existing first)
                $('input[name="pengawasan_ids[]"]').remove();
                selectedIds.forEach(function(id) {
                    var hiddenInput = $('<input>').attr({
                        type: 'hidden',
                        name: 'pengawasan_ids[]',
                        value: id
                    });
                    $('form').append(hiddenInput);
                    // Simpan data terpilih ke variable
                    var data = allPengawasanData.find(function(item) { return String(item.id) === String(id); });
                    if (data) {
                        selectedData.push(data);
                    } else {
                        console.warn('Data not found for id:', id);
                    }
                });

                window.selectedPengawasanData = selectedData; // simpan global
                console.log('Selected Data:', selectedData);

                // Hide the selection section
                $('#pengawasan-selection-section').hide();

                // Show the selected data section and populate it
                $('#selected-pengawasan-section').show();
                populateSelectedPengawasanTable(selectedData);

                // Show success feedback
                showFeedback('success', selectedIds.length + ' data pengawasan berhasil ditambahkan ke dalam rekap');

                // Clear selections
                $('.pengawasan-checkbox').prop('checked', false);
                $('#select-all-pengawasan').prop('checked', false);
                updateSelectedCount();

                // Jangan reload data agar allPengawasanData tetap ada
            });

            // Clear keyword on Enter in search field
            $('#pengawasan_keyword_filter').on('keypress', function(e) {
                if (e.which == 13) {
                    $('#search-pengawasan').click();
                }
            });
        });

        // Load pengawasan data via AJAX
        function loadPengawasanData() {
            // Show loading spinner
            $('#pengawasan-tbody').html('<tr><td colspan="9" class="text-center py-4"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><br><small class="text-muted mt-2">Memuat data pengawasan...</small></td></tr>');

            // Make AJAX request
            $.ajax({
                url: '{{ route("pengawasan-rekap.getPengawasanData") }}',
                type: 'GET',
                data: {
                    keyword: currentKeyword,
                    sort_field: currentSortField,
                    sort_order: currentSortOrder,
                    page: currentPage,
                    per_page: currentPerPage
                },
                success: function(response) {
                    if (response.success) {
                        allPengawasanData = response.data; // Simpan data AJAX ke variable global
                        console.log('AJAX response.data:', response.data);
                        renderPengawasanTable(response.data);
                        renderPagination(response.pagination);
                    } else {
                        $('#pengawasan-tbody').html('<tr><td colspan="9" class="text-center text-danger">Gagal memuat data pengawasan: ' + (response.message || 'Unknown error') + '</td></tr>');
                        renderEmptyPagination();
                    }
                },
                error: function(xhr, status, error) {
                    $('#pengawasan-tbody').html('<tr><td colspan="9" class="text-center text-danger">Terjadi kesalahan saat memuat data pengawasan</td></tr>');
                    renderEmptyPagination();
                    console.error('AJAX Error:', error);
                }
            });
        }

        // Render table rows
        function renderPengawasanTable(data) {
            if (!data.length) {
                $('#pengawasan-tbody').html('<tr><td colspan="7" class="text-center">Tidak ada data pengawasan yang ditemukan</td></tr>');
                return;
            }

            var tbody = '';
            $.each(data, function(index, pengawasan) {
                tbody += '<tr>';
                tbody += '<td><div class="form-check"><input class="form-check-input pengawasan-checkbox" type="checkbox" name="pengawasan_ids[]" value="' + pengawasan.id + '" id="pengawasan-' + pengawasan.id + '"><label class="form-check-label" for="pengawasan-' + pengawasan.id + '"></label></div></td>';
                tbody += '<td>' + (pengawasan.jenis_psat ? pengawasan.jenis_psat.nama_jenis_pangan_segar : '-') + '</td>';
                tbody += '<td>' + (pengawasan.produk_psat ? pengawasan.produk_psat.nama_bahan_pangan_segar : '-') + '</td>';
                tbody += '<td>' + (pengawasan.lokasi_provinsi ? pengawasan.lokasi_provinsi.nama_provinsi : '-') + '</td>';
                tbody += '<td>' + (pengawasan.lokasi_kota ? pengawasan.lokasi_kota.nama_kota : '-') + '</td>';
                tbody += '<td>' + (pengawasan.tanggal_mulai ? new Date(pengawasan.tanggal_mulai).toLocaleDateString('id-ID') : '-') + '</td>';
                tbody += '<td>' + (pengawasan.tanggal_selesai ? new Date(pengawasan.tanggal_selesai).toLocaleDateString('id-ID') : '-') + '</td>';
                tbody += '<td><span class="badge bg-' + (pengawasan.status === 'SELESAI' ? 'success' : (pengawasan.status === 'PROSES' ? 'warning' : 'secondary')) + '">' + pengawasan.status + '</span></td>';
                tbody += '</tr>';
            });

            $('#pengawasan-tbody').html(tbody);
            $('#select-all-pengawasan').prop('checked', false);

            // Re-attach event listeners to new checkboxes
            $('.pengawasan-checkbox').off('change').on('change', function() {
                updateSelectedCount();

                var totalCheckboxes = $('.pengawasan-checkbox').length;
                var checkedCheckboxes = $('.pengawasan-checkbox:checked').length;

                $('#select-all-pengawasan').prop('checked', totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes);
            });

            // Auto-select first 10 items if they exist and no items are selected
            var totalCheckboxes = $('.pengawasan-checkbox').length;
            var checkedCheckboxes = $('.pengawasan-checkbox:checked').length;

            if (totalCheckboxes > 0 && checkedCheckboxes === 0) {
                $('.pengawasan-checkbox').slice(0, Math.min(10, totalCheckboxes)).prop('checked', true);
                updateSelectedCount();
            }
        }

        // Render pagination
        function renderPagination(pagination) {
            if (!pagination || pagination.total == 0) {
                renderEmptyPagination();
                return;
            }

            var paginationHtml = '';

            // Previous button
            if (pagination.current_page > 1) {
                paginationHtml += '<li class="page-item"><a class="page-link pagination-link" href="#" data-page="' + (pagination.current_page - 1) + '">Previous</a></li>';
            } else {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
            }

            // Page numbers
            var startPage = Math.max(1, pagination.current_page - 2);
            var endPage = Math.min(pagination.last_page, pagination.current_page + 2);

            if (startPage > 1) {
                paginationHtml += '<li class="page-item"><a class="page-link pagination-link" href="#" data-page="1">1</a></li>';
                if (startPage > 2) {
                    paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
            }

            for (var i = startPage; i <= endPage; i++) {
                if (i == pagination.current_page) {
                    paginationHtml += '<li class="page-item active"><span class="page-link">' + i + '</span></li>';
                } else {
                    paginationHtml += '<li class="page-item"><a class="page-link pagination-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                }
            }

            if (endPage < pagination.last_page) {
                if (endPage < pagination.last_page - 1) {
                    paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
                paginationHtml += '<li class="page-item"><a class="page-link pagination-link" href="#" data-page="' + pagination.last_page + '">' + pagination.last_page + '</a></li>';
            }

            // Next button
            if (pagination.current_page < pagination.last_page) {
                paginationHtml += '<li class="page-item"><a class="page-link pagination-link" href="#" data-page="' + (pagination.current_page + 1) + '">Next</a></li>';
            } else {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">Next</span></li>';
            }

            $('#pengawasan-pagination').html(paginationHtml);

            // Update pagination info
            $('#pagination-from').text(pagination.from || 0);
            $('#pagination-to').text(pagination.to || 0);
            $('#pagination-total').text(pagination.total);
        }

        // Render empty pagination
        function renderEmptyPagination() {
            $('#pengawasan-pagination').html('<li class="page-item disabled"><span class="page-link">Tidak ada data</span></li>');
            $('#pagination-from').text('0');
            $('#pagination-to').text('0');
            $('#pagination-total').text('0');
        }

        // Update sort icons
        function updateSortIcons() {
            $('.sort-icon').hide();
            var sortIconId = 'sort-' + currentSortField.replace('.', '-').replace('_', '-');
            $('#' + sortIconId).show();
            $('#' + sortIconId + ' i').attr('class', currentSortOrder === 'asc' ? 'bx bx-sort-up' : 'bx bx-sort-down');
        }

        // Update selected count
        function updateSelectedCount() {
            var count = $('.pengawasan-checkbox:checked').length;
            $('#selected-count').text(count);
            $('#add-selected-pengawasan').prop('disabled', count === 0);

            // Update button text based on selection
            if (count > 0) {
                $('#add-selected-pengawasan').html('<i class="bx bx-plus me-1"></i> Tambahkan (' + count + ')');
            } else {
                $('#add-selected-pengawasan').html('<i class="bx bx-plus me-1"></i> Tambahkan (0)');
            }
        }

        // Show feedback messages
        function showFeedback(type, message) {
            var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            var feedbackHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>';

            $('#selection-feedback').html(feedbackHtml).show();

            // Auto-hide after 5 seconds for success messages
            if (type === 'success') {
                setTimeout(function() {
                    $('#selection-feedback .alert').fadeOut();
                }, 5000);
            }
        }

        // Populate selected pengawasan table
        function populateSelectedPengawasanTable(selectedIds) {
            console.log('Populating selected pengawasan table with data:', selectedIds);

            if (!selectedIds.length) {
                $('#selected-pengawasan-tbody').html('<tr><td colspan="8" class="text-center">Tidak ada data pengawasan yang dipilih</td></tr>');
                return;
            }

            var tbody = '';
            selectedIds.forEach(function(data) {
                tbody += '<tr>';
                tbody += '<td>' + (data.jenis_psat && data.jenis_psat.nama_jenis_pangan_segar ? data.jenis_psat.nama_jenis_pangan_segar : '-') + '</td>';
                tbody += '<td>' + (data.produk_psat && data.produk_psat.nama_bahan_pangan_segar ? data.produk_psat.nama_bahan_pangan_segar : '-') + '</td>';
                tbody += '<td>' + (data.lokasi_provinsi && data.lokasi_provinsi.nama_provinsi ? data.lokasi_provinsi.nama_provinsi : '-') + '</td>';
                tbody += '<td>' + (data.lokasi_kota && data.lokasi_kota.nama_kota ? data.lokasi_kota.nama_kota : '-') + '</td>';
                tbody += '<td>' + (data.tanggal_mulai ? new Date(data.tanggal_mulai).toLocaleDateString('id-ID') : '-') + '</td>';
                tbody += '<td>' + (data.tanggal_selesai ? new Date(data.tanggal_selesai).toLocaleDateString('id-ID') : '-') + '</td>';
                tbody += '<td><span class="badge bg-' + (data.status === 'SELESAI' ? 'success' : (data.status === 'PROSES' ? 'warning' : 'secondary')) + '">' + data.status + '</span></td>';
                tbody += '<td><button type="button" class="btn btn-sm btn-danger" onclick="removePengawasan(' + data.id + ')"><i class="bx bx-trash"></i></button></td>';
                tbody += '</tr>';
            });

            $('#selected-pengawasan-tbody').html(tbody);
        }

        // Remove pengawasan from selection
        function removePengawasan(id) {
            console.log('Removing pengawasan ID:', id);

            // Remove from hidden inputs
            $('input[name="pengawasan_ids[]"][value="' + id + '"]').remove();

            // Remove from table
            $('#selected-pengawasan-tbody').find('tr').each(function() {
                // Assuming we can identify the row by some means
                // For now, remove all and repopulate
            });

            // If no more selected, hide section and show original
            var remainingInput = $('input[name="pengawasan_ids[]"]').first();
            if (!remainingInput.length) {
                $('#selected-pengawasan-section').hide();
                $('#pengawasan-selection-section').show();
                window.location.reload();
            }

            showSelectedFeedback('success', 'Data pengawasan berhasil dihapus dari rekap');
        }

        // Show feedback in selected section
        function showSelectedFeedback(type, message) {
            var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            var feedbackHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>';

            $('#selected-pengawasan-feedback').html(feedbackHtml).show();

            if (type === 'success') {
                setTimeout(function() {
                    $('#selected-pengawasan-feedback .alert').fadeOut();
                }, 5000);
            }
        }
    </script>
    @endpush
@endsection
