@extends('employee.layouts.employee')

@section('title', 'My Profile - Skills Hut Ltd')

@push('styles')
<style>
    .profile-shell {
        max-width: 980px;
        margin: 0 auto;
    }

    .page-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.45rem;
        font-weight: 700;
        color: #1A1A1A;
    }

    .page-subtitle {
        font-size: 0.88rem;
        color: #7F7F7F;
    }

    .profile-header {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 18px;
    }

    .profile-photo {
        width: 80px;
        height: 80px;
        border-radius: 14px;
        object-fit: cover;
        border: 1px solid #E2E0DD;
        flex-shrink: 0;
    }

    .profile-photo-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 14px;
        background: #FFF0EB;
        color: #FF5E2B;
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .profile-name {
        font-family: 'Outfit', sans-serif;
        font-size: 1.3rem;
        font-weight: 800;
        color: #1A1A1A;
        margin-bottom: 4px;
    }

    .profile-meta {
        font-size: 0.88rem;
        color: #7F7F7F;
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ECFDF5;
        color: #059669;
        border-radius: 20px;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 5px 10px;
        margin-top: 10px;
    }

    .profile-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #059669;
    }

    .info-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 20px;
        height: 100%;
    }

    .info-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 16px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 11px 0;
        border-bottom: 1px solid #F4F4F0;
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        font-size: 0.82rem;
        color: #7F7F7F;
        font-weight: 600;
        white-space: nowrap;
    }

    .info-value {
        font-size: 0.88rem;
        color: #1A1A1A;
        font-weight: 600;
        text-align: right;
    }

    .btn-edit {
        background: #FF5E2B;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 10px 18px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-edit:hover { background: #E04B1A; color: #fff; }
</style>
@endpush

@section('content')

@php
    $employee = auth('employee')->user();
@endphp

<div class="profile-shell">
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h1 class="page-title mb-1">My Profile</h1>
            <p class="page-subtitle mb-0">View your account information and access details.</p>
        </div>
        <a href="{{ route('employee.edit') }}" class="btn-edit">
            <i class="bi bi-pencil-square"></i> Edit Profile
        </a>
    </div>

    {{-- Profile Header --}}
    <div class="profile-header">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            @if($employee->profile_picture)
                <img src="{{ asset('storage/' . $employee->profile_picture) }}"
                     class="profile-photo" alt="{{ $employee->name }}">
            @else
                <div class="profile-photo-placeholder">
                    {{ strtoupper(substr($employee->name ?? 'E', 0, 2)) }}
                </div>
            @endif

            <div>
                <div class="profile-name">{{ $employee->name }}</div>
                <div class="profile-meta">
                    {{ $employee->designation ?? 'N/A' }}
                    @if($employee->department)
                        &nbsp;•&nbsp;{{ $employee->department->name }}
                    @endif
                </div>
                <div class="profile-meta">{{ $employee->email }}</div>
                <span class="profile-badge">
                    {{ ucfirst($employee->employment_status ?? 'Active') }}
                </span>
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Personal Information --}}
        <div class="col-lg-6">
            <div class="info-card">
                <div class="info-title">Personal Information</div>

                <div class="info-row">
                    <div class="info-label">Full Name</div>
                    <div class="info-value">{{ $employee->name ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $employee->email ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $employee->phone ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value">
                        {{ $employee->date_of_birth
                            ? \Carbon\Carbon::parse($employee->date_of_birth)->format('d M Y')
                            : 'N/A' }}
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Gender</div>
                    <div class="info-value">{{ ucfirst($employee->gender ?? 'N/A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Blood Group</div>
                    <div class="info-value">{{ $employee->blood_group ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">NID</div>
                    <div class="info-value">{{ $employee->nid ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        {{-- Job Information --}}
        <div class="col-lg-6">
            <div class="info-card">
                <div class="info-title">Job Information</div>

                <div class="info-row">
                    <div class="info-label">Employee ID</div>
                    <div class="info-value">{{ $employee->employee_id ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Department</div>
                    <div class="info-value">{{ $employee->department->name ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Designation</div>
                    <div class="info-value">{{ $employee->designation ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Employment Status</div>
                    <div class="info-value">{{ ucfirst($employee->employment_status ?? 'N/A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Joining Date</div>
                    <div class="info-value">
                        {{ $employee->hire_date
                            ? \Carbon\Carbon::parse($employee->hire_date)->format('d M Y')
                            : 'N/A' }}
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Role</div>
                    <div class="info-value">{{ ucfirst($employee->role ?? 'Employee') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Member Since</div>
                    <div class="info-value">
                        {{ $employee->created_at
                            ? $employee->created_at->format('d M Y')
                            : 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Emergency Contact --}}
        <div class="col-lg-12">
            <div class="info-card">
                <div class="info-title">Emergency Contact</div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Name</div>
                            <div class="info-value">{{ $employee->emergency_contact_name ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Phone</div>
                            <div class="info-value">{{ $employee->emergency_contact_phone ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-row">
                            <div class="info-label">Relationship</div>
                            <div class="info-value">{{ ucfirst($employee->emergency_contact_relationship ?? 'N/A') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection