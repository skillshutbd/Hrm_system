<aside class="app-sidebar" id="sidebar">

    <div class="sidebar-brand">
        <div class="brand-logo">
            <i class="bi bi-grid-fill text-white fs-4"></i>
        </div>
        <div class="brand-text ms-3">
            <h2 class="brand-title mb-0">Skills Hut Ltd</h2>
            <span class="brand-subtitle text-uppercase">TEAM LEARD</span>
        </div>
    </div>

    <nav class="sidebar-nav my-4">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="{{ route('team_lead.dashboard') }}" class="nav-link {{ request()->routeIs('hr_admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill me-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>

         
                <li class="nav-item">
                  
                      
                  <a href="{{route('team_lead.memberIndex')}}" class="nav-link {{ request()->routeIs('team_lead.memberIndex.*') ? 'active' : '' }}"
                        <span><i class="bi bi-people-fill me-3"></i>My team</span>
                      
                    </a>

                   
                </li>
            

            <li class="nav-item">
                <a href="{{ route('admin.employee_leave.index') }}" class="nav-link {{ request()->routeIs('admin.employee_leave.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event-fill me-3"></i>
                    <span>Leave Requests Recommendation</span>
                </a>
            </li>

        </ul>
    </nav>

   
       

    <div class="sidebar-bottom mt-auto ">
        <hr class="sidebar-divider">
        <ul class="nav flex-column">
            

            <li class="nav-item">
                <form method="POST" action="{{ route('team_lead.logout') }}">
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