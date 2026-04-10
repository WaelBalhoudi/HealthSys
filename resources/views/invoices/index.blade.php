@extends('layouts.app')

@section('title', 'Factures')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Factures</h1>
            <p class="text-gray-500 mt-1">Gestion des factures et paiements</p>
        </div>
        <a href="{{ route('invoices.create') }}" class="btn-primary flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Nouvelle facture</span>
        </a>
    </div>

    <div class="card">
        <div class="overflow-x-auto">
            @if($invoices->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>N° Facture</th>
                            <th>Patient</th>
                            <th>Montant</th>
                            <th>Payé</th>
                            <th>Reste</th>
                            <th>Date échéance</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-sm">{{ $invoice->invoice_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-primary-600 text-sm"></i>
                                    </div>
                                    <span class="font-medium">{{ $invoice->patient->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium">{{ number_format($invoice->amount, 2) }} DT</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-600">
                                {{ number_format($invoice->paid_amount, 2) }} DT
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php $remaining = $invoice->amount - $invoice->paid_amount; @endphp
                                @if($remaining > 0)
                                    <span class="text-red-600 font-medium">{{ number_format($remaining, 2) }} DT</span>
                                @else
                                    <span class="text-green-600">0.00 DT</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}
                                @if($invoice->due_date < now() && $invoice->status != 'paid')
                                    <span class="ml-1 text-red-500"><i class="fas fa-exclamation-triangle"></i></span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($invoice->status == 'paid')
                                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full">Payée</span>
                                @elseif($invoice->status == 'partially_paid')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-600 text-xs rounded-full">Partielle</span>
                                @elseif($invoice->status == 'cancelled')
                                    <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded-full">Annulée</span>
                                @else
                                    <span class="px-2 py-1 bg-orange-100 text-orange-600 text-xs rounded-full">En attente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-800" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('invoices.edit', $invoice) }}" class="text-yellow-600 hover:text-yellow-800" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer cette facture ?')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-file-invoice-dollar text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500 mb-4">Aucune facture enregistrée</p>
                    <a href="{{ route('invoices.create') }}" class="btn-primary inline-flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Créer votre première facture</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection