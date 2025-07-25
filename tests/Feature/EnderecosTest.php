<?php

// namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Tests\TestCase;
// use App\Models\User;

// class EnderecosTest extends TestCase
// {
//     use RefreshDatabase;

//     public function test_controle_de_enderecos()
//     {
//         $user = User::factory()->create();
//         $this->actingAs($user, 'sanctum');

//         $response = $this->postJson('/api/addresses', [
//             'street' => 'Rua Exemplo',
//             'city' => 'Cidade Exemplo',
//             'state' => 'Estado Exemplo',
//             'zip' => '12345-678'
//         ]);
//         $response->assertStatus(201)
//             ->assertJsonStructure([
//                 'street',
//                 'city',
//                 'state',
//                 'zip',
//             ]);
//     }


// }
