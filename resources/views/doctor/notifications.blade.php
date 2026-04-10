@extends('layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Mes notifications')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-bell"></i> Notifications</h4>
        <form action="{{ url('/doctor/notifications/mark-all') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-light btn-sm">Tout marquer comme lu</button>
        </form>
    </div>
    <div class="card-body">
        @php
            $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();
        @endphp
        
        @if($notifications->count() > 0)
            <div class="list-group">
                @foreach($notifications as $notification)
                    <div class="list-group-item {{ is_null($notification->read_at) ? 'bg-light' : '' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-bell me-2 text-primary"></i>
                                <strong>{{ $notification->data['title'] ?? 'Notification' }}</strong>
                                <p class="mb-0 text-muted small">{{ $notification->data['message'] ?? '' }}</p>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                @if(is_null($notification->read_at))
                                    <form action="{{ url('/doctor/notifications/'.$notification->id.'/mark-read') }}" method="POST" class="mt-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Marquer comme lu</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                <p class="text-muted">Aucune notification</p>
            </div>
        @endif
    </div>
</div>
@endsection