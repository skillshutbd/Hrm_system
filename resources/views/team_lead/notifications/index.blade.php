@extends('team_lead.layouts.tl')

@section('title', 'Notifications - Skills Hut Ltd')

@push('styles')
<style>
/* ── Base ───────────────────────────────────── */
.page-title    { font-family:'Outfit',sans-serif; font-size:1.8rem; font-weight:700; color:#1A1A1A; }
.page-subtitle { font-size:0.88rem; color:#7F7F7F; }

/* ── KPI Cards ───────────────────────────────── */
.kpi-card  { background:#fff; border:1px solid #E2E0DD; border-radius:12px; padding:18px 22px; display:flex; justify-content:space-between; align-items:center; }
.kpi-label { font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.8px; color:#7F7F7F; margin-bottom:4px; }
.kpi-value { font-family:'Outfit',sans-serif; font-size:1.8rem; font-weight:800; color:#1A1A1A; }
.kpi-icon  { width:38px; height:38px; border-radius:50%; background:#FAF9F6; border:1px solid #E2E0DD; display:flex; align-items:center; justify-content:center; color:#7F7F7F; font-size:1rem; }

/* ── Filter Tabs ─────────────────────────────── */
.filter-tabs { display:flex; gap:8px; flex-wrap:wrap; }
.filter-tab  { border:1px solid #E2E0DD; background:#fff; color:#7F7F7F; border-radius:8px; font-size:0.82rem; font-weight:600; padding:7px 16px; cursor:pointer; transition:all .2s; text-decoration:none; }
.filter-tab:hover  { border-color:#FF5E2B; color:#FF5E2B; }
.filter-tab.active { background:#FF5E2B; color:#fff; border-color:#FF5E2B; }

/* ── Notification List ───────────────────────── */
.notif-card { background:#fff; border:1px solid #E2E0DD; border-radius:14px; overflow:hidden; }

.notif-item             { padding:18px 24px; border-bottom:1px solid #F4F4F0; display:flex; align-items:flex-start; gap:14px; transition:background .15s; }
.notif-item:last-child  { border-bottom:none; }
.notif-item:hover       { background:#FAF9F6; }
.notif-item.unread      { border-left:3px solid #FF5E2B; background:#FFF8F5; }
.notif-item.unread:hover{ background:#FFF3EE; }

.notif-icon             { width:42px; height:42px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
.notif-icon.submitted   { background:#EFF6FF; color:#2563EB; }
.notif-icon.approved    { background:#ECFDF5; color:#059669; }
.notif-icon.rejected    { background:#FEF2F2; color:#DC2626; }
.notif-icon.default     { background:#F4F4F0; color:#7F7F7F; }

.notif-body    { flex:1; min-width:0; }
.notif-title   { font-size:0.88rem; font-weight:700; color:#1A1A1A; margin-bottom:3px; }
.notif-message { font-size:0.82rem; color:#7F7F7F; line-height:1.5; }
.notif-time    { font-size:0.72rem; color:#B2ADA7; margin-top:4px; display:flex; align-items:center; gap:4px; }

.notif-dot     { width:8px; height:8px; border-radius:50%; background:#FF5E2B; flex-shrink:0; margin-top:6px; }

/* ── Badges ──────────────────────────────────── */
.badge-submitted { background:#EFF6FF; color:#1D4ED8; border-radius:20px; font-size:.72rem; font-weight:700; padding:3px 10px; }
.badge-approved  { background:#ECFDF5; color:#059669; border-radius:20px; font-size:.72rem; font-weight:700; padding:3px 10px; }
.badge-rejected  { background:#FEF2F2; color:#DC2626; border-radius:20px; font-size:.72rem; font-weight:700; padding:3px 10px; }

/* ── Mark Read Button ────────────────────────── */
.btn-mark-read { background:#fff; border:1px solid #E2E0DD; border-radius:8px; color:#4A4A4A; font-size:.8rem; font-weight:600; padding:8px 16px; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:6px; cursor:pointer; }
.btn-mark-read:hover { background:#FAF9F6; color:#FF5E2B; border-color:#FF5E2B; }
</style>
@endpush

@section('content')

@php
    $filter = request('filter', 'all');

    $totalCount    = $notifications->total();
    $unreadCount   = \App\Models\LeaveNotification::where('recipient_type','tl')
        ->where('recipient_id', auth('tl')->user()->employee->id ?? 0)
        ->whereNull('read_at')->count();
    $readCount     = $totalCount - $unreadCount;

    $iconMap = [
        'leave_submitted'     => ['icon' => 'bi-calendar-plus',    'class' => 'submitted', 'label' => 'Leave Submitted'],
        'tl_recommended'      => ['icon' => 'bi-check-circle',     'class' => 'approved',  'label' => 'Recommended'],
        'tl_not_recommended'  => ['icon' => 'bi-x-circle',         'class' => 'rejected',  'label' => 'Not Recommended'],
        'hr_approved'         => ['icon' => 'bi-check-circle-fill','class' => 'approved',  'label' => 'HR Approved'],
        'hr_rejected'         => ['icon' => 'bi-x-circle-fill',    'class' => 'rejected',  'label' => 'HR Rejected'],
    ];
@endphp

{{-- ════════════════════════════════════════════
     ALERTS
═════════════════════════════════════════════ --}}
@if(session('success'))
    <div class="alert border-0 rounded-3 mb-3"
         style="background:#ECFDF5; color:#059669; font-size:.88rem;">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    </div>
@endif

{{-- ════════════════════════════════════════════
     PAGE HEADER
═════════════════════════════════════════════ --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Notifications</h1>
        <p class="page-subtitle mb-0">All leave activity updates for your team.</p>
    </div>

    @if($unreadCount > 0)
        <form method="POST"
              action="{{ route('team_lead.notifications.mark-all-read') }}">
            @csrf
            <button type="submit" class="btn-mark-read">
                <i class="bi bi-check2-all"></i> Mark all as read
            </button>
        </form>
    @endif
</div>

{{-- ════════════════════════════════════════════
     KPI CARDS
═════════════════════════════════════════════ --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="kpi-card">
            <div>
                <div class="kpi-label">Total</div>
                <div class="kpi-value">{{ $totalCount }}</div>
            </div>
            <div class="kpi-icon"><i class="bi bi-bell"></i></div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="kpi-card">
            <div>
                <div class="kpi-label">Unread</div>
                <div class="kpi-value" style="color:#FF5E2B;">{{ $unreadCount }}</div>
            </div>
            <div class="kpi-icon" style="background:#FFF8F5; color:#FF5E2B; border-color:rgba(255,94,43,.2);">
                <i class="bi bi-bell-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="kpi-card">
            <div>
                <div class="kpi-label">Read</div>
                <div class="kpi-value" style="color:#7F7F7F;">{{ $readCount }}</div>
            </div>
            <div class="kpi-icon" style="background:#F4F4F0; color:#7F7F7F;">
                <i class="bi bi-bell-slash"></i>
            </div>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════
     FILTER TABS
═════════════════════════════════════════════ --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="filter-tabs">
        <a href="?filter=all"
           class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">
            All
            <span style="opacity:.7; font-size:.75rem;">({{ $totalCount }})</span>
        </a>
        <a href="?filter=unread"
           class="filter-tab {{ $filter === 'unread' ? 'active' : '' }}">
            Unread
            @if($unreadCount > 0)
                <span style="background:rgba(255,255,255,.3); padding:1px 6px; border-radius:10px; font-size:.7rem;">
                    {{ $unreadCount }}
                </span>
            @endif
        </a>
        <a href="?filter=read"
           class="filter-tab {{ $filter === 'read' ? 'active' : '' }}">
            Read
        </a>
    </div>
    <span style="font-size:.78rem; color:#B2ADA7;">
        {{ $notifications->total() }} results
    </span>
</div>

{{-- ════════════════════════════════════════════
     NOTIFICATION LIST
═════════════════════════════════════════════ --}}
<div class="notif-card">
    @forelse($notifications as $notif)
    @php
        $map     = $iconMap[$notif->type] ?? ['icon'=>'bi-bell','class'=>'default','label'=>'Notification'];
        $isUnread = is_null($notif->read_at);
        $emp     = $notif->leave->employee ?? null;
    @endphp

    <div class="notif-item {{ $isUnread ? 'unread' : '' }}"
         id="notif-{{ $notif->id }}">

        {{-- Icon --}}
        <div class="notif-icon {{ $map['class'] }}">
            <i class="bi {{ $map['icon'] }}"></i>
        </div>

        {{-- Body --}}
        <div class="notif-body">
            <div class="notif-title">{{ $map['label'] }}</div>
            <div class="notif-message">{{ $notif->message }}</div>
            <div class="notif-time">
                <i class="bi bi-clock" style="font-size:.65rem;"></i>
                {{ $notif->created_at->diffForHumans() }}
                @if($emp)
                    &nbsp;·&nbsp;
                    <span style="font-weight:600; color:#4A4A4A;">{{ $emp->name }}</span>
                    @if($emp->department)
                        &nbsp;·&nbsp; {{ $emp->department->name }}
                    @endif
                @endif
            </div>
        </div>

        {{-- Badge + Mark Read --}}
        <div class="d-flex flex-column align-items-end gap-2">

            {{-- Type badge --}}
            @if(str_contains($notif->type, 'approved'))
                <span class="badge-approved">Approved</span>
            @elseif(str_contains($notif->type, 'rejected') || str_contains($notif->type, 'not_recommended'))
                <span class="badge-rejected">Rejected</span>
            @else
                <span class="badge-submitted">New</span>
            @endif

            {{-- Unread dot + mark read --}}
            @if($isUnread)
                <button onclick="markRead({{ $notif->id }})"
                        class="btn-mark-read" style="font-size:.72rem; padding:4px 10px;">
                    Mark read
                </button>
            @else
                <span style="font-size:.72rem; color:#B2ADA7;">
                    <i class="bi bi-check2"></i> Read
                </span>
            @endif

        </div>

    </div>
    @empty
    <div class="text-center py-5" style="color:#B2ADA7;">
        <i class="bi bi-bell-slash d-block mb-2" style="font-size:2rem;"></i>
        <div style="font-weight:600; color:#4A4A4A; margin-bottom:4px;">No notifications</div>
        <div style="font-size:.85rem;">You're all caught up!</div>
    </div>
    @endforelse
</div>

{{-- ════════════════════════════════════════════
     PAGINATION
═════════════════════════════════════════════ --}}
@if($notifications->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3">
    <span style="font-size:.82rem; color:#7F7F7F;">
        Showing {{ $notifications->firstItem() }}–{{ $notifications->lastItem() }}
        of {{ $notifications->total() }}
    </span>
    {{ $notifications->links() }}
</div>
@endif

@push('scripts')
<script>
function markRead(id) {
    fetch(`/team-lead/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    }).then(res => {
        if (res.ok) {
            const item = document.getElementById(`notif-${id}`);
            item.classList.remove('unread');

            // Remove mark read button, show Read text
            const btn = item.querySelector('button');
            if (btn) {
                const span = document.createElement('span');
                span.style.cssText = 'font-size:.72rem; color:#B2ADA7;';
                span.innerHTML = '<i class="bi bi-check2"></i> Read';
                btn.replaceWith(span);
            }

            // Update bell badge count
            const badge = document.querySelector('#notif-btn .badge');
            if (badge) {
                const count = parseInt(badge.textContent) - 1;
                count <= 0 ? badge.remove() : (badge.textContent = count);
            }
        }
    });
}
</script>
@endpush

@endsection