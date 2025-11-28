<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vente;
use App\Models\Telephone;
use App\Models\Client;
use App\Models\Vendeur;
use Illuminate\Support\Facades\DB;

/**
 * Contrôleur qui gère toutes les opérations CRUD (Créer, Lire, Mettre à jour, Supprimer) pour les ventes.
 * Il gère également la logique de mise à jour des stocks de téléphones lors des ventes, mises à jour ou suppressions.
 */
class VentesController extends Controller
{
    /**
     * Affiche la liste de toutes les ventes.
     * Utilise l'eager loading pour charger les informations liées (téléphone, client, vendeur) et éviter les requêtes N+1.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $ventes = Vente::with(['telephone', 'client', 'vendeur'])->get();
        $telephones = Telephone::all();
        return view('ventes.index', compact('ventes', 'telephones'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle vente.
     * Passe les téléphones en stock, les clients et les vendeurs à la vue pour peupler les listes déroulantes.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $telephones = Telephone::where('stock', '>', 0)->get();
        $clients = Client::all();
        $vendeurs = Vendeur::all();
        return view('ventes.create', compact('telephones', 'clients', 'vendeurs'));
    }

    /**
     * Enregistre une nouvelle vente dans la base de données.
     * Valide les données entrantes et gère la mise à jour du stock dans une transaction de base de données
     * pour garantir l'intégrité des données (soit tout réussit, soit tout est annulé).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'telephone_id' => 'required|exists:telephones,id',
            'client_id' => 'required|exists:clients,id',
            'vendeur_id' => 'required|exists:vendeurs,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            // Utilisation d'une transaction pour s'assurer que la vente et la mise à jour du stock sont atomiques.
            DB::transaction(function () use ($request) {
                $telephone = Telephone::find($request->telephone_id);

                // Vérification cruciale pour s'assurer qu'il y a assez de stock avant de vendre.
                if ($telephone->stock < $request->quantity) {
                    throw new \Exception('Stock insuffisant pour ce téléphone.');
                }

                $totalPrice = $telephone->price * $request->quantity;

                // Crée la vente.
                Vente::create([
                    'telephone_id' => $request->telephone_id,
                    'client_id' => $request->client_id,
                    'vendeur_id' => $request->vendeur_id,
                    'quantity' => $request->quantity,
                    'price' => $totalPrice,
                ]);

                // Décrémente le stock du téléphone vendu.
                $telephone->decrement('stock', $request->quantity);
            });
        } catch (\Exception $e) {
            // En cas d'erreur (ex: stock insuffisant), on retourne à la page précédente avec le message d'erreur.
            return redirect()->back()->withErrors(['transaction' => $e->getMessage()])->withInput();
        }

        return redirect()->route('ventes.index')->with('success', 'Vente enregistrée avec succès.');
    }

    /**
     * Affiche les détails d'une vente spécifique.
     *
     * @param  \App\Models\Vente  $vente
     * @return \Illuminate\View\View
     */
    public function show(Vente $vente)
    {
        $vente->load(['telephone', 'client', 'vendeur']);
        return view('ventes.show', compact('vente'));
    }

    /**
     * Affiche le formulaire pour modifier une vente existante.
     *
     * @param  \App\Models\Vente  $vente
     * @return \Illuminate\View\View
     */
    public function edit(Vente $vente)
    {
        $vente->load(['telephone', 'client', 'vendeur']);
        // Permet de sélectionner le téléphone actuel même s'il est en rupture de stock, en plus des autres téléphones disponibles.
        $telephones = Telephone::where('stock', '>', 0)->orWhere('id', $vente->telephone_id)->get();
        $clients = Client::all();
        $vendeurs = Vendeur::all();
        return view('ventes.edit', compact('vente', 'telephones', 'clients', 'vendeurs'));
    }

    /**
     * Met à jour une vente existante dans la base de données.
     * La logique de stock est complexe car elle doit gérer le changement de téléphone et/ou de quantité.
     * Le tout est encapsulé dans une transaction pour garantir la cohérence des données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vente  $vente
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Vente $vente)
    {
        $request->validate([
            'telephone_id' => 'required|exists:telephones,id',
            'client_id' => 'required|exists:clients,id',
            'vendeur_id' => 'required|exists:vendeurs,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request, $vente) {
                // Étape 1: Annuler l'impact de la vente originale sur le stock.
                // On ré-incrémente le stock de l'ancien téléphone avec l'ancienne quantité.
                $originalTelephone = $vente->telephone;
                $originalTelephone->increment('stock', $vente->quantity);

                // Étape 2: Appliquer l'impact de la nouvelle vente sur le stock.
                $newTelephone = Telephone::find($request->telephone_id);
                if ($newTelephone->stock < $request->quantity) {
                    // Si le stock du nouveau téléphone est insuffisant, on annule toute la transaction.
                    throw new \Exception('Stock insuffisant pour le nouveau téléphone sélectionné.');
                }
                // On décrémente le stock du nouveau téléphone avec la nouvelle quantité.
                $newTelephone->decrement('stock', $request->quantity);

                $totalPrice = $newTelephone->price * $request->quantity;

                // Étape 3: Mettre à jour la vente avec les nouvelles informations.
                $vente->update([
                    'telephone_id' => $request->telephone_id,
                    'client_id' => $request->client_id,
                    'vendeur_id' => $request->vendeur_id,
                    'quantity' => $request->quantity,
                    'price' => $totalPrice,
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['transaction' => $e->getMessage()])->withInput();
        }

        return redirect()->route('ventes.index')->with('success', 'Vente mise à jour avec succès.');
    }

    /**
     * Supprime une vente de la base de données.
     * Restaure le stock du téléphone qui avait été vendu.
     *
     * @param  \App\Models\Vente  $vente
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Vente $vente)
    {
        try {
            DB::transaction(function () use ($vente) {
                // On restaure le stock en ré-incrémentant la quantité de la vente annulée.
                $vente->telephone->increment('stock', $vente->quantity);
                
                // On supprime la vente.
                $vente->delete();
            });
        } catch (\Exception $e) {
            return redirect()->route('ventes.index')->withErrors(['transaction' => 'Erreur lors de la suppression de la vente.']);
        }

        return redirect()->route('ventes.index')->with('success', 'Vente supprimée avec succès.');
    }
}
