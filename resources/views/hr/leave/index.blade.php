@extends('hr.layouts.hr')

@section('title', 'Leave Management - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }

    .kpi-stat { border: 1px solid #E2E0DD; border-radius: 10px; padding: 14px 20px; background: #fff; min-width: 130px; }
    .kpi-stat-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; margin-bottom: 4px; }
    .kpi-stat-value { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800; color: #FF5E2B; }

    .filter-bar { background: #fff; border: 1px solid #E2E0DD; border-radius: 10px; padding: 14px 20px; }
    .filter-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #7F7F7F; margin-bottom: 5px; }
    .filter-select { border: 1px solid #E2E0DD; border-radius: 7px; font-size: 0.82rem; padding: 7px 28px 7px 10px; background: #FAF9F6; color: #1A1A1A; appearance: none; cursor: pointer; }
    .filter-select:focus { outline: none; border-color: #FF5E2B; }
    .filter-date-input { border: 1px solid #E2E0DD; border-radius: 7px; font-size: 0.82rem; padding: 7px 10px; background: #FAF9F6; color: #1A1A1A; }
    .btn-export { border: 1px solid #E2E0DD; background: #fff; color: #1A1A1A; border-radius: 8px; font-size: 0.82rem; font-weight: 600; padding: 8px 18px; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-export:hover { background: #FAF9F6; color: #1A1A1A; }

    .leave-table-wrap { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; overflow: hidden; }
    .leave-table { width: 100%; margin: 0; }
    .leave-table thead th { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; padding: 14px 20px; border-bottom: 1px solid #E2E0DD; background: #FAFAFA; }
    .leave-table tbody tr { border-bottom: 1px solid #F4F4F0; transition: background 0.15s; }
    .leave-table tbody tr:last-child { border-bottom: none; }
    .leave-table tbody tr:hover { background: #FAF9F6; }
    .leave-table td { padding: 18px 20px; vertical-align: middle; font-size: 0.85rem; color: #1A1A1A; }

    .emp-avatar { width: 40px; height: 40px; border-radius: 50%; background: #F4F4F0; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; color: #4A4A4A; flex-shrink: 0; }
    .emp-name { font-size: 0.88rem; font-weight: 700; color: #1A1A1A; }
    .emp-role { font-size: 0.75rem; color: #7F7F7F; }

    .leave-type { font-size: 0.85rem; color: #1A1A1A; }
    .duration-date { font-size: 0.85rem; color: #1A1A1A; }
    .duration-year { font-size: 0.75rem; color: #B2ADA7; }
    .days-count { font-size: 0.85rem; font-weight: 600; color: #1A1A1A; }

    .badge-pending  { background: #FEF3C7; color: #D97706; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }
    .badge-approved { background: #ECFDF5; color: #059669; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }
    .badge-rejected { background: #FEF2F2; color: #DC2626; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }

    .tl-status-tag { font-size: 0.68rem; color: #7F7F7F; margin-top: 3px; display: block; }

    .btn-approve { background: #FF5E2B; color: #fff; border: none; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 6px 14px; transition: all 0.2s; display: flex; align-items: center; gap: 4px; }
    .btn-approve:hover { background: #E04B1A; color: #fff; }
    .btn-reject { background: #fff; color: #DC2626; border: 1px solid #DC2626; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 6px 14px; transition: all 0.2s; display: flex; align-items: center; gap: 4px; }
    .btn-reject:hover { background: #FEF2F2; }
    .btn-view { background: #fff; border: 1px solid #E2E0DD; color: #4A4A4A; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 6px 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; }
    .btn-view:hover { border-color: #FF5E2B; color: #FF5E2B; }

    .trends-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; padding: 24px; }
    .trends-title { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #1A1A1A; margin-bottom: 4px; }
    .trends-subtitle { font-size: 0.78rem; color: #7F7F7F; margin-bottom: 20px; }

    .staff-card { background: #8B3A0F; border-radius: 12px; padding: 24px; color: #fff; }
    .staff-title { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
    .staff-subtitle { font-size: 0.78rem; color: rgba(255,255,255,0.65); margin-bottom: 16px; }
    .staff-item { background: rgba(255,255,255,0.1); border-radius: 8px; padding: 12px 14px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .staff-avatar { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.78rem; color: #fff; flex-shrink: 0; }
    .staff-name { font-size: 0.85rem; font-weight: 700; color: #fff; }
    .staff-status { font-size: 0.72rem; color: rgba(255,255,255,0.65); }
    .staff-icon { color: rgba(255,255,255,0.7); font-size: 1rem; }
</style>
@endpush

@section('content')

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h1 class="page-title mb-1">Leave Management</h1>
            <p class="page-subtitle mb-0">Review and manage employee time-off requests.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="kpi-stat">
                <div class="kpi-stat-label">Pending</div>
                <div class="kpi-stat-value">{{ str_pad($pendingCount, 2, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="kpi-stat">
                <div class="kpi-stat-label">Approved Today</div>
                <div class="kpi-stat-value">{{ str_pad($approvedTodayCount, 2, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="kpi-stat">
                <div class="kpi-stat-label">On Leave Today</div>
                <div class="kpi-stat-value">{{ str_pad($onLeaveTodayCount, 2, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.employee_leave.index') }}"
          class="filter-bar d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">

        <div class="d-flex align-items-end gap-3 flex-wrap">
            <div>
                <div class="filter-label">Leave Type</div>
                <select name="leave_type_id" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    @foreach($leaveTypes as $type)
                        <option value="{{ $type->id }}" {{ request('leave_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <div class="filter-label">Status</div>
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="all" {{ !request('status') || request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div>
                <div class="filter-label">From</div>
                <input type="date" name="from" class="filter-date-input" value="{{ request('from') }}" onchange="this.form.submit()">
            </div>

            <div>
                <div class="filter-label">To</div>
                <input type="date" name="to" class="filter-date-input" value="{{ request('to') }}" onchange="this.form.submit()">
            </div>

            @if(request()->hasAny(['leave_type_id', 'status', 'from', 'to']))
                <a href="{{ route('admin.employee_leave.index') }}" class="btn-export">
                    <i class="bi bi-x-lg"></i> Clear
                </a>
            @endif
        </div>

        <button type="button" class="btn-export" onclick="window.print()">
            <i class="bi bi-download"></i> Export
        </button>
    </form>

    {{-- Table --}}
    <div class="leave-table-wrap mb-4">
        <table class="leave-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Duration</th>
                    <th>Days</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="emp-avatar">{{ strtoupper(substr($leave->employee->name ?? '?', 0, 2)) }}</div>
                            <div>
                                <div class="emp-name">{{ $leave->employee->name ?? 'Unknown' }}</div>
                                <div class="emp-role">
                                    {{ $leave->employee->designation ?? '' }}
                                    @if($leave->employee?->department) • {{ $leave->employee->department->name }} @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><span class="leave-type">{{ $leave->leaveType->name ?? '—' }}</span></td>
                    <td>
                        <div class="duration-date">
                            {{ \Carbon\Carbon::parse($leave->from_date)->format('M d') }} -
                            {{ \Carbon\Carbon::parse($leave->to_date)->format('M d') }}
                        </div>
                        <div class="duration-year">{{ \Carbon\Carbon::parse($leave->from_date)->format('Y') }}</div>
                    </td>
                    <td><span class="days-count">{{ $leave->duration }} {{ $leave->duration == 1 ? 'Day' : 'Days' }}</span></td>
                    <td>
                        @if($leave->status === 'pending')
                            <span class="badge-pending">PENDING</span>
                            <span class="tl-status-tag">
                                @if($leave->tl_status === 'recommended')
                                    Recommended by TL
                                @elseif($leave->tl_status === 'not_recommended')
                                    Declined by TL
                                @else
                                    Awaiting TL
                                @endif
                            </span>
                        @elseif($leave->status === 'approved')
                            <span class="badge-approved">APPROVED</span>
                        @else
                            <span class="badge-rejected">REJECTED</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($leave->status === 'pending')
                                <form method="POST" action="{{ route('hr.leave.approve', $leave->id) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-approve"><i class="bi bi-check"></i> Approve</button>
                                </form>
                                <button class="btn-reject" onclick="openAdminLeaveRejectModal({{ $leave->id }})">
                                    <i class="bi bi-x"></i> Reject
                                </button>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#B2ADA7;">
                        <i class="bi bi-calendar2-x d-block mb-2" style="font-size:2rem;"></i>
                        No leave requests found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <span style="font-size:0.82rem; color:#7F7F7F;">
            Showing {{ $leaves->firstItem() ?? 0 }}–{{ $leaves->lastItem() ?? 0 }} of {{ $leaves->total() }} requests
        </span>
        {{ $leaves->links() }}
    </div>

    {{-- Bottom --}}
    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="trends-card h-100">
                <div class="trends-title">Quick Insight</div>
                <div class="trends-subtitle">Snapshot of current leave activity.</div>
                <div class="d-flex flex-wrap gap-4">
                    <div>
                        <div style="font-size:0.72rem; color:#7F7F7F; text-transform:uppercase; font-weight:700;">Total Requests</div>
                        <div style="font-family:'Outfit',sans-serif; font-size:1.6rem; font-weight:800; color:#1A1A1A;">{{ $leaves->total() }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.72rem; color:#D97706; text-transform:uppercase; font-weight:700;">Pending</div>
                        <div style="font-family:'Outfit',sans-serif; font-size:1.6rem; font-weight:800; color:#D97706;">{{ $pendingCount }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.72rem; color:#059669; text-transform:uppercase; font-weight:700;">Approved Today</div>
                        <div style="font-family:'Outfit',sans-serif; font-size:1.6rem; font-weight:800; color:#059669;">{{ $approvedTodayCount }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Staff on Leave --}}
        <div class="col-12 col-lg-5">
            <div class="staff-card">
                <div class="staff-title">Staff on Leave</div>
                <div class="staff-subtitle">Currently out of office.</div>

                @forelse($staffOnLeave as $sl)
                <div class="staff-item">
                    <div class="d-flex align-items-center gap-3">
                        <div class="staff-avatar">{{ strtoupper(substr($sl->employee->name ?? '?', 0, 2)) }}</div>
                        <div>
                            <div class="staff-name">{{ $sl->employee->name ?? 'Unknown' }}</div>
                            <div class="staff-status">
                                Returning {{ \Carbon\Carbon::parse($sl->to_date)->isToday() ? 'today' : \Carbon\Carbon::parse($sl->to_date)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <i class="bi bi-airplane staff-icon"></i>
                </div>
                @empty
                <div style="font-size:0.85rem; color:rgba(255,255,255,0.7); text-align:center; padding:20px 0;">
                    No one is on leave today.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div class="modal fade" id="adminLeaveRejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:14px;border:1px solid #E2E0DD;">
                <div class="modal-header" style="border-bottom:1px solid #F4F4F0;">
                    <h6 class="modal-title" style="font-family:'Outfit',sans-serif;font-weight:700;">Reject Leave Request</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="adminLeaveRejectForm" method="POST">
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
    function openAdminLeaveRejectModal(leaveId) {
        const url = "{{ route('hr.leave.reject', ':id') }}".replace(':id', leaveId);
        document.getElementById('adminLeaveRejectForm').action = url;
        new bootstrap.Modal(document.getElementById('adminLeaveRejectModal')).show();
    }
</script>
@endpush