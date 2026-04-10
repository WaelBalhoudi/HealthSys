@extends('layouts.app')

@section('title', 'Mes ordonnances')
@section('page-title', 'Mes ordonnances')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-prescription"></i> Liste de mes ordonnances</h5>
    </div>
    <div class="card-body">
        @if($prescriptions->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Médecin</th>
                            <th>Spécialité</th>
                            <th>Médicaments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescriptions as $prescription)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $prescription->created_at->format('d/m/Y') }}</td>
                            <td>Dr. {{ $prescription->doctor->user->name ?? 'N/A' }}</td>
                            <td>{{ $prescription->doctor->specialty ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $meds = is_array($prescription->medications) ? $prescription->medications : json_decode($prescription->medications, true);
                                @endphp
                                @if(is_array($meds))
                                    @foreach(array_slice($meds, 0, 2) as $med)
                                        <span class="badge bg-info">{{ $med['name'] ?? '' }}</span>
                                    @endforeach
                                    @if(count($meds) > 2)
                                        <span class="badge bg-secondary">+{{ count($meds) - 2 }}</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('prescriptions.pdf', $prescription) }}" class="btn btn-danger btn-sm" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Télécharger
                                </a>
                                <a href="{{ route('prescriptions.show', $prescription) }}" class="btn btn-info btn-sm">
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
                <i class="fas fa-prescription fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucune ordonnance enregistrée</p>
            </div>
        @endif
    </div>
</div>
@endsection