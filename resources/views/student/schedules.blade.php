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
        cursor: pointer;
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

    .kpi-icon.schedules { background: rgba(66, 158, 189, 0.2); color: #429EBD; }

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
        color: #FFFFFF;
        min-height: 44px;
    }

    .btn-primary:hover {
        background: var(--navy);
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
        background: var(--border-color-light);
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

    /* View Switch Control */
    .view-switch {
        display: inline-flex;
        align-items: center;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 0.375rem;
        box-shadow: 0 1px 3px rgba(5, 63, 92, 0.08);
    }

    .view-switch .view-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: none;
        background: transparent;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        color: var(--text-muted);
    }

    .view-switch .view-btn:hover {
        color: var(--medium-blue);
    }

    .view-switch .view-btn.active {
        background: var(--medium-blue);
        color: #FFFFFF;
    }

    .view-switch .view-btn.active i {
        color: #FFFFFF;
    }

    .view-switch .view-btn i {
        color: var(--medium-blue);
        font-size: 1.1rem;
    }

    /* Unified Calendar Component */
    .calendar-component {
        display: flex;
        gap: 1.5rem;
        background: var(--card-bg);
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(5, 63, 92, 0.08), 0 1px 2px rgba(5, 63, 92, 0.05);
        border: 1px solid var(--border-color);
        overflow: hidden;
        height: 440px;
        min-height: 440px;
    }

    /* Left Panel - Date Details */
    .calendar-left-panel {
        background: var(--card-bg);
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        width: 320px;
        border-right: 1px solid var(--border-color);
        height: 440px;
        min-height: 440px;
    }

    .calendar-left-panel .panel-header {
        border-bottom: 1px solid var(--border-color-light);
        padding-bottom: 0.75rem;
        margin-bottom: 1rem;
    }

    .calendar-left-panel #selectedDateInfo {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .panel-header h5 {
        margin: 0;
        color: var(--navy);
        font-weight: 600;
    }

     .date-number {
        font-size: 3rem;
        font-weight: 700;
        color: var(--navy);
        line-height: 1;
    }

    .date-day {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--medium-blue);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0.25rem 0;
    }

     .date-full {
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    .detail-section {
        margin-top: 0.75rem;
    }

    .detail-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 0.25rem;
    }

    .slots-badge {
        background: var(--light-blue);
        color: var(--navy);
        border-radius: 1rem;
        padding: 0.375rem 0.875rem;
        font-size: 0.9rem;
        font-weight: 500;
        display: inline-block;
    }

     .no-appointment-msg {
        text-align: center;
        padding: 1.5rem 1rem;
        color: var(--text-muted);
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .no-appointment-msg i {
        font-size: 2rem;
        opacity: 0.3;
        margin-bottom: 0.75rem;
    }

    .action-btn {
        background: var(--medium-blue);
        color: #FFFFFF;
        border: none;
        border-radius: 0.75rem;
        padding: 0.625rem 1.25rem;
        font-weight: 500;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: auto;
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 40px;
        width: 100%;
        flex-shrink: 0;
    }

    .action-btn:hover {
        background: var(--navy);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 63, 92, 0.15);
    }

    .schedule-session-item {
        background: var(--bg-light);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.375rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .schedule-session-item:hover {
        border-color: var(--medium-blue);
        background: var(--card-bg);
    }

    .schedule-session-item.selected {
        border-color: var(--medium-blue);
        background: var(--card-bg);
        box-shadow: 0 0 0 2px rgba(66, 158, 189, 0.3);
    }

    .session-time {
        font-weight: 600;
        color: var(--navy);
        font-size: 1rem;
    }

    .session-associate {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    .session-slots {
        margin-top: 0.375rem;
    }

    /* Right Panel - Calendar */
    .calendar-right-panel {
        flex: 1;
        padding: 1.5rem;
        height: 440px;
        min-height: 440px;
    }

    .calendar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color-light);
    }

    .calendar-header .nav-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .calendar-nav-btn {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        color: var(--navy);
        font-size: 1.1rem;
    }

    .calendar-nav-btn:hover {
        background: var(--medium-blue);
        color: #FFFFFF;
    }

    .calendar-month-year {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--navy);
        min-width: 180px;
        text-align: center;
    }

    .calendar-today-btn {
        background: var(--light-blue);
        color: var(--navy);
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .calendar-today-btn:hover {
        background: var(--medium-blue);
        color: #FFFFFF;
    }

    /* Fixed 7-column calendar grid */
    .calendar-weekday-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        background: var(--border-color);
        border-radius: 0.5rem;
        gap: 0;
        width: 100%;
    }

    .calendar-day-header {
        background: var(--navy);
        color: #FFFFFF;
        padding: 0.5rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .calendar-day {
        background: var(--card-bg);
        height: 50px;
        min-height: 50px;
        padding: 0.4rem;
        position: relative;
        text-align: right;
        border: 1px solid var(--border-color-light);
        box-sizing: border-box;
        min-width: 0;
    }

    .calendar-day-number {
        font-weight: 500;
        font-size: 0.9rem;
        color: var(--navy);
    }

    .calendar-day.other-month {
        background: var(--bg-light);
        color: var(--text-muted);
        opacity: 0.5;
    }

    .calendar-day.today::after {
        content: '';
        position: absolute;
        top: 4px;
        right: 4px;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--yellow);
    }

    .calendar-day.available .calendar-day-number {
        color: var(--medium-blue);
        font-weight: 600;
    }

    .calendar-day.available::before {
        content: '';
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--medium-blue);
    }

    .calendar-day.selected {
        background: var(--medium-blue);
        color: #FFFFFF;
        cursor: default;
    }

    .calendar-day.selected .calendar-day-number {
        color: #FFFFFF;
        font-weight: 700;
    }

    .calendar-day.selected::after {
        content: '';
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #FFFFFF;
    }

    .calendar-day.available:hover {
        background: rgba(66, 158, 189, 0.1);
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .calendar-component {
            flex-direction: column;
            height: auto;
            min-height: 440px;
            max-height: none;
        }

        .calendar-left-panel {
            border-right: none;
            border-bottom: 1px solid var(--border-color);
            width: auto;
            height: auto;
        }

        .calendar-right-panel {
            height: auto;
            min-height: auto;
        }

        .calendar-day {
            min-height: 60px;
        }
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
            <div class="d-flex align-items-center">
                <div class="view-switch">
                    <button type="button" class="view-btn active" data-view="calendar">
                        <i class="bi bi-calendar3"></i> Calendar View
                    </button>
                    <button type="button" class="view-btn" data-view="card">
                        <i class="bi bi-grid-1x2"></i> Card View
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    // Build available dates map for calendar
    $availableDatesMap = [];
    foreach ($availableDates as $date => $availabilities) {
        $dateStr = \Carbon\Carbon::parse($date)->format('Y-m-d');
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
                        'guidance_associate_name' => $availability->guidanceAssociate->full_name,
                        'guidance_associate_id_val' => $availability->guidance_associate_id,
                    ];
                }

                $start = $slotEnd;
            }
        }

        $firstAvailability = $availabilities->first();
        $availableDatesMap[$dateStr] = [
            'slotCount' => $slotCount,
            'availabilityData' => $availabilityData,
            'firstAvailability' => [
                'guidanceAssociate' => [
                    'id' => $firstAvailability->guidanceAssociate->id,
                    'full_name' => $firstAvailability->guidanceAssociate->full_name,
                ],
            ],
        ];
    }
