@extends('admin/template-base')

@section('page-title', 'Messages')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE AND ACTIONS --}}
            <div class="d-flex justify-content-between">

                <div class="p-2 bd-highlight">
                    <h3 class="card-header">Messages</h3>
                </div>
                <div class="p-2 d-flex align-items-center">
                    <span class="badge bg-danger me-2" id="unread-badge">Unread Threads: {{ $unreadCount ?? 0 }}</span>
                </div>

            </div>

            {{-- SECOND ROW,  FOR DISPLAY PER PAGE AND SEARCH FORM --}}
            <div class="d-flex justify-content-between">

                {{-- OPTION TO SHOW LIST PER PAGE --}}
                <div class="p-2 bd-highlight">
                    @include('admin.components.paginator.perpageform')
                </div>

                {{-- SEARCH FORMS --}}
                <div class="p-2 d-flex align-items-center">
                    <form action="{{ url()->full() }}" method="get" class="d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="form-control border-1 shadow-none bg-light bg-gradient"
                            placeholder="Search title or participant.." aria-label="Search title or participant.." name="keyword"
                            value="{{ isset($keyword) ? $keyword : '' }}" />
                        <input type="hidden" name="sort_order" value="{{ request()->input('sort_order') }}" />
                        <input type="hidden" name="sort_field" value="{{ request()->input('sort_field') }}" />
                        <input type="hidden" name="per_page" value="{{ request()->input('per_page') }}" />
                    </form>
                </div>

            </div>

            {{-- THIRD ROW, FOR THE MAIN DATA PART --}}
            {{-- //to display any error if any --}}
            @if (isset($alerts))
                @include('admin.components.notification.general', $alerts)
            @endif

            <div class="table-responsive text-nowrap">
                <!-- Table data with Striped Rows -->
                <table class="table table-striped table-hover align-middle">

                    {{-- TABLE HEADER --}}
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>
                                <a
                                    href="{{ route('message.index', [
                                        'sort_field' => 'title',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Title
                                    @include('components.arrow-sort', [
                                        'field' => 'title',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('message.index', [
                                        'sort_field' => 'last_message_at',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Last Message
                                    @include('components.arrow-sort', [
                                        'field' => 'last_message_at',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('message.index', [
                                        'sort_field' => 'created_at',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                    ]) }}">
                                    Created At
                                    @include('components.arrow-sort', [
                                        'field' => 'created_at',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th></th>
                        </tr>
                    </thead>


                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($threads as $thread)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>
                                    <strong>{{ $thread->title }}</strong>
                                    <br>
                                    <small class="text-muted">With: {{ $thread->initiator_id == Auth::id() ? $thread->participant->name : $thread->initiator->name }}</small>
                                </td>
                                <td>
                                    @if ($thread->lastMessage)
                                        {{ \Carbon\Carbon::parse($thread->lastMessage->created_at)->format('d M Y H:i') }}
                                        <br>
                                        <small class="text-muted">{{ Str::limit($thread->lastMessage->message, 50) }}</small>
                                    @else
                                        <span class="text-muted">No messages yet</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($thread->created_at)->format('d M Y H:i') }}
                                </td>
                                <td>
                                    <a href="{{ route('message.show', ['id' => $thread->id]) }}" class="btn btn-sm btn-outline-primary">
                                        View Thread
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <br />

                <div class="row">
                    <div class="col-md-10 mx-auto">
                        {{ $threads->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('footer-code')
    {{-- Any specific JS for this page can go here --}}
@endsection
