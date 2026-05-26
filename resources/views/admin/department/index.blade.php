@extends('admin.layouts.admin')

@section('title', 'Department List - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #1A1A1A; letter-spacing: -0.5px; }
    .page-subtitle { font-size: 0.9rem; color: #7F7F7F; }
    .btn-add { background: #FF5E2B; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.88rem; padding: 10px 20px; text-decoration: none; }
    .btn-add:hover { background: #E04B1A; color: #fff; }
    .kpi-card { border: 1px solid #E2E0DD; border-radius: 12px; background: #fff; padding: 20px 24px; }
    .kpi-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; margin-bottom: 6px; }
    .kpi-value { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 700; color: #1A1A1A; }
    .insight-card { border-radius: 12px; background: #FF5E2B; padding: 20px 24px; position: relative; overflow: hidden; }
    .insight-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: rgba(255,255,255,0.75); margin-bottom: 8px; }
    .insight-text { font-family: 'Outfit', sans-serif; font-size: 1.1rem; font-weight: 700; color: #fff; line-height: 1.4; }
    .dept-table-wrap { border: 1px solid #E2E0DD; border-radius: 12px; overflow: hidden; background: #fff; }
    .dept-table { width: 100%; margin: 0; }
    .dept-table thead th { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; padding: 14px 20px; border-bottom: 1px solid #E2E0DD; background: #fff; }
    .dept-table tbody tr { border-bottom: 1px solid #F4F4F0; transition: background 0.15s; }
    .dept-table tbody tr:last-child { border-bottom: none; }
    .dept-table tbody tr:hover { background: #FAF9F6; }
    .dept-table td { padding: 18px 20px; vertical-align: middle; font-size: 0.88rem; color: #1A1A1A; }
    .dept-name { font-weight: 700; font-size: 0.92rem; display: flex; align-items: center; gap: 10px; }
    .dept-accent { width: 3px; height: 22px; background: #FF5E2B; border-radius: 2px; }
    .dept-accent.inactive { background: #E2E0DD; }
    .emp-badge { border: 1px solid #E2E0DD; border-radius: 6px; padding: 3px 10px; font-size: 0.82rem; font-weight: 600; color: #1A1A1A; display: inline-block; }
    .btn-action { background: none; border: none; color: #7F7F7F; padding: 4px 8px; border-radius: 6px; transition: all 0.2s; font-size: 1rem; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-action:hover { background: #F4F4F0; color: #FF5E2B; }
    .btn-action.delete:hover { color: #dc3545; }
    .badge-active { background: #ECFDF5; color: #059669; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
    .badge-inactive { background: #F4F4F0; color: #7F7F7F; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
    .pagination-wrap { padding: 16px 20px; border-top: 1px solid #E2E0DD; display: flex; justify-content: space-between; align-items: center; }
    .pagination-info { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #7F7F7F; }
    .btn-page { border: 1px solid #E2E0DD; background: #fff; color: #1A1A1A; border-radius: 6px; padding: 6px 16px; font-size: 0.82rem; font-weight: 600; transition: all 0.2s; }
    .btn-page:hover { background: #FF5E2B; color: #fff; border-color: #FF5E2B; }
    .btn-page:disabled { color: #C0BAB4; cursor: not-allowed; }
</style>
@endpush

@section('content')

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title mb-1">Department List</h1>
            <p class="page-subtitle mb-0">Manage and monitor organizational structures across the enterprise.</p>
        </div>
        <a href="{{ route('admin.department.create') }}" class="btn-add d-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add Department
        </a>
    </div>

    {{-- KPI Row --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-label">Total Depts</div>
                <div class="kpi-value">{{ str_pad($departments->count(), 2, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-label">Active Depts</div>
                <div class="kpi-value">{{ str_pad($departments->where('status', 'active')->count(), 2, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="insight-card">
                <div class="insight-label">Quick Insight</div>
                <div class="insight-text">
                    @if($departments->count() > 0)
                        {{ $departments->count() }} department(s) currently in the system.
                    @else
                        No departments yet. Add your first department!
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="dept-table-wrap">
        <table class="dept-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Department Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $department)
                <tr>
                    <td style="color:#B2ADA7; font-size:0.78rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="dept-name">
                            <span class="dept-accent {{ $department->status === 'inactive' ? 'inactive' : '' }}"></span>
                            {{ $department->name }}
                        </div>
                    </td>
                    <td style="color:#7F7F7F; font-size:0.82rem;">
                        {{ $department->description ?? '—' }}
                    </td>
                    <td>
                        @if($department->status === 'active')
                            <span class="badge-active">Active</span>
                        @else
                            <span class="badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.department.edit', $department->id) }}" class="btn-action">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.department.destroy', $department->id) }}" style="display:inline;" onsubmit="return confirm('Delete this department?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5" style="color:#B2ADA7; font-size:0.88rem;">
                        <i class="bi bi-diagram-3 d-block mb-2" style="font-size:2rem;"></i>
                        No departments found. <a href="{{ route('admin.department.create') }}" style="color:#FF5E2B;">Add one now.</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="pagination-wrap">
            <span class="pagination-info">Showing {{ $departments->count() }} Department(s)</span>
        </div>
    </div>

@endsection