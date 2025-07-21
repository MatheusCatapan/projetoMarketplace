<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;


class UserTest extends TestCase
{
    use RefreshDatabase;

    public function authenticateUser()
    {
        $user = User::factory()->create([
            'role' => 'ADMIN',
        ]);

        $token = $user->createToken('TestToken')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token, 'user' => $user];

    }

    public function test_retorno_de_usuario_logado()
    {
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        $response = $this->actingAs($user)->getJson('/api/user');

        $response->assertOk()
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }

    public function test_deletar_usuario_logado()
    {
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        $response = $this->actingAs($user)->deleteJson('/api/user');
        $response->assertOk();
    }

}
