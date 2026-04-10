@extends('layouts.app')

@section('title', 'Calendrier des rendez-vous')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-calendar-alt"></i> Calendrier des rendez-vous</h4>
            <a href="{{ route('appointments.create') }}" class="btn btn-light">
                <i class="fas fa-plus"></i> Nouveau rendez-vous
            </a>
        </div>
        <div class="card-body">
            <div id='calendar'></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/api/events',
            eventClick: function(info) {
                window.location.href = '/appointments/' + info.event.id;
            },
            height: 'auto',
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',
            allDaySlot: false
        });
        calendar.render();
    });
</script>
@endsection