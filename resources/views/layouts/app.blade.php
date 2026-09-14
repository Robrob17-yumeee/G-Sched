<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'G-SCHED') }} @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    @yield('styles')
    <style>
        :root {
            /* G-SCHED Official Color Palette */
            --navy: #053F5C;
            --medium-blue: #429EBD;
            --light-blue: #9FE7F5;
            --yellow: #F7AD19;
            --orange: #F27F0C;
            
            /* Semantic colors */
            --text-primary: #053F5C;
            --text-secondary: #475569;
            --text-muted: #64748B;
            
            /* Backgrounds */
            --bg-light: #F7FAFC;
            --card-bg: #FFFFFF;
            
            /* Borders */
            --border-color: #E2E8F0;
            --border-color-light: #F1F5F9;
            
            /* Shadow */
            --shadow-sm: 0 1px 3px rgba(5, 63, 92, 0.08), 0 1px 2px rgba(5, 63, 92, 0.05);
        }

        body {
            margin-top: 76px;
            font-family: 'Inter', 'Roboto', sans-serif;
            font-size: clamp(0.875rem, 0.85vw + 0.8rem, 1rem);
        }

        .row.g-4 { --bs-gutter-y: 1.5rem; }

        img {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            h1.h2 { font-size: 1.5rem; }
            h1.h1 { font-size: 1.75rem; }
            h2 { font-size: 1.25rem; }
            h3 { font-size: 1.1rem; }
            h4 { font-size: 1rem; }
            h5 { font-size: 0.95rem; }
            h6 { font-size: 0.85rem; }
        }

        @media (min-width: 576px) and (max-width: 768px) {
            h1.h2 { font-size: 1.75rem; }
            h1.h1 { font-size: 2rem; }
            h2 { font-size: 1.4rem; }
            h3 { font-size: 1.2rem; }
            h4 { font-size: 1.05rem; }
            h5 { font-size: 0.95rem; }
        }

        .sidebar-wrapper {
            position: relative;
        }

        @media (max-width: 767.98px) {
            .sidebar-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                overflow-y: auto;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                box-shadow: 2px 0 10px rgba(5, 63, 92, 0.15);
                background: #FFFFFF;
            }

            .sidebar-wrapper.show {
                transform: translateX(0);
            }
        }

        @media (min-width: 768px) {
            .sidebar-wrapper {
                position: relative;
                transform: none !important;
                height: auto;
                z-index: 0;
                box-shadow: none;
            }
        }

        .sidebar .nav-link {
            padding: 0.75rem 1rem;
            margin: 0.125rem 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: rgba(159, 231, 245, 0.15);
            color: var(--medium-blue);
        }

        .sidebar .nav-link.active {
            background: rgba(159, 231, 245, 0.25);
            color: var(--medium-blue);
            font-weight: 500;
        }

        @media (max-width: 767.98px) {
            .sidebar .nav-link {
                padding: 0.85rem 1.25rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .sidebar .nav-link {
                padding: 1rem 1.25rem;
                font-size: 1.1rem;
            }
        }

        /* Bootstrap button overrides to use G-SCHED palette */
        .btn-primary {
            background-color: var(--medium-blue);
            border-color: var(--medium-blue);
            color: #FFFFFF;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #3a8ca8;
            border-color: #3a8ca8;
            color: #FFFFFF;
        }
        .btn-secondary {
            background-color: var(--border-color);
            border-color: var(--border-color);
            color: var(--navy);
        }
        .btn-secondary:hover, .btn-secondary:focus {
            background-color: var(--navy);
            border-color: var(--navy);
            color: #FFFFFF;
        }
        .btn-success {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--navy);
        }
        .btn-success:hover, .btn-success:focus {
            background-color: #7fc7d9;
            border-color: #7fc7d9;
            color: var(--navy);
        }
        .btn-warning {
            background-color: var(--yellow);
            border-color: var(--yellow);
            color: var(--navy);
        }
        .btn-warning:hover, .btn-warning:focus {
            background-color: #db9a00;
            border-color: #db9a00;
            color: var(--navy);
        }
        .btn-danger {
            background-color: var(--orange);
            border-color: var(--orange);
            color: var(--navy);
        }
        .btn-danger:hover, .btn-danger:focus {
            background-color: #d97300;
            border-color: #d97300;
            color: var(--navy);
        }
        .btn-info {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--navy);
        }
        .btn-info:hover, .btn-info:focus {
            background-color: #7fc7d9;
            border-color: #7fc7d9;
            color: var(--navy);
        }

        /* Badge overrides */
        .badge.bg-primary { background-color: var(--medium-blue) !important; color: #FFFFFF !important; }
        .badge.bg-secondary { background-color: var(--navy) !important; color: #FFFFFF !important; }
        .badge.bg-success { background-color: var(--light-blue) !important; color: var(--navy) !important; }
        .badge.bg-warning { background-color: var(--yellow) !important; color: var(--navy) !important; }
        .badge.bg-danger { background-color: var(--orange) !important; color: var(--navy) !important; }
        .badge.bg-info { background-color: var(--light-blue) !important; color: var(--navy) !important; }

        /* Text color overrides */
        .text-primary { color: var(--medium-blue) !important; }
        .text-warning { color: var(--yellow) !important; }
        .text-success { color: var(--light-blue) !important; }
        .text-danger { color: var(--orange) !important; }
        .text-info { color: var(--light-blue) !important; }
        .text-secondary { color: var(--text-muted) !important; }

        /* Table header background */
        thead.bg-light {
            background-color: var(--bg-light);
        }

        /* Alert overrides */
        .alert-success { background-color: rgba(159, 231, 245, 0.2); color: var(--navy); }
        .alert-danger { background-color: rgba(242, 127, 12, 0.2); color: var(--navy); }
        .alert-warning { background-color: rgba(247, 173, 25, 0.2); color: var(--navy); }
        .alert-info { background-color: rgba(159, 231, 245, 0.2); color: var(--navy); }

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 767.98px) {
            .sidebar-overlay {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }

             .sidebar-overlay.hidden {
                display: none;
            }
        }

        @media (max-width: 767.98px) {
            body {
                margin-top: 56px;
                padding-bottom: 70px;
            }
        }

        @media (min-width: 768px) {
            body {
                margin-top: 76px;
                padding-bottom: 0;
            }
        }

        /* Mobile Bottom Navigation */
        @media (max-width: 767.98px) {
            .mobile-bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: var(--card-bg);
                border-top: 1px solid var(--border-color-light);
                box-shadow: 0 -2px 8px rgba(0,0,0,0.05);
                z-index: 1030;
                display: flex;
                justify-content: space-around;
                align-items: center;
                padding-top: 8px;
                padding-bottom: 8px;
                padding-bottom: calc(8px + env(safe-area-inset-bottom, 0px));
            }

            .mobile-bottom-nav .nav-item {
                flex: 1;
                text-align: center;
            }

            .mobile-bottom-nav .nav-link {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 6px 4px;
                color: var(--text-muted);
                font-size: 10px;
                font-weight: 500;
                text-decoration: none;
                border-radius: 0;
                min-width: 44px;
                min-height: 44px;
            }

            .mobile-bottom-nav .nav-link.active {
                color: var(--medium-blue);
            }

            .mobile-bottom-nav .nav-link i {
                font-size: 20px;
                margin-bottom: 2px;
            }

            .mobile-bottom-nav .nav-link.active i {
                color: var(--medium-blue);
            }

            .mobile-content {
                padding-bottom: 80px;
            }

            .px-md-4 {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
        }
    </style>
</head>
    <body>
    @include('layouts.navbar')

    <div class="d-flex">
        <div id="sidebarOverlay" class="sidebar-overlay hidden" onclick="toggleSidebar()"></div>

        @if(auth()->check())
            <div id="sidebarWrapper" class="sidebar-wrapper">
                @include('layouts.sidebar')
            </div>
        @endif

        <main class="px-md-4 flex-grow-1 {{ auth()->check() && auth()->user()->isStudent() ? 'mobile-content' : '' }}" style="min-width: 0;">
            @yield('content')
        </main>
    </div>

    @if(auth()->check() && auth()->user()->isStudent())
    <nav class="mobile-bottom-nav d-md-none">
        <div class="nav-item">
            <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Home</span>
            </a>
        </div>
        <div class="nav-item">
            <a class="nav-link {{ request()->routeIs('student.appointments*') ? 'active' : '' }}" href="{{ route('student.appointments.index') }}">
                <i class="bi bi-calendar-check"></i>
                <span>Appointments</span>
            </a>
        </div>
        <div class="nav-item">
            <a class="nav-link {{ request()->routeIs('student.notifications*') || request()->routeIs('notifications.show') ? 'active' : '' }}" href="{{ route('student.notifications') }}">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
            </a>
        </div>
        <div class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </div>
    </nav>
    @endif

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarWrapper');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('hidden');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @yield('scripts')
</body>
</html>
