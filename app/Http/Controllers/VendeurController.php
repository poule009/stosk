<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendeur;

class VendeurController extends Controller
{
    /**
     * Display a listing of the vendeurs.
     */
    public function index()
    {
        $vendeurs = Vendeur::paginate(10);
        return view('vendeurs.index', compact('vendeurs'));
    }

    /**
     * Show the form for creating a new vendeur.
     */
    public function create()
    {
        return view('vendeurs.create');
    }

    /**
     * Store a newly created vendeur in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:vendeurs,email',
            'phone' => 'nullable|string|max:20',
        ]);

        Vendeur::create($request->all());

        return redirect()->route('vendeurs.index')->with('success', 'Vendeur créé avec succès.');
    }

    /**
     * Display the specified vendeur.
     */
    public function show(Vendeur $vendeur)
    {
        return view('vendeurs.show', compact('vendeur'));
    }

    /**
     * Show the form for editing the specified vendeur.
     */
    public function edit(Vendeur $vendeur)
    {
        return view('vendeurs.edit', compact('vendeur'));
    }

    /**
     * Update the specified vendeur in storage.
     */
    public function update(Request $request, Vendeur $vendeur)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:vendeurs,email,' . $vendeur->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $vendeur->update($request->all());

        return redirect()->route('vendeurs.index')->with('success', 'Vendeur mis à jour avec succès.');
    }

    /**
     * Remove the specified vendeur from storage.
     */
    public function destroy(Vendeur $vendeur)
    {
        $vendeur->delete();

        return redirect()->route('vendeurs.index')->with('success', 'Vendeur supprimé avec succès.');
    }
}
