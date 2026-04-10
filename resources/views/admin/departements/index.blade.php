@extends('layouts.app')

@section('title', 'Gestion des départements')
@section('page-title', 'Départements')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des départements</h5>
        <a href="{{ route('admin.departements.create') }}" class="btn btn-custom">
            <i class="fas fa-plus"></i> Ajouter un département
        </a>
    </div>
    <div class="card-body">
        @if($departements->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Nombre de secrétaires</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departements as $departement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $departement->nom }}</strong></td>
                            <td>{{ $departement->description ?? '-' }}</td>
                            <td>{{ $departement->secretaries->count() }}</td>
                            <td>
                                <a href="{{ route('admin.departements.edit', $departement) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.departements.destroy', $departement) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce département ?')">
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
                <i class="fas fa-building fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucun département enregistré</p>
                <a href="{{ route('admin.departements.create') }}" class="btn btn-custom">Ajouter le premier département</a>
            </div>
        @endif
    </div>
</div>
@endsection