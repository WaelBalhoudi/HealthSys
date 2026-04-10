@extends('layouts.app')

@section('title', 'Ajouter un patient')
@section('page-title', 'Nouveau patient')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Ajouter un patient</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('/secretaire/patients') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                        <input type="date" name="birth_date" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Groupe sanguin</label>
                        <select name="blood_type" class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Poids (kg)</label>
                        <input type="number" step="0.01" name="weight" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Taille (cm)</label>
                        <input type="number" step="0.01" name="height" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Adresse</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Numéro mutuelle</label>
                        <input type="text" name="insurance_number" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Compagnie mutuelle</label>
                        <input type="text" name="insurance_company" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact d'urgence</label>
                        <input type="text" name="emergency_contact" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone urgence</label>
                        <input type="text" name="emergency_phone" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Allergies</label>
                        <textarea name="allergies" class="form-control" rows="2" placeholder="Liste des allergies..."></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Antécédents médicaux</label>
                        <textarea name="medical_history" class="form-control" rows="2" placeholder="Antécédents chirurgicaux, maladies chroniques..."></textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ url('/secretaire/patients') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection