<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PrescriptionController extends Controller
{
    

    public function index()
    {
        $prescriptions = Prescription::with(['patient.user', 'doctor.user'])
            ->orderBy('prescription_date', 'desc')
            ->get();
        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        return view('prescriptions.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medications' => 'required|array',
            'medications.*.name' => 'required',
            'medications.*.dosage' => 'required',
            'medications.*.duration' => 'required',
            'prescription_date' => 'required|date',
            'valid_until' => 'nullable|date|after:prescription_date',
        ]);

        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'consultation_id' => $request->consultation_id,
            'medications' => json_encode($request->medications),
            'instructions' => $request->instructions,
            'prescription_date' => $request->prescription_date,
            'valid_until' => $request->valid_until,
            'status' => 'active',
        ]);

        return redirect()->route('prescriptions.index')
            ->with('success', 'Ordonnance créée avec succès');
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient.user', 'doctor.user', 'consultation']);
        return view('prescriptions.show', compact('prescription'));
    }

    public function edit(Prescription $prescription)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        return view('prescriptions.edit', compact('prescription', 'patients', 'doctors'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medications' => 'required|array',
            'prescription_date' => 'required|date',
        ]);

        $prescription->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'consultation_id' => $request->consultation_id,
            'medications' => json_encode($request->medications),
            'instructions' => $request->instructions,
            'prescription_date' => $request->prescription_date,
            'valid_until' => $request->valid_until,
            'status' => $request->status,
        ]);

        return redirect()->route('prescriptions.index')
            ->with('success', 'Ordonnance modifiée avec succès');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('prescriptions.index')
            ->with('success', 'Ordonnance supprimée avec succès');
    }

    public function pdf(Prescription $prescription)
    {
        $prescription->load(['patient.user', 'doctor.user']);
        $pdf = Pdf::loadView('pdf.prescription', compact('prescription'));
        return $pdf->download('ordonnance_' . $prescription->id . '_' . $prescription->prescription_date->format('d-m-Y') . '.pdf');
    }

    public function print(Prescription $prescription)
    {
        $prescription->load(['patient.user', 'doctor.user']);
        return view('prescriptions.print', compact('prescription'));
    }

    public function forPatient(Patient $patient)
    {
        $prescriptions = $patient->prescriptions()->with('doctor.user')->orderBy('prescription_date', 'desc')->get();
        return view('prescriptions.patient', compact('patient', 'prescriptions'));
    }

    public function renew(Prescription $prescription)
    {
        $newPrescription = $prescription->replicate();
        $newPrescription->prescription_date = now();
        $newPrescription->valid_until = now()->addMonths(3);
        $newPrescription->status = 'active';
        $newPrescription->created_at = now();
        $newPrescription->save();

        return redirect()->route('prescriptions.show', $newPrescription)
            ->with('success', 'Ordonnance renouvelée avec succès');
    }
    public function patientPrescriptions()
{
        $user = auth()->user();
        $patient = $user->patient;
        
        if (!$patient) {
            $patient = Patient::create([
                'user_id' => $user->id,
            ]);
        }
        
        $prescriptions = Prescription::with(['doctor.user'])
            ->where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('patient.prescriptions', compact('prescriptions'));
    }
    }