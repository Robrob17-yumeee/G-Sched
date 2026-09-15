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
    
    .kpi-card {
        border-radius: 0.75rem;
        padding: 1.25rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(5, 63, 92, 0.08);
    }
    
    .kpi-link {
        text-decoration: none;
        color: inherit;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .kpi-link:hover .kpi-card {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }
    
    .kpi-row {
        align-items: stretch;
    }
    
    .kpi-col {
        display: flex;
        align-items: stretch;
    }
    
    .kpi-card.pending {
        background: linear-gradient(135deg, rgba(247, 173, 25, 0.1) 0%, rgba(247, 173, 25, 0.05) 100%);
        border-left: 4px solid var(--yellow);
    }
    
    .kpi-card.today {
        background: linear-gradient(135deg, rgba(66, 158, 189, 0.1) 0%, rgba(66, 158, 189, 0.05) 100%);
        border-left: 4px solid var(--medium-blue);
    }
    
    .kpi-card.completed {
        background: linear-gradient(135deg, rgba(159, 231, 245, 0.15) 0%, rgba(159, 231, 245, 0.05) 100%);
        border-left: 4px solid var(--light-blue);
    }
    
    .kpi-card.slots {
        background: linear-gradient(135deg, rgba(159, 231, 245, 0.25) 0%, rgba(159, 231, 245, 0.15) 100%);
        border-left: 4px solid var(--light-blue);
    }
    
    .kpi-card .kpi-count {
        font-size: 1.25rem !important;
        font-weight: 700;
    }
    
    .kpi-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .kpi-icon.pending { background: rgba(247, 173, 25, 0.2); color: #F7AD19; }
    .kpi-icon.today { background: rgba(66, 158, 189, 0.2); color: #429EBD; }
    .kpi-icon.completed { background: rgba(159, 231, 245, 0.25); color: #429EBD; }
    .kpi-icon.slots { background: rgba(159, 231, 245, 0.2); color: #429EBD; }
    
    .status-badge {
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    
    .status-badge.approved {
        background: var(--medium-blue);
        color: var(--navy);
    }
    
    .status-badge.pending {
        background: rgba(247, 173, 25, 0.15);
        color: var(--navy);
    }
    
    .btn-outline-custom {
        border: 2px solid var(--medium-blue);
        color: var(--medium-blue);
        border-radius: 0.5rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }
    
    .btn-outline-custom:hover {
        background: var(--medium-blue);
        color: #FFFFFF;
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
    
    .notification-title {
        color: var(--text-primary);
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    .notification-time {
        color: var(--text-muted);
        font-size: 0.75rem;
    }
    
    .notification-message {
        color: var(--text-muted);
        font-size: 0.8125rem;
        margin-top: 0.25rem;
        line-height: 1.4;
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
    
    .action-btn.primary-inverted {
        background: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        color: #429EBD;
        padding: 1rem 0.875rem;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(5, 63, 92, 0.08);
    }
    .action-btn.primary-inverted:hover {
        border-color: var(--medium-blue);
        background: rgba(66, 158, 189, 0.05);
        color: #429EBD;
    }
    .action-btn.primary-inverted i {
        color: #429EBD;
    }

    .action-btn.primary,
    .btn-primary-action {
        background: #429EBD;
        border: none;
        border-radius: 0.75rem;
        color: #FFFFFF;
        padding: 1rem 0.875rem;
        text-decoration: none;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 44px;
    }
    .action-btn.primary:hover,
    .btn-primary-action:hover {
        background: var(--navy);
    }
    .action-btn.primary i,
    .btn-primary-action i {
        color: #FFFFFF;
    }

    .action-btn {
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 1rem 0.875rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    .action-btn.warning:hover {
        border-color: var(--yellow);
        background: rgba(247, 173, 25, 0.05);
    }
    
    .action-btn.success:hover {
        border-color: var(--medium-blue);
        background: rgba(66, 158, 189, 0.05);
    }
    
    .action-btn.info:hover {
        border-color: var(--medium-blue);
        background: rgba(66, 158, 189, 0.05);
    }
    
    .action-btn.secondary:hover {
        border-color: var(--navy);
        background: rgba(5, 63, 92, 0.05);
    }
    
    .quick-action-icon {
        font-size: 1.75rem;
        display: block;
        margin-bottom: 0.5rem;
        width: 48px;
        height: 48px;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .action-btn.info .quick-action-icon {
        background: rgba(66, 158, 189, 0.15);
    }
    
    .action-btn.warning .quick-action-icon {
        background: rgba(247, 173, 25, 0.2);
    }
    
    .action-btn.success .quick-action-icon {
        background: rgba(159, 231, 245, 0.25);
    }
    
    .action-btn.secondary .quick-action-icon {
        background: rgba(5, 63, 92, 0.1);
    }
</style>
@endsection

@section('content')
<div class="row g-3 kpi-row">
        <!-- KPI Summary Cards -->
        <div class="col-12 col-md-6 col-lg-3 kpi-col">
            <a href="{{ route('guidance.requests') }}" class="kpi-link">
                <div class="card kpi-card pending">
                    <div class="d-flex justify-content-between align-items-center h-100">
                        <div>
                            <p class="text-muted mb-1 text-uppercase small" style="letter-spacing: 0.05em;">Pending Requests</p>
                            <h2 class="kpi-count mb-0" style="color: var(--navy);">{{ $pendingRequests->count() }}</h2>
                        </div>
                        <div class="kpi-icon pending">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-12 col-md-6 col-lg-3 kpi-col">
            <a href="{{ route('guidance.appointments') }}" class="kpi-link">
                <div class="card kpi-card today">
                    <div class="d-flex justify-content-between align-items-center h-100">
                        <div>
                            <p class="text-muted mb-1 text-uppercase small" style="letter-spacing: 0.05em;">Today's Appointments</p>
                            <h2 class="kpi-count mb-0" style="color: var(--navy);">{{ $todaysAppointments->count() }}</h2>
                        </div>
                        <div class="kpi-icon today">
                            <i class="bi bi-calendar-day-fill fs-4"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-12 col-md-6 col-lg-3 kpi-col">
            <a href="{{ route('guidance.history') }}" class="kpi-link">
                <div class="card kpi-card completed">
                    <div class="d-flex justify-content-between align-items-center h-100">
                        <div>
                            <p class="text-muted mb-1 text-uppercase small" style="letter-spacing: 0.05em;">Completed Sessions</p>
                            <h2 class="kpi-count mb-0" style="color: var(--navy);">{{ $completedCount }}</h2>
                        </div>
                        <div class="kpi-icon completed">
                            <i class="bi bi-check-circle-fill fs-4"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-12 col-md-6 col-lg-3 kpi-col">
            <a href="{{ route('guidance.availability') }}" class="kpi-link">
                <div class="card kpi-card slots">
                    <div class="d-flex justify-content-between align-items-center h-100">
                        <div>
                            <p class="text-muted mb-1 text-uppercase small" style="letter-spacing: 0.05em;">Available Slots</p>
                            <h2 class="kpi-count mb-0" style="color: var(--navy);">{{ $availableSlots }}</h2>
                        </div>
                        <div class="kpi-icon slots">
                            <i class="bi bi-calendar-plus-fill fs-4"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Main Content Widgets -->
        <div class="col-12 col-lg-7">
            <!-- Pending Requests Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: var(--navy); font-weight: 600;">
                        <i class="bi bi-inbox me-2" style="color: var(--yellow);"></i>Pending Requests
                    </h5>
                    <a href="{{ route('guidance.requests') }}" class="btn btn-sm" style="color: var(--medium-blue); font-weight: 500; padding: 0.375rem 0.75rem;">
                        View All <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($pendingRequests->count() > 0)
                        @foreach($pendingRequests->take(5) as $request)
                            <a href="{{ route('guidance.requests.show', $request) }}" class="notification-item d-flex gap-3 text-decoration-none">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="notification-title mb-1">{{ $request->student->full_name }}</h6>
                                        <small class="notification-time">{{ $request->formatted_date }} at {{ $request->formatted_time }}</small>
                                    </div>
                                    <p class="notification-message mb-0">{{ Str::limit($request->purpose, 80) }}</p>
                                </div>
                                <span class="status-badge pending align-self-center">Pending</span>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1" style="color: var(--text-muted); opacity: 0.5;"></i>
                            <p class="text-muted mt-3">No pending requests</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Today's Appointments Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: var(--navy); font-weight: 600;">
                        <i class="bi bi-calendar-day me-2" style="color: var(--medium-blue);"></i>Today's Appointments
                    </h5>
                    <a href="{{ route('guidance.appointments') }}" class="btn btn-sm" style="color: var(--medium-blue); font-weight: 500; padding: 0.375rem 0.75rem;">
                        View All <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($todaysAppointments->count() > 0)
                        @foreach($todaysAppointments as $appt)
                            <a href="{{ route('guidance.appointments.show', $appt) }}" class="notification-item d-flex gap-3 text-decoration-none">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="notification-title mb-1">{{ $appt->student->full_name }}</h6>
                                        <span class="status-badge approved">{{ $appt->status->label }}</span>
                                    </div>
                                    <p class="notification-message mb-0">{{ $appt->formatted_time }} - {{ Str::limit($appt->purpose, 80) }}</p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-check fs-1" style="color: var(--text-muted); opacity: 0.5;"></i>
                            <p class="text-muted mt-3">No appointments today</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Upcoming Appointments Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: var(--navy); font-weight: 600;">
                        <i class="bi bi-calendar-event me-2" style="color: var(--medium-blue);"></i>Upcoming Appointments
                    </h5>
                    <a href="{{ route('guidance.appointments') }}" class="btn btn-sm" style="color: var(--medium-blue); font-weight: 500; padding: 0.375rem 0.75rem;">
                        View All <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($upcomingAppointments->count() > 0)
                        @foreach($upcomingAppointments as $appt)
                            <a href="{{ route('guidance.appointments.show', $appt) }}" class="notification-item d-flex gap-3 text-decoration-none">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="notification-title mb-1">{{ $appt->student->full_name }}</h6>
                                        <small class="notification-time">{{ $appt->formatted_date }} at {{ $appt->formatted_time }}</small>
                                    </div>
                                    <p class="notification-message mb-0">{{ Str::limit($appt->purpose, 80) }}</p>
                                </div>
                                <span class="status-badge approved">{{ $appt->status->label }}</span>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-check fs-1" style="color: var(--text-muted); opacity: 0.5;"></i>
                            <p class="text-muted mt-3">No upcoming appointments</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Recent Notifications Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--navy); font-weight: 600;">
                        <i class="bi bi-bell me-2" style="color: var(--orange);"></i>Recent Notifications
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($notifications->count() > 0)
                        @foreach($notifications as $notification)
                            <a href="{{ route('guidance.notifications') }}" class="notification-item d-flex gap-3 text-decoration-none {{ !$notification->is_read ? 'fw-bold' : '' }}" style="{{ !$notification->is_read ? 'background: rgba(242, 127, 12, 0.08);' : '' }}">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="notification-title mb-1">{{ $notification->title }}</h6>
                                        <small class="notification-time">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="notification-message mb-0">{{ $notification->message }}</p>
                                </div>
                                @if(!$notification->is_read)
                                    <span class="notification-badge align-self-start">New</span>
                                @endif
                            </a>
                        @endforeach
                        <div class="text-center p-3 border-top" style="border-color: var(--border-color-light);">
            <a href="{{ route('guidance.notifications') }}" class="btn btn-sm" style="color: var(--medium-blue); font-weight: 500; padding: 0.375rem 0.75rem;">
                View All <i class="bi bi-chevron-right ms-1"></i>
            </a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-bell-slash fs-1" style="color: var(--text-muted); opacity: 0.5;"></i>
                            <p class="text-muted mt-3">No notifications</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-5">
            <!-- Quick Actions Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--navy); font-weight: 600;">
                        <i class="bi bi-lightning me-2" style="color: var(--yellow);"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <a href="{{ route('guidance.requests') }}" class="action-btn warning d-block h-100">
                                <i class="bi bi-inbox quick-action-icon" style="color: #F7AD19;"></i>
                                <span class="fw-medium d-block" style="color: var(--navy);">Pending Requests</span>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6">
                            <a href="{{ route('guidance.availability') }}" class="action-btn primary-inverted d-block h-100">
                                <i class="bi bi-calendar-plus quick-action-icon" style="color: #429EBD;"></i>
                                <span class="fw-medium d-block" style="color: #429EBD;">Manage Availability</span>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6">
                            <a href="{{ route('guidance.calendar') }}" class="action-btn info d-block h-100">
                                <i class="bi bi-calendar3 quick-action-icon" style="color: #429EBD;"></i>
                                <span class="fw-medium d-block" style="color: var(--navy);">Calendar View</span>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6">
                            <a href="{{ route('guidance.history') }}" class="action-btn secondary d-block h-100">
                                <i class="bi bi-clock-history quick-action-icon" style="color: #053F5C;"></i>
                                <span class="fw-medium d-block" style="color: var(--navy);">History</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection