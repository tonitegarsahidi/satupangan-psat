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

        <!-- Role-based Dashboard Content -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Status Pendaftaran</h5>

                    <!-- ROLE_USER_BUSINESS -->
                    @if($hasUserRoleBusiness)
                        <div class="row">
                            <!-- QR Badan Pangan Pending/Reviewed -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">QR Badan Pangan Saya (Status: Pending/Reviewed)</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($qrBadanPanganPendingReviewed->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Reg</th>
                                                            <th>Nama Badan Pangan</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($qrBadanPanganPendingReviewed as $qr)
                                                            <tr>
                                                                <td>{{ $qr->registration_number }}</td>
                                                                <td>{{ $qr->business_name }}</td>
                                                                <td>
                                                                     @php
                                                                         $badgeClass = ($qr->status == 'Pending') ? 'warning' : 'info';
                                                                     @endphp
                                                                     <span class="badge bg-{{ $badgeClass }}">
                                                                         {{ $qr->status }}
                                                                     </span>
                                                                 </td>
                                                                <td>
                                                                    <a href="{{ route('qr-badan-pangan.detail', $qr->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada QR Badan Pangan dengan status Pending/Reviewed</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Register SPPB Diajukan/Diperiksa -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Register SPPB Saya (Status: Diajukan/Diperiksa)</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($registerSppbDiajukanDiperiksa->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Reg</th>
                                                            <th>Nama Produk</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($registerSppbDiajukanDiperiksa as $sppb)
                                                            <tr>
                                                                <td>{{ $sppb->registration_number }}</td>
                                                                <td>{{ $sppb->product_name }}</td>
                                                                <td>
                                                                     @php
                                                                         $badgeClass = ($sppb->status == 'DIAJUKAN') ? 'info' : 'secondary';
                                                                     @endphp
                                                                     <span class="badge bg-{{ $badgeClass }}">
                                                                         {{ $sppb->status }}
                                                                     </span>
                                                                 </td>
                                                                <td>
                                                                    <a href="{{ route('register-sppb.detail', $sppb->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada Register SPPB dengan status Diajukan/Diperiksa</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Register Izin Edar PL Diajukan/Diperiksa -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Register IZIN EDAR PL Saya (Status: Diajukan/Diperiksa)</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($registerIzinedarPlDiajukanDiperiksa->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Reg</th>
                                                            <th>Nama Produk</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($registerIzinedarPlDiajukanDiperiksa as $izin)
                                                            <tr>
                                                                <td>{{ $izin->registration_number }}</td>
                                                                <td>{{ $izin->product_name }}</td>
                                                                <td>
                                                                     @php
                                                                         $badgeClass = ($izin->status == 'DIAJUKAN') ? 'info' : 'secondary';
                                                                     @endphp
                                                                     <span class="badge bg-{{ $badgeClass }}">
                                                                         {{ $izin->status }}
                                                                     </span>
                                                                 </td>
                                                                <td>
                                                                    <a href="{{ route('register-izinedar-psatpl.detail', $izin->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada Register IZIN EDAR PL dengan status Diajukan/Diperiksa</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Register Izin Edar PD Diajukan/Diperiksa -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Register IZIN EDAR PD Saya (Status: Diajukan/Diperiksa)</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($registerIzinedarPdDiajukanDiperiksa->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Reg</th>
                                                            <th>Nama Produk</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($registerIzinedarPdDiajukanDiperiksa as $izin)
                                                            <tr>
                                                                <td>{{ $izin->registration_number }}</td>
                                                                <td>{{ $izin->product_name }}</td>
                                                                <td>
                                                                     @php
                                                                         $badgeClass = ($izin->status == 'DIAJUKAN') ? 'info' : 'secondary';
                                                                     @endphp
                                                                     <span class="badge bg-{{ $badgeClass }}">
                                                                         {{ $izin->status }}
                                                                     </span>
                                                                 </td>
                                                                <td>
                                                                    <a href="{{ route('register-izinedar-psatpd.detail', $izin->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada Register IZIN EDAR PD dengan status Diajukan/Diperiksa</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Register Izin Edar PDUK Diajukan/Diperiksa -->
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Register IZIN EDAR PDUK Saya (Status: Diajukan/Diperiksa)</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($registerIzinedarPdukDiajukanDiperiksa->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Reg</th>
                                                            <th>Nama Produk</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($registerIzinedarPdukDiajukanDiperiksa as $izin)
                                                            <tr>
                                                                <td>{{ $izin->registration_number }}</td>
                                                                <td>{{ $izin->product_name }}</td>
                                                                <td>
                                                                     @php
                                                                         $badgeClass = ($izin->status == 'DIAJUKAN') ? 'info' : 'secondary';
                                                                     @endphp
                                                                     <span class="badge bg-{{ $badgeClass }}">
                                                                         {{ $izin->status }}
                                                                     </span>
                                                                 </td>
                                                                <td>
                                                                    <a href="{{ route('register-izinedar-psatpduk.detail', $izin->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada Register IZIN EDAR PDUK dengan status Diajukan/Diperiksa</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- ROLE_OPERATOR or ROLE_SUPERVISOR -->
                    @if($hasUserRoleOperator || $hasUserRoleSupervisor)
                        <div class="row">
                            <!-- Left Column: QR Badan Pangan Semua -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">QR Badan Pangan Semua (Status: Pending/Reviewed)</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($qrBadanPanganAllPendingReviewed->count() > 0)
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
                                                        @foreach($qrBadanPanganAllPendingReviewed as $qr)
                                                            <tr>
                                                                <td>{{ $qr->nama_komoditas }}</td>
                                                                <td>{{ $qr->merk_dagang }}</td>
                                                                <td>{{ $qr->business->nama_perusahaan }}</td>
                                                                <td>
                                                                     @php
                                                                         $badgeClass = ($qr->status == 'Pending') ? 'warning' : 'info';
                                                                     @endphp
                                                                     <span class="badge bg-{{ $badgeClass }}">
                                                                         {{ $qr->status }}
                                                                     </span>
                                                                 </td>
                                                                <td>
                                                                    <a href="{{ route('qr-badan-pangan.detail', $qr->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada QR Badan Pangan dengan status Pending/Reviewed</p>
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
                                            <h6 class="card-title mb-0">Register SPPB Semua (Status: Diajukan/Diperiksa)</h6>
                                            @if($registerSppbAllDiajukanDiperiksa->count() > 0)
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
                                                            @foreach($registerSppbAllDiajukanDiperiksa as $sppb)
                                                                <tr>
                                                                    <td>{{ $sppb->nomor_registrasi }}</td>
                                                                    <td>{{ $sppb->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                         @php
                                                                             $badgeClass = ($sppb->status == 'DIAJUKAN') ? 'info' : 'secondary';
                                                                         @endphp
                                                                         <span class="badge bg-{{ $badgeClass }}">
                                                                             {{ $sppb->status }}
                                                                         </span>
                                                                     </td>
                                                                    <td>
                                                                        <a href="{{ route('register-sppb.detail', $sppb->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register SPPB dengan status Diajukan/Diperiksa</p>
                                            @endif
                                        </div>

                                        <!-- Register IZIN EDAR PL Semua -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register IZIN EDAR PL Semua (Status: Diajukan/Diperiksa)</h6>
                                            @if($registerIzinedarPlAllDiajukanDiperiksa->count() > 0)
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
                                                            @foreach($registerIzinedarPlAllDiajukanDiperiksa as $izin)
                                                                <tr>
                                                                    <td>{{ $izin->nomor_izinedar_pl }}</td>
                                                                    <td>{{ $izin->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                         @php
                                                                             $badgeClass = ($izin->status == 'DIAJUKAN') ? 'info' : 'secondary';
                                                                         @endphp
                                                                         <span class="badge bg-{{ $badgeClass }}">
                                                                             {{ $izin->status }}
                                                                         </span>
                                                                     </td>
                                                                    <td>
                                                                        <a href="{{ route('register-izinedar-psatpl.detail', $izin->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register IZIN EDAR PL dengan status Diajukan/Diperiksa</p>
                                            @endif
                                        </div>

                                        <!-- Register IZIN EDAR PD Semua -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register IZIN EDAR PD Semua (Status: Diajukan/Diperiksa)</h6>
                                            @if($registerIzinedarPdAllDiajukanDiperiksa->count() > 0)
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
                                                            @foreach($registerIzinedarPdAllDiajukanDiperiksa as $izin)
                                                                <tr>
                                                                    <td>{{ $izin->nomor_izinedar_pd }}</td>
                                                                    <td>{{ $izin->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                         @php
                                                                             $badgeClass = ($izin->status == 'DIAJUKAN') ? 'info' : 'secondary';
                                                                         @endphp
                                                                         <span class="badge bg-{{ $badgeClass }}">
                                                                             {{ $izin->status }}
                                                                         </span>
                                                                     </td>
                                                                    <td>
                                                                        <a href="{{ route('register-izinedar-psatpd.detail', $izin->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register IZIN EDAR PD dengan status Diajukan/Diperiksa</p>
                                            @endif
                                        </div>

                                        <!-- Register IZIN EDAR PDUK Semua -->
                                        <div class="mb-4">
                                            <h6 class="card-title mb-0">Register IZIN EDAR PDUK Semua (Status: Diajukan/Diperiksa)</h6>
                                            @if($registerIzinedarPdukAllDiajukanDiperiksa->count() > 0)
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
                                                            @foreach($registerIzinedarPdukAllDiajukanDiperiksa as $izin)
                                                                <tr>
                                                                    <td>{{ $izin->nomor_izinedar_pduk }}</td>
                                                                    <td>{{ $izin->business->nama_perusahaan }}</td>
                                                                    <td>
                                                                         @php
                                                                             $badgeClass = ($izin->status == 'DIAJUKAN') ? 'info' : 'secondary';
                                                                         @endphp
                                                                         <span class="badge bg-{{ $badgeClass }}">
                                                                             {{ $izin->status }}
                                                                         </span>
                                                                     </td>
                                                                    <td>
                                                                        <a href="{{ route('register-izinedar-psatpduk.detail', $izin->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada Register IZIN EDAR PDUK dengan status Diajukan/Diperiksa</p>
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
