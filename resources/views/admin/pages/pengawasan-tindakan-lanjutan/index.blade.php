@extends('admin/template-base')

@section('page-title', 'List of Pengawasan Tindakan Lanjutan')

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
                    <h3 class="card-header">List of Pengawasan Tindakan Lanjutan</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('pengawasan-tindakan-lanjutan.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Pengawasan Tindakan Lanjutan
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
                            placeholder="Search follow-up action or PIC.." aria-label="Search follow-up action or PIC..." name="keyword"
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

            <div class="table-responsive">
                <!-- Table data with Striped Rows -->
                <table class="table table-striped table-hover align-middle">

                    {{-- TABLE HEADER --}}
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="min-width: 120px;">PIC</th>
                            <th style="min-width: 180px;">
                                <a
                                    href="{{ route('pengawasan-tindakan-lanjutan.index', [
                                        'sort_field' => 'tindakan.pimpinan.name',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Penanggung Jawab
                                    @include('components.arrow-sort', ['field' => 'tindakan.pimpinan.name', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th style="min-width: 200px; word-wrap: break-word;">
                                <a
                                    href="{{ route('pengawasan-tindakan-lanjutan.index', [
                                        'sort_field' => 'arahan_tindak_lanjut',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Arah Tindak Lanjut
                                    @include('components.arrow-sort', ['field' => 'arahan_tindak_lanjut', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th style="width: 80px;">
                                <a
                                    href="{{ route('pengawasan-tindakan-lanjutan.index', [
                                        'sort_field' => 'status',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Status
                                    @include('components.arrow-sort', ['field' => 'status', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th style="width: 80px;">
                                <a
                                    href="{{ route('pengawasan-tindakan-lanjutan.index', [
                                        'sort_field' => 'updated_at',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Tanggal
                                    @include('components.arrow-sort', ['field' => 'updated_at', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th style="width: 40px;"></th>
                            <th style="width: 40px;"></th>
                            <th style="width: 40px;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($pengawasanTindakanLanjutanList as $pengawasanTindakanLanjutan)
                            <tr>
                                <td style="width: 50px;">{{ $startNumber++ }}</td>
                                <td style="min-width: 120px;">
                                    @if ($pengawasanTindakanLanjutan->pic)
                                        <a href="{{ route('petugas.profile.detail', ['userId' => $pengawasanTindakanLanjutan->pic->id]) }}"
                                           class="text-primary text-decoration-none">
                                            {{ $pengawasanTindakanLanjutan->pic->name }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="max-width: 280px;">
                                    {{-- {{dd($pengawasanTindakanLanjutan->tindakan->pimpinan)}} --}}
                                    @if ($pengawasanTindakanLanjutan->tindakan && $pengawasanTindakanLanjutan->tindakan->pimpinan)
                                        <a href="{{ route('petugas.profile.detail', ['userId' => $pengawasanTindakanLanjutan->tindakan->pimpinan->id]) }}"
                                           class="text-primary text-decoration-none">

                                            {{ $pengawasanTindakanLanjutan->tindakan->pimpinan->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td style="max-width: 280px; word-wrap: break-word;">{{ $pengawasanTindakanLanjutan->arahan_tindak_lanjut ?: '-' }}</td>
                                <td style="width: 80px;">
                                    <span class="badge rounded-pill bg-info">{{ $pengawasanTindakanLanjutan->getStatusLabel() }}</span>
                                </td>
                                <td style="width: 80px;">{{ \Carbon\Carbon::parse($pengawasanTindakanLanjutan->updated_at)->format('d/m/Y') }}</td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td style="width: 40px;">
                                    <a class="action-icon" href="{{ route('pengawasan-tindakan-lanjutan.detail', ['id' => $pengawasanTindakanLanjutan->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td style="width: 40px;">
                                    <a class="action-icon" href="{{ route('pengawasan-tindakan-lanjutan.edit', ['id' => $pengawasanTindakanLanjutan->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td style="width: 40px;">
                                    <a class="action-icon" href="{{ route('pengawasan-tindakan-lanjutan.delete', ['id' => $pengawasanTindakanLanjutan->id]) }}"
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
                        {{ $pengawasanTindakanLanjutanList->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
