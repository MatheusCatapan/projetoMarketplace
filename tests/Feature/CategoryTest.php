<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;


class CategoryTest extends TestCase
{
    //CRUD de categorias
    use RefreshDatabase, WithFaker;

    //Usuário deve ser ADMIN para criar categorias
    public function authenticateUser()
    {
        $user = User::factory()->create([
            'role' => 'ADMIN',
        ]);

        $token = $user->createToken('TestToken')->plainTextToken;

        return ['Authorization' => 'Bearer ' . $token, 'user' => $user];
    }

    public function test_criar_categoria()
    {
        // Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        // Dados da categoria
        $data = [
            'name' => 'Categoria Teste',
            'description' => 'Descrição da Categoria Teste',
        ];

        // Criar a categoria
        $response = $this->actingAs($user)->postJson('/api/categories', $data);

        // AssertStatus de 201 para verificar se a categoria foi criada com sucesso
        $response->assertStatus(201);
    }

    public function test_deletar_categoria()
    {
        // Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        // Criar a categoria
        $category = Category::factory()->create();

        // Deletar a categoria
        $response = $this->actingAs($user)->deleteJson('/api/categories/' . $category->id);

        // AssertStatus de 204 para verificar se a categoria foi deletada com sucesso
        $response->assertStatus(204);
    }

    public function test_atualizar_categoria()
    {
        // Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        // Criar a categoria
        $category = Category::factory()->create();

        // Dados atualizados da categoria
        $data = [
            'name' => 'Categoria Atualizada',
            'description' => 'Descrição Atualizada',
        ];

        // Atualizar a categoria
        $response = $this->actingAs($user)->putJson('/api/categories/' . $category->id, $data);

        // AssertStatus de 200 para verificar se a categoria foi atualizada com sucesso
        $response->assertStatus(200);
    }

    public function test_listar_categorias()
    {
        // Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];

        // Listar categorias
        $response = $this->actingAs($user)->getJson('/api/categories');

        // AssertStatus de 200 para verificar se as categorias foram listadas com sucesso
        $response->assertStatus(200);
    }

}
