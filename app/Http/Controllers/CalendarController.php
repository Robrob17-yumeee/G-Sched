<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\AppointmentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $availabilities = Availability::where('guidance_associate_id', $user->id)
            ->where('available_date', '>=', Carbon::today())
            ->orderBy('available_date')
            ->get()
            ->groupBy('available_date');

        $appointments = Appointment::where('guidance_associate_id', $user->id)
            ->where('appointment_date', '>=', Carbon::today())
            ->with(['student', 'status'])
            ->orderBy('appointment_date')
            ->get()
            ->groupBy('appointment_date');

        $availableDatesMap = [];
        foreach ($availabilities as $date => $days) {
            $dateStr = Carbon::parse($date)->format('Y-m-d');
            $slotCount = 0;
            $availabilityData = [];

            foreach ($days as $availability) {
                $start = Carbon::parse($dateStr . ' ' . $availability->start_time->format('H:i'));
                $end = Carbon::parse($dateStr . ' ' . $availability->end_time->format('H:i'));
                $duration = $availability->slot_duration;

                $slotEnd = $start->copy()->addMinutes($duration);
                if ($slotEnd <= $end) {
                    $isBooked = Appointment::where('guidance_associate_id', $availability->guidance_associate_id)
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
                            'start_time' => $start->format('H:i'),
                            'end_time' => $slotEnd->format('H:i'),
                            'formatted_time' => $start->format('g:i A') . ' - ' . $slotEnd->format('g:i A'),
                        ];
                    }
                }
            }

            $availableDatesMap[$dateStr] = [
                'slotCount' => $slotCount,
                'availabilityData' => $availabilityData,
            ];
        }

        $appointmentsMap = [];
        foreach ($appointments as $date => $apps) {
            $dateStr = Carbon::parse($date)->format('Y-m-d');
            $appointmentsMap[$dateStr] = [];
            foreach ($apps as $appt) {
                $appointmentsMap[$dateStr][] = [
                    'id' => $appt->id,
                    'student_name' => $appt->student ? $appt->student->full_name : 'Unknown',
                    'time' => $appt->start_time->format('g:i A') . ' - ' . $appt->end_time->format('g:i A'),
                    'status' => $appt->status->name ?? '',
                    'status_label' => $appt->status->label ?? '',
                    'purpose' => $appt->purpose,
                    'notes' => $appt->notes,
                ];
            }
        }

        return view('guidance.calendar', compact('availableDatesMap', 'appointmentsMap'));
    }

    public function events(Request $request)
    {
        $user = Auth::user();
        $start = Carbon::parse($request->query('start'));
        $end = Carbon::parse($request->query('end'));

        // Get availabilities
        $availabilities = Availability::where('guidance_associate_id', $user->id)
            ->where('available_date', '>=', $start->toDateString())
            ->where('available_date', '<=', $end->toDateString())
            ->get();

        // Get appointments
        $appointments = Appointment::where('guidance_associate_id', $user->id)
            ->where('appointment_date', '>=', $start->toDateString())
            ->where('appointment_date', '<=', $end->toDateString())
            ->with('status')
            ->get();

        $events = [];

        // Add availability slots
        foreach ($availabilities as $avail) {
            $events[] = [
                'id' => 'avail-' . $avail->id,
                'title' => 'Available: ' . $avail->start_time->format('g:i A') . ' - ' . $avail->end_time->format('g:i A'),
                'start' => $avail->available_date->format('Y-m-d') . 'T' . $avail->start_time->format('H:i:s'),
                'end' => $avail->available_date->format('Y-m-d') . 'T' . $avail->end_time->format('H:i:s'),
                'backgroundColor' => $avail->isAvailable() ? '#28a745' : '#ffc107',
                'borderColor' => $avail->isAvailable() ? '#28a745' : '#ffc107',
                'extendedProps' => [
                    'type' => 'availability',
                    'status' => $avail->status,
                ],
            ];
        }

        // Add appointments
        foreach ($appointments as $appt) {
            $color = match ($appt->status->name ?? '') {
                'pending' => '#ffc107',
                'approved' => '#0d6efd',
                'completed' => '#28a745',
                'cancelled' => '#dc3545',
                'rejected' => '#dc3545',
                'reschedule_requested' => '#fd7e14',
                'rescheduled' => '#6f42c1',
                default => '#6c757d',
            };

            $events[] = [
                'id' => 'appt-' . $appt->id,
                'title' => $appt->student->full_name . ' - ' . $appt->status->label,
                'start' => $appt->appointment_date->format('Y-m-d') . 'T' . $appt->start_time->format('H:i:s'),
                'end' => $appt->appointment_date->format('Y-m-d') . 'T' . $appt->end_time->format('H:i:s'),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => '#fff',
                'extendedProps' => [
                    'type' => 'appointment',
                    'student' => $appt->student->full_name,
                    'purpose' => $appt->purpose,
                    'status' => $appt->status->label,
                    'notes' => $appt->notes,
                ],
            ];
        }

        return response()->json($events);
    }
}