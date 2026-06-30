@extends('admin.layouts.admin')

@section('title', 'Edit Employee - Skills Hut Ltd')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="page-title mb-1">Edit Employee</h1>
        <p class="page-subtitle mb-0">Update employee information.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.employee.update', $employee->id) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- Employee ID --}}
            <div class="col-md-6">
                <label class="form-label">Employee ID</label>
                <input type="text" name="employee_id"
                       class="form-control @error('employee_id') is-invalid @enderror"
                       value="{{ old('employee_id', $employee->employee_id) }}">
                @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- NID --}}
            <div class="col-md-6">
                <label class="form-label">NID</label>
                <input type="text" name="nid"
                       class="form-control @error('nid') is-invalid @enderror"
                       value="{{ old('nid', $employee->nid) }}" required>
                @error('nid')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Blood Group --}}
            <div class="col-12 col-md-6">
                <label class="form-label">Blood Group</label>
                <select name="blood_group"
                        class="form-control @error('blood_group') is-invalid @enderror">
                    <option value="" disabled
                        {{ old('blood_group', $employee->blood_group) ? '' : 'selected' }}>
                        Select Blood Group
                    </option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                        <option value="{{ $bg }}"
                            {{ old('blood_group', $employee->blood_group) == $bg ? 'selected' : '' }}>
                            {{ $bg }}
                        </option>
                    @endforeach
                </select>
                @error('blood_group')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Name --}}
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $employee->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Email --}}
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $employee->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Phone --}}
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $employee->phone) }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Profile Picture --}}
            <div class="col-md-6">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture"
                       class="form-control @error('profile_picture') is-invalid @enderror">
                @error('profile_picture')<div class="invalid-feedback">{{ $message }}</div>@enderror

                @if($employee->profile_picture)
                    <img src="{{ asset('storage/' . $employee->profile_picture) }}"
                         width="80" class="mt-2 rounded">
                @endif
            </div>

            {{-- Date of Birth --}}
            <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth"
                       class="form-control @error('date_of_birth') is-invalid @enderror"
                       value="{{ old('date_of_birth', $employee->date_of_birth) }}">
                @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Gender --}}
            <div class="col-md-6">
                <label class="form-label">Gender</label>
                <select name="gender"
                        class="form-control @error('gender') is-invalid @enderror">
                    <option value="">Select Gender</option>
                    <option value="male"   {{ old('gender', $employee->gender) == 'male'   ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other"  {{ old('gender', $employee->gender) == 'other'  ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Address --}}
            <div class="col-md-12">
                <label class="form-label">Address</label>
                <textarea name="address"
                          class="form-control @error('address') is-invalid @enderror">{{ old('address', $employee->address) }}</textarea>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Emergency Contact --}}
            <div class="col-md-4">
                <label class="form-label">Emergency Contact Name</label>
                <input type="text" name="emergency_contact_name"
                       class="form-control @error('emergency_contact_name') is-invalid @enderror"
                       value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}">
                @error('emergency_contact_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Emergency Contact Phone</label>
                <input type="text" name="emergency_contact_phone"
                       class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                       value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone) }}">
                @error('emergency_contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Emergency Contact Relationship</label>
                <input type="text" name="emergency_contact_relationship"
                       class="form-control @error('emergency_contact_relationship') is-invalid @enderror"
                       value="{{ old('emergency_contact_relationship', $employee->emergency_contact_relationship) }}">
                @error('emergency_contact_relationship')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Department --}}
            <div class="col-md-6">
                <label class="form-label">Department</label>
                <select name="department_id"
                        class="form-control @error('department_id') is-invalid @enderror" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Designation --}}
            <div class="col-md-6">
                <label class="form-label">Designation</label>
                <input type="text" name="designation"
                       class="form-control @error('designation') is-invalid @enderror"
                       value="{{ old('designation', $employee->designation) }}" required>
                @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Role --}}
            <div class="col-md-4">
                <label class="form-label">Role</label>
                <input type="text" name="role"
                       class="form-control @error('role') is-invalid @enderror"
                       value="{{ old('role', $employee->role) }}">
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Hire Date --}}
            <div class="col-md-4">
                <label class="form-label">Hire Date</label>
                <input type="date" name="hire_date"
                       class="form-control @error('hire_date') is-invalid @enderror"
                       value="{{ old('hire_date', $employee->hire_date) }}">
                @error('hire_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Status --}}
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status"
                        class="form-control @error('status') is-invalid @enderror" required>
                    <option value="active"           {{ old('status', $employee->status) == 'active'           ? 'selected' : '' }}>Active</option>
                    <option value="inactive"         {{ old('status', $employee->status) == 'inactive'         ? 'selected' : '' }}>Inactive</option>
                    <option value="pending_approval"  {{ old('status', $employee->status) == 'pending_approval'  ? 'selected' : '' }}>Pending Approval</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Password --}}
            <div class="col-md-6">
                <label class="form-label">New Password</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Leave blank to keep old password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Employee</button>
            <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection