@extends('admin.layouts.admin')

@section('title', 'Create Leave Type - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }
    .breadcrumb-custom { font-size: 0.78rem; color: #7F7F7F; display: flex; align-items: center; gap: 6px; margin-bottom: 20px; }
    .breadcrumb-custom a { color: #FF5E2B; text-decoration: none; }
    .breadcrumb-custom i { font-size: 0.65rem; color: #B2ADA7; }
    .form-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; padding: 32px; }
    .section-title { font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 700; color: #1A1A1A; padding-bottom: 12px; border-bottom: 1px solid #F4F4F0; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    .section-title i { color: #FF5E2B; }
    .form-label { font-size: 0.82rem; font-weight: 600; color: #4A4A4A; margin-bottom: 7px; }
    .form-control, .form-select { border: 1px solid #E2E0DD; border-radius: 8px; padding: 11px 14px; font-size: 0.88rem; color: #1A1A1A; transition: all 0.2s; }
    .form-control::placeholder { color: #C0BAB4; }
    .form-control:focus, .form-select:focus { border-color: #FF5E2B; box-shadow: 0 0 0 3px rgba(255,94,43,0.1); outline: none; }
    .form-control.is-invalid { border-color: #dc3545; }
    .hint-text { font-size: 0.75rem; color: #B2ADA7; margin-top: 5px; }
    .btn-save { background: #FF5E2B; color: #fff; border: none; border-radius: 8px; padding: 11px 28px; font-size: 0.9rem; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
    .btn-save:hover { background: #E04B1A; color: #fff; transform: translateY(-1px); }
    .btn-cancel { background: #fff; color: #4A4A4A; border: 1px solid #E2E0DD; border-radius: 8px; padding: 11px 28px; font-size: 0.9rem; font-weight: 600; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-cancel:hover { background: #FAF9F6; color: #4A4A4A; }

    /* Toggle Switch */
    .form-check-input { width: 42px; height: 22px; cursor: pointer; }
    .form-check-input:checked { background-color: #FF5E2B; border-color: #FF5E2B; }
    .form-check-input:focus { box-shadow: 0 0 0 3px rgba(255,94,43,0.1); border-color: #FF5E2B; }
    .form-check-label { font-size: 0.85rem; color: #4A4A4A; font-weight: 500; }
</style>
@endpush

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb-custom">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <i class="bi bi-chevron-right"></i>
      
        <i class="bi bi-chevron-right"></i>
        <span>Create</span>
    </div>

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title mb-1">Create Leave Type</h1>
            <p class="page-subtitle mb-0">Define a new leave category for employees.</p>
        </div>
        <a href="{{ route('admin.employee_leave.index') }}" class="btn-cancel">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Form --}}
    <div class="row justify-content-center">
        <div class="col-12 col-lg-7">
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-calendar2-check-fill"></i> Leave Type Details
                </div>

                <form action="{{route('admin.leave.store')}}" method="POST">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Leave Type Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="e.g. Annual Leave, Sick Leave" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Days Allowed --}}
                    <div class="mb-3">
                        <label class="form-label">Days Allowed Per Year <span class="text-danger">*</span></label>
                        <input type="number" name="days_allowed" class="form-control @error('days_allowed') is-invalid @enderror"
                               value="{{ old('days_allowed') }}" placeholder="e.g. 20" min="1" required>
                        <div class="hint-text">Total days an employee can take per year.</div>
                        @error('days_allowed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="3" placeholder="Optional description...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Active Toggle --}}
                   <div class="mb-4">
    <label class="form-label d-block">Status</label>
    <div class="form-check form-switch d-flex align-items-center gap-2">

        {{-- এই line টা যোগ করুন --}}
        <input type="hidden" name="is_active" value="0">

        <input class="form-check-input" type="checkbox" name="is_active"
               id="is_active" value="1"
               {{ old('is_active', true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
    <div class="hint-text">Inactive leave types won't appear in employee forms.</div>
</div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn-save">
                            <i class="bi bi-check-lg"></i> Save Leave Type
                        </button>
                        <a href="{{ route('admin.employee_leave.index') }}" class="btn-cancel">
                            <i class="bi bi-x-lg"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection