@extends('layouts.app')

@section('title', 'Nouveau rendez-vous')
@section('page-title', 'Créer un rendez-vous')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-calendar-plus"></i> Nouveau rendez-vous</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('/secretaire/appointments') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" class="form-control @error('patient_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name }} - {{ $patient->user->phone }}</option>
                            @endforeach
                        </select>
                        @error('patient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Médecin <span class="text-danger">*</span></label>
                        <select name="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un médecin</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }} - {{ $doctor->specialty }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date et heure <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="date_time" class="form-control @error('date_time') is-invalid @enderror" required>
                        @error('date_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Durée (minutes)</label>
                        <input type="number" name="duration" class="form-control" value="30">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type de consultation <span class="text-danger">*</span></label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="general">Générale</option>
                            <option value="emergency">Urgence</option>
                            <option value="follow_up">Suivi</option>
                            <option value="specialist">Spécialiste</option>
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Motif</label>
                        <textarea name="reason" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ url('/secretaire/appointments') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection