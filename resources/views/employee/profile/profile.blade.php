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

   

    .profile-name {
        font-family: 'Outfit', sans-serif;
     
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

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.82rem;
        color: #7F7F7F;
        font-weight: 600;
    }

    .info-value {
        font-size: 0.88rem;
        color: #1A1A1A;
        font-weight: 600;
        text-align: right;
    }

    

</style>
@endpush

@section('content')

@php
    $employee = $employee ?? auth()->user();
@endphp

<div class="profile-shell">
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h1 class="page-title mb-1">My Profile</h1>
            <p class="page-subtitle mb-0">View your account information and access details.</p>
        </div>

        <a href="#" class="btn-profile d-flex align-items-center gap-2">
            <i class="bi bi-pencil-square"></i> Edit Profile
            </a>
        </div>

    <div class="profile-header">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <div class="profile-avatar">
                {{ strtoupper(substr($employee->name ?? 'A', 0, 1)) }}
            </div>

            <div>
                <div class="profile-name">{{ $employee->name ?? 'Admin User' }}</div>
                <div class="profile-meta">{{ $employee->email ?? 'No email available' }}</div>

                <span class="profile-badge">Active Account</span>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="info-card">
                <div class="info-title">Account Information</div>

                <div class="info-row">
                    <div class="info-label">Name</div>
                    <div class="info-value">{{ $employee->name ?? 'N/A' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $employee->email ?? 'N/A' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Role</div>
                    <div class="info-value">{{ ucfirst($employee->role ?? 'Admin') }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Account ID</div>
                    <div class="info-value">#{{ $employee->id ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="info-card">
                <div class="info-title">Security Details</div>

                <div class="info-row">
                    <div class="info-label">Email Verified</div>
                    <div class="info-value">
                        {{ !empty($employee->email_verified_at) ? 'Verified' : 'Not Verified' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Created At</div>
                    <div class="info-value">
                        {{ !empty($employee->created_at) ? $employee->created_at->format('d M Y') : 'N/A' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Last Updated</div>
                    <div class="info-value">
                        {{ !empty($employee->updated_at) ? $employee->updated_at->format('d M Y') : 'N/A' }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Login Status</div>
                    <div class="info-value">Signed In</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection