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
                <a href="{{ route('employee.dashboard') }}" class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('employee.leave.history')}}" class="nav-link {{ request()->routeIs('employee_leave.history*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event-fill"></i>
                    <span>Leave Requests</span>
                </a>
            </li>

        </ul>
    </nav>

    {{-- Bottom Section --}}
    <div class="sidebar-bottom mt-auto">
        <hr class="sidebar-divider">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('hr_profile.edit') }}" class="nav-link">
                    <i class="bi bi-gear-fill"></i>
                    <span>Settings</span>
                </a>
            </li>

            <li class="nav-item">
                <form method="POST" action="{{ route('employee.logout') }}">
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