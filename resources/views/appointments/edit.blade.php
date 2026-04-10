@extends('layouts.app')

@section('title', 'Modifier le rendez-vous')
@section('page-title', 'Modification du rendez-vous')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0"><i class="fas fa-edit"></i> Modifier le rendez-vous</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('/secretaire/appointments/'.$appointment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" class="form-control @error('patient_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user->name }} - {{ $patient->user->phone }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Médecin <span class="text-danger">*</span></label>
                        <select name="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un médecin</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->user->name }} - {{ $doctor->specialty }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date et heure <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="date_time" class="form-control @error('date_time') is-invalid @enderror" 
                               value="{{ \Carbon\Carbon::parse($appointment->date_time)->format('Y-m-d\TH:i') }}" required>
                        @error('date_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Durée (minutes)</label>
                        <input type="number" name="duration" class="form-control" value="{{ $appointment->duration }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type de consultation <span class="text-danger">*</span></label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="general" {{ $appointment->type == 'general' ? 'selected' : '' }}>Générale</option>
                            <option value="emergency" {{ $appointment->type == 'emergency' ? 'selected' : '' }}>Urgence</option>
                            <option value="follow_up" {{ $appointment->type == 'follow_up' ? 'selected' : '' }}>Suivi</option>
                            <option value="specialist" {{ $appointment->type == 'specialist' ? 'selected' : '' }}>Spécialiste</option>
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Statut <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Terminé</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Motif</label>
                        <textarea name="reason" class="form-control" rows="2">{{ $appointment->reason }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ $appointment->notes }}</textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ url('/secretaire/appointments') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection