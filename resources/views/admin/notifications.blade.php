@extends('layouts.app')

@section('title', ' - System Notifications')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">System Notifications</h1>
</div>

@if($notifications->count() > 0)
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <a href="{{ route('notifications.show', $notification) }}" class="list-group-item list-group-item-action {{ !$notification->is_read ? 'fw-bold' : '' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                <i class="bi {{ $notification->icon }}" style="color: {{ $notification->typeColor }};"></i>
                                {{ $notification->title }}
                            </h6>
                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 small">{{ $notification->message }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge" style="background: {{ $notification->typeColor }}; color: #053F5C;">{{ ucfirst($notification->type) }}</span>
                                <span class="text-muted small ms-2">{{ $notification->user->full_name ?? 'System' }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="card-footer">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-bell-slash fs-1 text-muted"></i>
        <h4 class="mt-3 text-muted">No Notifications</h4>
    </div>
@endif
@endsection