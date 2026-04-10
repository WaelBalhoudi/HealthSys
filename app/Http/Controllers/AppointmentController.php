<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->orderBy('date_time', 'desc')
            ->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date_time' => 'required|date|after:now',
        ]);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'date_time' => $request->date_time,
            'duration' => $request->duration ?? 30,
            'status' => 'pending',
            'type' => $request->type ?? 'general',
            'reason' => $request->reason,
            'notes' => $request->notes,
        ]);

        return redirect()->to('/secretaire/appointments')
            ->with('success', 'Rendez-vous créé avec succès');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date_time' => 'required|date',
            'status' => 'required',
            'type' => 'required',
        ]);

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'date_time' => $request->date_time,
            'duration' => $request->duration ?? 30,
            'type' => $request->type,
            'status' => $request->status,
            'reason' => $request->reason,
            'notes' => $request->notes,
        ]);

        return redirect()->to('/secretaire/appointments')
            ->with('success', 'Rendez-vous modifié avec succès');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->to('/secretaire/appointments')
            ->with('success', 'Rendez-vous supprimé avec succès');
    }

    // Patient methods
    public function patientIndex()
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        if (!$patient) {
            $patient = Patient::create([
                'user_id' => $user->id,
            ]);
            $user->refresh();
            $patient = $user->patient;
        }
        
        $appointments = Appointment::with(['doctor.user'])
            ->where('patient_id', $patient->id)
            ->orderBy('date_time', 'desc')
            ->get();

        if (request()->wantsJson()) {
            return response()->json($appointments);
        }

        $doctors = Doctor::with('user')->get();
        return view('patient.appointments', compact('appointments', 'doctors'));
    }

    public function bookOnline(Request $request)
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        if (!$patient) {
            $patient = Patient::create([
                'user_id' => $user->id,
            ]);
            $user->refresh();
            $patient = $user->patient;
        }
        
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after:now',
        ]);

        $dateTime = Carbon::parse($request->date);

        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('date_time', $dateTime)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Ce créneau n\'est pas disponible']);
        }

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'date_time' => $dateTime,
            'reason' => $request->reason,
            'status' => 'pending',
            'type' => 'general',
            'duration' => 30,
        ]);

        return response()->json(['success' => true, 'appointment' => $appointment]);
    }

    public function cancelOnline($id)
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        if (!$patient) {
            return response()->json(['success' => false, 'message' => 'Patient non trouvé']);
        }
        
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        $appointment->update(['status' => 'cancelled']);

        return response()->json(['success' => true]);
    }
}