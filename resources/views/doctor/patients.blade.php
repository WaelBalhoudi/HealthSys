@extends('layouts.app')

@section('title', 'Mes patients')
@section('page-title', 'Liste de mes patients')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="fas fa-user-injured"></i> Mes patients</h4>
    </div>
    <div class="card-body">
        @if(isset($patients) && $patients->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Dernière consultation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $patient->user->name ?? 'N/A' }}</td>
                            <td>{{ $patient->user->email ?? 'N/A' }}</td>
                            <td>{{ $patient->user->phone ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $lastConsultation = $patient->consultations()
                                        ->where('doctor_id', auth()->user()->doctor->id ?? 0)
                                        ->latest('consultation_date')
                                        ->first();
                                @endphp
                                {{ $lastConsultation ? $lastConsultation->consultation_date->format('d/m/Y') : 'Jamais' }}
                            </td>
                            <td>
                                <a href="{{ url('/doctor/patients/'.$patient->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Voir dossier
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-injured fa-4x text-muted mb-3"></i>
                <p class="text-muted">Aucun patient pour le moment</p>
            </div>
        @endif
    </div>
</div>
@endsection