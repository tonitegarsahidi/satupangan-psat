@extends('admin/template-base')

@section('page-title', 'List of QR Badan Pangan')

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
                    <h3 class="card-header">List of QR Badan Pangan</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('qr-badan-pangan.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New QR Badan Pangan
                    </a>
                </div>

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
                            placeholder="Search QR code, komoditas, merk dagang, or status.." aria-label="Search qr_code, nama_komoditas, merk_dagang, or status.." name="keyword"
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
                                    href="{{ route('qr-badan-pangan.index', [
                                        'sort_field' => 'qr_code',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    QR Code
                                    @include('components.arrow-sort', ['field' => 'qr_code', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('qr-badan-pangan.index', [
                                        'sort_field' => 'nama_komoditas',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Komoditas
                                    @include('components.arrow-sort', ['field' => 'nama_komoditas', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('qr-badan-pangan.index', [
                                        'sort_field' => 'merk_dagang',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Merk Dagang
                                    @include('components.arrow-sort', ['field' => 'merk_dagang', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('qr-badan-pangan.index', [
                                        'sort_field' => 'status',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Status
                                    @include('components.arrow-sort', ['field' => 'status', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                Current Assignee
                            </th>
                            <th>
                                Published
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
                        @foreach ($qrBadanPangans as $qrBadanPangan)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $qrBadanPangan->qr_code }}</td>
                                <td>{{ $qrBadanPangan->nama_komoditas }}</td>
                                <td>{{ $qrBadanPangan->merk_dagang }}</td>
                                <td>
                                    @if ($qrBadanPangan->status == 'approved')
                                        <span class="badge rounded-pill bg-success">{{ $qrBadanPangan->status }}</span>
                                    @elseif ($qrBadanPangan->status == 'rejected')
                                        <span class="badge rounded-pill bg-danger">{{ $qrBadanPangan->status }}</span>
                                    @elseif ($qrBadanPangan->status == 'pending')
                                        <span class="badge rounded-pill bg-info">{{ $qrBadanPangan->status }}</span>
                                    @elseif ($qrBadanPangan->status == 'reviewed')
                                        <span class="badge rounded-pill bg-warning">{{ $qrBadanPangan->status }}</span>
                                    @else
                                        {{ $qrBadanPangan->status }}
                                    @endif
                                </td>
                                <td>{{ $qrBadanPangan->currentAssignee ? $qrBadanPangan->currentAssignee->name : '-' }}</td>
                                <td>
                                    @if ($qrBadanPangan->is_published)
                                        <span class="badge rounded-pill bg-success">Yes</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">No</span>
                                    @endif
                                </td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('qr-badan-pangan.detail', ['id' => $qrBadanPangan->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    @if (Auth::user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR'])
                                        || (Auth::user()->hasAnyRole(['ROLE_USER_BUSINESS']) && $qrBadanPangan->status == 'pending'))
                                        <a class="action-icon" href="{{ route('qr-badan-pangan.edit', ['id' => $qrBadanPangan->id]) }}"
                                            title="edit">
                                            <i class='bx bx-pencil'></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->hasAnyRole(['ROLE_OPERATOR', 'ROLE_SUPERVISOR']))
                                        <a class="action-icon" href="{{ route('qr-badan-pangan.delete', ['id' => $qrBadanPangan->id]) }}"
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
                        {{ $qrBadanPangans->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
