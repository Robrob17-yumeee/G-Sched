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

    .schedule-card {
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        transition: all 0.2s ease;
    }

    .schedule-card:hover {
        border-color: var(--medium-blue);
        box-shadow: 0 8px 20px rgba(5, 63, 92, 0.08);
        transform: translateY(-2px);
    }

    .date-card {
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        background: var(--card-bg);
        transition: all 0.2s ease;
        padding: 1.5rem;
    }

    .date-card:hover {
        border-color: var(--medium-blue);
        box-shadow: 0 8px 20px rgba(5, 63, 92, 0.08);
        transform: translateY(-2px);
    }

    .date-card.no-slots {
        border-color: var(--border-color);
        background: var(--bg-light);
    }

    .date-card.no-slots:hover {
        transform: none;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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

    .kpi-card.schedules {
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

    .kpi-icon.schedules { background: rgba(66, 158, 189, 0.15); color: var(--navy); }

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

    .btn-primary {
        background: var(--medium-blue);
        border: none;
        border-radius: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-weight: 500;
        color: var(--navy);
    }

    .btn-primary:hover {
        background: #6fa8c4;
    }

    .btn-secondary {
        background: var(--border-color);
        border: none;
        border-radius: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-weight: 500;
        color: var(--navy);
    }

    .btn-secondary:hover {
        background: #E2E8F0;
    }

    .btn-disabled {
        background: var(--border-color-light);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-weight: 500;
    }

    .form-label {
        color: var(--navy);
        font-weight: 500;
        margin-bottom: 0.375rem;
    }

    .readonly-field {
        background: var(--bg-light);
        border-color: var(--border-color);
        color: var(--text-primary);
    }
</style>
@endsection

@section('content')
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endforeach

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h2 mb-1" style="color: var(--navy); font-weight: 700;">Available Schedules</h1>
                <p class="text-muted mb-0">Browse and book available counseling sessions</p>
            </div>
            <div class="kpi-card schedules d-flex align-items-center gap-3" style="min-width: 200px;">
                <div class="kpi-icon schedules">
                    <i class="bi bi-calendar-week fs-3"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 text-uppercase small" style="letter-spacing: 0.05em;">Available Days</p>
                    <h5 class="mb-0" style="color: var(--navy); font-weight: 700;">{{ $availableDates->count() }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

@if($availableDates->count() > 0)
    <div class="row g-4">
        @foreach($availableDates as $date => $availabilities)
            @php
                $dateStr = \Carbon\Carbon::parse($date)->format('Y-m-d');
                $dateObj = \Carbon\Carbon::parse($dateStr);
                $firstAvailability = $availabilities->first();
                $guidanceAssociate = $firstAvailability->guidanceAssociate;
                $slotCount = 0;
                $availabilityData = [];

                foreach ($availabilities as $availability) {
                    $start = \Carbon\Carbon::parse($dateStr . ' ' . $availability->start_time->format('H:i'));
                    $end = \Carbon\Carbon::parse($dateStr . ' ' . $availability->end_time->format('H:i'));
                    $duration = $availability->slot_duration;

                    while ($start->copy()->addMinutes($duration) <= $end) {
                        $slotEnd = $start->copy()->addMinutes($duration);

                        $isBooked = \App\Models\Appointment::where('guidance_associate_id', $availability->guidance_associate_id)
                            ->where('appointment_date', $date)
                            ->where('start_time', $start->format('H:i'))
                            ->where('end_time', $slotEnd->format('H:i'))
                            ->whereHas('status', function ($q) {
                                $q->whereIn('name', ['pending', 'approved']);
                            })
                            ->exists();

                        if (!$isBooked) {
                            $slotCount++;
                            $availabilityData[] = [
                                'availability_id' => $availability->id,
                                'guidance_associate_id' => $availability->guidance_associate_id,
                                'start_time' => $start->format('H:i'),
                                'end_time' => $slotEnd->format('H:i'),
                                'formatted_time' => $start->format('g:i A') . ' - ' . $slotEnd->format('g:i A'),
                            ];
                        }

                        $start = $slotEnd;
                    }
                }
            @endphp

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card date-card {{ $slotCount > 0 ? '' : 'no-slots' }}">
                    <div class="card-header" style="border-bottom: 1px solid var(--border-color-light);">
                        <h5 class="mb-0" style="color: var(--navy); font-weight: 600;">
                            <i class="bi bi-calendar-date me-2" style="color: var(--medium-blue);"></i>
                            {{ $dateObj->format('l, F d, Y') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-badge me-1" style="color: var(--medium-blue);"></i>
                                <div>
                                    <p class="text-muted small mb-0">Guidance Associate</p>
                                    <p class="fw-medium mb-0" style="color: var(--navy);">{{ $guidanceAssociate->full_name }}</p>
                                </div>
                            </div>
                        </div>

                        @if($slotCount > 0)
                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-clock me-1" style="color: var(--medium-blue);"></i>
                                    <p class="mb-0 fw-medium" style="color: var(--navy);">{{ $slotCount }} {{ $slotCount === 1 ? 'slot' : 'slots' }} available</p>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary w-100"
                                    data-bs-toggle="modal"
                    data-bs-target="#bookingModal"
                    data-date="{{ $dateStr }}"
                    data-date-display="{{ $dateObj->format('F d, Y') }}"
                    data-guidance-associate="{{ $guidanceAssociate->full_name }}"
                    data-guidance-associate-id="{{ $guidanceAssociate->id }}"
                    data-availability-json="{{ json_encode($availabilityData) }}">
                                <i class="bi bi-plus-circle me-2"></i>Book Appointment
                            </button>
                        @else
                            <div class="mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-clock-slash me-1" style="color: #94A3B8;"></i>
                                    <p class="mb-0 text-muted fw-medium">No available slots</p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-disabled w-100" disabled>
                                <i class="bi bi-slash-circle me-2"></i>No Slots Available
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-calendar-x fs-1" style="color: var(--text-muted); opacity: 0.5;"></i>
            <h4 class="mt-3 text-muted">No Available Schedules</h4>
            <p class="text-muted">There are currently no available counseling schedules. Please check back later.</p>
        </div>
    </div>
@endif

<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--medium-blue); color: var(--navy);">
                <h5 class="modal-title" id="bookingModalLabel">
                    <i class="bi bi-calendar-plus me-2"></i>Book Appointment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('student.appointments.store') }}" id="bookingForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="availability_id" id="modal_availability_id">
                    <input type="hidden" name="appointment_date" id="modal_appointment_date">
                    <input type="hidden" name="start_time" id="modal_start_time">
                    <input type="hidden" name="end_time" id="modal_end_time">
                    <input type="hidden" name="guidance_associate_id" id="modal_guidance_associate_id">

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="text" class="form-control readonly-field" id="modal_date_display" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Guidance Associate</label>
                        <input type="text" class="form-control readonly-field" id="modal_guidance_associate_name" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: var(--navy);">Time Slot <span class="text-danger">*</span></label>
                        <select class="form-select" id="modal_time_slot" required>
                            <option value="">Select a time slot</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: var(--navy);">Purpose of Appointment <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="purpose" name="purpose" rows="4" required placeholder="Please describe the reason for your appointment..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: var(--navy);">Severity <span class="text-danger">*</span></label>
                        <select class="form-select @error('severity') is-invalid @enderror" id="severity" name="severity" required>
                            <option value="low">Low - General counseling</option>
                            <option value="medium">Medium - Ongoing concern</option>
                            <option value="high">High - Urgent/Confidential (Admin only)</option>
                        </select>
                        @error('severity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>High severity:</strong> Your identity will be confidential. Only admins can see your details.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0" style="border-radius: 0 0 1rem 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let selectedSlot = null;
    let currentModalData = null;

    document.addEventListener('DOMContentLoaded', function() {
        const bookingModal = document.getElementById('bookingModal');
        const bookingForm = document.getElementById('bookingForm');
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-danger';
        errorAlert.style.display = 'none';
        errorAlert.style.borderRadius = '0.5rem';
        errorAlert.setAttribute('role', 'alert');
        bookingForm.querySelector('.modal-body').prepend(errorAlert);

        bookingModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const date = button.getAttribute('data-date');
            const dateDisplay = button.getAttribute('data-date-display');
            const guidanceAssociateName = button.getAttribute('data-guidance-associate');
            const guidanceAssociateId = button.getAttribute('data-guidance-associate-id');
            const availabilityJson = button.getAttribute('data-availability-json');

            currentModalData = {
                date: date,
                dateDisplay: dateDisplay,
                guidanceAssociateName: guidanceAssociateName,
                guidanceAssociateId: guidanceAssociateId,
                availabilityJson: availabilityJson
            };

            document.getElementById('modal_date_display').value = dateDisplay;
            document.getElementById('modal_appointment_date').value = date;
            document.getElementById('modal_guidance_associate_name').value = guidanceAssociateName;
            document.getElementById('modal_guidance_associate_id').value = guidanceAssociateId;

            const timeSlotSelect = document.getElementById('modal_time_slot');
            timeSlotSelect.innerHTML = '<option value="">Select a time slot</option>';

            try {
                const slots = JSON.parse(availabilityJson);
                slots.forEach(function(slot) {
                    const option = document.createElement('option');
                    option.value = slot.availability_id + '|' + slot.start_time + '|' + slot.end_time;
                    option.textContent = slot.formatted_time;
                    timeSlotSelect.appendChild(option);
                });
            } catch (e) {
                console.error('Error parsing availability data:', e);
            }

            errorAlert.style.display = 'none';
            errorAlert.textContent = '';

            selectedSlot = null;
            document.getElementById('bookingForm').reset();
            timeSlotSelect.value = '';

            document.getElementById('modal_guidance_associate_name').readOnly = true;
            document.getElementById('modal_availability_id').value = '';
            document.getElementById('modal_start_time').value = '';
            document.getElementById('modal_end_time').value = '';
        });

        // Time slot change handler
        document.getElementById('modal_time_slot').addEventListener('change', function() {
            const selected = this.value;
            if (selected) {
                const parts = selected.split('|');
                document.getElementById('modal_availability_id').value = parts[0];
                document.getElementById('modal_start_time').value = parts[1];
                document.getElementById('modal_end_time').value = parts[2];
                selectedSlot = parts;
            } else {
                selectedSlot = null;
            }
        });

        // Form submission handler
        bookingForm.addEventListener('submit', function(e) {
            if (!selectedSlot) {
                e.preventDefault();
                errorAlert.style.display = 'block';
                errorAlert.textContent = 'Please select a time slot.';
                return;
            }
        });

        bookingModal.addEventListener('hidden.bs.modal', function() {
            resetSelection();
            document.getElementById('bookingForm').reset();
            document.getElementById('modal_time_slot').innerHTML = '<option value="">Select a time slot</option>';
            errorAlert.style.display = 'none';
            errorAlert.textContent = '';
        });
    });

    function resetSelection() {
        selectedSlot = null;
        const submitBtn = document.querySelector('#bookingForm button[type="submit"]');
        if (submitBtn) submitBtn.disabled = false;
    }
</script>
@endsection
