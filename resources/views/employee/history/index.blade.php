@extends('employee.layouts.employee')

@section('title', 'Leave History - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }

    .kpi-stat { border: 1px solid #E2E0DD; border-radius: 10px; padding: 14px 20px; background: #fff; min-width: 120px; }
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

    .leave-type { font-size: 0.85rem; font-weight: 600; color: #1A1A1A; }
    .duration-date { font-size: 0.85rem; color: #1A1A1A; }
    .duration-year { font-size: 0.75rem; color: #B2ADA7; }
    .days-count { font-size: 0.85rem; font-weight: 600; color: #1A1A1A; }
    .leave-reason { font-size: 0.8rem; color: #4A4A4A; max-width: 220px; display: block; }

    .badge-pending  { background: #FEF3C7; color: #D97706; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }
    .badge-approved { background: #ECFDF5; color: #059669; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }
    .badge-rejected { background: #FEF2F2; color: #DC2626; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }

    .tl-note-tag { font-size: 0.7rem; color: #7F7F7F; margin-top: 3px; display: block; }
    .btn-add { background: #FF5E2B; color: #fff; border: none; border-radius: 8px; font-weight: 600; font-size: 0.88rem; padding: 10px 20px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-add:hover { background: #E04B1A; color: #fff; }

    /* ============================================
       RESPONSIVE STYLES
       ============================================ */
    @media (max-width: 768px) {
        .page-title { font-size: 1.25rem !important; }
        .page-subtitle { font-size: 0.78rem !important; }

        .btn-add {
            width: 100%;
            justify-content: center;
            padding: 9px 16px;
        }

        /* KPI row - horizontal scroll instead of wrap-squeeze */
        .d-flex.gap-2.flex-wrap.mb-4 {
            flex-wrap: nowrap !important;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 4px;
        }
        .kpi-stat {
            min-width: 110px;
            flex: 0 0 auto;
            padding: 12px 16px;
        }
        .kpi-stat-value { font-size: 1.5rem; }

        /* Filter tabs - horizontal scroll */
        .filter-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 4px;
        }
        .filter-tab {
            flex: 0 0 auto;
            white-space: nowrap;
            font-size: 0.78rem;
            padding: 6px 12px;
        }

        /* Table - horizontal scroll */
        .leave-table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .leave-table {
            min-width: 680px;
        }
        .leave-table thead th {
            padding: 10px 14px;
            font-size: 0.68rem;
            white-space: nowrap;
        }
        .leave-table td {
            padding: 12px 14px;
            font-size: 0.8rem;
        }
        .leave-reason {
            max-width: 160px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Pagination - stack */
        .pagination-wrap-responsive {
            flex-direction: column;
            align-items: stretch !important;
            gap: 10px;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .page-title { font-size: 1.1rem !important; }
        .kpi-stat { min-width: 95px; padding: 10px 14px; }
        .kpi-stat-value { font-size: 1.3rem; }
        .kpi-stat-label { font-size: 0.65rem; }
        .leave-table { min-width: 620px; }
        .leave-reason { max-width: 120px; }
    }
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
            <h1 class="page-title mb-1">Leave History</h1>
            <p class="page-subtitle mb-0">Track the status of all your leave requests.</p>
        </div>
        <a href="{{ route('employee.leave.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Request Leave
        </a>
    </div>

    {{-- KPI --}}
    <div class="d-flex gap-2 flex-wrap mb-4">
        <div class="kpi-stat">
            <div class="kpi-stat-label">Total</div>
            <div class="kpi-stat-value">{{ $totalCount }}</div>
        </div>
        <div class="kpi-stat">
            <div class="kpi-stat-label">Pending</div>
            <div class="kpi-stat-value" style="color:#D97706;">{{ $pendingCount }}</div>
        </div>
        <div class="kpi-stat">
            <div class="kpi-stat-label">Approved</div>
            <div class="kpi-stat-value" style="color:#059669;">{{ $approvedCount }}</div>
        </div>
        <div class="kpi-stat">
            <div class="kpi-stat-label">Rejected</div>
            <div class="kpi-stat-value" style="color:#DC2626;">{{ $rejectedCount }}</div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="filter-tabs">
        <a href="{{ route('employee.leave.history') }}" class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">
            All <span class="count">{{ $totalCount }}</span>
        </a>
        <a href="{{ route('employee.leave.history', ['filter' => 'pending']) }}" class="filter-tab {{ $filter === 'pending' ? 'active' : '' }}">
            <i class="bi bi-hourglass-split"></i> Pending <span class="count">{{ $pendingCount }}</span>
        </a>
        <a href="{{ route('employee.leave.history', ['filter' => 'approved']) }}" class="filter-tab {{ $filter === 'approved' ? 'active' : '' }}">
            <i class="bi bi-check-circle"></i> Approved <span class="count">{{ $approvedCount }}</span>
        </a>
        <a href="{{ route('employee.leave.history', ['filter' => 'rejected']) }}" class="filter-tab {{ $filter === 'rejected' ? 'active' : '' }}">
            <i class="bi bi-x-circle"></i> Rejected <span class="count">{{ $rejectedCount }}</span>
        </a>
    </div>

    {{-- Table --}}
    <div class="leave-table-wrap mb-4">
        <table class="leave-table">
            <thead>
                <tr>
                    <th>Leave Type</th>
                    <th>Duration</th>
                    <th>Reason</th>
                    <th>TL Status</th>
                    <th>Final Status</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr>
                    <td><span class="leave-type">{{ $leave->leaveType->name ?? '—' }}</span></td>
                    <td>
                        <div class="duration-date">
                            {{ \Carbon\Carbon::parse($leave->from_date)->format('M d') }} -
                            {{ \Carbon\Carbon::parse($leave->to_date)->format('M d') }}
                        </div>
                        <div class="duration-year">{{ $leave->duration }} {{ $leave->duration == 1 ? 'Day' : 'Days' }}</div>
                    </td>
                    <td><span class="leave-reason" title="{{ $leave->reason }}">{{ $leave->reason }}</span></td>
                    <td>
                        @if($leave->tl_status === 'recommended')
                            <span class="badge-approved">RECOMMENDED</span>
                        @elseif($leave->tl_status === 'not_recommended')
                            <span class="badge-rejected">DECLINED</span>
                            @if($leave->tl_note)
                                <span class="tl-note-tag">"{{ $leave->tl_note }}"</span>
                            @endif
                        @else
                            <span class="badge-pending">PENDING</span>
                        @endif
                    </td>
                    <td>
                        @if($leave->status === 'pending')
                            <span class="badge-pending">PENDING</span>
                        @elseif($leave->status === 'approved')
                            <span class="badge-approved">APPROVED</span>
                        @else
                            <span class="badge-rejected">REJECTED</span>
                            @if($leave->hr_note)
                                <span class="tl-note-tag">"{{ $leave->hr_note }}"</span>
                            @endif
                        @endif
                    </td>
                    <td style="font-size:0.78rem; color:#7F7F7F;">
                        {{ $leave->created_at->format('M d, Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#B2ADA7;">
                        <i class="bi bi-calendar2-x d-block mb-2" style="font-size:2rem;"></i>
                        No leave requests found.
                        <div class="mt-2">
                            <a href="{{ route('employee.leave.create') }}" style="color:#FF5E2B; font-size:0.85rem;">Request your first leave</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center pagination-wrap-responsive">
        <span style="font-size:0.82rem; color:#7F7F7F;">
            Showing {{ $leaves->firstItem() ?? 0 }}–{{ $leaves->lastItem() ?? 0 }} of {{ $leaves->total() }}
        </span>
        {{ $leaves->links() }}
    </div>

@endsection