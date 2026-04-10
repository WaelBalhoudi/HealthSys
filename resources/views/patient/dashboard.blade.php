@extends('layouts.app')

@section('title', 'Mon espace patient')
@section('page-title', 'Tableau de bord patient')

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
    
    .appointment-card, .consultation-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .appointment-card:hover, .consultation-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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
</style>
@endsection

@section('content')
@php
    $patient = auth()->user()->patient;
    $patientId = $patient ? $patient->id : null;
    $user = auth()->user();
@endphp

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-2 fw-bold">Bonjour, {{ $user->name }} !</h2>
            <p class="mb-0 opacity-75">Bienvenue dans votre espace santé. Voici votre activité récente.</p>
        </div>
        <div class="text-end">
            <i class="fas fa-heartbeat fa-3x opacity-50"></i>
            <p class="mb-0 mt-2 small">{{ now()->format('l d F Y') }}</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card primary shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Prochains RDV</p>
                        <h3 class="fw-bold mb-0">
                            @if($patientId)
                                {{ \App\Models\Appointment::where('patient_id', $patientId)->where('status', 'confirmed')->where('date_time', '>', now())->count() }}
                            @else
                                0
                            @endif
                        </h3>
                        <small class="text-primary mt-2 d-block">
                            <i class="fas fa-calendar-check me-1"></i> À venir
                        </small>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="fas fa-calendar-check text-primary"></i>
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
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Ordonnances</p>
                        <h3 class="fw-bold mb-0">
                            @if($patientId)
                                {{ \App\Models\Prescription::where('patient_id', $patientId)->count() }}
                            @else
                                0
                            @endif
                        </h3>
                        <small class="text-success mt-2 d-block">
                            <i class="fas fa-prescription me-1"></i> Actives
                        </small>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10">
                        <i class="fas fa-prescription text-success"></i>
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
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Factures impayées</p>
                        <h3 class="fw-bold mb-0">
                            @if($patientId)
                                {{ \App\Models\Invoice::where('patient_id', $patientId)->where('status', 'pending')->count() }}
                            @else
                                0
                            @endif
                        </h3>
                        <small class="text-warning mt-2 d-block">
                            <i class="fas fa-file-invoice-dollar me-1"></i> En attente
                        </small>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10">
                        <i class="fas fa-file-invoice-dollar text-warning"></i>
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
                        <p class="text-muted text-uppercase small fw-semibold mb-1">Consultations</p>
                        <h3 class="fw-bold mb-0">
                            @if($patientId)
                                {{ \App\Models\Consultation::where('patient_id', $patientId)->count() }}
                            @else
                                0
                            @endif
                        </h3>
                        <small class="text-info mt-2 d-block">
                            <i class="fas fa-stethoscope me-1"></i> Total
                        </small>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10">
                        <i class="fas fa-stethoscope text-info"></i>
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
                        <a href="{{ route('patient.appointments') }}" class="btn btn-primary btn-action w-100">
                            <i class="fas fa-calendar-plus me-2"></i> Prendre RDV
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('patient.medical-record') }}" class="btn btn-info btn-action w-100">
                            <i class="fas fa-folder-medical me-2"></i> Dossier médical
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('patient.prescriptions') }}" class="btn btn-success btn-action w-100">
                            <i class="fas fa-prescription me-2"></i> Ordonnances
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('patient.invoices') }}" class="btn btn-warning btn-action w-100">
                            <i class="fas fa-file-invoice-dollar me-2"></i> Factures
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row g-4">
    <!-- Upcoming Appointments -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>Prochains rendez-vous
                </h5>
                <a href="{{ route('patient.appointments') }}" class="text-decoration-none small">Voir tout →</a>
            </div>
            <div class="card-body pt-0">
                @php
                    $appointments = $patientId ? \App\Models\Appointment::with(['doctor.user'])
                        ->where('patient_id', $patientId)
                        ->where('date_time', '>', now())
                        ->where('status', 'confirmed')
                        ->orderBy('date_time')
                        ->limit(5)
                        ->get() : collect();
                @endphp
                
                @if($appointments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($appointments as $appointment)
                            <div class="appointment-card list-group-item px-0 py-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                <i class="fas fa-user-md text-primary"></i>
                                            </div>
                                            <strong class="fs-6">Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}</strong>
                                            <span class="badge bg-primary ms-2">{{ $appointment->type ?? 'Consultation' }}</span>
                                        </div>
                                        <div class="ms-4">
                                            <small class="text-muted d-block mb-1">
                                                <i class="far fa-calendar me-2"></i>{{ \Carbon\Carbon::parse($appointment->date_time)->format('d/m/Y') }}
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($appointment->date_time)->format('H:i') }}
                                            </small>
                                            @if($appointment->reason)
                                                <small class="text-muted d-block mt-2">
                                                    <i class="fas fa-sticky-note me-2"></i>{{ Str::limit($appointment->reason, 60) }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-success rounded-pill mb-2">Confirmé</span>
                                        <br>
                                        <button class="btn btn-sm btn-outline-danger mt-2" onclick="cancelAppointment({{ $appointment->id }})">
                                            <i class="fas fa-times"></i> Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="far fa-calendar-times fa-4x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Aucun rendez-vous à venir</p>
                        <a href="{{ route('patient.appointments') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus me-2"></i>Prendre un rendez-vous
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Consultations -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-stethoscope me-2 text-info"></i>Dernières consultations
                </h5>
                <a href="{{ route('patient.medical-record') }}" class="text-decoration-none small">Voir tout →</a>
            </div>
            <div class="card-body pt-0">
                @php
                    $consultations = $patientId ? \App\Models\Consultation::with(['doctor.user'])
                        ->where('patient_id', $patientId)
                        ->orderBy('consultation_date', 'desc')
                        ->limit(5)
                        ->get() : collect();
                @endphp
                
                @if($consultations->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($consultations as $consultation)
                            <div class="consultation-card list-group-item px-0 py-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                                <i class="fas fa-stethoscope text-info"></i>
                                            </div>
                                            <strong class="fs-6">Dr. {{ $consultation->doctor->user->name ?? 'N/A' }}</strong>
                                            <span class="badge bg-info ms-2">{{ $consultation->consultation_date->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="ms-4">
                                            @if($consultation->diagnosis)
                                                <small class="text-muted d-block mb-1">
                                                    <i class="fas fa-diagnoses me-2"></i><strong>Diagnostic:</strong> {{ Str::limit($consultation->diagnosis, 50) }}
                                                </small>
                                            @endif
                                            @if($consultation->treatment)
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-pills me-2"></i><strong>Traitement:</strong> {{ Str::limit($consultation->treatment, 50) }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <a href="#" class="btn btn-sm btn-outline-info" onclick="showConsultationDetails({{ $consultation->id }})">
                                            <i class="fas fa-eye"></i> Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-stethoscope fa-4x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Aucune consultation enregistrée</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Active Treatments & Documents -->
<div class="row g-4 mt-2">
    <!-- Active Treatments -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-pills me-2 text-success"></i>Traitements en cours
                </h5>
            </div>
            <div class="card-body">
                @php
                    $activePrescriptions = $patientId ? \App\Models\Prescription::with(['doctor.user'])
                        ->where('patient_id', $patientId)
                        ->where('status', 'active')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get() : collect();
                @endphp
                
                @if($activePrescriptions->count() > 0)
                    @foreach($activePrescriptions as $prescription)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong class="text-success">Ordonnance du {{ $prescription->prescription_date->format('d/m/Y') }}</strong>
                                    <br>
                                    <small class="text-muted">Dr. {{ $prescription->doctor->user->name ?? 'N/A' }}</small>
                                </div>
                                <a href="{{ route('prescriptions.pdf', $prescription) }}" class="btn btn-sm btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                            </div>
                            <div>
                                @php
                                    $meds = is_array($prescription->medications) ? $prescription->medications : json_decode($prescription->medications, true);
                                @endphp
                                @if(is_array($meds))
                                    @foreach(array_slice($meds, 0, 3) as $med)
                                        <span class="badge bg-light text-dark me-1 mb-1">
                                            {{ $med['name'] ?? '' }} {{ $med['dosage'] ?? '' }}
                                        </span>
                                    @endforeach
                                    @if(count($meds) > 3)
                                        <span class="badge bg-secondary">+{{ count($meds) - 3 }}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if($activePrescriptions->count() >= 5)
                        <div class="text-center mt-2">
                            <a href="{{ route('patient.prescriptions') }}" class="text-decoration-none">Voir toutes mes ordonnances →</a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-pills fa-3x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Aucun traitement en cours</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Documents -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0 section-title">
                    <i class="fas fa-flask me-2 text-warning"></i>Derniers documents
                </h5>
            </div>
            <div class="card-body">
                @php
                    $documents = $patientId ? \App\Models\Document::where('patient_id', $patientId)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get() : collect();
                @endphp
                
                @if($documents->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($documents as $document)
                            <div class="list-group-item px-0 py-2 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-{{ $document->type == 'analysis' ? 'medical' : ($document->type == 'prescription' ? 'prescription' : 'alt') }} text-warning me-2"></i>
                                        <strong>{{ $document->title }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $document->created_at->format('d/m/Y') }}</small>
                                    </div>
                                    <a href="{{ url('/documents/'.$document->id.'/download') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3 opacity-25"></i>
                        <p class="text-muted mb-0">Aucun document disponible</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Health Tips -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-info bg-opacity-10 border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb fa-2x text-info"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">Conseil santé du jour</h6>
                        <p class="mb-0 small text-muted">Prenez soin de votre santé en adoptant une alimentation équilibrée et une activité physique régulière. N'oubliez pas vos rendez-vous médicaux !</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function cancelAppointment(id) {
    if(confirm('Annuler ce rendez-vous ?')) {
        fetch(`/patient/appointments/cancel/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => response.json()).then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Erreur lors de l\'annulation');
            }
        });
    }
}

function showConsultationDetails(id) {
    fetch(`/consultations/${id}/details`)
        .then(response => response.json())
        .then(data => {
            let html = `
                <div class="modal fade" id="consultationModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">Détails de la consultation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Date:</strong> ${data.consultation_date}</p>
                                        <p><strong>Médecin:</strong> Dr. ${data.doctor.user.name}</p>
                                        <p><strong>Spécialité:</strong> ${data.doctor.specialty}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Poids:</strong> ${data.weight ? data.weight + ' kg' : 'N/A'}</p>
                                        <p><strong>Taille:</strong> ${data.height ? data.height + ' cm' : 'N/A'}</p>
                                        <p><strong>Tension:</strong> ${data.blood_pressure || 'N/A'}</p>
                                    </div>
                                </div>
                                <hr>
                                <h6>Symptômes:</h6>
                                <p>${data.symptoms || 'Non renseignés'}</p>
                                <h6>Diagnostic:</h6>
                                <p>${data.diagnosis || 'Non renseigné'}</p>
                                <h6>Traitement:</h6>
                                <p>${data.treatment || 'Non renseigné'}</p>
                                <h6>Notes:</h6>
                                <p>${data.notes || 'Non renseignées'}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', html);
            new bootstrap.Modal(document.getElementById('consultationModal')).show();
            document.getElementById('consultationModal').addEventListener('hidden.bs.modal', function() {
                document.getElementById('consultationModal').remove();
            });
        });
}
</script>
@endpush