@extends('layouts.app')

@section('title', 'Espace Chef de Médecine')
@section('page-title', 'Tableau de bord administration')

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
    .stat-card.info::before { background: linear-gradient(90deg, #17a2b8, #6f42c1); }
    
    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
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
        padding: 10px 20px;
        transition: all 0.3s;
    }
    .btn-action:hover {
        transform: scale(1.02);
    }
    
    .list-item-hover {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    .list-item-hover:hover {
        transform: translateX(5px);
        border-left-color: #1a5f7a;
        background-color: #f8f9fa;
    }
    
    .avatar-circle {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: bold;
        font-size: 18px;
    }
</style>
@endsection

@section('content')
@php
    $doctorsCount = \App\Models\User::where('role', 'doctor')->count();
    $secretariesCount = \App\Models\User::where('role', 'secretaire')->count();
    $patientsCount = \App\Models\Patient::count();
    $totalRevenue = \App\Models\Invoice::sum('amount') ?? 0;
    $todayAppointments = \App\Models\Appointment::whereDate('date_time', today())->count();
    $pendingAppointments = \App\Models\Appointment::where('status', 'pending')->count();
    $completedConsultations = \App\Models\Consultation::count();
@endphp

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-2 fw-bold">Bonjour, {{ auth()->user()->name }} !</h2>
            <p class="mb-0 opacity-75">Bienvenue dans votre espace d'administration. Voici la vue d'ensemble du cabinet.</p>
        </div>
        <div class="text-end">
            <i class="fas fa-chart-line fa-3x opacity-50"></i>
            <p class="mb-0 mt-2 small">{{ now()->format('l d F Y') }}</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card primary shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Médecins</p>
                        <h2 class="fw-bold mb-0">{{ $doctorsCount }}</h2>
                        <small class="text-primary mt-2 d-block">
                            <i class="fas fa-user-md me-1"></i> Personnel médical
                        </small>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="fas fa-user-md text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card success shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Secrétaires</p>
                        <h2 class="fw-bold mb-0">{{ $secretariesCount }}</h2>
                        <small class="text-success mt-2 d-block">
                            <i class="fas fa-user-tie me-1"></i> Personnel administratif
                        </small>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10">
                        <i class="fas fa-user-tie text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card warning shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Patients</p>
                        <h2 class="fw-bold mb-0">{{ $patientsCount }}</h2>
                        <small class="text-warning mt-2 d-block">
                            <i class="fas fa-users me-1"></i> Dossiers actifs
                        </small>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10">
                        <i class="fas fa-users text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card info shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Chiffre d'affaires</p>
                        <h2 class="fw-bold mb-0">{{ number_format($totalRevenue, 0) }} DT</h2>
                        <small class="text-info mt-2 d-block">
                            <i class="fas fa-chart-line me-1"></i> Cumulé
                        </small>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10">
                        <i class="fas fa-chart-line text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-calendar-day fa-2x text-primary mb-2"></i>
                        <h5 class="mb-0">{{ $todayAppointments }}</h5>
                        <small class="text-muted">Rendez-vous aujourd'hui</small>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                        <h5 class="mb-0">{{ $pendingAppointments }}</h5>
                        <small class="text-muted">En attente</small>
                    </div>
                    <div class="vr"></div>
                    <div>
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <h5 class="mb-0">{{ $completedConsultations }}</h5>
                        <small class="text-muted">Consultations</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="mb-2 mb-md-0">
                        <i class="fas fa-chart-simple text-primary me-2"></i>
                        <span class="fw-semibold">Taux d'occupation :</span>
                        @php
                            $occupationRate = $doctorsCount > 0 ? round(($completedConsultations / ($doctorsCount * 100)) * 100, 1) : 0;
                        @endphp
                        <span class="text-success">{{ $occupationRate }}%</span>
                    </div>
                    <div class="mb-2 mb-md-0">
                        <i class="fas fa-chart-simple text-success me-2"></i>
                        <span class="fw-semibold">Patients par médecin :</span>
                        <span class="text-primary">{{ $doctorsCount > 0 ? round($patientsCount / $doctorsCount, 1) : 0 }}</span>
                    </div>
                    <div>
                        <i class="fas fa-chart-simple text-warning me-2"></i>
                        <span class="fw-semibold">CA par médecin :</span>
                        <span class="text-info">{{ $doctorsCount > 0 ? number_format($totalRevenue / $doctorsCount, 0) : 0 }} DT</span>
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
                    <div class="col-md-2 col-6">
                        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary btn-action w-100">
                            <i class="fas fa-user-md me-2"></i> Ajouter médecin
                        </a>
                    </div>
                    <div class="col-md-2 col-6">
                        <a href="{{ route('admin.secretaries.create') }}" class="btn btn-success btn-action w-100">
                            <i class="fas fa-user-tie me-2"></i> Ajouter secrétaire
                        </a>
                    </div>
                    <div class="col-md-2 col-6">
                        <a href="{{ route('admin.specialites.create') }}" class="btn btn-info btn-action w-100">
                            <i class="fas fa-tag me-2"></i> Spécialité
                        </a>
                    </div>
                    <div class="col-md-2 col-6">
                        <a href="{{ route('admin.departements.create') }}" class="btn btn-warning btn-action w-100">
                            <i class="fas fa-building me-2"></i> Département
                        </a>
                    </div>
                    <div class="col-md-2 col-6">
                        <a href="{{ route('admin.reports') }}" class="btn btn-secondary btn-action w-100">
                            <i class="fas fa-chart-bar me-2"></i> Rapports
                        </a>
                    </div>
                    <div class="col-md-2 col-6">
                        <a href="{{ route('admin.export.patients') }}" class="btn btn-dark btn-action w-100">
                            <i class="fas fa-file-excel me-2"></i> Export
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row g-4">
    <!-- User Distribution Chart -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-chart-pie me-2 text-primary"></i>Répartition des utilisateurs
                </h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 280px;">
                <canvas id="userDistributionChart" style="max-height: 250px;"></canvas>
            </div>
            <div class="card-footer bg-white border-0 pt-0">
                <div class="d-flex justify-content-center gap-4 small flex-wrap">
                    <span><i class="fas fa-circle text-primary me-1"></i> Médecins ({{ $doctorsCount }})</span>
                    <span><i class="fas fa-circle text-success me-1"></i> Secrétaires ({{ $secretariesCount }})</span>
                    <span><i class="fas fa-circle text-warning me-1"></i> Patients ({{ $patientsCount }})</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Chart -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-chart-line me-2 text-success"></i>Évolution mensuelle
                </h5>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-primary active" onclick="updateChart('appointments')">Rendez-vous</button>
                    <button type="button" class="btn btn-outline-primary" onclick="updateChart('revenue')">Revenus</button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Lists Row -->
<div class="row g-4 mt-2">
    <!-- Recent Doctors -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-user-md me-2 text-primary"></i>Derniers médecins ajoutés
                </h5>
                <a href="{{ route('admin.doctors.index') }}" class="text-decoration-none small">Voir tout →</a>
            </div>
            <div class="card-body pt-0">
                @php
                    $recentDoctors = \App\Models\User::with('specialite')
                        ->where('role', 'doctor')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                
                @if($recentDoctors->isNotEmpty())
                    <div class="list-group list-group-flush">
                        @foreach($recentDoctors as $doctor)
                            <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="list-group-item list-group-item-action list-item-hover px-0 py-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary bg-opacity-10 me-3">
                                            <i class="fas fa-user-md text-primary"></i>
                                        </div>
                                        <div>
                                            <strong>Dr. {{ $doctor->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-stethoscope me-1"></i>{{ $doctor->specialite->nom ?? 'Spécialité non définie' }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-light text-dark">
                                            <i class="far fa-calendar me-1"></i>{{ $doctor->created_at->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-md fa-4x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Aucun médecin enregistré</p>
                        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary mt-3">Ajouter un médecin</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Patients -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-user-injured me-2 text-warning"></i>Derniers patients
                </h5>
                <a href="{{ route('secretaire.patients.index') }}" class="text-decoration-none small">Voir tout →</a>
            </div>
            <div class="card-body pt-0">
                @php
                    $recentPatients = \App\Models\Patient::with('user')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                
                @if($recentPatients->isNotEmpty())
                    <div class="list-group list-group-flush">
                        @foreach($recentPatients as $patient)
                            <a href="{{ route('secretaire.patients.show', $patient->id) }}" class="list-group-item list-group-item-action list-item-hover px-0 py-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-warning bg-opacity-10 me-3">
                                            <i class="fas fa-user-injured text-warning"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $patient->user->name ?? 'Patient' }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-envelope me-1"></i>{{ $patient->user->email ?? 'Email non disponible' }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-light text-dark">
                                            <i class="far fa-calendar me-1"></i>{{ $patient->created_at->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-injured fa-4x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Aucun patient enregistré</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Appointments -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-calendar-alt me-2 text-info"></i>Derniers rendez-vous
                </h5>
                <a href="{{ route('secretaire.appointments.index') }}" class="text-decoration-none small">Voir tout →</a>
            </div>
            <div class="card-body pt-0">
                @php
                    $recentAppointments = \App\Models\Appointment::with(['patient.user', 'doctor.user'])
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                
                @if($recentAppointments->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Patient</th>
                                    <th>Médecin</th>
                                    <th>Date et heure</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAppointments as $appointment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-info bg-opacity-10 me-2" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user text-info"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $appointment->patient->user->name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $appointment->patient->user->phone ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}<br>
                                        <small class="text-muted">{{ $appointment->doctor->specialty ?? '' }}</small>
                                    </td>
                                    <td>
                                        <i class="far fa-calendar me-1"></i>{{ $appointment->date_time->format('d/m/Y') }}<br>
                                        <i class="far fa-clock me-1"></i>{{ $appointment->date_time->format('H:i') }}
                                    </td>
                                    <td>
                                        @if($appointment->status == 'confirmed')
                                            <span class="badge bg-success">Confirmé</span>
                                        @elseif($appointment->status == 'pending')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($appointment->status == 'completed')
                                            <span class="badge bg-secondary">Terminé</span>
                                        @else
                                            <span class="badge bg-danger">Annulé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('secretaire.appointments.show', $appointment->id) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-alt fa-4x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Aucun rendez-vous récent</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Financial Summary -->
<div class="row g-4 mt-2">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-chart-pie me-2 text-success"></i>Répartition des revenus
                </h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-file-invoice-dollar me-2 text-warning"></i>Aperçu financier
                </h5>
            </div>
            <div class="card-body">
                @php
                    $paidAmount = \App\Models\Invoice::sum('paid_amount') ?? 0;
                    $pendingAmount = $totalRevenue - $paidAmount;
                    $paidPercentage = $totalRevenue > 0 ? round(($paidAmount / $totalRevenue) * 100, 1) : 0;
                    $pendingPercentage = $totalRevenue > 0 ? round(($pendingAmount / $totalRevenue) * 100, 1) : 0;
                @endphp
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <small>Payé</small>
                        <small class="text-success">{{ $paidPercentage }}%</small>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: {{ $paidPercentage }}%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <small>Impayé</small>
                        <small class="text-danger">{{ $pendingPercentage }}%</small>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-danger" style="width: {{ $pendingPercentage }}%"></div>
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-6">
                        <div class="border-end">
                            <small class="text-muted">Total facturé</small>
                            <h5 class="text-primary">{{ number_format($totalRevenue, 2) }} DT</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Reste à payer</small>
                        <h5 class="text-danger">{{ number_format($pendingAmount, 2) }} DT</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let currentChart = null;

document.addEventListener('DOMContentLoaded', function() {
    // User Distribution Chart
    const userCtx = document.getElementById('userDistributionChart');
    if (userCtx) {
        new Chart(userCtx, {
            type: 'doughnut',
            data: {
                labels: ['Médecins', 'Secrétaires', 'Patients'],
                datasets: [{
                    data: [
                        {{ $doctorsCount }},
                        {{ $secretariesCount }},
                        {{ $patientsCount }}
                    ],
                    backgroundColor: [
                        'rgba(26, 95, 122, 0.85)',
                        'rgba(40, 167, 69, 0.85)',
                        'rgba(255, 193, 7, 0.85)'
                    ],
                    borderColor: [
                        'rgba(26, 95, 122, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(255, 193, 7, 1)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(33, 37, 41, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(255,255,255,0.2)',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 800
                }
            }
        });
    }
    
    // Revenue Distribution Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'pie',
            data: {
                labels: ['Consultations', 'Examens', 'Autres'],
                datasets: [{
                    data: [70, 20, 10],
                    backgroundColor: ['#1a5f7a', '#f0b429', '#28a745']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    // Monthly Chart
    updateChart('appointments');
});

function updateChart(type) {
    const monthlyCtx = document.getElementById('monthlyChart');
    if (!monthlyCtx) return;
    
    // Update button active state
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    const monthlyData = {
        appointments: [
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 1)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 2)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 3)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 4)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 5)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 6)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 7)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 8)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 9)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 10)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 11)->count() }},
            {{ \App\Models\Appointment::whereYear('date_time', date('Y'))->whereMonth('date_time', 12)->count() }}
        ],
        revenue: [
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 1)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 2)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 3)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 4)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 5)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 6)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 7)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 8)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 9)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 10)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 11)->sum('amount') }},
            {{ \App\Models\Invoice::whereYear('created_at', date('Y'))->whereMonth('created_at', 12)->sum('amount') }}
        ]
    };
    
    const isRevenue = type === 'revenue';
    const data = isRevenue ? monthlyData.revenue : monthlyData.appointments;
    const label = isRevenue ? 'Revenus (DT)' : 'Rendez-vous';
    const color = isRevenue ? 'rgba(40, 167, 69, 0.85)' : 'rgba(26, 95, 122, 0.85)';
    const borderColor = isRevenue ? 'rgba(40, 167, 69, 1)' : 'rgba(26, 95, 122, 1)';
    
    if (currentChart) {
        currentChart.destroy();
    }
    
    currentChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: label,
                data: data,
                backgroundColor: color,
                borderColor: borderColor,
                borderWidth: 1,
                borderRadius: 6,
                barThickness: 28,
                maxBarThickness: 35
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(33, 37, 41, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1,
                    padding: 10,
                    callbacks: {
                        label: function(context) {
                            return ` ${context.parsed.y} ${isRevenue ? 'DT' : 'rendez-vous'}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: isRevenue ? 500 : 1,
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
                        color: '#6c757d',
                        font: { size: 11 }
                    },
                    grid: { display: false }
                }
            },
            animation: {
                duration: 800,
                easing: 'easeOutQuart'
            }
        }
    });
}
</script>
@endpush