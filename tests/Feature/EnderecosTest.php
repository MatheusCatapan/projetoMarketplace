<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Address;


class EnderecosTest extends TestCase
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
        $response = $this->actingAs($user)->getJson('/api/address');

        // AssertStatus de 200 para verificar se o endereço foi mostrado com sucesso
        $response->assertStatus(200);
    }

    public function test_criar_endereco()
    {
        // Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        // Dados do endereço
        $data = [
            'street' => 'Rua Teste',
            'city' => 'Cidade Teste',
            'state' => 'Estado Teste',
            'zip' => '12345-678',
        ];

        // Criar o endereço
        $response = $this->actingAs($user)->postJson('/api/address', $data);

        // AssertStatus de 201 para verificar se o endereço foi criado com sucesso
        $response->assertStatus(201);
    }

    public function test_atualizar_endereco()
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

        // Dados atualizados do endereço
        $data = [
            'street' => 'Rua Atualizada',
            'city' => 'Cidade Atualizada',
            'state' => 'Estado Atualizado',
            'zip' => '87654-321',
        ];

        // Atualizar o endereço
        $response = $this->actingAs($user)->putJson('/api/address/' . $user->id);

        // AssertStatus de 200 para verificar se o endereço foi atualizado com sucesso
        $response->assertStatus(200);
    }

}
