@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail of Workflow')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="card">

            <div class="d-flex justify-content-between">
                <div class="bd-highlight">
                    <h3 class="card-header">Detail of Workflow with id : {{ $data->id }}</h3>
                </div>
            </div>

            <div class="row m-2">
                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" class="bg-dark text-white">Title</th>
                                    <td>{{ $data->title }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Type</th>
                                    <td>{{ $data->type }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Status</th>
                                    <td>{{ $data->status }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Category</th>
                                    <td>{{ $data->category }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Due Date</th>
                                    <td>{{ $data->due_date ? \Carbon\Carbon::parse($data->due_date)->format('Y-m-d') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Is Active</th>
                                    <td>
                                        @if ($data->is_active)
                                            <span class="badge rounded-pill bg-success"> Yes </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger"> No </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Initiator</th>
                                    <td>
                                        @if($data->initiator)
                                            <a href="{{ route('admin.user.detail', ['id' => $data->initiator->id]) }}" target="_blank">
                                                {{ $data->initiator->name }}
                                            </a>
                                        @else
                                            {{ $data->user_id_initiator }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Current Assignee</th>
                                    <td>
                                        @if($data->currentAssignee)
                                            <a href="{{ route('admin.user.detail', ['id' => $data->currentAssignee->id]) }}" target="_blank">
                                                {{ $data->currentAssignee->name }}
                                            </a>
                                        @else
                                            {{ $data->current_assignee_id }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Parent Workflow</th>
                                    <td>{{ $data->parent_id }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Created By</th>
                                    <td>{{ $data->created_by }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Updated By</th>
                                    <td>{{ $data->updated_by }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if (config('constant.CRUD.DISPLAY_TIMESTAMPS'))
                            @include('components.crud-timestamps', $data)
                        @endif
                    </div>
                </div>
            </div>

            <div class="m-4">
                <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>
                <a class="btn btn-primary me-2" href="{{ route('admin.workflow.edit', ['id' => $data->id]) }}"
                    title="update this workflow">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('admin.workflow.delete', ['id' => $data->id]) }}"
                    title="delete workflow">
                    <i class='tf-icons bx bx-trash me-2'></i>Delete</a>
            </div>
        </div>
    </div>
@endsection

@section('footer-code')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
