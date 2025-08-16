@extends('admin/template-base')

@section('page-title', 'Notification Detail')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Notification Detail</h5>
                <a href="{{ route('notification.index') }}" class="btn btn-sm btn-outline-secondary">Back to List</a>
            </div>
            <div class="card-body">
                @if ($notification)
                    <div class="mb-3">
                        <strong>Title:</strong> {{ $notification->title }}
                    </div>
                    <div class="mb-3">
                        <strong>Message:</strong>
                        <p>{{ $notification->message }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Type:</strong> <span class="badge bg-label-info">{{ $notification->type }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong>
                        @if ($notification->is_read)
                            <span class="badge rounded-pill bg-success">Read</span>
                        @else
                            <span class="badge rounded-pill bg-warning">Unread</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Created At:</strong> {{ \Carbon\Carbon::parse($notification->created_at)->format('d M Y H:i') }}
                    </div>
                    @if ($notification->data)
                        <div class="mb-3">
                            <strong>Additional Data:</strong>
                            <pre>{{ json_encode($notification->data, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    @endif
                @else
                    <p>Notification not found.</p>
                @endif
            </div>
        </div>

    </div>
@endsection

@section('footer-code')
    {{-- Any specific JS for this page can go here --}}
@endsection
