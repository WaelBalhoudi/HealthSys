@extends('layouts.app')

@section('title', 'Liste des ordonnances')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-prescription"></i> Liste des ordonnances</h4>
            <a href="{{ route('prescriptions.create') }}" class="btn btn-light">
                <i class="fas fa-plus"></i> Nouvelle ordonnance
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($prescriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            脂
                                <th>#</th>
                                <th>Patient</th>
                                <th>Médecin</th>
                                <th>Date</th>
                                <th>Valable jusqu'au</th>
                                <th>Médicaments</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </thead>
                        <tbody>
                            @foreach($prescriptions as $prescription)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $prescription->patient->user->name }}</strong><br>
                                        <small class="text-muted">{{ $prescription->patient->user->phone }}</small>
                                    </td>
                                    <td>Dr. {{ $prescription->doctor->user->name }}</td>
                                    <td>{{ $prescription->prescription_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($prescription->valid_until)
                                            {{ \Carbon\Carbon::parse($prescription->valid_until)->format('d/m/Y') }}
                                            @if($prescription->isExpired())
                                                <span class="badge bg-danger">Expirée</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Non spécifiée</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $meds = is_array($prescription->medications) ? $prescription->medications : json_decode($prescription->medications, true);
                                        @endphp
                                        @foreach(array_slice($meds, 0, 2) as $med)
                                            <span class="badge bg-info">{{ $med['name'] ?? '' }}</span>
                                        @endforeach
                                        @if(count($meds) > 2)
                                            <span class="badge bg-secondary">+{{ count($meds) - 2 }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($prescription->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($prescription->status == 'expired')
                                            <span class="badge bg-danger">Expirée</span>
                                        @else
                                            <span class="badge bg-warning">{{ $prescription->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('prescriptions.show', $prescription) }}" class="btn btn-info btn-sm" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('prescriptions.edit', $prescription) }}" class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('prescriptions.pdf', $prescription) }}" class="btn btn-danger btn-sm" title="PDF" target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <a href="{{ route('prescriptions.print', $prescription) }}" class="btn btn-secondary btn-sm" title="Imprimer" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <form action="{{ route('prescriptions.destroy', $prescription) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-dark btn-sm" onclick="return confirm('Supprimer cette ordonnance ?')" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-prescription fa-4x mb-3"></i>
                    <p>Aucune ordonnance enregistrée.</p>
                    <a href="{{ route('prescriptions.create') }}" class="btn btn-primary">Créer votre première ordonnance</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
