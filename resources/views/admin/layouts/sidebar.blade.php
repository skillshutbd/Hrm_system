<aside class="app-sidebar" id="sidebar">

    <div class="sidebar-brand">
        <div class="brand-logo">
            <i class="bi bi-grid-fill text-white fs-4"></i>
        </div>
        <div class="brand-text ms-3">
            <h2 class="brand-title mb-0">Skills Hut Ltd</h2>
            <span class="brand-subtitle text-uppercase">Phase 1 HRM</span>
        </div>
    </div>

    <nav class="sidebar-nav my-4">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill me-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- User Management Dropdown --}}
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.employee.*') || request()->routeIs('admin.tl.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse" href="#userManagement" role="button"
                   aria-expanded="{{ request()->routeIs('admin.employee.*') || request()->routeIs('admin.tl.*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-people-fill me-3"></i>User Management</span>
                    <i class="bi bi-chevron-down" style="font-size:0.7rem;"></i>
                </a>
                <div class="collapse {{ request()->routeIs('admin.employee.*') || request()->routeIs('admin.tl.*') ? 'show' : '' }}" id="userManagement">
                    <ul class="nav flex-column ms-4 mt-1">
                        <li class="nav-item">
                            <a href="{{ route('admin.employee.index') }}" class="nav-link sub-link {{ request()->routeIs('admin.employee.*') ? 'active' : '' }}">
                                <i class="bi bi-person-lines-fill me-2"></i> Employee Directory
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.teamlead.index') }}" class="nav-link sub-link {{ request()->routeIs('admin.tl.*') ? 'active' : '' }}">
                                <i class="bi bi-person-check-fill me-2"></i> TL Assignment
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.department.index') }}" class="nav-link {{ request()->routeIs('admin.department.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3-fill me-3"></i>
                    <span>Department List</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.employee_leave.index') }}" class="nav-link {{ request()->routeIs('admin.employee_leave.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event-fill me-3"></i>
                    <span>Leave Requests</span>
                </a>
            </li>

            <!-- <li class="nav-item">
                <a href="{{ route('admin.employee_activity.index') }}" class="nav-link {{ request()->routeIs('admin.employee_activity.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill me-3"></i>
                    <span>Employee Activity</span>
                </a>
            </li> -->

        </ul>
    </nav>

    <div class="sidebar-cta px-3 mb-auto">
        <a href="{{ route('admin.employee.create') }}" class="btn btn-brand w-100 py-2 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>New Hire
        </a>
    </div>

    <div class="sidebar-bottom mt-4">
        <hr class="sidebar-divider">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link py-2 {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill me-3"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link py-2 text-danger border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-left me-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>