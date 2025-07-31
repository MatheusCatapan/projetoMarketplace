<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Coupon;


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

    public function test_listar_cupons()
    {
        //Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        //Listar cupons
        $response = $this->actingAs($user)->getJson('/api/coupons');

        //AssertStatus de 200 para verificar se os cupons foram listados com sucesso
        $response->assertStatus(200);
    }

    public function test_deletar_cupom()
    {
        //Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        //Criar cupom
        $cupom = Coupon::factory()->create();

        //Deletar cupom
        $response = $this->actingAs($user)->deleteJson('/api/coupons/' . $cupom->coupon_code);

        //AssertStatus de 200 para verificar se o cupom foi deletado com sucesso
        $response->assertStatus(200);
    }
}
