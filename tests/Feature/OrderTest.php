<?php

namespace Tests\Feature;


use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{

    use RefreshDatabase;

    public function authenticateUser()
    {
        $user = User::factory()->create();

        $token = $user->createToken('TestToken')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token, 'user' => $user];
    }

    public function test_criar_pedido()
    {
        //autentica o usuario pois só é possível criar um pedido autenticado
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        $address = Address::factory()->create([
            'user_id' =>$user->id
        ]);
        $product = Product::factory()->create([
            'price' => 199.00
        ]);
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);

        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        //Envia as requisições do que o OrderController quer
        $response = $this->actingAs($user)->postJson('/api/pedido/criar', [
            'address_id' => $address->id,
            'coupon' => 'TESTCOUPON'
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'message',
                    'order_id'
                ]);
    }

    public function test_cancelar_pedido_criado()
    {
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        $address = Address::factory()->create([
                'user_id' => $user->id
            ]);
        $product = Product::factory()->create([
                'price' => 199.00
            ]);
        $cart = Cart::factory()->create([
                    'user_id' => $user->id
                ]);
        $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 2
            ]);
        $response = $this->actingAs($user)->postJson('/api/pedido/criar', [
            'address_id' => $address->id
        ]);
        $orderId = $response->json('order_id');
        $response = $this->actingAs($user)->putJson('/api/pedido/cancelar/' . $orderId);
        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Pedido cancelado com sucesso'
                ]);
    }

    public function test_atualizar_status_pedido()
    {
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        // Cria um moderador
        $moderator = User::factory()->create(['role' => 'MODERADOR']);

        $address = Address::factory()->create([
            'user_id' => $user->id
        ]);
        $product = Product::factory()->create([
            'price' => 199.00
        ]);
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        // Cria o pedido
        $response = $this->actingAs($user)->postJson('/api/pedido/criar', [
            'address_id' => $address->id
        ]);
        $orderId = $response->json('order_id');

        // Atualiza o status do pedido como moderador
        $response = $this->actingAs($moderator)->putJson('/api/pedido/atualizar-status/' . $orderId, [
            'status' => 'COMPLETED'
        ]);

        $response->assertStatus(200)
                ->assertJson(['message' => 'Status do pedido atualizado com sucesso']);
    }
}
