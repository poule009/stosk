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
        // Crée la table 'clients'
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Colonne d'identifiant auto-incrémentée (clé primaire)
            $table->string('name'); // Nom du client
            $table->string('email')->unique()->nullable(); // Adresse email unique et optionnelle
            $table->string('phone')->nullable(); // Numéro de téléphone optionnel
            $table->string('address')->nullable(); // Adresse du client optionnelle
            $table->timestamps(); // Colonnes `created_at` et `updated_at` pour l'horodatage
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprime la table 'clients' si la migration est annulée
        Schema::dropIfExists('clients');
    }
};
