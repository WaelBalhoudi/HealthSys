@extends('layouts.app')

@section('title', 'Mon dossier médical')
@section('page-title', 'Dossier médical')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-user-circle"></i> Mes informations</h5>
            </div>
            <div class="card-body">
                @php
                    $patient = auth()->user()->patient;
                    $user = auth()->user();
                @endphp
                <p><strong>Nom complet:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Téléphone:</strong> {{ $user->phone ?? 'Non renseigné' }}</p>
                <p><strong>Date de naissance:</strong> {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') : 'Non renseignée' }}</p>
                <p><strong>Âge:</strong> 
                    @if($user->birth_date)
                        {{ \Carbon\Carbon::parse($user->birth_date)->age }} ans
                    @else
                        Non renseigné
                    @endif
                </p>
                <hr>
                <p><strong>Groupe sanguin:</strong> {{ $patient->blood_type ?? 'Non renseigné' }}</p>
                <p><strong>Allergies:</strong> {{ $patient->allergies ?? 'Aucune' }}</p>
                <p><strong>Mutuelle:</strong> {{ $patient->insurance_company ?? 'Aucune' }}</p>
                <p><strong>N° mutuelle:</strong> {{ $patient->insurance_number ?? 'Non renseigné' }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-history"></i> Historique des consultations</h5>
            </div>
            <div class="card-body">
                @if(isset($consultations) && $consultations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Médecin</th>
                                    <th>Spécialité</th>
                                    <th>Diagnostic</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consultations as $consultation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d/m/Y') }}</td>
                                    <td>Dr. {{ $consultation->doctor->user->name ?? 'N/A' }}</td>
                                    <td>{{ $consultation->doctor->specialty ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($consultation->diagnosis ?? 'Non renseigné', 50) }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="showDetails({{ $consultation->id }})">
                                            <i class="fas fa-eye"></i> Détails
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune consultation enregistrée</p>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-prescription"></i> Mes ordonnances</h5>
            </div>
            <div class="card-body">
                @php
                    $prescriptions = \App\Models\Prescription::where('patient_id', $patient->id ?? 0)->orderBy('created_at', 'desc')->get();
                @endphp
                
                @if($prescriptions->count() > 0)
                    <div class="list-group">
                        @foreach($prescriptions as $prescription)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Ordonnance du {{ $prescription->created_at->format('d/m/Y') }}</strong>
                                        <br>
                                        <small>Dr. {{ $prescription->doctor->user->name ?? 'N/A' }}</small>
                                    </div>
                                    <a href="{{ route('prescriptions.pdf', $prescription) }}" class="btn btn-danger btn-sm" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Voir PDF
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">Aucune ordonnance</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails consultation -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Détails de la consultation</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showDetails(id) {
    fetch(`/consultations/${id}/details`)
        .then(response => response.json())
        .then(data => {
            let html = `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Patient:</strong> ${data.patient.user.name}</p>
                        <p><strong>Date:</strong> ${data.consultation_date}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Médecin:</strong> Dr. ${data.doctor.user.name}</p>
                        <p><strong>Spécialité:</strong> ${data.doctor.specialty}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Symptômes:</h6>
                        <p>${data.symptoms || 'Non renseignés'}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Diagnostic:</h6>
                        <p>${data.diagnosis || 'Non renseigné'}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Traitement:</h6>
                        <p>${data.treatment || 'Non renseigné'}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Notes:</h6>
                        <p>${data.notes || 'Non renseignées'}</p>
                    </div>
                </div>
            `;
            document.getElementById('modalContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('detailsModal')).show();
        });
}
</script>
@endsection