<aside class="app-sidebar" id="sidebar">

    <div class="sidebar-brand">
       
        <div class="brand-text ms-3">
              <img src="{{ asset('images/logo.png') }}" alt="Admin Avatar" class="profile-avatar border border-2 border-brand">
           
        </div>
    </div>

    <nav class="sidebar-nav my-4">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="{{route('employee.dashboard')}}" class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill me-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>

         
              
            

            <li class="nav-item">
                <a href="{{ route('admin.employee_leave.index') }}" class="nav-link {{ request()->routeIs('admin.employee_leave.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event-fill me-3"></i>
                    <span>Leave Requests</span>
                </a>
            </li>

        </ul>
    </nav>

   
       
  

    <div class="sidebar-bottom mt-auto">
        <hr class="sidebar-divider">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('hr_profile.edit') }}" class="nav-link py-2 ">
                    <i class="bi bi-gear-fill me-3"></i>
                    <span>Settings</span>
                </a>
            </li>

            <li class="nav-item">
                <form method="POST" action="{{route('employee.logout')}}">
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