@extends('layouts.app')

@section('title', ' - Calendar')

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
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-1" style="color: var(--navy); font-weight: 700;">Calendar</h1>
        <p class="text-muted mb-0">View your appointments and availability schedule</p>
    </div>
</div>

<div class="calendar-component">
    <!-- Left Panel - Selected Date Information -->
    <div class="calendar-left-panel">
        <div class="panel-header">
            <h5><i class="bi bi-info-circle me-2"></i>Selected Date</h5>
        </div>
        <div id="selectedDateInfo">
            <div class="no-appointment-msg">
                <i class="bi bi-calendar-check"></i>
                <p class="mb-0">Select a date to view schedule details.</p>
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
@endsection

@section('scripts')
<script>
    // Available dates data passed from PHP
    const availableDatesMap = @json($availableDatesMap);
    const appointmentsMap = @json($appointmentsMap);

    document.addEventListener('DOMContentLoaded', function() {
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

            const firstDay = new Date(currentYear, currentMonth, 1);
            const startingDay = firstDay.getDay();

            const prevMonthLastDate = new Date(currentYear, currentMonth, 0);
            for (let i = startingDay - 1; i >= 0; i--) {
                const dayEl = document.createElement('div');
                dayEl.className = 'calendar-day other-month';
                const dayNum = prevMonthLastDate.getDate() - i;
                dayEl.innerHTML = '<span class="calendar-day-number">' + dayNum + '</span>';
                calendarDays.appendChild(dayEl);
            }

            const today = new Date();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            for (let d = 1; d <= daysInMonth; d++) {
                const day = new Date(currentYear, currentMonth, d);
                const dayStr = formatDate(day);

                const dayEl = document.createElement('div');
                dayEl.className = 'calendar-day';
                dayEl.setAttribute('data-date', dayStr);

                if (day.toDateString() === today.toDateString()) {
                    dayEl.classList.add('today');
                }

                if (dayStr === selectedDateStr) {
                    dayEl.classList.add('selected');
                }

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
            const apptData = appointmentsMap[dateStr] || [];

            panel.innerHTML = '';

            let contentHtml = `
                <div class="date-number">${dateObj.getDate()}</div>
                <div class="date-day">${getDayName(dateObj.getDay())}</div>
                <div class="date-full">${dateObj.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</div>
            `;

            let hasContent = false;

            if (dateData && dateData.slotCount > 0) {
                hasContent = true;
                contentHtml += '<div class="detail-section"><div class="detail-label">Availability</div></div>';

                const avHtml = `
                    <div class="schedule-session-item">
                        <div class="session-time">${dateData.availabilityData[0].formatted_time}</div>
                        <div class="session-slots">
                            <span class="slots-badge">${dateData.slotCount} ${dateData.slotCount === 1 ? 'slot' : 'slots'} available</span>
                        </div>
                    </div>
                `;
                contentHtml += avHtml;
            }

            if (apptData.length > 0) {
                hasContent = true;
                contentHtml += '<div class="detail-section"><div class="detail-label">Appointments</div></div>';

                apptData.forEach(function(appt) {
                    const statusColors = {
                        'pending': '#F7AD19',
                        'approved': '#429EBD',
                        'completed': '#21db3d',
                        'cancelled': '#db213a',
                        'rejected': '#db213a',
                        'reschedule_requested': '#F27F0C',
                        'rescheduled': '#053F5C'
                    };
                    const statusColor = statusColors[appt.status] || '#053F5C';

                    contentHtml += `
                        <div class="schedule-session-item">
                            <div class="d-flex justify-content-space-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="session-time">${appt.student_name}</div>
                                    <div class="session-associate">${new Date(appt.time.split(' - ')[0]).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })} - ${appt.time.split(' - ')[1] || ''}</div>
                                </div>
                                <span class="slots-badge" style="background: ${statusColor}; color: #FFFFFF;">${appt.status_label}</span>
                            </div>
                        </div>
                    `;
                });
            }

            if (hasContent) {
                const contentDiv = document.createElement('div');
                contentDiv.innerHTML = contentHtml;
                panel.appendChild(contentDiv);
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

        // Initialize calendar
        renderCalendar();
    });
</script>
@endsection
