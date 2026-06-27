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
                placeholder="Search employees, departments..."
            >
        </form>
    </div>

    <div class="header-controls d-flex align-items-center gap-3">
     <button class="btn btn-control position-relative"
        id="btn-notifications" aria-label="Notifications">
    <i class="bi bi-bell fs-5"></i>

    @if(isset($unreadCount) && $unreadCount > 0)
        <span class="position-absolute top-2 start-75 translate-middle
                     badge rounded-pill bg-danger"
              style="font-size:0.6rem; padding:3px 5px;">
            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
        </span>
    @endif
</button>

      
        <div class="vr mx-1 d-none d-sm-block" style="height: 24px;"></div>

        <div class="dropdown" id="user-profile-dropdown">
            <button class="btn btn-profile d-flex align-items-center gap-2 text-start p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-info text-end d-none d-sm-block">
                    <div class="profile-name">{{ Auth::guard('employee')->user()->name }}</div>
                    <div class="profile-role">Employee</div>
                </div>
                <div class="profile-avatar-container">
                    <img src="{{ asset('images/avatar.png') }}" alt="Admin Avatar" class="profile-avatar border border-2 border-brand">
                </div>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li> 
                    <a class="dropdown-item py-2" href="{{route('employee.profile')}}">
                        <i class="bi bi-person-fill me-2"></i>My Profile
                    </a>
                </li>
               
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{route('employee.logout')}}">
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