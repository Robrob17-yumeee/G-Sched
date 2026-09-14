<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentStatus;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $pendingStatus = AppointmentStatus::where('name', 'pending')->first();
        $approvedStatus = AppointmentStatus::where('name', 'approved')->first();
        
        $nextAppointment = Appointment::where('student_id', $user->id)
            ->whereIn('appointment_status_id', [$pendingStatus->id, $approvedStatus->id])
            ->where('appointment_date', '>=', Carbon::today())
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->first();
            
        $pendingCount = Appointment::where('student_id', $user->id)
            ->where('appointment_status_id', $pendingStatus->id)
            ->count();
            
        $approvedCount = Appointment::where('student_id', $user->id)
            ->where('appointment_status_id', $approvedStatus->id)
            ->count();
            
        $notifications = $user->notifications()->latest()->take(5)->get();

        return view('student.dashboard', compact(
            'nextAppointment',
            'pendingCount',
            'approvedCount',
            'notifications'
        ));
    }
}