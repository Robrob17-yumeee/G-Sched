@extends('layouts.app')

@section('title', ' - All Appointments')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">All Appointments</h1>
</div>

@if($appointments->count() > 0)
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Guidance Associate</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->student->full_name }}</td>
                                <td>{{ $appointment->guidanceAssociate->full_name ?? 'N/A' }}</td>
                                <td>{{ $appointment->formatted_date }}</td>
                                <td>{{ $appointment->formatted_time }}</td>
                                <td>{{ Str::limit($appointment->purpose, 50) }}</td>
                                <td>
                                    <span class="badge" style="background: {{ $appointment->status->color ?? '#64748B' }}; color: #053F5C;">
                                        {{ $appointment->status->label }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-calendar-check fs-1 text-muted"></i>
        <h4 class="mt-3 text-muted">No Appointments</h4>
    </div>
@endif
@endsection