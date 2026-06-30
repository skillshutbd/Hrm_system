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
.view-btn    { background:none; border:none; padding:7px 10px; color:#7F7F7F; transition:all .2s; cursor:pointer; }
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

/* ── Employee Cards (Grid View) ──────────────── */
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

/* ── LIST VIEW TABLE ─────────────────────────── */
.list-view-table-wrap {
    background:#fff; border:1px solid #E2E0DD; border-radius:12px;
    overflow:hidden; margin-bottom:16px;
}

.list-view-table {
    width:100%; border-collapse:collapse; margin:0;
}

.list-view-table thead th {
    font-size:0.72rem; font-weight:700; text-transform:uppercase;
    letter-spacing:0.8px; color:#7F7F7F; padding:14px 20px;
    border-bottom:1px solid #E2E0DD; background:#FAFAFA; text-align:left;
}

.list-view-table tbody tr {
    border-bottom:1px solid #F4F4F0; transition:background .15s;
}

.list-view-table tbody tr:last-child { border-bottom:none; }
.list-view-table tbody tr:hover { background:#FAF9F6; }

.list-view-table tbody td {
    padding:16px 20px; font-size:0.88rem; color:#1A1A1A; vertical-align:middle;
}

.list-emp-info {
    display:flex; align-items:center; gap:12px;
}

.list-emp-avatar {
    width:40px; height:40px; border-radius:10px; object-fit:cover;
    border:1px solid #E2E0DD; flex-shrink:0;
}

.list-emp-avatar-placeholder {
    width:40px; height:40px; border-radius:10px; background:#FFF0EB;
    color:#FF5E2B; font-family:'Outfit',sans-serif; font-weight:700;
    font-size:0.82rem; display:flex; align-items:center; justify-content:center;
    flex-shrink:0;
}

.list-emp-name {
    font-weight:700; font-size:0.9rem; color:#1A1A1A;
}

.list-emp-id {
    font-size:0.72rem; color:#B2ADA7; font-family:monospace; margin-top:2px;
}

.list-emp-designation {
    color:#4A4A4A; font-size:0.85rem;
}

.list-emp-dept {
    color:#7F7F7F; font-size:0.85rem;
}

.list-status-badge {
    font-size:0.72rem; font-weight:700; padding:4px 10px;
    border-radius:20px; display:inline-block;
}

.list-status-active {
    background:#ECFDF5; color:#059669;
}

.list-status-inactive {
    background:#F4F4F0; color:#7F7F7F;
}

.list-status-pending {
    background:#FFFBEB; color:#D97706;
}

.btn-view-profile {
    background:#EFF6FF; color:#2563EB; border:1px solid #BFDBFE;
    border-radius:6px; font-size:0.78rem; font-weight:600;
    padding:6px 14px; text-decoration:none; display:inline-flex;
    align-items:center; gap:4px; transition:all .15s; white-space:nowrap;
}

.btn-view-profile:hover {
    background:#2563EB; color:#fff; border-color:#2563EB;
}

.list-view-empty {
    text-align:center; padding:60px 20px; color:#7F7F7F;
}

.list-view-empty i {
    font-size:2.5rem; color:#E2E0DD; margin-bottom:12px; display:block;
}

/* ── Pagination ──────────────────────────────── */
.pagination-info                  { font-size:0.82rem; color:#7F7F7F; }
.pagination                       { margin-bottom:0; }
.page-link                        { color:#FF5E2B; border-color:#E2E0DD; }
.page-item.active .page-link      { background-color:#FF5E2B; border-color:#FF5E2B; }

/* ── Responsive ──────────────────────────────── */
@media (max-width: 768px) {
    .list-view-table-wrap {
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }
    
    .list-view-table {
        min-width:700px;
    }
}
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
        <a href="{{ route('admin.leave.export-csv') }}" class="btn-export d-flex align-items-center gap-2">
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
            <form method="POST" action="{{ route('admin.employee.approve', $emp->id) }}">
                @csrf @method('put')
                <button type="submit" class="btn-approve">
                    <i class="bi bi-check-lg"></i> Approve
                </button>
            </form>
            <form method="POST" action="{{ route('admin.employee.reject', $emp->id) }}">
                @csrf @method('put')
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
     GRID VIEW
═════════════════════════════════════════════ --}}
<div id="grid-view-container">
    <div class="row g-3 mb-4">

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
</div>

{{-- ════════════════════════════════════════════
     LIST VIEW (TABLE)
═════════════════════════════════════════════ --}}
<div id="list-view-container" style="display:none;">
    <div class="list-view-table-wrap mb-4">
        <table class="list-view-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Employee ID</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                @if($employee->status === 'active')
                <tr>
                    <td>
                        <div class="list-emp-info">
                            @if($employee->profile_picture)
                                <img src="{{ asset('storage/'.$employee->profile_picture) }}" 
                                     class="list-emp-avatar" alt="{{ $employee->name }}">
                            @else
                                <div class="list-emp-avatar-placeholder">
                                    {{ strtoupper(substr($employee->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <div class="list-emp-name">{{ $employee->name }}</div>
                                <div class="list-emp-id">{{ $employee->employee_id ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="list-emp-designation">{{ $employee->designation ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <span class="list-emp-dept">{{ $employee->department->name ?? 'No Department' }}</span>
                    </td>
                    <td>
                        <span style="font-family:monospace; color:#4A4A4A;">{{ $employee->employee_id ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <span class="list-status-badge list-status-active">ACTIVE</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.employee.show', $employee->id) }}" class="btn-view-profile">
                            <i class="bi bi-eye"></i> View Profile
                        </a>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="6">
                        <div class="list-view-empty">
                            <i class="bi bi-people"></i>
                            <div style="font-weight:600; color:#1A1A1A; margin-bottom:6px;">No employees found</div>
                            <div style="font-size:0.85rem;">Add your first employee to get started.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const gridViewBtn = document.getElementById('grid-view');
    const listViewBtn = document.getElementById('list-view');
    const gridViewContainer = document.getElementById('grid-view-container');
    const listViewContainer = document.getElementById('list-view-container');

    // Load saved view from localStorage
    const savedView = localStorage.getItem('employeeView');
    if (savedView === 'list') {
        showListView();
    } else {
        showGridView();
    }

    // Grid view click
    gridViewBtn.addEventListener('click', function() {
        showGridView();
        localStorage.setItem('employeeView', 'grid');
    });

    // List view click
    listViewBtn.addEventListener('click', function() {
        showListView();
        localStorage.setItem('employeeView', 'list');
    });

    function showGridView() {
        gridViewContainer.style.display = 'block';
        listViewContainer.style.display = 'none';
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
    }

    function showListView() {
        gridViewContainer.style.display = 'none';
        listViewContainer.style.display = 'block';
        listViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
    }
});
</script>
@endpush