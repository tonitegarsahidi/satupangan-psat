@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Workflow History')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="card">
            <div class="d-flex justify-content-between">
                <div class="bd-highlight">
                    <h3 class="card-header">Workflow History: {{ $workflow->title }}</h3>
                </div>
            </div>
                <div class="m-4">
                    <a class="btn btn-success me-2" href="{{ route('admin.workflow-action.add', ['workflow_id' => $workflow->id]) }}"
                        title="Add Workflow Action">
                        <i class='tf-icons bx bx-plus me-2'></i>Add Workflow Action
                    </a>
                    <a class="btn btn-info me-2" href="{{ route('admin.workflow-thread.add', ['workflow_id' => $workflow->id]) }}"
                        title="Add Workflow Thread">
                        <i class='tf-icons bx bx-plus me-2'></i>Add Workflow Thread
                    </a>
                </div>

            <div class="row m-2">
                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" class="bg-dark text-white">Title</th>
                                    <td>{{ $workflow->title }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Type</th>
                                    <td>{{ $workflow->type }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Status</th>
                                    <td>{{ $workflow->status }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Category</th>
                                    <td>{{ $workflow->category }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Due Date</th>
                                    <td>{{ $workflow->due_date ? \Carbon\Carbon::parse($workflow->due_date)->format('Y-m-d') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Is Active</th>
                                    <td>
                                        @if ($workflow->is_active)
                                            <span class="badge rounded-pill bg-success"> Yes </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger"> No </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Attachments</th>
                                    <td>
                                        @if($workflow->attachments && count($workflow->attachments) > 0)
                                            <ul>
                                                @foreach($workflow->attachments as $attachment)
                                                    <li>
                                                        <a href="{{ asset($attachment->file_path) }}" target="_blank">
                                                            {{ $attachment->file_name ?? basename($attachment->file_path) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <hr>
            <div class="m-4">
                <h4>Workflow Actions & Threads (Chronological)</h4>
                <div class="timeline">
                    @forelse($historyItems as $item)
                        <div class="row align-items-stretch mb-3">
                            <div class="col-md-3 text-end pe-0">
                                <div class="bg-light border rounded p-2 h-100 d-flex flex-column justify-content-center">
                                    <span class="fw-bold text-primary">
                                        {{ $item['data']->created_at ? \Carbon\Carbon::parse($item['data']->created_at)->format('d F Y - H:i') : '' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-9 ps-0">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>
                                                @if($item['type'] === 'action')
                                                    <span class="badge bg-info text-dark me-2"><i class="bx bx-bolt"></i> Action</span>
                                                @else
                                                    <span class="badge bg-warning text-dark me-2"><i class="bx bx-message"></i> Thread</span>
                                                @endif
                                            </span>
                                            <span>
                                                @if($item['type'] === 'action')
                                                    <a href="{{ route('admin.workflow-action.edit', ['id' => $item['data']->id]) }}" class="text-primary me-2" title="Edit"><i class="bx bx-edit"></i></a>
                                                    <a href="{{ route('admin.workflow-action.delete', ['id' => $item['data']->id]) }}" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                                @else
                                                    <a href="{{ route('admin.workflow-thread.edit', ['id' => $item['data']->id]) }}" class="text-primary me-2" title="Edit"><i class="bx bx-edit"></i></a>
                                                    <a href="{{ route('admin.workflow-thread.delete', ['id' => $item['data']->id]) }}" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                                @endif
                                            </span>
                                        </div>
                                        <div>
                                            @if($item['type'] === 'action')
                                                <b>Action Type:</b>
                                                @php
                                                    $actionType = $item['data']->action_type ?? null;
                                                    $actionTypeLabel = $actionType && config('workflow.action_types') && isset(config('workflow.action_types')[$actionType])
                                                        ? config('workflow.action_types')[$actionType]
                                                        : $actionType;
                                                @endphp
                                                {{ $actionTypeLabel ?? '-' }}<br>
                                                <b>By:</b>
                                                @if($item['data']->user && $item['data']->user->name)
                                                    <a href="{{ route('admin.user.detail', ['id' => $item['data']->user->id]) }}" target="_blank">
                                                        {{ $item['data']->user->name }}
                                                    </a>
                                                @else
                                                    {{ $item['data']->user_id ?? '-' }}
                                                @endif
                                                <br>
                                                <b>Note:</b> {{ $item['data']->notes ?? '-' }}
                                            @else
                                                <b>Thread:</b> {{ $item['data']->message ?? '-' }}<br>
                                                <b>By:</b>
                                                @if($item['data']->user && $item['data']->user->name)
                                                    <a href="{{ route('admin.user.detail', ['id' => $item['data']->user->id]) }}" target="_blank">
                                                        {{ $item['data']->user->name }}
                                                    </a>
                                                @else
                                                    {{ $item['data']->user_id ?? '-' }}
                                                @endif
                                            @endif
                                        </div>
                                        @if($item['data']->attachments && count($item['data']->attachments) > 0)
                                            <div class="mt-2">
                                                <b>Attachments:</b>
                                                <ul>
                                                    @foreach($item['data']->attachments as $attachment)
                                                        <li>
                                                            <a href="{{ asset($attachment->file_path) }}" target="_blank">
                                                                {{ $attachment->file_name ?? basename($attachment->file_path) }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">No actions or threads found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
