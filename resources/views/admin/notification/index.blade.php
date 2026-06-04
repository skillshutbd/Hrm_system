@extends('admin.layouts.admin')

@section('title', 'Notifications - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.88rem; color: #7F7F7F; }

    /* Filter Tabs */
    .filter-tabs { display: flex; gap: 8px; }
    .filter-tab { border: 1px solid #E2E0DD; background: #fff; color: #7F7F7F; border-radius: 8px; font-size: 0.82rem; font-weight: 600; padding: 7px 16px; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .filter-tab:hover { border-color: #FF5E2B; color: #FF5E2B; }
    .filter-tab.active { background: #FF5E2B; color: #fff; border-color: #FF5E2B; }

    /* Notification Card */
    .notif-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; overflow: hidden; }
    .notif-item { padding: 18px 24px; border-bottom: 1px solid #F4F4F0; display: flex; align-items: flex-start; gap: 14px; transition: background 0.15s; }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: #FAF9F6; }
    .notif-item.unread { border-left: 3px solid #FF5E2B; background: #FFF8F5; }
    .notif-item.unread:hover { background: #FFF3EE; }

    .notif-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .notif-icon.tl    { background: #FFF3EE; color: #FF5E2B; }
    .notif-icon.emp   { background: #ECFDF5; color: #059669; }
    .notif-icon.info  { background: #EFF6FF; color: #3B82F6; }
    .notif-icon.warn  { background: #FFFBEB; color: #D97706; }

    .notif-body { flex: 1; min-width: 0; }
    .notif-title { font-size: 0.88rem; font-weight: 700; color: #1A1A1A; margin-bottom: 3px; }
    .notif-message { font-size: 0.82rem; color: #7F7F7F; }
    .notif-time { font-size: 0.72rem; color: #B2ADA7; margin-top: 4px; display: flex; align-items: center; gap: 4px; }

    .notif-actions { display: flex; gap: 6px; flex-shrink: 0; align-items: center; }

    .btn-approve { background: #ECFDF5; color: #059669; border: 1px solid #A7F3D0; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 5px 12px; cursor: pointer; transition: all 0.15s; white-space: nowrap; }
    .btn-approve:hover { background: #059669; color: #fff; border-color: #059669; }
    .btn-reject { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; border-radius: 6px; font-size: 0.78rem; font-weight: 600; padding: 5px 12px; cursor: pointer; transition: all 0.15s; white-space: nowrap; }
    .btn-reject:hover { background: #DC2626; color: #fff; border-color: #DC2626; }

    .badge-pending  { background: #FEF3C7; color: #D97706; border-radius: 20px; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; }
    .badge-approved { background: #ECFDF5; color: #059669; border-radius: 20px; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; }
    .badge-rejected { background: #FEF2F2; color: #DC2626; border-radius: 20px; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; }

    /* KPI */
    .kpi-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 12px; padding: 18px 22px; display: flex; justify-content: space-between; align-items: center; }
    .kpi-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; margin-bottom: 4px; }
    .kpi-value { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800; color: #1A1A1A; }
    .kpi-icon { width: 38px; height: 38px; border-radius: 50%; background: #FAF9F6; border: 1px solid #E2E0DD; display: flex; align-items: center; justify-content: center; color: #7F7F7F; font-size: 1rem; }
</style>
@endpush

@section('content')

@php
    $filter = request('filter', 'all');

    $query = \App\Models\Notification::with('employee')
        ->when($filter === 'pending',  fn($q) => $q->where('status', 'pending'))
        ->when($filter === 'approved', fn($q) => $q->where('status', 'approved'))
        ->when($filter === 'rejected', fn($q) => $q->where('status', 'rejected'))
        ->latest();

    $notifications = $query->paginate(10)->withQueryString();

    $totalCount    = \App\Models\Notification::count();
    $pendingCount  = \App\Models\Notification::where('status', 'pending')->count();
    $approvedCount = \App\Models\Notification::where('status', 'approved')->count();
    $rejectedCount = \App\Models\Notification::where('status', 'rejected')->count();
@endphp

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title mb-1">Notifications</h1>
            <p class="page-subtitle mb-0">Review and manage all system activity requests.</p>
        </div>
        @if($pendingCount > 0)
            <span style="background:#FEF3C7; color:#92400E; font-size:0.82rem; font-weight:700; padding:8px 16px; border-radius:8px; border:1px solid #FDE68A;">
                <i class="bi bi-hourglass-split me-1"></i> {{ $pendingCount }} pending
            </span>
        @endif
    </div>

    {{-- KPI --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div><div class="kpi-label">Total</div><div class="kpi-value">{{ $totalCount }}</div></div>
                <div class="kpi-icon"><i class="bi bi-bell"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div><div class="kpi-label">Pending</div><div class="kpi-value" style="color:#D97706;">{{ $pendingCount }}</div></div>
                <div class="kpi-icon" style="background:#FFFBEB; color:#D97706; border-color:rgba(217,119,6,0.2);"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div><div class="kpi-label">Approved</div><div class="kpi-value" style="color:#059669;">{{ $approvedCount }}</div></div>
                <div class="kpi-icon" style="background:#ECFDF5; color:#059669; border-color:#A7F3D0;"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div><div class="kpi-label">Rejected</div><div class="kpi-value" style="color:#DC2626;">{{ $rejectedCount }}</div></div>
                <div class="kpi-icon" style="background:#FEF2F2; color:#DC2626; border-color:#FECACA;"><i class="bi bi-x-circle"></i></div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="filter-tabs">
            <a href="?filter=all"      class="filter-tab {{ $filter === 'all'      ? 'active' : '' }}">All</a>
            <a href="?filter=pending"  class="filter-tab {{ $filter === 'pending'  ? 'active' : '' }}">
                Pending @if($pendingCount > 0) <span style="background:rgba(255,255,255,0.3); padding:1px 6px; border-radius:10px; font-size:0.7rem;">{{ $pendingCount }}</span> @endif
            </a>
            <a href="?filter=approved" class="filter-tab {{ $filter === 'approved' ? 'active' : '' }}">Approved</a>
            <a href="?filter=rejected" class="filter-tab {{ $filter === 'rejected' ? 'active' : '' }}">Rejected</a>
        </div>
        <span style="font-size:0.78rem; color:#B2ADA7;">{{ $notifications->total() }} results</span>
    </div>

    {{-- Notification List --}}
    <div class="notif-card">
        @forelse($notifications as $notification)
        @php
            $emp = $notification->employee;
            $isPending = $notification->status === 'pending';
            $icon = match($notification->type) {
                'tl_assignment_request' => ['class' => 'tl',   'icon' => 'bi-person-check-fill'],
                'employee_creation'     => ['class' => 'emp',  'icon' => 'bi-person-plus-fill'],
                default                 => ['class' => 'info', 'icon' => 'bi-info-circle-fill'],
            };
        @endphp

        <div class="notif-item {{ $isPending ? 'unread' : '' }}">

            {{-- Icon --}}
            <div class="notif-icon {{ $icon['class'] }}">
                <i class="bi {{ $icon['icon'] }}"></i>
            </div>

            {{-- Body --}}
            <div class="notif-body">
                <div class="notif-title">
                    @if($notification->type === 'tl_assignment_request')
                        TL Assignment Request
                    @elseif($notification->type === 'employee_creation')
                        New Employee Added
                    @else
                        System Notification
                    @endif
                </div>
                <div class="notif-message">{{ $notification->message }}</div>
                <div class="notif-time">
                    <i class="bi bi-clock" style="font-size:0.65rem;"></i>
                    {{ $notification->created_at->diffForHumans() }}
                    @if($emp)
                        &nbsp;·&nbsp; {{ $emp->name }}
                        @if($emp->department) · {{ $emp->department->name }} @endif
                    @endif
                </div>
            </div>

            {{-- Status / Actions --}}
            <div class="notif-actions">
        
    @if($notification->type === 'tl_assignment_request' && $isPending)
        <a href="{{ route('admin.teamlead.index', $emp->id) }}" class="btn-view">
            <i class="bi bi-eye"></i> View
        </a>
        @elseif($notification->type === 'employee_creation' && $isPending)
        <a href="{{ route('admin.employee.creation_index', $emp->id) }}" class="btn-view">
            <i class="bi bi-eye"></i> View
        </a>
    @endif
               
            </div>

        </div>
        @empty
            <div class="text-center py-5" style="color:#B2ADA7;">
                <i class="bi bi-bell-slash d-block mb-2" style="font-size:2rem;"></i>
                No notifications found.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <span style="font-size:0.82rem; color:#7F7F7F;">
            Showing {{ $notifications->firstItem() ?? 0 }}–{{ $notifications->lastItem() ?? 0 }} of {{ $notifications->total() }}
        </span>
        {{ $notifications->links() }}
    </div>

@endsection