@endphp

<!-- Calendar View -->
<div id="calendarView" class="view-content">
    <div class="calendar-component">
        <!-- Left Panel - Selected Date Information -->
        <div class="calendar-left-panel">
            <div class="panel-header">
                <h5><i class="bi bi-info-circle me-2"></i>Selected Date</h5>
            </div>
            <div id="selectedDateInfo">
                <div class="no-appointment-msg">
                    <i class="bi bi-calendar-check"></i>
                    <p class="mb-0">Select an available date to view schedule details.</p>
                </div>
            </div>
        </div>

        <!-- Right Panel - Calendar -->
        <div class="calendar-right-panel">
            <div class="calendar-header">
                <div class="nav-item">
                    <button type="button" class="calendar-nav-btn" id="prevMonth" aria-label="Previous month">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <span class="calendar-month-year" id="currentMonthYear"></span>
                    <button type="button" class="calendar-nav-btn" id="nextMonth" aria-label="Next month">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                <button type="button" class="calendar-today-btn" id="todayBtn">Today</button>
            </div>

            <div class="calendar-weekday-header">
                @php
                    $daysOfWeek = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
                @endphp
                @foreach($daysOfWeek as $day)
                    <div class="calendar-day-header">{{ $day }}</div>
                @endforeach
            </div>
            <div class="calendar-grid" id="calendarGrid"></div>
        </div>
    </div>
