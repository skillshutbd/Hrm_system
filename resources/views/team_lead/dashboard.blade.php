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
    .tl-stat-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.07);
    }
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 14px;
    }
    .stat-icon.orange  { background: #FFF0EB; color: #FF5E2B; }
    .stat-icon.blue    { background: #EBF3FF; color: #2563EB; }
    .stat-icon.red     { background: #FEE2E2; color: #DC2626; }

    .stat-number {
        font-family: 'Outfit', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #1A1A1A;
        line-height: 1;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 0.82rem;
        color: #7F7F7F;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .stat-sub {
        font-size: 0.78rem;
        color: #7F7F7F;
    }
    .stat-sub.green  { color: #059669; font-weight: 600; }
    .stat-sub.urgent { color: #DC2626; font-weight: 700; }

    /* Section titles */
    .section-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 0;
    }
    .view-all {
        font-size: 0.82rem;
        font-weight: 600;
        color: #FF5E2B;
        text-decoration: none;
    }
    .view-all:hover { color: #E04B1A; }

    /* Team card */
    .team-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 16px;
    }
    .team-member {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #F4F4F0;
    }
    .team-member:last-child { border-bottom: none; }
    .member-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #E2E0DD;
        background: #F4F4F0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 0.88rem;
        color: #FF5E2B;
        flex-shrink: 0;
    }
    .member-name {
        font-size: 0.88rem;
        font-weight: 600;
        color: #1A1A1A;
    }
    .member-role {
        font-size: 0.78rem;
        color: #7F7F7F;
    }
    .status-pill {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        letter-spacing: 0.3px;
        margin-left: auto;
        flex-shrink: 0;
    }
    .pill-active   { background: #ECFDF5; color: #059669; }
    .pill-leave    { background: #FFF7ED; color: #EA580C; }
    .pill-inactive { background: #F4F4F0; color: #7F7F7F; }

    /* Leave recommendations table */
    .leave-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 20px;
    }
    .leave-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
    }
    .leave-table thead th {
        font-size: 0.72rem;
        font-weight: 700;
        color: #7F7F7F;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 10px 12px;
        border-bottom: 1px solid #F4F4F0;
        text-align: left;
    }
    .leave-table tbody td {
        padding: 14px 12px;
        border-bottom: 1px solid #F4F4F0;
        font-size: 0.85rem;
        color: #1A1A1A;
        vertical-align: middle;
    }
    .leave-table tbody tr:last-child td { border-bottom: none; }
    .leave-table tbody tr:hover { background: #FAF9F6; }

    .emp-avatar {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 0.78rem;
        color: #fff;
        margin-right: 10px;
        flex-shrink: 0;
    }
    .emp-name { font-weight: 600; font-size: 0.88rem; }

    .leave-status {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 20px;
        white-space: nowrap;
    }
    .status-pending  { background: #FFF7ED; color: #EA580C; }
    .status-urgent   { background: #FEE2E2; color: #DC2626; }
    .status-approved { background: #ECFDF5; color: #059669; }

    .btn-recommend {
        background: #FF5E2B;
        color: #fff;
        border: none;
        border-radius: 7px;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 7px 14px;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .btn-recommend:hover { background: #E04B1A; }

    .btn-view {
        background: transparent;
        border: none;
        color: #7F7F7F;
        font-size: 1rem;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 6px;
        transition: color 0.2s, background 0.2s;
    }
    .btn-view:hover { color: #1A1A1A; background: #F4F4F0; }

    .btn-filter {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 7px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #1A1A1A;
        padding: 6px 12px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-filter:hover { background: #F4F4F0; }

    .pagination-btn {
        width: 32px;
        height: 32px;
        border-radius: 7px;
        border: 1px solid #E2E0DD;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.85rem;
        color: #1A1A1A;
        transition: background 0.2s;
    }
    .pagination-btn:hover { background: #F4F4F0; }
    .pagination-info { font-size: 0.78rem; color: #7F7F7F; }
</style>
@endpush

@section('content')

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="tl-stat-card">
            <div class="stat-icon orange"><i class="bi bi-people-fill"></i></div>
            <div class="stat-label">Total Members</div>
            <div class="stat-number">{{ $totalMembers ?? 24 }}</div>
            <div class="stat-sub green"><i class="bi bi-arrow-up"></i> +2 this month</div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="tl-stat-card">
            <div class="stat-icon blue"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="stat-label">Active on Leave</div>
            <div class="stat-number">{{ $activeOnLeave ?? '04' }}</div>
            <div class="stat-sub">Returning next week</div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="tl-stat-card">
            <div class="stat-icon red"><i class="bi bi-clipboard2-pulse-fill"></i></div>
            <div class="stat-label">Pending Recommendations</div>
            <div class="stat-number">{{ $pendingRecommendations ?? '07' }}</div>
            <div class="stat-sub urgent"><i class="bi bi-exclamation-circle-fill"></i> 3 Urgent</div>
        </div>
    </div>
</div>

{{-- My Team + Leave Recommendations --}}
<div class="row g-3">

    {{-- My Team --}}
    <div class="col-lg-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-people" style="color:#FF5E2B;"></i>
                <span class="section-title">My Team</span>
            </div>
            <a href="{{route('team_lead.memberIndex')}}" class="view-all">View All</a>
        </div>

        <div class="team-card">
            @forelse($teamMembers ?? [] as $member)
            <div class="team-member">
                @if($member->profile_picture)
                    <img src="{{ asset('storage/' . $member->profile_picture) }}" class="member-avatar" style="border-radius:10px;width:40px;height:40px;object-fit:cover;">
                @else
                    <div class="member-avatar">{{ strtoupper(substr($member->name, 0, 2)) }}</div>
                @endif
                <div>
                    <div class="member-name">{{ $member->name }}</div>
                    <div class="member-role">{{ $member->designation ?? 'N/A' }}</div>
                </div>
                <span class="status-pill {{ $member->status === 'active' ? 'pill-active' : ($member->status === 'on_leave' ? 'pill-leave' : 'pill-inactive') }}">
                    {{ strtoupper(str_replace('_', ' ', $member->status)) }}
                </span>
            </div>
            @empty
            {{-- Placeholder rows --}}
            @foreach([['Sarah Jenkins','Senior Designer','active'],['Marcus Thorne','Data Analyst','on_leave'],['Elena Rodriguez','HR Specialist','active'],['David Chen','Software Engineer','active']] as [$n,$r,$s])
            <div class="team-member">
                <div class="member-avatar">{{ strtoupper(substr($n,0,2)) }}</div>
                <div>
                    <div class="member-name">{{ $n }}</div>
                    <div class="member-role">{{ $r }}</div>
                </div>
                <span class="status-pill {{ $s === 'active' ? 'pill-active' : 'pill-leave' }}">
                    {{ strtoupper(str_replace('_',' ',$s)) }}
                </span>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>

    {{-- Leave Recommendations --}}
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
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
                                <div class="emp-avatar" style="background:{{ ['#FF5E2B','#2563EB','#059669','#7C3AED'][($loop->index % 4)] }}">
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
                            <span class="leave-status {{ $leave->tl_status === 'pending' ? 'status-pending' : 'status-urgent' }}">
                                {{ ucfirst($leave->tl_status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <form action="{{ route('tl.leave.recommend', $leave->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-recommend">Recommend</button>
                                </form>
                                <a href="{{ route('tl.leave.show', $leave->id) }}" class="btn-view">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    {{-- Placeholder rows --}}
                    @foreach([['BT','Benjamin Taylor','Annual Leave','5 Days','Oct 12 - Oct 17','pending'],['JW','Jessica Wong','Sick Leave','2 Days','Oct 05 - Oct 07','urgent'],['AS','Aaron Smith','Personal Leave','1 Day','Oct 20','pending']] as [$init,$name,$type,$dur,$dates,$status])
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="emp-avatar" style="background:{{ $loop->index === 0 ? '#2563EB' : ($loop->index === 1 ? '#7C3AED' : '#059669') }}">{{ $init }}</div>
                                <span class="emp-name">{{ $name }}</span>
                            </div>
                        </td>
                        <td>{{ $type }}</td>
                        <td>
                            <div style="font-weight:600;">{{ $dur }}</div>
                            <div style="font-size:0.75rem;color:#7F7F7F;">{{ $dates }}</div>
                        </td>
                        <td>
                            <span class="leave-status {{ $status === 'urgent' ? 'status-urgent' : 'status-pending' }}">
                                {{ $status === 'urgent' ? 'Urgent Review' : 'Pending TL' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn-recommend">Recommend</button>
                                <button class="btn-view"><i class="bi bi-eye"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3 pt-2" style="border-top:1px solid #F4F4F0;">
                <span class="pagination-info">Showing 3 of {{ $totalPending ?? 7 }} pending requests</span>
                <div class="d-flex gap-2">
                    <button class="pagination-btn"><i class="bi bi-chevron-left"></i></button>
                    <button class="pagination-btn"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection