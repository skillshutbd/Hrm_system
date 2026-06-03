@extends('admin.layouts.admin')

@section('title', 'Employee Directory - Skills Hut Ltd')

@push('styles')
<style>
/* ── Typography & Base ───────────────────────── */
.page-title    { font-family:'Outfit',sans-serif; font-size:1.8rem; font-weight:700; color:#1A1A1A; }
.page-subtitle { font-size:0.88rem; color:#7F7F7F; }

/* ── Buttons ─────────────────────────────────── */
.btn-export {
    background:#fff; border:1px solid #E2E0DD; color:#1A1A1A;
    border-radius:8px; font-weight:600; font-size:0.88rem;
    padding:10px 20px; transition:all .2s; text-decoration:none;
}
.btn-export:hover { background:#FAF9F6; color:#1A1A1A; }

.btn-add-emp {
    background:#FF5E2B; color:#fff; border:none;
    border-radius:8px; font-weight:600; font-size:0.88rem;
    padding:10px 20px; transition:all .2s; text-decoration:none;
}
.btn-add-emp:hover { background:#E04B1A; color:#fff; }

/* ── Filter Bar ──────────────────────────────── */
.filter-bar { background:#fff; border:1px solid #E2E0DD; border-radius:12px; padding:14px 20px; }
.filter-select {
    border:1px solid #E2E0DD; border-radius:8px; font-size:0.85rem;
    color:#1A1A1A; padding:7px 32px 7px 12px; background:#FAF9F6;
    appearance:none; cursor:pointer;
}
.filter-select:focus { outline:none; border-color:#FF5E2B; box-shadow:0 0 0 3px rgba(255,94,43,.1); }

.view-toggle { border:1px solid #E2E0DD; border-radius:8px; overflow:hidden; display:flex; }
.view-btn    { background:none; border:none; padding:7px 10px; color:#7F7F7F; transition:all .2s; }
.view-btn.active          { background:#FF5E2B; color:#fff; }
.view-btn:hover:not(.active) { background:#FAF9F6; }

/* ── Pending Panel ───────────────────────────── */
.pending-panel         { background:#fff; border:1px solid #FDE68A; border-radius:14px; overflow:hidden; }
.pending-panel-header  {
    background:#FFFBEB; border-bottom:1px solid #FDE68A;
    padding:14px 20px; display:flex; align-items:center; justify-content:space-between;
}
.pending-panel-title   {
    font-family:'Outfit',sans-serif; font-size:0.95rem; font-weight:700;
    color:#92400E; display:flex; align-items:center; gap:8px;
}
.pending-count-badge   {
    background:#F59E0B; color:#fff; font-size:0.7rem;
    font-weight:700; padding:2px 8px; border-radius:20px; letter-spacing:.3px;
}
.pending-item          {
    padding:14px 20px; border-bottom:1px solid #FEF3C7;
    display:flex; align-items:center; gap:14px; transition:background .15s;
}
.pending-item:last-child { border-bottom:none; }
.pending-item:hover       { background:#FFFBEB; }

.pending-avatar {
    width:38px; height:38px; border-radius:8px; background:#FEF3C7;
    color:#92400E; font-weight:700; font-size:0.85rem;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.pending-info        { flex:1; min-width:0; }
.pending-name        { font-size:0.88rem; font-weight:700; color:#1A1A1A; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.pending-meta        { font-size:0.75rem; color:#7F7F7F; margin-top:2px; }
.pending-message     { font-size:0.78rem; color:#7F7F7F; flex:1; min-width:0; }
.pending-message span { white-space:nowrap; overflow:hidden; text-overflow:ellipsis; display:block; max-width:260px; }

.pending-status      { font-size:0.75rem; font-weight:700; text-transform:uppercase; flex-shrink:0; }
.pending-actions     { display:flex; gap:6px; flex-shrink:0; }

.btn-approve {
    background:#ECFDF5; color:#059669; border:1px solid #A7F3D0;
    border-radius:6px; font-size:0.78rem; font-weight:600;
    padding:5px 12px; cursor:pointer; transition:all .15s; white-space:nowrap;
}
.btn-approve:hover { background:#059669; color:#fff; border-color:#059669; }

.btn-reject {
    background:#FEF2F2; color:#DC2626; border:1px solid #FECACA;
    border-radius:6px; font-size:0.78rem; font-weight:600;
    padding:5px 12px; cursor:pointer; transition:all .15s; white-space:nowrap;
}
.btn-reject:hover { background:#DC2626; color:#fff; border-color:#DC2626; }

/* ── Employee Cards ──────────────────────────── */
.emp-card {
    background:#fff; border:1px solid #E2E0DD; border-radius:14px;
    padding:20px; transition:all .2s; height:100%;
}
.emp-card:hover { border-color:#FF5E2B; box-shadow:0 4px 16px rgba(255,94,43,.08); transform:translateY(-2px); }

.emp-photo-wrap { position:relative; display:inline-block; margin-bottom:14px; }
.emp-photo      { width:72px; height:72px; border-radius:10px; object-fit:cover; filter:grayscale(20%); }

.status-badge   { position:absolute; top:-8px; right:-8px; font-size:0.65rem; font-weight:700; padding:3px 8px; border-radius:20px; letter-spacing:.3px; }
.status-active  { background:#ECFDF5; color:#059669; }
.status-inactive{ background:#F4F4F0; color:#7F7F7F; }
.status-pending { background:#FFFBEB; color:#D97706; }

.emp-name    { font-family:'Outfit',sans-serif; font-size:1.05rem; font-weight:700; color:#1A1A1A; margin-bottom:2px; }
.emp-role    { font-size:0.78rem; font-weight:600; color:#FF5E2B; margin-bottom:4px; }
.emp-dept    { font-size:0.78rem; color:#7F7F7F; display:flex; align-items:center; gap:4px; }
.emp-divider { border-color:#F4F4F0; margin:14px 0; }

.emp-avatar-initials {
    width:30px; height:30px; border-radius:50%; background:#F4F4F0;
    display:flex; align-items:center; justify-content:center;
    font-size:0.7rem; font-weight:700; color:#4A4A4A;
}
.link-view       { color:#FF5E2B; font-size:0.82rem; font-weight:600; text-decoration:none; display:flex; align-items:center; gap:4px; }
.link-view:hover { text-decoration:underline; color:#E04B1A; }

/* ── Add Card ────────────────────────────────── */
.emp-card-add {
    background:#fff; border:2px dashed #C0BAB4; border-radius:14px;
    padding:20px; display:flex; flex-direction:column; align-items:center;
    justify-content:center; min-height:220px; transition:all .2s; text-decoration:none;
}
.emp-card-add:hover           { border-color:#FF5E2B; background:#FFF8F5; }
.add-icon                     { width:44px; height:44px; border-radius:50%; background:#F4F4F0; display:flex; align-items:center; justify-content:center; font-size:1.3rem; color:#7F7F7F; margin-bottom:10px; transition:all .2s; }
.emp-card-add:hover .add-icon { background:#FF5E2B; color:#fff; }
.add-label                    { font-size:0.85rem; color:#7F7F7F; font-weight:500; }

/* ── Pagination ──────────────────────────────── */
.pagination-info                  { font-size:0.82rem; color:#7F7F7F; }
.pagination                       { margin-bottom:0; }
.page-link                        { color:#FF5E2B; border-color:#E2E0DD; }
.page-item.active .page-link      { background-color:#FF5E2B; border-color:#FF5E2B; }
</style>
@endpush

@section('content')

@php
    $departments = \App\Models\Department::orderBy('name')->get();

    $employees = \App\Models\Employee::with('department')
        ->when(request('department_id'), fn($q) => $q->where('department_id', request('department_id')))
        ->when(request('role'),          fn($q) => $q->where('role',          request('role')))
        ->when(request('status'),        fn($q) => $q->where('status',        request('status')))
        ->latest()
        ->paginate(8)
        ->withQueryString();

    $pendingNotifications = \App\Models\Notification::with(['employee.department'])
        ->where('type',   'employee_creation')
        ->where('status', 'pending')
        ->latest()
        ->get();
@endphp

{{-- ════════════════════════════════════════════
     PAGE HEADER
═════════════════════════════════════════════ --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Employee Directory</h1>
        <p class="page-subtitle mb-0">Manage and view all team members across the organization.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('employee.export-csv') }}" class="btn-export d-flex align-items-center gap-2">
            <i class="bi bi-download"></i> Export
        </a>
        <a href="{{ route('admin.employee.create') }}" class="btn-add-emp d-flex align-items-center gap-2">
            <i class="bi bi-person-plus"></i> Add Employee
        </a>
    </div>
</div>

{{-- ════════════════════════════════════════════
     PENDING APPROVALS PANEL
═════════════════════════════════════════════ --}}
@if($pendingNotifications->isNotEmpty())
<div class="pending-panel mb-4">

    {{-- Header --}}
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

    {{-- Rows --}}
    @foreach($pendingNotifications as $notification)
    @php $emp = $notification->employee; @endphp
    <div class="pending-item">

        {{-- Avatar --}}
        <div class="pending-avatar">
            {{ strtoupper(substr($emp->name ?? '?', 0, 2)) }}
        </div>

        {{-- Name + Meta --}}
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

        {{-- HR Message --}}
        <div class="pending-message">
            <span>{{ $notification->message }}</span>
        </div>

        {{-- Employee Status --}}
        <div class="pending-status" style="color:
            @if($emp->status === 'active')           #059669
            @elseif($emp->status === 'pending_approval') #D97706
            @else                                             #7F7F7F
            @endif;">
            {{ strtoupper(str_replace('_',' ',$emp->status ?? 'N/A')) }}
        </div>

        {{-- Approve / Reject --}}
        <div class="pending-actions">
            <form method="POST" action="#">
                @csrf @method('PATCH')
                <button type="submit" class="btn-approve">
                    <i class="bi bi-check-lg"></i> Approve
                </button>
            </form>
            <form method="POST" action="#">
                @csrf @method('PATCH')
                <button type="submit" class="btn-reject">
                    <i class="bi bi-x-lg"></i> Reject
                </button>
            </form>
        </div>

    </div>
    @endforeach

</div>
@endif

{{-- ════════════════════════════════════════════
     FILTER BAR
═════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('admin.employee.index') }}"
      class="filter-bar d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">

    <div class="d-flex align-items-center gap-3 flex-wrap">
        <span style="font-size:.82rem; font-weight:600; color:#7F7F7F;">Filter by:</span>

        {{-- Department --}}
        <div style="position:relative;">
            <select name="department_id" class="filter-select" onchange="this.form.submit()">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:.7rem;color:#7F7F7F;pointer-events:none;"></i>
        </div>

        {{-- Role --}}
        <div style="position:relative;">
            <select name="role" class="filter-select" onchange="this.form.submit()">
                <option value="">All Roles</option>
                @foreach(['admin'=>'Admin','hr'=>'HR','employee'=>'Employee','team_lead'=>'Team Lead'] as $val => $label)
                    <option value="{{ $val }}" {{ request('role') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:.7rem;color:#7F7F7F;pointer-events:none;"></i>
        </div>

        {{-- Status --}}
        <div style="position:relative;">
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Status: All</option>
                @foreach(['active'=>'Active','inactive'=>'Inactive','pending_approval'=>'Pending Approval'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:.7rem;color:#7F7F7F;pointer-events:none;"></i>
        </div>

        {{-- Clear --}}
        @if(request()->hasAny(['department_id','role','status']))
            <a href="{{ route('admin.employee.index') }}" class="btn-export d-flex align-items-center gap-2">
                <i class="bi bi-x-lg"></i> Clear
            </a>
        @endif
    </div>

    {{-- View toggle --}}
    <div class="view-toggle">
        <button type="button" class="view-btn active" id="grid-view"><i class="bi bi-grid"></i></button>
        <button type="button" class="view-btn"        id="list-view"><i class="bi bi-list-ul"></i></button>
    </div>
</form>

{{-- ════════════════════════════════════════════
     EMPLOYEE GRID
═════════════════════════════════════════════ --}}
<div class="row g-3 mb-4" id="employee-grid">

    @forelse($employees as $employee)
     @if($employee->status === 'active')
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="emp-card">

            {{-- Photo + status badge --}}
            <div class="emp-photo-wrap">
                <img src="{{ $employee->profile_picture
                             ? asset('storage/'.$employee->profile_picture)
                             : asset('images/admin_avatar.png') }}"
                     class="emp-photo" alt="{{ $employee->name }}">

                 <span class="status-badge status-active">ACTIVE</span>
            </div>

            {{-- Details --}}
            <div class="emp-name">{{ $employee->name }}</div>
            <div class="emp-role">{{ $employee->designation ?? 'N/A' }}</div>
            <div class="emp-dept">
                <i class="bi bi-building" style="font-size:.7rem;"></i>
                {{ $employee->department->name ?? 'No Department' }}
            </div>

            <hr class="emp-divider">

            <div class="d-flex justify-content-between align-items-center">
                <div class="emp-avatar-initials">
                    {{ strtoupper(substr($employee->name,0,1)) }}
                </div>
                <a href="{{ route('admin.employee.show',$employee->id) }}" class="link-view">
                    View Profile <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>
        @endif
    @empty
    <div class="col-12">
        <div class="emp-card text-center py-5">
            <i class="bi bi-people" style="font-size:2rem; color:#E2E0DD;"></i>
            <p class="mb-0 mt-2" style="color:#7F7F7F;">No employees found.</p>
        </div>
    </div>
    
    @endforelse
  

    {{-- Add new card --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('admin.employee.create') }}" class="emp-card-add">
            <div class="add-icon"><i class="bi bi-plus-lg"></i></div>
            <div class="add-label">Add New Employee</div>
        </a>
    </div>

</div>

{{-- ════════════════════════════════════════════
     PAGINATION
═════════════════════════════════════════════ --}}
<div class="d-flex justify-content-between align-items-center">
    <span class="pagination-info">
        Showing {{ $employees->firstItem() ?? 0 }}–{{ $employees->lastItem() ?? 0 }}
        of {{ $employees->total() }} employees
    </span>
    {{ $employees->links() }}
</div>

@endsection