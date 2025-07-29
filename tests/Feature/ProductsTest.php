<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use App\Models\Product;


class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function authenticateUser()
    {
        $user = User::factory()->create([
            'role' => 'MODERADOR',
        ]);

        $token = $user->createToken('TestToken')->plainTextToken;

        return ['Authorization' => 'Bearer ' . $token, 'user' => $user];
    }

    public function test_criar_produto()
    {
        //Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];
        //Criar a categoria do produto
        $category = Category::factory()->create();
        //Criar o produto
        $response = $this->actingAs($user)->postJson('/api/product', [
            'name' => 'Produto Teste',
            'stock' => 10,
            'price' => 99.99,
            'image' => UploadedFile::fake()->image('product.jpg'),
            'category_id' => $category->id,
        ]);
        //AssertStatus de 201 para verificar se o produto foi criado com sucesso
        $response->assertStatus(201);
    }

    public function test_atualizar_produto()
    {
        //Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];
        //Criar a categoria do produto
        $category = Category::factory()->create();
        //Criar o produto
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Produto Teste',
            'stock' => 10,
            'price' => 99.99,
        ]);
        //Atualizar o produto
        $response = $this->actingAs($user)->putJson('/api/product/' . $product->id, [
            'name' => 'Produto Atualizado',
            'stock' => 20,
            'price' => 89.99,
            'image' => UploadedFile::fake()->image('updated_product.jpg'),
        ]);
        //AssertStatus de 200 para verificar se o produto foi atualizado com sucesso
        $response->assertStatus(200);
    }

    public function test_deletar_produto()
    {
        //Autenticar usuário
        $auth = $this->authenticateUser();
        $user = $auth['user'];
        //Criar a categoria do produto
        $category = Category::factory()->create();
        //Criar o produto
        $product = Product::factory()->create([
            'id' => 1,
            'category_id' => $category->id,
            'name' => 'Produto Teste',
            'stock' => 10,
            'price' => 99.99,
        ]);
        //Deletar o produto
        $response = $this->actingAs($user)->deleteJson('/api/product/' . $product->id);
        //AssertStatus de 204 para verificar se o produto foi deletado com sucesso
        $response->assertStatus(204);
    }

}
