@extends('layouts.app')

@section('styles')
<style>
    :root {
        --navy: #053F5C;
        --medium-blue: #429EBD;
        --light-blue: #9FE7F5;
        --yellow: #F7AD19;
        --orange: #F27F0C;
        --bg-light: #F7FAFC;
        --card-bg: #FFFFFF;
        --text-primary: #053F5C;
        --text-muted: #64748B;
        --border-color: #E2E8F0;
        --border-color-light: #F1F5F9;
    }
    
    body {
        background-color: var(--bg-light);
        font-family: 'Inter', 'Roboto', sans-serif;
    }
    
    .card {
        background: var(--card-bg);
        border: none;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(5, 63, 92, 0.08), 0 1px 2px rgba(5, 63, 92, 0.05);
    }
    
    .card-header {
        background: transparent;
        border-bottom: 1px solid var(--border-color-light);
        padding: 1rem 1.5rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .notification-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color-light);
        transition: background 0.2s ease;
    }
    
    .notification-item:last-child {
        border-bottom: none;
    }
    
    .notification-item:hover {
        background: var(--bg-light);
    }
    
    .notification-badge {
        background: var(--orange);
        color: var(--navy);
        font-size: 0.7rem;
        font-weight: 700;
        border-radius: 9999px;
        padding: 0.25rem 0.5rem;
        text-align: center;
    }
    
    .type-badge {
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    
    .type-badge.appointment_request { background: #274be8; color: #FFFFFF; }
    .type-badge.appointment_approved { background: #21db3d; color: #FFFFFF; }
    .type-badge.appointment_rejected { background: rgba(242, 127, 12, 0.15); color: var(--navy); }
    .type-badge.appointment_cancelled { background: #db213a; color: #FFFFFF; }
    .type-badge.appointment_rescheduled { background: rgba(5, 63, 92, 0.15); color: var(--navy); }
    .type-badge.feedback { background: #ffbf00; color: #FFFFFF; }
    .type-badge.appointment_request_high { background: rgba(242, 127, 12, 0.15); color: var(--navy); }
    
    .btn-outline-custom {
        border: 2px solid var(--medium-blue);
        color: var(--navy);
        border-radius: 0.5rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }
    
    .btn-outline-custom:hover {
        background: var(--medium-blue);
        color: #FFFFFF;
    }
    
    .kpi-card {
        border-radius: 1rem;
        padding: 1.5rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(5, 63, 92, 0.08);
    }

    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .kpi-icon.notifications { background: rgba(159, 231, 245, 0.25); color: #429EBD; }
    
    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        background: white;
        color: var(--text-muted);
        transition: all 0.2s ease;
    }
    
    .btn-icon:hover {
        border-color: var(--medium-blue);
        color: var(--navy);
        background: rgba(66, 158, 189, 0.1);
    }
    
    .btn-icon.success:hover {
        border-color: var(--light-blue);
        color: var(--navy);
        background: rgba(159, 231, 245, 0.15);
    }
    
    .btn-outline-secondary-custom {
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        border-radius: 0.5rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }
    
    .btn-outline-secondary-custom:hover {
        border-color: var(--text-muted);
        color: var(--text-primary);
        background: var(--bg-light);
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h2 mb-1" style="color: var(--navy); font-weight: 700;">Notifications</h1>
                    <p class="text-muted mb-0">Stay updated with your appointment activities</p>
                </div>
                <div class="d-flex gap-2">
                    @if(auth()->user()->unreadNotificationsCount() > 0)
                        <form method="POST" action="{{ route('student.notifications.read-all') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-outline-custom">
                                <i class="bi bi-check-all me-2"></i>Mark All Read
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @if($notifications->count() > 0)
        <div class="card">
            <div class="card-body p-0">
                @foreach($notifications as $notification)
                    <a href="{{ route('notifications.show', $notification) }}" class="notification-item d-flex gap-3 text-decoration-none {{ !$notification->is_read ? 'bg-light' : '' }}">
                        <div class="flex-shrink-0">
                            <div class="kpi-icon notifications" style="width: 40px; height: 40px;">
                                <i class="bi {{ $notification->icon }} fs-5"></i>
                            </div>
                        </div>
<div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="notification-title mb-1">{{ $notification->title }}</h6>
                                </div>
                                <p class="notification-message mb-0">{{ $notification->message }}</p>
                            </div>
                            <div class="d-flex flex-column gap-2 align-items-end">
                                <small class="notification-time">{{ $notification->created_at->diffForHumans() }}</small>
                                <span class="type-badge {{ $notification->type }}">{{ ucfirst($notification->type) }}</span>
                                @if(!$notification->is_read)
                                <form method="POST" action="{{ route('student.notifications.read', $notification) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-icon success" title="Mark as read">
                                        <i class="bi bi-check fs-5"></i>
                                    </button>
                                </form>
                                <span class="notification-badge">New</span>
                            @endif
                        </div>
                    </a>
                @endforeach
                <div class="card-footer bg-transparent border-top p-3" style="border-color: var(--border-color-light);">
                    <div class="d-flex justify-content-center">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-bell-slash fs-1" style="color: var(--text-muted); opacity: 0.5;"></i>
                <h4 class="mt-3 text-muted">No Notifications</h4>
                <p class="text-muted">You're all caught up!</p>
            </div>
        </div>
    @endif
@endsection