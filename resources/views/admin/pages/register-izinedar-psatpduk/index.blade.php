@extends('admin/template-base')

@section('page-title', 'List of Register Izin EDAR PSATPDUK')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE AND ADD BUTTON --}}
            <div class="d-flex justify-content-between">

                <div class="p-2 bd-highlight">
                    <h3 class="card-header">List of Register Izin EDAR PSATPDUK</h3>
                </div>
                @if (Auth::user()->hasRole('ROLE_USER_BUSINESS'))
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('register-izinedar-psatpduk.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Register Izin EDAR PSATPDUK
                    </a>
                </div>
                @endif

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
                            placeholder="Search nomor SPPB, nomor izin EDAR PL, status, or file names.." aria-label="Search nomor_sppb, nomor_izinedar_pduk, status, or file names..." name="keyword"
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

            <div class="table-responsive text-nowrap">
                <!-- Table data with Striped Rows -->
                <table class="table table-striped table-hover align-middle">

                    {{-- TABLE HEADER --}}
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>
                                <a
                                    href="{{ route('register-izinedar-psatpduk.index', [
                                        'sort_field' => 'nomor_sppb',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Nomor SPPB
                                    @include('components.arrow-sort', ['field' => 'nomor_sppb', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('register-izinedar-psatpduk.index', [
                                        'sort_field' => 'nomor_izinedar_pduk',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Nomor Izin EDAR PL
                                    @include('components.arrow-sort', ['field' => 'nomor_izinedar_pduk', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('register-izinedar-psatpduk.index', [
                                        'sort_field' => 'status',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Status
                                    {{-- SORTING ARROW --}}
                                    @include('components.arrow-sort', [
                                        'field' => 'status',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('register-izinedar-psatpduk.index', [
                                        'sort_field' => 'tanggal_terakhir',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Akhir Masa Berlaku
                                    {{-- SORTING ARROW --}}
                                    @include('components.arrow-sort', [
                                        'field' => 'tanggal_terakhir',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                Komoditas
                            </th>
                            <th>
                                Merk Dagang
                            </th>
                            <th>
                                Nama Unit Usaha
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>


                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($registerIzinedarPsatpduks as $registerIzinedarPsatpduk)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $registerIzinedarPsatpduk->nomor_sppb }}</td>
                                <td>{{ $registerIzinedarPsatpduk->nomor_izinedar_pduk }}</td>
                                <td>
                                    @if ($registerIzinedarPsatpduk->status == 'DISETUJUI')
                                        <span class="badge rounded-pill bg-success">{{ $registerIzinedarPsatpduk->status }}</span>
                                    @elseif ($registerIzinedarPsatpduk->status == 'DITOLAK')
                                        <span class="badge rounded-pill bg-danger">{{ $registerIzinedarPsatpduk->status }}</span>
                                    @elseif ($registerIzinedarPsatpduk->status == 'DIAJUKAN')
                                        <span class="badge rounded-pill bg-info">{{ $registerIzinedarPsatpduk->status }}</span>
                                    @elseif ($registerIzinedarPsatpduk->status == 'DIPERIKSA')
                                        <span class="badge rounded-pill bg-warning">{{ $registerIzinedarPsatpduk->status }}</span>
                                    @else
                                        {{ $registerIzinedarPsatpduk->status }}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $expiryDate = \Carbon\Carbon::parse($registerIzinedarPsatpduk->tanggal_terakhir);
                                        $oneMonthFromNow = \Carbon\Carbon::now()->addMonth();
                                        // Format date with Indonesian month names
                                        $monthNames = [
                                            'January' => 'Januari',
                                            'February' => 'Februari',
                                            'March' => 'Maret',
                                            'April' => 'April',
                                            'May' => 'Mei',
                                            'June' => 'Juni',
                                            'July' => 'Juli',
                                            'August' => 'Agustus',
                                            'September' => 'September',
                                            'October' => 'Oktober',
                                            'November' => 'November',
                                            'December' => 'Desember'
                                        ];
                                        $englishDate = $expiryDate->format('d F Y');
                                        $formattedDate = strtr($englishDate, $monthNames);
                                        $isExpiringSoon = $expiryDate->lessThanOrEqualTo($oneMonthFromNow);
                                    @endphp
                                    <span class="{{ $isExpiringSoon ? 'text-danger' : '' }}">
                                        {{ $expiryDate->translatedFormat('j F Y') }}
                                    </span>
                                </td>
                                <td>{{ $registerIzinedarPsatpduk->nama_komoditas }}</td>
                                <td>{{ $registerIzinedarPsatpduk->merk_dagang }}</td>
                                <td>{{ $registerIzinedarPsatpduk->nama_unitusaha }}</td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('register-izinedar-psatpduk.detail', ['id' => $registerIzinedarPsatpduk->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    @if (Auth::user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR'])
                                        || (Auth::user()->hasAnyRole(['ROLE_USER_BUSINESS']) && $registerIzinedarPsatpduk->status == 'DIAJUKAN'))
                                        <a class="action-icon" href="{{ route('register-izinedar-psatpduk.edit', ['id' => $registerIzinedarPsatpduk->id]) }}"
                                            title="edit">
                                            <i class='bx bx-pencil'></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR']))
                                        <a class="action-icon" href="{{ route('register-izinedar-psatpduk.delete', ['id' => $registerIzinedarPsatpduk->id]) }}"
                                            title="delete">
                                            <i class='bx bx-trash'></i>
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
                        {{ $registerIzinedarPsatpduks->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
