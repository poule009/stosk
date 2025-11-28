<?php

namespace App\Http\Controllers;

use App\Models\Telephone;
use Illuminate\Http\Request;

/**
 * Contrôleur qui gère les opérations CRUD pour les téléphones.
 * Inclut la logique pour le téléversement (upload) des images de téléphones.
 */
class TelephoneController extends Controller
{
    /**
     * Affiche la liste des téléphones.
     * Permet un tri de base par colonne.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $telephones = Telephone::orderBy($request->get('sort', 'name'))->get();
        return view('telephones.index', compact('telephones'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau téléphone.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('telephones.create');
    }

    /**
     * Enregistre un nouveau téléphone dans la base de données.
     * Gère le téléversement de l'image si elle est fournie.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'model' => 'required',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        // Vérifie si une image a été envoyée avec le formulaire.
        if ($image = $request->file('image')) {
            // Définit le chemin de destination dans le dossier public.
            $destinationPath = 'images/';
            // Crée un nom de fichier unique basé sur la date et l'heure actuelles.
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            // Déplace le fichier téléversé vers sa destination finale.
            $image->move($destinationPath, $profileImage);
            // Stocke le nom du fichier dans les données à enregistrer.
            $input['image'] = "$profileImage";
        }

        Telephone::create($input);

        return redirect()->route('telephones.index')
                        ->with('success','Telephone created successfully.');
    }

    /**
     * Affiche les détails d'un téléphone spécifique.
     *
     * @param \App\Models\Telephone $telephone
     * @return \Illuminate\View\View
     */
    public function show(Telephone $telephone)
    {
        return view('telephones.show', compact('telephone'));
    }

    /**
     * Affiche le formulaire pour modifier un téléphone.
     *
     * @param \App\Models\Telephone $telephone
     * @return \Illuminate\View\View
     */
    public function edit(Telephone $telephone)
    {
        return view('telephones.edit', compact('telephone'));
    }

    /**
     * Met à jour un téléphone existant.
     * Gère le remplacement de l'image si une nouvelle est fournie.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Telephone $telephone
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Telephone $telephone)
    {
        $request->validate([
            'name' => 'required',
            'model' => 'required',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        // Logique similaire à la méthode store pour la gestion de l'image.
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            // Si aucune nouvelle image n'est envoyée, on retire 'image' des données
            // pour ne pas écraser l'ancienne image avec une valeur nulle.
            unset($input['image']);
        }

        $telephone->update($input);

        return redirect()->route('telephones.index')
                        ->with('success','Telephone updated successfully');
    }

    /**
     * Supprime un téléphone de la base de données.
     *
     * @param \App\Models\Telephone $telephone
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Telephone $telephone)
    {
        // Note: La suppression de l'image physique du serveur n'est pas implémentée ici.
        // Pour une application complète, il faudrait ajouter la logique pour supprimer le fichier image.
        $telephone->delete();

        return redirect()->route('telephones.index')
                        ->with('success','Telephone deleted successfully');
    }

    /**
     * Méthodes personnalisées pour des besoins spécifiques (ex: filtres).
     * Récupère les noms uniques des téléphones en stock.
     */
    public function names()
    {
        $names = Telephone::where('stock', '>', 0)->distinct()->pluck('name');
        return view('telephones.names', compact('names'));
    }

    /**
     * Récupère les modèles uniques des téléphones en stock.
     */
    public function models()
    {
        $models = Telephone::where('stock', '>', 0)->distinct()->pluck('model');
        return view('telephones.models', compact('models'));
    }
}
