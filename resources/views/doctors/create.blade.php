@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-user-md"></i> Ajouter un médecin</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('doctors.store') }}" method="POST">
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
                        <select name="specialty" class="form-control @error('specialty') is-invalid @enderror" required>
                            <option value="">Choisir une spécialité</option>
                            <option value="Médecin généraliste">Médecin généraliste</option>
                            <option value="Cardiologue">Cardiologue</option>
                            <option value="Dermatologue">Dermatologue</option>
                            <option value="Pédiatre">Pédiatre</option>
                            <option value="Gynécologue">Gynécologue</option>
                            <option value="Ophtalmologue">Ophtalmologue</option>
                            <option value="Dentiste">Dentiste</option>
                            <option value="Orthopédiste">Orthopédiste</option>
                            <option value="Neurologue">Neurologue</option>
                            <option value="Psychiatre">Psychiatre</option>
                        </select>
                        @error('specialty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Numéro d'inscription <span class="text-danger">*</span></label>
                        <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" required>
                        @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Honoraire de consultation (DT) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="consultation_fee" class="form-control @error('consultation_fee') is-invalid @enderror" required>
                        @error('consultation_fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Diplôme</label>
                        <input type="text" name="diploma" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone cabinet</label>
                        <input type="text" name="cabinet_phone" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Adresse</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection