@extends('hr.layouts.hr')

@section('title', 'Employee Directory - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.88rem; color: #7F7F7F; }

    .btn-export { background: #fff; border: 1px solid #E2E0DD; color: #1A1A1A; border-radius: 8px; font-weight: 600; font-size: 0.88rem; padding: 10px 20px; transition: all 0.2s; }
    .btn-export:hover { background: #FAF9F6; }
    .btn-add-emp { background: #FF5E2B; color: #fff; border: none; border-radius: 8px; font-weight: 600; font-size: 0.88rem; padding: 10px 20px; transition: all 0.2s; text-decoration: none; }
    .btn-add-emp:hover { background: #E04B1A; color: #fff; }

    .filter-bar { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; padding: 14px 20px; }
    .filter-select { border: 1px solid #E2E0DD; border-radius: 8px; font-size: 0.85rem; color: #1A1A1A; padding: 7px 32px 7px 12px; background: #FAF9F6; appearance: none; cursor: pointer; }
    .filter-select:focus { outline: none; border-color: #FF5E2B; box-shadow: 0 0 0 3px rgba(255,94,43,0.1); }
    .view-toggle { border: 1px solid #E2E0DD; border-radius: 8px; overflow: hidden; display: flex; }
    .view-btn { background: none; border: none; padding: 7px 10px; color: #7F7F7F; transition: all 0.2s; }
    .view-btn.active { background: #FF5E2B; color: #fff; }
    .view-btn:hover:not(.active) { background: #FAF9F6; }

    .emp-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; padding: 20px; transition: all 0.2s; height: 100%; }
    .emp-card:hover { border-color: #FF5E2B; box-shadow: 0 4px 16px rgba(255,94,43,0.08); transform: translateY(-2px); }

    .emp-photo-wrap { position: relative; display: inline-block; margin-bottom: 14px; }
    .emp-photo { width: 72px; height: 72px; border-radius: 10px; object-fit: cover; filter: grayscale(20%); }

    .status-badge { position: absolute; top: -8px; right: -8px; font-size: 0.65rem; font-weight: 700; padding: 3px 8px; border-radius: 20px; letter-spacing: 0.3px; }
    .status-active { background: #ECFDF5; color: #059669; }
    .status-inactive { background: #F4F4F0; color: #7F7F7F; }

    .emp-name { font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 700; color: #1A1A1A; margin-bottom: 2px; }
    .emp-role { font-size: 0.78rem; font-weight: 600; color: #FF5E2B; margin-bottom: 4px; }
    .emp-dept { font-size: 0.78rem; color: #7F7F7F; display: flex; align-items: center; gap: 4px; }

    .emp-divider { border-color: #F4F4F0; margin: 14px 0; }

    .emp-avatar-initials { width: 30px; height: 30px; border-radius: 50%; background: #F4F4F0; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #4A4A4A; }
    .link-view { color: #FF5E2B; font-size: 0.82rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 4px; }
    .link-view:hover { text-decoration: underline; color: #E04B1A; }

    .emp-card-add { background: #fff; border: 2px dashed #C0BAB4; border-radius: 14px; padding: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 220px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .emp-card-add:hover { border-color: #FF5E2B; background: #FFF8F5; }
    .add-icon { width: 44px; height: 44px; border-radius: 50%; background: #F4F4F0; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: #7F7F7F; margin-bottom: 10px; transition: all 0.2s; }
    .emp-card-add:hover .add-icon { background: #FF5E2B; color: #fff; }
    .add-label { font-size: 0.85rem; color: #7F7F7F; font-weight: 500; }

    .pagination-info { font-size: 0.82rem; color: #7F7F7F; }

    .pagination { margin-bottom: 0; }
    .page-link { color: #FF5E2B; border-color: #E2E0DD; }
    .page-item.active .page-link { background-color: #FF5E2B; border-color: #FF5E2B; }
</style>
@endpush

@section('content')

@php
    $departments = \App\Models\Department::orderBy('name')->get();

    $employees = \App\Models\Employee::with('department')
        ->when(request('department_id'), function ($query) {
            $query->where('department_id', request('department_id'));
        })
        ->when(request('role'), function ($query) {
            $query->where('role', request('role'));
        })
        ->when(request('status'), function ($query) {
            $query->where('status', request('status'));
        })
        ->latest()
        ->paginate(8)
        ->withQueryString();
@endphp

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title mb-1">Employee Directory</h1>
            <p class="page-subtitle mb-0">Manage and view all team members across the organization.</p>
        </div>

        <div class="d-flex gap-2">
        <a href="{{ route('employee.export-csv') }}" class="btn-export d-flex align-items-center gap-2 text-decoration-none">
             <i class="bi bi-download"></i> Export
        </a>
     
        

                <a href="{{ route('hr_admin.employee.create') }}" class="btn-add-emp d-flex align-items-center gap-2">
                    <i class="bi bi-person-plus"></i> Add Employee
                </a>
            
            
        </div>

    </div>

    <form method="GET" action="{{ route('admin.employee.index') }}" class="filter-bar d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span style="font-size:0.82rem; font-weight:600; color:#7F7F7F;">Filter by:</span>

            <div style="position:relative;">
                <select name="department_id" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Departments</option>

                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:0.7rem;color:#7F7F7F;pointer-events:none;"></i>
            </div>

            <div style="position:relative;">
                <select name="role" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="hr" {{ request('role') == 'hr' ? 'selected' : '' }}>HR</option>
                    <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                    <option value="team_lead" {{ request('role') == 'team_lead' ? 'selected' : '' }}>Team Lead</option>
                </select>
                <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:0.7rem;color:#7F7F7F;pointer-events:none;"></i>
            </div>

            <div style="position:relative;">
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Status: All</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:0.7rem;color:#7F7F7F;pointer-events:none;"></i>
            </div>

            @if(request('department_id') || request('role') || request('status'))
                <a href="{{ route('admin.employee.index') }}" class="btn-export d-flex align-items-center gap-2 text-decoration-none">
                    <i class="bi bi-x-lg"></i> Clear
                </a>
            @endif
        </div>

        <div class="view-toggle">
            <button type="button" class="view-btn active" id="grid-view"><i class="bi bi-grid"></i></button>
            <button type="button" class="view-btn" id="list-view"><i class="bi bi-list-ul"></i></button>
        </div>
    </form>

    <div class="row g-3 mb-4">

        @forelse($employees as $employee)
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="emp-card">
                    <div class="emp-photo-wrap">
                        @if($employee->profile_picture)
                            <img src="{{ asset('storage/' . $employee->profile_picture) }}" class="emp-photo" alt="{{ $employee->name }}">
                        @else
                            <img src="{{ asset('images/admin_avatar.png') }}" class="emp-photo" alt="{{ $employee->name }}">
                        @endif

                        <span class="status-badge {{ $employee->status === 'active' ? 'status-active' : 'status-inactive' }}">
                            {{ strtoupper($employee->status) }}
                        </span>
                    </div>

                    <div class="emp-name">{{ $employee->name }}</div>
                    <div class="emp-role">{{ $employee->designation ?? 'N/A' }}</div>

                    <div class="emp-dept">
                        <i class="bi bi-building" style="font-size:0.7rem;"></i>
                        {{ $employee->department->name ?? 'No Department' }}
                    </div>

                    <hr class="emp-divider">

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="emp-avatar-initials">
                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                        </div>

                        <a href="{{ route('admin.employee.show', $employee->id) }}" class="link-view">
                            View Profile <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="emp-card text-center">
                    <p class="mb-0">No employees found.</p>
                </div>
            </div>
        @endforelse

        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.employee.create') }}" class="emp-card-add">
                <div class="add-icon"><i class="bi bi-plus-lg"></i></div>
                <div class="add-label">Add New Employee</div>
            </a>
        </div>

    </div>

    <div class="d-flex justify-content-between align-items-center">
        <span class="pagination-info">
            Showing {{ $employees->firstItem() ?? 0 }} to {{ $employees->lastItem() ?? 0 }} of {{ $employees->total() }} employees
        </span>

        <div>
            {{ $employees->links() }}
        </div>
    </div>

@endsection