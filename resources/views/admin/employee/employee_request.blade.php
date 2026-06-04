@extends('admin.layouts.admin')

@section('title', 'Employee Approvals - Skills Hut Ltd')

@push('styles')
<style>
    .pending-panel { background:#fff; border:1px solid #FDE68A; border-radius:14px; overflow:hidden; }
    .pending-panel-header { background:#FFFBEB; border-bottom:1px solid #FDE68A; padding:14px 20px; display:flex; align-items:center; justify-content:space-between; }
    .pending-panel-title { font-family:'Outfit',sans-serif; font-size:0.95rem; font-weight:700; color:#92400E; display:flex; align-items:center; gap:8px; }
    .pending-count-badge { background:#F59E0B; color:#fff; font-size:0.7rem; font-weight:700; padding:2px 8px; border-radius:20px; letter-spacing:.3px; }
    .pending-item { padding:14px 20px; border-bottom:1px solid #FEF3C7; display:flex; align-items:center; gap:14px; transition:background .15s; }
    .pending-item:last-child { border-bottom:none; }
    .pending-item:hover { background:#FFFBEB; }
    .pending-avatar { width:38px; height:38px; border-radius:8px; background:#FEF3C7; color:#92400E; font-weight:700; font-size:0.85rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .pending-info { flex:1; min-width:0; }
    .pending-name { font-size:0.88rem; font-weight:700; color:#1A1A1A; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .pending-meta { font-size:0.75rem; color:#7F7F7F; margin-top:2px; }
    .pending-message { font-size:0.78rem; color:#7F7F7F; flex:1; min-width:0; }
    .pending-message span { white-space:nowrap; overflow:hidden; text-overflow:ellipsis; display:block; max-width:260px; }
    .pending-actions { display:flex; gap:6px; flex-shrink:0; }
    .btn-approve { background:#ECFDF5; color:#059669; border:1px solid #A7F3D0; border-radius:6px; font-size:0.78rem; font-weight:600; padding:5px 12px; cursor:pointer; transition:all .15s; white-space:nowrap; }
    .btn-approve:hover { background:#059669; color:#fff; border-color:#059669; }
    .btn-reject { background:#FEF2F2; color:#DC2626; border:1px solid #FECACA; border-radius:6px; font-size:0.78rem; font-weight:600; padding:5px 12px; cursor:pointer; transition:all .15s; white-space:nowrap; }
    .btn-reject:hover { background:#DC2626; color:#fff; border-color:#DC2626; }
    .btn-view { background:#fff; border:1px solid #E2E0DD; color:#4A4A4A; border-radius:6px; font-size:0.78rem; font-weight:600; padding:5px 12px; text-decoration:none; transition:all 0.2s; display:inline-flex; align-items:center; gap:4px; }
    .btn-view:hover { border-color:#FF5E2B; color:#FF5E2B; }
</style>
@endpush

@section('content')

@php
    $pendingNotifications = \App\Models\Notification::with(['employee.department'])
        ->where('type', 'employee_creation')
        ->where('status', 'pending')
        ->latest()
        ->get();
@endphp

{{-- Alerts --}}
@if(session('success'))
    <div class="alert alert-success py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    </div>
@endif

@if($pendingNotifications->isNotEmpty())
<div class="pending-panel mb-4">

    <div class="pending-panel-header">
        <div class="pending-panel-title">
            <i class="bi bi-hourglass-split"></i>
            Pending Employee Approvals
            <span class="pending-count-badge">{{ $pendingNotifications->count() }}</span>
        </div>
        <span style="font-size:0.78rem; color:#92400E; opacity:.7;">
            Submitted by HR — requires your approval
        </span>
    </div>

    @foreach($pendingNotifications as $notification)
        @php $emp = $notification->employee; @endphp
        <div class="pending-item">

            <div class="pending-avatar">
                {{ strtoupper(substr($emp->name ?? '?', 0, 2)) }}
            </div>

            <div class="pending-info">
                <div class="pending-name">{{ $emp->name ?? 'Unknown' }}</div>
                <div class="pending-meta">
                    {{ $emp->designation ?? 'N/A' }}
                    @if($emp?->department)
                        &nbsp;·&nbsp; {{ $emp->department->name }}
                    @endif
                    &nbsp;·&nbsp;
                    <i class="bi bi-clock" style="font-size:.7rem;"></i>
                    {{ $notification->created_at->diffForHumans() }}
                </div>
            </div>

            <div class="pending-message">
                <span>{{ $notification->message }}</span>
            </div>

            <div class="pending-actions">
                @if($emp)
                    <a href="{{ route('admin.employee.creation_view', $emp->id) }}" class="btn-view">
                        <i class="bi bi-eye"></i> View
                    </a>
                    <form method="POST" action="{{ route('admin.employee.approve', [$emp->id]) }}">
                        @csrf @method('PUT')
                        <button type="submit" class="btn-approve">
                            <i class="bi bi-check-lg"></i> Approve
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.employee.reject', [$emp->id, 'reject']) }}">
                        @csrf @method('PUT')
                        <button type="submit" class="btn-reject">
                            <i class="bi bi-x-lg"></i> Reject
                        </button>
                    </form>
                @endif
            </div>

        </div>
    @endforeach

</div>
@else
    <div class="text-center py-5" style="color:#B2ADA7;">
        <i class="bi bi-check-circle d-block mb-2" style="font-size:2.5rem; color:#A7F3D0;"></i>
        <p style="font-size:0.88rem;">No pending approvals.</p>
    </div>
@endif

@endsection