@extends('layouts.app')

@section('title', 'Créer une ordonnance')

@section('styles')
<style>
    .medication-item {
        background: #f8f9fa;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    .remove-medication {
        cursor: pointer;
        color: red;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-prescription"></i> Créer une ordonnance</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('prescriptions.store') }}" method="POST" id="prescriptionForm">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" class="form-control" required>
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name }} - {{ $patient->user->phone }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Médecin <span class="text-danger">*</span></label>
                        <select name="doctor_id" class="form-control" required>
                            <option value="">Sélectionner un médecin</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }} - {{ $doctor->specialty }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de prescription <span class="text-danger">*</span></label>
                        <input type="date" name="prescription_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Valable jusqu'au</label>
                        <input type="date" name="valid_until" class="form-control">
                        <small class="text-muted">Laissez vide si pas de date d'expiration</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Médicaments prescrits <span class="text-danger">*</span></label>
                    <div id="medications-container">
                        <div class="medication-item">
                            <div class="row">
                                <div class="col-md-5 mb-2">
                                    <input type="text" name="medications[0][name]" class="form-control" placeholder="Nom du médicament" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <input type="text" name="medications[0][dosage]" class="form-control" placeholder="Dosage (ex: 500mg)" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="text" name="medications[0][duration]" class="form-control" placeholder="Durée (ex: 7 jours)" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-success mt-2" onclick="addMedication()">
                        <i class="fas fa-plus"></i> Ajouter un médicament
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label">Instructions</label>
                    <textarea name="instructions" class="form-control" rows="3" placeholder="Mode d'emploi, précautions..."></textarea>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Créer l'ordonnance
                    </button>
                    <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let medCount = 1;

    function addMedication() {
        const container = document.getElementById('medications-container');
        const newDiv = document.createElement('div');
        newDiv.className = 'medication-item';
        newDiv.innerHTML = `
            <div class="row">
                <div class="col-md-5 mb-2">
                    <input type="text" name="medications[${medCount}][name]" class="form-control" placeholder="Nom du médicament" required>
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" name="medications[${medCount}][dosage]" class="form-control" placeholder="Dosage (ex: 500mg)" required>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="text" name="medications[${medCount}][duration]" class="form-control" placeholder="Durée" required>
                </div>
                <div class="col-md-1 mb-2">
                    <button type="button" class="btn btn-danger btn-sm remove-medication" onclick="this.closest('.medication-item').remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newDiv);
        medCount++;
    }
</script>
@endsection