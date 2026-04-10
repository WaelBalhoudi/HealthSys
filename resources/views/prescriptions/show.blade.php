@extends('layouts.app')

@section('title', 'Détails ordonnance')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-prescription"></i> Ordonnance médicale</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Dr. {{ $prescription->doctor->user->name }}</h5>
                            <p>Spécialité: {{ $prescription->doctor->specialty }}</p>
                            <p>N° inscription: {{ $prescription->doctor->registration_number }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5>Patient: {{ $prescription->patient->user->name }}</h5>
                            <p>Date: {{ $prescription->prescription_date->format('d/m/Y') }}</p>
                            @if($prescription->valid_until)
                                <p>Valable jusqu'au: {{ \Carbon\Carbon::parse($prescription->valid_until)->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    </div>

                    <h5>Médicaments prescrits:</h5>
                    <table class="table table-bordered">
                        <thead class="table-light">
                            脂
                                <th>Médicament</th>
                                <th>Dosage</th>
                                <th>Durée</th>
                            </thead>
                        <tbody>
                            @php
                                $meds = is_array($prescription->medications) ? $prescription->medications : json_decode($prescription->medications, true);
                            @endphp
                            @foreach($meds as $med)
                                <tr>
                                    <td>{{ $med['name'] ?? '' }}</td>
                                    <td>{{ $med['dosage'] ?? '' }}</td>
                                    <td>{{ $med['duration'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($prescription->instructions)
                        <div class="mt-3">
                            <h5>Instructions:</h5>
                            <p class="alert alert-info">{{ $prescription->instructions }}</p>
                        </div>
                    @endif

                    <div class="mt-4 text-center">
                        <a href="{{ route('prescriptions.pdf', $prescription) }}" class="btn btn-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i> Télécharger PDF
                        </a>
                        <a href="{{ route('prescriptions.print', $prescription) }}" class="btn btn-secondary" target="_blank">
                            <i class="fas fa-print"></i> Imprimer
                        </a>
                        <a href="{{ route('prescriptions.edit', $prescription) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('prescriptions.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    <small>HealthSys - Système de gestion de cabinet médical</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection