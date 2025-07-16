<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class EnderecosTest extends TestCase
{
    use RefreshDatabase;

    public function test_controle_de_address_armezenamento()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/addresses', [
            'street' => 'Rua Exemplo',
            'city' => 'Cidade Exemplo',
            'state' => 'Estado Exemplo',
            'zip' => '12345-678'
        ]);
        $response->assertOk()
            ->assertJsonStructure([
                'street',
                'city',
                'state',
                'zip',
            ])
            ->json();
        return $response;
    }


}
