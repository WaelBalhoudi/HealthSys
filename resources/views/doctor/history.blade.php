@extends('layouts.app')

@section('title', 'Historique des visites')
@section('page-title', 'Historique de mes visites')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-history"></i> Historique des consultations</h5>
    </div>
    <div class="card-body">
        @if($consultations->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Date de visite</th>
                            <th>Diagnostic</th>
                            <th>Traitement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultations as $consultation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $consultation->patient->user->name }}</strong><br>
                                <small>{{ $consultation->patient->user->phone }}</small>
                            </td>
                            <td>{{ $consultation->consultation_date->format('d/m/Y') }}</td>
                            <td>{{ Str::limit($consultation->diagnosis, 50) }}</td>
                            <td>{{ Str::limit($consultation->treatment, 50) }}</td>
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
                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucune consultation enregistrée</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Détails -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Détails de la consultation</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Contenu chargé dynamiquement -->
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
                        <p><strong>Âge:</strong> ${data.patient.age} ans</p>
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
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Poids:</strong> ${data.weight ? data.weight + ' kg' : 'N/A'}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Taille:</strong> ${data.height ? data.height + ' cm' : 'N/A'}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Tension:</strong> ${data.blood_pressure || 'N/A'}</p>
                    </div>
                </div>
            `;
            document.getElementById('modalContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('detailsModal')).show();
        });
}
</script>
@endsection