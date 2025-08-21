@extends('admin/template-base')

@section('page-title', 'List of Pengawasan')

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
                    <h3 class="card-header">List of Pengawasan</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('admin.pengawasan.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Pengawasan
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
                            placeholder="Search location address or initiator.." aria-label="Search location address or initiator..." name="keyword"
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
                                    href="{{ route('admin.pengawasan.index', [
                                        'sort_field' => 'lokasi_alamat',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Location Address
                                    @include('components.arrow-sort', [
                                        'field' => 'lokasi_alamat',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.pengawasan.index', [
                                        'sort_field' => 'tanggal_mulai',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Start Date
                                    @include('components.arrow-sort', ['field' => 'tanggal_mulai', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.pengawasan.index', [
                                        'sort_field' => 'status',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Status
                                    @include('components.arrow-sort', ['field' => 'status', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>Initiator</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($pengawasanList as $pengawasan)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $pengawasan->lokasi_alamat }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengawasan->tanggal_mulai)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($pengawasan->status == 'DRAFT')
                                        <span class="badge rounded-pill bg-secondary"> {{ $pengawasan->status }} </span>
                                    @elseif ($pengawasan->status == 'PROSES')
                                        <span class="badge rounded-pill bg-warning"> {{ $pengawasan->status }} </span>
                                    @else
                                        <span class="badge rounded-pill bg-success"> {{ $pengawasan->status }} </span>
                                    @endif
                                </td>
                                <td>{{ $pengawasan->initiator ? $pengawasan->initiator->name : '-' }}</td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('admin.pengawasan.detail', ['id' => $pengawasan->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.pengawasan.edit', ['id' => $pengawasan->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.pengawasan.delete', ['id' => $pengawasan->id]) }}"
                                        title="delete">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <br />

                <div class="row">
                    <div class="col-md-10 mx-auto">
                        {{ $pengawasanList->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
