@extends('admin/template-base')

@section('page-title', 'List of Early Warnings')


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
                    <h3 class="card-header">List of Early Warnings</h3>
                </div>
                @if (auth()->user())
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('early-warning.create') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Early Warning
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
                            placeholder="Search title, content, related product or urgency level.." aria-label="Search title, content, related product or urgency level..." name="keyword"
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
                                    href="{{ route('early-warning.index', [
                                        'sort_field' => 'updated_at',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Tanggal
                                    @include('components.arrow-sort', ['field' => 'updated_at', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('early-warning.index', [
                                        'sort_field' => 'creator_id',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Pembuat
                                    @include('components.arrow-sort', ['field' => 'creator_id', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('early-warning.index', [
                                        'sort_field' => 'title',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Judul
                                    @include('components.arrow-sort', ['field' => 'title', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('early-warning.index', [
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
                                    href="{{ route('early-warning.index', [
                                        'sort_field' => 'urgency_level',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Tingkat Keparahan
                                    @include('components.arrow-sort', ['field' => 'urgency_level', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('early-warning.index', [
                                        'sort_field' => 'related_product',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Produk terkait
                                    @include('components.arrow-sort', ['field' => 'related_product', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            @if (Auth::user())
                            <th></th>
                            <th></th>
                            @endif
                        </tr>
                    </thead>


                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($earlyWarnings as $earlyWarning)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                 <td>{{ \Carbon\Carbon::parse($earlyWarning->updated_at)->format('d-m-Y') }}</td>
                                <td>
                                    @if ($earlyWarning->creator && $earlyWarning->creator->petugas)
                                        <a href="{{ route('petugas.profile.detail', ['userId' => $earlyWarning->creator->petugas->user_id]) }}" class="text-decoration-none">
                                            {{ $earlyWarning->creator->petugas->user->name }}
                                        </a>
                                    @else
                                        {{ $earlyWarning->creator ? $earlyWarning->creator->name : '-' }}
                                    @endif
                                </td>
                                <td style="white-space: normal; word-wrap: break-word;">
                                     <a class="action-icon" href="{{ route('early-warning.detail', ['id' => $earlyWarning->id]) }}"
                                        title="detail">
                                        {{ $earlyWarning->title }}</td>
                                    </a>

                                <td>
                                    @if ($earlyWarning->status == 'Published')
                                        <span class="badge rounded-pill bg-success">{{ $earlyWarning->status }}</span>
                                    @elseif ($earlyWarning->status == 'Approved')
                                        <span class="badge rounded-pill bg-primary">{{ $earlyWarning->status }}</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">{{ $earlyWarning->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($earlyWarning->urgency_level == 'Danger')
                                        <span class="badge rounded-pill bg-danger">{{ $earlyWarning->urgency_level }}</span>
                                    @elseif ($earlyWarning->urgency_level == 'Warning')
                                        <span class="badge rounded-pill bg-warning text-dark">{{ $earlyWarning->urgency_level }}</span>
                                    @else
                                        <span class="badge rounded-pill bg-info text-dark">{{ $earlyWarning->urgency_level }}</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($earlyWarning->related_product, 30) }}</td>


                                {{-- ============ CRUD LINK ICON =============  --}}
                                @if (Auth::user())
                                <td>
                                    @if (
                                        ($earlyWarning->status == 'Draft' && $earlyWarning->creator_id == auth()->id()) ||
                                        ($earlyWarning->status == 'Approved')
                                    )
                                        <a class="action-icon" href="{{ route('early-warning.edit', ['id' => $earlyWarning->id]) }}"
                                            title="edit">
                                            <i class='bx bx-pencil'></i>
                                        </a>
                                    @endif
                                </td>

                                <td>
                                    @if ($earlyWarning->status != 'Published')
                                    <a class="action-icon" href="{{ route('early-warning.delete-confirm', ['id' => $earlyWarning->id]) }}"
                                        title="delete">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                    @endif
                                </td>

                                {{-- Publish button for ROLE_SUPERVISOR and ROLE_LEADER --}}
                                <td>
                                    @if ($earlyWarning->status != 'Published')
                                        <a href="{{ route('early-warning.detail', ['id' => $earlyWarning->id]) . '?publish=true' }}" class="btn btn-sm btn-success" title="Publish">
                                            <i class='bx bx-publish'></i> Publish
                                        </a>
                                    @endif
                                </td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <br />

                <div class="row">
                    <div class="col-md-10 mx-auto">
                        {{ $earlyWarnings->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
