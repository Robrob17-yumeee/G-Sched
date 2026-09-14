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
        return view('guidance.calendar');
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