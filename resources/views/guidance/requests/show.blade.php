@extends('layouts.app')

@section('title', ' - Appointment Request Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Appointment Request Details</h1>
    <a href="{{ route('guidance.requests') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Requests
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-person me-2"></i>Student Information</h5>
                @if($appointment->isHighSeverity() && !auth()->user()->isAdmin())
                    <span class="badge" style="background: #F27F0C; color: #053F5C;">Confidential - High Severity</span>
                @endif
            </div>
            <div class="card-body">
                @if($appointment->isHighSeverity() && !auth()->user()->isAdmin())
                    <div class="text-center py-4">
                        <i class="bi bi-shield-lock fs-1" style="color: #F7AD19;"></i>
                        <h5 class="mt-3">Confidential Appointment</h5>
                        <p class="text-muted">This is a high severity appointment. Student identity is hidden from guidance counselors.</p>
                        <span class="badge fs-6" style="background: #F27F0C; color: #053F5C;">HIGH SEVERITY</span>
                    </div>
                @else
                    <dl class="row">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $appointment->student->full_name }}</dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">{{ $appointment->student->email }}</dd>

                        <dt class="col-sm-3">Phone</dt>
                        <dd class="col-sm-9">{{ $appointment->student->phone ?: 'Not provided' }}</dd>

                        <dt class="col-sm-3">Student ID</dt>
                        <dd class="col-sm-9">{{ $appointment->student->student_id ?: 'N/A' }}</dd>
                    </dl>
                @endif
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Appointment Details</h5>
                <span class="badge fs-6" style="background: {{ $appointment->status->color ?? '#F7AD19' }}; color: #053F5C;">{{ $appointment->status->label }}</span>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Date</dt>
                    <dd class="col-sm-9">{{ $appointment->formatted_date }}</dd>

                    <dt class="col-sm-3">Time</dt>
                    <dd class="col-sm-9">{{ $appointment->formatted_time }}</dd>

                    <dt class="col-sm-3">Purpose</dt>
                    <dd class="col-sm-9">{{ $appointment->purpose }}</dd>

                    <dt class="col-sm-3">Requested</dt>
                    <dd class="col-sm-9">{{ $appointment->created_at->format('F d, Y g:i A') }}</dd>
                </dl>
            </div>
        </div>

        @if($appointment->rescheduleRequests->count() > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Reschedule Requests</h5>
                </div>
                <div class="card-body">
                    @foreach($appointment->rescheduleRequests as $request)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <h6>Request #{{ $request->id }}</h6>
                                <span class="badge bg-{{ $request->isPending() ? 'warning' : ($request->isApproved() ? 'success' : 'danger') }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </div>
                            <dl class="row">
                                <dt class="col-sm-3">Old Schedule</dt>
                                <dd class="col-sm-9">{{ $request->old_date->format('F d, Y') }} at {{ \Carbon\Carbon::parse($request->old_start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($request->old_end_time)->format('g:i A') }}</dd>
                                <dt class="col-sm-3">Requested Schedule</dt>
                                <dd class="col-sm-9">{{ $request->requested_date->format('F d, Y') }} at {{ \Carbon\Carbon::parse($request->requested_start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($request->requested_end_time)->format('g:i A') }}</dd>
                                <dt class="col-sm-3">Reason</dt>
                                <dd class="col-sm-9">{{ $request->reason }}</dd>
                                @if($request->reviewed_at)
                                    <dt class="col-sm-3">Reviewed By</dt>
                                    <dd class="col-sm-9">{{ $request->reviewer->full_name }} at {{ $request->reviewed_at->format('F d, Y g:i A') }}</dd>
                                @endif
                            </dl>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($appointment->isPending())
                        <form method="POST" action="{{ route('guidance.requests.approve', $appointment) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Approve this appointment?')">
                                <i class="bi bi-check-circle me-2"></i>Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('guidance.requests.reject', $appointment) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this appointment?')">
                                <i class="bi bi-x-circle me-2"></i>Reject
                            </button>
                        </form>
                    @endif
                    
                    @if($appointment->isPending() || $appointment->isApproved())
                        <a href="{{ route('guidance.requests.reschedule', $appointment) }}" class="btn btn-warning">
                            <i class="bi bi-calendar-event me-2"></i>Reschedule
                        </a>
                        
                        <form method="POST" action="{{ route('guidance.requests.cancel', $appointment) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-secondary" onclick="return confirm('Cancel this appointment?')">
                                <i class="bi bi-slash-circle me-2"></i>Cancel
                            </button>
                        </form>
                    @endif

                    @if($appointment->isApproved())
                        <form method="POST" action="{{ route('guidance.requests.complete', $appointment) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Mark this appointment as completed?')">
                                <i class="bi bi-check2-circle me-2"></i>Mark Completed
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('guidance.requests.remind', $appointment) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-info">
                                <i class="bi bi-bell me-2"></i>Send Reminder
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection