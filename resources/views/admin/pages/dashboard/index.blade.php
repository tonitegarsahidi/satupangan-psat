@extends('admin.template-base')

@section('page-title', 'Dashboard')

@section('main-content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Early Warning Notification Section -->
            @foreach($unreadEarlyWarningNotifications as $notification)
                <div class="col-12 mb-2">
                    <div class="card bg-danger border-0">
                        <div class="p-2 ml-3">
                            <h3 class="card-title mb-0 mt-0 text-white">
                                <i class="bx bx-error-circle me-2"></i>Peringatan Dini
                            </h3>

                                <div class="alert alert-light alert-dismissible mb-0" role="alert">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="mb-0 mt-0 text-white">{{ $notification->title }}</span>
                                        </div>
                                        <div>
                                            <a href="{{ route('notification.show', $notification->id) }}"
                                               class="btn btn-hover bg-white text-danger btn-sm">
                                                <i class="bx bx-arrow-to-right me-1"></i>Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Surveilans Notification Section -->
            @foreach($unreadSurveilansNotifications as $notification)
                <div class="col-12 mb-2">
                    <div class="card bg-warning border-0">
                        <div class="p-2 ml-3">
                            <h3 class="card-title mb-0 mt-0 text-danger">
                                <i class="bx bx-bell me-2"></i>Notifikasi Surveilans
                            </h3>
                                <div class="alert alert-light alert-dismissible mb-0" role="alert">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="mb-0 mt-0 text-black">{{ $notification->title }}</span>
                                        </div>
                                        <div>
                                            <a href="{{ route('notification.show', $notification->id) }}"
                                               class="btn btn-hover bg-white text-black btn-sm">
                                                <i class="bx bx-arrow-to-right me-1"></i>Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Congratulations Section -->
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat Datang {{ auth()->user()->name }} 🎉</h5>
                                <p class="mb-4">
                                    <strong>Selamat datang di Dashboard Sistem Pengendalian Keamanan Pangan Segar Asal
                                        Tumbuhan.</strong> Platform digital terpadu untuk mendukung pengendalian keamanan
                                    Pangan Segar Asal Tumbuhan (PSAT) di Indonesia.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                    alt="View Badge User"
                                    data-app-dark-img="{{ asset('illustrations/man-with-laptop-dark.png') }}"
                                    data-app-light-img="{{ asset('illustrations/man-with-laptop-light.png') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                            alt="notification" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <a class="dropdown-item" href="{{ route('notification.index') }}">View
                                                More</a>
                                            {{-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> --}}
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Notifikasi</span>
                                <h3 class="card-title mb-2">{{ $unreadNotificationsCount ?? '0' }}</h3>
                                <small class="text-info fw-semibold"><i class="bx bx-bell"></i>
                                    Notifikasi Baru</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="Message"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                            <a class="dropdown-item" href="{{ route('message.index') }}">View
                                                More</a>
                                            {{-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> --}}
                                        </div>
                                    </div>
                                </div>
                                <span>Jumlah Messages</span>
                                <h3 class="card-title text-nowrap mb-1">{{ $unreadMessagesCount ?? '0' }}</h3>
                                <small class="text-primary fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    Pesan Baru</small>
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
                                    <span class="badge bg-label-info p-2"><i class="bx bx-shield-alt text-info"></i></span>
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

        <!-- Role-based Dashboard Content -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Aktivitas Saya</h5>

                    <!-- ROLE_USER_BUSINESS -->
                    @if ($hasUserRoleBusiness)
                        <div class="row">
                            <!-- Left Column: QR Badan Pangan -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">QR Badan Pangan Saya (Status: Pending/Reviewed)</h6>
                                    </div>
                                    <div class="card-body">
                                        @if ($qrBadanPanganPendingReviewed->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Komoditas</th>
                                                            <th>Merk</th>
                                                            <th>Unit Usaha</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($qrBadanPanganPendingReviewed as $qr)
                                                            <tr>
                                                                <td>{{ $qr->nama_komoditas }}</td>
                                                                <td>{{ $qr->merk_dagang }}</td>
                                                                <td>{{ $qr->business->nama_perusahaan }}</td>
                                                                <td>
                                                                    @php
                                                                        $badgeClass =
                                                                            $qr->status == 'Pending'
                                                                                ? 'warning'
                                                                                : 'info';
                                                                    @endphp
                                                                    <span class="badge bg-{{ $badgeClass }}">
                                                                        {{ $qr->status }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('qr-badan-pangan.detail', $qr->id) }}"
                                                                        class="btn btn-sm btn-primary">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada QR Badan Pangan dengan status Pending/Reviewed
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: All Register Types -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Detail Status Pendaftaran</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Register SPPB Saya -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register SPPB Saya (Status: Diajukan/Diperiksa)
                                            </h6>
                                            @if ($registerSppbDiajukanDiperiksa->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No. Reg</th>
                                                                <th>Unit Usaha</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($registerSppbDiajukanDiperiksa as $sppb)
                                                                <tr>
                                                                    <td>{{ $sppb->nomor_registrasi }}</td>
                                                                    <td>{{ $sppb->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass =
                                                                                $sppb->status == 'DIAJUKAN'
                                                                                    ? 'info'
                                                                                    : 'secondary';
                                                                        @endphp
                                                                        <span class="badge bg-{{ $badgeClass }}">
                                                                            {{ $sppb->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('register-sppb.detail', $sppb->id) }}"
                                                                            class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register SPPB dengan status
                                                    Diajukan/Diperiksa</p>
                                            @endif
                                        </div>

                                        <!-- Register IZIN EDAR PL Saya -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register IZIN EDAR PL Saya (Status:
                                                Diajukan/Diperiksa)</h6>
                                            @if ($registerIzinedarPlDiajukanDiperiksa->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No. Reg</th>
                                                                <th>Unit Usaha</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($registerIzinedarPlDiajukanDiperiksa as $izin)
                                                                <tr>
                                                                    <td>{{ $izin->nomor_izinedar_pl }}</td>
                                                                    <td>{{ $izin->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass =
                                                                                $izin->status == 'DIAJUKAN'
                                                                                    ? 'info'
                                                                                    : 'secondary';
                                                                        @endphp
                                                                        <span class="badge bg-{{ $badgeClass }}">
                                                                            {{ $izin->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('register-izinedar-psatpl.detail', $izin->id) }}"
                                                                            class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register IZIN EDAR PL dengan status
                                                    Diajukan/Diperiksa</p>
                                            @endif
                                        </div>

                                        <!-- Register IZIN EDAR PD Saya -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register IZIN EDAR PD Saya (Status:
                                                Diajukan/Diperiksa)</h6>
                                            @if ($registerIzinedarPdDiajukanDiperiksa->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No. Reg</th>
                                                                <th>Unit Usaha</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($registerIzinedarPdDiajukanDiperiksa as $izin)
                                                                <tr>
                                                                    <td>{{ $izin->nomor_izinedar_pd }}</td>
                                                                    <td>{{ $izin->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass =
                                                                                $izin->status == 'DIAJUKAN'
                                                                                    ? 'info'
                                                                                    : 'secondary';
                                                                        @endphp
                                                                        <span class="badge bg-{{ $badgeClass }}">
                                                                            {{ $izin->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('register-izinedar-psatpd.detail', $izin->id) }}"
                                                                            class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register IZIN EDAR PD dengan status
                                                    Diajukan/Diperiksa</p>
                                            @endif
                                        </div>

                                        <!-- Register IZIN EDAR PDUK Saya -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register IZIN EDAR PDUK Saya (Status:
                                                Diajukan/Diperiksa)</h6>
                                            @if ($registerIzinedarPdukDiajukanDiperiksa->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No. Reg</th>
                                                                <th>Unit Usaha</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($registerIzinedarPdukDiajukanDiperiksa as $izin)
                                                                <tr>
                                                                    <td>{{ $izin->nomor_izinedar_pduk }}</td>
                                                                    <td>{{ $izin->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass =
                                                                                $izin->status == 'DIAJUKAN'
                                                                                    ? 'info'
                                                                                    : 'secondary';
                                                                        @endphp
                                                                        <span class="badge bg-{{ $badgeClass }}">
                                                                            {{ $izin->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('register-izinedar-psatpduk.detail', $izin->id) }}"
                                                                            class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register IZIN EDAR PDUK dengan status
                                                    Diajukan/Diperiksa</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif



                    <!-- ROLE_OPERATOR or ROLE_SUPERVISOR -->
                    @if ($hasUserRoleOperator || $hasUserRoleSupervisor)
                        <div class="row">
                            <!-- Left Column: QR Badan Pangan Semua -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">QR Badan Pangan Semua (Status: Pending/Reviewed)</h6>
                                    </div>
                                    <div class="card-body">
                                        @if ($qrBadanPanganAllPendingReviewed->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Komoditas</th>
                                                            <th>Merk</th>
                                                            <th>Unit Usaha</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($qrBadanPanganAllPendingReviewed as $qr)
                                                            <tr>
                                                                <td>{{ $qr->nama_komoditas }}</td>
                                                                <td>{{ $qr->merk_dagang }}</td>
                                                                <td>{{ $qr->business->nama_perusahaan }}</td>
                                                                <td>
                                                                    @php
                                                                        $badgeClass =
                                                                            $qr->status == 'Pending'
                                                                                ? 'warning'
                                                                                : 'info';
                                                                    @endphp
                                                                    <span class="badge bg-{{ $badgeClass }}">
                                                                        {{ $qr->status }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('qr-badan-pangan.detail', $qr->id) }}"
                                                                        class="btn btn-sm btn-primary">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada QR Badan Pangan dengan status Pending/Reviewed
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: All Register Types -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Detail Status Pendaftaran</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Register SPPB Semua -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register SPPB Semua (Status: Diajukan/Diperiksa)
                                            </h6>
                                            @if ($registerSppbAllDiajukanDiperiksa->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No. Reg</th>
                                                                <th>Unit Usaha</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($registerSppbAllDiajukanDiperiksa as $sppb)
                                                                <tr>
                                                                    <td>{{ $sppb->nomor_registrasi }}</td>
                                                                    <td>{{ $sppb->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass =
                                                                                $sppb->status == 'DIAJUKAN'
                                                                                    ? 'info'
                                                                                    : 'secondary';
                                                                        @endphp
                                                                        <span class="badge bg-{{ $badgeClass }}">
                                                                            {{ $sppb->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('register-sppb.detail', $sppb->id) }}"
                                                                            class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register SPPB dengan status
                                                    Diajukan/Diperiksa</p>
                                            @endif
                                        </div>

                                        <!-- Register IZIN EDAR PL Semua -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register IZIN EDAR PL Semua (Status:
                                                Diajukan/Diperiksa)</h6>
                                            @if ($registerIzinedarPlAllDiajukanDiperiksa->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No. Reg</th>
                                                                <th>Unit Usaha</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($registerIzinedarPlAllDiajukanDiperiksa as $izin)
                                                                <tr>
                                                                    <td>{{ $izin->nomor_izinedar_pl }}</td>
                                                                    <td>{{ $izin->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass =
                                                                                $izin->status == 'DIAJUKAN'
                                                                                    ? 'info'
                                                                                    : 'secondary';
                                                                        @endphp
                                                                        <span class="badge bg-{{ $badgeClass }}">
                                                                            {{ $izin->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('register-izinedar-psatpl.detail', $izin->id) }}"
                                                                            class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register IZIN EDAR PL dengan status
                                                    Diajukan/Diperiksa</p>
                                            @endif
                                        </div>

                                        <!-- Register IZIN EDAR PD Semua -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register IZIN EDAR PD Semua (Status:
                                                Diajukan/Diperiksa)</h6>
                                            @if ($registerIzinedarPdAllDiajukanDiperiksa->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No. Reg</th>
                                                                <th>Unit Usaha</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($registerIzinedarPdAllDiajukanDiperiksa as $izin)
                                                                <tr>
                                                                    <td>{{ $izin->nomor_izinedar_pd }}</td>
                                                                    <td>{{ $izin->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass =
                                                                                $izin->status == 'DIAJUKAN'
                                                                                    ? 'info'
                                                                                    : 'secondary';
                                                                        @endphp
                                                                        <span class="badge bg-{{ $badgeClass }}">
                                                                            {{ $izin->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('register-izinedar-psatpd.detail', $izin->id) }}"
                                                                            class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register IZIN EDAR PD dengan status
                                                    Diajukan/Diperiksa</p>
                                            @endif
                                        </div>

                                        <!-- Register IZIN EDAR PDUK Semua -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register IZIN EDAR PDUK Semua (Status:
                                                Diajukan/Diperiksa)</h6>
                                            @if ($registerIzinedarPdukAllDiajukanDiperiksa->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No. Reg</th>
                                                                <th>Unit Usaha</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($registerIzinedarPdukAllDiajukanDiperiksa as $izin)
                                                                <tr>
                                                                    <td>{{ $izin->nomor_izinedar_pduk }}</td>
                                                                    <td>{{ $izin->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass =
                                                                                $izin->status == 'DIAJUKAN'
                                                                                    ? 'info'
                                                                                    : 'secondary';
                                                                        @endphp
                                                                        <span class="badge bg-{{ $badgeClass }}">
                                                                            {{ $izin->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('register-izinedar-psatpduk.detail', $izin->id) }}"
                                                                            class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register IZIN EDAR PDUK dengan status
                                                    Diajukan/Diperiksa</p>
                                            @endif
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- ROLE_USER_BUSINESS -->
                    @if ($hasUserRole && !$hasUserRoleBusiness)
                        <div class="row">
                            <!-- Right Column: All Register Types -->
                            <div class="col-md-10 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Detail Laporan</h6>
                                    </div>
                                    <div class="card-body">

                                        <!-- Laporan Pengaduan Saya -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Laporan Pengaduan (Status: Diajukan/Diperiksa)</h6>
                                            @if ($laporanPengaduanDiajukanDiperiksa->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal</th>
                                                                <th>Lokasi Kejadian</th>
                                                                <th>Isi Laporan</th>

                                                                <th>Status</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($laporanPengaduanDiajukanDiperiksa as $laporan)
                                                                <tr>
                                                                    <td>{{ $laporan->created_at ? \Carbon\Carbon::parse($laporan->created_at)->format('d M Y') : '-' }}
                                                                    </td>
                                                                    <td>{{ $laporan->lokasi_kejadian }}</td>
                                                                    <td>{{ $laporan->isi_laporan }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass =
                                                                                $laporan->workflow->status == 'DIAJUKAN'
                                                                                    ? 'info'
                                                                                    : 'secondary';
                                                                        @endphp
                                                                        <span class="badge bg-{{ $badgeClass }}">
                                                                            {{ $laporan->workflow->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('admin.laporan-pengaduan.detail', $laporan->id) }}"
                                                                            class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Laporan Pengaduan dengan status
                                                    Diajukan/Diperiksa</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
