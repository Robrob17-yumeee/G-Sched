    <nav class="navbar navbar-expand-lg fixed-top shadow-sm" style="background: #2148db; border-bottom: 1px solid var(--border-color);">
    <div class="container-fluid px-3 px-md-4">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}" style="color: #FFD200; font-size: 1.25rem;">
            <img src="{{ asset('images/navbar-calendar.png') }}" alt="G-SCHED" class="avatar-sm me-2" style="width: 36px; height: 36px; object-fit: cover; border-radius: 50%;">
            @if(auth()->check() && auth()->user()->school && file_exists(public_path('images/school-' . auth()->user()->school . '.png')))
                <img src="{{ asset('images/school-' . auth()->user()->school . '.png') }}" alt="{{ auth()->user()->school }}" class="avatar-sm me-2" style="width: 36px; height: 36px; object-fit: cover; border-radius: 50%;">
            @endif
            G-SCHED
        </a>

        @if(auth()->check())
            <button class="navbar-toggler d-md-none border-0 me-2" type="button" onclick="toggleSidebar()" aria-label="Toggle navigation">
                <i class="bi bi-sidebar" style="font-size: 1.5rem; color: #FFD200;"></i>
            </button>
        @endif

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="border: none;">
            <span class="navbar-toggler-icon" style="background-image: url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 2' fill='%23FFD200'%3e%3cpath stroke='%23FFD200' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M0 1h30M0 1h30M0 1h30'/%3e%3c/svg%3e\") !important;"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                @if(auth()->check())
                    <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle position-relative p-2" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #FFD200;">
                             <div class="position-relative d-inline-block">
                                 <i class="bi bi-bell fs-4" style="color: #FFD200;"></i>
                                 @if(auth()->user()->unreadNotificationsCount() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill notification-badge" style="background: #FFD200; color: #053F5C; font-size: 0.65rem; padding: 0.25rem 0.5rem; min-width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
                                        {{ auth()->user()->unreadNotificationsCount() }}
                                    </span>
                                 @endif
                             </div>
                         </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationsDropdown" style="min-width: 300px; max-width: 90vw; max-height: 400px; overflow-y: auto; border: none; box-shadow: 0 10px 30px rgba(5, 63, 92, 0.1); border-radius: 1rem;">
                            <li><h6 class="dropdown-header px-3 py-2" style="color: #FFD200; font-weight: 600;">Notifications</h6></li>
                            @foreach(auth()->user()->notifications()->latest()->take(10)->get() as $notification)
                                <li>
                                    <a class="dropdown-item px-3 py-3 {{ !$notification->is_read ? 'fw-bold' : '' }}" href="{{ route('notifications.show', $notification) }}" style="border-bottom: 1px solid var(--border-color-light);">
                                        <div class="d-flex gap-3">
                                            <div class="flex-shrink-0">
                                                <div class="kpi-icon notifications" style="width: 36px; height: 36px;">
                                                    <i class="bi {{ $notification->icon }} fs-5" style="color: #FFD200;"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small fw-medium" style="color: #FFD200;">{{ $notification->title }}</div>
                                                <div class="small text-muted">{{ $notification->message }}</div>
                                                <div class="small" style="color: #FFFFFF;">{{ $notification->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            <li><hr class="dropdown-divider mx-3" style="border-color: var(--border-color-light);"></li>
                            <li><a class="dropdown-item px-3 py-2 text-center" href="{{ auth()->user()->isAdmin() ? route('admin.notifications') : (auth()->user()->isGuidanceAssociate() ? route('guidance.notifications') : route('student.notifications')) }}" style="color: #FFD200; font-weight: 500;">View All Notifications</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #FFD200;">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="avatar-sm">
                            @else
                                <div class="avatar-sm">{{ auth()->user()->first_name[0] }}</div>
                            @endif
                            <span class="fw-medium d-none d-md-inline">{{ auth()->user()->first_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown" style="min-width: 200px; max-width: 90vw; border: none; box-shadow: 0 10px 30px rgba(5, 63, 92, 0.1); border-radius: 1rem;">
                            <li><a class="dropdown-item px-3 py-2" href="{{ route('profile') }}"><i class="bi bi-person me-2" style="color: #FFD200;"></i>Profile</a></li>
                            <li><a class="dropdown-item px-3 py-2" href="{{ route('password.change') }}"><i class="bi bi-key me-2" style="color: #FFD200;"></i>Change Password</a></li>
                            <hr class="dropdown-divider mx-2" style="border-color: var(--border-color-light);">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item px-3 py-2" style="color: #FFD200;"><i class="bi bi-box-arrow-right me-2" style="color: #FFD200;"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>