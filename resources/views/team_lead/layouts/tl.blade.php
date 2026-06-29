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
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 10px 15px;
            margin-top: -65px;
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 0;
            border: none;
        }

        .brand-title {
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            color: #888;
        }

        .sidebar-nav {
            padding-top: 0;
            margin-top: -20px !important;
            list-style: none;
            padding-left: 0;
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
            margin-bottom: 4px;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255, 94, 43, 0.1);
            color: #FF5E2B;
            transform: translateX(2px);
        }

        .sidebar-nav .nav-link:hover i {
            color: #FF5E2B;
        }

        .sidebar-nav .nav-link.active {
            background: #FF5E2B;
            color: #FFFFFF;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(255, 94, 43, 0.25);
        }

        .sidebar-nav .nav-link.active i {
            color: #FFFFFF;
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

        .topbar-welcome {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .topbar-welcome .welcome-text {
            font-size: 0.92rem;
            color: #1A1A1A;
            font-weight: 500;
        }

        .topbar-welcome .welcome-text strong {
            color: #FF5E2B;
            font-weight: 700;
        }

        .notif-dropdown {
            width: 380px;
            padding: 0;
            border: 1px solid #E2E0DD;
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.12);
            overflow: hidden;
            background: #FFFFFF;
        }

        .notif-header {
            padding: 16px 20px;
            border-bottom: 1px solid #F4F4F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #FAFAFA 0%, #FFFFFF 100%);
        }

        .notif-header-title {
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: #1A1A1A;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notif-count-badge {
            background: linear-gradient(135deg, #FF5E2B 0%, #E04B1A 100%);
            color: #FFFFFF;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
            min-width: 20px;
            text-align: center;
        }

        .notif-mark-all {
            font-size: 0.75rem;
            font-weight: 600;
            color: #FF5E2B;
            text-decoration: none;
            cursor: pointer;
            background: none;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .notif-mark-all:hover {
            background: rgba(255, 94, 43, 0.08);
            text-decoration: none;
        }

        .notif-list {
            max-height: 360px;
            overflow-y: auto;
        }

        .notif-list::-webkit-scrollbar { width: 5px; }
        .notif-list::-webkit-scrollbar-track { background: #FAFAFA; }
        .notif-list::-webkit-scrollbar-thumb { background: #E2E0DD; border-radius: 4px; }
        .notif-list::-webkit-scrollbar-thumb:hover { background: #D0CBC5; }

        .notif-item {
            padding: 14px 20px;
            border-bottom: 1px solid #F4F4F0;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transition: all 0.2s ease;
            cursor: pointer;
            position: relative;
        }

        .notif-item:last-child { border-bottom: none; }
        .notif-item:hover { background: #FAF9F6; }

        .notif-item.unread {
            background: #FFF8F5;
            border-left: 3px solid #FF5E2B;
        }

        .notif-item.unread:hover { background: #FFF0EB; }

        .notif-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            transition: transform 0.2s;
        }

        .notif-item:hover .notif-icon { transform: scale(1.05); }

        .notif-icon.submitted { background: linear-gradient(135deg, #EBF3FF 0%, #D6E4FF 100%); color: #2563EB; }
        .notif-icon.recommended { background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); color: #059669; }
        .notif-icon.not_recommended { background: linear-gradient(135deg, #FEF2F2 0%, #FEE2E2 100%); color: #DC2626; }
        .notif-icon.approved { background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); color: #059669; }
        .notif-icon.rejected { background: linear-gradient(135deg, #FEF2F2 0%, #FEE2E2 100%); color: #DC2626; }
        .notif-icon.default { background: linear-gradient(135deg, #F4F4F0 0%, #E8E8E4 100%); color: #7F7F7F; }

        .notif-body { flex: 1; min-width: 0; }

        .notif-msg {
            font-size: 0.82rem;
            color: #1A1A1A;
            line-height: 1.5;
            margin-bottom: 4px;
            font-weight: 400;
        }

        .notif-msg.unread { font-weight: 600; color: #0A0A0A; }

        .notif-time {
            font-size: 0.72rem;
            color: #7F7F7F;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .notif-time::before { content: '🕐'; font-size: 0.7rem; }

        .notif-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF5E2B 0%, #E04B1A 100%);
            flex-shrink: 0;
            margin-top: 6px;
            box-shadow: 0 0 0 3px rgba(255, 94, 43, 0.15);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 3px rgba(255, 94, 43, 0.15); }
            50% { box-shadow: 0 0 0 6px rgba(255, 94, 43, 0.1); }
        }

        .notif-footer {
            padding: 14px 20px;
            border-top: 1px solid #F4F4F0;
            text-align: center;
            background: linear-gradient(135deg, #FAFAFA 0%, #FFFFFF 100%);
        }

        .notif-footer a {
            font-size: 0.82rem;
            font-weight: 600;
            color: #FF5E2B;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .notif-footer a:hover {
            background: rgba(255, 94, 43, 0.08);
            text-decoration: none;
        }

        .notif-footer a::after {
            content: '→';
            font-size: 1rem;
            transition: transform 0.2s;
        }

        .notif-footer a:hover::after { transform: translateX(3px); }

        .notif-empty {
            padding: 40px 20px;
            text-align: center;
            color: #7F7F7F;
            font-size: 0.85rem;
        }

        .notif-empty i {
            font-size: 2.5rem;
            color: #E2E0DD;
            display: block;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        .notif-empty-text { font-weight: 500; color: #9A9590; }

        /* ============================================
           MOBILE SIDEBAR TOGGLE (Phone Only)
           ============================================ */
        
        /* Hamburger button - hidden by default, shown only on mobile */
        .mobile-sidebar-toggle {
            display: none;
            background: none;
            border: 1px solid #E2E0DD;
            border-radius: 8px;
            color: #4A4A4A;
            width: 38px;
            height: 38px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            padding: 0;
            font-size: 1.3rem;
            flex-shrink: 0;
            margin-right: 10px;
        }

        .mobile-sidebar-toggle:hover {
            background: #FAF9F6;
            color: #FF5E2B;
            border-color: #FF5E2B;
        }

        /* Close button inside sidebar - hidden by default, shown only on mobile when open */
        .sidebar-close-btn {
            display: none;
            position: absolute;
            top: 12px;
            right: 12px;
            background: #fff;
            border: 1px solid #E2E0DD;
            border-radius: 8px;
            color: #4A4A4A;
            width: 32px;
            height: 32px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            padding: 0;
            font-size: 1.1rem;
            z-index: 10;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }

        .sidebar-close-btn:hover {
            background: #FEF2F2;
            color: #DC2626;
            border-color: #DC2626;
        }

        /* Overlay - hidden by default */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 100;
            backdrop-filter: blur(2px);
        }

        /* ===== Mobile Styles ===== */
        @media (max-width: 767.98px) {
            .app-header {
                left: 0;
                padding: 0 16px;
                height: 60px;
            }

            .app-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                box-shadow: none;
                width: 260px;
                z-index: 1050;
                padding-top: 50px;
            }

            .main-wrapper {
                margin-left: 0;
                padding-top: 60px;
            }

            .app-content {
                padding: 20px 16px;
            }

            /* Show hamburger button on mobile */
            .mobile-sidebar-toggle {
                display: flex;
            }

            /* Show close button inside sidebar when open */
            body.sidebar-open .sidebar-close-btn {
                display: flex;
            }

            /* Sidebar open state */
            body.sidebar-open .app-sidebar {
                transform: translateX(0);
                box-shadow: 2px 0 16px rgba(0,0,0,0.15);
            }

            /* Show overlay when sidebar open */
            body.sidebar-open .sidebar-overlay {
                display: block;
            }

            /* Adjust brand on mobile */
            .sidebar-brand {
                margin-top: 0;
                padding: 10px;
            }

            .brand-logo {
                width: 50px;
                height: 50px;
            }

            /* Hide search on mobile to save space - profile stays visible */
            .header-search {
                display: none;
            }

            /* Hide welcome text on mobile to save space */
            .topbar-welcome {
                display: none;
            }

            /* Profile and notification stay EXACTLY as they are */
            .profile-name, .profile-role, .profile-avatar {
                /* No changes - keep as is */
            }
        }

        /* ===== Desktop Styles - No changes ===== */
        @media (min-width: 768px) {
            .sidebar-overlay {
                display: none !important;
            }
            .mobile-sidebar-toggle {
                display: none !important;
            }
            .sidebar-close-btn {
                display: none !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="app-container">

        {{-- Mobile Sidebar Overlay --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        @include('team_lead.layouts.header')

        <div class="main-wrapper">

            @include('team_lead.layouts.sidebar')

            <main class="app-content">
                @yield('content')
            </main>

        </div>

        @include('team_lead.layouts.footer')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        // Mobile Sidebar Toggle Functionality
        (function() {
            const overlay = document.getElementById('sidebarOverlay');
            const body = document.body;
            let isAnimating = false;

            function openSidebar() {
                if (window.innerWidth >= 768) return;
                body.classList.add('sidebar-open');
                isAnimating = true;
                setTimeout(function() { isAnimating = false; }, 300);
            }

            function closeSidebar() {
                body.classList.remove('sidebar-open');
            }

            // Handle hamburger and close button clicks
            document.addEventListener('click', function(e) {
                const hamburger = e.target.closest('.mobile-sidebar-toggle');
                const closeBtn = e.target.closest('.sidebar-close-btn');

                if (hamburger) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    
                    if (body.classList.contains('sidebar-open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                    return false;
                }

                if (closeBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    closeSidebar();
                    return false;
                }
            }, true);

            // Overlay click - only close if not animating
            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    if (isAnimating) {
                        e.stopPropagation();
                        return;
                    }
                    if (body.classList.contains('sidebar-open')) {
                        closeSidebar();
                    }
                });
            }

            // Prevent clicks inside sidebar from closing it
            document.addEventListener('click', function(e) {
                if (body.classList.contains('sidebar-open') && window.innerWidth < 768) {
                    if (e.target.closest('.app-sidebar')) {
                        e.stopPropagation();
                    }
                }
            }, true);

            // Close sidebar when clicking any nav link on mobile
            document.querySelectorAll('.sidebar-nav .nav-link, .sidebar-nav .sub-link, .sidebar-bottom .nav-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }
                });
            });

            // Auto close sidebar if window resized to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    closeSidebar();
                }
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>