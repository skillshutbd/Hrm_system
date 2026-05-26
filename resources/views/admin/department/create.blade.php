@extends('admin.layouts.admin')

@section('title', 'Add Department - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }

    .form-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; padding: 32px; }
    .form-section-title { font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 700; color: #1A1A1A; padding-bottom: 12px; border-bottom: 1px solid #F4F4F0; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    .form-section-title i { color: #FF5E2B; }

    .form-label { font-size: 0.82rem; font-weight: 600; color: #4A4A4A; margin-bottom: 7px; }
    .form-control { border: 1px solid #E2E0DD; border-radius: 8px; padding: 11px 14px; font-size: 0.88rem; color: #1A1A1A; transition: all 0.2s; }
    .form-control::placeholder { color: #C0BAB4; }
    .form-control:focus { border-color: #FF5E2B; box-shadow: 0 0 0 3px rgba(255,94,43,0.1); outline: none; }
    .form-control.is-invalid { border-color: #dc3545; }
    .form-select { border: 1px solid #E2E0DD; border-radius: 8px; padding: 11px 14px; font-size: 0.88rem; color: #1A1A1A; transition: all 0.2s; }
    .form-select:focus { border-color: #FF5E2B; box-shadow: 0 0 0 3px rgba(255,94,43,0.1); outline: none; }

    .hint-text { font-size: 0.75rem; color: #B2ADA7; margin-top: 5px; }

    .btn-save { background: #FF5E2B; color: #fff; border: none; border-radius: 8px; padding: 11px 28px; font-size: 0.9rem; font-weight: 600; transition: all 0.2s; }
    .btn-save:hover { background: #E04B1A; color: #fff; transform: translateY(-1px); }
    .btn-cancel { background: #fff; color: #4A4A4A; border: 1px solid #E2E0DD; border-radius: 8px; padding: 11px 28px; font-size: 0.9rem; font-weight: 600; transition: all 0.2s; }
    .btn-cancel:hover { background: #FAF9F6; }

    /* Breadcrumb */
    .breadcrumb-custom { font-size: 0.78rem; color: #7F7F7F; display: flex; align-items: center; gap: 6px; margin-bottom: 20px; }
    .breadcrumb-custom a { color: #FF5E2B; text-decoration: none; }
    .breadcrumb-custom a:hover { text-decoration: underline; }
    .breadcrumb-custom i { font-size: 0.65rem; color: #B2ADA7; }
</style>
@endpush

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb-custom">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('admin.department.index') }}">Department List</a>
        <i class="bi bi-chevron-right"></i>
        <span>Add Department</span>
    </div>

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title mb-1">Add Department</h1>
            <p class="page-subtitle mb-0">Create a new department and assign a head of department.</p>
        </div>
        <a href="{{ route('admin.department.index') }}" class="btn-cancel d-flex align-items-center gap-2" style="text-decoration:none;">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('admin.department.store') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- Left Column --}}
            <div class="col-12 col-lg-8">
                <div class="form-card">

                    <div class="form-section-title">
                        <i class="bi bi-diagram-3-fill"></i> Department Information
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Department Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Engineering, Human Resources" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Brief description of this department's responsibilities...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Right Column --}}
            <!-- <div class="col-12 col-lg-4">
                <div class="form-card">

                    <div class="form-section-title">
                        <i class="bi bi-person-badge-fill"></i> Head of Department
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select HOD</label>
                        <select name="hod_id" class="form-select @error('hod_id') is-invalid @enderror">
                            <option value="">-- Select Employee --</option>
                            {{-- @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('hod_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach --}}
                        </select>
                        <div class="hint-text">Assign an existing employee as HOD.</div>
                        @error('hod_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Location / Floor</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="e.g. Floor 3, Block B">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div> -->

        </div>

        {{-- Action Buttons --}}
        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn-save d-flex align-items-center gap-2">
                <i class="bi bi-check-lg"></i> Save Department
            </button>
            <a href="{{ route('admin.department.index') }}" class="btn-cancel d-flex align-items-center gap-2" style="text-decoration:none;">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
        </div>

    </form>

@endsection