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

    public function test_retornar_usuario_autentiado()
    {
        $auth = $this->authenticateUser();
        $headers = ['Authorization' => $auth['Authorization']];

        $response = $this->withHeaders($headers)->getJson('/api/user');

        $response->assertOk()
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'role',
            ]);
    }

    public function test_atualizar_usuario()
    {
        $auth = $this->authenticateUser();
        $headers = ['Authorization' => $auth['Authorization']];
        $user = $auth['user'];

        $response = $this->withHeaders($headers)->putJson('/api/user/' . $user->id, [
            'name' => 'Novo Nome',
            'email' => 'novo@email.com'
        ]);
        $response->assertJson([
            'message' => 'Usuário atualizado com sucesso',
            'user' => [
                'id' => $user->id,
                'name' => 'Novo Nome',
                'email' => 'novo@email.com',
        ],
        ]);
        $response->assertStatus(200);
    }

    public function test_deletar_usuario()
    {
        $auth = $this->authenticateUser();
        $headers = ['Authorization' => $auth['Authorization']];
        $user = $auth['user'];

        $response = $this->withHeaders($headers)->deleteJson('/api/user/' . $user->id);

        $response->assertStatus(204);
    }

    public function test_criar_moderadores()
    {
        $auth = $this->authenticateUser();
        $headers = ['Authorization' => $auth['Authorization']];

        $response = $this->withHeaders($headers)->postJson('/api/user', [
            'name' => 'Moderador Teste',
            'email' => 'mod@email.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
            'role' => 'MODERADOR',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);
    }
}
