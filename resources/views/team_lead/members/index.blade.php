@extends('team_lead.layouts.tl')

@section('title', 'My Team - Skills Hut Ltd')

@push('styles')
<style>
    .page-header-title { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; color: #1A1A1A; margin-bottom: 4px; }
    .page-header-sub { font-size: 0.88rem; color: #7F7F7F; }

    .filter-tabs { display: flex; align-items: center; background: #F4F4F0; border-radius: 8px; padding: 4px; gap: 2px; }
    .filter-tab { padding: 7px 18px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; color: #7F7F7F; cursor: pointer; border: none; background: transparent; transition: all 0.2s; text-decoration: none; }
    .filter-tab:hover { color: #1A1A1A; }
    .filter-tab.active { background: #FF5E2B; color: #fff; }

    /* KPI */
    .kpi-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; padding: 18px 22px; display: flex; justify-content: space-between; align-items: center; }
    .kpi-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; margin-bottom: 4px; }
    .kpi-value { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800; color: #1A1A1A; }
    .kpi-icon { width: 38px; height: 38px; border-radius: 50%; background: #FAF9F6; border: 1px solid #E2E0DD; display: flex; align-items: center; justify-content: center; color: #7F7F7F; font-size: 1rem; }

    /* Table */
    .team-table-wrap { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; overflow: hidden; }
    .team-table { width: 100%; border-collapse: collapse; }
    .team-table thead th { font-size: 0.78rem; font-weight: 700; color: #7F7F7F; letter-spacing: 0.3px; padding: 14px 20px; border-bottom: 1px solid #E2E0DD; text-align: left; background: #fff; }
    .team-table tbody tr { border-bottom: 1px solid #F4F4F0; transition: background 0.15s; }
    .team-table tbody tr:last-child { border-bottom: none; }
    .team-table tbody tr:hover { background: #FAF9F6; }
    .team-table tbody td { padding: 16px 20px; font-size: 0.88rem; color: #1A1A1A; vertical-align: middle; }

    .member-avatar { width: 40px; height: 40px; border-radius: 10px; object-fit: cover; border: 1px solid #E2E0DD; flex-shrink: 0; }
    .member-avatar-placeholder { width: 40px; height: 40px; border-radius: 10px; background: #FFF0EB; color: #FF5E2B; font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 0.82rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .member-name { font-weight: 600; font-size: 0.9rem; color: #1A1A1A; }
    .member-id { font-size: 0.72rem; color: #B2ADA7; font-family: monospace; }

    .status-pill { font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; letter-spacing: 0.4px; display: inline-block; }
    .pill-active   { background: #ECFDF5; color: #059669; }
    .pill-leave    { background: #FFF7ED; color: #EA580C; }
    .pill-inactive { background: #FEE2E2; color: #DC2626; }
    .pill-pending  { background: #FEF3C7; color: #D97706; }

    .btn-message { width: 34px; height: 34px; border-radius: 8px; border: 1px solid #E2E0DD; background: #fff; color: #7F7F7F; display: inline-flex; align-items: center; justify-content: center; font-size: 0.95rem; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .btn-message:hover { background: #FFF0EB; border-color: #FF5E2B; color: #FF5E2B; }

    .pagination-wrap { padding: 14px 20px; border-top: 1px solid #E2E0DD; display: flex; justify-content: space-between; align-items: center; }
    .pagination-info { font-size: 0.78rem; color: #7F7F7F; }
    .pagination { margin-bottom: 0; }
    .page-link { color: #FF5E2B; border-color: #E2E0DD; }
    .page-item.active .page-link { background-color: #FF5E2B; border-color: #FF5E2B; }
</style>
@endpush

@section('content')

@php
    $tl           = auth('tl')->user();
    $departmentId = $tl->employee->department_id ?? null;
    $department   = \App\Models\Department::find($departmentId);

    $membersQuery = \App\Models\Employee::with('department')
        ->where('department_id', $departmentId)
        ->when(request('status'), fn($q) => $q->where('status', request('status')));

    $totalMembers  = (clone $membersQuery)->count();
    $activeMembers = (clone $membersQuery)->where('status', 'active')->count();
    $onLeave       = (clone $membersQuery)->where('status', 'on_leave')->count();

    $members = $membersQuery->latest()->paginate(10)->withQueryString();
@endphp

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <div class="page-header-title">My Team</div>
            <div class="page-header-sub">
                {{ $department->name ?? 'Your Department' }} — Manage your direct reports.
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="filter-tabs">
                <a href="{{ route('team_lead.memberIndex') }}"
                   class="filter-tab {{ !request('status') ? 'active' : '' }}">
                    All
                </a>
                <a href="{{ route('team_lead.memberIndex', ['status' => 'active']) }}"
                   class="filter-tab {{ request('status') === 'active' ? 'active' : '' }}">
                    Active
                </a>
                <a href="{{ route('team_lead.memberIndex', ['status' => 'on_leave']) }}"
                   class="filter-tab {{ request('status') === 'on_leave' ? 'active' : '' }}">
                    On Leave
                </a>
                <a href="{{ route('team_lead.memberIndex', ['status' => 'inactive']) }}"
                   class="filter-tab {{ request('status') === 'inactive' ? 'active' : '' }}">
                    Inactive
                </a>
            </div>
        </div>
    </div>

    {{-- KPI --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div><div class="kpi-label">Total Members</div><div class="kpi-value">{{ $totalMembers }}</div></div>
                <div class="kpi-icon"><i class="bi bi-people"></i></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div><div class="kpi-label">Active</div><div class="kpi-value" style="color:#059669;">{{ $activeMembers }}</div></div>
                <div class="kpi-icon" style="background:#ECFDF5; color:#059669; border-color:#A7F3D0;"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div><div class="kpi-label">On Leave</div><div class="kpi-value" style="color:#EA580C;">{{ $onLeave }}</div></div>
                <div class="kpi-icon" style="background:#FFF7ED; color:#EA580C; border-color:#FED7AA;"><i class="bi bi-calendar-x"></i></div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="team-table-wrap">
        <table class="team-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Employee ID</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($member->profile_picture)
                                <img src="{{ asset('storage/' . $member->profile_picture) }}"
                                     class="member-avatar" alt="{{ $member->name }}">
                            @else
                                <div class="member-avatar-placeholder">
                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <div class="member-name">{{ $member->name }}</div>
                                <div style="font-size:0.72rem; color:#B2ADA7;">{{ $member->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="member-id">{{ $member->employee_id ?? '—' }}</span></td>
                    <td style="color:#7F7F7F;">{{ $member->designation ?? 'N/A' }}</td>
                    <td style="color:#7F7F7F;">{{ $member->department->name ?? 'N/A' }}</td>
                    <td>
                        @php
                            $pillClass = match($member->status ?? 'inactive') {
                                'active'           => 'pill-active',
                                'on_leave'         => 'pill-leave',
                                'pending_approval' => 'pill-pending',
                                default            => 'pill-inactive',
                            };
                        @endphp
                        <span class="status-pill {{ $pillClass }}">
                            {{ strtoupper(str_replace('_', ' ', $member->status ?? 'INACTIVE')) }}
                        </span>
                    </td>
                    <td>
                        <a href="mailto:{{ $member->email }}" class="btn-message" title="Send Email">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#B2ADA7;">
                        <i class="bi bi-people d-block mb-2" style="font-size:2rem;"></i>
                        No team members found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="pagination-wrap">
            <span class="pagination-info">
                Showing {{ $members->firstItem() ?? 0 }}–{{ $members->lastItem() ?? 0 }}
                of {{ $members->total() }} members
            </span>
            {{ $members->links() }}
        </div>
    </div>

@endsection