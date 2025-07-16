<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_retorno_de_usuario_logado()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/user');

        $response->assertOk()
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }

    // public function test_atualizacao_de_usuario()
    // {
    //     $user = User::factory()->create();

    //     $data = [
    //         'name' => 'teste',
    //         'email' => 'teste@email.com',
    //         'password' => '123456',
    //     ];

    //     if (isset($data['password'])) {
    //         $data['password'] = bcrypt($data['password']);
    //     }

    // public function test_excluir_usuario()
    // {
    //     $user = User::factory()->create();

    //     $response = $this->actingAs($user)->deleteJson('/api/user');

    //     $response->assertOk();
    //     $this->assertDatabaseMissing('users', [
    //         'id' => $user->id,
    //     ]);
    // }
}
