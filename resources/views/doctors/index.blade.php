@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-user-md"></i> Liste des médecins</h4>
            <a href="{{ route('doctors.create') }}" class="btn btn-light">
                <i class="fas fa-plus"></i> Nouveau médecin
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($doctors->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Spécialité</th>
                                <th>Matricule</th>
                                <th>Honoraire</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctors as $doctor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $doctor->user->name }}</strong><br>
                                    <small>{{ $doctor->user->email }}</small>
                                </td>
                                <td><span class="badge bg-info">{{ $doctor->specialty }}</span></td>
                                <td><code>{{ $doctor->registration_number }}</code></td>
                                <td>{{ number_format($doctor->consultation_fee, 2) }} DT</td>
                                <td>{{ $doctor->user->phone }}</td>
                                <td>
                                    <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce médecin ?')">
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
                <div class="alert alert-info text-center">
                    <i class="fas fa-user-md fa-3x mb-3"></i>
                    <p>Aucun médecin enregistré.</p>
                    <a href="{{ route('doctors.create') }}" class="btn btn-primary">Ajouter votre premier médecin</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection