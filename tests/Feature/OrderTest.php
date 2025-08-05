<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;

class OrderTest extends TestCase
{
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
        $user = auth['user'];



        //Envia as requisições do que o OrderController quer
        $response = $this->actingAs($user)->postJson('/pedido/criar');

    }
}
