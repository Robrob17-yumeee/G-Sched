<?php

namespace Database\Seeders;

use App\Models\AppointmentStatus;
use Illuminate\Database\Seeder;

class AppointmentStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'pending', 'label' => 'Pending', 'color' => '#F7AD19', 'description' => 'Appointment request submitted, awaiting approval', 'sort_order' => 1],
            ['name' => 'approved', 'label' => 'Approved', 'color' => '#429EBD', 'description' => 'Appointment approved by guidance associate', 'sort_order' => 2],
            ['name' => 'rejected', 'label' => 'Rejected', 'color' => '#F27F0C', 'description' => 'Appointment request rejected', 'sort_order' => 3],
            ['name' => 'reschedule_requested', 'label' => 'Reschedule Requested', 'color' => '#F27F0C', 'description' => 'Student requested to reschedule', 'sort_order' => 4],
            ['name' => 'rescheduled', 'label' => 'Rescheduled', 'color' => '#053F5C', 'description' => 'Appointment rescheduled to new time', 'sort_order' => 5],
            ['name' => 'cancelled', 'label' => 'Cancelled', 'color' => '#F27F0C', 'description' => 'Appointment cancelled', 'sort_order' => 6],
            ['name' => 'completed', 'label' => 'Completed', 'color' => '#9FE7F5', 'description' => 'Appointment completed', 'sort_order' => 7],
            ['name' => 'no_show', 'label' => 'No Show', 'color' => '#64748B', 'description' => 'Student did not attend appointment', 'sort_order' => 8],
        ];

        foreach ($statuses as $status) {
            AppointmentStatus::firstOrCreate(['name' => $status['name']], $status);
        }
    }
}