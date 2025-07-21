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
            'role' => 'MODERADOR',
        ]);

        $token = $user->createToken('TestToken')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token, 'user' => $user];

    }

    public function test_criar_produto()
    {
        $auth = $this->authenticateUser();
        $user = $auth['user'];
        $response = $this->actingAs($user)->postJson('/api/products', [
            'name' => 'Produto Teste',
            'price' => 100.00,
            'description' => 'Descrição do produto teste',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'name' => 'Produto Teste',
        ]);
    }
}
