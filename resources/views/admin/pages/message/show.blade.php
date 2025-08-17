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

        {{-- Reply Form --}}
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Reply to Thread</h5>
            </div>
            <div class="card-body">
                {{-- Display alerts --}}
                @if (session('alerts'))
                    @foreach (session('alerts') as $alert)
                        <div class="alert alert-{{ is_array($alert) ? $alert['type'] : $alert->type }} alert-dismissible fade show" role="alert">
                            {{ is_array($alert) ? $alert['message'] : $alert->message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endif

                <form action="{{ route('message.send', $thread->id) }}" method="POST" id="replyForm">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea
                            name="message"
                            id="message"
                            class="form-control"
                            rows="4"
                            placeholder="Type your reply here..."
                            required
                        >{{ old('message') }}</textarea>
                        <div class="form-text">Maximum 5000 characters</div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" id="cancelReply">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="sendReplyBtn">
                            <i class="fas fa-paper-plane me-2"></i>Send Reply
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- New Message Modal (Legacy) --}}
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

        /* Form styling */
        #replyForm {
            transition: all 0.3s ease;
        }
        #replyForm:focus-within {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            border-color: #80bdff;
        }
        .character-count {
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Loading state */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }
        .btn-loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #fff;
            border-radius: 50%;
            animation: btn-spin 0.8s linear infinite;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }
        @keyframes btn-spin {
            to { transform: rotate(360deg); }
        }
    </style>

    {{-- JavaScript for reply form --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const replyForm = document.getElementById('replyForm');
            const messageTextarea = document.getElementById('message');
            const sendReplyBtn = document.getElementById('sendReplyBtn');
            const cancelReplyBtn = document.getElementById('cancelReply');

            // Character counter
            const maxLength = 5000;
            const characterCount = document.createElement('div');
            characterCount.className = 'character-count text-end mt-1';
            characterCount.textContent = `0 / ${maxLength} characters`;
            messageTextarea.parentNode.appendChild(characterCount);

            // Update character count
            messageTextarea.addEventListener('input', function() {
                const length = this.value.length;
                characterCount.textContent = `${length} / ${maxLength} characters`;

                if (length > maxLength) {
                    characterCount.classList.add('text-danger');
                    sendReplyBtn.disabled = true;
                } else {
                    characterCount.classList.remove('text-danger');
                    sendReplyBtn.disabled = false;
                }
            });

            // Form submission
            replyForm.addEventListener('submit', function(e) {
                const message = messageTextarea.value.trim();

                if (!message) {
                    e.preventDefault();
                    alert('Please enter a message before sending.');
                    return;
                }

                if (message.length > maxLength) {
                    e.preventDefault();
                    alert(`Message exceeds maximum length of ${maxLength} characters.`);
                    return;
                }

                // Show loading state
                sendReplyBtn.disabled = true;
                sendReplyBtn.classList.add('btn-loading');
                sendReplyBtn.innerHTML = 'Sending...';
            });

            // Cancel button
            cancelReplyBtn.addEventListener('click', function() {
                if (messageTextarea.value.trim()) {
                    if (confirm('Are you sure you want to cancel? Your message will be lost.')) {
                        messageTextarea.value = '';
                        characterCount.textContent = `0 / ${maxLength} characters`;
                        replyForm.reset();
                    }
                } else {
                    messageTextarea.value = '';
                    characterCount.textContent = `0 / ${maxLength} characters`;
                    replyForm.reset();
                }
            });

            // Reset form on modal close (for legacy modal)
            document.getElementById('newMessageModal').addEventListener('hidden.bs.modal', function() {
                replyForm.reset();
                characterCount.textContent = `0 / ${maxLength} characters`;
            });
        });
    </script>
@endsection
