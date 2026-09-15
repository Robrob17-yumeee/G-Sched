<aside id="sidebar" class="sidebar" style="width: 260px; flex-shrink: 0;">
    <nav class="px-3 py-3">
        <ul class="nav flex-column gap-1">
            @if(auth()->user()->isStudent())
                <li class="nav-item">
                    <span class="text-uppercase small text-muted px-3 py-2" style="letter-spacing: 0.05em; font-size: 0.7rem; color: var(--navy);">STUDENT</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2 fs-5"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.schedules*') ? 'active' : '' }}" href="{{ route('student.schedules') }}">
                        <i class="bi bi-calendar-week me-2 fs-5"></i>Available Schedules
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.appointments*') ? 'active' : '' }}" href="{{ route('student.appointments.index') }}">
                        <i class="bi bi-calendar-check me-2 fs-5"></i>My Appointments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.notifications*') ? 'active' : '' }}" href="{{ route('student.notifications') }}">
                        <i class="bi bi-bell me-2 fs-5"></i>Notifications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.feedback*') ? 'active' : '' }}" href="{{ route('student.feedback.index') }}">
                        <i class="bi bi-chat-text me-2 fs-5"></i>Feedback
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                        <i class="bi bi-person me-2 fs-5"></i>Profile
                    </a>
                </li>

            @elseif(auth()->user()->isGuidanceAssociate())
                <li class="nav-item">
                    <span class="text-uppercase small text-muted px-3 py-2" style="letter-spacing: 0.05em; font-size: 0.7rem; color: var(--navy);">GUIDANCE ASSOCIATE</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guidance.dashboard') ? 'active' : '' }}" href="{{ route('guidance.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2 fs-5"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guidance.requests*') ? 'active' : '' }}" href="{{ route('guidance.requests') }}">
                        <i class="bi bi-inbox me-2 fs-5"></i>Appointment Requests
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guidance.appointments*') ? 'active' : '' }}" href="{{ route('guidance.appointments') }}">
                        <i class="bi bi-calendar-check me-2 fs-5"></i>Appointments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guidance.availability*') ? 'active' : '' }}" href="{{ route('guidance.availability') }}">
                        <i class="bi bi-calendar-plus me-2 fs-5"></i>Manage Availability
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guidance.calendar*') ? 'active' : '' }}" href="{{ route('guidance.calendar') }}">
                        <i class="bi bi-calendar3 me-2 fs-5"></i>Calendar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guidance.history*') ? 'active' : '' }}" href="{{ route('guidance.history') }}">
                        <i class="bi bi-clock-history me-2 fs-5"></i>Appointment History
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guidance.notifications*') ? 'active' : '' }}" href="{{ route('guidance.notifications') }}">
                        <i class="bi bi-bell me-2 fs-5"></i>Notifications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                        <i class="bi bi-person me-2 fs-5"></i>Profile
                    </a>
                </li>

            @elseif(auth()->user()->isAdmin())
                <li class="nav-item">
                    <span class="text-uppercase small text-muted px-3 py-2" style="letter-spacing: 0.05em; font-size: 0.7rem; color: var(--navy);">ADMINISTRATOR</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2 fs-5"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people me-2 fs-5"></i>User Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.appointments*') ? 'active' : '' }}" href="{{ route('admin.appointments') }}">
                        <i class="bi bi-calendar-check me-2 fs-5"></i>All Appointments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.schedules*') ? 'active' : '' }}" href="{{ route('admin.schedules') }}">
                        <i class="bi bi-calendar-week me-2 fs-5"></i>Schedules
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.availability*') ? 'active' : '' }}" href="{{ route('admin.availability') }}">
                        <i class="bi bi-calendar-plus me-2 fs-5"></i>Availability
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
                        <i class="bi bi-graph-up me-2 fs-5"></i>Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.logs*') ? 'active' : '' }}" href="{{ route('admin.logs') }}">
                        <i class="bi bi-journal-text me-2 fs-5"></i>Activity Logs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}" href="{{ route('admin.notifications') }}">
                        <i class="bi bi-bell me-2 fs-5"></i>Notifications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                        <i class="bi bi-gear me-2 fs-5"></i>System Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                        <i class="bi bi-person me-2 fs-5"></i>Profile
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</aside>