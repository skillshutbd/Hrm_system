@extends('layouts.app')

@section('title', 'Admin Login')

@push('styles')
<style>
    :root {
        --brand-primary: #FF5E2B;
        --brand-hover: #E04B1A;
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

    .site-header {
        padding: 18px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        background: #fff;
    }
    .brand {
        font-weight: 700;
        color: var(--brand-primary);
        font-size: 1.15rem;
        text-decoration: none;
    }
    .brand span { color: var(--text-dark); font-weight: 400; margin: 0 6px; }
    .header-nav a {
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.88rem;
        font-weight: 500;
        margin-left: 20px;
        transition: color 0.2s;
    }
    .header-nav a:hover { color: var(--brand-primary); }

    main {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 16px;
    }

    .login-card {
        background: #fff;
        border: 1px solid rgba(255, 94, 43, 0.15);
        border-radius: 20px;
        padding: 48px 52px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 20px 40px rgba(255, 94, 43, 0.04), 0 4px 12px rgba(0,0,0,0.03);
    }

    .brand-icon {
        width: 54px;
        height: 54px;
        background: var(--brand-primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.4rem;
        margin: 0 auto 22px;
        box-shadow: 0 6px 16px rgba(255, 94, 43, 0.28);
    }
    .card-title {
        font-family: var(--font-serif);
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 6px;
    }
    .card-subtitle {
        text-align: center;
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 32px;
    }

    .form-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #4A4A4A;
        margin-bottom: 7px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .form-label i { color: #9A9590; font-size: 0.8rem; }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 0.93rem;
        color: var(--text-dark);
        transition: all 0.2s;
    }
    .form-control::placeholder { color: #C0BAB4; }
    .form-control:focus {
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 4px rgba(255, 94, 43, 0.1);
        outline: none;
    }
    .form-control.is-invalid { border-color: #dc3545; }

    .input-group .form-control {
        border-right: none;
        border-radius: 8px 0 0 8px;
    }
    .input-group .btn-toggle {
        border: 1px solid var(--border-color);
        border-left: none;
        border-radius: 0 8px 8px 0;
        background: #fff;
        color: var(--text-muted);
        padding: 0 14px;
        transition: color 0.2s;
    }
    .input-group .btn-toggle:hover { color: var(--brand-primary); }
    .input-group:focus-within .btn-toggle { border-color: var(--brand-primary); }

    .btn-login {
        width: 100%;
        background: var(--brand-primary);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 13px;
        font-size: 1rem;
        font-weight: 600;
        margin-top: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.25s;
        box-shadow: 0 4px 12px rgba(255, 94, 43, 0.2);
    }
    .btn-login:hover {
        background: var(--brand-hover);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(255, 94, 43, 0.3);
    }
    .btn-login:active { transform: translateY(1px); }

    .site-footer {
        border-top: 1px solid rgba(0,0,0,0.05);
        padding: 20px 40px;
        font-size: 0.82rem;
        color: var(--text-muted);
        background: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .site-footer a {
        color: var(--text-muted);
        text-decoration: none;
        margin-left: 16px;
        transition: color 0.2s;
    }
    .site-footer a:hover { color: var(--brand-primary); }
</style>
@endpush

@section('content')

    <header class="site-header">
        <a href="#" class="brand">Skills Hut Ltd <span>|</span> HRM</a>
        <nav class="header-nav">
            <a href="#">Support</a>
            <a href="#">Privacy</a>
        </nav>
    </header>

    <main>
        <div class="login-card">

            <div class="brand-icon">
                <i class="fa-solid fa-building"></i>
            </div>

            <h1 class="card-title">Welcome Back</h1>
            <p class="card-subtitle">Skills Hut HRM — Admin Portal</p>

            {{-- Error message --}}
            @if (session('error'))
                <div class="alert alert-danger py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Success message --}}
            @if (session('success'))
                <div class="alert alert-success py-2 px-3 mb-3 rounded-3" style="font-size:0.88rem;">
                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fa-solid fa-envelope"></i> Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="example@skillshut.com"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fa-solid fa-lock"></i> Password
                    </label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="btn-toggle" onclick="togglePassword()">
                            <i class="fa-regular fa-eye" id="toggle-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    Sign In <i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>
        </div>
    </main>

    <footer class="site-footer">
        <div>
            <span style="color: var(--text-dark); font-weight: 700;">Skills Hut Ltd | HRM</span>
            <span class="ms-2" style="color: #B2ADA7;">© 2025 Skills Hut Ltd. All rights reserved.</span>
        </div>
        <div>
            <a href="#">Terms of Service</a>
            <a href="#">Contact Us</a>
        </div>
    </footer>

@endsection

@push('scripts')
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('toggle-icon');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.classList.toggle('fa-eye', !isHidden);
        icon.classList.toggle('fa-eye-slash', isHidden);
    }
</script>
@endpush