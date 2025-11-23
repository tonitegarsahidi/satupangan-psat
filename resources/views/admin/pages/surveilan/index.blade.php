@extends('admin/template-base')

@section('page-title', 'Notifikasi Surveilan')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE --}}
            <div class="d-flex justify-content-between">

                <div class="p-2 bd-highlight">
                    <h3 class="card-header">Notifikasi Surveilan</h3>
                </div>

                {{-- KIRIM NOTIFIKASI BUTTON --}}
                {{-- @if(auth()->user()->hasAnyRole(['ROLE_SUPERVISOR', 'ROLE_OPERATOR', 'ROLE_KANTOR', 'ROLE_PIMPINAN']))
                    <div class="p-2 bd-highlight">
                        <a href="{{ route('surveilan.create-notification') }}"
                           class="btn btn-primary">
                            <i class="bx bx-send me-1"></i>
                            Kirim Notifikasi
                        </a>
                    </div>
                @endif --}}

            </div>

            {{-- SECOND ROW,  FOR DISPLAY PER PAGE AND SEARCH FORM --}}
            <div class="d-flex justify-content-between">

                {{-- OPTION TO SHOW LIST PER PAGE --}}
                <div class="p-2 bd-highlight">
                    @include('admin.components.paginator.perpageform')
                </div>

                {{-- SEARCH FORMS --}}
                <div class="p-2 d-flex align-items-center">
                    <form action="{{ url()->full() }}" method="get" class="d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="form-control border-1 shadow-none bg-light bg-gradient"
                            placeholder="Search..." aria-label="Search..." name="keyword"
                            value="{{ isset($keyword) ? $keyword : '' }}" />
                        <input type="hidden" name="sort_order" value="{{ request()->input('sort_order') }}" />
                        <input type="hidden" name="sort_field" value="{{ request()->input('sort_field') }}" />
                        <input type="hidden" name="per_page" value="{{ request()->input('per_page') }}" />
                    </form>
                </div>

            </div>

            {{-- THIRD ROW, FOR THE MAIN DATA PART --}}
            {{-- //to display any error if any --}}
            @if (isset($alerts))
                @include('admin.components.notification.general', $alerts)
            @endif

            {{-- Display session alerts from redirect --}}
            @if (session('alerts'))
                @include('admin.components.notification.general', ['alerts' => session('alerts')])
            @endif

            <div class="table-responsive text-nowrap">
                <!-- Table data with Striped Rows -->
                <table class="table table-striped table-hover align-middle">

                    {{-- TABLE HEADER --}}
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Nomor</th>
                            <th>Pelaku Usaha</th>
                            <th>Akhir Masa Berlaku</th>
                            <th>Status Notifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>


                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($surveilans as $surveilan)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $surveilan['jenis'] }}</td>
                                <td>{{ $surveilan['nomor'] }}</td>
                                <td>{{ $surveilan['nama_perusahaan'] }}</td>
                                <td>
                                    @php
                                        $expiryDate = \Carbon\Carbon::parse($surveilan['akhir_masa_berlaku']);
                                        $oneMonthFromNow = \Carbon\Carbon::now()->addMonth(config('pengawasan.MAX_MONTH_EXPIRED'));
                                        // Format date with Indonesian month names
                                        $formattedDate = $expiryDate->translatedFormat('d F Y');
                                        $isExpiringSoon = $expiryDate->lessThanOrEqualTo($oneMonthFromNow);
                                    @endphp
                                    <span class="{{ $isExpiringSoon ? 'text-danger' : '' }}">
                                        {{ $expiryDate->translatedFormat('j F Y') }}
                                    </span>
                                </td>
                                <td>
                                    @if($surveilan['has_notification'])
                                        <span class="badge bg-success text-black">
                                            <i class="bx bx-check-circle me-1"></i>
                                            Notifikasi sudah terkirim
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-black">
                                            <i class="bx bx-clock me-1"></i>
                                            Belum ada notifikasi
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{-- KIRIM NOTIFIKASI BUTTON --}}
                                    @if(auth()->user()->hasAnyRole(['ROLE_SUPERVISOR', 'ROLE_OPERATOR', 'ROLE_KANTOR', 'ROLE_PIMPINAN']) && !$surveilan['has_notification'])
                                        <a href="{{ route('surveilan.create-notification-for-business', [
                                           'business_id' => $surveilan['business_id'] ?? null,
                                           'jenis' => $surveilan['jenis'] ?? null,
                                           'nomor' => $surveilan['nomor'] ?? null,
                                           'pelaku_usaha' => $surveilan['nama_perusahaan'] ?? null,
                                           'akhir_masa_berlaku' => $expiryDate->translatedFormat('j F Y') ?? null,
                                           'surveilan_id' => $surveilan['nomor'] ?? null
                                       ]) }}"
                                           class="btn btn-sm btn-primary">
                                            <i class="bx bx-send me-1"></i>
                                            Kirim Notifikasi
                                        </a>
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
                        {{ $surveilans->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
