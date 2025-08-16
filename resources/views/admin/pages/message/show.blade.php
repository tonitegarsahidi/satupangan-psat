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

                <div class="message-container" style="max-height: 500px; overflow-y: auto;">
                    @forelse ($messages as $message)
                        <div class="mb-4 {{ $message->sender_id == Auth::id() ? 'text-end' : '' }}">
                            <div class="d-inline-block p-3 rounded-3 {{ $message->sender_id == Auth::id() ? 'bg-primary text-white' : 'bg-light' }}">
                                <p class="mb-1">{{ $message->message }}</p>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($message->created_at)->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No messages in this thread yet.</p>
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
                    <form action="{{ route('message.sendMessage', $thread->id) }}" method="POST">
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
    {{-- Scroll to bottom of messages on load --}}
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const messageContainer = document.querySelector('.message-container');
            if (messageContainer) {
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }
        });
    </script>
@endsection
