@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-warning">
            <h4 class="mb-0"><i class="fas fa-edit"></i> Modifier médecin</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('doctors.update', $doctor) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->user->name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->user->email) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->user->phone) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de naissance</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $doctor->user->birth_date) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Spécialité <span class="text-danger">*</span></label>
                        <select name="specialty" class="form-control" required>
                            <option value="Médecin généraliste" {{ $doctor->specialty == 'Médecin généraliste' ? 'selected' : '' }}>Médecin généraliste</option>
                            <option value="Cardiologue" {{ $doctor->specialty == 'Cardiologue' ? 'selected' : '' }}>Cardiologue</option>
                            <option value="Dermatologue" {{ $doctor->specialty == 'Dermatologue' ? 'selected' : '' }}>Dermatologue</option>
                            <option value="Pédiatre" {{ $doctor->specialty == 'Pédiatre' ? 'selected' : '' }}>Pédiatre</option>
                            <option value="Gynécologue" {{ $doctor->specialty == 'Gynécologue' ? 'selected' : '' }}>Gynécologue</option>
                            <option value="Ophtalmologue" {{ $doctor->specialty == 'Ophtalmologue' ? 'selected' : '' }}>Ophtalmologue</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Numéro d'inscription <span class="text-danger">*</span></label>
                        <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $doctor->registration_number) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Honoraire de consultation (DT) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="consultation_fee" class="form-control" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Diplôme</label>
                        <input type="text" name="diploma" class="form-control" value="{{ old('diploma', $doctor->diploma) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone cabinet</label>
                        <input type="text" name="cabinet_phone" class="form-control" value="{{ old('cabinet_phone', $doctor->cabinet_phone) }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Adresse</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address', $doctor->user->address) }}</textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection