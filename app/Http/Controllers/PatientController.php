<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $patients = Patient::with('user')->get();
        return view('secretaire.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('secretaire.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required',
            'birth_date' => 'required|date',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ]);

        Patient::create([
            'user_id' => $user->id,
            'insurance_number' => $request->insurance_number,
            'insurance_company' => $request->insurance_company,
            'emergency_contact' => $request->emergency_contact,
            'emergency_phone' => $request->emergency_phone,
            'allergies' => $request->allergies,
            'medical_history' => $request->medical_history,
            'blood_type' => $request->blood_type,
            'weight' => $request->weight,
            'height' => $request->height,
        ]);

        return redirect()->to('/secretaire/patients')
            ->with('success', 'Patient ajouté avec succès');
    }

    public function show(Patient $patient)
    {
        $patient->load(['user', 'appointments', 'consultations']);
        return view('secretaire.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $patient->load('user');
        return view('secretaire.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'phone' => 'required',
            'birth_date' => 'required|date',
        ]);

        $patient->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ]);

        $patient->update([
            'insurance_number' => $request->insurance_number,
            'insurance_company' => $request->insurance_company,
            'emergency_contact' => $request->emergency_contact,
            'emergency_phone' => $request->emergency_phone,
            'allergies' => $request->allergies,
            'medical_history' => $request->medical_history,
            'blood_type' => $request->blood_type,
            'weight' => $request->weight,
            'height' => $request->height,
        ]);

        return redirect()->to('/secretaire/patients')
            ->with('success', 'Patient modifié avec succès');
    }

    public function destroy(Patient $patient)
    {
        $patient->user->delete();
        $patient->delete();

        return redirect()->to('/secretaire/patients')
            ->with('success', 'Patient supprimé avec succès');
    }
}