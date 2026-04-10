@extends('layouts.app')

@section('title', 'Gestion des spécialités')
@section('page-title', 'Spécialités médicales')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des spécialités</h5>
        <a href="{{ route('admin.specialites.create') }}" class="btn btn-custom">
            <i class="fas fa-plus"></i> Ajouter une spécialité
        </a>
    </div>
    <div class="card-body">
        @if($specialites->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Nombre de médecins</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($specialites as $specialite)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $specialite->nom }}</strong></td>
                            <td>{{ $specialite->description ?? '-' }}</td>
                            <td>{{ $specialite->doctors->count() }}</td>
                            <td>
                                <a href="{{ route('admin.specialites.edit', $specialite) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.specialites.destroy', $specialite) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette spécialité ?')">
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
                <i class="fas fa-tag fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucune spécialité enregistrée</p>
                <a href="{{ route('admin.specialites.create') }}" class="btn btn-custom">Ajouter la première spécialité</a>
            </div>
        @endif
    </div>
</div>
@endsection