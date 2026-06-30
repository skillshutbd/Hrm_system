@extends('admin.layouts.admin')

@section('title', 'Leave Types - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }
    .breadcrumb-custom { font-size: 0.78rem; color: #7F7F7F; display: flex; align-items: center; gap: 6px; margin-bottom: 20px; }
    .breadcrumb-custom a { color: #FF5E2B; text-decoration: none; }
    .breadcrumb-custom i { font-size: 0.65rem; color: #B2ADA7; }

    .btn-create { background: #FF5E2B; color: #fff; border: none; border-radius: 8px; padding: 10px 20px; font-size: 0.88rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s; }
    .btn-create:hover { background: #E04B1A; color: #fff; }

    .table-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; overflow: hidden; }
    .leave-table { width: 100%; border-collapse: collapse; }
    .leave-table thead th { font-size: 0.75rem; font-weight: 700; color: #7F7F7F; letter-spacing: 0.4px; text-transform: uppercase; padding: 14px 20px; border-bottom: 1px solid #E2E0DD; text-align: left; background: #FAFAFA; }
    .leave-table tbody tr { border-bottom: 1px solid #F4F4F0; transition: background 0.15s; }
    .leave-table tbody tr:last-child { border-bottom: none; }
    .leave-table tbody tr:hover { background: #FAF9F6; }
    .leave-table tbody td { padding: 16px 20px; font-size: 0.88rem; color: #1A1A1A; vertical-align: middle; }

    .badge-active   { background: #ECFDF5; color: #059669; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; border: 1px solid #D1FAE5; }
    .badge-inactive { background: #F4F4F0; color: #7F7F7F; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; }

    .days-badge { background: #EBF3FF; color: #2563EB; font-size: 0.78rem; font-weight: 700; padding: 4px 10px; border-radius: 8px; }

    .btn-edit { background: #fff; border: 1px solid #E2E0DD; border-radius: 7px; color: #4A4A4A; font-size: 0.8rem; font-weight: 600; padding: 6px 14px; text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px; }
    .btn-edit:hover { background: #FAF9F6; color: #1A1A1A; border-color: #C4C4C4; }
    .btn-delete { background: #FEE2E2; border: none; border-radius: 7px; color: #DC2626; font-size: 0.8rem; font-weight: 600; padding: 6px 14px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px; }
    .btn-delete:hover { background: #FECACA; }

    .empty-state { text-align: center; padding: 60px 20px; color: #7F7F7F; }
    .empty-state i { font-size: 2.5rem; color: #E2E0DD; margin-bottom: 12px; display: block; }

    /* ============================================
       PAGE-SPECIFIC RESPONSIVE (Unique Classes)
       ============================================ */

    /* ===== Tablet (≤991px) ===== */
    @media (max-width: 991.98px) {
        .page-title {
            font-size: 1.4rem;
        }

        .leave-table thead th {
            padding: 12px 16px;
            font-size: 0.72rem;
        }

        .leave-table tbody td {
            padding: 14px 16px;
            font-size: 0.85rem;
        }

        .btn-edit,
        .btn-delete {
            font-size: 0.78rem;
            padding: 5px 12px;
        }
    }

    /* ===== Mobile (≤768px) ===== */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.2rem;
        }

        .page-subtitle {
            font-size: 0.78rem;
        }

        .breadcrumb-custom {
            font-size: 0.72rem;
            margin-bottom: 16px;
        }

        /* Page header - stack vertically (unique class) */
        .leave-types-header {
            flex-direction: column !important;
            gap: 12px !important;
            align-items: stretch !important;
        }

        .leave-types-header .btn-create {
            width: 100%;
            justify-content: center;
            font-size: 0.85rem;
            padding: 10px 16px;
        }

        /* Table - horizontal scroll (unique class) */
        .leave-types-table-card {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .leave-types-table-card .leave-table {
            min-width: 780px;
        }

        .leave-types-table-card .leave-table thead th {
            padding: 10px 12px;
            font-size: 0.68rem;
            white-space: nowrap;
        }

        .leave-types-table-card .leave-table tbody td {
            padding: 12px 12px;
            font-size: 0.8rem;
        }

        .badge-active,
        .badge-inactive {
            font-size: 0.68rem;
            padding: 3px 8px;
        }

        .days-badge {
            font-size: 0.72rem;
            padding: 3px 8px;
        }

        .btn-edit,
        .btn-delete {
            font-size: 0.72rem;
            padding: 5px 10px;
            white-space: nowrap;
        }

        /* Action buttons wrap on mobile */
        .leave-types-table-card .d-flex.gap-2 {
            flex-wrap: wrap;
            gap: 6px !important;
        }

        /* Empty state */
        .empty-state {
            padding: 40px 16px;
        }

        .empty-state i {
            font-size: 2rem;
        }
    }

    /* ===== Small Mobile (≤576px) ===== */
    @media (max-width: 576px) {
        .page-title {
            font-size: 1.1rem;
        }

        .page-subtitle {
            font-size: 0.75rem;
        }

        .breadcrumb-custom {
            font-size: 0.7rem;
            margin-bottom: 14px;
        }

        .leave-types-table-card .leave-table {
            min-width: 720px;
        }

        .leave-types-table-card .leave-table thead th {
            padding: 8px 10px;
            font-size: 0.65rem;
        }

        .leave-types-table-card .leave-table tbody td {
            padding: 10px 10px;
            font-size: 0.78rem;
        }

        .btn-create {
            font-size: 0.82rem;
            padding: 9px 14px;
        }

        .btn-edit,
        .btn-delete {
            font-size: 0.7rem;
            padding: 4px 8px;
        }

        .empty-state {
            padding: 32px 12px;
        }

        .empty-state i {
            font-size: 1.8rem;
        }
    }

    /* ===== Extra Small Mobile (≤400px) ===== */
    @media (max-width: 400px) {
        .page-title {
            font-size: 1rem;
        }

        .breadcrumb-custom {
            font-size: 0.68rem;
        }

        .leave-types-table-card .leave-table {
            min-width: 680px;
        }

        .btn-create {
            font-size: 0.78rem;
            padding: 8px 12px;
        }

        .btn-edit,
        .btn-delete {
            font-size: 0.68rem;
            padding: 4px 7px;
        }

        .empty-state {
            padding: 28px 10px;
        }
    }
</style>
@endpush

@section('content')

<div class="breadcrumb-custom">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <i class="bi bi-chevron-right"></i>
    <span>Leave Types</span>
</div>

{{-- Page Header with unique class --}}
<div class="leave-types-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title mb-1">Leave Types</h1>
        <p class="page-subtitle mb-0">Manage all leave categories available to employees.</p>
    </div>
    <a href="{{ route('admin.leave.create') }}" class="btn-create">
        <i class="bi bi-plus-lg"></i> Create Leave Type
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-3 mb-4" style="background:#ECFDF5;color:#059669;font-size:0.88rem;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

@php
use App\Models\LeaveType;
$leaveTypes = LeaveType::all();
@endphp

{{-- Table with unique class --}}
<div class="leave-types-table-card table-card">
    <table class="leave-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Leave Type</th>
                <th>Description</th>
                <th>Days / Year</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaveTypes as $type)
            <tr>
                <td style="color:#7F7F7F;font-weight:600;">{{ $loop->iteration }}</td>
                <td style="font-weight:700;">{{ $type->name }}</td>
                <td style="color:#7F7F7F;max-width:260px;">{{ $type->description ?? '—' }}</td>
                <td><span class="days-badge">{{ $type->days_allowed }} Days</span></td>
                <td>
                    @if($type->is_active)
                        <span class="badge-active">Active</span>
                    @else
                        <span class="badge-inactive">Inactive</span>
                    @endif
                </td>
                <td style="color:#7F7F7F;">{{ $type->created_at->format('d M Y') }}</td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.leave.edit', $type->id) }}" class="btn-edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a>

                        <form method="POST" action="{{ route('admin.leave.destroy', $type->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete"
                                    onclick="return confirm('Are you sure?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="bi bi-calendar-x"></i>
                        <div style="font-weight:600;color:#1A1A1A;margin-bottom:6px;">No leave types found</div>
                        <div style="font-size:0.85rem;">Create your first leave type to get started.</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection