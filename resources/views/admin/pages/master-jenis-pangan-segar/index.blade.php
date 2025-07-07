@extends('admin/template-base')

@section('page-title', 'List of Jenis Pangan Segar')

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
                    <h3 class="card-header">List of Jenis Pangan Segar</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('admin.master-jenis-pangan-segar.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Jenis Pangan Segar
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
                            placeholder="Search nama jenis pangan segar or kode jenis pangan segar.." aria-label="Search nama_jenis_pangan_segar or kode_jenis_pangan_segar..." name="keyword"
                            value="{{ isset($keyword) ? $keyword : '' }}" />
                        <input type="hidden" nama_jenis_pangan_segar="sort_order" value="{{ request()->input('sort_order') }}" />
                        <input type="hidden" nama_jenis_pangan_segar="sort_field" value="{{ request()->input('sort_field') }}" />
                        <input type="hidden" nama_jenis_pangan_segar="per_page" value="{{ request()->input('per_page') }}" />
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
                                    href="{{ route('admin.master-jenis-pangan-segar.index', [
                                        'sort_field' => 'kode_jenis_pangan_segar',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Kode
                                    @include('components.arrow-sort', ['field' => 'kode_jenis_pangan_segar', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.master-jenis-pangan-segar.index', [
                                        'sort_field' => 'nama_jenis_pangan_segar',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Nama Jenis Pangan Segar
                                    {{-- SORTING ARROW --}}
                                    @include('components.arrow-sort', [
                                        'field' => 'nama_jenis_pangan_segar',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                Kelompok Pangan
                            </th>

                            <th><a
                                    href="{{ route('admin.master-jenis-pangan-segar.index', ['sort_field' => 'is_active', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'keyword' => $keyword]) }}">
                                    Is Active
                                    @include('components.arrow-sort', ['field' => 'is_active', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>


                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($jenisPanganSegars as $jenisPanganSegar)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $jenisPanganSegar->kode_jenis_pangan_segar }}</td>
                                <td>{{ $jenisPanganSegar->nama_jenis_pangan_segar }}</td>
                                <td>{{ $jenisPanganSegar->kelompok->nama_kelompok_pangan }}</td>
                                <td>
                                    @if ($jenisPanganSegar->is_active)
                                        <span class="badge rounded-pill bg-success"> Yes </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger"> No </span>
                                    @endif
                                </td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('admin.master-jenis-pangan-segar.detail', ['id' => $jenisPanganSegar->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.master-jenis-pangan-segar.edit', ['id' => $jenisPanganSegar->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.master-jenis-pangan-segar.delete', ['id' => $jenisPanganSegar->id]) }}"
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
                        {{ $jenisPanganSegars->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>







            </div>
        </div>

    </div>
@endsection
