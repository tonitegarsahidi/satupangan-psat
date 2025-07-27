@extends('admin/template-base')

@section('page-title', 'List of Register SPPB')

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
                    <h3 class="card-header">List of Register SPPB</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('register-sppb.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Register SPPB
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
                            placeholder="Search nomor registrasi or status.." aria-label="Search nomor_registrasi or status..." name="keyword"
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
                                    href="{{ route('register-sppb.index', [
                                        'sort_field' => 'nomor_registrasi',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Nomor Registrasi
                                    @include('components.arrow-sort', ['field' => 'nomor_registrasi', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('register-sppb.index', [
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
                                Komoditas
                            </th>
                            <th>
                                Nama Penanganan
                            </th>
                            <th>
                                Penanganan Keterangan
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
                        @foreach ($registerSppbs as $registerSppb)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $registerSppb->nomor_registrasi }}</td>
                                <td>
                                    @if ($registerSppb->status == config('workflow.sppb_statuses.DISETUJUI'))
                                        <span class="badge rounded-pill bg-success">{{ $registerSppb->status }}</span>
                                    @elseif ($registerSppb->status == config('workflow.sppb_statuses.DITOLAK'))
                                        <span class="badge rounded-pill bg-danger">{{ $registerSppb->status }}</span>
                                    @elseif ($registerSppb->status == config('workflow.sppb_statuses.DIAJUKAN'))
                                        <span class="badge rounded-pill bg-info">{{ $registerSppb->status }}</span>
                                    @elseif ($registerSppb->status == config('workflow.sppb_statuses.DIPERIKSA'))
                                        <span class="badge rounded-pill bg-warning">{{ $registerSppb->status }}</span>
                                    @else
                                        {{ $registerSppb->status }}
                                    @endif
                                </td>
                                <td>{{ $registerSppb->nama_komoditas }}</td>
                                <td>{{ $registerSppb->penanganan->nama_penanganan }}</td>
                                <td>{{ $registerSppb->penanganan_keterangan }}</td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('register-sppb.detail', ['id' => $registerSppb->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('register-sppb.edit', ['id' => $registerSppb->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('register-sppb.delete', ['id' => $registerSppb->id]) }}"
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
                        {{ $registerSppbs->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
