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

                        <form method="POST" action="{{ route('pengawasan-rekap.store') }}">
                            @csrf

                            {{-- PROVINSI FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="provinsi_id">Provinsi</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'provinsi_id'])

                                    {{-- input form --}}
                                    <select name="provinsi_id" class="form-select" id="provinsi_id">
                                        <option value="">-- Select Provinsi --</option>
                                        @foreach ($provinsis ?? [] as $provinsi)
                                            <option value="{{ $provinsi->id }}">{{ $provinsi->nama_provinsi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- MEMILIH DATA PENGAWASAN SECTION --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Memilih Data Pengawasan</h5>
                                    <p class="text-muted mb-0 small">Pilih data pengawasan yang akan digunakan untuk rekapitulasi</p>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Filter Data Pengawasan</label>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label small">Berdasarkan Initiator</label>
                                                        <select class="form-select pengawasan-filter" id="pengawasan_initiator_filter">
                                                            <option value="">Semua Initiator</option>
                                                            @foreach ($initiators ?? [] as $initiator)
                                                                <option value="{{ $initiator->id }}">{{ $initiator->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label small">Berdasarkan Jenis PSAT</label>
                                                        <select class="form-select pengawasan-filter" id="pengawasan_jenis_filter">
                                                            <option value="">Semua Jenis PSAT</option>
                                                            @foreach ($jenisPsats ?? [] as $jenis)
                                                                <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis_pangan_segar }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label small">Berdasarkan Produk PSAT</label>
                                                        <select class="form-select pengawasan-filter" id="pengawasan_produk_filter">
                                                            <option value="">Semua Produk PSAT</option>
                                                            @foreach ($produkPsats ?? [] as $produk)
                                                                <option value="{{ $produk->id }}">{{ $produk->nama_bahan_pangan_segar }}</option>
                                                            @endforeach
                                                        </select>
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
                                                            <th>Initiator</th>
                                                            <th>Jenis PSAT</th>
                                                            <th>Produk PSAT</th>
                                                            <th>Provinsi</th>
                                                            <th>Kota</th>
                                                            <th>Tanggal Mulai</th>
                                                            <th>Tanggal Selesai</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($pengawasans ?? [] as $pengawasan)
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input pengawasan-checkbox" type="checkbox"
                                                                               name="pengawasan_ids[]" value="{{ $pengawasan->id }}" id="pengawasan-{{ $pengawasan->id }}">
                                                                        <label class="form-check-label" for="pengawasan-{{ $pengawasan->id }}"></label>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $pengawasan->initiator ? $pengawasan->initiator->name : '-' }}</td>
                                                                <td>{{ $pengawasan->jenisPsat ? $pengawasan->jenisPsat->nama_jenis_pangan_segar : '-' }}</td>
                                                                <td>{{ $pengawasan->produkPsat ? $pengawasan->produkPsat->nama_bahan_pangan_segar : '-' }}</td>
                                                                <td>{{ $pengawasan->lokasiProvinsi ? $pengawasan->lokasiProvinsi->nama_provinsi : '-' }}</td>
                                                                <td>{{ $pengawasan->lokasiKota ? $pengawasan->lokasiKota->nama_kota : '-' }}</td>
                                                                <>{{ $pengawasan->tanggal_mulai ? \Carbon\Carbon::parse($pengawasan->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                                                                <td>{{ $pengawasan->tanggal_selesai ? \Carbon\Carbon::parse($pengawasan->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $pengawasan->status == 'SELESAI' ? 'success' : ($pengawasan->status == 'PROSES' ? 'warning' : 'secondary') }}">
                                                                        {{ $pengawasan->status }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center">Tidak ada data pengawasan yang ditemukan</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="mt-3">
                                                <button type="button" class="btn btn-primary" id="add-selected-pengawasan">
                                                    <i class="bx bx-plus me-1"></i> Tambahkan
                                                </button>
                                                <span class="text-muted ms-2">
                                                    <span id="selected-count">0</span> data terpilih
                                                </span>
                                            </div>
                                        </div>
                                    </div>
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
                                            <input type="text" class="form-control" id="lampiran1" name="lampiran1"
                                                placeholder="Enter attachment 1 path" value="{{ old('lampiran1') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran2">Lampiran 2</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran2'])
                                            <input type="text" class="form-control" id="lampiran2" name="lampiran2"
                                                placeholder="Enter attachment 2 path" value="{{ old('lampiran2') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran3">Lampiran 3</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran3'])
                                            <input type="text" class="form-control" id="lampiran3" name="lampiran3"
                                                placeholder="Enter attachment 3 path" value="{{ old('lampiran3') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran4">Lampiran 4</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran4'])
                                            <input type="text" class="form-control" id="lampiran4" name="lampiran4"
                                                placeholder="Enter attachment 4 path" value="{{ old('lampiran4') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran5">Lampiran 5</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran5'])
                                            <input type="text" class="form-control" id="lampiran5" name="lampiran5"
                                                placeholder="Enter attachment 5 path" value="{{ old('lampiran5') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lampiran6">Lampiran 6</label>
                                            @include('admin.components.notification.error-validation', ['field' => 'lampiran6'])
                                            <input type="text" class="form-control" id="lampiran6" name="lampiran6"
                                                placeholder="Enter attachment 6 path" value="{{ old('lampiran6') }}">
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
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @push('js')
    <script>
        $(document).ready(function() {
            // Handle select all checkbox
            $('#select-all-pengawasan').on('change', function() {
                $('.pengawasan-checkbox').prop('checked', $(this).prop('checked'));
                updateSelectedCount();
            });

            // Handle individual checkbox changes
            $('.pengawasan-checkbox').on('change', function() {
                updateSelectedCount();

                // Update select all checkbox state
                var totalCheckboxes = $('.pengawasan-checkbox').length;
                var checkedCheckboxes = $('.pengawasan-checkbox:checked').length;

                $('#select-all-pengawasan').prop('checked', totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes);
            });

            // Handle filter changes
            $('.pengawasan-filter').on('change', function() {
                applyFilters();
            });

            // Handle add selected button
            $('#add-selected-pengawasan').on('click', function() {
                var selectedIds = [];
                $('.pengawasan-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    alert('Silakan pilih minimal satu data pengawasan');
                    return;
                }

                // Add selected IDs to hidden input
                var hiddenInput = $('<input>').attr({
                    type: 'hidden',
                    name: 'pengawasan_ids[]',
                    value: selectedIds.join(',')
                });

                $('form').append(hiddenInput);

                // Show notification
                alert(selectedIds.length + ' data pengawasan berhasil ditambahkan');

                // Clear selections
                $('.pengawasan-checkbox').prop('checked', false);
                $('#select-all-pengawasan').prop('checked', false);
                updateSelectedCount();
            });

            // Update selected count
            function updateSelectedCount() {
                var count = $('.pengawasan-checkbox:checked').length;
                $('#selected-count').text(count);
            }

            // Apply filters
            function applyFilters() {
                var jenisFilter = $('#pengawasan_jenis_filter').val();
                var produkFilter = $('#pengawasan_produk_filter').val();
                var initiatorFilter = $('#pengawasan_initiator_filter').val();

                // Show loading spinner
                $('#pengawasan-table tbody').html('<tr><td colspan="9" class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>');

                // Make AJAX request to get filtered data
                $.ajax({
                    url: '{{ route("pengawasan-rekap.getPengawasanData") }}',
                    type: 'GET',
                    data: {
                        jenis_psat_id: jenisFilter,
                        produk_psat_id: produkFilter,
                        initiator_id: initiatorFilter
                    },
                    success: function(response) {
                        if (response.success) {
                            var tbody = '';
                            $.each(response.data, function(index, pengawasan) {
                                tbody += '<tr>';
                                tbody += '<td><div class="form-check"><input class="form-check-input pengawasan-checkbox" type="checkbox" name="pengawasan_ids[]" value="' + pengawasan.id + '" id="pengawasan-' + pengawasan.id + '"><label class="form-check-label" for="pengawasan-' + pengawasan.id + '"></label></div></td>';
                                tbody += '<td>' + (pengawasan.initiator ? pengawasan.initiator.name : '-') + '</td>';
                                tbody += '<td>' + (pengawasan.jenisPsat ? pengawasan.jenisPsat.nama_jenis_pangan_segar : '-') + '</td>';
                                tbody += '<td>' + (pengawasan.produkPsat ? pengawasan.produkPsat.nama_bahan_pangan_segar : '-') + '</td>';
                                tbody += '<td>' + (pengawasan.lokasiProvinsi ? pengawasan.lokasiProvinsi.nama_provinsi : '-') + '</td>';
                                tbody += '<td>' + (pengawasan.lokasiKota ? pengawasan.lokasiKota.nama_kota : '-') + '</td>';
                                tbody += '<td>' + (pengawasan.tanggal_mulai ? new Date(pengawasan.tanggal_mulai).toLocaleDateString('id-ID') : '-') + '</td>';
                                tbody += '<td>' + (pengawasan.tanggal_selesai ? new Date(pengawasan.tanggal_selesai).toLocaleDateString('id-ID') : '-') + '</td>';
                                tbody += '<td><span class="badge bg-' + (pengawasan.status === 'SELESAI' ? 'success' : (pengawasan.status === 'PROSES' ? 'warning' : 'secondary')) + '">' + pengawasan.status + '</span></td>';
                                tbody += '</tr>';
                            });

                            $('#pengawasan-table tbody').html(tbody);

                            // Re-attach event listeners to new checkboxes
                            $('.pengawasan-checkbox').off('change').on('change', function() {
                                updateSelectedCount();

                                var totalCheckboxes = $('.pengawasan-checkbox').length;
                                var checkedCheckboxes = $('.pengawasan-checkbox:checked').length;

                                $('#select-all-pengawasan').prop('checked', totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes);
                            });
                        } else {
                            $('#pengawasan-table tbody').html('<tr><td colspan="9" class="text-center">Gagal memuat data pengawasan</td></tr>');
                        }
                    },
                    error: function() {
                        $('#pengawasan-table tbody').html('<tr><td colspan="9" class="text-center">Gagal memuat data pengawasan</td></tr>');
                    }
                });
            }
        });
    </script>
    @endpush
@endsection
