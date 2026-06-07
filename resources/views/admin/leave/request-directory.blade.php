@extends('admin.layouts.admin')

@section('title', 'Leave Management - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }

    /* KPI */
    .kpi-stat { border: 1px solid #E2E0DD; border-radius: 10px; padding: 14px 20px; background: #fff; min-width: 130px; }
    .kpi-stat-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; margin-bottom: 4px; }
    .kpi-stat-value { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800; color: #FF5E2B; }

    /* Filter Bar */
    .filter-bar { background: #fff; border: 1px solid #E2E0DD; border-radius: 10px; padding: 14px 20px; }
    .filter-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #7F7F7F; margin-bottom: 5px; }
    .filter-select { border: 1px solid #E2E0DD; border-radius: 7px; font-size: 0.82rem; padding: 7px 28px 7px 10px; background: #FAF9F6; color: #1A1A1A; appearance: none; cursor: pointer; }
    .filter-select:focus { outline: none; border-color: #FF5E2B; }
    .filter-date { border: 1px solid #E2E0DD; border-radius: 7px; font-size: 0.82rem; padding: 7px 12px; background: #FAF9F6; color: #1A1A1A; display: flex; align-items: center; gap: 8px; }
    .btn-export { border: 1px solid #E2E0DD; background: #fff; color: #1A1A1A; border-radius: 8px; font-size: 0.82rem; font-weight: 600; padding: 8px 18px; transition: all 0.2s; }
    .btn-export:hover { background: #FAF9F6; }

    /* Table */
    .leave-table-wrap { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; overflow: hidden; }
    .leave-table { width: 100%; margin: 0; }
    .leave-table thead th { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; padding: 14px 20px; border-bottom: 1px solid #E2E0DD; background: #FAFAFA; }
    .leave-table tbody tr { border-bottom: 1px solid #F4F4F0; transition: background 0.15s; }
    .leave-table tbody tr:last-child { border-bottom: none; }
    .leave-table tbody tr:hover { background: #FAF9F6; }
    .leave-table td { padding: 18px 20px; vertical-align: middle; font-size: 0.85rem; color: #1A1A1A; }

    .emp-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
    .emp-name { font-size: 0.88rem; font-weight: 700; color: #1A1A1A; }
    .emp-role { font-size: 0.75rem; color: #7F7F7F; }

    .leave-type { font-size: 0.85rem; color: #1A1A1A; }
    .duration-date { font-size: 0.85rem; color: #1A1A1A; }
    .duration-year { font-size: 0.75rem; color: #B2ADA7; }
    .days-count { font-size: 0.85rem; font-weight: 600; color: #1A1A1A; }

    .badge-pending { background: #FEF3C7; color: #D97706; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }
    .badge-approved { background: #ECFDF5; color: #059669; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }
    .badge-rejected { background: #FEF2F2; color: #DC2626; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.3px; }

    .btn-approve { background: #FF5E2B; color: #fff; border: none; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 6px 14px; transition: all 0.2s; display: flex; align-items: center; gap: 4px; }
    .btn-approve:hover { background: #E04B1A; color: #fff; }
    .btn-reject { background: #fff; color: #DC2626; border: 1px solid #DC2626; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 6px 14px; transition: all 0.2s; display: flex; align-items: center; gap: 4px; }
    .btn-reject:hover { background: #FEF2F2; }
    .btn-more { background: none; border: none; color: #7F7F7F; font-size: 1.1rem; padding: 4px 6px; border-radius: 6px; transition: all 0.2s; }
    .btn-more:hover { background: #F4F4F0; color: #1A1A1A; }

    /* Pagination */
    .pagination-wrap { padding: 14px 20px; border-top: 1px solid #E2E0DD; display: flex; justify-content: space-between; align-items: center; }
    .pagination-info { font-size: 0.78rem; color: #7F7F7F; }
    .page-btn { width: 32px; height: 32px; border-radius: 6px; border: 1px solid #E2E0DD; background: #fff; color: #1A1A1A; font-size: 0.82rem; font-weight: 600; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .page-btn:hover { border-color: #FF5E2B; color: #FF5E2B; }
    .page-btn.active { background: #FF5E2B; color: #fff; border-color: #FF5E2B; }
    .page-btn.disabled { color: #C0BAB4; cursor: not-allowed; }

    /* Bottom Section */
    .trends-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; padding: 24px; }
    .trends-title { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #1A1A1A; margin-bottom: 4px; }
    .trends-subtitle { font-size: 0.78rem; color: #7F7F7F; margin-bottom: 20px; }

    /* Bar Chart */
    .bar-chart { display: flex; align-items: flex-end; gap: 12px; height: 120px; }
    .bar-wrap { display: flex; flex-direction: column; align-items: center; gap: 6px; flex: 1; }
    .bar { width: 100%; border-radius: 4px 4px 0 0; background: #E2E0DD; transition: all 0.2s; }
    .bar.highlight { background: #FF5E2B; }
    .bar-label { font-size: 0.72rem; color: #7F7F7F; font-weight: 600; }

    /* Staff on Leave */
    .staff-card { background: #8B3A0F; border-radius: 12px; padding: 24px; color: #fff; }
    .staff-title { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
    .staff-subtitle { font-size: 0.78rem; color: rgba(255,255,255,0.65); margin-bottom: 16px; }
    .staff-item { background: rgba(255,255,255,0.1); border-radius: 8px; padding: 12px 14px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .staff-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }
    .staff-name { font-size: 0.85rem; font-weight: 700; color: #fff; }
    .staff-status { font-size: 0.72rem; color: rgba(255,255,255,0.65); }
    .staff-icon { color: rgba(255,255,255,0.7); font-size: 1rem; }
    .link-all { color: #fff; font-size: 0.78rem; font-weight: 700; text-decoration: underline; margin-top: 8px; display: inline-block; }
</style>
@endpush

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h1 class="page-title mb-1">Leave Management</h1>
            <p class="page-subtitle mb-0">Review and manage employee time-off requests.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="kpi-stat">
                <div class="kpi-stat-label">Pending</div>
                <div class="kpi-stat-value">12</div>
            </div>
            <div class="kpi-stat">
                <div class="kpi-stat-label">Approved Today</div>
                <div class="kpi-stat-value">04</div>
            </div>
            <div class="kpi-stat">
                <div class="kpi-stat-label">On Leave</div>
                <div class="kpi-stat-value">08</div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div>
                <div class="filter-label">Leave Type</div>
                <div style="position:relative;">
                    <select class="filter-select">
                        <option>All Types</option>
                        <option>Annual Leave</option>
                        <option>Sick Leave</option>
                        <option>Casual Leave</option>
                    </select>
                    <i class="bi bi-chevron-down" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);font-size:0.65rem;color:#7F7F7F;pointer-events:none;"></i>
                </div>
            </div>
            <div>
                <div class="filter-label">Status</div>
                <div style="position:relative;">
                    <select class="filter-select">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Approved</option>
                        <option>Rejected</option>
                    </select>
                    <i class="bi bi-chevron-down" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);font-size:0.65rem;color:#7F7F7F;pointer-events:none;"></i>
                </div>
            </div>
            <div>
                <div class="filter-label">Date Range</div>
                <div class="filter-date">
                    <i class="bi bi-calendar3" style="color:#7F7F7F;"></i>
                    Oct 01 - Oct 31, 2023
                </div>
            </div>
        </div>
        <button class="btn-export d-flex align-items-center gap-2">
            <i class="bi bi-download"></i> Export
        </button>

         <a href="{{ route('admin.leave.create') }}" class="btn-export d-flex align-items-center gap-2" style="background:#FF5E2B; color:#fff; border-color:#FF5E2B; text-decoration:none;">
        <i class="bi bi-plus-lg"></i> Add Leave Type
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
                    <th>Days</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('images/admin_avatar.png') }}" class="emp-avatar" alt="">
                            <div>
                                <div class="emp-name">Jonathan Smith</div>
                                <div class="emp-role">Senior Developer</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="leave-type">Annual Leave</span></td>
                    <td>
                        <div class="duration-date">Oct 12 - Oct 15</div>
                        <div class="duration-year">2023</div>
                    </td>
                    <td><span class="days-count">4 Days</span></td>
                    <td><span class="badge-pending">PENDING</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn-approve"><i class="bi bi-check"></i> Approve</button>
                            <button class="btn-reject"><i class="bi bi-x"></i> Reject</button>
                            <button class="btn-more"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('images/admin_avatar.png') }}" class="emp-avatar" alt="">
                            <div>
                                <div class="emp-name">Alice Dubois</div>
                                <div class="emp-role">HR Specialist</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="leave-type">Sick Leave</span></td>
                    <td>
                        <div class="duration-date">Oct 08 - Oct 09</div>
                        <div class="duration-year">2023</div>
                    </td>
                    <td><span class="days-count">2 Days</span></td>
                    <td><span class="badge-approved">APPROVED</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn-more"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('images/admin_avatar.png') }}" class="emp-avatar" alt="">
                            <div>
                                <div class="emp-name">Marcus Reed</div>
                                <div class="emp-role">UX Designer</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="leave-type">Casual Leave</span></td>
                    <td>
                        <div class="duration-date">Oct 05 - Oct 05</div>
                        <div class="duration-year">2023</div>
                    </td>
                    <td><span class="days-count">1 Day</span></td>
                    <td><span class="badge-rejected">REJECTED</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn-more"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('images/admin_avatar.png') }}" class="emp-avatar" alt="">
                            <div>
                                <div class="emp-name">Sarah Linn</div>
                                <div class="emp-role">Accountant</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="leave-type">Annual Leave</span></td>
                    <td>
                        <div class="duration-date">Oct 15 - Oct 22</div>
                        <div class="duration-year">2023</div>
                    </td>
                    <td><span class="days-count">7 Days</span></td>
                    <td><span class="badge-pending">PENDING</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn-approve"><i class="bi bi-check"></i> Approve</button>
                            <button class="btn-reject"><i class="bi bi-x"></i> Reject</button>
                            <button class="btn-more"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="pagination-wrap">
            <span class="pagination-info">Showing 1-4 of 12 requests</span>
            <div class="d-flex gap-1">
                <button class="page-btn disabled"><i class="bi bi-chevron-left"></i></button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
    </div>

    {{-- Bottom --}}
    <div class="row g-4">

      

        {{-- Staff on Leave --}}
        <div class="col-12 col-lg-5">
            <div class="staff-card">
                <div class="staff-title">Staff on Leave</div>
                <div class="staff-subtitle">Currently out of office.</div>

                <div class="staff-item">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('images/admin_avatar.png') }}" class="staff-avatar" alt="">
                        <div>
                            <div class="staff-name">Elena Vance</div>
                            <div class="staff-status">Returning tomorrow</div>
                        </div>
                    </div>
                    <i class="bi bi-airplane staff-icon"></i>
                </div>

                <div class="staff-item">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('images/admin_avatar.png') }}" class="staff-avatar" alt="">
                        <div>
                            <div class="staff-name">Gary Holt</div>
                            <div class="staff-status">Sick Leave</div>
                        </div>
                    </div>
                    <i class="bi bi-briefcase staff-icon"></i>
                </div>

                <a href="#" class="link-all">View All Absence</a>
            </div>
        </div>

    </div>

@endsection