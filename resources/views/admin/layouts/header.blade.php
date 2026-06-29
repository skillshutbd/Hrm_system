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

    .notification-dot {
        width: 8px;
        height: 8px;
        padding: 0;
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
</style>
@endpush


@php
    $pendingNotificationsCount = \App\Models\Notification::where('status', 'pending')->count();
    $recentNotifications = \App\Models\Notification::where('status', 'pending')
        ->latest()
        ->take(5)
        ->get();
@endphp


<header class="app-header py-3 px-4 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center justify-content-between w-100">
         <button class="mobile-sidebar-toggle" type="button" aria-label="Toggle Menu">
           <i class="bi bi-list"></i>
        </button>
    {{-- Left: Toggle + Welcome --}}
    <div class="d-flex align-items-center">
       

         <div class="welcome-text">
                @php
                    $hour = \Carbon\Carbon::now()->hour;
                    $greeting = match(true) {
                        $hour < 12 => 'Good Morning',
                        $hour < 17 => 'Good Afternoon',
                        default    => 'Good Evening',
                    };
                @endphp
                {{ $greeting }}, <strong>{{ $employeeAuth->name ?? 'Super Admin' }}</strong> 👋
          
        </div>
        
    </div>

    {{-- Right side (existing icons/profile can go here) --}}
    <div class="d-flex align-items-center gap-2">
        {{-- your existing right-side content --}}
    </div>
</div>

    <div class="header-controls d-flex align-items-center gap-3">
       @php
    $pendingNotificationsCount = \App\Models\Notification::where('status', 'pending')->count();
    $recentNotifications = \App\Models\Notification::where('status', 'pending')
        ->latest()
        ->take(5)
        ->get();
@endphp

<div class="dropdown">
    <button class="btn btn-control position-relative" id="btn-notifications" data-bs-toggle="dropdown" aria-label="Notifications">
        <i class="bi bi-bell fs-5"></i>
        @if($pendingNotificationsCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;">
                {{ $pendingNotificationsCount }}
            </span>
        @endif
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="min-width:320px; border-radius:12px;">
        <li class="px-3 py-2 border-bottom">
            <span style="font-size:0.82rem; font-weight:700; color:#1A1A1A;">Notifications</span>
            @if($pendingNotificationsCount > 0)
                <span class="badge bg-danger ms-2" style="font-size:0.65rem;">{{ $pendingNotificationsCount }} pending</span>
            @endif
        </li>

        @forelse($recentNotifications as $notification)
            <li>
                <div class="dropdown-item py-2" style="white-space:normal; cursor:default;">
                    <div style="font-size:0.82rem; color:#1A1A1A;">{{ $notification->message }}</div>
                    <div style="font-size:0.72rem; color:#B2ADA7; margin-top:2px;">
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                </div>
            </li>
        @empty
            <li>
                <div class="dropdown-item py-3 text-center" style="font-size:0.82rem; color:#B2ADA7;">
                    No notifications
                </div>
            </li>
        @endforelse

        @if($pendingNotificationsCount > 0)
            <li class="border-top">
                <a href="{{ route('admin.notifications.index') }}" class="dropdown-item py-2 text-center" style="font-size:0.78rem; color:#FF5E2B; font-weight:600;">
                    View All Notifications
                </a>
            </li>
        @endif
    </ul>
</div>

      
        <div class="vr mx-1 d-none d-sm-block" style="height: 24px;"></div>

        <div class="dropdown" id="user-profile-dropdown">
            <button class="btn btn-profile d-flex align-items-center gap-2 text-start p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-info text-end d-none d-sm-block">
                    <span class="profile-name d-block fw-semibold mb-0">{{ auth()->user()->name ?? 'Admin User' }}</span>
                    <span class="profile-role text-uppercase fs-7">{{ auth()->user()->role ?? 'Super Admin' }}</span>
                </div>
                <div class="profile-avatar-container">
                    <img src="{{ asset('images/avatar.png') }}" alt="Admin Avatar" class="profile-avatar border border-2 border-brand">
                </div>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li>
                    <a class="dropdown-item py-2" href="{{ route('admin.profile') }}">
                        <i class="bi bi-person-fill me-2"></i>My Profile
                    </a>
                </li>
               
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('admin.logout') }}">
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