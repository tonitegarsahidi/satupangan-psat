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
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">Title</th>
                                <td>{{ $notification->title }}</td>
                            </tr>
                            <tr>
                                <th>Message</th>
                                <td>{!! $notification->message !!}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td><span class="badge bg-label-info">{{ $notification->type }}</span></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($notification->is_read)
                                        <span class="badge rounded-pill bg-success">Read</span>
                                    @else
                                        <span class="badge rounded-pill bg-warning">Unread</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat pada</th>
                                <td>{{ \Carbon\Carbon::parse($notification->created_at)->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>
                                    Additional Data
                                    <button class="btn btn-sm btn-outline-primary ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#additionalDataCollapse" aria-expanded="false" aria-controls="additionalDataCollapse">
                                        <i class='bx bx-show me-1'></i> Show/Hide
                                    </button>
                                </th>
                                <td>
                                    <div class="collapse" id="additionalDataCollapse">
                                        @if ($notification->data && count($notification->data) > 0)
                                            <pre>{{ json_encode($notification->data, JSON_PRETTY_PRINT) }}</pre>
                                            @if (isset($notification->data['link']) && !empty($notification->data['link']))
                                                <a href="{{ $notification->data['link'] }}" target="_blank" class="btn btn-primary mt-2">
                                                    Lihat Tautan
                                                </a>
                                            @endif
                                        @else
                                            <p>No additional data available.</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
