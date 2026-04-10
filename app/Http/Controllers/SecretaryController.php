<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SecretaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:chef_medecine');
    }
    public function dashboard()
    {
        return view('secretaire.dashboard');
    }

    public function index()
    {
        $secretaries = User::where('role', 'secretaire')->with('departement')->get();
        return view('admin.secretaries.index', compact('secretaries'));
    }

    public function create()
    {
        $departements = Departement::all();
        return view('admin.secretaries.create', compact('departements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required',
            'departement_id' => 'required|exists:departements,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'secretaire',
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'departement_id' => $request->departement_id,
        ]);

        return redirect()->route('admin.secretaries.index')
            ->with('success', 'Secrétaire ajouté avec succès');
    }

    public function edit(User $secretary)
    {
        if ($secretary->role != 'secretaire') {
            abort(404);
        }
        
        $departements = Departement::all();
        return view('admin.secretaries.edit', compact('secretary', 'departements'));
    }

    public function update(Request $request, User $secretary)
    {
        if ($secretary->role != 'secretaire') {
            abort(404);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $secretary->id,
            'phone' => 'required',
            'departement_id' => 'required|exists:departements,id',
        ]);

        $secretary->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'departement_id' => $request->departement_id,
        ]);

        if ($request->password) {
            $secretary->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.secretaries.index')
            ->with('success', 'Secrétaire modifié avec succès');
    }

    public function destroy(User $secretary)
    {
        if ($secretary->role != 'secretaire') {
            abort(404);
        }
        
        $secretary->delete();
        
        return redirect()->route('admin.secretaries.index')
            ->with('success', 'Secrétaire supprimé avec succès');
    }
}