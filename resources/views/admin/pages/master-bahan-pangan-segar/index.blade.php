@extends('admin/template-base')

@section('page-title', 'List of Bahan Pangan Segar')

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
                    <h3 class="card-header">List of Bahan Pangan Segar</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('admin.master-bahan-pangan-segar.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Bahan Pangan Segar
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
                            placeholder="Search nama bahan pangan segar or kode bahan pangan segar.." aria-label="Search nama_bahan_pangan_segar or kode_bahan_pangan_segar..." name="keyword"
                            value="{{ isset($keyword) ? $keyword : '' }}" />
                        <input type="hidden" nama_bahan_pangan_segar="sort_order" value="{{ request()->input('sort_order') }}" />
                        <input type="hidden" nama_bahan_pangan_segar="sort_field" value="{{ request()->input('sort_field') }}" />
                        <input type="hidden" nama_bahan_pangan_segar="per_page" value="{{ request()->input('per_page') }}" />
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
                                    href="{{ route('admin.master-bahan-pangan-segar.index', [
                                        'sort_field' => 'kode_bahan_pangan_segar',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Kode
                                    @include('components.arrow-sort', ['field' => 'kode_bahan_pangan_segar', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th style="max-width:250px;">
                                <a
                                    href="{{ route('admin.master-bahan-pangan-segar.index', [
                                        'sort_field' => 'nama_bahan_pangan_segar',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Nama Bahan Pangan Segar
                                    {{-- SORTING ARROW --}}
                                    @include('components.arrow-sort', [
                                        'field' => 'nama_bahan_pangan_segar',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                Jenis Pangan Segar
                            </th>

                            <th><a
                                    href="{{ route('admin.master-bahan-pangan-segar.index', ['sort_field' => 'is_active', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc', 'keyword' => $keyword]) }}">
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
                        @foreach ($bahanPanganSegars as $bahanPanganSegar)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $bahanPanganSegar->kode_bahan_pangan_segar }}</td>
                                <td style="max-width:250px; white-space:normal; word-break:break-word;">
                                    {{ $bahanPanganSegar->nama_bahan_pangan_segar }}
                                </td>
                                <td>{{ $bahanPanganSegar->jenis->nama_jenis_pangan_segar }}</td>
                                <td>
                                    @if ($bahanPanganSegar->is_active)
                                        <span class="badge rounded-pill bg-success"> Yes </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger"> No </span>
                                    @endif
                                </td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('admin.master-bahan-pangan-segar.detail', ['id' => $bahanPanganSegar->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.master-bahan-pangan-segar.edit', ['id' => $bahanPanganSegar->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.master-bahan-pangan-segar.delete', ['id' => $bahanPanganSegar->id]) }}"
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
                        {{ $bahanPanganSegars->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>







            </div>
        </div>

    </div>
@endsection
