@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard - Skills Hut Ltd')

@push('styles')
<style>
    .kpi-card { border-radius: 12px; transition: transform 0.2s; }
    .kpi-card:hover { transform: translateY(-2px); }
    .kpi-label { font-size: 0.75rem; letter-spacing: 0.5px; }
    .kpi-value { font-size: 2rem; font-weight: 700; color: #1A1A1A; }
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; }
    .page-subtitle { font-size: 0.9rem; }
    .btn-brand { background-color: #FF5E2B; color: #fff; border: none; border-radius: 8px; font-weight: 600; font-size: 0.88rem; }
    .btn-brand:hover { background-color: #E04B1A; color: #fff; }
    .btn-outline-custom { border: 1px solid #E2E0DD; color: #4A4A4A; border-radius: 8px; font-weight: 600; font-size: 0.88rem; }
    .btn-outline-custom:hover { background-color: #FAF9F6; }

    .workflow-card { border-radius: 16px; border: 1px solid #E2E0DD; background: #fff; padding: 28px; }
    .workflow-badge { background: #FF5E2B; color: #fff; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; letter-spacing: 0.5px; }
    .workflow-step { border: 1px solid #E2E0DD; border-radius: 12px; padding: 20px; text-align: center; flex: 1; position: relative; }
    .workflow-step.active { border-color: #FF5E2B; background: #FFF8F5; }
    .workflow-step-icon { width: 48px; height: 48px; border-radius: 10px; border: 1px solid #E2E0DD; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 1.2rem; color: #4A4A4A; }
    .workflow-step.active .workflow-step-icon { border-color: #FF5E2B; color: #FF5E2B; background: #fff; }
    .workflow-step-title { font-size: 0.88rem; font-weight: 700; color: #1A1A1A; margin-bottom: 4px; }
    .workflow-step.active .workflow-step-title { color: #FF5E2B; }
    .workflow-step-desc { font-size: 0.78rem; color: #7F7F7F; }
    .workflow-connector { display: flex; align-items: center; padding: 0 8px; color: #C0BAB4; font-size: 1.2rem; }
    .step-badge { position: absolute; top: -10px; right: -10px; background: #FF5E2B; color: #fff; font-size: 0.7rem; font-weight: 700; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

    .section-card { border-radius: 16px; border: 1px solid #E2E0DD; background: #fff; padding: 24px; }
    .section-title { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #1A1A1A; }
    .table th { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #7F7F7F; border-bottom: 1px solid #E2E0DD; padding: 10px 12px; }
    .table td { font-size: 0.85rem; color: #1A1A1A; padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid #F4F4F0; }
    .avatar-circle { width: 34px; height: 34px; border-radius: 50%; background: #E2E0DD; display: flex; align-items: center; justify-content: center; font-size: 0.78rem; font-weight: 700; color: #4A4A4A; flex-shrink: 0; }
    .badge-approved { background: #ECFDF5; color: #059669; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
    .badge-recommended { background: #EFF6FF; color: #3B82F6; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; }
    .badge-skipped { background: #FEF3C7; color: #D97706; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; }
    .badge-by-hr { background: #F4F4F0; color: #4A4A4A; font-size: 0.68rem; font-weight: 700; padding: 3px 8px; border-radius: 20px; }
    .badge-by-admin { background: #FFF3EE; color: #FF5E2B; font-size: 0.68rem; font-weight: 700; padding: 3px 8px; border-radius: 20px; }
    .btn-approve { background: #FF5E2B; color: #fff; border: none; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 5px 12px; }
    .btn-approve:hover { background: #E04B1A; color: #fff; }
    .btn-reject { background: none; border: 1px solid #E2E0DD; color: #4A4A4A; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 5px 12px; }
    .btn-reject:hover { background: #FAF9F6; }
    .link-brand { color: #FF5E2B; font-size: 0.82rem; font-weight: 600; text-decoration: none; }
    .link-brand:hover { text-decoration: underline; }

    .activity-item { padding: 12px 0; border-bottom: 1px solid #F4F4F0; }
    .activity-item:last-child { border-bottom: none; }
    .activity-item strong { font-size: 0.85rem; color: #1A1A1A; }
    .activity-item p { font-size: 0.82rem; color: #4A4A4A; margin: 2px 0 0; }
    .activity-item .time { font-size: 0.75rem; color: #B2ADA7; }
</style>
@endpush

@section('content')

    @if(session('success'))
        <div class="alert alert-success py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Admin Dashboard</h1>
            <p class="page-subtitle text-muted mb-0">Skills Hut Ltd</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url()->current() }}" class="btn btn-brand d-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-arrow-clockwise"></i> Refresh Data
            </a>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <span class="kpi-label text-uppercase text-muted fw-semibold d-block mb-2">Total Workforce</span>
                    <h3 class="kpi-value mb-2">{{ $totalEmployees }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <span class="kpi-label text-uppercase text-muted fw-semibold d-block mb-2">Departments</span>
                    <h3 class="kpi-value mb-2">{{ $totalDepartments }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <span class="kpi-label text-uppercase text-muted fw-semibold d-block mb-2">Team Leads</span>
                    <h3 class="kpi-value mb-2">{{ $totalTeamLeads }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card kpi-card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <span class="kpi-label text-uppercase text-muted fw-semibold d-block mb-2">Pending Approvals</span>
                    <h3 class="kpi-value mb-2" style="color:#D97706;">{{ $pendingLeaves->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Leave Approval Workflow --}}
    <!-- <div class="workflow-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <div class="section-title">Leave Approval Workflow</div>
                <div style="font-size:0.82rem; color:#7F7F7F;">Three-tier verification architecture</div>
            </div>
            <span class="workflow-badge">PHASE 1 ACTIVE</span>
        </div>
        <div class="d-flex align-items-stretch gap-2">
            <div class="workflow-step">
                <div class="workflow-step-icon"><i class="bi bi-person"></i></div>
                <div class="workflow-step-title">1. Employee Request</div>
                <div class="workflow-step-desc">Submits leave application through dedicated portal</div>
            </div>
            <div class="workflow-connector"><i class="bi bi-chevron-right"></i></div>
            <div class="workflow-step active">
                <div class="step-badge">{{ $pendingLeaves->count() }}</div>
                <div class="workflow-step-icon"><i class="bi bi-people"></i></div>
                <div class="workflow-step-title">2. Team Lead Review</div>
                <div class="workflow-step-desc">First-line operational approval & resource check</div>
            </div>
            <div class="workflow-connector"><i class="bi bi-chevron-right"></i></div>
            <div class="workflow-step">
                <div class="workflow-step-icon"><i class="bi bi-shield-check"></i></div>
                <div class="workflow-step-title">3. HR Admin Final</div>
                <div class="workflow-step-desc">Policy compliance check & final system record</div>
            </div>
        </div>
    </div> -->

    {{-- Approval Queue + Activity Log --}}
    <div class="row g-4 mb-4">

        {{-- Final Approval Queue (HR এর কাজ — Admin ও করতে পারবে যদি HR মিস করে) --}}
        <div class="col-12 col-lg-7">
            <div class="section-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="section-title">Final Approval Queue</div>
                    <a href="{{ route('admin.employee_leave.index') }}" class="link-brand">View All Requests</a>
                </div>

                @if($pendingLeaves->isEmpty())
                    <div class="text-center py-4" style="color:#B2ADA7;">
                        <i class="bi bi-check-circle d-block mb-2" style="font-size:2rem; color:#A7F3D0;"></i>
                        <p style="font-size:0.88rem;">No pending approvals. HR is on top of things.</p>
                    </div>
                @else
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
                        @foreach($pendingLeaves as $leave)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle">{{ strtoupper(substr($leave->employee->name ?? '?', 0, 2)) }}</div>
                                    <div>
                                        <div style="font-weight:600;">{{ $leave->employee->name ?? 'Unknown' }}</div>
                                        <div style="font-size:0.75rem; color:#7F7F7F;">
                                            {{ $leave->employee->designation ?? '' }}
                                            @if($leave->employee?->department) • {{ $leave->employee->department->name }} @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($leave->tl_status === 'recommended')
                                    <span class="badge-recommended"><i class="bi bi-check-circle me-1"></i>Recommended by TL</span>
                                @elseif($leave->tl_status === 'skipped')
                                    <span class="badge-skipped"><i class="bi bi-skip-forward me-1"></i>TL Skipped (on leave)</span>
                                @else
                                    <span class="badge-recommended">{{ ucfirst($leave->tl_status) }}</span>
                                @endif
                            </td>
                            <td style="font-size:0.82rem;">
                                {{ \Carbon\Carbon::parse($leave->from_date)->format('M d') }} -
                                {{ \Carbon\Carbon::parse($leave->to_date)->format('M d') }}
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <form method="POST" action="{{ route('admin.leave.approve', $leave->id) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-approve">APPROVE</button>
                                    </form>
                                    <button class="btn-reject" onclick="openAdminRejectModal({{ $leave->id }})">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

        {{-- System Activity Log --}}
     <div class="col-12 col-lg-5">
    <div class="section-card h-100">
        <div class="section-title mb-3">System Activity Log</div>

        @forelse($recentLeaveActivity as $activity)
            <div class="activity-item">
                <strong>{{ $activity->title }}</strong>
                <p>
                    {{ $activity->desc }}
                    @if($activity->approver === 'hr_admin')
                        <span class="badge-by-hr ms-1">by HR</span>
                    @elseif($activity->approver === 'super_admin')
                        <span class="badge-by-admin ms-1">by Admin</span>
                    @endif
                </p>
                <span class="time">{{ $activity->created_at->diffForHumans() }}</span>
            </div>
        @empty
            <div class="text-center py-4" style="color:#B2ADA7; font-size:0.85rem;">
                No recent activity.
            </div>
        @endforelse

        <div class="mt-3">
            <a href="{{route('admin.employee_activity.index')}}" class="btn btn-outline-custom w-100 text-decoration-none d-block text-center" style="font-size:0.82rem;">
                View Full Audit Log
            </a>
        </div>
    </div>
</div>
        </div>

    </div>

    {{-- Recently Approved by HR --}}
    <div class="section-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="section-title">Recently Approved Leaves</div>
            <span style="font-size:0.78rem; color:#7F7F7F;">Visibility into both HR and Admin approvals</span>
        </div>

        @if($approvedLeaves->isEmpty())
            <div class="text-center py-4" style="color:#B2ADA7; font-size:0.88rem;">
                No leaves approved yet.
            </div>
        @else
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Period</th>
                  
                </tr>
            </thead>
            <tbody>
                @foreach($approvedLeaves as $leave)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-circle">{{ strtoupper(substr($leave->employee->name ?? '?', 0, 2)) }}</div>
                            <div style="font-weight:600;">{{ $leave->employee->name ?? 'Unknown' }}</div>
                        </div>
                    </td>
                    <td>{{ $leave->leaveType->name ?? '—' }}</td>
                    <td style="font-size:0.82rem;">
                        {{ \Carbon\Carbon::parse($leave->from_date)->format('M d') }} -
                        {{ \Carbon\Carbon::parse($leave->to_date)->format('M d') }}
                    </td>
                
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Admin Reject Modal --}}
    <div class="modal fade" id="adminRejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:14px;border:1px solid #E2E0DD;">
                <div class="modal-header" style="border-bottom:1px solid #F4F4F0;">
                    <h6 class="modal-title" style="font-family:'Outfit',sans-serif;font-weight:700;">Reject Leave Request</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="adminRejectForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <label style="font-size:0.82rem;font-weight:600;color:#4A4A4A;margin-bottom:7px;display:block;">
                            Reason for Rejection <span class="text-danger">*</span>
                        </label>
                        <textarea name="hr_note" rows="4" required
                                  style="width:100%;border:1px solid #E2E0DD;border-radius:8px;padding:10px 14px;font-size:0.88rem;resize:vertical;"
                                  placeholder="Explain why this leave is being rejected..."></textarea>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #F4F4F0;">
                        <button type="button" class="btn btn-sm" style="background:#fff;border:1px solid #E2E0DD;border-radius:8px;font-weight:600;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm" style="background:#DC2626;color:#fff;border:none;border-radius:8px;font-weight:600;padding:8px 20px;">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    const ADMIN_LEAVE_BASE_URL = "{{ url('/admin/leave') }}";

    function openAdminRejectModal(leaveId) {
        document.getElementById('adminRejectForm').action = `${ADMIN_LEAVE_BASE_URL}/${leaveId}/reject`;
        new bootstrap.Modal(document.getElementById('adminRejectModal')).show();
    }
</script>
@endpush