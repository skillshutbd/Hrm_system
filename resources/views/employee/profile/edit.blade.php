@extends('admin.layouts.admin')

@section('title', 'Edit Profile - Skills Hut Ltd')

@push('styles')
<style>
    .profile-shell {
        max-width: 760px;
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

    .form-card {
        background: #fff;
        border: 1px solid #E2E0DD;
        border-radius: 14px;
        padding: 24px;
    }

    .form-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 8px;
    }

    .form-control {
        border: 1px solid #E2E0DD;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 0.9rem;
    }

    .form-control:focus {
        border-color: #FF5E2B;
        box-shadow: 0 0 0 3px rgba(255,94,43,0.1);
    }

    .btn-save {
        background: #FF5E2B;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.88rem;
        padding: 10px 18px;
    }

    .btn-save:hover {
        background: #E04B1A;
        color: #fff;
    }

    .btn-back {
        background: #fff;
        color: #1A1A1A;
        border: 1px solid #E2E0DD;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.88rem;
        padding: 10px 18px;
        text-decoration: none;
    }

    .btn-back:hover {
        background: #FAF9F6;
        color: #1A1A1A;
    }

    .text-danger {
        font-size: 0.78rem;
        margin-top: 5px;
    }
</style>
@endpush

@section('content')

@php
    $admin = $admin ?? auth()->user();
@endphp

<div class="profile-shell">
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h1 class="page-title mb-1">Edit Profile</h1>
            <p class="page-subtitle mb-0">Update your account information and password.</p>
        </div>

        <a href="{{ route('admin.profile') }}" class="btn-back d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
    
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $admin->name) }}"
                    required
                >

                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $admin->email) }}"
                    required
                >

                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <hr class="my-4">

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Leave blank to keep current password"
                >

                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm New Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Confirm new password"
                >
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-save d-flex align-items-center gap-2">
                    <i class="bi bi-check-lg"></i> Save Changes
                </button>

                <a href="{{ route('admin.profile') }}" class="btn-back">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection