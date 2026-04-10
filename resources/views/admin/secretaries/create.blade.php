@extends('layouts.app')

@section('title', 'Ajouter une secrétaire')
@section('page-title', 'Nouvelle secrétaire')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ajouter une secrétaire</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.secretaries.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">CIN <span class="text-danger">*</span></label>
                        <input type="text" name="cin" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" name="prenom" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Numéro de téléphone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Département <span class="text-danger">*</span></label>
                        <select name="departement_id" class="form-control" required>
                            <option value="">Sélectionner un département</option>
                            @foreach($departements as $departement)
                                <option value="{{ $departement->id }}">{{ $departement->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Adresse</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.secretaries.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-custom">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection