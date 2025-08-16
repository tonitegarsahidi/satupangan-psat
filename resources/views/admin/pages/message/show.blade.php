@extends('admin/template-base')

@section('page-title', 'Message Thread Detail')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thread: {{ $thread->title }}</h5>
                <div>
                    <a href="{{ route('message.index') }}" class="btn btn-sm btn-outline-secondary">Back to List</a>
                    @if ($thread->initiator_id == Auth::id() && $thread->participant_id)
                        <a href="#" class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                            New Message
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted">With: {{ $thread->initiator_id == Auth::id() ? $thread->participant->name : $thread->initiator->name }}</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">Started: {{ \Carbon\Carbon::parse($thread->created_at)->format('d M Y H:i') }}</small>
                    </div>
                </div>

                <hr>

                <div class="message-container">
                    @forelse ($messages as $message)
                        <div class="mb-4 border-bottom pb-3 @if($message->sender_id == Auth::id()) bg-success-light @else bg-warning-light @endif">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        @if($message->sender && $message->sender->profile && $message->sender->profile->profile_picture)
                                            <img src="{{ asset($message->sender->profile->profile_picture) }}" alt="Avatar" class="rounded-circle">
                                        @else
                                            <div class="avatar-placeholder bg-primary text-white d-flex align-items-center justify-content-center rounded-circle">
                                                {{ substr($message->sender->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $message->sender->name }}</h6>
                                        <small class="text-muted">{{ $message->sender->email ?? '' }}</small>
                                    </div>
                                </div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($message->created_at)->format('d M Y H:i') }}</small>
                            </div>
                            <div class="ms-4">
                                <p class="mb-0">{{ $message->message }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-envelope-open text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted">No messages in this thread yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- New Message Modal --}}
    @if ($thread->initiator_id == Auth::id() && $thread->participant_id)
        <div class="modal fade" id="newMessageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send New Message</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('message.send', $thread->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <textarea name="message" class="form-control" rows="5" placeholder="Type your message here..." required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('footer-code')
    {{-- Add some styling for the message thread --}}
    <style>
        .message-container {
            max-height: 600px;
            overflow-y: auto;
        }
        .avatar {
            width: 40px;
            height: 40px;
        }
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .avatar-placeholder {
            width: 40px;
            height: 40px;
            font-size: 16px;
            font-weight: 600;
        }
        .bg-success-light {
            background-color: rgba(40, 167, 69, 0.1);
        }
        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.1);
        }
    </style>
@endsection
