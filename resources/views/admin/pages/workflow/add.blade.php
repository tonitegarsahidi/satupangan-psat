@extends('admin/template-base')

@section('page-title', 'Add New Workflow')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Workflow</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.workflow.store') }}">
                            @csrf

                            {{-- TITLE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="title">Title*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'title'])
                                    <input type="text" name="title" class="form-control" id="title"
                                        placeholder="e.g., Laporan Kendala" value="{{ old('title', isset($title) ? $title : '') }}">
                                </div>
                            </div>

                            {{-- TYPE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="type">Type*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'type'])
                                    <select name="type" class="form-control" id="type">
                                        @foreach(config('workflow.types') as $type)
                                            <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- STATUS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'status'])
                                    <select name="status" class="form-control" id="status">
                                        @foreach(config('workflow.statuses') as $status)
                                            <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- CATEGORY FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="category">Category</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'category'])
                                    <select name="category" class="form-control" id="category">
                                        <option value="">-- Select Category --</option>
                                        @foreach(config('workflow.categories') as $cat)
                                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- DUE DATE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="due_date">Due Date</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'due_date'])
                                    <input type="date" name="due_date" class="form-control" id="due_date"
                                        value="{{ old('due_date', isset($due_date) ? $due_date : '') }}">
                                </div>
                            </div>

                            {{-- CURRENT ASSIGNEE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="current_assignee_id">Current Assignee*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'current_assignee_id'])
                                    <select class="form-control" id="current_assignee_id" name="current_assignee_id" required>
                                        <option value="">-- Select Current Assignee --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('current_assignee_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- IS_ACTIVE RADIO BUTTONS --}}
                            <div class="row mb-3">
                                @php
                                    $oldIsActive = old('is_active', 1); // Default to 1 (true)
                                @endphp
                                <label class="col-sm-2 col-form-label" for="is_active">Is Active*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'is_active'])
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_true" value="1"
                                            {{ $oldIsActive == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_active_true">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_false" value="0"
                                            {{ $oldIsActive == 0 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="is_active_false">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-code')
    <!-- Select2 JS and CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#current_assignee_id').select2({
                placeholder: 'Search for a current assignee',
                allowClear: true
            });
        });
    </script>
@endsection
