@extends('hr.layouts.hr')

@section('title', 'Leave Request Detail - Skills Hut Ltd')

@push('styles')
<style>
/* ── Base ───────────────────────────────────── */
.page-title    { font-family:'Outfit',sans-serif; font-size:1.6rem; font-weight:700; color:#1A1A1A; }
.page-subtitle { font-size:0.85rem; color:#7F7F7F; }

/* ── Breadcrumb ─────────────────────────────── */
.breadcrumb-custom     { font-size:0.78rem; color:#7F7F7F; display:flex; align-items:center; gap:6px; margin-bottom:20px; }
.breadcrumb-custom a   { color:#FF5E2B; text-decoration:none; }
.breadcrumb-custom a:hover { text-decoration:underline; }
.breadcrumb-custom i   { font-size:0.65rem; color:#B2ADA7; }

/* ── Cards ──────────────────────────────────── */
.info-card     { background:#fff; border:1px solid #E2E0DD; border-radius:14px; padding:28px; }
.section-title { font-family:'Outfit',sans-serif; font-size:0.95rem; font-weight:700; color:#1A1A1A; padding-bottom:12px; border-bottom:1px solid #F4F4F0; margin-bottom:20px; display:flex; align-items:center; gap:8px; }
.section-title i { color:#FF5E2B; }

/* ── Info Rows ──────────────────────────────── */
.info-row            { display:flex; padding:10px 0; border-bottom:1px solid #F4F4F0; }
.info-row:last-child { border-bottom:none; }
.info-label          { font-size:0.78rem; font-weight:700; color:#7F7F7F; text-transform:uppercase; letter-spacing:.5px; width:180px; flex-shrink:0; }
.info-value          { font-size:0.88rem; color:#1A1A1A; flex:1; }

/* ── Status Banner ──────────────────────────── */
.status-banner         { border-radius:10px; padding:14px 20px; display:flex; align-items:center; gap:10px; margin-bottom:24px; font-size:.88rem; font-weight:600; }
.status-banner.pending  { background:#FFFBEB; border:1px solid #FDE68A;  color:#92400E; }
.status-banner.approved { background:#ECFDF5; border:1px solid #A7F3D0;  color:#065F46; }
.status-banner.rejected { background:#FEF2F2; border:1px solid #FECACA;  color:#991B1B; }

/* ── Badges ──────────────────────────────────── */
.badge-pending   { background:#FEF3C7; color:#D97706; border-radius:20px; font-size:.75rem; font-weight:700; padding:3px 12px; }
.badge-approved  { background:#ECFDF5; color:#059669; border-radius:20px; font-size:.75rem; font-weight:700; padding:3px 12px; }
.badge-rejected  { background:#FEF2F2; color:#DC2626; border-radius:20px; font-size:.75rem; font-weight:700; padding:3px 12px; }
.badge-recommended     { background:#ECFDF5; color:#059669; border-radius:20px; font-size:.75rem; font-weight:700; padding:3px 12px; }
.badge-not-recommended { background:#FEF2F2; color:#DC2626; border-radius:20px; font-size:.75rem; font-weight:700; padding:3px 12px; }
.badge-tl-pending      { background:#FEF3C7; color:#D97706; border-radius:20px; font-size:.75rem; font-weight:700; padding:3px 12px; }

/* ── TL Note Box ─────────────────────────────── */
.tl-note-box {
    background:#F8FAFC; border:1px solid #E2E0DD;
    border-radius:10px; padding:14px 16px;
    font-size:.85rem; color:#4A4A4A; line-height:1.6;
    border-left:3px solid #FF5E2B;
}

/* ── Action Buttons ─────────────────────────── */
.btn-approve {
    background:#059669; color:#fff; border:none; border-radius:8px;
    padding:11px 28px; font-size:.9rem; font-weight:600;
    transition:all .2s; display:inline-flex; align-items:center;
    gap:6px; width:100%; justify-content:center;
}
.btn-approve:hover { background:#047857; color:#fff; }

.btn-reject {
    background:#fff; color:#DC2626; border:1px solid #DC2626;
    border-radius:8px; padding:11px 28px; font-size:.9rem; font-weight:600;
    transition:all .2s; display:inline-flex; align-items:center;
    gap:6px; width:100%; justify-content:center;
}
.btn-reject:hover { background:#FEF2F2; }

.btn-back {
    background:#fff; color:#4A4A4A; border:1px solid #E2E0DD;
    border-radius:8px; padding:11px 28px; font-size:.9rem; font-weight:600;
    transition:all .2s; text-decoration:none;
    display:inline-flex; align-items:center; gap:6px;
}
.btn-back:hover { background:#FAF9F6; color:#4A4A4A; }

/* ── Duration Badge ──────────────────────────── */
.duration-badge {
    background:#EBF3FF; color:#1D4ED8;
    border-radius:8px; font-size:.85rem; font-weight:700;
    padding:5px 14px; display:inline-block;
}

/* ── Attachment ──────────────────────────────── */
.attachment-btn {
    background:#F4F4F0; border:1px solid #E2E0DD; border-radius:8px;
    color:#4A4A4A; font-size:.82rem; font-weight:600;
    padding:8px 16px; text-decoration:none;
    display:inline-flex; align-items:center; gap:6px; transition:all .2s;
}
.attachment-btn:hover { background:#E2E0DD; color:#1A1A1A; }

/* ── Employee Photo ──────────────────────────── */
.emp-photo { width:80px; height:80px; border-radius:10px; object-fit:cover; border:2px solid #E2E0DD; }
</style>
@endpush

@section('content')

@php
    $bannerClass = match($leave->status) {
        'approved' => 'approved',
        'rejected' => 'rejected',
        default    => 'pending',
    };
    $bannerIcon = match($leave->status) {
        'approved' => 'bi-check-circle-fill',
        'rejected' => 'bi-x-circle-fill',
        default    => 'bi-hourglass-split',
    };
    $bannerText = match($leave->status) {
        'approved' => 'This leave request has been approved.',
        'rejected' => 'This leave request has been rejected.',
        default    => 'This leave request is awaiting your final decision.',
    };
@endphp

{{-- ════════════════════════════════════════════
     BREADCRUMB
═════════════════════════════════════════════ --}}
<div class="breadcrumb-custom">
    <a href="{{ route('hr_admin.dashboard') }}">Dashboard</a>
    <i class="bi bi-chevron-right"></i>
    <a href="{{ route('hr_admin.employee_leave.index') }}">Leave Requests</a>
    <i class="bi bi-chevron-right"></i>
    <span>{{ $leave->employee->name ?? 'Leave' }} — #{{ $leave->id }}</span>
</div>

{{-- ════════════════════════════════════════════
     PAGE HEADER
═════════════════════════════════════════════ --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Leave Request Detail</h1>
        <p class="page-subtitle mb-0">Review full details before making a final decision.</p>
    </div>
    <a href="{{ route('hr_admin.employee_leave.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

{{-- ════════════════════════════════════════════
     ALERTS
═════════════════════════════════════════════ --}}
@if(session('success'))
    <div class="alert border-0 rounded-3 mb-3"
         style="background:#ECFDF5; color:#059669; font-size:.88rem;">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert border-0 rounded-3 mb-3"
         style="background:#FEF2F2; color:#DC2626; font-size:.88rem;">
        <i class="bi bi-x-circle me-1"></i> {{ session('error') }}
    </div>
@endif

{{-- ════════════════════════════════════════════
     STATUS BANNER
═════════════════════════════════════════════ --}}
<div class="status-banner {{ $bannerClass }}">
    <i class="bi {{ $bannerIcon }}"></i>
    {{ $bannerText }}
</div>

{{-- ════════════════════════════════════════════
     MAIN CONTENT
═════════════════════════════════════════════ --}}
<div class="row g-4">

    {{-- ── LEFT COLUMN ── --}}
    <div class="col-12 col-lg-8">

        {{-- Employee Info --}}
        <div class="info-card mb-4">
            <div class="section-title">
                <i class="bi bi-person-fill"></i> Employee Information
            </div>
            <div class="d-flex align-items-center gap-3 mb-3">
                <img src="{{ $leave->employee->profile_picture
                             ? asset('storage/'.$leave->employee->profile_picture)
                             : asset('images/admin_avatar.png') }}"
                     class="emp-photo" alt="{{ $leave->employee->name }}">
                <div>
                    <div style="font-size:1rem; font-weight:700; color:#1A1A1A;">
                        {{ $leave->employee->name }}
                    </div>
                    <div style="font-size:.82rem; color:#FF5E2B; font-weight:600;">
                        {{ $leave->employee->designation ?? 'N/A' }}
                    </div>
                    <div style="font-size:.78rem; color:#7F7F7F;">
                        {{ $leave->employee->department->name ?? 'N/A' }}
                        &nbsp;·&nbsp; {{ $leave->employee->employee_id }}
                    </div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $leave->employee->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $leave->employee->phone ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Department</div>
                <div class="info-value">{{ $leave->employee->department->name ?? '—' }}</div>
            </div>
        </div>

        {{-- Leave Details --}}
        <div class="info-card mb-4">
            <div class="section-title">
                <i class="bi bi-calendar2-check-fill"></i> Leave Details
            </div>
            <div class="info-row">
                <div class="info-label">Leave Type</div>
                <div class="info-value">{{ $leave->leaveType->name ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">From Date</div>
                <div class="info-value">
                    {{ \Carbon\Carbon::parse($leave->from_date)->format('d M Y') }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">To Date</div>
                <div class="info-value">
                    {{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Duration</div>
                <div class="info-value">
                    <span class="duration-badge">
                        {{ $leave->duration }} {{ $leave->duration == 1 ? 'day' : 'days' }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Reason</div>
                <div class="info-value">{{ $leave->reason }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Submitted</div>
                <div class="info-value">
                    {{ $leave->created_at->format('d M Y, h:i A') }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Attachment</div>
                <div class="info-value">
                    @if($leave->attachment)
                        <a href="{{ asset('storage/'.$leave->attachment) }}"
                           target="_blank" class="attachment-btn">
                            <i class="bi bi-paperclip"></i> View Document
                        </a>
                    @else
                        <span style="color:#B2ADA7;">No attachment</span>
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">
                    @if($leave->status === 'approved')
                        <span class="badge-approved">Approved</span>
                    @elseif($leave->status === 'rejected')
                        <span class="badge-rejected">Rejected</span>
                    @else
                        <span class="badge-pending">Pending</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- TL Recommendation --}}
        <div class="info-card">
            <div class="section-title">
                <i class="bi bi-person-check-fill"></i> Team Lead Recommendation
            </div>
            <div class="info-row">
                <div class="info-label">TL Status</div>
                <div class="info-value">
                    @if($leave->tl_status === 'recommended')
                        <span class="badge-recommended">Recommended</span>
                    @elseif($leave->tl_status === 'not_recommended')
                        <span class="badge-not-recommended">Not Recommended</span>
                    @else
                        <span class="badge-tl-pending">Awaiting TL</span>
                    @endif
                </div>
            </div>
            @if($leave->tl_note)
            <div class="info-row">
                <div class="info-label">TL Note</div>
                <div class="info-value">
                    <div class="tl-note-box">
                        {{ $leave->tl_note }}
                    </div>
                </div>
            </div>
            @endif
            @if($leave->tl_reviewed_at)
            <div class="info-row">
                <div class="info-label">Reviewed At</div>
                <div class="info-value">
                    {{ \Carbon\Carbon::parse($leave->tl_reviewed_at)->format('d M Y, h:i A') }}
                </div>
            </div>
            @endif
        </div>

    </div>

    {{-- ── RIGHT COLUMN ── --}}
    <div class="col-12 col-lg-4">

        {{-- Action Card --}}
        @if($leave->status === 'pending')
        <div class="info-card mb-4"
             style="border-color:rgba(255,94,43,.2); background:#FFF8F5;">
            <div class="section-title">
                <i class="bi bi-shield-check"></i> Final Decision
            </div>
            <p style="font-size:.82rem; color:#7F7F7F; margin-bottom:20px;">
                @if($leave->tl_status === 'not_recommended')
                    ⚠️ Team Lead has <strong>not recommended</strong> this request.
                    You can still approve or reject.
                @elseif($leave->tl_status === 'recommended')
                    ✅ Team Lead has <strong>recommended</strong> this request.
                @else
                    Team Lead has not reviewed this yet.
                @endif
            </p>

            <div class="d-flex flex-column gap-2">

                {{-- Approve --}}
                <form method="POST"
                      action="{{ route('hr.leave.approve', $leave->id) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-approve">
                        <i class="bi bi-check-lg"></i> Approve Leave
                    </button>
                </form>

                {{-- Reject with note --}}
                <form method="POST"
                      action="{{ route('hr.leave.reject', $leave->id) }}"
                      id="rejectForm">
                    @csrf @method('PATCH')
                    <textarea name="hr_note" id="hrNoteField"
                              placeholder="Rejection reason (required)..."
                              style="display:none; width:100%; border:1px solid #FECACA;
                                     border-radius:8px; padding:10px; font-size:.82rem;
                                     margin-bottom:8px; resize:none;"
                              rows="3"></textarea>
                    <button type="button" class="btn-reject" onclick="toggleReject()">
                        <i class="bi bi-x-lg"></i> Reject Leave
                    </button>
                </form>

            </div>
        </div>
        @endif

        {{-- Already decided --}}
        @if(in_array($leave->status, ['approved', 'rejected']))
        <div class="info-card mb-4 text-center">
            <i class="bi bi-{{ $leave->status === 'approved' ? 'check-circle-fill' : 'x-circle-fill' }}"
               style="font-size:2rem;
                      color:{{ $leave->status === 'approved' ? '#059669' : '#DC2626' }};"></i>
            <p style="font-size:.85rem; color:#7F7F7F; margin-top:10px; margin-bottom:0;">
                @if($leave->status === 'approved')
                    This leave has been approved.
                @else
                    This leave has been rejected.
                    @if($leave->hr_note)
                        <br><strong>Reason:</strong> {{ $leave->hr_note }}
                    @endif
                @endif
            </p>
        </div>
        @endif

        {{-- Leave Summary --}}
        <div class="info-card">
            <div class="section-title">
                <i class="bi bi-bar-chart-fill"></i> Leave Summary
            </div>
            @php
                $used = \App\Models\Leave::where('employee_id', $leave->employee_id)
                    ->where('leave_type_id', $leave->leave_type_id)
                    ->where('status', 'approved')
                    ->sum('duration');
                $allowed  = $leave->leaveType->days_allowed ?? 0;
                $remaining = max(0, $allowed - $used);
            @endphp
            <div class="info-row">
                <div class="info-label">Leave Type</div>
                <div class="info-value">{{ $leave->leaveType->name ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Allowed</div>
                <div class="info-value">{{ $allowed }} days/year</div>
            </div>
            <div class="info-row">
                <div class="info-label">Used</div>
                <div class="info-value" style="color:#DC2626; font-weight:600;">
                    {{ $used }} days
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Remaining</div>
                <div class="info-value" style="color:#059669; font-weight:600;">
                    {{ $remaining }} days
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Requesting</div>
                <div class="info-value" style="color:#D97706; font-weight:600;">
                    {{ $leave->duration }} days
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
function toggleReject() {
    const note  = document.getElementById('hrNoteField');
    const form  = document.getElementById('rejectForm');
    const isVisible = note.style.display !== 'none';

    if (isVisible) {
        // Second click — submit
        if (!note.value.trim()) {
            note.style.border = '1px solid #DC2626';
            note.placeholder  = 'Please enter a rejection reason...';
            note.focus();
            return;
        }
        form.submit();
    } else {
        // First click — show textarea
        note.style.display = 'block';
        note.focus();
    }
}
</script>
@endpush

@endsection