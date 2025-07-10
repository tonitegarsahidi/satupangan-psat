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
                        <input type="text" class="form-control" id="user_id" name="user_id" value="{{ old('user_id', $action->user_id) }}" required>
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
