@extends('layouts.app')

@section('title', 'Comptabilité')
@section('page-title', 'Comptabilité / Statistiques')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Patients</h6>
                        <h2 class="mb-0">{{ $stats['total_patients'] }}</h2>
                    </div>
                    <i class="fas fa-users fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Rendez-vous</h6>
                        <h2 class="mb-0">{{ $stats['today_appointments'] }}</h2>
                        <small>Aujourd'hui</small>
                    </div>
                    <i class="fas fa-calendar-check fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Salle d'attente</h6>
                        <h2 class="mb-0">{{ $stats['waiting_patients'] }}</h2>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Revenus</h6>
                        <h2 class="mb-0">{{ number_format($stats['monthly_revenue'], 0) }} DT</h2>
                        <small>Ce mois</small>
                    </div>
                    <i class="fas fa-chart-line fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Chiffre d'affaires</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Rendez-vous par mois</h5>
            </div>
            <div class="card-body">
                <canvas id="appointmentsChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Dernières factures</h5>
                <a href="{{ route('secretaire.facture.create') }}" class="btn btn-custom btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle facture
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>N° Facture</th>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Montant</th>
                                <th>Payé</th>
                                <th>Reste</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->patient->user->name }}</td>
                                <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                                <td>{{ number_format($invoice->amount, 2) }} DT</td>
                                <td class="text-success">{{ number_format($invoice->paid_amount, 2) }} DT</td>
                                <td class="text-danger">{{ number_format($invoice->amount - $invoice->paid_amount, 2) }} DT</td>
                                <td>
                                    @if($invoice->status == 'paid')
                                        <span class="badge bg-success">Payée</span>
                                    @elseif($invoice->status == 'partially_paid')
                                        <span class="badge bg-warning">Partielle</span>
                                    @else
                                        <span class="badge bg-danger">Impayée</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des revenus
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Revenus (DT)',
                data: @json($monthly_revenue_data),
                borderColor: '#1a5f7a',
                backgroundColor: 'rgba(26, 95, 122, 0.1)',
                fill: true,
                tension: 0.3
            }]
        }
    });
    
    // Graphique des rendez-vous
    new Chart(document.getElementById('appointmentsChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Rendez-vous',
                data: @json($appointments_data),
                backgroundColor: '#f0b429'
            }]
        }
    });
</script>
@endsection