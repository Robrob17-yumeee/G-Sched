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

            /* Navbar & Sidebar */
            --navbar-height: 76px;
            --sidebar-bg: #FFFFFF;
            --sidebar-border: #E2E8F0;
            --sidebar-collapsed-width: 76px;
            --sidebar-expanded-width: 250px;
            
            /* Shadow */
            --shadow-sm: 0 1px 3px rgba(5, 63, 92, 0.08), 0 1px 2px rgba(5, 63, 92, 0.05);
        }

        .navbar {
            height: var(--navbar-height);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 2'><path fill='%23FFA62B' d='M0 0h30v2H0zM0 6h30v2H0zM0 12h30v2H0z'></svg>");
        }

        body {
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
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            width: var(--sidebar-collapsed-width);
            min-width: var(--sidebar-collapsed-width);
            max-width: var(--sidebar-collapsed-width);
            height: calc(100vh - var(--navbar-height));
            z-index: 1050;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: width 0.3s ease, min-width 0.3s ease, max-width 0.3s ease, box-shadow 0.3s ease;
        }

        @media (min-width: 768px) and (hover: hover) {
            .sidebar-wrapper:hover {
                width: var(--sidebar-expanded-width);
                min-width: var(--sidebar-expanded-width);
                max-width: var(--sidebar-expanded-width);
                box-shadow: 0 0 24px rgba(5, 63, 92, 0.12);
            }
        }

        body.has-sidebar .main-content {
            margin-left: var(--sidebar-collapsed-width) !important;
        }

        @media (max-width: 767.98px) {
            .sidebar-wrapper {
                top: var(--navbar-height);
                width: var(--sidebar-collapsed-width);
                min-width: var(--sidebar-collapsed-width);
                max-width: var(--sidebar-collapsed-width);
                height: calc(100vh - var(--navbar-height));
                transform: none;
                transition: width 0.3s ease, min-width 0.3s ease, max-width 0.3s ease, box-shadow 0.3s ease;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            }

            .sidebar-wrapper.show {
                width: 260px;
                min-width: 260px;
                max-width: 260px;
            }

            body.has-sidebar .main-content {
                margin-left: var(--sidebar-collapsed-width) !important;
            }
        }

        @media (min-width: 768px) {
            .sidebar-wrapper {
                top: var(--navbar-height);
                height: calc(100vh - var(--navbar-height));
                transform: none !important;
            }
        }

        /* Collapsed sidebar text/icon visibility */
        @media (min-width: 768px) {
            .sidebar-wrapper:not(:hover) .sidebar-text,
            .sidebar-wrapper:not(:hover) .sidebar-label {
                opacity: 0;
                visibility: hidden;
                width: 0;
                white-space: nowrap;
                overflow: hidden;
                transition: opacity 0.1s ease 0.1s, visibility 0.1s ease 0.1s, width 0.1s ease 0.1s;
            }

            .sidebar-wrapper:hover .sidebar-text,
            .sidebar-wrapper:hover .sidebar-label {
                opacity: 1;
                visibility: visible;
                width: auto;
                transition: opacity 0.1s ease 0.2s, visibility 0.1s ease 0.2s, width 0.1s ease 0.2s;
            }

            .sidebar-wrapper .nav-link {
                display: flex;
                align-items: center;
                white-space: nowrap;
            }

            .sidebar-wrapper .sidebar-icon {
                flex-shrink: 0;
                width: 24px;
                text-align: center;
            }
        }

        @media (max-width: 767.98px) {
            .sidebar-wrapper .sidebar-text,
            .sidebar-wrapper .sidebar-label {
                opacity: 1;
                visibility: visible;
                width: auto;
            }
        }

        /* Sidebar content vertical centering */
        .sidebar-wrapper .sidebar {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .sidebar-wrapper .sidebar nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .sidebar-wrapper .sidebar ul.nav {
            display: flex;
            flex-direction: column;
            flex: 1;
            justify-content: flex-start;
            gap: 0.25rem;
            padding-top: 2rem;
        }

        .sidebar-wrapper .sidebar .nav-item:first-child {
            flex-shrink: 0;
            position: absolute;
            top: 1rem;
            left: 0;
            right: 0;
            text-align: left;
            padding-left: 1rem;
        }

        .sidebar-wrapper .sidebar .nav-link {
            justify-content: center;
        }

        .sidebar-wrapper:hover .sidebar .nav-link {
            justify-content: flex-start;
        }

        @media (min-width: 768px) {
            .sidebar-wrapper:not(:hover) .sidebar .nav-link {
                justify-content: center;
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
        }

        /* Main content shifts when sidebar expands on hover */
        .main-content,
        main.main-content {
            margin-left: var(--sidebar-collapsed-width);
            transition: margin-left 0.3s ease;
        }

        /* Sidebar overlay on hover - content stays fixed */
        /* .sidebar-wrapper:hover ~ .main-content {
            margin-left: var(--sidebar-expanded-width) !important;
        } */

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
            background-color: var(--navy);
            border-color: var(--navy);
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
            background-color: #429EBD;
            border-color: #429EBD;
            color: #FFFFFF;
        }
        .btn-success:hover, .btn-success:focus {
            background-color: var(--navy);
            border-color: var(--navy);
            color: #FFFFFF;
        }
        .btn-warning {
            background-color: var(--yellow);
            border-color: var(--yellow);
            color: var(--navy);
        }
        .btn-warning:hover, .btn-warning:focus {
            background-color: var(--orange);
            border-color: var(--orange);
            color: var(--navy);
        }
        .btn-danger {
            background-color: var(--orange);
            border-color: var(--orange);
            color: var(--navy);
        }
        .btn-danger:hover, .btn-danger:focus {
            background-color: var(--orange);
            border-color: var(--orange);
            color: var(--navy);
        }
        .btn-info {
            background-color: #429EBD;
            border-color: #429EBD;
            color: var(--navy);
        }
        .btn-info:hover, .btn-info:focus {
            background-color: var(--navy);
            border-color: var(--navy);
            color: #FFFFFF;
        }

        /* Badge overrides */
        .badge.bg-primary { background-color: var(--medium-blue) !important; color: #FFFFFF !important; }
        .badge.bg-secondary { background-color: var(--navy) !important; color: #FFFFFF !important; }
        .badge.bg-success { background-color: #429EBD !important; color: #FFFFFF !important; }
        .badge.bg-warning { background-color: var(--yellow) !important; color: #053F5C !important; }
        .badge.bg-danger { background-color: var(--orange) !important; color: #053F5C !important; }
        .badge.bg-info { background-color: #429EBD !important; color: #FFFFFF !important; }

        /* Text color overrides */
        .text-primary { color: var(--medium-blue) !important; }
        .text-warning { color: var(--yellow) !important; }
        .text-success { color: #429EBD !important; }
        .text-danger { color: var(--orange) !important; }
        .text-info { color: #429EBD !important; }
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

        /* Unified Primary Action Button - shared across all dashboards */
        .btn-primary-action {
            background-color: #429EBD;
            border: none;
            border-radius: 0.5rem;
            color: #FFFFFF;
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            transition: all 0.2s ease;
            min-height: 44px;
        }
        .btn-primary-action:hover {
            background-color: var(--navy);
        }
        .btn-primary-action:focus {
            background-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(66, 158, 189, 0.3);
        }
        .btn-primary-action i {
            color: #FFFFFF;
        }

        .sidebar-overlay {
            display: none;
        }

        .avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 210, 0, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: #053F5C;
            object-fit: cover;
        }

        .profile-photo-preview {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #e2e8f0;
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
    <body {{ auth()->check() ? 'class="has-sidebar"' : '' }}>
    @if(!@isset($hide_navbar) || !$hide_navbar)
        @include('layouts.navbar')
    @endif

    <div class="d-flex">
        <div id="sidebarOverlay" class="sidebar-overlay hidden" onclick="toggleSidebar()"></div>

        @if(auth()->check())
            <div id="sidebarWrapper" class="sidebar-wrapper">
                @include('layouts.sidebar')
            </div>
        @endif

        <main class="main-content px-md-4 flex-grow-1 {{ auth()->check() && auth()->user()->isStudent() ? 'mobile-content' : '' }}" style="min-width: 0; margin-left: var(--sidebar-collapsed-width);">
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
