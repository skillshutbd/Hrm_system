@extends('hr.layouts.hr')

@section('title', 'Admin Dashboard - Skills Hut Ltd')

@push('styles')
<style>
    /* ===== Base / Mobile-First ===== */
    .kpi-card {
        border-radius: 12px;
        transition: transform 0.2s;
    }
    .kpi-card:hover { transform: translateY(-2px); }

    .kpi-label {
        font-size: 0.7rem;
        letter-spacing: 0.5px;
    }
    .kpi-value {
        font-size: 1.6rem;          /* smaller on mobile */
        font-weight: 700;
        color: #1A1A1A;
    }

    .page-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.35rem;
        font-weight: 700;
    }
    .page-subtitle { font-size: 0.85rem; }

    .btn-brand {
        background-color: #FF5E2B;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        width: 100%;                /* full width on mobile */
        justify-content: center;
    }
    .btn-outline-custom {
        border: 1px solid #E2E0DD;
        color: #4A4A4A;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .btn-outline-custom:hover { background-color: #FAF9F6; }

    .section-card {
        border-radius: 14px;
        border: 1px solid #E2E0DD;
        background: #fff;
        padding: 16px;              /* tighter on mobile */
    }
    .section-title {
        font-family: 'Outfit', sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: #1A1A1A;
    }

    /* Table */
    .table th {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #7F7F7F;
        border-bottom: 1px solid #E2E0DD;
        padding: 10px 10px;
        white-space: nowrap;
    }
    .table td {
        font-size: 0.82rem;
        color: #1A1A1A;
        padding: 12px 10px;
        vertical-align: middle;
        border-bottom: 1px solid #F4F4F0;
    }

    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #FFF0EB;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 700;
        color: #FF5E2B;
        flex-shrink: 0;
    }

    .badge-approved, .badge-pending {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 20px;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-approved { background: #ECFDF5; color: #059669; }
    .badge-pending  { background: #FFF7ED; color: #EA580C; }

    /* Action buttons — wrap on small screens */
    .action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        align-items: center;
    }

    .btn-approve, .btn-reject, .btn-view {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        flex: 1 1 auto;
        text-align: center;
        min-width: 70px;
    }
    .btn-approve {
        background: #FF5E2B; color: #fff; border: none;
    }
    .btn-approve:hover { background: #E04B1A; }
    .btn-reject {
        background: none; border: 1px solid #E2E0DD; color: #DC2626;
    }
    .btn-reject:hover { background: #FEE2E2; }
    .btn-view {
        background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE;
        text-decoration: none;
        display: inline-flex; align-items: center; justify-content: center; gap: 4px;
    }
    .btn-view:hover { background: #2563EB; color: #fff; border-color: #2563EB; }

    .link-brand {
        color: #FF5E2B;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
    }
    .link-brand:hover { text-decoration: underline; }

    .activity-item {
        padding: 12px 0;
        border-bottom: 1px solid #F4F4F0;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-item strong { font-size: 0.85rem; color: #1A1A1A; }
    .activity-item p { font-size: 0.8rem; color: #4A4A4A; margin: 2px 0 0; }
    .activity-item .time { font-size: 0.72rem; color: #B2ADA7; }

    /* ===== Tablet (≥576px) ===== */
    @media (min-width: 576px) {
        .kpi-value { font-size: 1.8rem; }
        .page-title { font-size: 1.5rem; }
        .btn-brand { width: auto; }
        .section-card { padding: 20px; }
    }

    /* ===== Desktop (≥768px) ===== */
    @media (min-width: 768px) {
        .kpi-value { font-size: 2rem; }
        .kpi-label { font-size: 0.75rem; }
        .page-title { font-size: 1.6rem; }
        .section-card { padding: 24px; }
        .section-title { font-size: 1rem; }
        .table th { font-size: 0.72rem; padding: 10px 12px; }
        .table td { font-size: 0.85rem; padding: 14px 12px; }
        .avatar-circle { width: 34px; height: 34px; font-size: 0.78rem; }
        .badge-approved, .badge-pending { font-size: 0.75rem; padding: 4px 10px; }
        .btn-approve, .btn-reject, .btn-view {
            font-size: 0.78rem;
            padding: 5px 12px;
            flex: 0 0 auto;
            min-width: auto;
        }
    }

    /* ===== Large Desktop (≥992px) ===== */
    @media (min-width: 992px) {
        .action-group { flex-wrap: nowrap; }
    }

    /* ===== Prevent horizontal page scroll ===== */
    body { overflow-x: hidden; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-3 mb-4">
    <div>
        <h1 class="page-title mb-1">HR Dashboard</h1>
        <p class="page-subtitle text-muted mb-0">Skills Hut Ltd</p>
    </div>
    <a href="{{ url()->current() }}" class="btn btn-brand d-flex align-items-center gap-2 text-decoration-none">
        <i class="bi bi-arrow-clockwise"></i> Refresh Data
    </a>
</div>

@if(session('success'))
    <div class="alert border-0 rounded-3 mb-4"
         style="background:#ECFDF5;color:#059669;font-size:0.88rem;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

{{-- KPI Cards --}}
<div class="row g-3 g-md-4 mb-4">
    <div class="col-6 col-lg-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm h-100">
            <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between">
                <span class="kpi-label text-uppercase text-muted fw-semibold d-block mb-2">Total Workforce</span>
                <h3 class="kpi-value mb-2">{{ $totalEmployees }}</h3>
                <div class="text-success d-flex align-items-center gap-1">
                    <i class="bi bi-people"></i>
                    <span style="font-size:0.75rem;">Active Employees</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm h-100">
            <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between">
                <span class="kpi-label text-uppercase text-muted fw-semibold d-block mb-2">Departments</span>
                <h3 class="kpi-value mb-2">{{ $totalDepartments }}</h3>
                <div class="text-muted" style="font-size:0.75rem;">Total Departments</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm h-100">
            <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between">
                <span class="kpi-label text-uppercase text-muted fw-semibold d-block mb-2">Pending Approvals</span>
                <h3 class="kpi-value mb-2">{{ $leaveQueue->count() }}</h3>
                <div class="text-warning d-flex align-items-center gap-1">
                    <i class="bi bi-clock"></i>
                    <span style="font-size:0.75rem;">Awaiting HR Action</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-6 col-xl-3">
        <div class="card kpi-card border-0 shadow-sm h-100">
            <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between">
                <span class="kpi-label text-uppercase text-muted fw-semibold d-block mb-2">Recent Activity</span>
                <h3 class="kpi-value mb-2">{{ $recentActivity->count() }}</h3>
                <div class="text-muted" style="font-size:0.75rem;">Last actions taken</div>
            </div>
        </div>
    </div>
</div>

{{-- Approval Queue + Activity Log --}}
<div class="row g-3 g-md-4 mb-4">

    {{-- HR Final Approval Queue --}}
    <div class="col-12 col-lg-7">
        <div class="section-card h-100">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-3">
                <div class="section-title">HR Final Approval Queue</div>
                <a href="{{route('hr_admin.employee_leave.index')}}" class="link-brand">View All Requests</a>
            </div>

            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Employee / Dept</th>
                            <th>TL Status</th>
                            <th>Period</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveQueue as $leave)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($leave->employee->name ?? 'NA', 0, 2)) }}
                                    </div>
                                    <div style="min-width:0;">
                                        <div style="font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">
                                            {{ $leave->employee->name ?? 'N/A' }}
                                        </div>
                                        <div style="font-size:0.72rem;color:#7F7F7F;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">
                                            {{ $leave->employee->department->name ?? 'N/A' }}
                                            • {{ $leave->employee->designation ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-approved">
                                    <i class="bi bi-check-circle me-1"></i>Recommended by TL
                                </span>
                            </td>
                            <td style="font-size:0.8rem;white-space:nowrap;">
                                {{ \Carbon\Carbon::parse($leave->from_date)->format('M d') }} -
                                {{ \Carbon\Carbon::parse($leave->to_date)->format('M d') }}
                            </td>
                            <td>
                                <div class="action-group">
                                    <form method="POST"
                                          action="{{ route('hr.leave.approve', $leave->id) }}"
                                          style="flex:1 1 auto;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-approve w-100">Approve</button>
                                    </form>
                                    <button class="btn-reject"
                                            onclick="openRejectModal({{ $leave->id }})">
                                        Reject
                                    </button>
                                    <a href="{{ route('hr.leave.show', $leave->id) }}" class="btn-view">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4"
                                style="text-align:center;padding:32px;color:#7F7F7F;font-size:0.85rem;">
                                <i class="bi bi-check2-all"
                                   style="font-size:1.5rem;display:block;margin-bottom:8px;color:#E2E0DD;"></i>
                                No pending approvals.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Activity Log --}}
    <div class="col-12 col-lg-5">
        <div class="section-card h-100">
            <div class="section-title mb-3">Recent Activity</div>
            @forelse($recentActivity as $activity)
            <div class="activity-item">
                <strong>{{ $activity->employee->name ?? 'N/A' }}</strong>
                <p>
                    Leave request ({{ $activity->leaveType->name ?? 'N/A' }})
                    @if($activity->status === 'approved')
                        <span style="color:#059669;font-weight:600;">approved by HR</span>
                    @elseif($activity->status === 'rejected')
                        <span style="color:#DC2626;font-weight:600;">rejected by HR</span>
                    @elseif($activity->tl_status === 'recommended')
                        <span style="color:#EA580C;font-weight:600;">recommended by TL</span>
                    @elseif($activity->tl_status === 'not_recommended')
                        <span style="color:#DC2626;font-weight:600;">declined by TL</span>
                    @else
                        <span style="color:#7F7F7F;font-weight:600;">submitted</span>
                    @endif
                </p>
                <span class="time">{{ $activity->updated_at->diffForHumans() }}</span>
            </div>
            @empty
            <div style="text-align:center;padding:32px;color:#7F7F7F;font-size:0.85rem;">
                <i class="bi bi-clock-history"
                   style="font-size:1.5rem;display:block;margin-bottom:8px;color:#E2E0DD;"></i>
                No recent activity.
            </div>
            @endforelse
            <div class="mt-3">
                <a href="{{ route('hr_admin.employee_activity.index') }}"
                   class="btn btn-outline-custom w-100 text-decoration-none d-block text-center"
                   style="font-size:0.82rem;">
                    View Full Audit Log
                </a>
            </div>
        </div>
    </div>

</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content" style="border-radius:14px;border:1px solid #E2E0DD;">
            <div class="modal-header" style="border-bottom:1px solid #F4F4F0;">
                <h6 class="modal-title"
                    style="font-family:'Outfit',sans-serif;font-weight:700;">
                    Reject Leave Request
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <label style="font-size:0.82rem;font-weight:600;color:#4A4A4A;margin-bottom:7px;display:block;">
                        Rejection Note <span class="text-danger">*</span>
                    </label>
                    <textarea name="hr_note" rows="4" required
                              class="form-control"
                              style="border:1px solid #E2E0DD;border-radius:8px;padding:10px 14px;font-size:0.88rem;resize:vertical;"
                              placeholder="Reason for rejection..."></textarea>
                </div>
                <div class="modal-footer" style="border-top:1px solid #F4F4F0;">
                    <button type="button" class="btn btn-sm"
                            style="background:#fff;border:1px solid #E2E0DD;border-radius:8px;font-weight:600;"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm"
                            style="background:#DC2626;color:#fff;border:none;border-radius:8px;font-weight:600;padding:8px 20px;">
                        Confirm Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openRejectModal(leaveId) {
    document.getElementById('rejectForm').action = `/hr_admin/leave/${leaveId}/reject`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endpush