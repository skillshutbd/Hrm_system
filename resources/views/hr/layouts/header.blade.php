@push('styles')
<style>
    .app-header {
        background: #FFFFFF;
        border-bottom: 1px solid #E2E0DD;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header-search {
        position: relative;
        width: 300px;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9A9590;
        font-size: 0.9rem;
        z-index: 1;
    }

    .form-control-search {
        padding-left: 36px;
        border: 1px solid #E2E0DD;
        border-radius: 8px;
        font-size: 0.88rem;
        background: #FAF9F6;
    }

    .form-control-search:focus {
        border-color: #FF5E2B;
        box-shadow: 0 0 0 4px rgba(255, 94, 43, 0.1);
        background: #FFFFFF;
    }

    .btn-control {
        background: none;
        border: 1px solid #E2E0DD;
        border-radius: 8px;
        color: #4A4A4A;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-control:hover {
        background: #FAF9F6;
        color: #FF5E2B;
        border-color: #FF5E2B;
    }

    .btn-control.active {
        background: #FFF0EB;
        color: #FF5E2B;
        border-color: #FF5E2B;
    }

    .btn-profile {
        background: none;
        border: none;
    }

    .profile-name {
        font-size: 0.88rem;
        color: #1A1A1A;
    }

    .profile-role {
        font-size: 0.72rem;
        color: #FF5E2B;
        letter-spacing: 0.5px;
    }

    .profile-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
    }

    .border-brand {
        border-color: #FF5E2B !important;
    }

    .text-brand {
        color: #FF5E2B !important;
    }

    .dropdown-menu {
        border-radius: 12px;
        font-size: 0.88rem;
    }

    .dropdown-item:hover {
        background: #FAF9F6;
        color: #FF5E2B;
    }

    /* ── Notification Dropdown ───────────────────── */
    .notif-dropdown {
        width: 360px;
        padding: 0;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.10);
        overflow: hidden;
    }
    .notif-header {
        padding: 14px 18px;
        border-bottom: 1px solid #F4F4F0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #FAFAFA;
    }
    .notif-header-title {
        font-family: 'Outfit', sans-serif;
        font-size: .92rem;
        font-weight: 700;
        color: #1A1A1A;
    }
    .notif-mark-all {
        font-size: .75rem;
        font-weight: 600;
        color: #FF5E2B;
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
    }
    .notif-mark-all:hover { text-decoration: underline; }

    .notif-list { max-height: 340px; overflow-y: auto; }
    .notif-list::-webkit-scrollbar { width: 4px; }
    .notif-list::-webkit-scrollbar-thumb { background: #E2E0DD; border-radius: 4px; }

    .notif-item {
        padding: 14px 18px;
        border-bottom: 1px solid #F4F4F0;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        transition: background .15s;
        cursor: pointer;
    }
    .notif-item:last-child  { border-bottom: none; }
    .notif-item:hover       { background: #FAF9F6; }
    .notif-item.unread      { background: #FFF8F5; }
    .notif-item.unread:hover{ background: #FFF0EB; }

    .notif-icon {
        width: 36px; height: 36px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem; flex-shrink: 0;
    }
    .notif-icon.submitted       { background: #EBF3FF; color: #2563EB; }
    .notif-icon.recommended     { background: #ECFDF5; color: #059669; }
    .notif-icon.not_recommended { background: #FEF2F2; color: #DC2626; }
    .notif-icon.approved        { background: #ECFDF5; color: #059669; }
    .notif-icon.rejected        { background: #FEF2F2; color: #DC2626; }
    .notif-icon.default         { background: #F4F4F0; color: #7F7F7F; }

    .notif-body         { flex: 1; min-width: 0; }
    .notif-msg          { font-size: .82rem; color: #1A1A1A; line-height: 1.4; margin-bottom: 4px; }
    .notif-msg.unread   { font-weight: 600; }
    .notif-time         { font-size: .72rem; color: #7F7F7F; }
    .notif-dot          { width: 7px; height: 7px; border-radius: 50%; background: #FF5E2B; flex-shrink: 0; margin-top: 6px; }

    .notif-footer {
        padding: 12px 18px;
        border-top: 1px solid #F4F4F0;
        text-align: center;
        background: #FAFAFA;
    }
    .notif-footer a {
        font-size: .82rem;
        font-weight: 600;
        color: #FF5E2B;
        text-decoration: none;
    }
    .notif-footer a:hover { text-decoration: underline; }

    .notif-empty {
        padding: 32px 18px;
        text-align: center;
        color: #7F7F7F;
        font-size: .85rem;
    }
    .notif-empty i { font-size: 1.8rem; color: #E2E0DD; display: block; margin-bottom: 8px; }
</style>
@endpush

@php
    $hrAdmin = auth('Hr')->user();

    $hrNotifications = \App\Models\LeaveNotification::where('recipient_type', 'hr')
        ->where('recipient_id', $hrAdmin->id ?? 0)
        ->with('leave.employee')
        ->latest()
        ->take(10)
        ->get();

    $iconMap = [
        'leave_recommended'  => ['icon' => 'bi-calendar-check', 'class' => 'recommended'],
        'leave_submitted'    => ['icon' => 'bi-calendar-plus',  'class' => 'submitted'],
        'tl_recommended'     => ['icon' => 'bi-check-circle',   'class' => 'recommended'],
        'tl_not_recommended' => ['icon' => 'bi-x-circle',       'class' => 'not_recommended'],
    ];

    $hrUnreadCount = $hrNotifications->whereNull('read_at')->count();
@endphp

<header class="app-header py-3 px-4 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
        <button class="btn btn-outline-secondary d-lg-none me-3" id="sidebar-toggle" aria-label="Toggle Navigation">
            <i class="bi bi-list"></i>
        </button>

        <form action="#" method="GET" class="header-search">
            <i class="bi bi-search search-icon"></i>
            <input
                type="text"
                name="query"
                class="form-control form-control-search"
                id="dashboard-search"
                value="{{ request('query') }}"
                placeholder="Search employees, departments...">
        </form>
    </div>

    <div class="header-controls d-flex align-items-center gap-3">

        {{-- ── Notification Dropdown ── --}}
        <div class="dropdown">
            <button class="btn btn-control position-relative {{ $hrUnreadCount > 0 ? 'active' : '' }}"
                    id="hr-notif-btn"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                    aria-label="Notifications">
                <i class="bi bi-bell fs-5"></i>
                @if($hrUnreadCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                          style="font-size:.6rem; padding:3px 5px;">
                        {{ $hrUnreadCount > 99 ? '99+' : $hrUnreadCount }}
                    </span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end notif-dropdown mt-2">
                <div class="notif-header">
                    <span class="notif-header-title">
                        Notifications
                        @if($hrUnreadCount > 0)
                            <span class="badge rounded-pill ms-1" style="background:#FF5E2B; font-size:.65rem;">
                                {{ $hrUnreadCount }}
                            </span>
                        @endif
                    </span>
                    <form method="POST" action="{{ route('hr_admin.notifications.mark-all-read') }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="notif-mark-all">Mark all as read</button>
                    </form>
                </div>

                <div class="notif-list">
                    @forelse($hrNotifications as $notif)
                    @php
                        $map      = $iconMap[$notif->type] ?? ['icon' => 'bi-bell', 'class' => 'default'];
                        $isUnread = is_null($notif->read_at);
                    @endphp
                    <div class="notif-item {{ $isUnread ? 'unread' : '' }}"
                         onclick="markHrRead({{ $notif->id }}, this)">
                        <div class="notif-icon {{ $map['class'] }}">
                            <i class="bi {{ $map['icon'] }}"></i>
                        </div>
                        <div class="notif-body">
                            <div class="notif-msg {{ $isUnread ? 'unread' : '' }}">
                                {{ $notif->message }}
                            </div>
                            <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                        @if($isUnread)
                            <div class="notif-dot"></div>
                        @endif
                    </div>
                    @empty
                    <div class="notif-empty">
                        <i class="bi bi-bell-slash"></i>
                        No notifications yet
                    </div>
                    @endforelse
                </div>

                @if($hrNotifications->count() > 0)
                <div class="notif-footer">
                    <a href="{{ route('hr_admin.notifications.index') }}">View all notifications</a>
                </div>
                @endif
            </div>
        </div>

        <div class="vr mx-1 d-none d-sm-block" style="height: 24px;"></div>

        {{-- ── Profile Dropdown ── --}}
        <div class="dropdown" id="user-profile-dropdown">
            <button class="btn btn-profile d-flex align-items-center gap-2 text-start p-1"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-info text-end d-none d-sm-block">
                    <div class="profile-name">{{ $hrAdmin->name ?? 'HR Admin' }}</div>
                    <div class="profile-role">HR Admin</div>
                </div>
                <div class="profile-avatar-container">
                    <img src="{{ asset('images/avatar.png') }}"
                         alt="HR Avatar"
                         class="profile-avatar border border-2 border-brand">
                </div>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li>
                    <a class="dropdown-item py-2" href="{{ route('hr_admin.profile') }}">
                        <i class="bi bi-person-fill me-2"></i>My Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('hr_admin.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 text-danger">
                            <i class="bi bi-box-arrow-left me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

@push('scripts')
<script>
function markHrRead(notifId, element) {
    fetch(`/hr_admin/notifications/${notifId}/read`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    }).then(() => {
        element.classList.remove('unread');
        element.querySelector('.notif-msg')?.classList.remove('unread');
        const dot = element.querySelector('.notif-dot');
        if (dot) dot.remove();

        const badge = document.querySelector('#hr-notif-btn .badge');
        if (badge) {
            const count = parseInt(badge.textContent) - 1;
            if (count <= 0) {
                badge.remove();
                document.getElementById('hr-notif-btn').classList.remove('active');
            } else {
                badge.textContent = count;
            }
        }
    });
}
</script>
@endpush