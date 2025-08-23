@extends('admin/template-base')

@section('page-title', 'List of Pengawasan Rekap')

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
                    <h3 class="card-header">List of Pengawasan Rekap</h3>
                </div>
                @if(auth()->user()->hasRole('ROLE_SUPERVISOR'))
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('pengawasan-rekap.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Pengawasan Rekap
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
                            placeholder="Search recap result or admin..." aria-label="Search recap result or admin..." name="keyword"
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
                                    href="{{ route('pengawasan-rekap.index', [
                                        'sort_field' => 'jenis_psat.nama_jenis_pangan_segar',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Jenis PSAT
                                    @include('components.arrow-sort', ['field' => 'jenis_psat.nama_jenis_pangan_segar', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('pengawasan-rekap.index', [
                                        'sort_field' => 'produk_psat.nama_bahan_pangan_segar',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Nama Produk PSAT
                                    @include('components.arrow-sort', ['field' => 'produk_psat.nama_bahan_pangan_segar', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('pengawasan-rekap.index', [
                                        'sort_field' => 'status',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Status
                                    @include('components.arrow-sort', ['field' => 'status', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>PIC Tindakan</th>
                            <th>
                                <a
                                    href="{{ route('pengawasan-rekap.index', [
                                        'sort_field' => 'updated_at',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Tanggal
                                    @include('components.arrow-sort', ['field' => 'updated_at', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
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
                        @foreach ($pengawasanRekapList as $pengawasanRekap)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>
                                    @if ($pengawasanRekap->jenisPsat)
                                        {{ $pengawasanRekap->jenisPsat->nama_jenis_pangan_segar }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($pengawasanRekap->produkPsat)
                                        {{ $pengawasanRekap->produkPsat->nama_bahan_pangan_segar }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($pengawasanRekap->status == 'DRAFT')
                                        <span class="badge rounded-pill bg-secondary"> {{ $pengawasanRekap->status }} </span>
                                    @elseif ($pengawasanRekap->status == 'PROSES')
                                        <span class="badge rounded-pill bg-warning"> {{ $pengawasanRekap->status }} </span>
                                    @else
                                        <span class="badge rounded-pill bg-success"> {{ $pengawasanRekap->status }} </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($pengawasanRekap->picTindakan)
                                        {{ $pengawasanRekap->picTindakan->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($pengawasanRekap->updated_at)->format('d/m/Y') }}</td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('pengawasan-rekap.detail', ['id' => $pengawasanRekap->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('pengawasan-rekap.edit', ['id' => $pengawasanRekap->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('pengawasan-rekap.delete', ['id' => $pengawasanRekap->id]) }}"
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
                        {{ $pengawasanRekapList->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
