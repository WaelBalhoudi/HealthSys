@extends('layouts.app')

@section('title', 'Mes consultations')
@section('page-title', 'Mes consultations')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Liste des consultations</h5>
    </div>
    <div class="card-body">
        @if($consultations->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Diagnostic</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultations as $consultation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $consultation->patient->user->name }}</td>
                            <td>{{ $consultation->consultation_date->format('d/m/Y') }}</td>
                            <td>{{ Str::limit($consultation->diagnosis, 50) }}</td>
                            <td>
                                <a href="{{ route('consultations.show', $consultation) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-stethoscope fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucune consultation enregistrée</p>
            </div>
        @endif
    </div>
</div>
@endsection