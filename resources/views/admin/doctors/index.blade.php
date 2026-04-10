@extends('layouts.app')

@section('title', 'Gestion des médecins')
@section('page-title', 'Médecins')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des médecins</h5>
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-custom">
            <i class="fas fa-plus"></i> Ajouter un médecin
        </a>
    </div>
    <div class="card-body">
        @if($doctors->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Spécialité</th>
                            <th>Matricule</th>
                            <th>Honoraire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $doctor->user->name }}</strong></td>
                            <td>{{ $doctor->user->email }}</td>
                            <td>{{ $doctor->user->phone }}</td>
                            <td><span class="badge bg-primary">{{ $doctor->specialty }}</span></td>
                            <td><code>{{ $doctor->registration_number }}</code></td>
                            <td>{{ number_format($doctor->consultation_fee, 2) }} DT</td>
                            <td>
                                <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce médecin ?')">
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
                <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                <p class="text-muted">Aucun médecin enregistré</p>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-custom">Ajouter le premier médecin</a>
            </div>
        @endif
    </div>
</div>
@endsection