@extends('layouts.app')

@section('title', 'Nouvelle facture')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header bg-gray-50">
            <h3 class="font-semibold text-gray-800">Créer une facture</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="form-label">Patient <span class="text-red-500">*</span></label>
                        <select name="patient_id" class="form-input" required>
                            <option value="">Sélectionner un patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name }} - {{ $patient->user->phone }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Montant (DT) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-input" placeholder="0.00" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Date d'émission <span class="text-red-500">*</span></label>
                            <input type="date" name="issue_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div>
                            <label class="form-label">Date d'échéance <span class="text-red-500">*</span></label>
                            <input type="date" name="due_date" class="form-input" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-input" rows="3" placeholder="Description de la prestation..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('invoices.index') }}" class="btn-secondary">Annuler</a>
                        <button type="submit" class="btn-primary">Créer la facture</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection