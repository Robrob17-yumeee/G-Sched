@extends('layouts.app')

@section('title', ' - Notification')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Notification Details</h1>
    <a href="{{ auth()->user()->isAdmin() ? route('admin.notifications') : (auth()->user()->isGuidanceAssociate() ? route('guidance.notifications') : route('student.notifications')) }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi {{ $notification->icon }}" style="color: {{ $notification->typeColor }};"></i>
                    {{ $notification->title }}
                </h5>
                <span class="badge" style="background: {{ $notification->typeColor }}; color: #053F5C;">{{ ucfirst($notification->type) }}</span>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Message</dt>
                    <dd class="col-sm-9">{{ $notification->message }}

                    <dt class="col-sm-3">Type</dt>
                    <dd class="col-sm-9">
                        <span class="badge" style="background: {{ $notification->typeColor }}; color: #053F5C;">{{ ucfirst($notification->type) }}</span>
                    </dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">
                        @if($notification->is_read)
                            <span class="badge" style="background: #9FE7F5; color: #053F5C;"><i class="bi bi-check-circle me-1"></i>Read</span>
                        @else
                            <span class="badge" style="background: #F7AD19; color: #053F5C;"><i class="bi bi-envelope me-1"></i>Unread</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Created</dt>
                    <dd class="col-sm-9">{{ $notification->created_at->format('F d, Y g:i A') }}</dd>

                    @if($notification->read_at)
                        <dt class="col-sm-3">Read At</dt>
                        <dd class="col-sm-9">{{ $notification->read_at->format('F d, Y g:i A') }}</dd>
                    @endif

                    @if($notification->related_appointment_id)
                        <dt class="col-sm-3">Related Appointment</dt>
                        <dd class="col-sm-9">
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.appointments.show', $notification->appointment) : (auth()->user()->isGuidanceAssociate() ? route('guidance.appointments.show', $notification->appointment) : route('student.appointments.show', $notification->appointment)) }}">
                                Appointment #{{ $notification->related_appointment_id }}
                            </a>
                        </dd>
                    @endif

                    @if($notification->user_id && !auth()->user()->isAdmin())
                        <dt class="col-sm-3">Recipient</dt>
                        <dd class="col-sm-9">{{ $notification->user->full_name }} ({{ $notification->user->email }})</dd>
                    @endif
                </dl>

                @if(!$notification->is_read)
                    <form method="POST" action="{{ auth()->user()->isAdmin() ? route('admin.notifications.read', $notification) : (auth()->user()->isGuidanceAssociate() ? route('guidance.notifications.read', $notification) : route('student.notifications.read', $notification)) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Mark as Read
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection