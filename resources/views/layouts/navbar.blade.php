<nav class="navbar navbar-expand-lg fixed-top shadow-sm" style="background: var(--card-bg); border-bottom: 1px solid var(--border-color);">
    <div class="container-fluid px-3 px-md-4">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}" style="color: var(--navy); font-size: 1.25rem;">
            <i class="bi bi-calendar-check me-2" style="color: var(--medium-blue); font-size: 1.4rem;"></i>G-SCHED
        </a>

        @if(auth()->check())
            <button class="navbar-toggler d-md-none border-0 me-2" type="button" onclick="toggleSidebar()" aria-label="Toggle navigation">
                <i class="bi bi-sidebar" style="font-size: 1.5rem; color: var(--navy);"></i>
            </button>
        @endif

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="border: none;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                @if(auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle position-relative p-2" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--text-muted);">
                            <i class="bi bi-bell fs-4"></i>
                            @if(auth()->user()->unreadNotificationsCount() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge notification-badge" style="background: var(--orange); font-size: 0.7rem; padding: 0.25rem 0.5rem;">
                                    {{ auth()->user()->unreadNotificationsCount() }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationsDropdown" style="min-width: 300px; max-width: 90vw; max-height: 400px; overflow-y: auto; border: none; box-shadow: 0 10px 30px rgba(5, 63, 92, 0.1); border-radius: 1rem;">
                            <li><h6 class="dropdown-header px-3 py-2" style="color: var(--navy); font-weight: 600;">Notifications</h6></li>
                            @foreach(auth()->user()->notifications()->latest()->take(10)->get() as $notification)
                                <li>
                                    <a class="dropdown-item px-3 py-3 {{ !$notification->is_read ? 'fw-bold' : '' }}" href="{{ route('notifications.show', $notification) }}" style="border-bottom: 1px solid var(--border-color-light);">
                                        <div class="d-flex gap-3">
                                            <div class="flex-shrink-0">
                                                <div class="kpi-icon notifications" style="width: 36px; height: 36px;">
                                                    <i class="bi {{ $notification->icon }} fs-5" style="color: var(--medium-blue);"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small fw-medium" style="color: var(--navy);">{{ $notification->title }}</div>
                                                <div class="small text-muted">{{ $notification->message }}</div>
                                                <div class="small" style="color: #64748B;">{{ $notification->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            <li><hr class="dropdown-divider mx-3" style="border-color: var(--border-color-light);"></li>
                            <li><a class="dropdown-item px-3 py-2 text-center" href="{{ auth()->user()->isAdmin() ? route('admin.notifications') : (auth()->user()->isGuidanceAssociate() ? route('guidance.notifications') : route('student.notifications')) }}" style="color: var(--medium-blue); font-weight: 500;">View All Notifications</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--navy);">
                            <div class="avatar-sm">{{ auth()->user()->first_name[0] }}</div>
                            <span class="fw-medium d-none d-md-inline">{{ auth()->user()->first_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown" style="min-width: 200px; max-width: 90vw; border: none; box-shadow: 0 10px 30px rgba(5, 63, 92, 0.1); border-radius: 1rem;">
                            <li><a class="dropdown-item px-3 py-2" href="{{ route('profile') }}"><i class="bi bi-person me-2" style="color: var(--text-muted);"></i>Profile</a></li>
                            <li><a class="dropdown-item px-3 py-2" href="{{ route('password.change') }}"><i class="bi bi-key me-2" style="color: var(--text-muted);"></i>Change Password</a></li>
                            <li><hr class="dropdown-divider mx-2" style="border-color: var(--border-color-light);"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item px-3 py-2" style="color: var(--orange);"><i class="bi bi-box-arrow-right me-2" style="color: var(--orange);"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>