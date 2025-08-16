@extends('admin/template-base')

@section('page-title', 'Notifications')

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
                    <h3 class="card-header">Notifications</h3>
                </div>
                <div class="p-2 d-flex align-items-center">
                    <span class="badge bg-danger me-2" id="unread-badge">Unread: {{ $unreadCount ?? 0 }}</span>
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
                            placeholder="Search title, message or type.." aria-label="Search title, message or type..." name="keyword"
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

            {{-- NOTIFICATION STATISTICS --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Notification Statistics</h5>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#notificationStatsCollapse" aria-expanded="false" aria-controls="notificationStatsCollapse">
                        <i class='bx bx-show me-1'></i> Show/Hide Stats
                    </button>
                </div>
                <div class="collapse" id="notificationStatsCollapse">
                    <div class="card-body">
                        @if (isset($stats['type_stats']) && count($stats['type_stats']) > 0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Unread</th>
                                        <th>Read</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stats['type_stats'] as $typeStat)
                                        <tr>
                                            <td><span class="badge {{ $typeColors[$typeStat['type']] ?? 'bg-secondary' }}">{{ $typeStat['type'] }}</span></td>
                                            <td>{{ $typeStat['unread_count'] }}</td>
                                            <td>{{ $typeStat['read_count'] }}</td>
                                            <td>{{ $typeStat['total_count'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Overall Total</strong></td>
                                        <td><strong>{{ $stats['overall_unread'] }}</strong></td>
                                        <td><strong>{{ $stats['overall_read'] }}</strong></td>
                                        <td><strong>{{ $stats['overall_total'] }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <p>No notification statistics available.</p>
                        @endif
                    </div>
                </div>
            </div>

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
                                    href="{{ route('notification.index', [
                                        'sort_field' => 'type',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                        'unreadOnly' => $unreadOnly,
                                    ]) }}">
                                    Type
                                    @include('components.arrow-sort', [
                                        'field' => 'type',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('notification.index', [
                                        'sort_field' => 'title',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                        'unreadOnly' => $unreadOnly,
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
                                    href="{{ route('notification.index', [
                                        'sort_field' => 'is_read',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                        'unreadOnly' => $unreadOnly,
                                    ]) }}">
                                    Status
                                    @include('components.arrow-sort', [
                                        'field' => 'is_read',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('notification.index', [
                                        'sort_field' => 'created_at',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                        'unreadOnly' => $unreadOnly,
                                    ]) }}">
                                    Dibuat pada
                                    @include('components.arrow-sort', [
                                        'field' => 'created_at',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>


                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                            $typeColors = [
                                'system_alert' => 'bg-primary',
                                'info' => 'bg-info',
                                'warning' => 'bg-warning',
                                'error' => 'bg-danger',
                                'success' => 'bg-success',
                                // Add more types and colors as needed
                            ];
                        @endphp
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>
                                    <span class="badge {{ $typeColors[$notification->type] ?? 'bg-secondary' }}">{{ $notification->type }}</span>
                                </td>
                                <td>
                                    <strong>{{ $notification->title }}</strong>
                                </td>
                                <td>
                                    @if ($notification->is_read)
                                        <span class="badge rounded-pill bg-success"> Read </span>
                                    @else
                                        <span class="badge rounded-pill bg-warning"> Unread </span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($notification->created_at)->format('d M Y H:i') }}
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('notification.show', ['id' => $notification->id]) }}"
                                        title="view">
                                        <i class='bx bx-show'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon text-danger" href="#"
                                        onclick="confirmDelete('{{ $notification->id }}', '{{ $notification->title }}')"
                                        title="delete">
                                        <i class='bx bx-trash'></i>
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
                        {{ $notifications->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('footer-code')
    <script>
        function confirmDelete(id, title) {
            if (confirm('Are you sure you want to delete this notification: "' + title + '"?')) {
                window.location.href = "{{ route('notification.destroy', ['id' => '__ID__']) }}".replace('__ID__', id);
            }
        }

        function markAllAsRead() {
            if (confirm('Are you sure you want to mark all notifications as read?')) {
                fetch("{{ route('notification.markAllAsRead') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to mark all as read');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error occurred');
                });
            }
        }

        function deleteReadNotifications() {
            if (confirm('Are you sure you want to delete all read notifications? This action cannot be undone.')) {
                fetch("{{ route('notification.deleteRead') }}", {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to delete read notifications');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error occurred');
                });
            }
        }

        // Update unread count badge
        function updateUnreadCount() {
            fetch("{{ route('notification.unreadCount') }}")
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('unread-badge');
                    if (badge) {
                        badge.textContent = 'Unread: ' + data.count;
                    }
                })
                .catch(error => {
                    console.error('Error fetching unread count:', error);
                });
        }

        // Update unread count every 30 seconds
        setInterval(updateUnreadCount, 30000);
    </script>
@endsection
