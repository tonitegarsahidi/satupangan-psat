@extends('admin/template-base')

@section('page-title', 'List of Register Izin EDAR PSATPL')

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
                    <h3 class="card-header">List of Register Izin EDAR PSATPL</h3>
                </div>
                @if (Auth::user()->hasRole('ROLE_USER_BUSINESS'))
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('register-izinedar-psatpl.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Register Izin EDAR PSATPL
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
                            placeholder="Search nomor SPPB, nomor izin EDAR PL, status, or file names.." aria-label="Search nomor_sppb, nomor_izinedar_pl, status, or file names..." name="keyword"
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
                                    href="{{ route('register-izinedar-psatpl.index', [
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
                                    href="{{ route('register-izinedar-psatpl.index', [
                                        'sort_field' => 'nomor_izinedar_pl',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Nomor Izin EDAR PL
                                    @include('components.arrow-sort', ['field' => 'nomor_izinedar_pl', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('register-izinedar-psatpl.index', [
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
                                    href="{{ route('register-izinedar-psatpl.index', [
                                        'sort_field' => 'updated_at',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Akhir Masa Berlaku
                                    {{-- SORTING ARROW --}}
                                    @include('components.arrow-sort', [
                                        'field' => 'updated_at',
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
                        @foreach ($registerIzinedarPsatpls as $registerIzinedarPsatpl)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $registerIzinedarPsatpl->nomor_sppb }}</td>
                                <td>{{ $registerIzinedarPsatpl->nomor_izinedar_pl }}</td>
                                <td>
                                    @if ($registerIzinedarPsatpl->status == 'DISETUJUI')
                                        <span class="badge rounded-pill bg-success">{{ $registerIzinedarPsatpl->status }}</span>
                                    @elseif ($registerIzinedarPsatpl->status == 'DITOLAK')
                                        <span class="badge rounded-pill bg-danger">{{ $registerIzinedarPsatpl->status }}</span>
                                    @elseif ($registerIzinedarPsatpl->status == 'DIAJUKAN')
                                        <span class="badge rounded-pill bg-info">{{ $registerIzinedarPsatpl->status }}</span>
                                    @elseif ($registerIzinedarPsatpl->status == 'DIPERIKSA')
                                        <span class="badge rounded-pill bg-warning">{{ $registerIzinedarPsatpl->status }}</span>
                                    @else
                                        {{ $registerIzinedarPsatpl->status }}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $expiryDate = \Carbon\Carbon::parse($registerIzinedarPsatpl->updated_at);
                                        $oneMonthFromNow = \Carbon\Carbon::now()->addMonth();
                                        $isExpiringSoon = $expiryDate->lessThanOrEqualTo($oneMonthFromNow);
                                    @endphp
                                    <span class="{{ $isExpiringSoon ? 'text-danger' : '' }}">
                                        {{ $expiryDate->translatedFormat('j F Y') }}
                                    </span>
                                </td>
                                <td>{{ $registerIzinedarPsatpl->nama_komoditas }}</td>
                                <td>{{ $registerIzinedarPsatpl->merk_dagang }}</td>
                                <td>{{ $registerIzinedarPsatpl->nama_unitusaha }}</td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('register-izinedar-psatpl.detail', ['id' => $registerIzinedarPsatpl->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    @if (Auth::user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR'])
                                        || (Auth::user()->hasAnyRole(['ROLE_USER_BUSINESS']) && $registerIzinedarPsatpl->status == 'DIAJUKAN'))
                                        <a class="action-icon" href="{{ route('register-izinedar-psatpl.edit', ['id' => $registerIzinedarPsatpl->id]) }}"
                                            title="edit">
                                            <i class='bx bx-pencil'></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR']))
                                        <a class="action-icon" href="{{ route('register-izinedar-psatpl.delete', ['id' => $registerIzinedarPsatpl->id]) }}"
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
                        {{ $registerIzinedarPsatpls->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
