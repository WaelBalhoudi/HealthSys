@extends('layouts.app')

@section('title', 'Modifier la facture')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header bg-gray-50">
            <h3 class="font-semibold text-gray-800">Modifier la facture</h3>
            <p class="text-sm text-gray-500 mt-1">Facture #{{ $invoice->invoice_number }}</p>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="form-label">Patient <span class="text-red-500">*</span></label>
                        <select name="patient_id" class="form-input" required>
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ $invoice->patient_id == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user->name }} - {{ $patient->user->phone }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Montant (DT) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-input" value="{{ old('amount', $invoice->amount) }}" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Date d'émission <span class="text-red-500">*</span></label>
                            <input type="date" name="issue_date" class="form-input" value="{{ old('issue_date', $invoice->issue_date->format('Y-m-d')) }}" required>
                        </div>
                        <div>
                            <label class="form-label">Date d'échéance <span class="text-red-500">*</span></label>
                            <input type="date" name="due_date" class="form-input" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Statut <span class="text-red-500">*</span></label>
                        <select name="status" class="form-input" required>
                            <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Payée</option>
                            <option value="partially_paid" {{ $invoice->status == 'partially_paid' ? 'selected' : '' }}>Partiellement payée</option>
                            <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-input" rows="3" placeholder="Description de la prestation...">{{ old('description', $invoice->description) }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn-secondary">Annuler</a>
                        <button type="submit" class="btn-primary">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection