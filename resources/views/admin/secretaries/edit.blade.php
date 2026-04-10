@extends('layouts.app')

@section('title', 'Modifier une secrétaire')
@section('page-title', 'Modifier la secrétaire')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Modifier : {{ $secretary->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.secretaries.update', $secretary) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CIN</label>
                            <input type="text" name="cin" class="form-control" value="{{ old('cin', $secretary->cin ?? '') }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $secretary->name) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $secretary->prenom ?? '') }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $secretary->email) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $secretary->phone) }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Département</label>
                            <select name="departement_id" class="form-control" required>
                                <option value="">Sélectionner un département</option>
                                @foreach($departements as $departement)
                                    <option value="{{ $departement->id }}" {{ $secretary->departement_id == $departement->id ? 'selected' : '' }}>
                                        {{ $departement->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $secretary->address) }}</textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.secretaries.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-custom">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection