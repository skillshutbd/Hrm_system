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
</style>
@endpush

@section('content')

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
            <div class="col-md-4">
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
            <div class="col-md-8">
                <div class="row g-3 h-100">
                    <div class="col-6">
                        <div class="stat-card">
                            <svg class="stat-sparkline" width="60" height="30" viewBox="0 0 60 30">
                                <polyline points="0,25 15,15 30,20 45,8 60,12"
                                    fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <div class="stat-icon green"><i class="bi bi-calendar3"></i></div>
                            <div class="stat-label">Annual Leave Balance</div>
<div class="stat-number">
 {{ $annual->days_allowed ?? 0 }}<span> days</span>
</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <svg class="stat-sparkline" width="60" height="30" viewBox="0 0 60 30">
                                <polyline points="0,10 15,18 30,12 45,22 60,15"
                                    fill="none" stroke="#DC2626" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <div class="stat-icon red"><i class="bi bi-bandaid"></i></div>
                            <div class="stat-label">Sick Leave Taken</div>
                          <div class="stat-number">
    {{ $sick->days_allowed ?? 0 }}<span> days</span>
</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <svg class="stat-sparkline" width="60" height="30" viewBox="0 0 60 30">
                                <polyline points="0,20 20,15 40,18 60,10"
                                    fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <div class="stat-icon blue"><i class="bi bi-person-check"></i></div>
                            <div class="stat-label">Casual Leave Taken</div>
                            <div class="stat-number">
    {{ $casual->days_allowed ?? 0 }}<span> days</span>
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
                <a href="#" class="view-all-link">View All History</a>
            </div>

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

    {{-- Right column --}}
    <div class="col-lg-4">

        {{-- CTA card --}}
        <div class="cta-card">
            <span class="cta-icon"><i class="bi bi-send-fill"></i></span>
            <div class="cta-title">Planning a getaway?</div>
            <div class="cta-sub">Request your leave now to ensure timely approvals and smooth project handovers.</div>
            <a href="{{route('employee.leave.create')}}" class="btn-submit-request">
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