@extends('team_lead.layouts.tl')

@section('title', 'Leave Request - Skills Hut Ltd')

@push('styles')
<style>
    .page-title    { font-family: 'Outfit', sans-serif; font-size: 1.45rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.88rem; color: #7F7F7F; }
    .breadcrumb-custom     { font-size: 0.78rem; color: #7F7F7F; display: flex; align-items: center; gap: 6px; margin-bottom: 20px; }
    .breadcrumb-custom a   { color: #FF5E2B; text-decoration: none; }
    .breadcrumb-custom i   { font-size: 0.65rem; color: #B2ADA7; }

    .info-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 20px;
        height: 100%;
    }
    .info-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #F4F4F0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .info-title i { color: #FF5E2B; }
    .info-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 11px 0;
        border-bottom: 1px solid #F4F4F0;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: 0.82rem; color: #7F7F7F; font-weight: 600; }
    .info-value { font-size: 0.88rem; color: #1A1A1A; font-weight: 600; text-align: right; }

    .emp-header {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 20px 24px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .emp-avatar-lg {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: #FFF0EB;
        color: #FF5E2B;
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .emp-name-lg   { font-family: 'Outfit', sans-serif; font-size: 1.1rem; font-weight: 700; color: #1A1A1A; }
    .emp-meta      { font-size: 0.82rem; color: #7F7F7F; }

    .status-pill {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-block;
    }
    .pill-pending         { background: #FFF7ED; color: #EA580C; }
    .pill-recommended     { background: #ECFDF5; color: #059669; }
    .pill-not_recommended { background: #FEE2E2; color: #DC2626; }
    .pill-approved        { background: #ECFDF5; color: #059669; }
    .pill-rejected        { background: #FEE2E2; color: #DC2626; }

    .reason-box {
        background: #FAF9F6;
        border: 1px solid #F4F4F0;
        border-radius: 10px;
        padding: 14px 16px;
        font-size: 0.88rem;
        color: #1A1A1A;
        line-height: 1.6;
    }

    .action-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 20px;
    }
    .btn-recommend {
        background: #FF5E2B; color: #fff; border: none; border-radius: 8px;
        font-size: 0.88rem; font-weight: 700; padding: 11px 24px;
        cursor: pointer; transition: background 0.2s; width: 100%;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-recommend:hover { background: #E04B1A; }
    .btn-decline {
        background: #FEE2E2; color: #DC2626; border: none; border-radius: 8px;
        font-size: 0.88rem; font-weight: 700; padding: 11px 24px;
        cursor: pointer; transition: background 0.2s; width: 100%;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        margin-top: 10px;
    }
    .btn-decline:hover { background: #FECACA; }
    .btn-back {
        background: #fff; color: #1A1A1A; border: 1px solid #E2E0DD;
        border-radius: 8px; font-size: 0.88rem; font-weight: 600;
        padding: 10px 20px; text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-back:hover { background: #FAF9F6; color: #1A1A1A; }

    .already-acted {
        background: #F4F4F0;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
        font-size: 0.85rem;
        color: #7F7F7F;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-custom">
    <a href="{{ route('team_lead.dashboard') }}">Dashboard</a>
    <i class="bi bi-chevron-right"></i>
    <span>Leave Request #{{ $leave->id }}</span>
</div>

{{-- Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Leave Request Details</h1>
        <p class="page-subtitle mb-0">Review the request and take action.</p>
    </div>
    <a href="{{ route('team_lead.dashboard') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

{{-- Employee Header --}}
<div class="emp-header">
    @if($leave->employee->profile_picture)
        <img src="{{ asset('storage/' . $leave->employee->profile_picture) }}"
             style="width:56px;height:56px;border-radius:12px;object-fit:cover;border:1px solid #E2E0DD;">
    @else
        <div class="emp-avatar-lg">
            {{ strtoupper(substr($leave->employee->name, 0, 2)) }}
        </div>
    @endif
    <div class="flex-grow-1">
        <div class="emp-name-lg">{{ $leave->employee->name }}</div>
        <div class="emp-meta">
            {{ $leave->employee->designation ?? 'N/A' }}
            &nbsp;•&nbsp;
            {{ $leave->employee->department->name ?? 'N/A' }}
            &nbsp;•&nbsp;
            {{ $leave->employee->employee_id }}
        </div>
    </div>
    <div>
        @php
            $tlClass = match($leave->tl_status) {
                'recommended'     => 'pill-recommended',
                'not_recommended' => 'pill-not_recommended',
                default           => 'pill-pending',
            };
        @endphp
        <span class="status-pill {{ $tlClass }}">
            {{ ucfirst(str_replace('_', ' ', $leave->tl_status)) }}
        </span>
    </div>
</div>

<div class="row g-3">

    {{-- Leave Details --}}
    <div class="col-lg-8">
        <div class="row g-3">

            {{-- Leave Info --}}
            <div class="col-12">
                <div class="info-card">
                    <div class="info-title">
                        <i class="bi bi-calendar2-week-fill"></i> Leave Information
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Leave Type</div>
                                <div class="info-value">{{ $leave->leaveType->name ?? 'N/A' }}</div>
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
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Duration</div>
                                <div class="info-value">{{ $leave->duration }} Working Days</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Applied On</div>
                                <div class="info-value">
                                    {{ $leave->created_at->format('d M Y, h:i A') }}
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">HR Status</div>
                                <div class="info-value">
                                    @php
                                        $hrClass = match($leave->status) {
                                            'approved' => 'pill-approved',
                                            'rejected' => 'pill-rejected',
                                            default    => 'pill-pending',
                                        };
                                    @endphp
                                    <span class="status-pill {{ $hrClass }}">
                                        {{ ucfirst($leave->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reason --}}
            <div class="col-12">
                <div class="info-card">
                    <div class="info-title">
                        <i class="bi bi-chat-text-fill"></i> Reason
                    </div>
                    <div class="reason-box">{{ $leave->reason }}</div>
                </div>
            </div>

            {{-- Attachment --}}
            @if($leave->attachment)
            <div class="col-12">
                <div class="info-card">
                    <div class="info-title">
                        <i class="bi bi-paperclip"></i> Attachment
                    </div>
                    <a href="{{ asset('storage/' . $leave->attachment) }}"
                       target="_blank"
                       style="font-size:0.88rem;color:#FF5E2B;font-weight:600;text-decoration:none;">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i>
                        View Attachment
                    </a>
                </div>
            </div>
            @endif

            {{-- TL Note (if already acted) --}}
            @if($leave->tl_note)
            <div class="col-12">
                <div class="info-card">
                    <div class="info-title">
                        <i class="bi bi-pencil-square"></i> Your Note
                    </div>
                    <div class="reason-box">{{ $leave->tl_note }}</div>
                </div>
            </div>
            @endif

            {{-- HR Note --}}
            @if($leave->hr_note)
            <div class="col-12">
                <div class="info-card">
                    <div class="info-title">
                        <i class="bi bi-person-badge-fill"></i> HR Note
                    </div>
                    <div class="reason-box">{{ $leave->hr_note }}</div>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Action Panel --}}
    <div class="col-lg-4">
        <div class="action-card">
            <div class="info-title">
                <i class="bi bi-check2-circle"></i> Your Action
            </div>

            @if($leave->tl_status === 'pending')
                {{-- Recommend --}}
                <form method="POST" action="{{ route('tl.leave.recommend', $leave->id) }}"
                      onsubmit="return checkNote(this)">
                    @csrf
                    @method('PATCH')
                    <label style="font-size:0.82rem;font-weight:600;color:#4A4A4A;margin-bottom:7px;display:block;">
                        Note <span class="text-danger">*</span>
                    </label>
                    <textarea name="tl_note" id="tlNote" rows="4" required
                              style="width:100%;border:1px solid #E2E0DD;border-radius:8px;padding:10px 14px;font-size:0.88rem;resize:vertical;margin-bottom:12px;"
                              placeholder="Add your note here..."></textarea>
                    <button type="submit" class="btn-recommend">
                        <i class="bi bi-hand-thumbs-up"></i> Recommend
                    </button>
                </form>

                {{-- Decline --}}
                <form method="POST" action="{{ route('tl.leave.not-recommend', $leave->id) }}"
                      onsubmit="return checkNote(this)">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="tl_note" id="tlNoteDecline">
                    <button type="submit" class="btn-decline"
                            onclick="document.getElementById('tlNoteDecline').value = document.getElementById('tlNote').value">
                        <i class="bi bi-hand-thumbs-down"></i> Decline
                    </button>
                </form>

            @else
                <div class="already-acted">
                    <i class="bi bi-{{ $leave->tl_status === 'recommended' ? 'check-circle-fill' : 'x-circle-fill' }}"
                       style="font-size:1.5rem;display:block;margin-bottom:8px;color:{{ $leave->tl_status === 'recommended' ? '#059669' : '#DC2626' }};"></i>
                    You have already
                    <strong>{{ str_replace('_', ' ', $leave->tl_status) }}</strong>
                    this request.
                </div>
            @endif
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
function checkNote(form) {
    const note = document.getElementById('tlNote').value.trim();
    if (!note) {
        alert('Please add a note before submitting.');
        return false;
    }
    return true;
}
</script>
@endpush