<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specialite;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:chef_medecine');
    }

    // ==================== LISTE DES UTILISATEURS ====================
    public function index(Request $request)
    {
        $query = User::query();

        // Filtre par rôle
        if ($request->has('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $roles = [
            'patient' => 'Patient',
            'doctor' => 'Médecin',
            'secretaire' => 'Secrétaire',
            'chef_medecine' => 'Chef de médecine'
        ];

        return view('admin.users.index', compact('users', 'roles'));
    }

    // ==================== CRÉER UN UTILISATEUR ====================
    public function create()
    {
        $specialites = Specialite::all();
        $departements = Departement::all();
        $roles = [
            'patient' => 'Patient',
            'doctor' => 'Médecin',
            'secretaire' => 'Secrétaire',
            'chef_medecine' => 'Chef de médecine'
        ];
        
        return view('admin.users.create', compact('specialites', 'departements', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:patient,doctor,secretaire,chef_medecine',
            'phone' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'specialite_id' => $request->specialite_id,
            'departement_id' => $request->departement_id,
        ]);

        // Créer automatiquement le profil patient si le rôle est patient
        if ($request->role == 'patient') {
            \App\Models\Patient::create(['user_id' => $user->id]);
        }

        // Créer automatiquement le profil docteur si le rôle est doctor
        if ($request->role == 'doctor') {
            \App\Models\Doctor::create([
                'user_id' => $user->id,
                'specialty' => $request->specialty ?? 'Généraliste',
                'registration_number' => $request->registration_number ?? 'REG' . time(),
                'consultation_fee' => $request->consultation_fee ?? 0,
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès');
    }

    // ==================== AFFICHER UN UTILISATEUR ====================
    public function show(User $user)
    {
        $user->load(['patient', 'doctor', 'specialite', 'departement']);
        
        // Statistiques spécifiques à l'utilisateur
        $stats = [];
        if ($user->role == 'patient' && $user->patient) {
            $stats = [
                'appointments' => $user->patient->appointments()->count(),
                'consultations' => $user->patient->consultations()->count(),
                'prescriptions' => $user->patient->prescriptions()->count(),
                'invoices' => $user->patient->invoices()->sum('amount'),
            ];
        } elseif ($user->role == 'doctor' && $user->doctor) {
            $stats = [
                'appointments' => $user->doctor->appointments()->count(),
                'consultations' => $user->doctor->consultations()->count(),
                'prescriptions' => $user->doctor->prescriptions()->count(),
                'revenue' => $user->doctor->consultations()->sum('consultation_fee'),
            ];
        }

        return view('admin.users.show', compact('user', 'stats'));
    }

    // ==================== MODIFIER UN UTILISATEUR ====================
    public function edit(User $user)
    {
        $specialites = Specialite::all();
        $departements = Departement::all();
        $roles = [
            'patient' => 'Patient',
            'doctor' => 'Médecin',
            'secretaire' => 'Secrétaire',
            'chef_medecine' => 'Chef de médecine'
        ];
        
        return view('admin.users.edit', compact('user', 'specialites', 'departements', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:patient,doctor,secretaire,chef_medecine',
            'phone' => 'required|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'specialite_id' => $request->specialite_id,
            'departement_id' => $request->departement_id,
        ]);

        // Mettre à jour le mot de passe si fourni
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur modifié avec succès');
    }

    // ==================== SUPPRIMER UN UTILISATEUR ====================
    public function destroy(User $user)
    {
        // Empêcher la suppression de son propre compte
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }

        // Supprimer les profils associés
        if ($user->patient) {
            $user->patient->delete();
        }
        if ($user->doctor) {
            $user->doctor->delete();
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès');
    }

    // ==================== CHANGER LE STATUT ====================
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        return redirect()->back()
            ->with('success', 'Statut de l\'utilisateur modifié');
    }

    // ==================== RÉINITIALISER LE MOT DE PASSE ====================
    public function resetPassword(User $user)
    {
        $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        $user->update(['password' => Hash::make($newPassword)]);
        
        return redirect()->back()
            ->with('success', 'Mot de passe réinitialisé. Nouveau mot de passe: ' . $newPassword);
    }

    // ==================== EXPORTER LES UTILISATEURS ====================
    public function export(Request $request)
    {
        $users = User::query();
        
        if ($request->has('role') && $request->role != 'all') {
            $users->where('role', $request->role);
        }
        
        $users = $users->get();
        
        $filename = 'utilisateurs_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://output', 'w');
        
        // En-têtes CSV
        fputcsv($handle, ['ID', 'Nom', 'Email', 'Rôle', 'Téléphone', 'Adresse', 'Date de naissance', 'Créé le']);
        
        // Données
        foreach ($users as $user) {
            fputcsv($handle, [
                $user->id,
                $user->name,
                $user->email,
                $user->role,
                $user->phone,
                $user->address,
                $user->birth_date,
                $user->created_at->format('d/m/Y'),
            ]);
        }
        
        fclose($handle);
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        exit;
    }
}