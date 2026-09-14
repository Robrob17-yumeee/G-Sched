@extends('layouts.app')

@section('title', ' - Activity Logs')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Activity Logs</h1>
</div>

<!-- Filters -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Date From</label>
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Date To</label>
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">User</label>
                <select class="form-select" name="user_id">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Action</label>
                <input type="text" class="form-control" name="action" placeholder="Search action..." value="{{ request('action') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Module</label>
                <input type="text" class="form-control" name="module" placeholder="Search module..." value="{{ request('module') }}">
            </div>
            <div class="col-md-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.logs') }}" class="btn btn-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

@if($logs->count() > 0)
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Module</th>
                            <th>Description</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('M d, Y g:i A') }}</td>
                                <td>{{ $log->user->full_name ?? 'System' }}</td>
                                <td><span class="badge" style="background: #64748B; color: #053F5C;">{{ $log->action }}</span></td>
                                <td>{{ $log->module }}</td>
                                <td>{{ Str::limit($log->description, 80) }}</td>
                                <td>{{ $log->ip_address ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-journal-text fs-1 text-muted"></i>
        <h4 class="mt-3 text-muted">No Activity Logs</h4>
    </div>
@endif
@endsection