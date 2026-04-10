@extends('layouts.app')

@section('title', 'Détails du rendez-vous')
@section('page-title', 'Informations du rendez-vous')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-calendar-alt"></i> Détails du rendez-vous</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Patient</th>
                            <td>{{ $appointment->patient->user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Téléphone patient</th>
                            <td>{{ $appointment->patient->user->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Médecin</th>
                            <td>Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Spécialité</th>
                            <td>{{ $appointment->doctor->specialty ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Date et heure</th>
                            <td>{{ \Carbon\Carbon::parse($appointment->date_time)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Durée</th>
                            <td>{{ $appointment->duration }} minutes</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>
                                @if($appointment->type == 'general')
                                    <span class="badge bg-info">Générale</span>
                                @elseif($appointment->type == 'emergency')
                                    <span class="badge bg-danger">Urgence</span>
                                @elseif($appointment->type == 'follow_up')
                                    <span class="badge bg-warning">Suivi</span>
                                @else
                                    <span class="badge bg-secondary">{{ $appointment->type }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                @if($appointment->status == 'pending')
                                    <span class="badge bg-warning">En attente</span>
                                @elseif($appointment->status == 'confirmed')
                                    <span class="badge bg-success">Confirmé</span>
                                @elseif($appointment->status == 'cancelled')
                                    <span class="badge bg-danger">Annulé</span>
                                @elseif($appointment->status == 'completed')
                                    <span class="badge bg-secondary">Terminé</span>
                                @else
                                    <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @if($appointment->reason)
                        <tr>
                            <th>Motif</th>
                            <td>{{ $appointment->reason }}</td>
                        </tr>
                        @endif
                        @if($appointment->notes)
                        <tr>
                            <th>Notes</th>
                            <td>{{ $appointment->notes }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ url('/secretaire/appointments/'.$appointment->id.'/edit') }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ url('/secretaire/appointments') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
                <form action="{{ url('/secretaire/appointments/'.$appointment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ce rendez-vous ?')">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection