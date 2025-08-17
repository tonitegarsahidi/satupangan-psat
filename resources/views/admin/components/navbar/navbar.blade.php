<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme no-print"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
               Halo,&nbsp; <strong>{{ auth()->user()->name }}</strong>, yuk kita jaga dan awasi pangan di Indonesia..!!
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            {{-- uncomment me to see another example of navbar component --}}
            <!-- Place this tag where you want the button to render. -->
            {{-- <li class="nav-item lh-1 me-3">
                <a class="github-button" href="https://github.com/themeselection/sneat-html-admin-template-free"
                    data-icon="octicon-star" data-size="large" data-show-count="true"
                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">Star</a>
            </li> --}}

            <!-- Notifications -->
            <li class="nav-item navbar-dropdown dropdown-notifications dropdown me-3 me-xl-0">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-bell bx-sm"></i>
                    <span class="badge bg-danger badge-dot indicator" id="notification-badge" style="display: none;"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end pt-0" id="notification-dropdown">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="position-relative">
                            <h6 class="mb-0 d-flex align-items-center justify-content-between">
                                Notifications
                                <span class="badge bg-primary rounded-pill notification-count" id="notification-count">0</span>
                            </h6>
                        </div>
                    </li>
                    <li class="dropdown-divider my-1"></li>
                    <li class="dropdown-notifications-list scrollable-container" id="notification-list">
                        <div class="text-center text-muted py-3">
                            <i class="bx bx-bell bx-2x"></i>
                            <p class="mb-0 mt-2">No new notifications</p>
                        </div>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <a href="{{ route('notification.index') }}" class="dropdown-item dropdown-item-unread">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-semibold">View all notifications</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Messages -->
            <li class="nav-item navbar-dropdown dropdown-messages dropdown me-3 me-xl-0">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-chat bx-sm"></i>
                    <span class="badge bg-danger badge-dot indicator" id="message-badge" style="display: none;"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end pt-0" id="message-dropdown">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="position-relative">
                            <h6 class="mb-0 d-flex align-items-center justify-content-between">
                                Messages
                                <span class="badge bg-primary rounded-pill message-count" id="message-count">0</span>
                            </h6>
                        </div>
                    </li>
                    <li class="dropdown-divider my-1"></li>
                    <li class="dropdown-messages-list scrollable-container" id="message-list">
                        <div class="text-center text-muted py-3">
                            <i class="bx bx-chat bx-2x"></i>
                            <p class="mb-0 mt-2">No new messages</p>
                        </div>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <a href="{{ route('message.index') }}" class="dropdown-item dropdown-item-unread">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-semibold">View all messages</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ auth()->user()->profile && auth()->user()->profile->profile_picture ? asset(auth()->user()->profile->profile_picture) : asset('assets/img/avatars/default.png') }}"
                        alt
                        class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ auth()->user()->profile && auth()->user()->profile->profile_picture ? asset(auth()->user()->profile->profile_picture) : asset('assets/img/avatars/default.png') }}"  alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                    <small class="text-muted">
                                        {{ auth()->user()->printRoles() }}

                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>

                    {{-- ====== USER PROFILE ======== --}}
                    <li>
                        <a class="dropdown-item" href="{{route('user.profile.index')}}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>

                    {{-- ====== SETTING ======== --}}
                    <li>
                        <a class="dropdown-item" href="{{route('user.setting.index')}}">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Settings</span>
                        </a>
                    </li>
                    {{-- UNCOMMENT BELOW TO SEE ANOTHER SAMPLE OF SUBMENU WITH BADGE --}}
                    {{-- <li>
                        <a class="dropdown-item" href="#">
                            <span class="d-flex align-items-center align-middle">
                                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                <span class="flex-grow-1 align-middle">Message</span>
                                <span
                                    class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                            </span>
                        </a>
                    </li> --}}
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    {{-- ====== LOGOUT ======== --}}
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>

                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>

