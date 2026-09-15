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
    
    .btn-book-appointment {
        background: var(--medium-blue);
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
    
    .btn-book-appointment i {
        color: #FFFFFF;
        font-size: 1.1rem;
    }
    
    .btn-book-appointment:hover {
        background: var(--navy);
    }
    
    .btn-book-appointment:focus {
        background: var(--navy);
        box-shadow: 0 0 0 3px rgba(66, 158, 189, 0.3);
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
        box-shadow: 0 10px 25px rgba(5, 63, 92, 0.12);
    }
    
    .kpi-row {
        align-items: stretch;
    }
    
    .kpi-col {
        display: flex;
        align-items: flex-start;
        align-self: flex-start;
        height: fit-content;
    }
    
    .kpi-card .kpi-count {
        font-size: 1.5rem !important;
        font-weight: 700;
    }
    
    .kpi-card.pending,
    .kpi-card.approved {
        min-height: 100px;
    }

    .kpi-card.pending {
        background: linear-gradient(135deg, rgba(247, 173, 25, 0.1) 0%, rgba(247, 173, 25, 0.05) 100%);
        border-left: 4px solid var(--yellow);
    }
    
    .kpi-card.approved {
        background: linear-gradient(135deg, rgba(66, 158, 189, 0.1) 0%, rgba(66, 158, 189, 0.05) 100%);
        border-left: 4px solid var(--medium-blue);
    }
    
    .kpi-card.appointments {
        background: linear-gradient(135deg, rgba(66, 158, 189, 0.1) 0%, rgba(66, 158, 189, 0.05) 100%);
        border-left: 4px solid var(--medium-blue);
    }
    
    .kpi-icon.appointments {
         background: rgba(66, 158, 189, 0.15);
         color: var(--navy);
    }
    @media (max-width: 767.98px) {
        .mobile-greeting {
            margin-bottom: 0.5rem;
        }
        .mobile-greeting h4 {
            font-size: 1.25rem;
            font-weight: 700;
        }
        .mobile-greeting p {
            font-size: 0.875rem;
        }
        .btn-book-mobile {
            height: 48px;
            font-size: 0.95rem;
            font-weight: 500;
            border-radius: 0.75rem;
        }
        .mobile-stat-card {
            padding: 0.875rem 1rem;
            min-height: 70px;
        }
        .mobile-stat-card h3 {
            font-size: 1.5rem;
        }
        .mobile-stat-card p {
            font-size: 0.7rem;
        }
        .next-appt-mobile .card-body {
            padding: 1rem;
        }
        .appt-date-mobile {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .appt-time-mobile {
            font-size: 0.9rem;
        }
        .mobile-table-card .card-body {
            padding: 0.75rem;
        }
        .mobile-full-width {
            width: 100% !important;
        }
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
    .kpi-icon.approved { background: rgba(66, 158, 189, 0.2); color: #429EBD; }
    .kpi-icon.appointments { background: rgba(66, 158, 189, 0.2); color: #429EBD; }
    
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
        color: #FFFFFF;
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
    
     .action-btn {
        border-radius: 0.75rem;
        padding: 0.6rem 0.875rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
    }
    
    .action-btn:hover {
        border-color: var(--medium-blue);
        background: rgba(66, 158, 189, 0.05);
        transform: translateY(-2px);
        text-decoration: none;
    }
    
     .quick-action-icon {
        font-size: 1.75rem;
        display: block;
        margin-bottom: 0.25rem;
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
    
    .action-btn.warning:hover {
        border-color: var(--yellow);
        background: rgba(247, 173, 25, 0.05);
    }
    
    .action-btn.info:hover {
        border-color: var(--medium-blue);
        background: rgba(66, 158, 189, 0.05);
    }
    
    .action-btn.secondary:hover {
        border-color: var(--navy);
        background: rgba(5, 63, 92, 0.05);
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
    .type-badge.appointment_rejected { background: #db213a; color: #FFFFFF; }
    .type-badge.appointment_cancelled { background: #db213a; color: #FFFFFF; }
    .type-badge.appointment_rescheduled { background: rgba(5, 63, 92, 0.15); color: var(--navy); }
    .type-badge.feedback { background: #ffbf00; color: #FFFFFF; }
</style>
@endsection

@section('content')
<!-- Mobile Greeting -->
<div class="d-none d-md-block mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h2 mb-1" style="color: var(--navy); font-weight: 700;">Student Dashboard</h1>
            <p class="text-muted mb-0">Manage your guidance appointments and requests</p>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('student.schedules') }}" class="btn-book-appointment">
                <i class="bi bi-plus-circle"></i>Book an Appointment
            </a>
        </div>
    </div>
</div>
<div class="d-md-none mb-3 mobile-greeting">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 style="color: var(--navy);" class="mb-1">Good morning, {{ auth()->user()->first_name }}</h4>
            <p class="text-muted mb-0">Manage your appointments and requests</p>
        </div>
    </div>
</div>

<!-- Book Appointment Button (Mobile) -->
<div class="mb-4 d-md-none">
    <a href="{{ route('student.schedules') }}" class="btn-book-appointment w-100">
        <i class="bi bi-plus-circle"></i>Book an Appointment
    </a>
</div>

<!-- Dashboard Layout -->
<div class="row g-3">
    <!-- Left Column: KPI Cards + Next Appointment -->
    <div class="col-12 col-lg-7">
        <div class="row g-3 mb-3">
            <!-- Pending Requests -->
            <div class="col-12 col-md-6">
                <a href="{{ route('student.appointments.index') }}" class="kpi-link d-block h-100">
                    <div class="card kpi-card pending kpi-count-card h-100">
                        <div class="d-flex justify-content-between align-items-center h-100">
                            <div>
                                <p class="text-muted mb-1 text-uppercase small" style="letter-spacing: 0.05em;">Pending Requests</p>
                                <h2 class="kpi-count mb-0" style="color: var(--navy);">{{ $pendingCount }}</h2>
                            </div>
                            <div class="kpi-icon pending">
                                <i class="bi bi-hourglass-split fs-4"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Approved Appointments -->
            <div class="col-12 col-md-6">
                <a href="{{ route('student.appointments.index') }}" class="kpi-link d-block h-100">
                    <div class="card kpi-card approved kpi-count-card h-100">
                        <div class="d-flex justify-content-between align-items-center h-100">
                            <div>
                                <p class="text-muted mb-1 text-uppercase small" style="letter-spacing: 0.05em;">Approved Appointments</p>
                                <h2 class="kpi-count mb-0" style="color: var(--navy);">{{ $approvedCount }}</h2>
                            </div>
                            <div class="kpi-icon approved">
                                <i class="bi bi-check-circle-fill fs-4"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Next Appointment Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0" style="color: var(--navy); font-weight: 600;">
                    <i class="bi bi-calendar-event me-2" style="color: var(--medium-blue);"></i>Next Appointment
                </h5>
            </div>
            <div class="card-body">
                @if($nextAppointment)
                     <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                         <div class="d-flex align-items-center gap-3">
                              <div class="bg-light bg-opacity-10 p-3 rounded-xl" style="background: rgba(159, 231, 245, 0.15) !important;">
                                 <i class="bi bi-calendar-check fs-1" style="color: var(--medium-blue);"></i>
                              </div>
                              <div>
                                  <h5 class="mb-1" style="color: var(--navy); font-weight: 600;">{{ $nextAppointment->formatted_date }}</h5>
                                  <p class="mb-1 text-muted">{{ $nextAppointment->formatted_time }}</p>
                                  <p class="mb-1"><strong style="color: var(--navy);">{{ $nextAppointment->guidanceAssociate->full_name }}</strong></p>
                                  @if($nextAppointment->purpose)
                                      <p class="mb-1 small text-muted"><i class="bi bi-chat-text me-1"></i>{{ Str::limit($nextAppointment->purpose, 100) }}</p>
                                  @endif
                              </div>
                         </div>
                         <div class="d-flex flex-column align-items-center gap-2" style="min-width: 140px;">
                             <span class="status-badge approved">{{ $nextAppointment->status->label }}</span>
                             <a href="{{ route('student.appointments.show', $nextAppointment) }}" class="btn-outline-custom">
                                 <i class="bi bi-eye me-1"></i>View Details
                             </a>
                         </div>
                     </div>
                 @else
                     <div class="text-center py-5">
                        <i class="bi bi-calendar-x fs-1" style="color: var(--text-muted); opacity: 0.5;"></i>
                        <p class="text-muted mt-3" style="color: var(--text-muted);">No upcoming appointments</p>
                         <a href="{{ route('student.schedules') }}" class="btn-book-appointment">
                             <i class="bi bi-plus-circle"></i>Book an Appointment
                         </a>
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
                        <a href="{{ route('notifications.show', $notification) }}" class="notification-item d-flex gap-3 text-decoration-none {{ !$notification->is_read ? 'bg-light' : '' }}" style="{{ !$notification->is_read ? 'background: rgba(242, 127, 12, 0.08);' : '' }}">
                            <div class="flex-shrink-0">
                                <div class="kpi-icon notifications" style="width: 40px; height: 40px;">
                                    <i class="bi {{ $notification->icon }} fs-5"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="notification-title mb-1 {{ !$notification->is_read ? 'fw-bold' : '' }}">{{ $notification->title }}</h6>
                                        <p class="notification-message mb-0">{{ Str::limit($notification->message, 100) }}</p>
                                    </div>
                                    <small class="notification-time flex-nowrap">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <small class="type-badge {{ $notification->type }}">{{ ucfirst($notification->type) }}</small>
                            </div>
                            <div class="d-flex flex-row align-items-center gap-2 ms-3">
                                @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('student.notifications.read', $notification) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-check me-1"></i>Mark Read</button>
                                    </form>
                                @endif
                            </div>
                        </a>
                    @endforeach
                    <div class="text-center p-3 border-top" style="border-color: #F1F5F9;">
                        <a href="{{ route('student.notifications') }}" class="btn btn-sm" style="color: var(--medium-blue); font-weight: 500; padding: 0.5rem 1rem;">
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

     <!-- Right Column: Quick Actions -->
    <div class="col-12 col-lg-5 d-flex">
        <!-- Quick Actions Card -->
        <div class="card align-self-start">
            <div class="card-header bg-white p-2">
                <h5 class="mb-0" style="color: var(--navy); font-weight: 600;">
                    <i class="bi bi-lightning me-2" style="color: var(--yellow);"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body p-2">
                <div class="row g-2">
                    <div class="col-12 col-sm-6">
                        <a href="{{ route('student.schedules') }}" class="action-btn info d-block h-100">
                            <i class="bi bi-calendar-week quick-action-icon" style="color: #429EBD;"></i>
                            <span class="fw-medium d-block" style="color: var(--navy);">Available Schedules</span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6">
                        <a href="{{ route('student.appointments.index') }}" class="action-btn info d-block h-100">
                            <i class="bi bi-calendar-check quick-action-icon" style="color: #429EBD;"></i>
                            <span class="fw-medium d-block" style="color: var(--navy);">My Appointments</span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6">
                        <a href="{{ route('student.schedules') }}" class="action-btn info d-block h-100">
                            <i class="bi bi-plus-circle quick-action-icon" style="color: #429EBD;"></i>
                            <span class="fw-medium d-block" style="color: var(--navy);">Book Appointment</span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6">
                        <a href="{{ route('student.notifications') }}" class="action-btn warning d-block h-100">
                            <i class="bi bi-bell quick-action-icon" style="color: #F7AD19;"></i>
                            <span class="fw-medium d-block" style="color: var(--navy);">Notifications</span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6">
                        <a href="{{ route('student.feedback.index') }}" class="action-btn info d-block h-100">
                            <i class="bi bi-chat-text quick-action-icon" style="color: #429EBD;"></i>
                            <span class="fw-medium d-block" style="color: var(--navy);">Feedback</span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6">
                        <a href="{{ route('profile') }}" class="action-btn secondary d-block h-100">
                            <i class="bi bi-person quick-action-icon" style="color: #053F5C;"></i>
                            <span class="fw-medium d-block" style="color: var(--navy);">Profile</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection