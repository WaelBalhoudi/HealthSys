@extends('layouts.app')

@section('title', 'Facture ' . $invoice->invoice_number)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card">
        <div class="card-header bg-gray-50 flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-gray-800">Facture #{{ $invoice->invoice_number }}</h3>
                <p class="text-sm text-gray-500">Créée le {{ $invoice->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('invoices.edit', $invoice) }}" class="btn-warning text-sm px-3 py-1">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('invoices.index') }}" class="btn-secondary text-sm px-3 py-1">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Informations facture -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Patient</p>
                    <p class="font-semibold">{{ $invoice->patient->user->name }}</p>
                    <p class="text-sm">{{ $invoice->patient->user->email }}</p>
                    <p class="text-sm">{{ $invoice->patient->user->phone }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Dates</p>
                    <p><strong>Émission:</strong> {{ \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') }}</p>
                    <p><strong>Échéance:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</p>
                    @if($invoice->due_date < now() && $invoice->status != 'paid')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-triangle"></i> Facture en retard</p>
                    @endif
                </div>
            </div>

            <!-- Détails facture -->
            <div class="border-t border-b py-4 mb-6">
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Description</span>
                    <span class="text-gray-600">Montant</span>
                </div>
                <div class="flex justify-between items-center py-2 border-t">
                    <span>{{ $invoice->description ?? 'Consultation médicale' }}</span>
                    <span class="font-semibold">{{ number_format($invoice->amount, 2) }} DT</span>
                </div>
                <div class="flex justify-between items-center py-2 border-t bg-gray-50">
                    <span class="font-bold">Total</span>
                    <span class="font-bold text-lg">{{ number_format($invoice->amount, 2) }} DT</span>
                </div>
            </div>

            <!-- Paiements -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-semibold">Paiements effectués</h4>
                    @if($invoice->status != 'paid' && $invoice->status != 'cancelled')
                        <button type="button" class="btn-primary text-sm px-3 py-1" data-bs-toggle="modal" data-bs-target="#paymentModal">
                            <i class="fas fa-plus"></i> Ajouter paiement
                        </button>
                    @endif
                </div>

                @if($invoice->payments && $invoice->payments->count() > 0)
                    <div class="space-y-2">
                        @foreach($invoice->payments as $payment)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ number_format($payment->amount, 2) }} DT</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-600 text-xs rounded-full">
                                        {{ $payment->payment_method == 'cash' ? 'Espèces' : ($payment->payment_method == 'card' ? 'Carte' : ($payment->payment_method == 'check' ? 'Chèque' : 'Virement')) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 p-3 bg-primary-50 rounded-lg">
                        <div class="flex justify-between">
                            <span class="font-semibold">Total payé:</span>
                            <span class="font-semibold text-green-600">{{ number_format($invoice->paid_amount, 2) }} DT</span>
                        </div>
                        <div class="flex justify-between mt-1">
                            <span class="font-semibold">Reste à payer:</span>
                            <span class="font-semibold text-red-600">{{ number_format($invoice->amount - $invoice->paid_amount, 2) }} DT</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6 bg-gray-50 rounded-lg">
                        <i class="fas fa-credit-card text-gray-300 text-3xl mb-2"></i>
                        <p class="text-gray-500">Aucun paiement enregistré</p>
                    </div>
                @endif
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('invoices.edit', $invoice) }}" class="btn-warning">Modifier la facture</a>
                <button onclick="window.print()" class="btn-secondary">Imprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajouter paiement -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('invoices.pay', $invoice) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Montant <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-input" max="{{ $invoice->amount - $invoice->paid_amount }}" required>
                        <small class="text-muted">Reste à payer: {{ number_format($invoice->amount - $invoice->paid_amount, 2) }} DT</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mode de paiement</label>
                        <select name="payment_method" class="form-input" required>
                            <option value="cash">Espèces</option>
                            <option value="card">Carte bancaire</option>
                            <option value="check">Chèque</option>
                            <option value="transfer">Virement bancaire</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date de paiement</label>
                        <input type="date" name="payment_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-input" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection