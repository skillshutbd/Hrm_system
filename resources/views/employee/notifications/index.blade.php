@extends('employee.layouts.employee')

@section('title', 'Notifications - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }

    .notif-mark-all {
        font-size: 0.82rem; font-weight: 600; color: #FF5E2B;
        text-decoration: none; cursor: pointer; background: none; border: none; padding: 0;
    }
    .notif-mark-all:hover { text-decoration: underline; }

    .notif-feed { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; overflow: hidden; }
    .notif-row {
        padding: 16px 24px; border-bottom: 1px solid #F4F4F0;
        display: flex; align-items: flex-start; gap: 14px;
        transition: background 0.15s; cursor: pointer;
    }
    .notif-row:last-child { border-bottom: none; }
    .notif-row:hover { background: #FAF9F6; }
    .notif-row.unread { background: #FFF8F5; }
    .notif-row.unread:hover { background: #FFF0EB; }

    .notif-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.05rem; flex-shrink: 0; }
    .notif-icon.leave_request      { background: #EBF3FF; color: #2563EB; }
    .notif-icon.leave_recommended  { background: #ECFDF5; color: #059669; }
    .notif-icon.leave_not_recommended,
    .notif-icon.hr_rejected        { background: #FEF2F2; color: #DC2626; }
    .notif-icon.hr_approved        { background: #ECFDF5; color: #059669; }
    .notif-icon.default            { background: #F4F4F0; color: #7F7F7F; }

    .notif-body { flex: 1; min-width: 0; }
    .notif-msg { font-size: 0.86rem; color: #1A1A1A; line-height: 1.4; margin-bottom: 4px; }
    .notif-msg.unread { font-weight: 600; }
    .notif-meta { font-size: 0.76rem; color: #7F7F7F; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .notif-leave-info { background: #F4F4F0; border-radius: 6px; padding: 2px 8px; font-size: 0.72rem; color: #4A4A4A; }

    .notif-dot { width: 8px; height: 8px; border-radius: 50%; background: #FF5E2B; flex-shrink: 0; margin-top: 6px; }

    .notif-empty { padding: 60px 24px; text-align: center; color: #7F7F7F; }
    .notif-empty i { font-size: 2.4rem; color: #E2E0DD; display: block; margin-bottom: 10px; }
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
            <h1 class="page-title mb-1">Notifications</h1>
            <p class="page-subtitle mb-0">Updates on your leave requests and approvals.</p>
        </div>

        @if($notifications->where('read_at', null)->count() > 0)
            <form method="POST" action="{{ route('employee.leave.notifications.mark-all-read') }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="notif-mark-all">
                    <i class="bi bi-check2-all me-1"></i> Mark all as read
                </button>
            </form>
        @endif
    </div>

    {{-- Feed --}}
    <div class="notif-feed">
        @forelse($notifications as $notif)
            @php
                $isUnread = is_null($notif->read_at);
                $iconClass = $notif->type ?? 'default';
            @endphp
            <div class="notif-row {{ $isUnread ? 'unread' : '' }}" onclick="markRead({{ $notif->id }}, this)">
                <div class="notif-icon {{ $iconClass }}">
                    <i class="bi
                        @switch($notif->type)
                            @case('leave_request') bi-calendar-plus @break
                            @case('leave_recommended') bi-check-circle @break
                            @case('leave_not_recommended') bi-x-circle @break
                            @case('hr_approved') bi-check-circle-fill @break
                            @case('hr_rejected') bi-x-circle-fill @break
                            @default bi-bell
                        @endswitch
                    "></i>
                </div>
                <div class="notif-body">
                    <div class="notif-msg {{ $isUnread ? 'unread' : '' }}">
                        {{ $notif->message }}
                    </div>
                    <div class="notif-meta">
                        <span><i class="bi bi-clock" style="font-size:0.7rem;"></i> {{ $notif->created_at->diffForHumans() }}</span>
                        @if($notif->leave)
                            <span class="notif-leave-info">
                                {{ $notif->leave->leaveType->name ?? 'Leave' }} &middot;
                                {{ \Carbon\Carbon::parse($notif->leave->from_date)->format('M d') }} -
                                {{ \Carbon\Carbon::parse($notif->leave->to_date)->format('M d') }}
                            </span>
                        @endif
                    </div>
                </div>
                @if($isUnread)
                    <div class="notif-dot"></div>
                @endif
            </div>
        @empty
            <div class="notif-empty">
                <i class="bi bi-bell-slash"></i>
                No notifications yet.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($notifications->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <span style="font-size:0.82rem; color:#7F7F7F;">
            Showing {{ $notifications->firstItem() ?? 0 }}–{{ $notifications->lastItem() ?? 0 }} of {{ $notifications->total() }}
        </span>
        {{ $notifications->links() }}
    </div>
    @endif

@endsection

@push('scripts')
<script>
    const EMPLOYEE_NOTIF_BASE_URL = "{{ url('/employee/leave/notifications') }}";

    function markRead(notifId, element) {
        if (!element.classList.contains('unread')) return;

        fetch(`${EMPLOYEE_NOTIF_BASE_URL}/${notifId}/read`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        }).then(() => {
            element.classList.remove('unread');
            element.querySelector('.notif-msg')?.classList.remove('unread');
            const dot = element.querySelector('.notif-dot');
            if (dot) dot.remove();
        });
    }
</script>
@endpush