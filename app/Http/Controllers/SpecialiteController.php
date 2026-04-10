<?php

namespace App\Http\Controllers;

use App\Models\Specialite;
use Illuminate\Http\Request;

class SpecialiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:chef_medecine');
    }

    public function index()
    {
        $specialites = Specialite::all();
        return view('admin.specialites.index', compact('specialites'));
    }

    public function create()
    {
        return view('admin.specialites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:specialites',
            'description' => 'nullable|string',
        ]);

        Specialite::create($request->all());

        return redirect()->route('admin.specialites.index')
            ->with('success', 'Spécialité ajoutée avec succès');
    }

    public function edit(Specialite $specialite)
    {
        return view('admin.specialites.edit', compact('specialite'));
    }

    public function update(Request $request, Specialite $specialite)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:specialites,nom,' . $specialite->id,
            'description' => 'nullable|string',
        ]);

        $specialite->update($request->all());

        return redirect()->route('admin.specialites.index')
            ->with('success', 'Spécialité modifiée avec succès');
    }

    public function destroy(Specialite $specialite)
    {
        $specialite->delete();
        return redirect()->route('admin.specialites.index')
            ->with('success', 'Spécialité supprimée avec succès');
    }
}