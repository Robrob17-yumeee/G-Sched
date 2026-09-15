@extends('layouts.app')

@section('title', ' - Appointment Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Appointment Details</h1>
    <a href="{{ route('guidance.appointments') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Appointments
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Appointment Information</h5>
                        <span class="badge fs-6" style="background: {{ $appointment->status->color ?? '#64748B' }}; color: #053F5C;">{{ $appointment->status->label }}</span>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Date</dt>
                    <dd class="col-sm-9">{{ $appointment->formatted_date }}</dd>

                    <dt class="col-sm-3">Time</dt>
                    <dd class="col-sm-9">{{ $appointment->formatted_time }}</dd>

                    <dt class="col-sm-3">Student</dt>
                    <dd class="col-sm-9">{{ $appointment->student->full_name }}</dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $appointment->student->email }}</dd>

                    <dt class="col-sm-3">Phone</dt>
                    <dd class="col-sm-9">{{ $appointment->student->phone ?: 'Not provided' }}</dd>

                    <dt class="col-sm-3">Purpose</dt>
                    <dd class="col-sm-9">{{ $appointment->purpose }}</dd>

                    @if($appointment->notes)
                        <dt class="col-sm-3">Notes</dt>
                        <dd class="col-sm-9">{{ $appointment->notes }}</dd>
                    @endif

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">
                <span class="badge fs-6" style="background: {{ $appointment->status->color ?? '#64748B' }}; color: #053F5C;">{{ $appointment->status->label }}</span>
                    </dd>

                    @if($appointment->approved_at)
                        <dt class="col-sm-3">Approved At</dt>
                        <dd class="col-sm-9">{{ $appointment->approved_at->format('F d, Y g:i A') }}</dd>
                    @endif

                    @if($appointment->completed_at)
                        <dt class="col-sm-3">Completed At</dt>
                        <dd class="col-sm-9">{{ $appointment->completed_at->format('F d, Y g:i A') }}</dd>
                    @endif

                    @if($appointment->cancelled_at)
                        <dt class="col-sm-3">Cancelled At</dt>
                        <dd class="col-sm-9">{{ $appointment->cancelled_at->format('F d, Y g:i A') }}</dd>
                        <dt class="col-sm-3">Cancellation Reason</dt>
                        <dd class="col-sm-9">{{ $appointment->cancellation_reason }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        @if($appointment->feedback)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-star me-2"></i>Student Feedback</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $appointment->feedback->rating ? '-fill' : ''}}" style="{{ $i <= $appointment->feedback->rating ? 'color: #F7AD19;' : 'color: var(--navy); opacity: 0.4;' }}" fs-4"></i>
                        @endfor
                    </div>
                    <p>{{ $appointment->feedback->comments }}</p>
                    <small class="text-muted">Submitted {{ $appointment->feedback->submitted_at->diffForHumans() }}</small>
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person me-2"></i>Student</h5>
            </div>
            <div class="card-body text-center">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; background: rgba(66, 158, 189, 0.15); color: var(--medium-blue);">
                    <i class="bi bi-person fs-1"></i>
                </div>
                <h5>{{ $appointment->student->full_name }}</h5>
                <p class="text-muted">{{ $appointment->student->email }}</p>
                @if($appointment->student->phone)
                    <p><i class="bi bi-telephone me-2"></i>{{ $appointment->student->phone }}</p>
                @endif
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($appointment->isApproved())
                        <form method="POST" action="{{ route('guidance.requests.complete', $appointment) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Mark this appointment as completed? Student will be notified to provide feedback.')">
                                <i class="bi bi-check2-circle me-2"></i>Mark Completed
                            </button>
                        </form>
                    @endif

                    @if($appointment->isCompleted())
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Appointment completed. Student can now submit feedback.
                        </div>
                        @if(!$appointment->feedback)
                            <a href="{{ route('student.feedback.create', $appointment) }}" class="btn btn-outline-info" target="_blank">
                                <i class="bi bi-star me-2"></i>View Feedback Form
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection