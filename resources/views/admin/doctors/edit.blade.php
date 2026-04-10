@extends('layouts.app')

@section('title', 'Modifier un médecin')
@section('page-title', 'Modifier le médecin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Modifier : {{ $doctor->user->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->user->name) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->user->email) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->user->phone) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de naissance</label>
                            <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $doctor->user->birth_date) }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Spécialité</label>
                            <select name="specialty" class="form-control" required>
                                <option value="Cardiologue" {{ $doctor->specialty == 'Cardiologue' ? 'selected' : '' }}>Cardiologue</option>
                                <option value="Dermatologue" {{ $doctor->specialty == 'Dermatologue' ? 'selected' : '' }}>Dermatologue</option>
                                <option value="Pédiatre" {{ $doctor->specialty == 'Pédiatre' ? 'selected' : '' }}>Pédiatre</option>
                                <option value="Gynécologue" {{ $doctor->specialty == 'Gynécologue' ? 'selected' : '' }}>Gynécologue</option>
                                <option value="Ophtalmologue" {{ $doctor->specialty == 'Ophtalmologue' ? 'selected' : '' }}>Ophtalmologue</option>
                                <option value="Généraliste" {{ $doctor->specialty == 'Généraliste' ? 'selected' : '' }}>Généraliste</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Numéro d'inscription</label>
                            <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $doctor->registration_number) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Honoraire (DT)</label>
                            <input type="number" step="0.01" name="consultation_fee" class="form-control" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Diplôme</label>
                            <input type="text" name="diploma" class="form-control" value="{{ old('diploma', $doctor->diploma) }}">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $doctor->user->address) }}</textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-custom">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection