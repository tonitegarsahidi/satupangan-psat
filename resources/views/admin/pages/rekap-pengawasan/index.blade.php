@extends('admin/template-base')

@section('page-title', 'Rekapitulasi Pengawasan')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        {{-- Filter Form --}}
        <div class="card mb-4">
            <div class="p-3">
                <h5 class="card-title mb-4">Filter Data</h5>
                <form action="{{ route('rekap-pengawasan.index') }}" method="get" class="row g-3">
                    {{-- Date Range Filter --}}
                    <div class="col-md-3">
                        <label for="date_filter" class="form-label">Rentang Tanggal</label>
                        <select class="form-select" id="date_filter" name="date_filter">
                            <option value="">Semua Tanggal</option>
                            <option value="today" {{ $dateFilter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="this_week" {{ $dateFilter == 'this_week' ? 'selected' : '' }}>Pekan Ini</option>
                            <option value="this_month" {{ $dateFilter == 'this_month' ? 'selected' : '' }}>Bulan Ini
                            </option>
                            <option value="last_3_months" {{ $dateFilter == 'last_3_months' ? 'selected' : '' }}>3 Bulan
                                Terakhir</option>
                            <option value="last_6_months" {{ $dateFilter == 'last_6_months' ? 'selected' : '' }}>6 Bulan
                                Terakhir</option>
                            <option value="last_year" {{ $dateFilter == 'last_year' ? 'selected' : '' }}>1 Tahun Terakhir
                            </option>
                            <option value="all" {{ $dateFilter == 'all' ? 'selected' : '' }}>Semuanya</option>
                        </select>
                    </div>

                    {{-- Provinsi --}}
                    <div class="col-md-3">
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

                    {{-- Komoditas --}}
                    <div class="col-md-3">
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
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-search me-1"></i> Filter
                        </button>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('rekap-pengawasan.index') }}" class="btn btn-secondary">
                            <i class="bx bx-reset me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

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
                                <h6 class="card-title text-muted">Total Seluruh sampel (lab dan rapid)</h6>
                                <h3 class="mb-0">{{ number_format($summary['lab_test_sample_count'] + $summary['rapid_test_sample_count']) }}</h3>
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
                                <h6 class="card-title text-muted">Jumlah Rapid Test</h6>
                                <h3 class="mb-0">{{ number_format($summary['rapid_test_count']) }}</h3>
                            </div>
                            <div class="avatar avatar-stats bg-label-info p-3">
                                <i class="bx bx-check-double bx-sm"></i>
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
                                <h6 class="card-title text-muted">Jumlah Lab Test</h6>
                                <h3 class="mb-0">{{ number_format($summary['lab_test_count']) }}</h3>
                            </div>
                            <div class="avatar avatar-stats bg-label-info p-3">
                                <i class="bx bx-check-double bx-sm"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            // dd($summary)
        @endphp
        {{-- Summary Rapid Test Section --}}
        <div class="card mb-4">
            <div class="p-3">
                <h5 class="card-title mb-4">Summary Rapid Test</h5>

                {{-- Summary Cards --}}
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title text-muted">Jumlah Rapid Test Dilakukan</h6>
                                        <h3 class="mb-0">{{ number_format($summary['rapid_test_count']) }}</h3>
                                    </div>
                                    <div class="avatar avatar-stats bg-label-primary p-3">
                                        <i class="bx bx-check-circle bx-sm"></i>
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
                                        <h6 class="card-title text-muted">Jumlah Sampel Rapid Test</h6>
                                        <h3 class="mb-0">{{ number_format($summary['rapid_test_sample_count']) }}</h3>
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
                                        <h6 class="card-title text-muted">Tidak Memenuhi Syarat</h6>
                                        <h3 class="mb-0">{{ number_format($summary['rapid_test_tidak_memenuhi_syarat']) }}</h3>
                                    </div>
                                    <div class="avatar avatar-stats bg-label-danger p-3">
                                        <i class="bx bx-error bx-sm"></i>
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
                                        <h6 class="card-title text-muted">Memenuhi Syarat</h6>
                                        <h3 class="mb-0">{{ number_format($summary['rapid_test_memenuhi_syarat']) }}</h3>
                                    </div>
                                    <div class="avatar avatar-stats bg-label-success p-3">
                                        <i class="bx bx-check bx-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pie Chart for Memenuhi Syarat vs Tidak Memenuhi Syarat --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Distribusi Sampel Rapid Test</h6>
                                <div class="chart-container" style="position: relative; height:250px;">
                                    <canvas id="rapidTestPieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Tabel Distribusi Sampel Rapid Test</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Jumlah</th>
                                                <th>Persentase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="badge bg-success">Memenuhi Syarat</span></td>
                                                <td>{{ number_format($summary['rapid_test_memenuhi_syarat']) }}</td>
                                                <td>{{ $summary['rapid_test_count'] > 0 ? round(($summary['rapid_test_memenuhi_syarat'] / $summary['rapid_test_count']) * 100, 1) : 0 }}%</td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-danger">Tidak Memenuhi Syarat</span></td>
                                                <td>{{ number_format($summary['rapid_test_tidak_memenuhi_syarat']) }}</td>
                                                <td>{{ $summary['rapid_test_count'] > 0 ? round(($summary['rapid_test_tidak_memenuhi_syarat'] / $summary['rapid_test_count']) * 100, 1) : 0 }}%</td>
                                            </tr>
                                            <tr class="table-secondary">
                                                <td><strong>Total</strong></td>
                                                <td><strong>{{ number_format($summary['rapid_test_count']) }}</strong></td>
                                                <td><strong>100%</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Test Name Chart and Table --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Summary Berdasarkan Test Name</h6>
                                <div class="chart-container" style="position: relative; height:300px;">
                                    <canvas id="rapidTestByTestNameChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Tabel Summary Berdasarkan Test Name</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Test Name</th>
                                                <th>Memenuhi Syarat</th>
                                                <th>Tidak Memenuhi Syarat</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($summary['rapid_test_by_test_name'] as $item)
                                                <tr>
                                                    <td>{{ $item->test_name }}</td>
                                                    <td><span class="badge bg-success">{{ number_format($item->memenuhi_syarat) }}</span></td>
                                                    <td><span class="badge bg-danger">{{ number_format($item->tidak_memenuhi_syarat) }}</span></td>
                                                    <td><strong>{{ number_format($item->memenuhi_syarat + $item->tidak_memenuhi_syarat) }}</strong></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Komoditas Chart and Table --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Summary Berdasarkan Komoditas</h6>
                                <div class="chart-container" style="position: relative; height:300px;">
                                    <canvas id="rapidTestByKomoditasChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Tabel Summary Berdasarkan Komoditas</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Komoditas</th>
                                                <th>Memenuhi Syarat</th>
                                                <th>Tidak Memenuhi Syarat</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($summary['rapid_test_by_komoditas'] as $item)
                                                <tr>
                                                    <td>{{ $item->komoditas ? $item->komoditas->nama_bahan_pangan_segar : 'Unknown' }}</td>
                                                    <td><span class="badge bg-success">{{ number_format($item->memenuhi_syarat) }}</span></td>
                                                    <td><span class="badge bg-danger">{{ number_format($item->tidak_memenuhi_syarat) }}</span></td>
                                                    <td><strong>{{ number_format($item->memenuhi_syarat + $item->tidak_memenuhi_syarat) }}</strong></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary Lab Test Section --}}
        <div class="card mb-4">
            <div class="p-3">
                <h5 class="card-title mb-4">Summary Lab Test</h5>

                {{-- Summary Cards --}}
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title text-muted">Jumlah Lab Test Dilakukan</h6>
                                        <h3 class="mb-0">{{ number_format($summary['lab_test_count']) }}</h3>
                                    </div>
                                    <div class="avatar avatar-stats bg-label-primary p-3">
                                        <i class="bx bx-check-circle bx-sm"></i>
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
                                        <h6 class="card-title text-muted">Jumlah Sampel Lab Test</h6>
                                        <h3 class="mb-0">{{ number_format($summary['lab_test_sample_count']) }}</h3>
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
                                        <h6 class="card-title text-muted">Tidak Memenuhi Syarat</h6>
                                        <h3 class="mb-0">{{ number_format($summary['lab_test_tidak_memenuhi_syarat']) }}</h3>
                                    </div>
                                    <div class="avatar avatar-stats bg-label-danger p-3">
                                        <i class="bx bx-error bx-sm"></i>
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
                                        <h6 class="card-title text-muted">Memenuhi Syarat</h6>
                                        <h3 class="mb-0">{{ number_format($summary['lab_test_memenuhi_syarat']) }}</h3>
                                    </div>
                                    <div class="avatar avatar-stats bg-label-success p-3">
                                        <i class="bx bx-check bx-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pie Chart for Memenuhi Syarat vs Tidak Memenuhi Syarat --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Distribusi Sampel Lab Test</h6>
                                <div class="chart-container" style="position: relative; height:250px;">
                                    <canvas id="labTestPieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Tabel Distribusi Sampel Lab Test</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Jumlah</th>
                                                <th>Persentase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="badge bg-success">Memenuhi Syarat</span></td>
                                                <td>{{ number_format($summary['lab_test_memenuhi_syarat']) }}</td>
                                                <td>{{ $summary['lab_test_count'] > 0 ? round(($summary['lab_test_memenuhi_syarat'] / $summary['lab_test_count']) * 100, 1) : 0 }}%</td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-danger">Tidak Memenuhi Syarat</span></td>
                                                <td>{{ number_format($summary['lab_test_tidak_memenuhi_syarat']) }}</td>
                                                <td>{{ $summary['lab_test_count'] > 0 ? round(($summary['lab_test_tidak_memenuhi_syarat'] / $summary['lab_test_count']) * 100, 1) : 0 }}%</td>
                                            </tr>
                                            <tr class="table-secondary">
                                                <td><strong>Total</strong></td>
                                                <td><strong>{{ number_format($summary['lab_test_count']) }}</strong></td>
                                                <td><strong>100%</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Test Name Chart and Table --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Summary Berdasarkan Test Name</h6>
                                <div class="chart-container" style="position: relative; height:300px;">
                                    <canvas id="labTestByTestNameChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Tabel Summary Berdasarkan Test Name</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Test Name</th>
                                                <th>Memenuhi Syarat</th>
                                                <th>Tidak Memenuhi Syarat</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($summary['lab_test_by_test_name'] as $item)
                                                <tr>
                                                    <td>{{ $item->test_name }}</td>
                                                    <td><span class="badge bg-success">{{ number_format($item->memenuhi_syarat) }}</span></td>
                                                    <td><span class="badge bg-danger">{{ number_format($item->tidak_memenuhi_syarat) }}</span></td>
                                                    <td><strong>{{ number_format($item->memenuhi_syarat + $item->tidak_memenuhi_syarat) }}</strong></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Komoditas Chart and Table --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Summary Berdasarkan Komoditas</h6>
                                <div class="chart-container" style="position: relative; height:300px;">
                                    <canvas id="labTestByKomoditasChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Tabel Summary Berdasarkan Komoditas</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Komoditas</th>
                                                <th>Memenuhi Syarat</th>
                                                <th>Tidak Memenuhi Syarat</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($summary['lab_test_by_komoditas'] as $item)
                                                <tr>
                                                    <td>{{ $item->komoditas ? $item->komoditas->nama_bahan_pangan_segar : 'Unknown' }}</td>
                                                    <td><span class="badge bg-success">{{ number_format($item->memenuhi_syarat) }}</span></td>
                                                    <td><span class="badge bg-danger">{{ number_format($item->tidak_memenuhi_syarat) }}</span></td>
                                                    <td><strong>{{ number_format($item->memenuhi_syarat + $item->tidak_memenuhi_syarat) }}</strong></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart Section --}}
        <div class="card mb-4">
            <div class="p-3">
                <h5 class="card-title mb-4">Statistik Pengawasan</h5>
                <div class="chart-container" style="position: relative; height:300px;">
                    <canvas id="pengawasanChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE --}}
            <div class="p-3">
                <h3 class="card-header">Rekapitulasi Pengawasan</h3>
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
                                    <span class="badge bg-{{ $item->type == 'rapid' ? 'warning' : 'info' }}">
                                        {{ $item->type == 'rapid' ? 'Rapid Test' : 'Laboratory' }}
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
                        {{ $rekapData->onEachSide(5)->appends(['date_filter' => $dateFilter, 'provinsi_id' => $provinsiId, 'komoditas_id' => $komoditasId])->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('pengawasanChart').getContext('2d');

                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Total Pengawasan', 'Rapid Test', 'Laboratory', 'Positif', 'Negatif',
                            'Memenuhi Syarat', 'Tidak Memenuhi Syarat'
                        ],
                        datasets: [{
                            label: 'Jumlah',
                            data: [
                                {{ $summary['total_pengawasan'] }},
                                {{ $summary['total_rapid_test'] }},
                                {{ $summary['total_lab_test'] }},
                                {{ $summary['total_positif'] }},
                                {{ $summary['total_negatif'] }},
                                {{ $summary['total_memenuhi_syarat'] }},
                                {{ $summary['total_tidak_memenuhi_syarat'] }}
                            ],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(153, 102, 255, 0.8)',
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Distribusi Pengawasan'
                            }
                        }
                    }
                });
            });

            // Rapid Test Pie Chart
            const pieCtx = document.getElementById('rapidTestPieChart').getContext('2d');
            const pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Memenuhi Syarat', 'Tidak Memenuhi Syarat'],
                    datasets: [{
                        data: [
                            {{ $summary['rapid_test_memenuhi_syarat'] }},
                            {{ $summary['rapid_test_tidak_memenuhi_syarat'] }}
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(255, 99, 132, 0.8)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Distribusi Sampel Rapid Test'
                        }
                    }
                }
            });

            // Rapid Test By Test Name Bar Chart
            const testNameCtx = document.getElementById('rapidTestByTestNameChart').getContext('2d');
            const testNameChart = new Chart(testNameCtx, {
                type: 'bar',
                data: {
                    labels: @json($summary['rapid_test_by_test_name']->pluck('test_name')),
                    datasets: [{
                            label: 'Memenuhi Syarat',
                            data: @json($summary['rapid_test_by_test_name']->pluck('memenuhi_syarat')),
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Tidak Memenuhi Syarat',
                            data: @json($summary['rapid_test_by_test_name']->pluck('tidak_memenuhi_syarat')),
                            backgroundColor: 'rgba(255, 99, 132, 0.8)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Summary Berdasarkan Test Name'
                        }
                    }
                }
            });

            // Rapid Test By Komoditas Bar Chart
            const komoditasCtx = document.getElementById('rapidTestByKomoditasChart').getContext('2d');
            const komoditasChart = new Chart(komoditasCtx, {
                type: 'bar',
                data: {
                    labels: @json(
                        $summary['rapid_test_by_komoditas']->map(function ($item) {
                            return $item->komoditas ? $item->komoditas->nama_bahan_pangan_segar : 'Unknown';
                        })),
                    datasets: [{
                            label: 'Memenuhi Syarat',
                            data: @json($summary['rapid_test_by_komoditas']->pluck('memenuhi_syarat')),
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Tidak Memenuhi Syarat',
                            data: @json($summary['rapid_test_by_komoditas']->pluck('tidak_memenuhi_syarat')),
                            backgroundColor: 'rgba(255, 99, 132, 0.8)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Summary Berdasarkan Komoditas'
                        }
                    }
                }
            });
        </script>
        <script>
            // Lab Test Pie Chart
            const labPieCtx = document.getElementById('labTestPieChart').getContext('2d');
            const labPieChart = new Chart(labPieCtx, {
                type: 'pie',
                data: {
                    labels: ['Memenuhi Syarat', 'Tidak Memenuhi Syarat'],
                    datasets: [{
                        data: [
                            {{ $summary['lab_test_memenuhi_syarat'] }},
                            {{ $summary['lab_test_tidak_memenuhi_syarat'] }}
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(255, 99, 132, 0.8)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Distribusi Sampel Lab Test'
                        }
                    }
                }
            });

            // Lab Test By Test Name Bar Chart
            const labTestNameCtx = document.getElementById('labTestByTestNameChart').getContext('2d');
            const labTestNameChart = new Chart(labTestNameCtx, {
                type: 'bar',
                data: {
                    labels: @json($summary['lab_test_by_test_name']->pluck('test_name')),
                    datasets: [{
                            label: 'Memenuhi Syarat',
                            data: @json($summary['lab_test_by_test_name']->pluck('memenuhi_syarat')),
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Tidak Memenuhi Syarat',
                            data: @json($summary['lab_test_by_test_name']->pluck('tidak_memenuhi_syarat')),
                            backgroundColor: 'rgba(255, 99, 132, 0.8)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Summary Berdasarkan Test Name'
                        }
                    }
                }
            });

            // Lab Test By Komoditas Bar Chart
            const labKomoditasCtx = document.getElementById('labTestByKomoditasChart').getContext('2d');
            const labKomoditasChart = new Chart(labKomoditasCtx, {
                type: 'bar',
                data: {
                    labels: @json(
                        $summary['lab_test_by_komoditas']->map(function ($item) {
                            return $item->komoditas ? $item->komoditas->nama_bahan_pangan_segar : 'Unknown';
                        })),
                    datasets: [{
                            label: 'Memenuhi Syarat',
                            data: @json($summary['lab_test_by_komoditas']->pluck('memenuhi_syarat')),
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Tidak Memenuhi Syarat',
                            data: @json($summary['lab_test_by_komoditas']->pluck('tidak_memenuhi_syarat')),
                            backgroundColor: 'rgba(255, 99, 132, 0.8)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Summary Berdasarkan Komoditas'
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
