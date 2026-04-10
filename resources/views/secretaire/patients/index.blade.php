@extends('layouts.app')

@section('title', 'Liste des patients')
@section('page-title', 'Gestion des patients')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users"></i> Liste des patients</h5>
        <a href="{{ url('/secretaire/patients/create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau patient
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(isset($patients) && $patients->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date naissance</th>
                            <th>Âge</th>
                            <th>Mutuelle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $patient->user->name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $patient->user->address ?? '' }}</small>
                            </td>
                            <td>{{ $patient->user->email ?? 'N/A' }}</td>
                            <td>{{ $patient->user->phone ?? 'N/A' }}</td>
                            <td>{{ $patient->user->birth_date ? \Carbon\Carbon::parse($patient->user->birth_date)->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                @if($patient->user->birth_date)
                                    {{ \Carbon\Carbon::parse($patient->user->birth_date)->age }} ans
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($patient->insurance_number)
                                    <span class="badge bg-info">{{ $patient->insurance_company ?? 'Mutuelle' }}</span>
                                @else
                                    <span class="badge bg-secondary">Aucune</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ url('/secretaire/patients/'.$patient->id) }}" class="btn btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/secretaire/patients/'.$patient->id.'/edit') }}" class="btn btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ url('/secretaire/patients/'.$patient->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ce patient ?')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-injured fa-4x text-muted mb-3"></i>
                <p class="text-muted">Aucun patient enregistré.</p>
                <a href="{{ url('/secretaire/patients/create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter votre premier patient
                </a>
            </div>
        @endif
    </div>
</div>
@endsection