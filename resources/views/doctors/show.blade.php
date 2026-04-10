@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-user-md"></i> {{ $doctor->user->name }}</h4>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-stethoscope fa-5x text-primary mb-3"></i>
                    <h5>{{ $doctor->specialty }}</h5>
                    <p class="text-muted">Médecin depuis {{ $doctor->created_at->format('d/m/Y') }}</p>
                    <hr>
                    <p><strong>Matricule:</strong> {{ $doctor->registration_number }}</p>
                    <p><strong>Honoraire:</strong> {{ number_format($doctor->consultation_fee, 2) }} DT</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informations détaillées</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>📧 Email:</strong> {{ $doctor->user->email }}</p>
                            <p><strong>📞 Téléphone:</strong> {{ $doctor->user->phone }}</p>
                            <p><strong>📞 Cabinet:</strong> {{ $doctor->cabinet_phone ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>🎂 Date naissance:</strong> {{ $doctor->user->birth_date ? \Carbon\Carbon::parse($doctor->user->birth_date)->format('d/m/Y') : 'Non renseignée' }}</p>
                            <p><strong>🎓 Diplôme:</strong> {{ $doctor->diploma ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    <hr>
                    <p><strong>📍 Adresse:</strong> {{ $doctor->user->address ?? 'Non renseignée' }}</p>
                    
                    @if($doctor->appointments->count() > 0)
                        <hr>
                        <h6>📅 Derniers rendez-vous</h6>
                        <ul>
                            @foreach($doctor->appointments->take(5) as $appointment)
                                <li>{{ $appointment->patient->user->name }} - {{ $appointment->date_time->format('d/m/Y H:i') }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-warning">Modifier</a>
                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection