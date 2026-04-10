<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $consultations = Consultation::with(['patient.user', 'doctor.user'])
            ->orderBy('consultation_date', 'desc')
            ->get();
        return view('consultations.index', compact('consultations'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->where('status', 'confirmed')
            ->where('date_time', '<', now())
            ->get();
        return view('consultations.create', compact('patients', 'doctors', 'appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'consultation_date' => 'required|date',
        ]);

        $consultation = Consultation::create([
            'appointment_id' => $request->appointment_id,
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'consultation_date' => $request->consultation_date,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'weight' => $request->weight,
            'height' => $request->height,
            'blood_pressure' => $request->blood_pressure,
            'temperature' => $request->temperature,
            'heart_rate' => $request->heart_rate,
            'notes' => $request->notes,
        ]);

        if ($request->appointment_id) {
            Appointment::where('id', $request->appointment_id)->update(['status' => 'completed']);
        }

        return redirect()->route('consultations.show', $consultation)
            ->with('success', 'Consultation enregistrée avec succès');
    }

    public function show(Consultation $consultation)
    {
        $consultation->load(['patient.user', 'doctor.user', 'appointment']);
        return view('consultations.show', compact('consultation'));
    }

    public function edit(Consultation $consultation)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        return view('consultations.edit', compact('consultation', 'patients', 'doctors'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'consultation_date' => 'required|date',
        ]);

        $consultation->update($request->all());

        return redirect()->route('consultations.show', $consultation)
            ->with('success', 'Consultation modifiée avec succès');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return redirect()->route('consultations.index')
            ->with('success', 'Consultation supprimée avec succès');
    }

    // Méthodes pour le médecin
    public function doctorConsultations()
    {
        $consultations = Consultation::with(['patient.user'])
            ->where('doctor_id', auth()->user()->doctor->id)
            ->orderBy('consultation_date', 'desc')
            ->get();
        
        return view('doctor.consultations', compact('consultations'));
    }

    public function visitHistory()
    {
        $consultations = Consultation::with(['patient.user'])
            ->where('doctor_id', auth()->user()->doctor->id)
            ->orderBy('consultation_date', 'desc')
            ->get();
        
        return view('doctor.history', compact('consultations'));
    }

    // Méthodes pour le patient
    public function patientMedicalRecord()
    {
        $consultations = Consultation::with(['doctor.user'])
            ->where('patient_id', auth()->user()->patient->id)
            ->orderBy('consultation_date', 'desc')
            ->get();
        
        return view('patient.medical-record', compact('consultations'));
    }

    public function details(Consultation $consultation)
    {
        $consultation->load(['patient.user', 'doctor.user']);
        return response()->json($consultation);
    }
    
}