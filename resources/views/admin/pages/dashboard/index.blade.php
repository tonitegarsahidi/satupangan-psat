@extends('admin.template-base')

@section('page-title', 'Dashboard')

@section('main-content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Congratulations Section -->
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat Datang {{ auth()->user()->name }} 🎉</h5>
                            <p class="mb-4">
                                <strong>Selamat datang di Dashboard Sistem Pengendalian Keamanan Pangan Segar Asal Tumbuhan.</strong> Platform digital terpadu untuk mendukung pengendalian keamanan Pangan Segar Asal Tumbuhan (PSAT) di Indonesia.
                            </p>

                            <a href="javascript:;" class="btn btn-sm btn-outline-primary">View
                                Badges</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                                height="140" alt="View Badge User"
                                data-app-dark-img="{{ asset('illustrations/man-with-laptop-dark.png') }}"
                                data-app-light-img="{{ asset('illustrations/man-with-laptop-light.png') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                        <div class="text-center fw-semibold pt-3 mb-2">Dashboard Pangan Aman Kamu</div>

                        <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-primary p-2"><i
                                            class="bx bx-file-find text-primary"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>Laporan Pengaduan</small>
                                    <h6 class="mb-0">{{ $laporanPengaduanCount ?? '0' }}</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-success p-2"><i
                                            class="bx bx-file-plus text-success"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>Register SPPB</small>
                                    <h6 class="mb-0">{{ $registerSppbCount ?? '0' }}</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-info p-2"><i
                                            class="bx bx-shield-alt text-info"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>Izin Edar PL</small>
                                    <h6 class="mb-0">{{ $izinEdarPlCount ?? '0' }}</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-warning p-2"><i
                                            class="bx bx-shield-alt text-warning"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>Izin Edar PD</small>
                                    <h6 class="mb-0">{{ $izinEdarPdCount ?? '0' }}</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-secondary p-2"><i
                                            class="bx bx-shield-alt text-secondary"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>Izin Edar PDUK</small>
                                    <h6 class="mb-0">{{ $izinEdarPdukCount ?? '0' }}</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-danger p-2"><i
                                            class="bx bx-qrcode text-danger"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>QR Badan Pangan</small>
                                    <h6 class="mb-0">{{ $qrBadanPanganCount ?? '0' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Total Revenue -->
    </div>
</div>
@endsection