<script>
    // Load notifications
    document.addEventListener('DOMContentLoaded', function() {
        loadNotifications();
        loadMessages();

        // No periodic refresh
    });

    function loadNotifications() {
        fetch('{{ route("notification.api") }}?limit=10&sort_by=created_at&sort_order=desc&unread_only=true')
            .then(response => response.json())
            .then(data => {
                updateNotificationUI(data);
            })
            .catch(error => console.error('Error loading notifications:', error));
    }

    function updateNotificationUI(notifications) {
        const notificationList = document.getElementById('notification-list');
        const notificationCount = document.getElementById('notification-count');
        const notificationBadge = document.getElementById('notification-badge');

        // Update count
        const unreadCount = notifications.filter(n => !n.is_read).length;
        notificationCount.textContent = unreadCount;

        // Show/hide badge
        if (unreadCount > 0) {
            notificationBadge.style.display = 'block';
            notificationBadge.textContent = unreadCount;
        } else {
            notificationBadge.style.display = 'none';
        }

        // Update list
        if (notifications.length === 0) {
            notificationList.innerHTML = `
                <div class="text-center text-muted py-3">
                    <i class="bx bx-bell bx-2x"></i>
                    <p class="mb-0 mt-2">No new notifications</p>
                </div>
            `;
        } else {
            notificationList.innerHTML = notifications.map(notification => `
                <a href="/notification/detail/${notification.id}" class="dropdown-item ${!notification.is_read ? 'dropdown-item-unread' : ''}"
                   onclick="markNotificationAsRead(${notification.id})">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                                <img src="${notification.data?.sender_avatar || '/assets/img/avatars/default.png'}" alt="${notification.data?.sender_name || 'System'}"
                                     class="w-px-30 h-auto rounded-circle">
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">${notification.title || 'Notification'}</h6>
                            <small class="text-muted">${formatDate(notification.created_at)}</small>
                        </div>
                    </div>
                </a>
            `).join('');
        }
    }

    function markNotificationAsRead(notificationId) {
        fetch(`/admin/notification/mark-as-read/${notificationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications(); // Refresh the list
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
    }

    function loadMessages() {
        fetch('{{ route("message.api") }}?limit=10&sort_by=created_at&sort_order=desc&unread_only=true')
            .then(response => response.json())
            .then(data => {
                updateMessageUI(data);
            })
            .catch(error => console.error('Error loading messages:', error));
    }

    function updateMessageUI(messages) {
        const messageList = document.getElementById('message-list');
        const messageCount = document.getElementById('message-count');
        const messageBadge = document.getElementById('message-badge');

        // Update count
        const unreadCount = messages.filter(m => !m.is_read).length;
        messageCount.textContent = unreadCount;

        // Show/hide badge
        if (unreadCount > 0) {
            messageBadge.style.display = 'block';
            messageBadge.textContent = unreadCount;
        } else {
            messageBadge.style.display = 'none';
        }

        // Update list
        if (messages.length === 0) {
            messageList.innerHTML = `
                <div class="text-center text-muted py-3">
                    <i class="bx bx-chat bx-2x"></i>
                    <p class="mb-0 mt-2">No messages</p>
                </div>
            `;
        } else {
            messageList.innerHTML = messages.map(message => `
                <a href="/message/detail/${message.id}"
                   class="dropdown-item ${!message.is_read ? 'dropdown-item-unread' : ''}">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                                <img src="${message.sender?.profile?.profile_picture || '/assets/img/avatars/default.png'}"
                                     alt="${message.sender?.name || 'User'}"
                                     class="w-px-30 h-auto rounded-circle">
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">${message.title || 'Unknown User'}</h6>
                            <small class="text-muted">${formatDate(message.updated_at)}</small>
                        </div>
                    </div>
                </a>
            `).join('');
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffTime = Math.abs(now - date);
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays === 0) {
            const diffHours = Math.floor(diffTime / (1000 * 60 * 60));
            if (diffHours === 0) {
                const diffMinutes = Math.floor(diffTime / (1000 * 60));
                return diffMinutes === 0 ? 'Just now' : `${diffMinutes} min ago`;
            }
            return `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`;
        } else if (diffDays === 1) {
            return 'Yesterday';
        } else if (diffDays < 7) {
            return `${diffDays} days ago`;
        } else {
            return date.toLocaleDateString();
        }
    }
</script>
</nav>
