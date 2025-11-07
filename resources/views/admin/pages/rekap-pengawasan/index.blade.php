@extends('admin/template-base')

@section('page-title', 'Rekapitulasi Pengawasan')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        {{-- Summary Cards --}}
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-muted">Total Pengawasan</h6>
                                <h3 class="mb-0">{{ number_format($summary['total_pengawasan']) }}</h3>
                            </div>
                            <div class="avatar avatar-stats bg-label-primary p-3">
                                <i class="bx bx-file bx-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-muted">Rapid Test</h6>
                                <h3 class="mb-0">{{ number_format($summary['total_rapid_test']) }}</h3>
                            </div>
                            <div class="avatar avatar-stats bg-label-success p-3">
                                <i class="bx bx-time bx-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-muted">Laboratory</h6>
                                <h3 class="mb-0">{{ number_format($summary['total_lab_test']) }}</h3>
                            </div>
                            <div class="avatar avatar-stats bg-label-info p-3">
                                <i class="bx bx bx-vial bx-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-muted">Positif</h6>
                                <h3 class="mb-0">{{ number_format($summary['total_positif']) }}</h3>
                            </div>
                            <div class="avatar avatar-stats bg-label-danger p-3">
                                <i class="bx bx-error bx-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE --}}
            <div class="p-3">
                <h3 class="card-header">Rekapitulasi Pengawasan</h3>
            </div>

            {{-- SECOND ROW,  FOR FILTER FORM --}}
            <div class="p-3 border-bottom">
                <form action="{{ route('rekap-pengawasan.index') }}" method="get" class="row g-3">
                    {{-- Tanggal Selesai From --}}
                    <div class="col-md-3">
                        <label for="tanggal_selesai_from" class="form-label">Tanggal Selesai Dari</label>
                        <input type="date" class="form-control" id="tanggal_selesai_from" name="tanggal_selesai_from"
                               value="{{ $tanggalSelesaiFrom }}" placeholder="Pilih tanggal mulai">
                    </div>

                    {{-- Tanggal Selesai To --}}
                    <div class="col-md-3">
                        <label for="tanggal_selesai_to" class="form-label">Tanggal Selesai Sampai</label>
                        <input type="date" class="form-control" id="tanggal_selesai_to" name="tanggal_selesai_to"
                               value="{{ $tanggalSelesaiTo }}" placeholder="Pilih tanggal akhir">
                    </div>

                    {{-- Provinsi --}}
                    <div class="col-md-2">
                        <label for="provinsi_id" class="form-label">Provinsi</label>
                        <select class="form-select" id="provinsi_id" name="provinsi_id">
                            <option value="">Semua Provinsi</option>
                            @foreach ($provinsis as $provinsi)
                                <option value="{{ $provinsi->id }}" {{ $provinsiId == $provinsi->id ? 'selected' : '' }}>
                                    {{ $provinsi->nama_provinsi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tipe --}}
                    <div class="col-md-2">
                        <label for="tipe" class="form-label">Tipe</label>
                        <select class="form-select" id="tipe" name="tipe">
                            <option value="">Semua Tipe</option>
                            @foreach ($tipeOptions as $key => $value)
                                <option value="{{ $key }}" {{ $tipe == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Komoditas --}}
                    <div class="col-md-2">
                        <label for="komoditas_id" class="form-label">Komoditas</label>
                        <select class="form-select" id="komoditas_id" name="komoditas_id">
                            <option value="">Semua Komoditas</option>
                            @foreach ($komoditas as $komod)
                                <option value="{{ $komod->id }}" {{ $komoditasId == $komod->id ? 'selected' : '' }}>
                                    {{ $komod->nama_bahan_pangan_segar }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('rekap-pengawasan.index') }}" class="btn btn-secondary">
                            <i class="bx bx-reset me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- THIRD ROW, FOR THE MAIN DATA PART --}}
            {{-- //to display any error if any --}}
            @if (isset($alerts))
                @include('admin.components.notification.general', $alerts)
            @endif

            <div class="table-responsive">
                <!-- Table data with Striped Rows -->
                <table class="table table-striped table-hover align-middle">

                    {{-- TABLE HEADER --}}
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="min-width: 150px;">Tanggal Selesai</th>
                            <th style="min-width: 120px;">Provinsi</th>
                            <th style="min-width: 150px;">Lokasi</th>
                            <th style="min-width: 120px;">Tipe</th>
                            <th style="min-width: 150px;">Tes</th>
                            <th style="min-width: 150px;">Komoditas</th>
                            <th style="min-width: 100px;">Hasil</th>
                            <th style="min-width: 100px;">Memenuhi Syarat</th>
                            <th style="min-width: 100px;">Nilai</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $startNumber = $rekapData->perPage() * ($rekapData->currentPage() - 1) + 1;
                        @endphp
                        @foreach ($rekapData as $item)
                            <tr>
                                <td style="width: 50px;">{{ $startNumber++ }}</td>
                                <td style="min-width: 150px;">
                                    {{ $item->pengawasan->tanggal_selesai ? \Carbon\Carbon::parse($item->pengawasan->tanggal_selesai)->format('d/m/Y') : '-' }}
                                </td>
                                <td style="min-width: 120px;">
                                    {{ $item->pengawasan->lokasiProvinsi->nama_provinsi ?? '-' }}
                                </td>
                                <td style="min-width: 150px;">
                                    {{ $item->pengawasan->lokasi_alamat ?? '-' }}
                                </td>
                                <td style="min-width: 120px;">
                                    <span class="badge bg-{{ $item->type == 'RAPID' ? 'success' : 'info' }}">
                                        {{ $item->type == 'RAPID' ? 'Rapid Test' : 'Laboratory' }}
                                    </span>
                                </td>
                                <td style="min-width: 150px;">
                                    {{ $item->test_name ?? '-' }}
                                </td>
                                <td style="min-width: 150px;">
                                    {{ $item->komoditas->nama_bahan_pangan_segar ?? '-' }}
                                </td>
                                <td style="min-width: 100px;">
                                    @if ($item->is_positif)
                                        <span class="badge bg-danger">Positif</span>
                                    @else
                                        <span class="badge bg-success">Negatif</span>
                                    @endif
                                </td>
                                <td style="min-width: 100px;">
                                    @if ($item->is_memenuhisyarat)
                                        <span class="badge bg-success">Ya</span>
                                    @else
                                        <span class="badge bg-danger">Tidak</span>
                                    @endif
                                </td>
                                <td style="min-width: 100px;">
                                    @if ($item->value_numeric !== null)
                                        {{ $item->value_numeric }} {{ $item->value_unit ?? '' }}
                                    @else
                                        {{ $item->value_string ?? '-' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <br />

                <div class="row">
                    <div class="col-md-10 mx-auto">
                        {{ $rekapData->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
