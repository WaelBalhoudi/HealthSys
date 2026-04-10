@extends('layouts.app')

@section('title', 'Ajouter un médecin')
@section('page-title', 'Nouveau médecin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ajouter un médecin</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.doctors.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de naissance</label>
                            <input type="date" name="birth_date" class="form-control">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Spécialité <span class="text-danger">*</span></label>
                            <select name="specialty" class="form-control" required>
                                <option value="">Choisir une spécialité</option>
                                <option value="Cardiologue">Cardiologue</option>
                                <option value="Dermatologue">Dermatologue</option>
                                <option value="Pédiatre">Pédiatre</option>
                                <option value="Gynécologue">Gynécologue</option>
                                <option value="Ophtalmologue">Ophtalmologue</option>
                                <option value="Dentiste">Dentiste</option>
                                <option value="Généraliste">Généraliste</option>
                            </select>
                            @error('specialty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Numéro d'inscription <span class="text-danger">*</span></label>
                            <input type="text" name="registration_number" class="form-control" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Honoraire (DT) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="consultation_fee" class="form-control" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Diplôme</label>
                            <input type="text" name="diploma" class="form-control">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-custom">Ajouter le médecin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection