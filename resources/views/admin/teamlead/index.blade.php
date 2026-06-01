@extends('admin.layouts.admin')

@section('title', 'TL Assignment - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }

    .filter-select {
        border: 1px solid #E2E0DD;
        border-radius: 8px;
        font-size: 0.85rem;
        padding: 9px 36px 9px 14px;
        background: #fff;
        color: #1A1A1A;
        appearance: none;
        cursor: pointer;
        min-width: 180px;
    }
    .filter-select:focus { outline: none; border-color: #FF5E2B; box-shadow: 0 0 0 3px rgba(255,94,43,0.1); }
    .filter-wrap { position: relative; }
    .filter-wrap .bi-chevron-down { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 0.7rem; color: #7F7F7F; pointer-events: none; }

    .kpi-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; padding: 20px 24px; display: flex; justify-content: space-between; align-items: center; }
    .kpi-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #7F7F7F; margin-bottom: 6px; }
    .kpi-value { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #1A1A1A; }
    .kpi-value.orange { color: #FF5E2B; }
    .kpi-icon { width: 40px; height: 40px; border-radius: 50%; background: #FAF9F6; border: 1px solid #E2E0DD; display: flex; align-items: center; justify-content: center; color: #7F7F7F; font-size: 1.1rem; }
    .kpi-icon.orange { background: #FFF3EE; border-color: rgba(255,94,43,0.2); color: #FF5E2B; }

    .tl-table-wrap { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; overflow: hidden; }
    .tl-table { width: 100%; margin: 0; }
    .tl-table thead th { font-size: 0.78rem; font-weight: 700; color: #1A1A1A; padding: 16px 20px; border-bottom: 1px solid #E2E0DD; background: #fff; }
    .tl-table tbody tr { border-bottom: 1px solid #F4F4F0; transition: background 0.15s; }
    .tl-table tbody tr:last-child { border-bottom: none; }
    .tl-table tbody tr:hover { background: #FAF9F6; }
    .tl-table td { padding: 18px 20px; vertical-align: middle; }

    .emp-avatar { width: 38px; height: 38px; border-radius: 50%; background: #F4F4F0; display: flex; align-items: center; justify-content: center; font-size: 0.78rem; font-weight: 700; color: #4A4A4A; flex-shrink: 0; }
    .emp-avatar.tl-avatar { background: #FFF3EE; color: #FF5E2B; }
    .emp-name { font-size: 0.9rem; font-weight: 700; color: #1A1A1A; }
    .emp-id { font-size: 0.75rem; color: #B2ADA7; font-family: monospace; }
    .emp-designation { font-size: 0.85rem; color: #4A4A4A; }

    .badge-member { background: #F4F4F0; color: #4A4A4A; border-radius: 20px; font-size: 0.75rem; font-weight: 600; padding: 5px 12px; display: inline-flex; align-items: center; gap: 5px; }
    .badge-member::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #B2ADA7; display: inline-block; }
    .badge-tl { background: #FFF3EE; color: #FF5E2B; border-radius: 20px; font-size: 0.75rem; font-weight: 700; padding: 5px 12px; display: inline-flex; align-items: center; gap: 5px; }
    .badge-tl::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #FF5E2B; display: inline-block; }

    .btn-assign { background: #FF5E2B; color: #fff; border: none; border-radius: 6px; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.5px; padding: 8px 18px; transition: all 0.2s; }
    .btn-assign:hover { background: #E04B1A; color: #fff; }
    .btn-modify { background: #fff; color: #1A1A1A; border: 1px solid #E2E0DD; border-radius: 6px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; padding: 8px 18px; transition: all 0.2s; }
    .btn-modify:hover { background: #FAF9F6; border-color: #FF5E2B; color: #FF5E2B; }

    .pagination-wrap { padding: 16px 20px; border-top: 1px solid #E2E0DD; display: flex; justify-content: space-between; align-items: center; }
    .pagination-info { font-size: 0.78rem; color: #7F7F7F; font-family: monospace; }
    .pagination { margin-bottom: 0; }
    .page-link { color: #FF5E2B; border-color: #E2E0DD; }
    .page-item.active .page-link { background-color: #FF5E2B; border-color: #FF5E2B; }
</style>
@endpush

@section('content')

@php
    $departments = \App\Models\Department::orderBy('name')->get();

    $employeesQuery = \App\Models\Employee::with('department')
        ->when(request('department_id'), function ($query) {
            $query->where('department_id', request('department_id'));
        });

    $totalMembers = (clone $employeesQuery)->count();
    $assignedLeads = (clone $employeesQuery)->where('role', 'team_lead')->count();
    $openPositions = max(0, $totalMembers - $assignedLeads);

    $employees = $employeesQuery->latest()->paginate(8)->withQueryString();
@endphp

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h1 class="page-title mb-1">Team Lead Assignment</h1>
            <p class="page-subtitle mb-0">Delegate leadership responsibilities to senior staff members.</p>
        </div>

        <form method="GET" action="{{ url()->current() }}">
            <div style="font-size:0.75rem; font-weight:700; color:#7F7F7F; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">
                Filter by Department
            </div>

            <div class="filter-wrap">
                <select name="department_id" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Departments</option>

                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>

                <i class="bi bi-chevron-down"></i>
            </div>
        </form>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div>
                    <div class="kpi-label">Total Members</div>
                    <div class="kpi-value">{{ $totalMembers }}</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-people"></i></div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div>
                    <div class="kpi-label">Assigned Leads</div>
                    <div class="kpi-value orange">{{ $assignedLeads }}</div>
                </div>
                <div class="kpi-icon orange"><i class="bi bi-shield-check"></i></div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div>
                    <div class="kpi-label">Open Positions</div>
                    <div class="kpi-value">{{ $openPositions }}</div>
                </div>
                <div class="kpi-icon"><i class="bi bi-person-plus"></i></div>
            </div>
        </div>
    </div>

    <div class="tl-table-wrap">
        <table class="tl-table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Current Role</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="emp-avatar {{ $employee->role === 'team_lead' ? 'tl-avatar' : '' }}">
                                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                                </div>

                                <div>
                                    <div class="emp-name">{{ $employee->name }}</div>
                                    <div class="emp-id">{{ $employee->employee_id ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="emp-designation">{{ $employee->designation ?? 'N/A' }}</span>
                        </td>

                        <td>
                            <span class="emp-designation">{{ $employee->department->name ?? 'No Department' }}</span>
                        </td>

                        <td>
                            @if($employee->role === 'team_lead')
                                <span class="badge-tl">Team Lead</span>
                            @else
                                <span class="badge-member">Member</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('admin.tl-assignment.toggle', $employee->id) }}" method="POST">
                                @csrf

                                @if($employee->role === 'team_lead')
                                    <button type="submit" class="btn-modify">REMOVE TL</button>
                                @else
                                    <button type="submit" class="btn-assign">ASSIGN AS TL</button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            No employees found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrap">
            <span class="pagination-info">
                Showing {{ $employees->firstItem() ?? 0 }}-{{ $employees->lastItem() ?? 0 }} of {{ $employees->total() }} employees
            </span>

            <div>
                {{ $employees->links() }}
            </div>
        </div>
    </div>

@endsection