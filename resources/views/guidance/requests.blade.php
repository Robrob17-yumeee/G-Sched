@extends('layouts.app')

@section('title', ' - Appointment Requests')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Appointment Requests</h1>
</div>

@if($requests->count() > 0)
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Requested</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                            <tr>
                                <td>
                                    @if($request->isHighSeverity() && !auth()->user()->isAdmin())
                                        <strong style="color: var(--orange);">Confidential (High Severity)</strong>
                                        <br><small class="text-muted">Student identity hidden</small>
                                        <span class="badge" style="background: var(--orange); color: var(--badge-text-light);" >HIGH</span>
                                    @else
                                        <strong>{{ $request->student->full_name }}</strong>
                                        <br><small class="text-muted">{{ $request->student->email }}</small>
                                        @if($request->student->student_id)
                                            <br><small class="text-muted">ID: {{ $request->student->student_id }}</small>
                                        @endif
                                        @if($request->isHighSeverity())
                                            <span class="badge" style="background: var(--orange); color: var(--badge-text-light);" >HIGH</span>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $request->formatted_date }}</td>
                                <td>{{ $request->formatted_time }}</td>
                                <td>{{ Str::limit($request->purpose, 50) }}</td>
                                <td>
                                    <span class="badge" style="background: {{ $request->status->color ?? '#F7AD19' }}; color: var(--badge-text-light);">
                                        {{ $request->status->label }}
                                    </span>
                                </td>
                                <td>{{ $request->created_at->format('M d, Y g:i A') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('guidance.requests.show', $request) }}" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('guidance.requests.approve', $request) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success" onclick="return confirm('Approve this appointment?')" title="Approve">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('guidance.requests.reject', $request) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Reject this appointment?')" title="Reject">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('guidance.requests.reschedule', $request) }}" class="btn btn-outline-warning" title="Reschedule">
                                            <i class="bi bi-calendar-event"></i>
                                        </a>
                                        <form method="POST" action="{{ route('guidance.requests.cancel', $request) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-secondary" onclick="return confirm('Cancel this appointment?')" title="Cancel">
                                                <i class="bi bi-slash-circle"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-inbox fs-1 text-muted"></i>
        <h4 class="mt-3 text-muted">No Pending Requests</h4>
        <p class="text-muted">All caught up! No new appointment requests at this time.</p>
    </div>
@endif
@endsection
