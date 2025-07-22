<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

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

        $product = Product::factory()->create();

        $auth = $this->authenticateUser();
        $user = $auth['user'];
        $response = $this->actingAs($user)->postJson('/api/product', [
            'id' => $product->id,
            'name' => 'Produto Teste',
            'price' => 100.00,
            'description' => 'Descrição do produto teste',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'price',
                'description',
                'created_at',
                'updated_at',
            ]);
    }
}
