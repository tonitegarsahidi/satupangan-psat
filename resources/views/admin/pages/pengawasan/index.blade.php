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
                @php
                    $user = Auth::user();
                @endphp
                @if ($user->hasAnyRole(['ROLE_KANTOR', 'ROLE_SUPERVISOR']))
                    <div class="p-2">
                        <a class="btn btn-primary" href="{{ route('pengawasan.add') }}">
                            <span class="tf-icons bx bx-plus"></span>&nbsp;
                            Add New Pengawasan
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
                                    href="{{ route('pengawasan.index', [
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
                                    href="{{ route('pengawasan.index', [
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
                                    href="{{ route('pengawasan.index', [
                                        'sort_field' => 'lokasi_provinsi.nama_provinsi',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Provinsi
                                    @include('components.arrow-sort', ['field' => 'lokasi_provinsi.nama_provinsi', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('pengawasan.index', [
                                        'sort_field' => 'lokasi_kota.nama_kota',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Kota
                                    @include('components.arrow-sort', ['field' => 'lokasi_kota.nama_kota', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>Alamat</th>
                            <th>
                                <a
                                    href="{{ route('pengawasan.index', [
                                        'sort_field' => 'status',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Status
                                    @include('components.arrow-sort', ['field' => 'status', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('pengawasan.index', [
                                        'sort_field' => 'tanggal_selesai',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Tanggal Selesai
                                    @include('components.arrow-sort', ['field' => 'tanggal_selesai', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
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
                        @foreach ($pengawasanList as $pengawasan)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>
                                    @if ($pengawasan->jenisPsat)
                                        {{ $pengawasan->jenisPsat->nama_jenis_pangan_segar }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($pengawasan->produkPsat)
                                        {{ $pengawasan->produkPsat->nama_bahan_pangan_segar }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($pengawasan->lokasiProvinsi)
                                        {{ $pengawasan->lokasiProvinsi->nama_provinsi }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($pengawasan->lokasiKota)
                                        {{ $pengawasan->lokasiKota->nama_kota }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $pengawasan->lokasi_alamat }}</td>
                                <td>
                                    @php
                                        $statusClass = $pengawasan->status === 'SELESAI' ? 'success' : ($pengawasan->status === 'PROSES' ? 'warning' : 'secondary');
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ $pengawasan->status }}

                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($pengawasan->tanggal_selesai)->format('d/m/Y') }}</td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('pengawasan.detail', ['id' => $pengawasan->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    @php
                                        $user = Auth::user();
                                        $canEdit = $user->hasRole('ROLE_LEADER') || $user->hasRole('ROLE_KANTOR') || $pengawasan->created_by == $user->id;
                                    @endphp
                                    @if ($canEdit)
                                        <a class="action-icon" href="{{ route('pengawasan.edit', ['id' => $pengawasan->id]) }}"
                                            title="edit">
                                            <i class='bx bx-pencil'></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('pengawasan.delete', ['id' => $pengawasan->id]) }}"
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
