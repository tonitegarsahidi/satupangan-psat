@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Edit Workflow Action')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h3 class="card-header">Edit Workflow Action</h3>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.workflow-action.update', ['id' => $action->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="action" class="form-label">Action</label>
                        <select class="form-control" id="action" name="action" required>
                            <option value="">-- Select Action --</option>
                            @foreach(config('workflow.action_types', []) as $key => $label)
                                <option value="{{ $key }}" {{ old('action', $action->action) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">-- Select User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $action->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note">{{ old('note', $action->note) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                </form>
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
            $('#user_id').select2({
                placeholder: 'Search for a user',
                allowClear: true
            });
        });
    </script>
@endsection
