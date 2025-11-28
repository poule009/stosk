<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crée la table 'vendeurs'
        Schema::create('vendeurs', function (Blueprint $table) {
            $table->id(); // Colonne d'identifiant auto-incrémentée (clé primaire)
            $table->string('name'); // Nom du vendeur
            $table->string('email')->unique()->nullable(); // Adresse email unique et optionnelle
            $table->string('phone')->nullable(); // Numéro de téléphone optionnel
            $table->timestamps(); // Colonnes `created_at` et `updated_at` pour l'horodatage
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprime la table 'vendeurs' si la migration est annulée
        Schema::dropIfExists('vendeurs');
    }
};