</div>

<!-- Card View -->
<div id="cardView" class="view-content" style="display: none;">
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
                                        <i class="bi bi-clock-slash me-1" style="color: var(--navy);"></i>
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
</div>

<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                <div class="modal-footer border-0">
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
    let currentDateObj = null;
    let selectedSchedule = null;

    // Available dates data passed from PHP
    const availableDatesMap = @json($availableDatesMap);

    document.addEventListener('DOMContentLoaded', function() {
        const bookingModal = document.getElementById('bookingModal');
        const bookingForm = document.getElementById('bookingForm');

        // View switching
        const viewButtons = document.querySelectorAll('.view-switch .view-btn');
        const viewContents = document.querySelectorAll('.view-content');

        viewButtons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const targetView = this.getAttribute('data-view');

                viewButtons.forEach(b => b.classList.remove('active'));
                viewContents.forEach(c => c.style.display = 'none');

                this.classList.add('active');
                document.getElementById(targetView + 'View').style.display = 'block';

                if (targetView === 'calendar') {
                    renderCalendar();
                }
            });
        });

        // Calendar state
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let selectedDateStr = null;

        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                           'July', 'August', 'September', 'October', 'November', 'December'];

        function renderCalendar() {
            const monthYearDisplay = document.getElementById('currentMonthYear');
            monthYearDisplay.textContent = monthNames[currentMonth] + ' ' + currentYear;

            const calendarDays = document.getElementById('calendarGrid');
            calendarDays.innerHTML = '';

            // First day of the month (0 = Sunday, 1 = Monday, etc.)
            const firstDay = new Date(currentYear, currentMonth, 1);
            const startingDay = firstDay.getDay();

            // Previous month's trailing days to fill first week
            const prevMonthLastDate = new Date(currentYear, currentMonth, 0);
            for (let i = startingDay - 1; i >= 0; i--) {
                const dayEl = document.createElement('div');
                dayEl.className = 'calendar-day other-month';
                const dayNum = prevMonthLastDate.getDate() - i;
                dayEl.innerHTML = '<span class="calendar-day-number">' + dayNum + '</span>';
                calendarDays.appendChild(dayEl);
            }

            // Current month's days
            const today = new Date();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            for (let d = 1; d <= daysInMonth; d++) {
                const day = new Date(currentYear, currentMonth, d);
                const dayStr = formatDate(day);

                const dayEl = document.createElement('div');
                dayEl.className = 'calendar-day';
                dayEl.setAttribute('data-date', dayStr);

                // Check if today
                if (day.toDateString() === today.toDateString()) {
                    dayEl.classList.add('today');
                }

                // Check if selected
                if (dayStr === selectedDateStr) {
                    dayEl.classList.add('selected');
                }

                // Check if available (has schedules with slots)
                const dateData = availableDatesMap[dayStr];
                if (dateData && dateData.slotCount > 0) {
                    dayEl.classList.add('available');
                    dayEl.addEventListener('click', function() {
                        selectDate(day, dayStr);
                    });
                }

                dayEl.innerHTML = '<span class="calendar-day-number">' + d + '</span>';
                calendarDays.appendChild(dayEl);
            }

            // Next month's leading days to fill last row
            const totalCells = startingDay + daysInMonth;
            const remainingCells = (Math.ceil(totalCells / 7) * 7) - totalCells;
            for (let i = 1; i <= remainingCells; i++) {
                const dayEl = document.createElement('div');
                dayEl.className = 'calendar-day other-month';
                dayEl.innerHTML = '<span class="calendar-day-number">' + i + '</span>';
                calendarDays.appendChild(dayEl);
            }
        }

        function formatDate(date) {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const d = String(date.getDate()).padStart(2, '0');
            return y + '-' + m + '-' + d;
        }

        function selectDate(dateObj, dateStr) {
            selectedDateStr = dateStr;
            currentDateObj = dateObj;
            selectedSchedule = null;

            // Update selected state in calendar
            document.querySelectorAll('.calendar-day.selected').forEach(el => {
                el.classList.remove('selected');
            });
            const selectedEl = document.querySelector('.calendar-day[data-date="' + dateStr + '"]');
            if (selectedEl) {
                selectedEl.classList.add('selected');
            }

            updateSelectedDateInfo(dateObj, dateStr);
        }

        function getDayName(dayIndex) {
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            return days[dayIndex];
        }

        function updateSelectedDateInfo(dateObj, dateStr) {
            const panel = document.getElementById('selectedDateInfo');
            const dateData = availableDatesMap[dateStr];

            // Reset panel structure
            panel.innerHTML = '';

            if (dateData && dateData.slotCount > 0) {
                const firstAvail = dateData.firstAvailability;
                const associateName = firstAvail ? firstAvail.guidanceAssociate.full_name : 'Unknown';

                let contentHtml = `
                    <div class="date-number">${dateObj.getDate()}</div>
                    <div class="date-day">${getDayName(dateObj.getDay())}</div>
                    <div class="date-full">${dateObj.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</div>
                `;

                // Check if multiple schedules exist
                if (dateData.availabilityData && dateData.availabilityData.length > 0) {
                    // Group by guidance associate
                    const sessionsByAssoc = {};
                    dateData.availabilityData.forEach(slot => {
                        const key = slot.guidance_associate_name;
                        if (!sessionsByAssoc[key]) {
                            sessionsByAssoc[key] = [];
                        }
                        sessionsByAssoc[key].push(slot);
                    });

                    contentHtml += '<div class="detail-section"><div class="detail-label">Available Sessions</div></div>';

                    let firstSession = true;
                    for (const [assoc, slots] of Object.entries(sessionsByAssoc)) {
                        const firstSlot = slots[0];
                        contentHtml += `<div class="schedule-session-item ${firstSession ? 'selected' : ''}"
                                 data-assoc="${assoc}"
                                 data-assoc-id="${firstSlot.guidance_associate_id}">
                            <div class="session-time">${firstSlot.formatted_time}</div>
                            <div class="session-associate">${assoc}</div>
                            <div class="session-slots">
                                <span class="slots-badge">${slots.length} ${slots.length === 1 ? 'slot' : 'slots'}</span>
                            </div>
                        </div>`;
                        if (firstSession) firstSession = false;
                    }
                } else {
                    contentHtml += '<div class="detail-section"><div class="detail-label">Guidance Associate</div><div class="detail-value">' + associateName + '</div></div>';
                    contentHtml += '<div class="detail-section"><div class="detail-label">Available Slots</div><div class="detail-value"><span class="slots-badge">' + dateData.slotCount + ' ' + (dateData.slotCount === 1 ? 'slot' : 'slots') + '</span></div></div>';
                }

                // Wrap content in a div that can scroll
                const contentDiv = document.createElement('div');
                contentDiv.innerHTML = contentHtml;
                panel.appendChild(contentDiv);

                // Book Appointment button at the bottom
                const firstAvailForBtn = dateData.firstAvailability;
                const btnAssocName = associateName;
                const btnAssocId = firstAvailForBtn ? firstAvailForBtn.guidanceAssociate.id : '';
                const avJson = JSON.stringify(dateData.availabilityData).replace(/"/g, '&quot;');

                const btnWrapper = document.createElement('div');
                btnWrapper.className = 'detail-section';
                btnWrapper.innerHTML = `
                    <button type="button" class="action-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#bookingModal"
                            data-date="${dateStr}"
                            data-date-display="${dateObj.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}"
                            data-guidance-associate="${btnAssocName}"
                            data-guidance-associate-id="${btnAssocId}"
                            data-availability-json="${avJson}">
                        <i class="bi bi-plus-circle"></i>Book Appointment
                    </button>
                `;
                panel.appendChild(btnWrapper);

                // Attach click handler to schedule items
                panel.querySelectorAll('.schedule-session-item').forEach(function(item) {
                    item.addEventListener('click', function() {
                        panel.querySelectorAll('.schedule-session-item').forEach(i => i.classList.remove('selected'));
                        this.classList.add('selected');

                        const assoc = this.getAttribute('data-assoc');
                        const assocId = this.getAttribute('data-assoc-id');

                        // Update button with selected session
                        const bookBtn = panel.querySelector('.action-btn');
                        if (bookBtn) {
                            bookBtn.setAttribute('data-guidance-associate', assoc);
                            bookBtn.setAttribute('data-guidance-associate-id', assocId);
                        }

                        selectedSchedule = {
                            id: assocId,
                            associate: assoc
                        };
                    });
                });
            } else {
                panel.innerHTML = `
                    <div class="date-number">${dateObj.getDate()}</div>
                    <div class="date-day">${getDayName(dateObj.getDay())}</div>
                    <div class="date-full">${dateObj.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</div>
                    <div class="no-appointment-msg">
                        <i class="bi bi-calendar-x"></i>
                        <p class="mt-2 mb-0">No available appointments on this date.</p>
                    </div>
                `;
            }
        }

        // Navigation handlers
        document.getElementById('prevMonth').addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        });

        document.getElementById('todayBtn').addEventListener('click', function() {
            const now = new Date();
            currentMonth = now.getMonth();
            currentYear = now.getFullYear();
            renderCalendar();
        });

        // Booking modal handler
        bookingModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const date = button.getAttribute('data-date');
            const dateDisplay = button.getAttribute('data-date-display');
            const guidanceAssociateName = button.getAttribute('data-guidance-associate');
            const guidanceAssociateId = button.getAttribute('data-guidance-associate-id');
            const availabilityJson = button.getAttribute('data-availability-json');

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

            selectedSlot = null;
            document.getElementById('bookingForm').reset();
            timeSlotSelect.value = '';

            document.getElementById('modal_guidance_associate_name').readOnly = true;
            document.getElementById('modal_availability_id').value = '';
            document.getElementById('modal_start_time').value = '';
            document.getElementById('modal_end_time').value = '';
        });

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

        bookingForm.addEventListener('submit', function(e) {
            if (!selectedSlot) {
                e.preventDefault();
                const timeSlotSelect = document.getElementById('modal_time_slot');
                timeSlotSelect.classList.add('is-invalid');
                return;
            }
        });

        bookingModal.addEventListener('hidden.bs.modal', function() {
            selectedSlot = null;
            document.getElementById('bookingForm').reset();
            document.getElementById('modal_time_slot').innerHTML = '<option value="">Select a time slot</option>';
            const timeSlotSelect = document.getElementById('modal_time_slot');
            if (timeSlotSelect) timeSlotSelect.classList.remove('is-invalid');
        });

        // Initialize calendar
        renderCalendar();
    });
</script>
@endsection
