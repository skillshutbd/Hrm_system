@extends('admin.layouts.admin')

@section('title', 'Edit Department - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #1A1A1A; letter-spacing: -0.5px; }
    .page-subtitle { font-size: 0.9rem; color: #7F7F7F; }
    .btn-back { border: 1px solid #E2E0DD; background: #fff; color: #1A1A1A; border-radius: 8px; font-weight: 700; font-size: 0.88rem; padding: 10px 18px; text-decoration: none; }
    .btn-back:hover { background: #F4F4F0; color: #FF5E2B; }
    .edit-card { border: 1px solid #E2E0DD; border-radius: 12px; background: #fff; overflow: hidden; }
    .edit-card-head { padding: 20px 24px; border-bottom: 1px solid #E2E0DD; display: flex; justify-content: space-between; align-items: center; gap: 16px; }
    .edit-card-title { font-family: 'Outfit', sans-serif; font-size: 1.15rem; font-weight: 800; color: #1A1A1A; margin: 0; }
    .edit-card-meta { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #7F7F7F; }
    .edit-card-body { padding: 24px; }
    .form-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; margin-bottom: 8px; }
    .form-control, .form-select { border: 1px solid #E2E0DD; border-radius: 8px; padding: 11px 14px; font-size: 0.9rem; color: #1A1A1A; }
    .form-control:focus, .form-select:focus { border-color: #FF5E2B; box-shadow: 0 0 0 0.18rem rgba(255, 94, 43, 0.14); }
    .form-control::placeholder { color: #B2ADA7; }
    .invalid-feedback { font-size: 0.78rem; font-weight: 600; }
    .form-actions { border-top: 1px solid #E2E0DD; padding: 18px 24px; display: flex; justify-content: flex-end; gap: 12px; background: #FAF9F6; }
    .btn-cancel { border: 1px solid #E2E0DD; background: #fff; color: #1A1A1A; border-radius: 8px; font-weight: 700; font-size: 0.88rem; padding: 10px 18px; text-decoration: none; }
    .btn-cancel:hover { background: #F4F4F0; color: #1A1A1A; }
    .btn-save { background: #FF5E2B; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 0.88rem; padding: 10px 20px; }
    .btn-save:hover { background: #E04B1A; color: #fff; }
    .status-preview { border: 1px solid #E2E0DD; border-radius: 12px; background: #FAF9F6; padding: 18px 20px; height: 100%; }
    .status-preview-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #7F7F7F; margin-bottom: 10px; }
    .dept-name-preview { font-weight: 800; color: #1A1A1A; display: flex; align-items: center; gap: 10px; }
    .dept-accent { width: 3px; height: 24px; background: #FF5E2B; border-radius: 2px; flex: 0 0 auto; }
    .badge-active { background: #ECFDF5; color: #059669; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
    .badge-inactive { background: #F4F4F0; color: #7F7F7F; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
</style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title mb-1">Edit Department</h1>
            <p class="page-subtitle mb-0">Update department details, description, and current availability status.</p>
        </div>
        <a href="{{ route('admin.department.index') }}" class="btn-back d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- Validation Summary --}}
    @if($errors->any())
        <div class="alert alert-danger py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
            <i class="bi bi-exclamation-circle me-1"></i> Please fix the highlighted fields and try again.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.department.update', $department->id) }}">
        @csrf
        @method('PUT')

        <div class="edit-card">
            <div class="edit-card-head">
                <div>
                    <h2 class="edit-card-title">Department Information</h2>
                    <div class="edit-card-meta">Department ID #{{ str_pad($department->id, 2, '0', STR_PAD_LEFT) }}</div>
                </div>

                @if(old('status', $department->status) === 'active')
                    <span class="badge-active">Active</span>
                @else
                    <span class="badge-inactive">Inactive</span>
                @endif
            </div>

            <div class="edit-card-body">
                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Department Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $department->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter department name"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Add a short department description"
                            >{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $department->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $department->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="status-preview">
                            <div class="status-preview-label">Current Record</div>
                            <div class="dept-name-preview mb-3">
                                <span class="dept-accent"></span>
                                {{ old('name', $department->name) }}
                            </div>
                            <div class="page-subtitle mb-0">
                                {{ old('description', $department->description) ?: 'No description added yet.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.department.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save d-flex align-items-center gap-2">
                    <i class="bi bi-check-lg"></i> Update Department
                </button>
            </div>
        </div>
    </form>

@endsection
