<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Skills Hut Ltd HRM')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * { box-sizing: border-box; }

        body { margin: 0; padding: 0; background: #F4F4F0; font-family: 'Inter', sans-serif; }

     .app-container {
    min-height: 100vh;
    background: #F4F4F0;
}

.app-header {
    position: fixed;
    top: 0;
    left: 200px;
    right: 0;
    z-index: 100;
    height: 65px;
    background: #FFFFFF;
    border-bottom: 1px solid #E2E0DD;
}

.app-sidebar {
    width: 200px;
    background: white;
    display: flex;
    flex-direction: column;
    padding: 24px 12px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    overflow-y: auto;
    z-index: 101;
}

.main-wrapper {
    margin-left: 200px;
    padding-top: 65px;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.app-content {
    flex: 1;
    min-width: 0;
    padding: 28px 32px;
    background: #F4F4F0;
}
        /* Sidebar */
        .sidebar-brand {
    display: flex;
    align-items: center;
    padding: 0 8px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    margin-bottom: 8px;
}

.brand-logo {
    width: 36px;
    height: 36px;
    background: #FF5E2B;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.brand-title {
    font-family: 'Outfit', sans-serif;
    font-size: 0.88rem;
    font-weight: 700;
    color: #BDBDBD;
    line-height: 1.2;
}

.brand-subtitle {
    font-size: 0.65rem;
    color: #8F8F8F;
    letter-spacing: 1px;
}

.sidebar-nav .nav-link {
    color: #A6A6A6;
    font-size: 0.85rem;
    font-weight: 500;
    border-radius: 8px;
    padding: 9px 10px;
    display: flex;
    align-items: center;
    transition: all 0.2s;
    margin-bottom: 2px;
}

.sidebar-nav .nav-link:hover {
    color: #DADADA;
    background: rgba(255,255,255,0.07);
}

.sidebar-nav .nav-link.active {
    color: #FFFFFF;
    background: #FF5E2B;
}

.sidebar-nav .nav-link i {
    font-size: 1rem;
    width: 20px;
    color: inherit;
}

.sidebar-divider {
    border-color: rgba(255,255,255,0.08);
}

.sidebar-bottom .nav-link {
    color: #A6A6A6;
    font-size: 0.85rem;
    font-weight: 500;
    border-radius: 8px;
    padding: 9px 10px;
    display: flex;
    align-items: center;
    transition: all 0.2s;
}

.sidebar-nav .sub-link {
   
    font-size: 0.82rem;
    font-weight: 500;
    border-radius: 8px;
    padding: 7px 10px;
    display: flex;
    align-items: center;
    transition: all 0.2s;
    margin-bottom: 2px;
}
.sidebar-nav .sub-link:hover {  background: rgba(255,255,255,0.07); }
.sidebar-nav .sub-link.active { color: #fff; background: rgba(255,94,43,0.5); }

.sidebar-bottom .nav-link:hover {
    color: #DADADA;
    background: rgba(255,255,255,0.07);
}
        /* Header */
        .header-search { position: relative; width: 280px; }
        .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9A9590; font-size: 0.88rem; z-index: 1; }
        .form-control-search { padding-left: 36px; border: 1px solid #E2E0DD; border-radius: 8px; font-size: 0.85rem; background: #FAF9F6; }
        .form-control-search:focus { border-color: #FF5E2B; box-shadow: 0 0 0 3px rgba(255,94,43,0.1); background: #fff; }
        .btn-control { background: none; border: 1px solid #E2E0DD; border-radius: 8px; color: #4A4A4A; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; padding: 0; }
        .btn-control:hover { background: #FAF9F6; color: #FF5E2B; border-color: #FF5E2B; }
        .notification-dot { width: 8px; height: 8px; padding: 0; }
        .profile-name { font-size: 0.85rem; color: #1A1A1A; }
        .profile-role { font-size: 0.7rem; color: #FF5E2B; letter-spacing: 0.5px; }
        .profile-avatar { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }
        .border-brand { border-color: #FF5E2B !important; }
        .text-brand { color: #FF5E2B !important; }
        .dropdown-menu { border-radius: 10px; font-size: 0.85rem; }
        .dropdown-item:hover { background: #FAF9F6; color: #FF5E2B; }

        /* Dashboard */
        .page-title { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 700; color: #1A1A1A; }
        .page-subtitle { font-size: 0.88rem; color: #7F7F7F; }
        .kpi-card { border-radius: 12px; background: #fff; transition: transform 0.2s; }
        .kpi-card:hover { transform: translateY(-2px); }
        .kpi-label { font-size: 0.72rem; letter-spacing: 0.8px; }
        .kpi-value { font-size: 2.2rem; font-weight: 700; font-family: 'Outfit', sans-serif; color: #1A1A1A; }
        .btn-brand { background-color: #FF5E2B; color: #fff; border: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; }
        .btn-brand:hover { background-color: #E04B1A; color: #fff; }
        .btn-outline-custom { border: 1px solid #E2E0DD; color: #4A4A4A; border-radius: 8px; font-weight: 600; font-size: 0.85rem; background: #fff; }
        .btn-outline-custom:hover { background-color: #FAF9F6; }

        .app-footer {
    width: 100%;
    background: #FFFFFF;
    border-top: 1px solid #E2E0DD;
    padding: 14px 32px;
    text-align: center;
    color: #7F7F7F;
}
    </style>

    @stack('styles')
</head>

<body>
    <div class="app-container">

        @include('hr.layouts.header')

        <div class="main-wrapper">

            @include('hr.layouts.sidebar')

            <main class="app-content">
                @yield('content')
            </main>

        </div>

        @include('hr.layouts.footer')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>