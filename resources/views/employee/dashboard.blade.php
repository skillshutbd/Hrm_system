@extends('employee.layouts.employee')

@section('title', 'Dashboard - Skills Hut Ltd')

@push('styles')
<style>
    .welcome-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 4px;
    }
    .welcome-sub {
        font-size: 0.88rem;
        color: #7F7F7F;
    }

    /* Profile card */
    .profile-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 24px;
        height: 100%;
    }
    .profile-avatar-wrap {
        position: relative;
        width: 90px;
        height: 90px;
        margin-bottom: 16px;
    }
    .profile-avatar {
        width: 90px;
        height: 90px;
        border-radius: 14px;
        object-fit: cover;
        border: 1px solid #E2E0DD;
    }
    .profile-avatar-placeholder {
        width: 90px;
        height: 90px;
        border-radius: 14px;
        background: #FFF0EB;
        color: #FF5E2B;
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .employment-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ECFDF5;
        color: #059669;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        border: 1px solid #D1FAE5;
    }
    .profile-name {
        font-family: 'Outfit', sans-serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 4px;
    }
    .profile-role {
        font-size: 0.82rem;
        color: #7F7F7F;
        margin-bottom: 20px;
    }
    .profile-meta-row {
        display: flex;
        gap: 24px;
        padding-top: 16px;
        border-top: 1px solid #F4F4F0;
    }
    .profile-meta-item label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #7F7F7F;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: block;
        margin-bottom: 4px;
    }
    .profile-meta-item span {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1A1A1A;
    }

    /* Stat cards */
    .stat-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 20px;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        margin-bottom: 28px;
    }
    .stat-icon.green  { background: #ECFDF5; color: #059669; }
    .stat-icon.red    { background: #FEE2E2; color: #DC2626; }
    .stat-icon.blue   { background: #EBF3FF; color: #2563EB; }
    .stat-icon.orange { background: #FFF0EB; color: #FF5E2B; }

    .stat-label {
        font-size: 0.8rem;
        color: #7F7F7F;
        font-weight: 600;
        margin-bottom: 6px;
    }
    .stat-number {
        font-family: 'Outfit', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #1A1A1A;
        line-height: 1;
    }
    .stat-number span {
        font-size: 0.9rem;
        font-weight: 500;
        color: #7F7F7F;
    }
    .stat-badge-active {
        position: absolute;
        top: 16px;
        right: 16px;
        background: #ECFDF5;
        color: #059669;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        border: 1px solid #D1FAE5;
    }
    .stat-sparkline {
        position: absolute;
        top: 16px;
        right: 16px;
        opacity: 0.6;
    }

    /* Leave history */
    .history-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 20px;
    }
    .history-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #1A1A1A;
    }
    .view-all-link {
        font-size: 0.82rem;
        font-weight: 600;
        color: #FF5E2B;
        text-decoration: none;
    }
    .view-all-link:hover { color: #E04B1A; }

    .history-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 12px;
    }
    .history-table thead th {
        font-size: 0.7rem;
        font-weight: 700;
        color: #7F7F7F;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 8px 12px;
        border-bottom: 1px solid #F4F4F0;
        text-align: left;
    }
    .history-table tbody td {
        padding: 14px 12px;
        font-size: 0.85rem;
        color: #1A1A1A;
        border-bottom: 1px solid #F4F4F0;
        vertical-align: middle;
    }
    .history-table tbody tr:last-child td { border-bottom: none; }
    .history-table tbody tr:hover { background: #FAF9F6; }

    .leave-status-pill {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        border: 1px solid transparent;
        display: inline-block;
    }
    .status-approved { background: #ECFDF5; color: #059669; border-color: #D1FAE5; }
    .status-rejected { background: #FEE2E2; color: #DC2626; border-color: #FECACA; }
    .status-pending  { background: #FFF7ED; color: #EA580C; border-color: #FED7AA; }

    .btn-action-dot {
        background: transparent;
        border: none;
        color: #7F7F7F;
        font-size: 1.1rem;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-action-dot:hover { background: #F4F4F0; color: #1A1A1A; }

    /* CTA card */
    .cta-card {
        background: #FF5E2B;
        border-radius: 14px;
        padding: 24px;
        color: #fff;
    }
    .cta-icon {
        font-size: 1.6rem;
        margin-bottom: 12px;
        display: block;
    }
    .cta-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .cta-sub {
        font-size: 0.82rem;
        opacity: 0.85;
        margin-bottom: 20px;
        line-height: 1.5;
    }
    .btn-submit-request {
        background: #fff;
        color: #FF5E2B;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        padding: 11px 18px;
        width: 100%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-submit-request:hover { background: #FFF0EB; color: #FF5E2B; }

    /* HR support card */
    .hr-support-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 20px;
        margin-top: 16px;
    }
    .hr-support-title {
        font-family: 'Outfit', sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 14px;
    }
    .hr-person-avatar {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #E2E0DD;
        flex-shrink: 0;
    }
    .hr-person-name {
        font-size: 0.88rem;
        font-weight: 600;
        color: #1A1A1A;
    }
    .hr-person-role {
        font-size: 0.78rem;
        color: #7F7F7F;
    }
    .btn-message-hr {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #1A1A1A;
        padding: 10px;
        width: 100%;
        margin-top: 14px;
        cursor: pointer;
        transition: background 0.2s;
        text-align: center;
        text-decoration: none;
        display: block;
    }
    .btn-message-hr:hover { background: #FAF9F6; color: #1A1A1A; }

    /* ============================================
       RESPONSIVE STYLES
       ============================================ */

    /* ===== Tablet (≤991px) ===== */
    @media (max-width: 991.98px) {
        .welcome-title {
            font-size: 1.5rem;
        }

        .profile-card {
            padding: 20px;
        }

        .profile-avatar-wrap,
        .profile-avatar,
        .profile-avatar-placeholder {
            width: 80px;
            height: 80px;
        }

        .profile-name {
            font-size: 1.15rem;
        }

        .stat-card {
            padding: 16px;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            font-size: 0.95rem;
            margin-bottom: 24px;
        }

        .stat-label {
            font-size: 0.75rem;
        }

        .stat-number {
            font-size: 1.7rem;
        }

        .history-card {
            padding: 16px;
        }

        .history-table thead th {
            padding: 6px 10px;
            font-size: 0.68rem;
        }

        .history-table tbody td {
            padding: 12px 10px;
            font-size: 0.82rem;
        }

        .cta-card {
            padding: 20px;
        }

        .cta-title {
            font-size: 1rem;
        }

        .hr-support-card {
            padding: 16px;
        }
    }

    /* ===== Mobile (≤768px) ===== */
    @media (max-width: 768px) {
        .welcome-title {
            font-size: 1.3rem;
        }

        .welcome-sub {
            font-size: 0.82rem;
        }

        /* Profile card - full width */
        .profile-card {
            padding: 18px;
        }

        .profile-avatar-wrap,
        .profile-avatar,
        .profile-avatar-placeholder {
            width: 70px;
            height: 70px;
        }

        .profile-avatar-placeholder {
            font-size: 1.2rem;
        }

        .profile-name {
            font-size: 1.1rem;
        }

        .profile-role {
            font-size: 0.78rem;
            margin-bottom: 16px;
        }

        .profile-meta-row {
            gap: 16px;
            padding-top: 12px;
        }

        .profile-meta-item label {
            font-size: 0.65rem;
        }

        .profile-meta-item span {
            font-size: 0.82rem;
        }

        /* Stat cards - smaller */
        .stat-card {
            padding: 14px;
        }

        .stat-icon {
            width: 30px;
            height: 30px;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .stat-label {
            font-size: 0.72rem;
            margin-bottom: 4px;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .stat-number span {
            font-size: 0.8rem;
        }

        /* History card - horizontal scroll */
        .history-card {
            padding: 14px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .history-title {
            font-size: 0.92rem;
        }

        .view-all-link {
            font-size: 0.78rem;
        }

        .history-table {
            min-width: 600px;
        }

        .history-table thead th {
            padding: 6px 8px;
            font-size: 0.65rem;
            white-space: nowrap;
        }

        .history-table tbody td {
            padding: 10px 8px;
            font-size: 0.78rem;
        }

        .leave-status-pill {
            font-size: 0.65rem;
            padding: 3px 8px;
        }

        /* CTA card */
        .cta-card {
            padding: 18px;
        }

        .cta-icon {
            font-size: 1.4rem;
            margin-bottom: 10px;
        }

        .cta-title {
            font-size: 0.95rem;
            margin-bottom: 6px;
        }

        .cta-sub {
            font-size: 0.78rem;
            margin-bottom: 16px;
        }

        .btn-submit-request {
            font-size: 0.82rem;
            padding: 10px 16px;
        }

        /* HR support card */
        .hr-support-card {
            padding: 14px;
            margin-top: 12px;
        }

        .hr-support-title {
            font-size: 0.9rem;
            margin-bottom: 12px;
        }

        .hr-person-avatar {
            width: 40px;
            height: 40px;
        }

        .hr-person-name {
            font-size: 0.82rem;
        }

        .hr-person-role {
            font-size: 0.72rem;
        }

        .btn-message-hr {
            font-size: 0.82rem;
            padding: 9px;
            margin-top: 12px;
        }
    }

    /* ===== Small Mobile (≤576px) ===== */
    @media (max-width: 576px) {
        .welcome-title {
            font-size: 1.15rem;
        }

        .welcome-sub {
            font-size: 0.78rem;
        }

        /* Profile card - more compact */
        .profile-card {
            padding: 16px;
        }

        .profile-avatar-wrap,
        .profile-avatar,
        .profile-avatar-placeholder {
            width: 60px;
            height: 60px;
            margin-bottom: 12px;
        }

        .profile-avatar-placeholder {
            font-size: 1rem;
        }

        .employment-badge {
            font-size: 0.62rem;
            padding: 2px 6px;
            top: -6px;
            right: -6px;
        }

        .profile-name {
            font-size: 1rem;
        }

        .profile-role {
            font-size: 0.75rem;
            margin-bottom: 14px;
        }

        .profile-meta-row {
            gap: 12px;
        }

        .profile-meta-item label {
            font-size: 0.62rem;
        }

        .profile-meta-item span {
            font-size: 0.78rem;
        }

        /* Stat cards - even smaller */
        .stat-card {
            padding: 12px;
        }

        .stat-icon {
            width: 28px;
            height: 28px;
            font-size: 0.85rem;
            margin-bottom: 16px;
        }

        .stat-label {
            font-size: 0.68rem;
        }

        .stat-number {
            font-size: 1.3rem;
        }

        .stat-number span {
            font-size: 0.75rem;
        }

        .stat-badge-active {
            font-size: 0.62rem;
            padding: 2px 6px;
            top: 12px;
            right: 12px;
        }

        /* History table */
        .history-card {
            padding: 12px;
        }

        .history-table {
            min-width: 550px;
        }

        .history-table thead th {
            padding: 5px 6px;
            font-size: 0.62rem;
        }

        .history-table tbody td {
            padding: 8px 6px;
            font-size: 0.75rem;
        }

        /* CTA card */
        .cta-card {
            padding: 16px;
        }

        .cta-icon {
            font-size: 1.3rem;
        }

        .cta-title {
            font-size: 0.9rem;
        }

        .cta-sub {
            font-size: 0.75rem;
        }

        .btn-submit-request {
            font-size: 0.78rem;
            padding: 9px 14px;
        }

        /* HR support */
        .hr-support-card {
            padding: 12px;
        }

        .hr-support-title {
            font-size: 0.85rem;
        }

        .hr-person-avatar {
            width: 36px;
            height: 36px;
        }

        .hr-person-name {
            font-size: 0.78rem;
        }

        .hr-person-role {
            font-size: 0.68rem;
        }

        .btn-message-hr {
            font-size: 0.78rem;
            padding: 8px;
        }
    }

    /* ===== Extra Small Mobile (≤400px) ===== */
    @media (max-width: 400px) {
        .welcome-title {
            font-size: 1.05rem;
        }

        .profile-card {
            padding: 14px;
        }

        .profile-avatar-wrap,
        .profile-avatar,
        .profile-avatar-placeholder {
            width: 55px;
            height: 55px;
        }

        .profile-name {
            font-size: 0.95rem;
        }

        .stat-card {
            padding: 10px;
        }

        .stat-number {
            font-size: 1.2rem;
        }

        .history-table {
            min-width: 500px;
        }

        .cta-card {
            padding: 14px;
        }

        .cta-title {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')

  @if(session('success'))
    <div class="alert alert-success py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    </div>
  @endif

{{-- Welcome --}}
<div class="mb-4">
    <div class="welcome-title">Welcome back, {{ auth('employee')->user()->name ?? 'Employee' }}</div>
    <div class="welcome-sub">Here is an overview of your workspace today.</div>
</div>

<div class="row g-3">

    {{-- Left column --}}
    <div class="col-lg-8">

        {{-- Profile + Stats row --}}
        <div class="row g-3 mb-3">

            {{-- Profile card --}}
            <div class="col-12 col-md-4">
                <div class="profile-card">
                    <div class="profile-avatar-wrap">
                        @if(auth('employee')->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth('employee')->user()->profile_picture) }}"
                                 class="profile-avatar" alt="Profile">
                        @else
                            <div class="profile-avatar-placeholder">
                                {{ strtoupper(substr(auth('employee')->user()->name ?? 'E', 0, 2)) }}
                            </div>
                        @endif
                        <span class="employment-badge">
                            {{ ucfirst(auth('employee')->user()->employment_status ?? 'Permanent') }}
                        </span>
                    </div>

                    <div class="profile-name">{{ auth('employee')->user()->name ?? 'N/A' }}</div>
                    <div class="profile-role">
                        {{ auth('employee')->user()->designation ?? 'N/A' }}
                        @if(auth('employee')->user()->department)
                            • {{ auth('employee')->user()->department->name }}
                        @endif
                    </div>

                    <div class="profile-meta-row">
                        <div class="profile-meta-item">
                            <label>Employee ID</label>
                            <span>{{ auth('employee')->user()->employee_id ?? 'N/A' }}</span>
                        </div>
                        <div class="profile-meta-item">
                            <label>Joined Date</label>
                            <span>
                                {{ auth('employee')->user()->hire_date
                                    ? \Carbon\Carbon::parse(auth('employee')->user()->hire_date)->format('M d, Y')
                                    : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stat cards --}}
            <div class="col-12 col-md-8">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-card">
                            <div class="stat-icon green"><i class="bi bi-calendar3"></i></div>
                            <div class="stat-label">Annual Leave Balance</div>
                            <div class="stat-number">
                                {{ $annualBalance ?? 0 }}<span> days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <div class="stat-icon red"><i class="bi bi-bandaid"></i></div>
                            <div class="stat-label">Sick Leave Taken</div>
                            <div class="stat-number">
                                {{ $sickUsed ?? 0 }}<span> days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <div class="stat-icon blue"><i class="bi bi-person-check"></i></div>
                            <div class="stat-label">Casual Leave Taken</div>
                            <div class="stat-number">
                                {{ $casualUsed ?? 0 }}<span> days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <span class="stat-badge-active">Active</span>
                            <div class="stat-icon orange"><i class="bi bi-calendar2-check"></i></div>
                            <div class="stat-label">Remaining Leaves</div>
                            <div class="stat-number">
                                {{ $remainingLeaves ?? 0 }}<span> total</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Recent Leave History --}}
        <div class="history-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="history-title">Recent Leave History</span>
                <a href="{{route('employee.leave.history')}}" class="view-all-link">View All History</a>
            </div>

            <div class="table-responsive">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Leave Type</th>
                            <th>Duration</th>
                            <th>Dates</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLeaves ?? [] as $leave)
                        <tr>
                            <td style="font-weight:600;">{{ $leave->leaveType->name ?? 'N/A' }}</td>
                            <td style="color:#7F7F7F;">{{ $leave->duration }} {{ $leave->duration == 1 ? 'Day' : 'Days' }}</td>
                            <td style="color:#7F7F7F;">
                                @if($leave->from_date === $leave->to_date)
                                    {{ \Carbon\Carbon::parse($leave->from_date)->format('M d, Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($leave->from_date)->format('M d') }} -
                                    {{ \Carbon\Carbon::parse($leave->to_date)->format('M d, Y') }}
                                @endif
                            </td>
                            <td>
                                @php
                                    $st = $leave->status ?? 'pending';
                                    $cls = match($st) {
                                        'approved' => 'status-approved',
                                        'rejected' => 'status-rejected',
                                        default    => 'status-pending',
                                    };
                                @endphp
                                <span class="leave-status-pill {{ $cls }}">
                                    {{ ucfirst($st) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn-action-dot">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        @foreach([
                            ['Annual Leave',  '5 Days', 'Dec 24 - Dec 28, 2023', 'approved'],
                            ['Casual Leave',  '1 Day',  'Nov 15, 2023',          'approved'],
                            ['Sick Leave',    '2 Days', 'Oct 02 - Oct 03, 2023', 'rejected'],
                            ['Annual Leave',  '3 Days', 'Sep 10 - Sep 12, 2023', 'pending'],
                        ] as [$type, $dur, $dates, $status])
                        <tr>
                            <td style="font-weight:600;">{{ $type }}</td>
                            <td style="color:#7F7F7F;">{{ $dur }}</td>
                            <td style="color:#7F7F7F;">{{ $dates }}</td>
                            <td>
                                <span class="leave-status-pill {{ match($status) { 'approved' => 'status-approved', 'rejected' => 'status-rejected', default => 'status-pending' } }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn-action-dot">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Right column --}}
    <div class="col-lg-4">

        {{-- CTA card --}}
        <div class="cta-card">
            <span class="cta-icon"><i class="bi bi-send-fill"></i></span>
            <div class="cta-title">Planning a getaway?</div>
            <div class="cta-sub">Request your leave now to ensure timely approvals and smooth project handovers.</div>
            <a href="{{ route('employee.leave.create') }}" class="btn-submit-request">
                <i class="bi bi-plus-circle"></i> Submit New Request
            </a>
        </div>

        {{-- HR Support --}}
        <div class="hr-support-card">
            <div class="hr-support-title">HR Support</div>
            <div class="d-flex align-items-center gap-3">
                @if(isset($hrManager) && $hrManager->profile_picture)
                    <img src="{{ asset('storage/' . $hrManager->profile_picture) }}"
                         class="hr-person-avatar" alt="HR Manager">
                @else
                    <div class="profile-avatar-placeholder"
                         style="width:44px;height:44px;border-radius:10px;font-size:0.88rem;">
                        {{ isset($hrManager) ? strtoupper(substr($hrManager->name, 0, 2)) : 'SJ' }}
                    </div>
                @endif
                <div>
                    <div class="hr-person-name">{{ $hrManager->name ?? 'Sarah Jenkins' }}</div>
                    <div class="hr-person-role">{{ $hrManager->designation ?? 'HR Manager' }}</div>
                </div>
            </div>
            <a href="mailto:{{ $hrManager->email ?? '#' }}" class="btn-message-hr">
                Message HR
            </a>
        </div>

    </div>

</div>

@endsection