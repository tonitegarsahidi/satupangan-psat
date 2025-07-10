@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Delete Workflow Thread')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h3 class="card-header">Delete Workflow Thread</h3>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.workflow-thread.destroy', ['id' => $thread->id]) }}">
                    @csrf
                    @method('DELETE')
                    <p>Are you sure you want to delete this thread?</p>
                    <ul>
                        <li><b>Message:</b> {{ $thread->message }}</li>
                        <li><b>User:</b> {{ $thread->user_id }}</li>
                    </ul>
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
