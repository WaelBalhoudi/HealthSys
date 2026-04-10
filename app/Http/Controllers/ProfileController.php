<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Validation de base
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ];

        // Validation pour les médecins uniquement (si le doctor existe)
        if ($user->role == 'doctor' && $user->doctor) {
            $rules['specialty'] = 'nullable|string';
            $rules['registration_number'] = 'nullable|string';
            $rules['consultation_fee'] = 'nullable|numeric';
            $rules['cabinet_phone'] = 'nullable|string';
            $rules['diploma'] = 'nullable|string';
        }

        $request->validate($rules);

        // ================= MISE À JOUR TABLE users =================
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ]);

        // ================= GESTION AVATAR =================
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Enregistrer le nouvel avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }

        // ================= MISE À JOUR TABLE doctors (UNIQUEMENT SI LE DOCTEUR EXISTE) =================
        if ($user->role == 'doctor' && $user->doctor) {
            $doctor = $user->doctor;
            
            $doctor->specialty = $request->specialty ?? $doctor->specialty;
            $doctor->registration_number = $request->registration_number ?? $doctor->registration_number;
            $doctor->consultation_fee = $request->consultation_fee ?? $doctor->consultation_fee;
            $doctor->cabinet_phone = $request->cabinet_phone ?? $doctor->cabinet_phone;
            $doctor->diploma = $request->diploma ?? $doctor->diploma;
            
            $doctor->save();
        }

        // ================= CHANGER LE MOT DE PASSE =================
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Message de succès adapté au rôle
        $message = 'Profil mis à jour avec succès';
        
        return redirect()->route('profile.edit')->with('success', $message);
    }
}