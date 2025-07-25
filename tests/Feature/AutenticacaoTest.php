<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AutenticacaoTest extends TestCase
{
    use RefreshDatabase;


    public function test_registro_funcionando()
    {
        $response = $this->postJson('api/register', [
            'name' => 'Teste',
            'email' => 'matheus@teste.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
        ]);
        $response->assertCreated();
    }


    public function test_login_funcionando()
    {
        $user = User::factory()->create([
            'password' => bcrypt('senha123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'senha123'
        ]);

        $response->assertOk();
    }
}

