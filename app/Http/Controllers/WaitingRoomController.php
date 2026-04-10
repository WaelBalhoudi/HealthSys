<?php

namespace App\Http\Controllers;

use App\Models\WaitingRoom;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class WaitingRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Pour le médecin
    public function doctorIndex()
    {
        $doctorId = auth()->user()->doctor->id;
        
        $waiting = WaitingRoom::with(['patient.user', 'doctor.user'])
            ->where('doctor_id', $doctorId)
            ->where('status', 'waiting')
            ->orderBy('priority', 'desc')
            ->orderBy('arrival_time', 'asc')
            ->get();

        $inConsultation = WaitingRoom::with(['patient.user', 'doctor.user'])
            ->where('doctor_id', $doctorId)
            ->where('status', 'in_consultation')
            ->first();

        return view('doctor.waiting-room', compact('waiting', 'inConsultation'));
    }

    // Pour la secrétaire
    public function secretaireIndex()
    {
        $waiting = WaitingRoom::with(['patient.user', 'doctor.user'])
            ->where('status', 'waiting')
            ->orderBy('priority', 'desc')
            ->orderBy('arrival_time', 'asc')
            ->get();

        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();

        return view('secretaire.waiting-room', compact('waiting', 'doctors', 'patients'));
    }

    // Ajouter un patient à la salle d'attente (secrétaire)
    public function add(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'priority' => 'nullable|integer|min:0|max:2',
        ]);

        $existing = WaitingRoom::where('patient_id', $request->patient_id)
            ->whereIn('status', ['waiting', 'in_consultation'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Patient déjà en salle d\'attente');
        }

        WaitingRoom::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_id' => $request->appointment_id,
            'arrival_time' => now(),
            'priority' => $request->priority ?? 0,
            'status' => 'waiting',
        ]);

        // Correction : utiliser redirect()->to()
        return redirect()->to('/secretaire/waiting-room')
            ->with('success', 'Patient ajouté à la salle d\'attente');
    }

    // Démarrer consultation (médecin)
    public function startConsultation(WaitingRoom $waitingRoom)
    {
        $waitingRoom->update([
            'status' => 'in_consultation',
            'start_time' => now(),
        ]);

        // Correction : utiliser redirect()->to()
        return redirect()->to('/doctor/waiting-room')
            ->with('success', 'Consultation démarrée');
    }

    // Terminer consultation (médecin)
    public function complete(WaitingRoom $waitingRoom)
    {
        $waitingRoom->update([
            'status' => 'completed',
            'end_time' => now(),
        ]);

        if ($waitingRoom->appointment_id) {
            $appointment = Appointment::find($waitingRoom->appointment_id);
            if ($appointment && $appointment->status != 'completed') {
                $appointment->update(['status' => 'completed']);
            }
        }

        // Correction : utiliser redirect()->to()
        return redirect()->to('/doctor/waiting-room')
            ->with('success', 'Consultation terminée');
    }

    // Retirer un patient de la salle d'attente (secrétaire)
    public function remove(WaitingRoom $waitingRoom)
    {
        $waitingRoom->delete();
        
        // Correction : utiliser redirect()->to()
        return redirect()->to('/secretaire/waiting-room')
            ->with('success', 'Patient retiré de la salle d\'attente');
    }
}