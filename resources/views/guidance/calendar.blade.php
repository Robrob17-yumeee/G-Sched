@extends('layouts.app')

@section('title', ' - Calendar')

@section('styles')
<style>
    #calendar {
        max-width: 100%;
    }
    .fc-event {
        cursor: pointer;
        border: none;
        padding: 2px 4px;
        font-size: 0.85em;
    }
    .fc-event:hover {
        opacity: 0.8;
    }
    .fc-daygrid-event-dot {
        display: none;
    }
    @media (max-width: 767.98px) {
        .fc-toolbar {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .fc-toolbar-chunk {
            flex: 1 0 auto;
        }
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Calendar</h1>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Legend</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center">
                        <div class="rounded me-2" style="width: 16px; height: 16px; background: #9FE7F5;"></div>
                        <span class="small">Available</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="rounded me-2" style="width: 16px; height: 16px; background: #F7AD19;"></div>
                        <span class="small">Booked/Unavailable</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="rounded me-2" style="width: 16px; height: 16px; background: #429EBD;"></div>
                        <span class="small">Pending Request</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="rounded me-2" style="width: 16px; height: 16px; background: #9FE7F5;"></div>
                        <span class="small">Approved</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="rounded me-2" style="width: 16px; height: 16px; background: #9FE7F5;"></div>
                        <span class="small">Completed</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="rounded me-2" style="width: 16px; height: 16px; background: #F27F0C;"></div>
                        <span class="small">Cancelled/Rejected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="rounded me-2" style="width: 16px; height: 16px; background: #053F5C;"></div>
                        <span class="small">Rescheduled</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm" id="eventDetails">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Event Details</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">Click on an event to see details</p>
            </div>
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="eventDetailContent">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            events: '{{ route("guidance.calendar.events") }}',
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                showEventDetails(info.event);
            },
            eventDisplay: 'block',
            height: 'auto',
        });
        
        calendar.render();
        
        function showEventDetails(event) {
            const modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
            const content = document.getElementById('eventDetailContent');
            const title = document.getElementById('eventDetailModalLabel');
            
            title.textContent = event.title;
            
            let html = '';
            const props = event.extendedProps;
            
            if (props.type === 'availability') {
                html = `
                    <div class="text-center mb-3">
                        <div class="rounded d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: ${props.status === 'available' ? '#9FE7F5' : '#F7AD19'};">
                            <i class="bi bi-calendar fs-2 text-white"></i>
                        </div>
                    </div>
                    <h5>${event.title}</h5>
                    <hr>
                    <p><strong>Date:</strong> ${event.start.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                    <p><strong>Time:</strong> ${event.start.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })} - ${event.end.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}</p>
                    <p><strong>Status:</strong> <span class="badge" style="background: ${props.status === 'available' ? '#9FE7F5' : '#F7AD19'}; color: var(--navy);">${props.status}</span></p>
                `;
            } else if (props.type === 'appointment') {
                const statusColors = {
                    'pending': '#F7AD19',
                    'approved': '#429EBD',
                    'completed': '#9FE7F5',
                    'cancelled': '#F27F0C',
                    'rejected': '#F27F0C',
                    'reschedule_requested': '#F27F0C',
                    'rescheduled': '#053F5C'
                };
                const statusColor = statusColors[props.status?.toLowerCase()] || '#053F5C';
                
                html = `
                    <div class="text-center mb-3">
                        <div class="rounded d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: ${statusColor};">
                            <i class="bi bi-person fs-2 text-white"></i>
                        </div>
                    </div>
                    <h5>${event.title}</h5>
                    <hr>
                    <p><strong>Student:</strong> ${props.student}</p>
                    <p><strong>Date:</strong> ${event.start.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                    <p><strong>Time:</strong> ${event.start.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })} - ${event.end.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}</p>
                    <p><strong>Status:</strong> <span class="badge" style="background: ${statusColor}; color: var(--navy);">${props.status}</span></p>
                    <p><strong>Purpose:</strong> ${props.purpose}</p>
                    ${props.notes ? `<p><strong>Notes:</strong> ${props.notes}</p>` : ''}
                `;
            }
            
            content.innerHTML = html;
            modal.show();
        }
    });
</script>
@endsection