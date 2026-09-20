@extends('layouts.app')

@section('title', ' - Appointment Request Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2" style="color: var(--text-primary); font-weight: 700;">Appointment Request Details</h1>
    <a href="{{ route('guidance.requests') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-2"></i>Back to Requests
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--border-color-light); padding: 1rem 1.5rem;">
                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                    <i class="bi bi-person me-2" style="color: var(--medium-blue);"></i>Student Information
                </h5>
                @if($appointment->isHighSeverity())
                    <span class="badge" style="background: var(--orange); color: var(--badge-text-light);">Confidential - High Severity</span>
                @endif
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                @if($appointment->isHighSeverity())
                    <div class="text-center py-4">
                        <i class="bi bi-shield-lock fs-1" style="color: var(--yellow);"></i>
                        <h5 class="mt-3">Confidential Appointment</h5>
                        <p class="text-muted">This is a high severity appointment. Student identity is hidden from guidance counselors.</p>
                        <span class="badge fs-6" style="background: var(--orange); color: var(--badge-text-light);">HIGH SEVERITY</span>
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
            <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--border-color-light); padding: 1rem 1.5rem;">
                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                    <i class="bi bi-calendar-event me-2" style="color: var(--medium-blue);"></i>Appointment Details
                </h5>
                <span class="badge fs-6" style="background: {{ $appointment->status->color ?? '#F7AD19' }}; color: var(--badge-text-light);">{{ $appointment->status->label }}</span>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <dl class="row">
                    <dt class="col-sm-3">Date</dt>
                    <dd class="col-sm-9">{{ $appointment->formatted_date }}</dd>

                    <dt class="col-sm-3">Time</dt>
                    <dd class="col-sm-9">{{ $appointment->formatted_time }}</dd>

                    <dt class="col-sm-3">Purpose</dt>
                    <dd class="col-sm-9">{{ $appointment->purpose }}</dd>

                    <dt class="col-sm-3">Concern Category</dt>
                    <dd class="col-sm-9">{{ $appointment->concern_category ?: 'Not specified' }}</dd>

                    <dt class="col-sm-3">Requested</dt>
                    <dd class="col-sm-9">{{ $appointment->created_at->format('F d, Y g:i A') }}</dd>
                </dl>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--border-color-light); padding: 1rem 1.5rem;">
                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                    <i class="bi bi-clipboard-data me-2" style="color: var(--medium-blue);"></i>Case Assessment
                </h5>
                <span class="badge fs-6" style="background: {{ $appointment->isSeverityAssessed() ? 'var(--medium-blue)' : 'var(--yellow)' }}; color: var(--badge-text-light);">
                    {{ $appointment->severityLabel() }}
                </span>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <div class="mb-3">
                    <label class="form-label"><strong>Concern / Purpose</strong></label>
                    <div class="border rounded p-3 bg-light" style="background-color: var(--bg-light);">
                        {{ $appointment->purpose }}
                    </div>
                    <div class="form-text small text-muted mt-1">Submitted by student. Guidance Associate reviews but does not modify.</div>
                </div>

                <form method="POST" action="{{ route('guidance.requests.severity', $appointment) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="severity" class="form-label">Severity Level</label>
                        <select class="form-select" id="severity" name="severity" required>
                            <option value="not_assessed" {{ $appointment->severity === 'not_assessed' ? 'selected' : '' }}>Not Yet Assessed</option>
                            <option value="low" {{ $appointment->severity === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="moderate" {{ $appointment->severity === 'moderate' ? 'selected' : '' }}>Moderate</option>
                            <option value="high" {{ $appointment->severity === 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Save Assessment
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($appointment->rescheduleRequests->count() > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white" style="border-bottom: 1px solid var(--border-color-light); padding: 1rem 1.5rem;">
                    <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                        <i class="bi bi-calendar-event me-2" style="color: var(--medium-blue);"></i>Reschedule Requests
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
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
            <div class="card-header bg-white" style="border-bottom: 1px solid var(--border-color-light); padding: 1rem 1.5rem;">
                <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                    <i class="bi bi-lightning me-2" style="color: var(--yellow);"></i>Actions
                </h5>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
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
