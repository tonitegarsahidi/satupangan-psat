@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Delete Workflow Action')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h3 class="card-header">Delete Workflow Action</h3>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.workflow-action.destroy', ['id' => $data->id]) }}">
                    @csrf
                    @method('DELETE')
                    <p>Are you sure you want to delete this action?</p>
                    <ul>
                        <li><b>Action:</b> {{ $data->action }}</li>
                        <li><b>User:</b> {{ $data->user_id }}</li>
                        <li><b>Note:</b> {{ $data->note }}</li>
                    </ul>
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
