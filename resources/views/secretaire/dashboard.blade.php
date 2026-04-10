@extends('layouts.app')

@section('title', 'Espace secrétaire')
@section('page-title', 'à votre espace secrétaire')

@section('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
        cursor: pointer;
    }
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .quick-action-btn {
        transition: all 0.3s ease;
        border-radius: 12px;
        padding: 12px;
    }
    .quick-action-btn:hover {
        transform: translateX(5px);
    }
    .appointment-row {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .appointment-row:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
    }
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 11px;
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
</style>
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-2 fw-bold">Bonjour, {{ auth()->user()->name }} !</h2>
            <p class="mb-0 opacity-75">Voici le résumé de votre activité du jour</p>
        </div>
        <div class="text-end">
            <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
            <p class="mb-0 mt-2 small">{{ now()->format('l d F Y') }}</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <!-- Patients -->
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Patients</p>
                        <h3 class="fw-bold mb-0">{{ \App\Models\Patient::count() }}</h3>
                        <small class="text-success mt-2 d-block">
                            <i class="fas fa-arrow-up me-1"></i> +12% ce mois
                        </small>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rendez-vous aujourd'hui -->
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Rendez-vous</p>
                        <h3 class="fw-bold mb-0">{{ \App\Models\Appointment::whereDate('date_time', today())->count() }}</h3>
                        <small class="text-info mt-2 d-block">
                            <i class="fas fa-calendar-check me-1"></i> Aujourd'hui
                        </small>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10">
                        <i class="fas fa-calendar-check text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Salle d'attente -->
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Salle d'attente</p>
                        <h3 class="fw-bold mb-0">{{ \App\Models\WaitingRoom::where('status', 'waiting')->count() }}</h3>
                        <small class="text-warning mt-2 d-block">
                            <i class="fas fa-clock me-1"></i> En attente
                        </small>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10">
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenus -->
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Revenus du mois</p>
                        <h3 class="fw-bold mb-0">{{ number_format(\App\Models\Invoice::whereMonth('created_at', now()->month)->sum('amount') ?? 0, 0) }} DT</h3>
                        <small class="text-success mt-2 d-block">
                            <i class="fas fa-chart-line me-1"></i> +5% vs mois dernier
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

