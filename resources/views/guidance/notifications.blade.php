@extends('layouts.app')

@section('title', ' - Notifications')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Notifications</h1>
    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('guidance.notifications.read-all') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm" id="markAllReadBtn">
                <i class="bi bi-check-all me-2"></i>Mark All as Read
            </button>
        </form>
    </div>
</div>

@if($notifications->count() > 0)
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <a href="{{ route('notifications.show', $notification) }}" class="list-group-item list-group-item-action {{ !$notification->is_read ? 'fw-bold' : '' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                <i class="bi {{ $notification->icon }}" style="color: {{ $notification->type_color }};"></i>
                                {{ $notification->title }}
                            </h6>
                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 small">{{ $notification->message }}</p>
                        <div class="d-flex justify-content-between">
                            <span class="badge" style="background: {{ $notification->type_color }}; color: #053F5C;">{{ ucfirst($notification->type) }}</span>
                            @if(!$notification->is_read)
                                <form method="POST" action="{{ route('guidance.notifications.read', $notification) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Mark Read</button>
                                </form>
                            @endif
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
        <p class="text-muted">You're all caught up!</p>
    </div>
@endif
@endsection