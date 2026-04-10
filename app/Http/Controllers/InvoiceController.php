<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    

    public function index()
    {
        $invoices = Invoice::with(['patient.user', 'consultation'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        return view('invoices.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'description' => 'nullable|string',
        ]);

        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(Invoice::count() + 1, 4, '0', STR_PAD_LEFT);

        Invoice::create([
            'invoice_number' => $invoiceNumber,
            'patient_id' => $request->patient_id,
            'amount' => $request->amount,
            'paid_amount' => 0,
            'status' => 'pending',
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'description' => $request->description,
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Facture créée avec succès');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient.user', 'consultation', 'payments']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $patients = Patient::with('user')->get();
        return view('invoices.edit', compact('invoice', 'patients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|in:pending,paid,partially_paid,cancelled',
            'description' => 'nullable|string',
        ]);

        $invoice->update([
            'patient_id' => $request->patient_id,
            'amount' => $request->amount,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Facture modifiée avec succès');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->payments()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une facture avec des paiements');
        }
        
        $invoice->delete();
        return redirect()->route('invoices.index')
            ->with('success', 'Facture supprimée avec succès');
    }

    public function addPayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . ($invoice->amount - $invoice->paid_amount),
            'payment_method' => 'required|in:cash,card,check,transfer',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
        ]);

        $newPaidAmount = $invoice->paid_amount + $request->amount;
        
        $status = 'partially_paid';
        if ($newPaidAmount >= $invoice->amount) {
            $status = 'paid';
        }
        
        $invoice->update([
            'paid_amount' => $newPaidAmount,
            'status' => $status,
        ]);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Paiement enregistré avec succès');
    }
    public function patientInvoices()
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        if (!$patient) {
            $patient = Patient::create([
                'user_id' => $user->id,
            ]);
        }
        
        $invoices = Invoice::with(['patient.user'])
            ->where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('patient.invoices', compact('invoices'));
    }
    }