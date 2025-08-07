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
            'address_id' => $address->id
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'message',
                    'order_id'
                ]);
    }
}
