<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;



class CarrinhoTest extends TestCase
{
    use RefreshDatabase;

    public function test_adicionar_produto_ao_carrinho()
    {
        // Cria usuário e produto no banco de dados
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Sanctum::actingAs($user);

        // Quantidade a adicionar
        $quantity = 3;

        // Faz a requisição autenticada ao endpoint que chama o método adicionarProduto
        $response = $this->actingAs($user)->postJson('/api/carrinho/adicionar', [
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        // Verifica status 200 e mensagem correta
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Produto adicionado ao carrinho com sucesso']);

        // Verifica no banco se o item foi criado corretamente
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);
    }

    public function test_deletar_produto_do_carrinho()
    {
        //Cria usuário e produto no banco de dados
        $user = User::factory()->create();
        $product = Product::factory()->create();
        //Autentica o usuário
        Sanctum::actingAs($user);
        //Adiciona o produto ao carrinho
        $response = $this->actingAs($user)->postJson('/api/carrinho/adicionar', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        //Verifica se o produto foi adicionado com sucesso
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Produto adicionado ao carrinho com sucesso']);
        //Faz a requisição para deletar o produto do carrinho
        $response = $this->actingAs($user)->deleteJson('/api/carrinho/remover', [
            'product_id' => $product->id,
        ]);
        //Verifica se o produto foi removido com sucesso
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Produto removido do carrinho com sucesso']);
    }

    public function test_mostrar_carrinho()
    {
        //Cria usuário e produto no banco de dados
        $user = User::factory()->create();
        $product = Product::factory()->create();
        //Autentica o usuário
        Sanctum::actingAs($user);
        //Adiciona o produto ao carrinho
        $this->actingAs($user)->postJson('/api/carrinho/adicionar', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        //Faz a requisição para mostrar o carrinho
        $response = $this->actingAs($user)->getJson('/api/carrinho');
        //Verifica se o carrinho foi mostrado com sucesso
        $response->assertStatus(200);
    }

    public function test_limpar_carrinho()
    {
        //Cria usuário e produto no banco de dados
        $user = User::factory()->create();
        $product = Product::factory()->create();
        //Autentica o usuário
        Sanctum::actingAs($user);
        //Adiciona o produto ao carrinho
        $this->actingAs($user)->postJson('/api/carrinho/adicionar', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        //Faz a requisição para limpar o carrinho
        $response = $this->actingAs($user)->deleteJson('/api/carrinho/limpar');
        //Verifica se o carrinho foi limpo com sucesso
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Carrinho limpo com sucesso']);
    }
}
