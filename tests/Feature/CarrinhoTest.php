<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;


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
        $user = $auth['user'];
        $product = Product::factory()->create([
            'id' => '1',
            'stock' => '10'
        ]);

        $response = $this->actingAs($user)->postJson('/carrinho/adicionar', [
            'product_id' => 1,
            'quantity' => 2,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Produto adicionado ao carrinho com sucesso']);
    }
}
