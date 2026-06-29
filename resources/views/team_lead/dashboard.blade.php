@extends('team_lead.layouts.tl')

@section('title', 'Dashboard - Skills Hut Ltd')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap');

    .tl-stat-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 24px;
        height: 100%;
        transition: box-shadow 0.2s;
    }
    .tl-stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.07); }
    .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 14px; }
    .stat-icon.orange { background: #FFF0EB; color: #FF5E2B; }
    .stat-icon.blue   { background: #EBF3FF; color: #2563EB; }
    .stat-icon.red    { background: #FEE2E2; color: #DC2626; }
    .stat-number { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 700; color: #1A1A1A; line-height: 1; margin-bottom: 4px; }
    .stat-label  { font-size: 0.82rem; color: #7F7F7F; font-weight: 600; margin-bottom: 8px; }
    .stat-sub    { font-size: 0.78rem; color: #7F7F7F; }
    .stat-sub.green  { color: #059669; font-weight: 600; }
    .stat-sub.urgent { color: #DC2626; font-weight: 700; }

    .section-title { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #1A1A1A; margin-bottom: 0; }
    .view-all { font-size: 0.82rem; font-weight: 600; color: #FF5E2B; text-decoration: none; }
    .view-all:hover { color: #E04B1A; }

    .team-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; padding: 16px; }
    .team-member { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #F4F4F0; }
    .team-member:last-child { border-bottom: none; }
    .member-avatar { width: 40px; height: 40px; border-radius: 10px; object-fit: cover; border: 1px solid #E2E0DD; background: #F4F4F0; display: flex; align-items: center; justify-content: center; font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 0.88rem; color: #FF5E2B; flex-shrink: 0; }
    .member-name { font-size: 0.88rem; font-weight: 600; color: #1A1A1A; }
    .member-role { font-size: 0.78rem; color: #7F7F7F; }
    .status-pill { font-size: 0.68rem; font-weight: 700; padding: 3px 8px; border-radius: 20px; letter-spacing: 0.3px; margin-left: auto; flex-shrink: 0; }
    .pill-active   { background: #ECFDF5; color: #059669; }
    .pill-leave    { background: #FFF7ED; color: #EA580C; }
    .pill-inactive { background: #F4F4F0; color: #7F7F7F; }

    .leave-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; padding: 20px; }
    .leave-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
    .leave-table thead th { font-size: 0.72rem; font-weight: 700; color: #7F7F7F; letter-spacing: 0.5px; text-transform: uppercase; padding: 10px 12px; border-bottom: 1px solid #F4F4F0; text-align: left; }
    .leave-table tbody td { padding: 14px 12px; border-bottom: 1px solid #F4F4F0; font-size: 0.85rem; color: #1A1A1A; vertical-align: middle; }
    .leave-table tbody tr:last-child td { border-bottom: none; }
    .leave-table tbody tr:hover { background: #FAF9F6; }

    .emp-avatar { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 0.78rem; color: #fff; margin-right: 10px; flex-shrink: 0; }
    .emp-name { font-weight: 600; font-size: 0.88rem; }

    .leave-status { font-size: 0.72rem; font-weight: 700; padding: 4px 8px; border-radius: 20px; white-space: nowrap; }
    .status-pending  { background: #FFF7ED; color: #EA580C; }
    .status-urgent   { background: #FEE2E2; color: #DC2626; }
    .status-approved { background: #ECFDF5; color: #059669; }

    .btn-recommend { background: #FF5E2B; color: #fff; border: none; border-radius: 7px; font-size: 0.78rem; font-weight: 700; padding: 7px 14px; cursor: pointer; transition: background 0.2s; white-space: nowrap; }
    .btn-recommend:hover { background: #E04B1A; }
    .btn-decline { background: #FEE2E2; color: #DC2626; border: none; border-radius: 7px; font-size: 0.78rem; font-weight: 700; padding: 7px 14px; cursor: pointer; transition: background 0.2s; white-space: nowrap; }
    .btn-decline:hover { background: #FECACA; }
    .btn-view { background: transparent; border: none; color: #7F7F7F; font-size: 1rem; cursor: pointer; padding: 4px 8px; border-radius: 6px; transition: color 0.2s, background 0.2s; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-view:hover { color: #1A1A1A; background: #F4F4F0; }
    .btn-filter { background: #fff; border: 1px solid #E2E0DD; border-radius: 7px; font-size: 0.78rem; font-weight: 600; color: #1A1A1A; padding: 6px 12px; cursor: pointer; transition: background 0.2s; }
    .btn-filter:hover { background: #F4F4F0; }
    .pagination-btn { width: 32px; height: 32px; border-radius: 7px; border: 1px solid #E2E0DD; background: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.85rem; color: #1A1A1A; transition: background 0.2s; }
    .pagination-btn:hover { background: #F4F4F0; }
    .pagination-info { font-size: 0.78rem; color: #7F7F7F; }

    /* ============================================
       RESPONSIVE STYLES
       ============================================ */
    
    /* Tablet (≤991px) */
    @media (max-width: 991.98px) {
        .tl-stat-card {
            padding: 20px;
        }

        .stat-number {
            font-size: 1.8rem;
        }

        .leave-card {
            padding: 16px;
        }

        .leave-table thead th {
            font-size: 0.7rem;
            padding: 8px 10px;
        }

        .leave-table tbody td {
            padding: 12px 10px;
            font-size: 0.82rem;
        }

        .btn-recommend,
        .btn-decline {
            font-size: 0.75rem;
            padding: 6px 12px;
        }
    }

    /* Mobile (≤767px) */
    @media (max-width: 767.98px) {
        .tl-stat-card {
            padding: 16px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
            margin-bottom: 12px;
        }

        .stat-number {
            font-size: 1.6rem;
        }

        .stat-label {
            font-size: 0.78rem;
        }

        .stat-sub {
            font-size: 0.72rem;
        }

        .section-title {
            font-size: 0.92rem;
        }

        .view-all {
            font-size: 0.78rem;
        }

        .team-card {
            padding: 12px;
        }

        .team-member {
            gap: 10px;
            padding: 8px 0;
        }

        .member-avatar {
            width: 36px;
            height: 36px;
            font-size: 0.82rem;
        }

        .member-name {
            font-size: 0.82rem;
        }

        .member-role {
            font-size: 0.72rem;
        }

        .status-pill {
            font-size: 0.65rem;
            padding: 2px 6px;
        }

        .leave-card {
            padding: 12px;
            overflow-x: auto;
        }

        /* Make table horizontally scrollable on mobile */
        .leave-table {
            min-width: 600px;
        }

        .leave-table thead th {
            font-size: 0.68rem;
            padding: 8px 8px;
            white-space: nowrap;
        }

        .leave-table tbody td {
            padding: 10px 8px;
            font-size: 0.78rem;
        }

        .emp-avatar {
            width: 30px;
            height: 30px;
            font-size: 0.72rem;
            margin-right: 8px;
        }

        .emp-name {
            font-size: 0.82rem;
        }

        .leave-status {
            font-size: 0.68rem;
            padding: 3px 6px;
        }

        /* Action buttons stack vertically on mobile */
        .leave-table tbody td:last-child .d-flex {
            flex-direction: column;
            gap: 6px !important;
            align-items: stretch !important;
        }

        .btn-recommend,
        .btn-decline {
            font-size: 0.72rem;
            padding: 6px 10px;
            width: 100%;
            text-align: center;
        }

        .btn-view {
            align-self: center;
        }

        /* Filter and Sort buttons wrap */
        .d-flex.gap-2 {
            flex-wrap: wrap;
        }

        .btn-filter {
            font-size: 0.75rem;
            padding: 5px 10px;
            flex: 1;
            min-width: 80px;
        }

        /* Pagination stacks */
        .d-flex.justify-content-between.align-items-center.mt-3 {
            flex-direction: column;
            gap: 12px;
            align-items: stretch !important;
        }

        .pagination-info {
            font-size: 0.75rem;
            text-align: center;
        }

        .d-flex.gap-2 {
            justify-content: center;
        }

        /* Modal fullscreen on mobile */
        .modal-dialog {
            margin: 0;
            max-width: 100%;
            height: 100vh;
        }

        .modal-content {
            border-radius: 0 !important;
            height: 100vh;
        }

        .modal-header,
        .modal-footer {
            padding: 16px;
        }

        .modal-body {
            padding: 16px;
        }
    }

    /* Small Mobile (≤575px) */
    @media (max-width: 575.98px) {
        .tl-stat-card {
            padding: 14px;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .stat-label {
            font-size: 0.75rem;
        }

        .team-member {
            gap: 8px;
        }

        .member-avatar {
            width: 32px;
            height: 32px;
            font-size: 0.78rem;
        }

        .member-name {
            font-size: 0.78rem;
        }

        .member-role {
            font-size: 0.7rem;
        }

        .leave-table {
            min-width: 550px;
        }

        .emp-avatar {
            width: 28px;
            height: 28px;
            font-size: 0.68rem;
            margin-right: 6px;
        }

        .emp-name {
            font-size: 0.78rem;
        }

        .btn-recommend,
        .btn-decline {
            font-size: 0.7rem;
            padding: 5px 8px;
        }
    }
</style>
@endpush

@section('content')

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="tl-stat-card">
            <div class="stat-icon orange"><i class="bi bi-people-fill"></i></div>
            <div class="stat-label">Total Members</div>
            <div class="stat-number">{{ $totalMembers ?? 0 }}</div>
            <div class="stat-sub green"><i class="bi bi-arrow-up"></i> Active team</div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <div class="tl-stat-card">
            <div class="stat-icon blue"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="stat-label">Active on Leave</div>
            <div class="stat-number">{{ $activeOnLeave ?? 0 }}</div>
            <div class="stat-sub">Currently on leave</div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="tl-stat-card">
            <div class="stat-icon red"><i class="bi bi-clipboard2-pulse-fill"></i></div>
            <div class="stat-label">Pending Recommendations</div>
            <div class="stat-number">{{ $pendingCount ?? 0 }}</div>
            @if(($pendingCount ?? 0) > 0)
                <div class="stat-sub urgent"><i class="bi bi-exclamation-circle-fill"></i> Needs your attention</div>
            @else
                <div class="stat-sub">All clear</div>
            @endif
        </div>
    </div>
</div>

{{-- My Team + Leave Recommendations --}}
<div class="row g-3">

    {{-- My Team --}}
    <div class="col-12 col-lg-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-people" style="color:#FF5E2B;"></i>
                <span class="section-title">My Team</span>
            </div>
            <a href="{{ route('team_lead.memberIndex') }}" class="view-all">View All</a>
        </div>

        <div class="team-card">
            @forelse($members ?? [] as $member)
            <div class="team-member">
                @if($member->profile_picture)
                    <img src="{{ asset('storage/' . $member->profile_picture) }}"
                         class="member-avatar" style="border-radius:10px;width:40px;height:40px;object-fit:cover;">
                @else
                    <div class="member-avatar">{{ strtoupper(substr($member->name, 0, 2)) }}</div>
                @endif
                <div>
                    <div class="member-name">{{ $member->name }}</div>
                    <div class="member-role">{{ $member->designation ?? 'N/A' }}</div>
                </div>
                <span class="status-pill {{ $member->status === 'active' ? 'pill-active' : ($member->status === 'on_leave' ? 'pill-leave' : 'pill-inactive') }}">
                    {{ strtoupper(str_replace('_', ' ', $member->status ?? 'active')) }}
                </span>
            </div>
            @empty
            <div class="team-member">
                <div class="member-avatar">--</div>
                <div>
                    <div class="member-name">No members found</div>
                    <div class="member-role">—</div>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Leave Recommendations --}}
    <div class="col-12 col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-clipboard2-check" style="color:#FF5E2B;"></i>
                <span class="section-title">Leave Recommendations</span>
            </div>
            <div class="d-flex gap-2">
                <button class="btn-filter"><i class="bi bi-funnel"></i> Filter</button>
                <button class="btn-filter"><i class="bi bi-sort-down"></i> Sort</button>
            </div>
        </div>

        <div class="leave-card">
            <div style="overflow-x: auto;">
                <table class="leave-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaveRequests ?? [] as $leave)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="emp-avatar"
                                         style="background:{{ ['#FF5E2B','#2563EB','#059669','#7C3AED'][$loop->index % 4] }}">
                                        {{ strtoupper(substr($leave->employee->name ?? 'NA', 0, 2)) }}
                                    </div>
                                    <span class="emp-name">{{ $leave->employee->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>{{ $leave->leaveType->name ?? 'N/A' }}</td>
                            <td>
                                <div style="font-weight:600;">{{ $leave->duration }} Days</div>
                                <div style="font-size:0.75rem;color:#7F7F7F;">
                                    {{ \Carbon\Carbon::parse($leave->from_date)->format('M d') }} -
                                    {{ \Carbon\Carbon::parse($leave->to_date)->format('M d') }}
                                </div>
                            </td>
                            <td>
                                <span class="leave-status status-pending">
                                    Pending TL
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <button class="btn-recommend"
                                            onclick='openNoteModal({{ $leave->id }}, "recommend")'>
                                        Recommend
                                    </button>
                                    <button class="btn-decline"
                                            onclick='openNoteModal({{ $leave->id }}, "not-recommend")'>
                                        Decline
                                    </button>
                                    <a href="{{ route('tl.leave.show', $leave->id) }}" class="btn-view">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:32px;color:#7F7F7F;font-size:0.88rem;">
                                <i class="bi bi-clipboard-check" style="font-size:1.5rem;display:block;margin-bottom:8px;color:#E2E0DD;"></i>
                                No pending leave requests.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 pt-2"
                 style="border-top:1px solid #F4F4F0;">
                <span class="pagination-info">
                    Showing {{ $leaveRequests->count() }} of {{ $leaveRequests->total() ?? 0 }} pending requests
                </span>
                <div class="d-flex gap-2">
                    {{ $leaveRequests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Note Modal --}}
<div class="modal fade" id="noteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content" style="border-radius:14px;border:1px solid #E2E0DD;">
            <div class="modal-header" style="border-bottom:1px solid #F4F4F0;">
                <h6 class="modal-title"
                    style="font-family:'Outfit',sans-serif;font-weight:700;"
                    id="modalTitle">Add Note</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="noteForm" method="POST">
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
                    <button type="button" class="btn btn-sm"
                            style="background:#fff;border:1px solid #E2E0DD;border-radius:8px;font-weight:600;"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm"
                            style="background:#FF5E2B;color:#fff;border:none;border-radius:8px;font-weight:600;padding:8px 20px;"
                            id="modalSubmitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openNoteModal(leaveId, action) {
    const form  = document.getElementById('noteForm');
    const title = document.getElementById('modalTitle');
    const btn   = document.getElementById('modalSubmitBtn');

    if (action === 'recommend') {
         form.action          = `/team_lead/leave/${leaveId}/recommend`;
        title.textContent    = 'Recommend Leave';
        btn.textContent      = 'Recommend';
        btn.style.background = '#FF5E2B';
    } else {
        form.action          = `/team_lead/leave/${leaveId}/not-recommend`;
        title.textContent    = 'Decline Leave';
        btn.textContent      = 'Decline';
        btn.style.background = '#DC2626';
    }

    new bootstrap.Modal(document.getElementById('noteModal')).show();
}
</script>
@endpush