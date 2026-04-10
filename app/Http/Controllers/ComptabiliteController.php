<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\WaitingRoom;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ComptabiliteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:secretaire,chef_medecine');
    }

    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'today_appointments' => Appointment::whereDate('date_time', today())->count(),
            'waiting_patients' => WaitingRoom::where('status', 'waiting')->count(),
            'monthly_revenue' => Invoice::whereMonth('created_at', now()->month)->sum('amount'),
        ];
        
        // Données pour les graphiques
        $monthly_revenue_data = [];
        $appointments_data = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $monthly_revenue_data[] = Invoice::whereMonth('created_at', $i)->whereYear('created_at', now()->year)->sum('amount');
            if ($i <= 6) {
                $appointments_data[] = Appointment::whereMonth('date_time', $i)->whereYear('date_time', now()->year)->count();
            }
        }
        
        $invoices = Invoice::with('patient.user')->orderBy('created_at', 'desc')->limit(10)->get();
        
        return view('secretaire.comptabilite', compact('stats', 'monthly_revenue_data', 'appointments_data', 'invoices'));
    }

    public function paiements()
    {
        $invoices = Invoice::with('patient.user')->orderBy('created_at', 'desc')->get();
        return view('secretaire.paiements', compact('invoices'));
    }

    public function createFacture()
    {
        $patients = Patient::with('user')->get();
        return view('secretaire.create-facture', compact('patients'));
    }

    public function storeFacture(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
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

        // Correction ici : utiliser redirect()->to() au lieu de route()
        return redirect()->to('/secretaire/comptabilite')
            ->with('success', 'Facture créée avec succès');
    }
}