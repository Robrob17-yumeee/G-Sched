@extends('layouts.app')

@section('title', ' - Appointment Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Appointment Details</h1>
    <a href="{{ route('admin.appointments') }}" class="btn btn-secondary">
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
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">#{{ $appointment->id }}</dd>

                    <dt class="col-sm-3">Severity</dt>
                    <dd class="col-sm-9">
                        <span class="badge fs-6" style="background: {{ $appointment->severity === 'high' ? '#F27F0C' : ($appointment->severity === 'medium' ? '#F7AD19' : '#429EBD') }}; color: #053F5C;">
                            {{ ucfirst($appointment->severity) }}
                        </span>
                        @if($appointment->severity === 'high')
                            <span class="text-danger ms-2"><i class="bi bi-shield-lock me-1"></i>Confidential - Admin only</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Date</dt>
                    <dd class="col-sm-9">{{ $appointment->formatted_date }}</dd>

                    <dt class="col-sm-3">Time</dt>
                    <dd class="col-sm-9">{{ $appointment->formatted_time }}</dd>

                    <dt class="col-sm-3">Student</dt>
                    <dd class="col-sm-9">{{ $appointment->student->full_name }} ({{ $appointment->student->email }})</dd>

                    <dt class="col-sm-3">Guidance Associate</dt>
                    <dd class="col-sm-9">{{ $appointment->guidanceAssociate->full_name ?? 'N/A' }} ({{ $appointment->guidanceAssociate->email ?? 'N/A' }})</dd>

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

                    <dt class="col-sm-3">Created At</dt>
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
                <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Guidance Associate</h5>
            </div>
            <div class="card-body text-center">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; background: rgba(159, 231, 245, 0.15); color: #429EBD;">
                    <i class="bi bi-person-badge fs-1"></i>
                </div>
                <h5>{{ $appointment->guidanceAssociate->full_name ?? 'N/A' }}</h5>
                <p class="text-muted">{{ $appointment->guidanceAssociate->email ?? 'N/A' }}</p>
            </div>
        </div>

        @if($appointment->feedback)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-star me-2"></i>Feedback</h5>
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
</div>
@endsection