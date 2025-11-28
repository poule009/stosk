<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Telephone;
use App\Models\Client;
use App\Models\Vendeur;
use App\Models\Vente;

class VenteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_calculates_the_total_price_when_creating_a_new_vente()
    {
        $telephone = Telephone::factory()->create(['price' => 100, 'stock' => 10]);
        $client = Client::factory()->create();
        $vendeur = Vendeur::factory()->create();

        $response = $this->post(route('ventes.store'), [
            'telephone_id' => $telephone->id,
            'client_id' => $client->id,
            'vendeur_id' => $vendeur->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect(route('ventes.index'));
        $this->assertDatabaseHas('ventes', [
            'telephone_id' => $telephone->id,
            'quantity' => 2,
            'price' => 200, // 2 * 100
        ]);

        $this->assertDatabaseHas('telephones', [
            'id' => $telephone->id,
            'stock' => 8, // 10 - 2
        ]);
    }

    /** @test */
    public function it_recalculates_the_total_price_when_updating_a_vente()
    {
        $telephone1 = Telephone::factory()->create(['price' => 100, 'stock' => 10]);
        $telephone2 = Telephone::factory()->create(['price' => 200, 'stock' => 5]);
        $client = Client::factory()->create();
        $vendeur = Vendeur::factory()->create();
        $vente = Vente::factory()->create([
            'telephone_id' => $telephone1->id,
            'client_id' => $client->id,
            'vendeur_id' => $vendeur->id,
            'quantity' => 2,
            'price' => 200,
        ]);
        $telephone1->decrement('stock', 2); // initial stock is 8

        $response = $this->put(route('ventes.update', $vente), [
            'telephone_id' => $telephone2->id,
            'client_id' => $client->id,
            'vendeur_id' => $vendeur->id,
            'quantity' => 3,
        ]);

        $response->assertRedirect(route('ventes.index'));
        $this->assertDatabaseHas('ventes', [
            'id' => $vente->id,
            'telephone_id' => $telephone2->id,
            'quantity' => 3,
            'price' => 600, // 3 * 200
        ]);

        $this->assertDatabaseHas('telephones', [
            'id' => $telephone1->id,
            'stock' => 10, // stock restored
        ]);

        $this->assertDatabaseHas('telephones', [
            'id' => $telephone2->id,
            'stock' => 2, // 5 - 3
        ]);
    }
}
