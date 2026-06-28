@extends('admin.layouts.admin')

@section('title', 'Activity Log - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.88rem; color: #7F7F7F; }

    .kpi-card { border: 1px solid #E2E0DD; border-radius: 12px; background: #fff; padding: 18px 22px; display: flex; justify-content: space-between; align-items: center; }
    .kpi-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; margin-bottom: 4px; }
    .kpi-value { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800; color: #1A1A1A; }
    .kpi-icon { width: 38px; height: 38px; border-radius: 50%; background: #FAF9F6; border: 1px solid #E2E0DD; display: flex; align-items: center; justify-content: center; color: #7F7F7F; font-size: 1rem; flex-shrink: 0; }

    /* Filter Tabs */
    .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px; }
    .filter-tab {
        border: 1px solid #E2E0DD; background: #fff; color: #4A4A4A;
        border-radius: 20px; font-size: 0.82rem; font-weight: 600;
        padding: 7px 16px; text-decoration: none; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .filter-tab:hover { border-color: #FF5E2B; color: #FF5E2B; }
    .filter-tab.active { background: #FF5E2B; color: #fff; border-color: #FF5E2B; }
    .filter-tab .count { background: rgba(0,0,0,0.08); border-radius: 10px; padding: 1px 7px; font-size: 0.7rem; }
    .filter-tab.active .count { background: rgba(255,255,255,0.25); }

    /* Date group divider */
    .date-divider {
        font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;
        color: #B2ADA7; padding: 14px 24px 8px; background: #FAFAFA;
        border-bottom: 1px solid #F4F4F0;
    }

    /* Timeline feed */
    .activity-feed { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; overflow: hidden; }
    .activity-row {
        padding: 16px 24px; border-bottom: 1px solid #F4F4F0;
        display: flex; align-items: flex-start; gap: 14px;
        transition: background 0.15s; position: relative;
    }
    .activity-row:last-child { border-bottom: none; }
    .activity-row:hover { background: #FAF9F6; }

    .activity-icon {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem; flex-shrink: 0;
    }
    .activity-icon.approved { background: #ECFDF5; color: #059669; }
    .activity-icon.rejected { background: #FEF2F2; color: #DC2626; }
    .activity-icon.pending  { background: #FFFBEB; color: #D97706; }
    .activity-icon.info     { background: #EFF6FF; color: #3B82F6; }

    .activity-body { flex: 1; min-width: 0; }
    .activity-title-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 3px; }
    .activity-title { font-size: 0.9rem; font-weight: 700; color: #1A1A1A; }
    .activity-desc { font-size: 0.84rem; color: #4A4A4A; line-height: 1.4; }

    /* Time — ডান পাশে fixed column */
    .activity-time {
        font-size: 0.73rem; color: #B2ADA7;
        flex-shrink: 0; text-align: right;
        min-width: 110px;
        display: flex; flex-direction: column; align-items: flex-end; gap: 2px;
        padding-top: 2px;
    }
    .activity-time .time-exact { font-weight: 600; color: #7F7F7F; }
    .activity-time .time-relative { font-size: 0.7rem; }

    .badge-by-hr    { background: #F4F4F0; color: #4A4A4A; font-size: 0.66rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; }
    .badge-by-admin { background: #FFF3EE; color: #FF5E2B; font-size: 0.66rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; }

    .category-badge { font-size: 0.65rem; font-weight: 700; padding: 2px 9px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.4px; white-space: nowrap; }
    .category-leave                  { background: #EFF6FF; color: #3B82F6; }
    .category-tl_assignment_request  { background: #FFF3EE; color: #FF5E2B; }
    .category-employee_creation      { background: #ECFDF5; color: #059669; }
</style>
@endpush

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h1 class="page-title mb-1">Activity Log</h1>
            <p class="page-subtitle mb-0">Full audit trail of leave actions, employee additions, and TL assignments.</p>
        </div>
        <a href="{{ url()->current() }}" class="btn btn-brand d-flex align-items-center gap-2 text-decoration-none">
            <i class="bi bi-arrow-clockwise"></i> Refresh
        </a>
    </div>

    {{-- KPI --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div><div class="kpi-label">Total Events</div><div class="kpi-value">{{ $totalActivities }}</div></div>
                <div class="kpi-icon"><i class="bi bi-list-check"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div><div class="kpi-label">Leave Activities</div><div class="kpi-value" style="color:#3B82F6;">{{ $leaveCount }}</div></div>
                <div class="kpi-icon" style="background:#EFF6FF; color:#3B82F6; border-color:#BFDBFE;"><i class="bi bi-calendar2-check"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div><div class="kpi-label">TL Assignments</div><div class="kpi-value" style="color:#FF5E2B;">{{ $assignmentCount }}</div></div>
                <div class="kpi-icon" style="background:#FFF3EE; color:#FF5E2B; border-color:rgba(255,94,43,0.2);"><i class="bi bi-person-check"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div><div class="kpi-label">New Employees</div><div class="kpi-value" style="color:#059669;">{{ $employeeAddCount }}</div></div>
                <div class="kpi-icon" style="background:#ECFDF5; color:#059669; border-color:#A7F3D0;"><i class="bi bi-person-plus"></i></div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="filter-tabs">
        <a href="{{ route('admin.employee_activity.index') }}" class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">
            All <span class="count">{{ $totalActivities }}</span>
        </a>
        <a href="{{ route('admin.employee_activity.index', ['filter' => 'leave']) }}" class="filter-tab {{ $filter === 'leave' ? 'active' : '' }}">
            <i class="bi bi-calendar2-check"></i> Leave <span class="count">{{ $leaveCount }}</span>
        </a>
        <a href="{{ route('admin.employee_activity.index', ['filter' => 'assignment']) }}" class="filter-tab {{ $filter === 'assignment' ? 'active' : '' }}">
            <i class="bi bi-person-check"></i> TL Assignment <span class="count">{{ $assignmentCount }}</span>
        </a>
        <a href="{{ route('admin.employee_activity.index', ['filter' => 'employee']) }}" class="filter-tab {{ $filter === 'employee' ? 'active' : '' }}">
            <i class="bi bi-person-plus"></i> New Employee <span class="count">{{ $employeeAddCount }}</span>
        </a>
    </div>

    {{-- Feed grouped by date --}}
    <div class="activity-feed">
        @php $lastDate = null; @endphp

        @forelse($activities as $activity)
            @php
                $dateLabel = $activity->created_at->isToday()
                    ? 'Today'
                    : ($activity->created_at->isYesterday() ? 'Yesterday' : $activity->created_at->format('F j, Y'));
            @endphp

            @if($dateLabel !== $lastDate)
                <div class="date-divider">{{ $dateLabel }}</div>
                @php $lastDate = $dateLabel; @endphp
            @endif

            <div class="activity-row">
                <div class="activity-icon {{ $activity->type }}">
                    <i class="bi {{ $activity->icon }}"></i>
                </div>

                <div class="activity-body">
                    <div class="activity-title-row">
                        <span class="activity-title">{{ $activity->title }}</span>
                        <span class="category-badge category-{{ $activity->category }}">
                            {{ str_replace('_', ' ', $activity->category) }}
                        </span>
                    </div>
                    <div class="activity-desc">
                        {{ $activity->desc }}
                        @if($activity->approver === 'hr_admin')
                            <span class="badge-by-hr ms-1">by HR</span>
                        @elseif($activity->approver === 'super_admin')
                            <span class="badge-by-admin ms-1">by Admin</span>
                        @endif
                    </div>
                </div>

                {{-- Time — ডান পাশে fixed column --}}
                <div class="activity-time">
                    <span class="time-exact">{{ $activity->created_at->format('h:i A') }}</span>
                    <span class="time-relative">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <div class="text-center py-5" style="color:#B2ADA7;">
                <i class="bi bi-clock-history d-block mb-2" style="font-size:2rem;"></i>
                No activity recorded yet.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <span style="font-size:0.82rem; color:#7F7F7F;">
            Showing {{ $activities->firstItem() ?? 0 }}–{{ $activities->lastItem() ?? 0 }} of {{ $activities->total() }}
        </span>
        {{ $activities->links() }}
    </div>

@endsection