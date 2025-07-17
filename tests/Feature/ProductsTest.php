<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function authenticateUser()
    {
        $user = User::factory()->create([
            'role' => 'MODERATOR',
        ]);

        $token = $user->createToken('TestToken')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token, 'user' => $user];
    }

    public function test_crud_de_produtos()
    {
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        $response = $this->actingAs($user)->postJson('/api/products', [
            'name' => 'Produto Teste',
            'price' => 100.00,
            'description' => 'Descrição do produto teste',
        ]);

        $response->assertCreated()
            ->assertJson(['name' => 'Produto Teste']);

        $productId = $response->json('id');
        $response = $this->actingAs($user)->getJson("/api/products/{$productId}");
        $response->assertOk()
            ->assertJson(['name' => 'Produto Teste']);

        $response = $this->actingAs($user)->putJson("/api/products/{$productId}", [
            'name' => 'Produto Teste Atualizado',
            'price' => 120.00,
            'description' => 'Descrição atualizada do produto teste',
        ]);
        $response->assertOk()
            ->assertJson(['name' => 'Produto Teste Atualizado']);

        $response = $this->actingAs($user)->deleteJson("/api/products/{$productId}");
        $response->assertNoContent();
    }
}
