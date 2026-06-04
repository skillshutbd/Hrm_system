@extends('admin.layouts.admin')

@section('title', 'Employee Request - Skills Hut Ltd')

@push('styles')
<style>
/* ── Base ───────────────────────────────────── */
.page-title      { font-family:'Outfit',sans-serif; font-size:1.6rem; font-weight:700; color:#1A1A1A; }
.page-subtitle   { font-size:0.85rem; color:#7F7F7F; }

/* ── Breadcrumb ─────────────────────────────── */
.breadcrumb-custom       { font-size:0.78rem; color:#7F7F7F; display:flex; align-items:center; gap:6px; margin-bottom:20px; }
.breadcrumb-custom a     { color:#FF5E2B; text-decoration:none; }
.breadcrumb-custom a:hover { text-decoration:underline; }
.breadcrumb-custom i     { font-size:0.65rem; color:#B2ADA7; }

/* ── Cards ──────────────────────────────────── */
.info-card      { background:#fff; border:1px solid #E2E0DD; border-radius:14px; padding:28px; }
.section-title  { font-family:'Outfit',sans-serif; font-size:0.95rem; font-weight:700; color:#1A1A1A; padding-bottom:12px; border-bottom:1px solid #F4F4F0; margin-bottom:20px; display:flex; align-items:center; gap:8px; }
.section-title i { color:#FF5E2B; }

/* ── Info Rows ──────────────────────────────── */
.info-row             { display:flex; padding:10px 0; border-bottom:1px solid #F4F4F0; }
.info-row:last-child  { border-bottom:none; }
.info-label           { font-size:0.78rem; font-weight:700; color:#7F7F7F; text-transform:uppercase; letter-spacing:0.5px; width:180px; flex-shrink:0; }
.info-value           { font-size:0.88rem; color:#1A1A1A; flex:1; }

/* ── Badges ─────────────────────────────────── */
.badge-active   { background:#ECFDF5; color:#059669; border-radius:20px; font-size:0.75rem; font-weight:700; padding:3px 12px; }
.badge-inactive { background:#F4F4F0; color:#7F7F7F; border-radius:20px; font-size:0.75rem; font-weight:700; padding:3px 12px; }
.badge-pending  { background:#FEF3C7; color:#D97706; border-radius:20px; font-size:0.75rem; font-weight:700; padding:3px 12px; }
.badge-rejected { background:#FEF2F2; color:#DC2626; border-radius:20px; font-size:0.75rem; font-weight:700; padding:3px 12px; }

/* ── Status Banner ──────────────────────────── */
.status-banner         { border-radius:10px; padding:14px 20px; display:flex; align-items:center; gap:10px; margin-bottom:24px; font-size:0.88rem; font-weight:600; }
.status-banner.pending  { background:#FFFBEB; border:1px solid #FDE68A;  color:#92400E; }
.status-banner.active   { background:#ECFDF5; border:1px solid #A7F3D0;  color:#065F46; }
.status-banner.rejected { background:#FEF2F2; border:1px solid #FECACA;  color:#991B1B; }
.status-banner.inactive { background:#F4F4F0; border:1px solid #E2E0DD;  color:#4A4A4A; }

/* ── Profile Photo ──────────────────────────── */
.emp-photo { width:100px; height:100px; border-radius:12px; object-fit:cover; border:2px solid #E2E0DD; }

/* ── Action Buttons ─────────────────────────── */
.btn-approve {
    background:#059669; color:#fff; border:none; border-radius:8px;
    padding:11px 28px; font-size:0.9rem; font-weight:600;
    transition:all .2s; display:inline-flex; align-items:center;
    gap:6px; width:100%; justify-content:center;
}
.btn-approve:hover { background:#047857; color:#fff; }

.btn-reject {
    background:#fff; color:#DC2626; border:1px solid #DC2626;
    border-radius:8px; padding:11px 28px; font-size:0.9rem; font-weight:600;
    transition:all .2s; display:inline-flex; align-items:center;
    gap:6px; width:100%; justify-content:center;
}
.btn-reject:hover { background:#FEF2F2; }

.btn-back {
    background:#fff; color:#4A4A4A; border:1px solid #E2E0DD;
    border-radius:8px; padding:11px 28px; font-size:0.9rem; font-weight:600;
    transition:all .2s; text-decoration:none;
    display:inline-flex; align-items:center; gap:6px;
}
.btn-back:hover { background:#FAF9F6; color:#4A4A4A; }
</style>
@endpush

@section('content')

@php


    $bannerClass = match($employee->status) {
        'active'           => 'active',
        'pending_approval' => 'pending',
        'rejected'         => 'rejected',
        default            => 'inactive',
    };
    $bannerIcon = match($employee->status) {
        'active'           => 'bi-check-circle-fill',
        'pending_approval' => 'bi-hourglass-split',
        'rejected'         => 'bi-x-circle-fill',
        default            => 'bi-dash-circle-fill',
    };
    $bannerText = match($employee->status) {
        'active'           => 'This employee has been approved and is active.',
        'pending_approval' => 'This employee is awaiting your approval.',
        'rejected'         => 'This employee request has been rejected.',
        default            => 'This employee is currently inactive.',
    };
@endphp

{{-- ════════════════════════════════════════════
     BREADCRUMB
═════════════════════════════════════════════ --}}
<div class="breadcrumb-custom">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <i class="bi bi-chevron-right"></i>
    <a href="{{ route('admin.employee.index') }}">Employees</a>
    <i class="bi bi-chevron-right"></i>
    <span>{{ $employee->name }}</span>
</div>

{{-- ════════════════════════════════════════════
     PAGE HEADER
═════════════════════════════════════════════ --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Employee Request</h1>
        <p class="page-subtitle mb-0">Review employee details before approving or rejecting.</p>
    </div>
   <a href="{{ route('admin.employee.creation_index', $employee->id) }}" class="btn-back">
    <i class="bi bi-arrow-left"></i> Back
</a>
</div>

{{-- ════════════════════════════════════════════ 
     ALERTS
═════════════════════════════════════════════ --}}
@if(session('success'))
    <div class="alert alert-success py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
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

        {{-- Personal Information --}}
        <div class="info-card mb-4">
            <div class="section-title">
                <i class="bi bi-person-fill"></i> Personal Information
            </div>
            <div class="info-row">
                <div class="info-label">Full Name</div>
                <div class="info-value">{{ $employee->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $employee->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $employee->phone ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NID</div>
                <div class="info-value">{{ $employee->nid ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date of Birth</div>
                <div class="info-value">
                    {{ $employee->date_of_birth
                        ? \Carbon\Carbon::parse($employee->date_of_birth)->format('d M Y')
                        : '—' }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Gender</div>
                <div class="info-value">{{ ucfirst($employee->gender ?? '—') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Blood Group</div>
                <div class="info-value">{{ $employee->blood_group ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Address</div>
                <div class="info-value">{{ $employee->address ?? '—' }}</div>
            </div>
        </div>

        {{-- Job Information --}}
        <div class="info-card mb-4">
            <div class="section-title">
                <i class="bi bi-briefcase-fill"></i> Job Information
            </div>
            <div class="info-row">
                <div class="info-label">Employee ID</div>
                <div class="info-value">{{ $employee->employee_id ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Department</div>
                <div class="info-value">{{ $employee->department->name ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Designation</div>
                <div class="info-value">{{ $employee->designation ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Role</div>
                <div class="info-value">
                    {{ ucfirst(str_replace('_', ' ', $employee->role ?? '—')) }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Joining Date</div>
                <div class="info-value">
                    {{ $employee->hire_date
                        ? \Carbon\Carbon::parse($employee->hire_date)->format('d M Y')
                        : '—' }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Employment Status</div>
                <div class="info-value">
                    @if($employee->status === 'active')
                        <span class="badge-active">Active</span>
                    @elseif($employee->status === 'pending_approval')
                        <span class="badge-pending">Pending Approval</span>
                    @elseif($employee->status === 'rejected')
                        <span class="badge-rejected">Rejected</span>
                    @else
                        <span class="badge-inactive">Inactive</span>
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Submitted By</div>
                <div class="info-value">
                    {{ $employee->createdByHr->name ?? 'Super Admin' }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Submitted At</div>
                <div class="info-value">
                    {{ $employee->created_at->format('d M Y, h:i A') }}
                </div>
            </div>
        </div>

        {{-- Emergency Contact --}}
        <div class="info-card">
            <div class="section-title">
                <i class="bi bi-telephone-fill"></i> Emergency Contact
            </div>
            <div class="info-row">
                <div class="info-label">Name</div>
                <div class="info-value">{{ $employee->emergency_contact_name ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $employee->emergency_contact_phone ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Relationship</div>
                <div class="info-value">
                    {{ ucfirst($employee->emergency_contact_relationship ?? '—') }}
                </div>
            </div>
        </div>

    </div>

    {{-- ── RIGHT COLUMN ── --}}
    <div class="col-12 col-lg-4">

        {{-- Profile Photo Card --}}
        <div class="info-card mb-4 text-center">
            <div class="section-title justify-content-center">
                <i class="bi bi-image-fill"></i> Profile Photo
            </div>
            <img src="{{ $employee->profile_picture
                         ? asset('storage/'.$employee->profile_picture)
                         : asset('images/admin_avatar.png') }}"
                 class="emp-photo mb-3" alt="{{ $employee->name }}">
            <div style="font-size:0.9rem; font-weight:700; color:#1A1A1A;">
                {{ $employee->name }}
            </div>
            <div style="font-size:0.78rem; color:#FF5E2B; margin-top:2px;">
                {{ $employee->designation ?? '' }}
            </div>
            <div style="font-size:0.75rem; color:#7F7F7F; margin-top:4px;">
                {{ $employee->department->name ?? '' }}
            </div>
        </div>

        {{-- Action Card — only for pending --}}
        @if($employee->status === 'pending_approval')
        <div class="info-card" style="border-color:rgba(255,94,43,0.2); background:#FFF8F5;">
            <div class="section-title">
                <i class="bi bi-shield-check"></i> Take Action
            </div>
            <p style="font-size:0.82rem; color:#7F7F7F; margin-bottom:20px;">
                Approving will activate this employee account.
                Rejecting will mark the request as rejected.
            </p>
            <div class="d-flex flex-column gap-2">

                {{-- Approve --}}
                <form method="POST"
                      action="{{ route('admin.employee.approve', $employee->id) }}">
                    @csrf @method('PUT')
                    <button type="submit" class="btn-approve">
                        <i class="bi bi-check-lg"></i> Approve Employee
                    </button>
                </form>

                {{-- Reject --}}
                <form method="POST"
                      action="{{ route('admin.employee.reject', $employee->id) }}">
                    @csrf @method('PUT')
                    <button type="submit" class="btn-reject">
                        <i class="bi bi-x-lg"></i> Reject Employee
                    </button>
                </form>

            </div>
        </div>
        @endif

        {{-- Already actioned --}}
        @if(in_array($employee->status, ['active', 'rejected', 'inactive']))
        <div class="info-card text-center" style="border-color:#E2E0DD;">
            <i class="bi bi-{{ $employee->status === 'active' ? 'check-circle-fill' : 'x-circle-fill' }}"
               style="font-size:2rem; color:{{ $employee->status === 'active' ? '#059669' : '#DC2626' }};"></i>
            <p style="font-size:0.85rem; color:#7F7F7F; margin-top:10px; margin-bottom:0;">
                @if($employee->status === 'active')
                    This employee has already been approved.
                @else
                    This employee request has been rejected.
                @endif
            </p>
        </div>
        @endif

    </div>
</div>

@endsection