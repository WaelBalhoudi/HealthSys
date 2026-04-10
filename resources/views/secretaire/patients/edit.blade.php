@extends('layouts.app')

@section('title', 'Modifier le patient')
@section('page-title', 'Modification des informations du patient')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0"><i class="fas fa-edit"></i> Modifier le patient</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('/secretaire/patients/'.$patient->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $patient->user->name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $patient->user->email) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->user->phone) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $patient->user->birth_date) }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Adresse</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address', $patient->user->address) }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Numéro mutuelle</label>
                        <input type="text" name="insurance_number" class="form-control" value="{{ old('insurance_number', $patient->insurance_number) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Compagnie mutuelle</label>
                        <input type="text" name="insurance_company" class="form-control" value="{{ old('insurance_company', $patient->insurance_company) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Groupe sanguin</label>
                        <select name="blood_type" class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="A+" {{ $patient->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ $patient->blood_type == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ $patient->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ $patient->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ $patient->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ $patient->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ $patient->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ $patient->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Poids (kg)</label>
                        <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', $patient->weight) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Taille (cm)</label>
                        <input type="number" step="0.01" name="height" class="form-control" value="{{ old('height', $patient->height) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact d'urgence</label>
                        <input type="text" name="emergency_contact" class="form-control" value="{{ old('emergency_contact', $patient->emergency_contact) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone urgence</label>
                        <input type="text" name="emergency_phone" class="form-control" value="{{ old('emergency_phone', $patient->emergency_phone) }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Allergies</label>
                        <textarea name="allergies" class="form-control" rows="2">{{ old('allergies', $patient->allergies) }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Antécédents médicaux</label>
                        <textarea name="medical_history" class="form-control" rows="2">{{ old('medical_history', $patient->medical_history) }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ url('/secretaire/patients') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection