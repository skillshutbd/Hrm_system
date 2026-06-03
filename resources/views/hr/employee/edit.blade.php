@extends('hr.layouts.hr')

@section('title', 'Edit Employee - Skills Hut Ltd')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="page-title mb-1">Edit Employee</h1>
        <p class="page-subtitle mb-0">Update employee information.</p>
    </div>

    <form action="{{ route('admin.employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Employee ID</label>
                <input type="text" name="employee_id" class="form-control" value="{{ old('employee_id', $employee->employee_id) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">NID</label>
                <input type="text" name="nid" class="form-control" value="{{ old('nid', $employee->nid) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control">

                @if($employee->profile_picture)
                    <img src="{{ asset('storage/' . $employee->profile_picture) }}" width="80" class="mt-2 rounded">
                @endif
            </div>

            <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $employee->date_of_birth) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control">{{ old('address', $employee->address) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Emergency Contact Name</label>
                <input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Emergency Contact Phone</label>
                <input type="text" name="emergency_contact_phone" class="form-control" value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Emergency Contact Relationship</label>
                <input type="text" name="emergency_contact_relationship" class="form-control" value="{{ old('emergency_contact_relationship', $employee->emergency_contact_relationship) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-control" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Designation</label>
                <input type="text" name="designation" class="form-control" value="{{ old('designation', $employee->designation) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Role</label>
                <input type="text" name="role" class="form-control" value="{{ old('role', $employee->role) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Hire Date</label>
                <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', $employee->hire_date) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep old password">
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Employee</button>
            <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection