<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class EnderecosTest extends TestCase
{
    use RefreshDatabase;

    public function authenticateUser()
    {
        $user = User::factory()->create([
            'role' => 'USER',
        ]);

        $token = $user->createToken('TestToken')->plainTextToken;

        return ['Authorization' => 'Bearer ' . $token, 'user' => $user];
    }

    public function test_mostrar_endereco()
    {
        // Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        // Criar o endereço
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'street' => 'Rua Teste',
            'city' => 'Cidade Teste',
            'state' => 'Estado Teste',
            'zip' => '12345-678',
        ]);

        // Mostrar o endereço
        $response = $this->actingAs($user)->getJson('/api/address/' . $address->id);

        // AssertStatus de 200 para verificar se o endereço foi mostrado com sucesso
        $response->assertStatus(200);
    }
}
