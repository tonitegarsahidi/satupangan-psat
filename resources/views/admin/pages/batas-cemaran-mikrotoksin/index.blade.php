@extends('admin/template-base')

@section('page-title', 'List of Batas Cemaran Mikrotoksin')

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
                    <h3 class="card-header">List of Batas Cemaran Mikrotoksin</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('admin.batas-cemaran-mikrotoksin.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Batas Cemaran Mikrotoksin
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
                            placeholder="Search jenis pangan, cemaran mikrotoksin, satuan, metode..." aria-label="Search" name="keyword"
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
                                    href="{{ route('admin.batas-cemaran-mikrotoksin.index', [
                                        'sort_field' => 'jenisPangan.nama_jenis_pangan',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Jenis Pangan
                                    @include('components.arrow-sort', ['field' => 'jenisPangan.nama_jenis_pangan', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.batas-cemaran-mikrotoksin.index', [
                                        'sort_field' => 'cemaranMikrotoksin.nama_cemaran_mikrotoksin',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Cemaran Mikrotoksin
                                    @include('components.arrow-sort', [
                                        'field' => 'cemaranMikrotoksin.nama_cemaran_mikrotoksin',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.batas-cemaran-mikrotoksin.index', [
                                        'sort_field' => 'value_min',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Min Value
                                    @include('components.arrow-sort', ['field' => 'value_min', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.batas-cemaran-mikrotoksin.index', [
                                        'sort_field' => 'value_max',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Max Value
                                    @include('components.arrow-sort', ['field' => 'value_max', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.batas-cemaran-mikrotoksin.index', [
                                        'sort_field' => 'satuan',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Satuan
                                    @include('components.arrow-sort', ['field' => 'satuan', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.batas-cemaran-mikrotoksin.index', [
                                        'sort_field' => 'metode',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Metode
                                    @include('components.arrow-sort', ['field' => 'metode', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th><a
                                    href="{{ route('admin.batas-cemaran-mikrotoksin.index', ['sort_field' => 'is_active', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'keyword' => $keyword]) }}">
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
                        @foreach ($batasCemaranMikrotoksins as $batasCemaranMikrotoksin)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $batasCemaranMikrotoksin->jenisPangan->nama_jenis_pangan ?? '-' }}</td>
                                <td>{{ $batasCemaranMikrotoksin->cemaranMikrotoksin->nama_cemaran_mikrotoksin ?? '-' }}</td>
                                <td>{{ $batasCemaranMikrotoksin->value_min }}</td>
                                <td>{{ $batasCemaranMikrotoksin->value_max }}</td>
                                <td>{{ $batasCemaranMikrotoksin->satuan }}</td>
                                <td>{{ $batasCemaranMikrotoksin->metode }}</td>
                                <td>
                                    @if ($batasCemaranMikrotoksin->is_active)
                                        <span class="badge rounded-pill bg-success"> Yes </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger"> No </span>
                                    @endif
                                </td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('admin.batas-cemaran-mikrotoksin.detail', ['id' => $batasCemaranMikrotoksin->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.batas-cemaran-mikrotoksin.edit', ['id' => $batasCemaranMikrotoksin->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.batas-cemaran-mikrotoksin.delete', ['id' => $batasCemaranMikrotoksin->id]) }}"
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
                        {{ $batasCemaranMikrotoksins->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
