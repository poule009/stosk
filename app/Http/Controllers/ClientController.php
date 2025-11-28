<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

/**
 * Contrôleur gérant les opérations CRUD pour les clients.
 */
class ClientController extends Controller
{
    /**
     * Affiche une liste de tous les clients.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère les clients les plus récents en premier.
        $clients = Client::latest()->get();
        return view('clients.index', compact('clients'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau client.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Enregistre un nouveau client dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
    }

    /**
     * Affiche les informations d'un client spécifique.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\View\View
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Affiche le formulaire de modification d'un client.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\View\View
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Met à jour un client existant dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Assure que l'email est unique, sauf pour cet utilisateur-ci.
            'email' => 'nullable|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Supprime un client de la base de données.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }
}
