@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Add Workflow Thread')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h3 class="card-header">Add Workflow Thread</h3>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.workflow-thread.store') }}">
                    @csrf
                    <input type="hidden" name="workflow_id" value="{{ $workflow_id }}">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">-- Select User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_internal" name="is_internal" value="1"
                            {{ old('is_internal') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_internal">Internal Thread</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Thread</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer-code')
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
