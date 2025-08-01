<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;

//Um carrinho por usuario, adicionar produtos, remover produtos, finalizar compra, limpar carrinho.

class CarrinhoTest extends TestCase
{
    use RefreshDatabase;

    public function authenticateUser()
    {
        $user = User::factory()->create([
            'role' => 'CLIENT',
        ]);

        $token = $user->createToken('TestToken')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token, 'user' => $user];
    }

    public function test_adicionar_produto_ao_carrinho()
    {
        $auth = $this->authenticateUser();
        Sanctum::actingAs($auth['user']);

        //Cria a categoria do produto
        $categoria = Category::factory()->create(['id' => 1]);

        //Cria o produto com a categoria
        $product = Product::factory()->create([
            'category_id' => $categoria->id,
            'name' => 'Smartphone Galaxy S21',
            'description' => 'Smartphone Samsung com tela AMOLED de 6.2',
            'stock' => 50,
            'price' => 3499.99,
        ]);

        $response = $this->actingAs($auth['user'])->postJson('/carrinho/adicionar', [
            'product_id' => 1,
            'quantity' => 2,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Produto adicionado ao carrinho com sucesso']);
    }
}