<!-- Main Content -->
<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-bolt me-2 text-warning"></i>Actions rapides
                </h5>
            </div>
            <div class="card-body pt-0">
                <div class="d-grid gap-2">
                    <a href="{{ route('secretaire.appointments.create') }}" class="btn btn-primary quick-action-btn">
                        <i class="fas fa-plus-circle me-2"></i> Nouveau rendez-vous
                    </a>
                    <a href="{{ route('secretaire.patients.create') }}" class="btn btn-success quick-action-btn">
                        <i class="fas fa-user-plus me-2"></i> Nouveau patient
                    </a>
                    <a href="{{ route('secretaire.facture.create') }}" class="btn btn-info text-white quick-action-btn">
                        <i class="fas fa-file-invoice-dollar me-2"></i> Nouvelle facture
                    </a>
                    <a href="{{ route('secretaire.waiting-room') }}" class="btn btn-warning quick-action-btn">
                        <i class="fas fa-clock me-2"></i> Gérer salle d'attente
                    </a>
                    <a href="{{ route('secretaire.comptabilite') }}" class="btn btn-secondary quick-action-btn">
                        <i class="fas fa-chart-line me-2"></i> Voir comptabilité
                    </a>
                    <a href="{{ route('secretaire.documents') }}" class="btn btn-dark quick-action-btn">
                        <i class="fas fa-file-alt me-2"></i> Documents
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Appointments -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 section-title">
                        <i class="fas fa-calendar-day me-2 text-primary"></i>Rendez-vous du jour
                    </h5>
                    <span class="badge bg-primary">{{ \App\Models\Appointment::whereDate('date_time', today())->count() }} RDV</span>
                </div>
            </div>
            <div class="card-body pt-0">
                @php
                    $todayAppointments = \App\Models\Appointment::with(['patient.user', 'doctor.user'])
                        ->whereDate('date_time', today())
                        ->orderBy('date_time')
                        ->get();
                @endphp
                
                @if($todayAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Heure</th>
                                    <th>Patient</th>
                                    <th>Médecin</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayAppointments as $appointment)
                                <tr class="appointment-row">
                                    <td>
                                        <span class="fw-bold text-primary">{{ $appointment->date_time->format('H:i') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-2 me-2" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $appointment->patient->user->name }}</strong><br>
                                                <small class="text-muted">{{ $appointment->patient->user->phone }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-2 me-2" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user-md text-success"></i>
                                            </div>
                                            <div>
                                                <strong>Dr. {{ $appointment->doctor->user->name }}</strong><br>
                                                <small class="text-muted">{{ $appointment->doctor->specialty }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($appointment->status == 'confirmed')
                                            <span class="badge-status bg-success text-white">Confirmé</span>
                                        @elseif($appointment->status == 'cancelled')
                                            <span class="badge-status bg-danger text-white">Annulé</span>
                                        @elseif($appointment->status == 'completed')
                                            <span class="badge-status bg-secondary text-white">Terminé</span>
                                        @else
                                            <span class="badge-status bg-warning text-dark">En attente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('secretaire.appointments.edit', $appointment) }}" class="btn btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="showAppointmentDetails({{ $appointment->id }})" class="btn btn-outline-info" title="Détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-check fa-4x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Aucun rendez-vous prévu aujourd'hui</p>
                        <a href="{{ route('secretaire.appointments.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus me-2"></i>Créer un rendez-vous
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Patients -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 section-title">
                        <i class="fas fa-user-plus me-2 text-success"></i>Derniers patients ajoutés
                    </h5>
                    <a href="{{ route('secretaire.patients.index') }}" class="text-decoration-none">
                        Voir tout <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-body pt-0">
                @php
                    $recentPatients = \App\Models\Patient::with('user')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                
                @if($recentPatients->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Patient</th>
                                    <th>Contact</th>
                                    <th>Date d'inscription</th>
                                    <th>Mutuelle</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPatients as $patient)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user text-success"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $patient->user->name ?? 'Patient' }}</strong><br>
                                                <small class="text-muted">ID: {{ $patient->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="fas fa-envelope text-muted me-1"></i> {{ $patient->user->email ?? 'Non renseigné' }}<br>
                                        <i class="fas fa-phone text-muted me-1"></i> {{ $patient->user->phone ?? 'Non renseigné' }}
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar text-muted me-1"></i> {{ $patient->created_at->format('d/m/Y') }}<br>
                                        <small class="text-muted">{{ $patient->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        @if($patient->insurance_number)
                                            <span class="badge bg-info text-white">{{ $patient->insurance_company ?? 'Mutuelle' }}</span>
                                        @else
                                            <span class="badge bg-secondary">Aucune</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('secretaire.patients.show', $patient) }}" class="btn btn-outline-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('secretaire.patients.edit', $patient) }}" class="btn btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-plus fa-4x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Aucun patient enregistré</p>
                        <a href="{{ route('secretaire.patients.create') }}" class="btn btn-success mt-3">
                            <i class="fas fa-plus me-2"></i>Ajouter un patient
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails Rendez-vous -->
<div class="modal fade" id="appointmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Détails du rendez-vous</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="appointmentDetails">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showAppointmentDetails(id) {
    fetch(`/secretaire/appointments/${id}`)
        .then(response => response.json())
        .then(data => {
            let html = `
                <div class="mb-3">
                    <strong>Patient:</strong> ${data.patient.user.name}<br>
                    <strong>Téléphone:</strong> ${data.patient.user.phone || 'Non renseigné'}<br>
                    <strong>Email:</strong> ${data.patient.user.email || 'Non renseigné'}
                </div>
                <div class="mb-3">
                    <strong>Médecin:</strong> Dr. ${data.doctor.user.name}<br>
                    <strong>Spécialité:</strong> ${data.doctor.specialty}<br>
                    <strong>Honoraire:</strong> ${data.doctor.consultation_fee} DT
                </div>
                <div class="mb-3">
                    <strong>Date et heure:</strong> ${new Date(data.date_time).toLocaleString()}<br>
                    <strong>Type:</strong> ${data.type || 'Général'}<br>
                    <strong>Statut:</strong> <span class="badge bg-${data.status == 'confirmed' ? 'success' : 'warning'}">${data.status}</span>
                </div>
                ${data.reason ? `<div class="mb-3"><strong>Motif:</strong><br>${data.reason}</div>` : ''}
                ${data.notes ? `<div class="mb-3"><strong>Notes:</strong><br>${data.notes}</div>` : ''}
            `;
            document.getElementById('appointmentDetails').innerHTML = html;
            new bootstrap.Modal(document.getElementById('appointmentModal')).show();
        });
}
</script>
@endpush