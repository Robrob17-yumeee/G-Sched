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
    
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        background: #2148db;
    }

    .table {
        margin-bottom: 0;
        background: transparent;
    }

    .table th {
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--border-color-light);
        padding: 1rem 1.5rem;
    }

    .table thead {
        background: #0077b6 !important;
    }

    .table thead th {
        background: #0077b6 !important;
        color: #FFFFFF !important;
        border-bottom: none;
    }

    .table tbody {
        background: #FFFFFF;
    }

    .table td {
        background: #FFFFFF;
    }
    
    .table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color-light);
        color: var(--text-primary);
    }
    
    .table tbody tr {
        transition: background 0.2s ease;
    }
    
    .table tbody tr:hover {
        background: var(--bg-light);
    }
    
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .status-badge {
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    
    .status-badge.pending {
        background: #ffbf00;
        color: #FFFFFF;
    }
    
    .status-badge.approved {
        background: var(--medium-blue);
        color: #FFFFFF;
    }
    
    .status-badge.rejected {
        background: rgba(242, 127, 12, 0.15);
        color: #FFFFFF;
    }
    
    .status-badge.completed {
        background: #21db3d;
        color: #FFFFFF;
    }
    
    .status-badge.cancelled {
        background: #db213a;
        color: #FFFFFF;
    }
    
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
    
    .btn-icon.danger:hover {
        border-color: var(--orange);
        color: var(--navy);
        background: rgba(242, 127, 12, 0.1);
    }
    
    .btn-icon.warning:hover {
        border-color: var(--yellow);
        color: var(--navy);
        background: rgba(247, 173, 25, 0.1);
    }

    /* Mobile-responsive table to cards */
    @media (max-width: 767.98px) {
        .table-responsive {
            overflow-x: visible;
        }
        .mobile-appointment-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .mobile-appt-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1rem;
            background: white;
        }
        .mobile-appt-card .appt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }
        .mobile-appt-card .appt-title {
            font-weight: 600;
            color: var(--navy);
            font-size: 1rem;
        }
        .mobile-appt-card .appt-guidance {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .mobile-appt-card .appt-status {
            font-size: 0.75rem;
        }
        .mobile-appt-card .appt-details {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }
        .mobile-appt-card .appt-detail-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
        }
        .mobile-appt-card .appt-detail-label {
            color: var(--text-muted);
        }
        .mobile-appt-card .appt-detail-value {
            color: var(--navy);
            font-weight: 500;
        }
        .mobile-appt-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }
        .mobile-appt-actions .btn {
            flex: 1;
            min-width: 100px;
            height: 44px;
        }
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
    
    .kpi-card.appointments {
        background: linear-gradient(135deg, rgba(66, 158, 189, 0.1) 0%, rgba(66, 158, 189, 0.05) 100%);
        border-left: 4px solid var(--medium-blue);
    }
    
    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .kpi-icon.appointments { background: rgba(66, 158, 189, 0.2); color: #429EBD; }
    
    .modal-content {
        border: none;
        border-radius: 1rem;
    }
    
    .modal-header {
        border: none;
        border-radius: 1rem 1rem 0 0;
    }
    
    .form-control, .form-select {
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.625rem 0.875rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--medium-blue);
        box-shadow: 0 0 0 3px rgba(66, 158, 189, 0.3);
    }
    
    /* Book Appointment button */
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
        box-shadow: 0 0 0 3px rgba(66, 158, 189, 0.4);
    }
    
    .btn-primary {
        background: var(--medium-blue);
        border: none;
        border-radius: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-weight: 500;
        color: #FFFFFF;
    }
    
    .btn-primary:hover {
        background: var(--navy);
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h2 mb-1" style="color: var(--navy); font-weight: 700;">My Appointments</h1>
                    <p class="text-muted mb-0">View and manage your counseling appointments</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('student.schedules') }}" class="btn-book-appointment">
                        <i class="bi bi-plus-circle"></i>Book an Appointment
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    @if($appointments->count() > 0)
        <!-- Mobile Card View (hidden on desktop) -->
        <div class="d-md-none mobile-appointment-list">
            @foreach($appointments as $appointment)
                @php
                    $statusClass = 'secondary';
                    $statusName = strtolower($appointment->status->name ?? '');
                    if ($statusName === 'pending') $statusClass = 'pending';
                    elseif ($statusName === 'approved') $statusClass = 'approved';
                    elseif ($statusName === 'rejected') $statusClass = 'rejected';
                    elseif ($statusName === 'completed') $statusClass = 'completed';
                    elseif ($statusName === 'cancelled') $statusClass = 'cancelled';
                @endphp
                <div class="card mobile-appt-card">
                    <div class="appt-header">
                        <div>
                            <div class="appt-title">{{ $appointment->formatted_date }}</div>
                            <div class="appt-guidance">{{ $appointment->guidanceAssociate->full_name }}</div>
                        </div>
                        <span class="status-badge {{ $statusClass }}">{{ $appointment->status->label }}</span>
                    </div>
                    <div class="appt-details">
                        <div class="appt-detail-row">
                            <span class="appt-detail-label">Time</span>
                            <span class="appt-detail-value">{{ $appointment->formatted_time }}</span>
                        </div>
                        <div class="appt-detail-row">
                            <span class="appt-detail-label">Purpose</span>
                            <span class="appt-detail-value text-muted">{{ Str::limit($appointment->purpose, 60) }}</span>
                        </div>
                    </div>
                    <div class="mobile-appt-actions">
                        <a href="{{ route('student.appointments.show', $appointment) }}" class="btn btn-outline-secondary" style="border-radius: 0.5rem; min-height: 44px; padding: 0.55rem 1rem;">
                            <i class="bi bi-eye me-1"></i>View
                        </a>
                        @if($appointment->isPending() || $appointment->isApproved())
                            @if($appointment->appointment_date >= now()->toDateString())
                                <button type="button" class="btn btn-warning" style="border: none; min-height: 44px; padding: 0.55rem 1rem; border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#rescheduleModal{{ $appointment->id }}" title="Reschedule">
                                    <i class="bi bi-calendar-event"></i>
                                </button>
                                <button type="button" class="btn btn-danger" style="border: none; min-height: 44px; padding: 0.55rem 1rem; border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $appointment->id }}" title="Cancel">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Desktop Table View (hidden on mobile) -->
        <div class="d-none d-md-block">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Guidance Associate</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>
                                            <div>
                                                <div class="fw-medium" style="color: var(--navy);">{{ $appointment->formatted_date }}</div>
                                                <div class="small text-muted">{{ $appointment->formatted_time }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ $appointment->guidanceAssociate->full_name }}</div>
                                        </td>
                                        <td>
                                            <div class="text-muted" style="max-width: 300px;">{{ Str::limit($appointment->purpose, 60) }}</div>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = 'secondary';
                                                $statusName = strtolower($appointment->status->name ?? '');
                                                if ($statusName === 'pending') $statusClass = 'pending';
                                                elseif ($statusName === 'approved') $statusClass = 'approved';
                                                elseif ($statusName === 'rejected') $statusClass = 'rejected';
                                                elseif ($statusName === 'completed') $statusClass = 'completed';
                                                elseif ($statusName === 'cancelled') $statusClass = 'cancelled';
                                            @endphp
                                            <span class="status-badge {{ $statusClass }}">{{ $appointment->status->label }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('student.appointments.show', $appointment) }}" class="btn-icon" title="View Details">
                                                    <i class="bi bi-eye fs-5"></i>
                                                </a>
                                                @if($appointment->isPending() || $appointment->isApproved())
                                                    @if($appointment->appointment_date >= now()->toDateString())
                                                        <button type="button" class="btn-icon warning" data-bs-toggle="modal" data-bs-target="#rescheduleModal{{ $appointment->id }}" title="Reschedule">
                                                            <i class="bi bi-calendar-event fs-5"></i>
                                                        </button>
                                                        <button type="button" class="btn-icon danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $appointment->id }}" title="Cancel">
                                                            <i class="bi bi-x-circle fs-5"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                <!-- Cancel Modal -->
                                <div class="modal fade" id="cancelModal{{ $appointment->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: var(--orange); color: var(--navy); border-radius: 1rem 1rem 0 0;">
                                                <h5 class="modal-title"><i class="bi bi-x-circle me-2"></i>Cancel Appointment</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('student.appointments.cancel', $appointment) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Are you sure you want to cancel this appointment?</p>
                                                    <p class="text-muted small">
                                                        <strong>Date:</strong> {{ $appointment->formatted_date }}<br>
                                                        <strong>Time:</strong> {{ $appointment->formatted_time }}<br>
                                                        <strong>Guidance Associate:</strong> {{ $appointment->guidanceAssociate->full_name }}
                                                    </p>
                                                    <div class="mb-3">
                                                        <label for="cancellation_reason{{ $appointment->id }}" class="form-label fw-medium" style="color: var(--navy);">Reason for Cancellation <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="cancellation_reason{{ $appointment->id }}" name="cancellation_reason" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0" style="border-radius: 0 0 1rem 1rem;">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Appointment</button>
                                                    <button type="submit" class="btn" style="background: var(--orange); border: none; border-radius: 0.5rem; color: var(--navy); font-weight: 500;">Cancel Appointment</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                
                                <!-- Reschedule Modal -->
                                <div class="modal fade" id="rescheduleModal{{ $appointment->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: var(--yellow); color: var(--navy); border-radius: 1rem 1rem 0 0;">
                                                <h5 class="modal-title"><i class="bi bi-calendar-event me-2"></i>Request Reschedule</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('student.appointments.reschedule', $appointment) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Select a new date and time for your appointment.</p>
                                                    <input type="hidden" name="availability_id" id="reschedule_availability_id{{ $appointment->id }}">
                                                    <input type="hidden" name="requested_date" id="reschedule_requested_date{{ $appointment->id }}">
                                                    <input type="hidden" name="requested_start_time" id="reschedule_requested_start_time{{ $appointment->id }}">
                                                    <input type="hidden" name="requested_end_time" id="reschedule_requested_end_time{{ $appointment->id }}">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label fw-medium" style="color: var(--navy);">Current Appointment</label>
                                                        <input type="text" class="form-control" value="{{ $appointment->formatted_date }} at {{ $appointment->formatted_time }}" readonly>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label fw-medium" style="color: var(--navy);">New Date</label>
                                                        <select class="form-select" id="reschedule_date_select{{ $appointment->id }}" onchange="loadRescheduleSlots({{ $appointment->id }})">
                                                            <option value="">Select a date</option>
                                                            @foreach($availableDates as $date)
                                                                <option value="{{ $date->available_date->format('Y-m-d') }}">{{ $date->available_date->format('l, F d, Y') }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="mb-3" id="reschedule_slots_container{{ $appointment->id }}">
                                                        <p class="text-muted">Select a date to see available time slots</p>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label fw-medium" style="color: var(--navy);">Reason for Reschedule <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="reason{{ $appointment->id }}" name="reason" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0" style="border-radius: 0 0 1rem 1rem;">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn" style="background: var(--yellow); border: none; border-radius: 0.5rem; color: var(--navy);" disabled id="reschedule_submit{{ $appointment->id }}">Submit Request</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
        <!-- End Desktop Table View -->
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-calendar-x fs-1" style="color: var(--text-muted); opacity: 0.5;"></i>
                <h4 class="mt-3 text-muted">No Appointments</h4>
                <p class="text-muted">You haven't booked any appointments yet.</p>
                <a href="{{ route('student.schedules') }}" class="btn btn-primary mt-2" style="background: var(--medium-blue); border: none; border-radius: 0.5rem;">
                    <i class="bi bi-plus-circle me-2"></i>Book Appointment
                </a>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
<script>
    function loadRescheduleSlots(appointmentId) {
        const date = document.getElementById('reschedule_date_select' + appointmentId).value;
        const container = document.getElementById('reschedule_slots_container' + appointmentId);
        
        if (!date) {
            container.innerHTML = '<p class="text-muted">Select a date to see available time slots</p>';
            return;
        }

        container.innerHTML = '<div class="text-center py-3"><div class="spinner-border" style="color: var(--medium-blue);" role="status"><span class="visually-hidden">Loading...</span></div></div>';

        fetch(`/student/schedules/${date}/slots`)
            .then(response => response.json())
            .then(slots => {
                if (slots.length === 0) {
                    container.innerHTML = '<p class="text-center text-muted">No available slots for this date</p>';
                    return;
                }

                let html = '<label class="form-label fw-medium" style="color: var(--navy);">Available Time Slots</label><div class="row g-2">';
                slots.forEach(slot => {
                    let classes = 'time-slot col-6 col-md-4 d-flex flex-column align-items-center justify-content-center p-2 text-center';
                    if (slot.is_booked) {
                        classes += ' booked';
                    } else if (slot.student_conflict) {
                        classes += ' conflict';
                    }
                    
                    html += `
                        <div class="${classes}" 
                             data-availability-id="${slot.availability_id}"
                             data-start="${slot.start_time}"
                             data-end="${slot.end_time}"
                             ${slot.is_booked || slot.student_conflict ? '' : 'onclick="selectRescheduleSlot(this, ' + appointmentId + ')"'}>
                            <span class="fw-medium">${slot.formatted_time}</span>
                            <small class="text-muted">${slot.guidance_associate_name}</small>
                            ${slot.is_booked ? '<i class="bi bi-lock-fill ms-1"></i>' : ''}
                            ${slot.student_conflict ? '<i class="bi bi-exclamation-triangle ms-1"></i>' : ''}
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            })
            .catch(error => {
                container.innerHTML = '<p class="text-center text-danger">Error loading time slots</p>';
            });
    }
    
    function selectRescheduleSlot(element, appointmentId) {
        document.querySelectorAll('#reschedule_slots_container' + appointmentId + ' .time-slot').forEach(el => {
            el.classList.remove('selected');
        });
        
        element.classList.add('selected');
        
        document.getElementById('reschedule_availability_id' + appointmentId).value = element.dataset.availabilityId;
        document.getElementById('reschedule_requested_date' + appointmentId).value = document.getElementById('reschedule_date_select' + appointmentId).value;
        document.getElementById('reschedule_requested_start_time' + appointmentId).value = element.dataset.start;
        document.getElementById('reschedule_requested_end_time' + appointmentId).value = element.dataset.end;
        
        const submitBtn = document.getElementById('reschedule_submit' + appointmentId);
        if (submitBtn) submitBtn.disabled = false;
    }
</script>
@endsection