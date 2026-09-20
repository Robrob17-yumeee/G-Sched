@extends('layouts.app')

@section('styles')
<style>
    :root {
        --navy: #053F5C;
        --medium-blue: #429EBD;
        --light-blue: #9FE7F5;
        --yellow: #F7AD19;
        --orange: #F27F0C;
        --bg-light: #F7FAFC;
        --card-bg: #FFFFFF;
        --text-primary: #053F5C;
        --text-muted: #64748B;
        --border-color: #E2E8F0;
        --border-color-light: #F1F5F9;
    }
    
    body {
        background-color: var(--bg-light);
        font-family: 'Inter', 'Roboto', sans-serif;
    }
    
    .card {
        background: var(--card-bg);
        border: none;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(5, 63, 92, 0.08), 0 1px 2px rgba(5, 63, 92, 0.05);
    }
    
    .card-header {
        background: transparent;
        border-bottom: 1px solid var(--border-color-light);
        padding: 1rem 1.5rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .table {
        margin-bottom: 0;
        background: transparent;
    }
    
    .table th {
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--border-color-light);
        padding: 1rem 1.5rem;
    }
    
    .table thead {
        background: #0077b6 !important;
    }
    
    .table thead th {
        background: #0077b6 !important;
        color: #FFFFFF !important;
        border-bottom: none;
    }
    
    .table tbody {
        background: #FFFFFF;
    }
    
    .table td {
        background: #FFFFFF;
    }
    
    .table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color-light);
        color: var(--text-primary);
    }
    
    .table tbody tr {
        transition: background 0.2s ease;
    }
    
    .table tbody tr:hover {
        background: var(--bg-light);
    }
    
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .status-badge {
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        color: #FFFFFF;
    }
    
    .status-badge.pending { background: #ffbf00; }
    .status-badge.approved { background: #429EBD; }
    .status-badge.rejected { background: #db213a; }
    .status-badge.completed { background: #21db3d; }
    .status-badge.cancelled { background: #F27F0C; }
    .status-badge.rescheduled { background: rgba(5, 63, 92, 0.15); }
    
    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        background: white;
        color: var(--text-muted);
        transition: all 0.2s ease;
    }
    
    .btn-icon:hover {
        border-color: var(--medium-blue);
        color: var(--navy);
        background: rgba(66, 158, 189, 0.1);
    }
    
    .btn-primary-action {
        background: var(--medium-blue);
        border: none;
        border-radius: 0.5rem;
        color: #FFFFFF;
        font-weight: 500;
        padding: 0.625rem 1.25rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.2s ease;
        min-height: 44px;
    }
    
    .btn-primary-action:hover {
        background: var(--navy);
    }
    
    .form-control, .form-select {
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.625rem 0.875rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--medium-blue);
        box-shadow: 0 0 0 3px rgba(66, 158, 189, 0.3);
    }
    
    .pagination {
        margin: 0;
        gap: 2px;
    }
    
    .page-link {
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        background: white;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 0.25rem;
        min-width: 32px;
        text-align: center;
    }
    
    .page-link:hover {
        background: var(--bg-light);
        border-color: var(--medium-blue);
        color: var(--medium-blue);
    }
    
    .page-item.active .page-link {
        background: var(--medium-blue);
        border-color: var(--medium-blue);
        color: white;
    }
    
    .page-item.disabled .page-link {
        color: var(--text-muted);
        background: var(--bg-light);
        border-color: var(--border-color-light);
    }
    
    @media (max-width: 767.98px) {
        .table-responsive {
            overflow-x: visible;
        }
        .mobile-appointment-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .mobile-appt-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1rem;
            background: white;
        }
        .mobile-appt-card .appt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }
        .mobile-appt-card .appt-title {
            font-weight: 600;
            color: var(--navy);
            font-size: 1rem;
        }
        .mobile-appt-card .appt-guidance {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .mobile-appt-card .appt-status {
            font-size: 0.75rem;
        }
        .mobile-appt-card .appt-details {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }
        .mobile-appt-card .appt-detail-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
        }
        .mobile-appt-card .appt-detail-label {
            color: var(--text-muted);
        }
        .mobile-appt-card .appt-detail-value {
            color: var(--navy);
            font-weight: 500;
        }
        .mobile-appt-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }
        .mobile-appt-actions .btn {
            flex: 1;
            min-width: 100px;
            height: 44px;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h2 mb-1" style="color: var(--navy); font-weight: 700;">All Appointments</h1>
                <p class="text-muted mb-0">View and manage all system appointments</p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Card -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
            <i class="bi bi-funnel me-2" style="color: var(--yellow);"></i>Filters
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label visually-hidden">Search</label>
                <input type="text" class="form-control" name="search" placeholder="Search student, associate, purpose..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label visually-hidden">Role</label>
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label visually-hidden">Date From</label>
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label visually-hidden">Date To</label>
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn-primary-action w-100">
                    <i class="bi bi-funnel"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@if($appointments->count() > 0)
    <!-- Mobile Card View (hidden on desktop) -->
    <div class="d-md-none mobile-appointment-list">
        @foreach($appointments as $appointment)
            @php
                $statusClass = strtolower($appointment->status->name ?? 'pending');
                if (!in_array($statusClass, ['pending', 'approved', 'rejected', 'completed', 'cancelled', 'rescheduled'])) {
                    $statusClass = 'pending';
                }
            @endphp
            <div class="card mobile-appt-card">
                <div class="appt-header">
                    <div>
                        <div class="appt-title">{{ $appointment->student->full_name }}</div>
                        <div class="appt-guidance">{{ $appointment->guidanceAssociate->full_name ?? 'N/A' }}</div>
                    </div>
                    <span class="status-badge {{ $statusClass }}">{{ $appointment->status->label }}</span>
                </div>
                <div class="appt-details">
                    <div class="appt-detail-row">
                        <span class="appt-detail-label">Date</span>
                        <span class="appt-detail-value">{{ $appointment->formatted_date }}</span>
                    </div>
                    <div class="appt-detail-row">
                        <span class="appt-detail-label">Time</span>
                        <span class="appt-detail-value">{{ $appointment->formatted_time }}</span>
                    </div>
                    <div class="appt-detail-row">
                        <span class="appt-detail-label">Purpose</span>
                        <span class="appt-detail-value text-muted">{{ Str::limit($appointment->purpose, 60) }}</span>
                    </div>
                </div>
                <div class="mobile-appt-actions">
                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-eye me-1"></i>View
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="d-none d-md-block">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Guidance Associate</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Purpose</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td>
                                        <div>
                                            <div class="fw-medium" style="color: var(--navy);">{{ $appointment->student->full_name }}</div>
                                            <div class="small text-muted">{{ $appointment->student->email }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $appointment->guidanceAssociate->full_name ?? 'N/A' }}</div>
                                    </td>
                                    <td>{{ $appointment->formatted_date }}</td>
                                    <td>{{ $appointment->formatted_time }}</td>
                                    <td>
                                        <div class="text-muted" style="max-width: 300px;">{{ Str::limit($appointment->purpose, 60) }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = strtolower($appointment->status->name ?? 'pending');
                                            if (!in_array($statusClass, ['pending', 'approved', 'rejected', 'completed', 'cancelled', 'rescheduled'])) {
                                                $statusClass = 'pending';
                                            }
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">{{ $appointment->status->label }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn-icon" title="View Details">
                                                <i class="bi bi-eye fs-5"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top p-3" style="border-color: var(--border-color-light);">
                <div class="d-flex justify-content-center">
                    {{ $appointments->appends(request()->query())->onEachSide(3)->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-calendar-check fs-1" style="color: var(--text-muted); opacity: 0.5;"></i>
            <h4 class="mt-3 text-muted">No Appointments</h4>
            <p class="text-muted">No appointments match your search criteria.</p>
        </div>
    </div>
@endif
@endsection