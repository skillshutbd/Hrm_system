@extends('team_lead.layouts.tl')

@section('title', 'Leave Recommendations - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }

    .kpi-stat { border: 1px solid #E2E0DD; border-radius: 10px; padding: 14px 20px; background: #fff; min-width: 130px; }
    .kpi-stat-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; margin-bottom: 4px; }
    .kpi-stat-value { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800; color: #FF5E2B; }

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

    .leave-table-wrap { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; overflow: hidden; }
    .leave-table { width: 100%; margin: 0; }
    .leave-table thead th { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; padding: 14px 20px; border-bottom: 1px solid #E2E0DD; background: #FAFAFA; }
    .leave-table tbody tr { border-bottom: 1px solid #F4F4F0; transition: background 0.15s; }
    .leave-table tbody tr:last-child { border-bottom: none; }
    .leave-table tbody tr:hover { background: #FAF9F6; }
    .leave-table td { padding: 18px 20px; vertical-align: middle; font-size: 0.85rem; color: #1A1A1A; }

    .emp-avatar { width: 40px; height: 40px; border-radius: 50%; background: #FFF0EB; color: #FF5E2B; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; }
    .emp-name { font-size: 0.88rem; font-weight: 700; color: #1A1A1A; }
    .emp-role { font-size: 0.75rem; color: #7F7F7F; }

    .leave-type { font-size: 0.85rem; color: #1A1A1A; }
    .duration-date { font-size: 0.85rem; color: #1A1A1A; }
    .duration-year { font-size: 0.75rem; color: #B2ADA7; }
    .days-count { font-size: 0.85rem; font-weight: 600; color: #1A1A1A; }
    .leave-reason { font-size: 0.8rem; color: #4A4A4A; max-width: 220px; display: block; }

    .badge-pending     { background: #FEF3C7; color: #D97706; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }
    .badge-recommended { background: #ECFDF5; color: #059669; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }
    .badge-declined    { background: #FEF2F2; color: #DC2626; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }

    .btn-approve { background: #FF5E2B; color: #fff; border: none; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 6px 14px; transition: all 0.2s; display: flex; align-items: center; gap: 4px; }
    .btn-approve:hover { background: #E04B1A; color: #fff; }
    .btn-reject { background: #fff; color: #DC2626; border: 1px solid #DC2626; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 6px 14px; transition: all 0.2s; display: flex; align-items: center; gap: 4px; }
    .btn-reject:hover { background: #FEF2F2; }
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
            <h1 class="page-title mb-1">Leave Recommendations</h1>
            <p class="page-subtitle mb-0">Review your team's leave requests and recommend or decline.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="kpi-stat">
                <div class="kpi-stat-label">Pending</div>
                <div class="kpi-stat-value">{{ $pendingCount }}</div>
            </div>
            <div class="kpi-stat">
                <div class="kpi-stat-label">Recommended</div>
                <div class="kpi-stat-value" style="color:#059669;">{{ $recommendedCount }}</div>
            </div>
            <div class="kpi-stat">
                <div class="kpi-stat-label">Declined</div>
                <div class="kpi-stat-value" style="color:#DC2626;">{{ $declinedCount }}</div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="filter-tabs">
        <a href="{{ route('team_lead.index', ['filter' => 'pending']) }}" class="filter-tab {{ $filter === 'pending' ? 'active' : '' }}">
            <i class="bi bi-hourglass-split"></i> Pending <span class="count">{{ $pendingCount }}</span>
        </a>
        <a href="{{ route('team_lead.index', ['filter' => 'recommended']) }}" class="filter-tab {{ $filter === 'recommended' ? 'active' : '' }}">
            <i class="bi bi-check-circle"></i> Recommended <span class="count">{{ $recommendedCount }}</span>
        </a>
        <a href="{{ route('team_lead.index', ['filter' => 'declined']) }}" class="filter-tab {{ $filter === 'declined' ? 'active' : '' }}">
            <i class="bi bi-x-circle"></i> Declined <span class="count">{{ $declinedCount }}</span>
        </a>
    </div>

    {{-- Table --}}
    <div class="leave-table-wrap mb-4">
        <table class="leave-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Duration</th>
                    <th>Reason</th>
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
                                <div class="emp-role">{{ $leave->employee->designation ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="leave-type">{{ $leave->leaveType->name ?? '—' }}</span></td>
                    <td>
                        <div class="duration-date">
                            {{ \Carbon\Carbon::parse($leave->from_date)->format('M d') }} -
                            {{ \Carbon\Carbon::parse($leave->to_date)->format('M d') }}
                        </div>
                        <div class="duration-year">{{ $leave->duration }} {{ $leave->duration == 1 ? 'Day' : 'Days' }}</div>
                    </td>
                    <td><span class="leave-reason">{{ $leave->reason }}</span></td>
                    <td>
                        @if($leave->tl_status === 'pending')
                            <span class="badge-pending">PENDING</span>
                        @elseif($leave->tl_status === 'recommended')
                            <span class="badge-recommended">RECOMMENDED</span>
                        @else
                            <span class="badge-declined">DECLINED</span>
                        @endif
                    </td>
                    <td>
                        @if($leave->tl_status === 'pending')
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn-approve" onclick="openTlActionModal({{ $leave->id }}, 'recommend')">
                                    <i class="bi bi-check"></i> Recommend
                                </button>
                                <button class="btn-reject" onclick="openTlActionModal({{ $leave->id }}, 'not-recommend')">
                                    <i class="bi bi-x"></i> Decline
                                </button>
                            </div>
                        @else
                            <span style="font-size:0.78rem; color:#B2ADA7;">{{ $leave->tl_note }}</span>
                        @endif
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
    <div class="d-flex justify-content-between align-items-center">
        <span style="font-size:0.82rem; color:#7F7F7F;">
            Showing {{ $leaves->firstItem() ?? 0 }}–{{ $leaves->lastItem() ?? 0 }} of {{ $leaves->total() }}
        </span>
        {{ $leaves->links() }}
    </div>

    {{-- Action Note Modal --}}
    <div class="modal fade" id="tlActionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:14px;border:1px solid #E2E0DD;">
                <div class="modal-header" style="border-bottom:1px solid #F4F4F0;">
                    <h6 class="modal-title" id="tlActionModalTitle" style="font-family:'Outfit',sans-serif;font-weight:700;">Add Note</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="tlActionForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <label style="font-size:0.82rem;font-weight:600;color:#4A4A4A;margin-bottom:7px;display:block;">
                            Note <span class="text-danger">*</span>
                        </label>
                        <textarea name="tl_note" rows="4" required
                                  style="width:100%;border:1px solid #E2E0DD;border-radius:8px;padding:10px 14px;font-size:0.88rem;resize:vertical;"
                                  placeholder="Add your note here..."></textarea>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #F4F4F0;">
                        <button type="button" class="btn btn-sm" style="background:#fff;border:1px solid #E2E0DD;border-radius:8px;font-weight:600;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm" id="tlActionSubmitBtn" style="color:#fff;border:none;border-radius:8px;font-weight:600;padding:8px 20px;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    const TL_LEAVE_BASE_URL = "{{ url('/team_lead/leave') }}";

    function openTlActionModal(leaveId, action) {
        const form  = document.getElementById('tlActionForm');
        const title = document.getElementById('tlActionModalTitle');
        const btn   = document.getElementById('tlActionSubmitBtn');

        if (action === 'recommend') {
            form.action          = `${TL_LEAVE_BASE_URL}/${leaveId}/recommend`;
            title.textContent    = 'Recommend Leave';
            btn.textContent      = 'Recommend';
            btn.style.background = '#FF5E2B';
        } else {
            form.action          = `${TL_LEAVE_BASE_URL}/${leaveId}/not-recommend`;
            title.textContent    = 'Decline Leave';
            btn.textContent      = 'Decline';
            btn.style.background = '#DC2626';
        }

        new bootstrap.Modal(document.getElementById('tlActionModal')).show();
    }
</script>
@endpush