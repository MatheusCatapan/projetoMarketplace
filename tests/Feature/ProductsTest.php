<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Categories;

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
        $headers = ['Authorization' => $auth['Authorization']];

        $category = Categories::factory()->create();

        $productData = [
            'name' => 'Produto Teste',
            'stock' => 15,
            'price' => 99.99,
            'image' => 'https://via.placeholder.com/640x480.png',
            'category_id' => $category->id,
        ];

        $response = $this->withHeaders($headers)->postJson('/api/product', $productData);

        $response->assertCreated();

        $this->assertDatabaseHas('products', [
            'name' => 'Produto Teste',
            'stock' => 15,
            'price' => 99.99,
            'category_id' => $category->id,
        ]);
    }
}
