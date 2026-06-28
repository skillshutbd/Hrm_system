@extends('admin.layouts.admin')

@section('title', 'Activity Log - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.88rem; color: #7F7F7F; }

    .kpi-card { border: 1px solid #E2E0DD; border-radius: 12px; background: #fff; padding: 18px 22px; }
    .kpi-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; margin-bottom: 4px; }
    .kpi-value { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800; color: #1A1A1A; }

    .activity-feed { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; overflow: hidden; }
    .activity-row { padding: 18px 24px; border-bottom: 1px solid #F4F4F0; display: flex; align-items: flex-start; gap: 14px; transition: background 0.15s; }
    .activity-row:last-child { border-bottom: none; }
    .activity-row:hover { background: #FAF9F6; }

    .activity-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .activity-icon.approved { background: #ECFDF5; color: #059669; }
    .activity-icon.rejected { background: #FEF2F2; color: #DC2626; }
    .activity-icon.pending  { background: #FFFBEB; color: #D97706; }
    .activity-icon.info     { background: #EFF6FF; color: #3B82F6; }

    .activity-body { flex: 1; min-width: 0; }
    .activity-title { font-size: 0.9rem; font-weight: 700; color: #1A1A1A; margin-bottom: 2px; }
    .activity-desc { font-size: 0.84rem; color: #4A4A4A; }
    .activity-time { font-size: 0.74rem; color: #B2ADA7; margin-top: 4px; display: flex; align-items: center; gap: 4px; }

    .badge-by-hr    { background: #F4F4F0; color: #4A4A4A; font-size: 0.68rem; font-weight: 700; padding: 3px 8px; border-radius: 20px; }
    .badge-by-admin { background: #FFF3EE; color: #FF5E2B; font-size: 0.68rem; font-weight: 700; padding: 3px 8px; border-radius: 20px; }

    .category-badge { font-size: 0.68rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.4px; }
    .category-leave  { background: #EFF6FF; color: #3B82F6; }
    .category-tl_assignment_request { background: #FFF3EE; color: #FF5E2B; }
    .category-employee_creation     { background: #ECFDF5; color: #059669; }
</style>
@endpush

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title mb-1">Activity Log</h1>
            <p class="page-subtitle mb-0">Full audit trail of leave actions, employee additions, and TL assignments.</p>
        </div>
    </div>

    {{-- KPI --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div class="kpi-label">Total Events</div>
                <div class="kpi-value">{{ $totalActivities }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div class="kpi-label">Leave Activities</div>
                <div class="kpi-value" style="color:#3B82F6;">{{ $leaveCount }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div class="kpi-label">TL Assignments</div>
                <div class="kpi-value" style="color:#FF5E2B;">{{ $assignmentCount }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div class="kpi-label">New Employees</div>
                <div class="kpi-value" style="color:#059669;">{{ $employeeAddCount }}</div>
            </div>
        </div>
    </div>

    {{-- Feed --}}
    <div class="activity-feed">
        @forelse($activities as $activity)
            <div class="activity-row">
                <div class="activity-icon {{ $activity->type }}">
                    <i class="bi {{ $activity->icon }}"></i>
                </div>
                <div class="activity-body">
                    <div class="activity-title">
                        {{ $activity->title }}
                        <span class="category-badge category-{{ $activity->category }} ms-2">
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
                    <div class="activity-time">
                        <i class="bi bi-clock" style="font-size:0.65rem;"></i>
                        {{ $activity->created_at->diffForHumans() }}
                    </div>
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