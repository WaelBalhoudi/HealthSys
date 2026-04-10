@extends('layouts.app')

@section('title', 'Espace médecin')
@section('page-title', 'Tableau de bord médecin')

@section('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        overflow: hidden;
        position: relative;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    .stat-card.primary::before { background: linear-gradient(90deg, #1a5f7a, #f0b429); }
    .stat-card.success::before { background: linear-gradient(90deg, #28a745, #20c997); }
    .stat-card.warning::before { background: linear-gradient(90deg, #ffc107, #fd7e14); }
    
    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .timeline-item {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        padding-left: 15px;
    }
    .timeline-item:hover {
        border-left-color: #1a5f7a;
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
    
    .welcome-banner {
        background: linear-gradient(135deg, #1a5f7a 0%, #0d3b4f 100%);
        border-radius: 20px;
        padding: 25px;
        color: white;
        margin-bottom: 25px;
    }
    
    .section-title {
        position: relative;
        padding-bottom: 12px;
        margin-bottom: 20px;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, #1a5f7a, #f0b429);
        border-radius: 3px;
    }
    
    .btn-action {
        border-radius: 25px;
        padding: 8px 20px;
        transition: all 0.3s;
    }
    .btn-action:hover {
        transform: scale(1.02);
    }
    
    .patient-avatar {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: bold;
        font-size: 18px;
    }
    
    .time-badge {
        background: #1a5f7a;
        color: white;
        padding: 5px 12px;
        border-radius: 25px;
        font-size: 12px;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
@php
    $doctorId = auth()->user()->doctor->id;
    $waitingCount = \App\Models\WaitingRoom::where('doctor_id', $doctorId)->where('status', 'waiting')->count();
    $todayAppointmentsCount = \App\Models\Appointment::where('doctor_id', $doctorId)
        ->whereDate('date_time', today())
        ->whereIn('status', ['confirmed', 'pending'])->count();
    $totalConsultations = \App\Models\Consultation::where('doctor_id', $doctorId)->count();
@endphp

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-2 fw-bold">Bonjour, Dr. {{ auth()->user()->name }} !</h2>
            <p class="mb-0 opacity-75">Voici le résumé de votre activité du jour</p>
        </div>
        <div class="text-end">
            <i class="fas fa-user-md fa-3x opacity-50"></i>
            <p class="mb-0 mt-2 small">{{ now()->format('l d F Y') }}</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card primary shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Patients en attente</p>
                        <h2 class="fw-bold mb-0">{{ $waitingCount }}</h2>
                        <small class="text-primary mt-2 d-block">
                            <i class="fas fa-clock me-1"></i> En file d'attente
                        </small>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="fas fa-clock text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card stat-card success shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Rendez-vous aujourd'hui</p>
                        <h2 class="fw-bold mb-0">{{ $todayAppointmentsCount }}</h2>
                        <small class="text-success mt-2 d-block">
                            <i class="fas fa-calendar-check me-1"></i> Programme du jour
                        </small>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10">
                        <i class="fas fa-calendar-check text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card stat-card warning shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Consultations effectuées</p>
                        <h2 class="fw-bold mb-0">{{ $totalConsultations }}</h2>
                        <small class="text-warning mt-2 d-block">
                            <i class="fas fa-stethoscope me-1"></i> Total cumulé
                        </small>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10">
                        <i class="fas fa-stethoscope text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="mb-3 section-title">Actions rapides</h5>
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <a href="{{ route('doctor.waiting-room') }}" class="btn btn-primary btn-action w-100">
                            <i class="fas fa-clock me-2"></i> Salle d'attente
                            @if($waitingCount > 0)
                                <span class="badge bg-danger ms-2">{{ $waitingCount }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('doctor.consultations') }}" class="btn btn-info btn-action w-100">
                            <i class="fas fa-stethoscope me-2"></i> Consultations
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('doctor.patients') }}" class="btn btn-success btn-action w-100">
                            <i class="fas fa-users me-2"></i> Mes patients
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('doctor.establish-document') }}" class="btn btn-warning btn-action w-100">
                            <i class="fas fa-file-alt me-2"></i> Document
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row g-4">
    <!-- Today's Schedule -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-calendar-day me-2 text-primary"></i>Programme du jour
                </h5>
                <span class="badge bg-primary rounded-pill">{{ $todayAppointmentsCount }}</span>
            </div>
            <div class="card-body pt-0">
                @php
                    $todayAppointments = \App\Models\Appointment::with(['patient.user'])
                        ->where('doctor_id', $doctorId)
                        ->whereDate('date_time', today())
                        ->orderBy('date_time')
                        ->get();
                @endphp
                
                @if($todayAppointments->count() > 0)
                    <div class="timeline">
                        @foreach($todayAppointments as $appointment)
                            <div class="timeline-item mb-4 pb-3 border-bottom">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="time-badge text-center">
                                            {{ $appointment->date_time->format('H') }}h<br>
                                            <small>{{ $appointment->date_time->format('i') }}</small>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="patient-avatar bg-primary bg-opacity-10 me-2">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </div>
                                                    <h6 class="mb-0 fw-bold">{{ $appointment->patient->user->name }}</h6>
                                                    <span class="ms-2 badge bg-{{ $appointment->type == 'urgence' ? 'danger' : 'secondary' }} rounded-pill">
                                                        {{ $appointment->type ?? 'Consultation' }}
                                                    </span>
                                                </div>
                                                <div class="ms-4">
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="fas fa-id-card me-1"></i> {{ $appointment->patient->user->cin ?? 'CIN non renseigné' }}
                                                    </small>
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="fas fa-phone me-1"></i> {{ $appointment->patient->user->phone ?? 'Tél non renseigné' }}
                                                    </small>
                                                    @if($appointment->reason)
                                                        <small class="text-muted d-block mt-2">
                                                            <i class="fas fa-info-circle me-1"></i> {{ $appointment->reason }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mt-2 mt-md-0">
                                                @if($appointment->status == 'confirmed')
                                                    <span class="badge bg-success mb-2 d-block">Confirmé</span>
                                                @elseif($appointment->status == 'pending')
                                                    <span class="badge bg-warning text-dark mb-2 d-block">En attente</span>
                                                @elseif($appointment->status == 'completed')
                                                    <span class="badge bg-secondary mb-2 d-block">Terminé</span>
                                                @else
                                                    <span class="badge bg-danger mb-2 d-block">Annulé</span>
                                                @endif
                                                
                                                @if($appointment->status != 'completed' && $appointment->status != 'cancelled')
                                                    <div class="btn-group-vertical">
                                                        <a href="{{ route('doctor.consultations.create', ['patient' => $appointment->patient->id, 'appointment' => $appointment->id]) }}" 
                                                           class="btn btn-sm btn-primary mb-1">
                                                            <i class="fas fa-play me-1"></i> Consulter
                                                        </a>
                                                        <a href="{{ route('doctor.patients.show', $appointment->patient->id) }}" 
                                                           class="btn btn-sm btn-outline-secondary">
                                                            <i class="fas fa-folder me-1"></i> Dossier
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-day fa-4x text-muted mb-3 opacity-25"></i>
                        <h5 class="text-muted">Aucun rendez-vous aujourd'hui</h5>
                        <p class="text-muted mb-3">Profitez de cette journée pour rattraper votre retard administratif</p>
                        <a href="{{ url('/doctor/consultations') }}" class="btn btn-primary">
                            <i class="fas fa-calendar me-2"></i>Voir l'agenda
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Right Column -->
    <div class="col-lg-5">
        <!-- Weekly Activity Chart -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-chart-line me-2 text-success"></i>Activité hebdomadaire
                </h5>
            </div>
            <div class="card-body">
                <canvas id="weeklyActivityChart" height="250"></canvas>
            </div>
        </div>
        
        <!-- Recent Patients -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-users me-2 text-info"></i>Patients récents
                </h5>
                <a href="{{ route('doctor.patients') }}" class="text-decoration-none small">Voir tout →</a>
            </div>
            <div class="card-body pt-0">
                @php
                    $recentPatients = \App\Models\Consultation::with('patient.user')
                        ->where('doctor_id', $doctorId)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get()
                        ->unique('patient_id');
                @endphp
                
                @if($recentPatients->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentPatients as $consultation)
                            <div class="list-group-item list-group-item-action px-0 py-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center">
                                            <div class="patient-avatar bg-info bg-opacity-10 me-3">
                                                <span class="text-info fw-bold">
                                                    {{ substr($consultation->patient->user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $consultation->patient->user->name }}</h6>
                                                <small class="text-muted">
                                                    <i class="far fa-clock me-1"></i>
                                                    {{ $consultation->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('doctor.patients.show', $consultation->patient->id) }}" 
                                           class="btn btn-sm btn-outline-info" title="Voir dossier">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-injured fa-4x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Aucun patient récent</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Next Appointments Preview -->
@if($todayAppointmentsCount == 0 && $todayAppointments->count() == 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-warning bg-opacity-10 border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb fa-2x text-warning"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">Journée libre !</h6>
                        <p class="mb-0 small text-muted">Vous n'avez aucun rendez-vous aujourd'hui. C'est le moment idéal pour mettre à jour vos dossiers patients ou consulter la documentation médicale.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('weeklyActivityChart');
    if (ctx) {
        @php
            $weeklyData = [];
            for ($i = 1; $i <= 7; $i++) {
                $day = now()->startOfWeek()->addDays($i - 1);
                $count = \App\Models\Consultation::where('doctor_id', auth()->user()->doctor->id)
                    ->whereDate('consultation_date', $day)->count();
                $weeklyData[] = $count;
            }
        @endphp
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Consultations',
                    data: @json($weeklyData),
                    borderColor: '#1a5f7a',
                    backgroundColor: 'rgba(26, 95, 122, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#1a5f7a',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(33, 37, 41, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(255,255,255,0.2)',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' consultation' + (context.parsed.y > 1 ? 's' : '');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: '#6c757d',
                            font: { size: 11 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            borderDash: [4, 4]
                        }
                    },
                    x: {
                        ticks: {
                            color: '#495057',
                            font: { size: 11, weight: '500' }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }
});
</script>
@endpush