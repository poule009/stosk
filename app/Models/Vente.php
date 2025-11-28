<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Vente.
 * Représente une seule transaction de vente dans la base de données.
 * Ce modèle est au cœur de l'application, liant les téléphones, les clients et les vendeurs.
 */
class Vente extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     * C'est une mesure de sécurité pour empêcher que des champs non désirés soient modifiés.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'telephone_id', 'client_id', 'vendeur_id', 'quantity', 'price', 'sale_date'
    ];

    /**
     * Définit la relation "belongsTo" (appartient à) avec le modèle Telephone.
     * Chaque vente est associée à un seul téléphone.
     */
    public function telephone()
    {
        return $this->belongsTo(Telephone::class);
    }

    /**
     * Définit la relation "belongsTo" avec le modèle Client.
     * Chaque vente est effectuée pour un seul client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Définit la relation "belongsTo" avec le modèle Vendeur.
     * Chaque vente est réalisée par un seul vendeur.
     */
    public function vendeur()
    {
        return $this->belongsTo(Vendeur::class);
    }

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'ventes';
}
