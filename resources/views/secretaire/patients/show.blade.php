@extends('layouts.app')

@section('title', 'Détails du patient')
@section('page-title', 'Informations du patient')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="fas fa-user-circle"></i> {{ $patient->user->name }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="40%">Nom complet</th><td>{{ $patient->user->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $patient->user->email }}</td></tr>
                    <tr><th>Téléphone</th><td>{{ $patient->user->phone }}</td></tr>
                    <tr><th>Date naissance</th><td>{{ \Carbon\Carbon::parse($patient->user->birth_date)->format('d/m/Y') }}</td></tr>
                    <tr><th>Âge</th><td>{{ \Carbon\Carbon::parse($patient->user->birth_date)->age }} ans</td></tr>
                    <tr><th>Adresse</th><td>{{ $patient->user->address ?? 'Non renseignée' }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="40%">Mutuelle</th><td>{{ $patient->insurance_company ?? 'Aucune' }}</td></tr>
                    <tr><th>N° mutuelle</th><td>{{ $patient->insurance_number ?? 'Non renseigné' }}</td></tr>
                    <tr><th>Groupe sanguin</th><td>{{ $patient->blood_type ?? 'Non renseigné' }}</td></tr>
                    <tr><th>Allergies</th><td>{{ $patient->allergies ?? 'Aucune' }}</td></tr>
                    <tr><th>Antécédents</th><td>{{ $patient->medical_history ?? 'Aucun' }}</td></tr>
                    <tr><th>Contact urgence</th><td>{{ $patient->emergency_contact ?? 'Non renseigné' }} - {{ $patient->emergency_phone ?? '' }}</td></tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ url('/secretaire/patients/'.$patient->id.'/edit') }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ url('/secretaire/patients') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>
@endsection