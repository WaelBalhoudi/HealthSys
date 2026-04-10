@extends('layouts.app')

@section('title', 'Gestion des secrétaires')
@section('page-title', 'Secrétaires')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des secrétaires</h5>
        <a href="{{ route('admin.secretaries.create') }}" class="btn btn-custom">
            <i class="fas fa-plus"></i> Ajouter une secrétaire
        </a>
    </div>
    <div class="card-body">
        @if($secretaries->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Département</th>
                            <th>Date d'ajout</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($secretaries as $secretary)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $secretary->name }}</strong></td>
                            <td>{{ $secretary->email }}</td>
                            <td>{{ $secretary->phone }}</td>
                            <td>
                                @if($secretary->departement)
                                    <span class="badge bg-info">{{ $secretary->departement->nom }}</span>
                                @else
                                    <span class="badge bg-secondary">Non assigné</span>
                                @endif
                             </td>
                            <td>{{ $secretary->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.secretaries.edit', $secretary) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.secretaries.destroy', $secretary) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette secrétaire ?')">
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
            <div class="text-center py-5">
                <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucune secrétaire enregistrée</p>
                <a href="{{ route('admin.secretaries.create') }}" class="btn btn-custom">Ajouter la première secrétaire</a>
            </div>
        @endif
    </div>
</div>
@endsection