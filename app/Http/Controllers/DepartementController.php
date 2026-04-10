<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:chef_medecine');
    }

    public function index()
    {
        $departements = Departement::all();
        return view('admin.departements.index', compact('departements'));
    }

    public function create()
    {
        return view('admin.departements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:departements',
            'description' => 'nullable|string',
        ]);

        Departement::create($request->all());

        return redirect()->route('admin.departements.index')
            ->with('success', 'Département ajouté avec succès');
    }

    public function edit(Departement $departement)
    {
        return view('admin.departements.edit', compact('departement'));
    }

    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:departements,nom,' . $departement->id,
            'description' => 'nullable|string',
        ]);

        $departement->update($request->all());

        return redirect()->route('admin.departements.index')
            ->with('success', 'Département modifié avec succès');
    }

    public function destroy(Departement $departement)
    {
        $departement->delete();
        return redirect()->route('admin.departements.index')
            ->with('success', 'Département supprimé avec succès');
    }
}