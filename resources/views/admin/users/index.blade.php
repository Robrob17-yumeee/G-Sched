@extends('layouts.app')

@section('title', ' - User Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">User Management</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Add User
    </a>
</div>

<!-- Search and Filter -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" placeholder="Search name, email, student ID..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="role">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $role->name)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

@if($users->count() > 0)
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->full_name }}</strong>
                                    @if($user->student_id)
                                        <br><small class="text-muted">ID: {{ $user->student_id }}</small>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role->name === 'admin' ? 'danger' : ($user->role->name === 'guidance_associate' ? 'info' : 'success') }}">
                                        {{ ucfirst(str_replace('_', ' ', $user->role->name)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge" style="background: {{ $user->status === 'active' ? '#9FE7F5' : '#64748B' }}; color: #053F5C;">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-{{ $user->status === 'active' ? 'warning' : 'success' }}" title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                                    <i class="bi bi-{{ $user->status === 'active' ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $user->id }}" title="Reset Password">
                                                <i class="bi bi-key"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">(You)</span>
                                        @endif
                                    </div>
                                    </td>
                                </tr>

                            <!-- Reset Password Modal -->
                            <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: #F7AD19; color: #053F5C;">
                                            <h5 class="modal-title"><i class="bi bi-key me-2"></i>Reset Password for {{ $user->full_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.users.reset-password', $user) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="password{{ $user->id }}" class="form-label">New Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="password{{ $user->id }}" name="password" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password_confirmation{{ $user->id }}" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="password_confirmation{{ $user->id }}" name="password_confirmation" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-warning">Reset Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-people fs-1 text-muted"></i>
        <h4 class="mt-3 text-muted">No Users Found</h4>
        <p class="text-muted">No users match your search criteria.</p>
    </div>
@endif
@endsection