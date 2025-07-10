@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Workflow Threads')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE AND ADD BUTTON --}}
            <div class="d-flex justify-content-between">
                <div class="p-2 bd-highlight">
                    <h3 class="card-header">List of Workflow Threads</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="#">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Thread
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
                            placeholder="Search message, user..." aria-label="Search message, user..." name="keyword"
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
                                <a href="{{ route('admin.workflow-thread.index', [
                                    'sort_field' => 'message',
                                    'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                    'keyword' => $keyword,
                                ]) }}">
                                    Message
                                    @include('components.arrow-sort', ['field' => 'message', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>Workflow Title</th>
                            <th>User</th>
                            <th>Is Internal</th>
                            <th>Created At</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($threads as $thread)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td style="white-space: pre-line; word-break: break-word; max-width: 200px;">{{ $thread->message }}</td>
                                <td style="white-space: pre-line; word-break: break-word; max-width: 200px;">
                                    @if($thread->workflow && $thread->workflow->title)
                                        {{ $thread->workflow->title }}
                                    @else
                                        -
                                    @endif
                                </td>
                                    @if($thread->user && $thread->user->name)
                                        <a href="{{ route('admin.user.detail', ['id' => $thread->user->id]) }}" target="_blank" style="word-break: break-word;">
                                            {{ $thread->user->name }}
                                        </a>
                                    @else
                                        <span style="word-break: break-word;">{{ $thread->user_id }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($thread->is_internal)
                                        <span class="badge rounded-pill bg-info">Internal</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">External</span>
                                    @endif
                                </td>
                                <td style="white-space: pre-line; word-break: break-word; max-width: 120px;">{{ $thread->created_at ? \Carbon\Carbon::parse($thread->created_at)->format('Y-m-d H:i') : '-' }}</td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.workflow-thread.edit', ['id' => $thread->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.workflow-thread.delete', ['id' => $thread->id]) }}"
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
                        {{ $threads->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
