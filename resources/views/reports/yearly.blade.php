@extends('layouts.app')

@section('title', 'Rapport annuel')
@section('page-title', 'Rapport annuel - Année ' . $year)

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
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h6 class="card-title">Total rendez-vous</h6>
                <h2 class="mb-0">{{ $stats['total_appointments'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h6 class="card-title">Nouveaux patients</h6>
                <h2 class="mb-0">{{ $stats['total_patients'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h6 class="card-title">Chiffre d'affaires</h6>
                <h2 class="mb-0">{{ number_format($stats['total_revenue'], 2) }} DT</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Évolution mensuelle</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Mois</th>
                                <th>Rendez-vous</th>
                                <th>Chiffre d'affaires (DT)</th>
                                <th>Moyenne par RDV</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats['monthly_data'] as $data)
                            <tr>
                                <td><strong>{{ $data['month'] }}</strong></td>
                                <td>{{ $data['appointments'] }}</td>
                                <td>{{ number_format($data['revenue'], 2) }}</td>
                                <td>{{ $data['appointments'] > 0 ? number_format($data['revenue'] / $data['appointments'], 2) : 0 }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light fw-bold">
                            <tr>
                                <td>Total</td>
                                <td>{{ $stats['total_appointments'] }}</td>
                                <td>{{ number_format($stats['total_revenue'], 2) }}</td>
                                <td>{{ $stats['total_appointments'] > 0 ? number_format($stats['total_revenue'] / $stats['total_appointments'], 2) : 0 }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection