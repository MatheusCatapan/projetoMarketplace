<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class CouponsTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function authenticateUser()
    {
        $user = User::factory()->create([
            'role' => 'ADMIN',
        ]);

        $token = $user->createToken('TestToken')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token, 'user' => $user];

    }

    //Testes de Cupons de desconto

    public function test_criar_cupom()
    {
        //Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        //Criar cupom
        $response = $this->actingAs($user)->postJson('/api/coupons', [
            'codigo' => 'DESCONTO10',
            'discount' => 10.00,
            'expires_at' => now()->addDays(30)->toDateString(),
        ]);

        //AssertStatus de 201 para verificar se o cupom foi criado com sucesso
        $response->assertStatus(201);
    }
}
