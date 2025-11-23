@extends('admin/template-base')

@section('page-title', 'List of Business')

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
                    <h3 class="card-header">Data Pelaku Usaha</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('business.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Business
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
                            placeholder="Search nama perusahaan or alamat.." aria-label="Search nama_perusahaan or alamat..." name="keyword"
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
                                    href="{{ route('business.index', [
                                        'sort_field' => 'nama_perusahaan',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Nama Perusahaan
                                    @include('components.arrow-sort', ['field' => 'nama_perusahaan', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('business.index', [
                                        'sort_field' => 'alamat_perusahaan',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Alamat
                                    @include('components.arrow-sort', ['field' => 'alamat_perusahaan', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                Kota
                            </th>
                            <th>
                                Provinsi
                            </th>
                            <th>
                                NIB
                            </th>
                            <th>
                                Status
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
                        @foreach ($businesses as $business)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $business->nama_perusahaan }}</td>
                                <td>{{ $business->alamat_perusahaan }}</td>
                                <td>{{ $business->kota ? $business->kota->nama_kota : '-' }}</td>
                                <td>{{ $business->provinsi ? $business->provinsi->nama_provinsi : '-' }}</td>
                                <td>{{ $business->nib }}</td>
                                <td>
                                    @if ($business->is_active)
                                        <span class="badge rounded-pill bg-success">Aktif</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('business.detail', ['id' => $business->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('business.edit', ['id' => $business->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-xs {{ $business->is_active ? 'btn-danger' : 'btn-success' }}" href="{{ route('business.toggle-status-confirm', ['id' => $business->id]) }}"
                                        title="{{ $business->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class='bx bx-power-off'></i>
                                        {{ $business->is_active ? 'Non Aktifkan' : 'Aktifkan' }}
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
                        {{ $businesses->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
