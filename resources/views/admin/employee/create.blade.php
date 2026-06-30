@extends('admin.layouts.admin')

@section('title', 'Add Employee - Skills Hut Ltd')

@push('styles')
<style>
    .page-title { font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700; color: #1A1A1A; }
    .page-subtitle { font-size: 0.85rem; color: #7F7F7F; }
    .breadcrumb-custom { font-size: 0.78rem; color: #7F7F7F; display: flex; align-items: center; gap: 6px; margin-bottom: 20px; }
    .breadcrumb-custom a { color: #FF5E2B; text-decoration: none; }
    .breadcrumb-custom i { font-size: 0.65rem; color: #B2ADA7; }
    .form-card { background: #fff; border: 1px solid #E2E0DD; border-radius: 14px; padding: 32px; }
    .form-section-title { font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 700; color: #1A1A1A; padding-bottom: 12px; border-bottom: 1px solid #F4F4F0; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    .form-section-title i { color: #FF5E2B; }
    .form-label { font-size: 0.82rem; font-weight: 600; color: #4A4A4A; margin-bottom: 7px; }
    .form-control, .form-select { border: 1px solid #E2E0DD; border-radius: 8px; padding: 11px 14px; font-size: 0.88rem; color: #1A1A1A; transition: all 0.2s; }
    .form-control::placeholder { color: #C0BAB4; }
    .form-control:focus, .form-select:focus { border-color: #FF5E2B; box-shadow: 0 0 0 3px rgba(255,94,43,0.1); outline: none; }
    .form-control.is-invalid, .form-select.is-invalid { border-color: #dc3545; }
    .hint-text { font-size: 0.75rem; color: #B2ADA7; margin-top: 5px; }
    .btn-save { background: #FF5E2B; color: #fff; border: none; border-radius: 8px; padding: 11px 28px; font-size: 0.9rem; font-weight: 600; transition: all 0.2s; }
    .btn-save:hover { background: #E04B1A; color: #fff; transform: translateY(-1px); }
    .btn-cancel { background: #fff; color: #4A4A4A; border: 1px solid #E2E0DD; border-radius: 8px; padding: 11px 28px; font-size: 0.9rem; font-weight: 600; transition: all 0.2s; text-decoration: none; }
    .btn-cancel:hover { background: #FAF9F6; color: #4A4A4A; }

    /* Photo Upload */
    .photo-upload { border: 2px dashed #E2E0DD; border-radius: 12px; padding: 28px; text-align: center; cursor: pointer; transition: all 0.2s; }
    .photo-upload:hover { border-color: #FF5E2B; background: #FFF8F5; }
    .photo-upload-icon { width: 52px; height: 52px; border-radius: 50%; background: #F4F4F0; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 1.3rem; color: #7F7F7F; }
    .photo-upload-text { font-size: 0.82rem; color: #7F7F7F; }
    .photo-upload-hint { font-size: 0.72rem; color: #B2ADA7; margin-top: 4px; }
</style>
@endpush

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb-custom">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('admin.employee.index') }}">Employee Directory</a>
        <i class="bi bi-chevron-right"></i>
        <span>Add Employee</span>
    </div>

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title mb-1">Add Employee</h1>
            <p class="page-subtitle mb-0">Fill in the details to onboard a new team member.</p>
        </div>
        <a href="{{ route('admin.employee.index') }}" class="btn-cancel d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('admin.employee.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            {{-- Left Column --}}
            <div class="col-12 col-lg-8">

                {{-- Personal Info --}}
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-person-fill"></i> Personal Information
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. John Doe" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Employee ID <span class="text-danger">*</span></label>
                            <input type="text" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" value="{{ old('employee_id') }}" placeholder="e.g. EMP-1001" required>
                            @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6">
    <label class="form-label">NID <span class="text-danger">*</span></label>
    <input type="text" name="nid" class="form-control @error('nid') is-invalid @enderror" value="{{ old('nid') }}" placeholder="e.g. 1234567890" required>
    @error('nid')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="col-12 col-md-6">
    <label class="form-label">Blood Group</label>
    <select name="blood_group" class="form-control @error('blood_group') is-invalid @enderror">
        <option value="">Select Blood Group</option>
        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
            <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>
                {{ $bg }}
            </option>
        @endforeach
    </select>
    @error('blood_group')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="john@skillshut.com" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="01XXXXXXXXX" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">-- Select --</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" placeholder="Full residential address">{{ old('address') }}</textarea>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Job Info --}}
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-briefcase-fill"></i> Job Information
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Department <span class="text-danger">*</span></label>
                            <select name="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                                <option value="">-- Select Department --</option>
                                @php
                                    $departments = \App\Models\Department::all();
                                @endphp

                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation') }}" placeholder="e.g. Senior Developer" required>
                            @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">-- Select Role --</option>
                                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                                <option value="team_lead" {{ old('role') == 'team_lead' ? 'selected' : '' }}>Team Lead</option>
                                <option value="hr_admin" {{ old('role') == 'hr_admin' ? 'selected' : '' }}>HR Admin</option>
                            </select>
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Joining Date <span class="text-danger">*</span></label>
                            <input type="date" name="hire_date" class="form-control @error('hire_date') is-invalid @enderror" value="{{ old('hire_date') }}" required>
                            @error('hire_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 8 characters" required>
                            <div class="hint-text">Employee will use this to login.</div>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Emergency Contact --}}
                <div class="form-card">
                    <div class="form-section-title">
                        <i class="bi bi-telephone-fill"></i> Emergency Contact
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Contact Name</label>
                            <input type="text" name="emergency_contact_name" class="form-control @error('emergency_contact_name') is-invalid @enderror" value="{{ old('emergency_contact_name') }}" placeholder="Full name">
                            @error('emergency_contact_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Relationship</label>
                            <input type="text" name="emergency_contact_relationship" class="form-control @error('emergency_contact_relationship') is-invalid @enderror" value="{{ old('emergency_contact_relationship') }}" placeholder="e.g. Spouse, Parent">
                            @error('emergency_contact_relationship')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Contact Phone</label>
                            <input type="tel" name="emergency_contact_phone" class="form-control @error('emergency_contact_phone') is-invalid @enderror" value="{{ old('emergency_contact_phone') }}" placeholder="01XXXXXXXXX">
                            @error('emergency_contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Column --}}
            <div class="col-12 col-lg-4">
    <div class="form-card">
        <div class="form-section-title">
            <i class="bi bi-image-fill"></i> Profile Photo
        </div>
        <label for="profile_picture" style="cursor:pointer; display:block;">
            <div class="photo-upload" id="photo-drop">
                <div class="photo-upload-icon">
                    <i class="bi bi-cloud-upload"></i>
                </div>
                <div class="photo-upload-text">Click to upload photo</div>
                <div class="photo-upload-hint">JPG, PNG — Max 2MB</div>
            </div>
        </label>
        <input type="file" name="profile_picture" id="profile_picture"
               class="d-none" accept="image/*" onchange="previewPhoto(this)">

        <div id="photo-preview" class="text-center mt-3" style="display:none;">
            <img id="preview-img" src="" alt="Preview"
                 style="width:100px; height:100px; border-radius:50%;
                        object-fit:cover; border:2px solid #FF5E2B;">
        </div>

        @error('profile_picture')
            <div class="text-danger mt-2" style="font-size:0.78rem;">{{ $message }}</div>
        @enderror
    </div>
</div>

        </div>

        {{-- Action Buttons --}}
        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn-save d-flex align-items-center gap-2">
                <i class="bi bi-check-lg"></i> Save Employee
            </button>
            <a href="{{ route('admin.employee.index') }}" class="btn-cancel d-flex align-items-center gap-2">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
        </div>

    </form>

@endsection

@push('scripts')
<script>
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('photo-preview').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush