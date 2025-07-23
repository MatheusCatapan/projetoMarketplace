<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

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
        $user = $this->authenticateUser();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->withHeaders($user)->postJson('/api/product', [
            'id' => $product->id,
            'name' => $product->name,
            'stock' => $product->stock,
            'price' => $product->price,
            'image' => $product->image,
            'category_id' => $product->category_id,

        ]);
        $response->assertCreated();
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'stock' => $product->stock,
            'price' => $product->price,
            'category_id' => $product->category_id,
        ]);
    }

}
