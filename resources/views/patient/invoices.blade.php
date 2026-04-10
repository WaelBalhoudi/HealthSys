@extends('layouts.app')

@section('title', 'Mes factures')
@section('page-title', 'Mes factures')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Mes factures</h5>
    </div>
    <div class="card-body">
        @if(isset($invoices) && $invoices->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>N° Facture</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                            <td>{{ number_format($invoice->amount, 2) }} DT</td>
                            <td>
                                @if($invoice->status == 'paid')
                                    <span class="badge bg-success">Payée</span>
                                @else
                                    <span class="badge bg-warning">En attente</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Aucune facture trouvée.
            </div>
        @endif
    </div>
</div>
@endsection