@extends('layouts.app')

@section('title', 'Salle d\'attente')
@section('page-title', 'Gestion de la salle d\'attente')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Ajouter un patient</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('/secretaire/waiting-room/add') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Patient</label>
                        <select name="patient_id" class="form-control" required>
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name }} - {{ $patient->user->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Médecin</label>
                        <select name="doctor_id" class="form-control" required>
                            <option value="">Sélectionner un médecin</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }} - {{ $doctor->specialty }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Priorité</label>
                        <select name="priority" class="form-control">
                            <option value="0">Normal</option>
                            <option value="1">Prioritaire</option>
                            <option value="2">Urgent</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ajouter à la salle d'attente</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-clock"></i> File d'attente</h5>
            </div>
            <div class="card-body">
                @if($waiting->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Patient</th>
                                    <th>Médecin</th>
                                    <th>Heure d'arrivée</th>
                                    <th>Priorité</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($waiting as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $item->patient->user->name }}</strong><br>
                                        <small class="text-muted">{{ $item->patient->user->phone }}</small>
                                    </td>
                                    <td>Dr. {{ $item->doctor->user->name }}<br>
                                        <small>{{ $item->doctor->specialty }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->arrival_time)->format('H:i') }}<br>
                                        <small>{{ $item->arrival_time->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        @if($item->priority == 2)
                                            <span class="badge bg-danger">Urgent</span>
                                        @elseif($item->priority == 1)
                                            <span class="badge bg-warning">Prioritaire</span>
                                        @else
                                            <span class="badge bg-secondary">Normal</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ url('/secretaire/waiting-room/'.$item->id.'/remove') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Retirer ce patient de la salle d\'attente ?')">
                                                <i class="fas fa-trash"></i> Retirer
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
                        <i class="fas fa-clock fa-4x text-muted mb-3"></i>
                        <p class="text-muted">Aucun patient en salle d'attente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection