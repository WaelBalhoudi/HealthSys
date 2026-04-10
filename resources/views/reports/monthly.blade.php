@extends('layouts.app')

@section('title', 'Rapport mensuel')
@section('page-title', 'Rapport mensuel - ' . $stats['month'])

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
                <button onclick="window.print()" class="btn btn-primary float-end">
                    <i class="fas fa-print"></i> Imprimer
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h6 class="card-title">Rendez-vous</h6>
                <h2 class="mb-0">{{ $stats['appointments_count'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h6 class="card-title">Confirmés</h6>
                <h2 class="mb-0">{{ $stats['confirmed_appointments'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-danger">
            <div class="card-body text-center">
                <h6 class="card-title">Annulés</h6>
                <h2 class="mb-0">{{ $stats['cancelled_appointments'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h6 class="card-title">Nouveaux patients</h6>
                <h2 class="mb-0">{{ $stats['new_patients'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-dark">
            <div class="card-body text-center">
                <h6 class="card-title">Chiffre d'affaires</h6>
                <h2 class="mb-0">{{ number_format($stats['total_revenue'], 2) }} DT</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h6 class="card-title">Montant payé</h6>
                <h2 class="mb-0">{{ number_format($stats['total_paid'], 2) }} DT</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h6 class="card-title">Reste à payer</h6>
                <h2 class="mb-0">{{ number_format($stats['pending_payment'], 2) }} DT</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Détail des rendez-vous par type</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Type</th>
                            <th>Nombre</th>
                            <th>Pourcentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Général</td>
                            <td>{{ $stats['appointments_by_type']['general'] }}</td>
                            <td>{{ $stats['appointments_count'] > 0 ? round(($stats['appointments_by_type']['general'] / $stats['appointments_count']) * 100, 1) : 0 }}%</td>
                        </tr>
                        <tr>
                            <td>Urgence</td>
                            <td>{{ $stats['appointments_by_type']['emergency'] }}</td>
                            <td>{{ $stats['appointments_count'] > 0 ? round(($stats['appointments_by_type']['emergency'] / $stats['appointments_count']) * 100, 1) : 0 }}%</td>
                        </tr>
                        <tr>
                            <td>Suivi</td>
                            <td>{{ $stats['appointments_by_type']['follow_up'] }}</td>
                            <td>{{ $stats['appointments_count'] > 0 ? round(($stats['appointments_by_type']['follow_up'] / $stats['appointments_count']) * 100, 1) : 0 }}%</td>
                        </tr>
                        <tr>
                            <td>Spécialiste</td>
                            <td>{{ $stats['appointments_by_type']['specialist'] }}</td>
                            <td>{{ $stats['appointments_count'] > 0 ? round(($stats['appointments_by_type']['specialist'] / $stats['appointments_count']) * 100, 1) : 0 }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection