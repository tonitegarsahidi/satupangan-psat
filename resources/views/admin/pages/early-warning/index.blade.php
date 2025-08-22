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
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('early-warning.create') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Early Warning
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
                                        'sort_field' => 'title',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Title
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
                                    Urgency Level
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
                                    Related Product
                                    @include('components.arrow-sort', ['field' => 'related_product', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
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
                        @foreach ($earlyWarnings as $earlyWarning)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ Str::limit($earlyWarning->title, 50) }}</td>
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
                                <td>
                                    <a class="action-icon" href="{{ route('early-warning.detail', ['id' => $earlyWarning->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('early-warning.edit', ['id' => $earlyWarning->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('early-warning.delete-confirm', ['id' => $earlyWarning->id]) }}"
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
                        {{ $earlyWarnings->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
