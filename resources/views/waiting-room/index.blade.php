@extends('layouts.app')

@section('title', 'Salle d\'attente')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Ajouter patient</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('waiting-room.add') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Patient</label>
                            <select name="patient_id" class="form-control" required>
                                <option value="">Choisir</option>
                                @foreach(\App\Models\Patient::with('user')->get() as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Médecin</label>
                            <select name="doctor_id" class="form-control" required>
                                <option value="">Choisir</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Priorité</label>
                            <select name="priority" class="form-control">
                                <option value="0">Normal</option>
                                <option value="1">Prioritaire</option>
                                <option value="2">Urgent</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                    </form>
                </div>
            </div>

            @if($inConsultation)
            <div class="card bg-warning">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-stethoscope"></i> En consultation</h5>
                </div>
                <div class="card-body">
                    <h4>{{ $inConsultation->patient->user->name }}</h4>
                    <p>Dr. {{ $inConsultation->doctor->user->name }}</p>
                    <form action="{{ route('waiting-room.complete', $inConsultation) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">Terminer consultation</button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-clock"></i> File d'attente</h5>
                </div>
                <div class="card-body">
                    @if($waiting->count() > 0)
                        <div class="list-group">
                            @foreach($waiting as $item)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($item->priority == 2)
                                                <span class="badge bg-danger">URGENT</span>
                                            @elseif($item->priority == 1)
                                                <span class="badge bg-warning">Prioritaire</span>
                                            @endif
                                            <strong>{{ $item->patient->user->name }}</strong>
                                            <br>
                                            <small>Arrivé à {{ $item->arrival_time->format('H:i') }}</small>
                                        </div>
                                        <div>
                                            <form action="{{ route('waiting-room.start', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">Démarrer consultation</button>
                                            </form>
                                            <form action="{{ route('waiting-room.remove', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Retirer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">Aucun patient en attente</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection