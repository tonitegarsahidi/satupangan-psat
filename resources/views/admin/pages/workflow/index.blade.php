@extends('admin/template-base')

@section('page-title', 'List of Workflows')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE AND ADD BUTTON --}}
            <div class="d-flex justify-content-between">
                <div class="p-2 bd-highlight">
                    <h3 class="card-header">List of Workflows</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('admin.workflow.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Workflow
                    </a>
                </div>
            </div>

            {{-- SECOND ROW,  FOR DISPLAY PER PAGE AND SEARCH FORM --}}
            <div class="d-flex justify-content-between">
                <div class="p-2 bd-highlight">
                    @include('admin.components.paginator.perpageform')
                </div>
                <div class="p-2 d-flex align-items-center">
                    <form action="{{ url()->full() }}" method="get" class="d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="form-control border-1 shadow-none bg-light bg-gradient"
                            placeholder="Search title, type, status, category..." aria-label="Search title, type, status, category..." name="keyword"
                            value="{{ isset($keyword) ? $keyword : '' }}" />
                        <input type="hidden" name="sort_order" value="{{ request()->input('sort_order') }}" />
                        <input type="hidden" name="sort_field" value="{{ request()->input('sort_field') }}" />
                        <input type="hidden" name="per_page" value="{{ request()->input('per_page') }}" />
                    </form>
                </div>
            </div>

            {{-- ALERTS --}}
            @if (isset($alerts))
                @include('admin.components.notification.general', $alerts)
            @endif

            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>
                                <a href="{{ route('admin.workflow.index', [
                                    'sort_field' => 'title',
                                    'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                    'keyword' => $keyword,
                                ]) }}">
                                    Title
                                    @include('components.arrow-sort', ['field' => 'title', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Due Date</th>
                            <th>Is Active</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($workflows as $workflow)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $workflow->title }}</td>
                                <td>{{ $workflow->type }}</td>
                                <td>{{ $workflow->status }}</td>
                                <td>{{ $workflow->category }}</td>
                                <td>{{ $workflow->due_date ? \Carbon\Carbon::parse($workflow->due_date)->format('Y-m-d') : '-' }}</td>
                                <td>
                                    @if ($workflow->is_active)
                                        <span class="badge rounded-pill bg-success"> Yes </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger"> No </span>
                                    @endif
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.workflow.detail', ['id' => $workflow->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.workflow.edit', ['id' => $workflow->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.workflow.delete', ['id' => $workflow->id]) }}"
                                        title="delete">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <div class="row">
                    <div class="col-md-10 mx-auto">
                        {{ $workflows->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
