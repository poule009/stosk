<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vendeur
 *
 * Représente un vendeur dans le système.
 * Les vendeurs peuvent être associés à des ventes pour la traçabilité.
 */
class Vendeur extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * Les ventes associées à ce vendeur.
     * Un vendeur peut avoir plusieurs ventes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }
}
