@extends('layouts.app')

@section('title', 'Create Account')

@push('styles')
<style>
    :root {
        --brand-primary: #FF5E2B;
        --brand-primary-hover: #E04B1A;
        --bg-page: #FAF9F6;
        --text-dark: #1A1A1A;
        --text-muted: #7F7F7F;
        --border-color: #E2E0DD;
        --font-serif: 'Playfair Display', serif;
        --font-sans: 'Plus Jakarta Sans', sans-serif;
    }

    body {
        background-color: var(--bg-page);
        font-family: var(--font-sans);
        color: var(--text-dark);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .navbar-brand-custom {
        font-weight: 700;
        color: var(--brand-primary);
        font-size: 1.25rem;
        text-decoration: none;
        letter-spacing: -0.2px;
    }
    .navbar-brand-custom span { color: var(--text-dark); font-weight: 400; margin: 0 4px; }
    .header-link { color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.2s ease; }
    .header-link:hover { color: var(--brand-primary); }
    .header-divider { color: #D3CECA; margin: 0 15px; }

    .register-card-container { max-width: 580px; width: 100%; margin: 40px auto; }
    .register-card {
        background: #FFFFFF;
        border: 1px solid rgba(255, 94, 43, 0.15);
        border-radius: 20px;
        padding: 45px 50px;
        box-shadow: 0 15px 35px rgba(255, 94, 43, 0.02), 0 5px 15px rgba(0, 0, 0, 0.01);
    }

    .badge-office {
        background-color: var(--brand-primary);
        width: 54px; height: 54px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 24px auto;
        color: #FFFFFF; font-size: 1.5rem;
        box-shadow: 0 6px 16px rgba(255, 94, 43, 0.25);
    }
    .card-title { font-family: var(--font-serif); font-size: 2.2rem; font-weight: 700; color: var(--text-dark); margin-bottom: 6px; }
    .card-subtitle { font-size: 0.95rem; color: var(--text-muted); font-weight: 500; margin-bottom: 35px; }

    .form-label { font-size: 0.85rem; font-weight: 600; color: #4A4A4A; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
    .form-label i { color: #7A7672; font-size: 0.9rem; }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 13px 18px;
        font-size: 0.95rem;
        color: var(--text-dark);
        transition: all 0.2s ease;
    }
    .form-control::placeholder { color: #B2ADA7; }
    .form-control:focus { border-color: var(--brand-primary); box-shadow: 0 0 0 4px rgba(255, 94, 43, 0.1); outline: 0; }
    .form-control.is-invalid { border-color: #dc3545; }

    .password-toggle-btn { background: none; border: none; color: var(--text-muted); font-size: 0.85rem; cursor: pointer; padding: 0; transition: color 0.2s; font-weight: 500; }
    .password-toggle-btn:hover { color: var(--brand-primary); }

    .form-check-input { border-color: var(--border-color); cursor: pointer; }
    .form-check-input:checked { background-color: var(--brand-primary); border-color: var(--brand-primary); }
    .form-check-input:focus { box-shadow: 0 0 0 4px rgba(255, 94, 43, 0.1); border-color: var(--brand-primary); }
    .form-check-label { font-size: 0.88rem; color: #555; cursor: pointer; }
    .form-check-label a { color: var(--brand-primary); text-decoration: none; font-weight: 500; }
    .form-check-label a:hover { text-decoration: underline; }

    .btn-register {
        background-color: var(--brand-primary);
        color: #FFFFFF; border: none; border-radius: 8px;
        padding: 14px; font-size: 1.1rem; font-weight: 600;
        transition: all 0.25s ease;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; margin-top: 25px;
        box-shadow: 0 4px 12px rgba(255, 94, 43, 0.15);
    }
    .btn-register:hover { background-color: var(--brand-primary-hover); color: #FFFFFF; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255, 94, 43, 0.25); }
    .btn-register:active { transform: translateY(1px); }

    .hint-text { font-size: 0.78rem; color: var(--text-muted); margin-top: 5px; }

    .badge-footer { display: flex; justify-content: center; gap: 25px; margin-top: 10px; margin-bottom: 40px; font-size: 0.85rem; color: var(--text-muted); font-weight: 500; }
    .badge-footer span { display: flex; align-items: center; gap: 6px; }
    .badge-footer i { color: #7A7672; }

    .site-footer { border-top: 1px solid rgba(0,0,0,0.05); padding: 25px 40px; font-size: 0.82rem; color: var(--text-muted); background-color: #FFFFFF; }
    .site-footer a { color: var(--text-muted); text-decoration: none; margin: 0 12px; transition: color 0.2s; }
    .site-footer a:hover { color: var(--brand-primary); }
</style>
@endpush

@section('content')

    <header class="py-3 px-4 d-flex justify-content-between align-items-center">
        <a href="#" class="navbar-brand-custom">
            Skills Hut Ltd <span>|</span> HRM
        </a>
        <div class="d-flex align-items-center">
            <a href="#" class="header-link">Support</a>
            <span class="header-divider">|</span>
            <a href="#" class="header-link">Privacy</a>
        </div>
    </header>

    <main class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">
        <div class="register-card-container">
            <div class="register-card text-center">

                <div class="badge-office">
                    <i class="fa-solid fa-building"></i>
                </div>

                <h1 class="card-title">Create Account</h1>
                <p class="card-subtitle">Skills Hut HRM Portal Access</p>

                @if (session('error'))
                    <div class="alert alert-danger py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.reg.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="full_name" class="form-label">
                            <i class="fa-regular fa-user"></i> Full Name
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="full_name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label">
                            <i class="fa-solid fa-briefcase"></i> Position / Title
                        </label>
                        <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}" placeholder="e.g. CEO, Director" required>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="company_name" class="form-label">
                            <i class="fa-regular fa-building"></i> Company Name
                        </label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="e.g. Skills Hut Ltd" required>
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fa-solid fa-envelope"></i> Email Address
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="example@skillshut.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fa-solid fa-lock"></i> Password
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="password_confirmation" class="form-label mb-0">
                                <i class="fa-solid fa-rotate-left"></i> Confirm Password
                            </label>
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()">
                                <i class="fa-regular fa-eye" id="toggle-icon"></i>
                            </button>
                        </div>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                        <div class="hint-text">Min. 8 characters.</div>
                    </div>

                    <div class="mb-4 form-check d-flex align-items-start">
                        <input type="checkbox" class="form-check-input me-2 mt-1" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                        </label>
                    </div>

                    <button type="submit" class="btn-register">
                        Register <i class="fa-solid fa-arrow-right ms-1"></i>
                    </button>
                </form>

            </div>
        </div>

        <div class="badge-footer">
            <span><i class="fa-solid fa-shield-halved"></i> ISO 27001 Certified</span>
            <span><i class="fa-solid fa-lock"></i> AES-256 Encrypted</span>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 text-center text-md-start">
            <div>
                <a href="#" style="color: var(--text-dark); font-weight: 700; margin-left: 0;">Skills Hut Ltd | HRM</a>
                <span class="ms-md-2" style="font-weight: 400; color: #B2ADA7;">© 2025 Skills Hut Ltd. All rights reserved.</span>
            </div>
            <div class="d-flex flex-wrap justify-content-center justify-content-md-end">
                <a href="#">Terms of Service</a>
                <span style="color: #E2E0DD;">|</span>
                <a href="#">Contact Us</a>
            </div>
        </div>
    </footer>

@endsection

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const toggleIcon = document.getElementById('toggle-icon');

        if (confirmInput.type === 'password') {
            confirmInput.type = 'text';
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            confirmInput.type = 'password';
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endpush