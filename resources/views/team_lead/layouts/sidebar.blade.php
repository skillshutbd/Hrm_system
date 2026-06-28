<aside class="app-sidebar" id="sidebar">

    {{-- Brand Logo --}}
    <div class="sidebar-brand">
        <div class="brand-logo">
            <img src="{{ $brandLogo ?? asset('images/logo.png') }}" alt="Skills Hut Logo">
        </div>
    </div>

    {{-- Main Navigation --}}
    <nav class="sidebar-nav">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="{{ route('team_lead.dashboard') }}" class="nav-link {{ request()->routeIs('team_lead.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('team_lead.memberIndex') }}" class="nav-link {{ request()->routeIs('team_lead.memberIndex') || request()->routeIs('team_lead.memberIndex.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>My Team</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.employee_leave.index') }}" class="nav-link {{ request()->routeIs('admin.employee_leave.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event-fill"></i>
                    <span>Leave Recommendation</span>
                </a>
            </li>

        </ul>
    </nav>

    {{-- Bottom Section --}}
    <div class="sidebar-bottom mt-auto">
        <hr class="sidebar-divider">
        <ul class="nav flex-column">
            <li class="nav-item">
                <form method="POST" action="{{ route('team_lead.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

</aside>