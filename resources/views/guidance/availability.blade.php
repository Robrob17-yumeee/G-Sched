@extends('layouts.app')

@section('title', ' - Manage Availability')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Availability</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAvailabilityModal">
        <i class="bi bi-plus-circle me-2"></i>Add Availability
    </button>
</div>

@if($availabilities->count() > 0)
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Slot Duration</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($availabilities as $availability)
                            <tr>
                                <td>{{ $availability->available_date->format('l, F d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($availability->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($availability->end_time)->format('g:i A') }}</td>
                                <td>{{ $availability->slot_duration }} minutes</td>
                                <td>
                                    <span class="badge bg-{{ $availability->isAvailable() ? 'success' : ($availability->isBooked() ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($availability->status) }}
                                    </span>
                                </td>
                                <td>{{ $availability->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if($availability->isAvailable())
                                            <a href="{{ route('guidance.availability.edit', $availability) }}" class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('guidance.availability.destroy', $availability) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Delete this availability?')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-outline-secondary" disabled title="Cannot modify booked slot">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $availabilities->links() }}
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-calendar-plus fs-1 text-muted"></i>
        <h4 class="mt-3 text-muted">No Availability Set</h4>
        <p class="text-muted">Add your available time slots for student appointments.</p>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAvailabilityModal">
            <i class="bi bi-plus-circle me-2"></i>Add Availability
        </button>
    </div>
@endif

<!-- Add Availability Modal -->
<div class="modal fade" id="addAvailabilityModal" tabindex="-1" aria-labelledby="addAvailabilityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #053F5C; color: #FFFFFF;">
                <h5 class="modal-title" id="addAvailabilityModalLabel">
                    <i class="bi bi-calendar-plus me-2"></i>Add Availability
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('guidance.availability.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="available_date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="available_date" name="available_date" min="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="slot_duration" class="form-label">Slot Duration (minutes) <span class="text-danger">*</span></label>
                        <select class="form-select" id="slot_duration" name="slot_duration" required>
                            <option value="15">15 minutes</option>
                            <option value="30" selected>30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60">60 minutes</option>
                        </select>
                        <div class="form-text">Each appointment slot will be this duration.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Availability</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection