<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Garante que existam categorias
        if (Category::count() === 0) {
            $this->command->warn('Nenhuma categoria encontrada. Execute o CategorySeeder primeiro.');
            return;
        }

        $products = [
            [
                'name' => 'Smartphone Galaxy S21',
                'description' => 'Smartphone Samsung com tela AMOLED de 6.2", 128GB.',
                'stock' => 50,
                'price' => 3499.99,
                'image' => 's21.jpg',
                'category_name' => 'Eletrônicos',
            ],
            [
                'name' => 'Camiseta Básica Branca',
                'description' => 'Camiseta de algodão, confortável e leve.',
                'stock' => 100,
                'price' => 29.90,
                'image' => 'camiseta.jpg',
                'category_name' => 'Roupas',
            ],
            [
                'name' => 'Livro - Dom Casmurro',
                'description' => 'Obra clássica de Machado de Assis.',
                'stock' => 30,
                'price' => 39.90,
                'image' => 'domcasmurro.jpg',
                'category_name' => 'Livros',
            ],
            [
                'name' => 'Cadeira de Escritório Ergonomica',
                'description' => 'Cadeira com ajuste de altura e apoio lombar.',
                'stock' => 20,
                'price' => 499.90,
                'image' => 'cadeira.jpg',
                'category_name' => 'Móveis',
            ],
            [
                'name' => 'Perfume Dior Sauvage',
                'description' => 'Perfume masculino, fragrância fresca e amadeirada.',
                'stock' => 15,
                'price' => 399.90,
                'image' => 'dior.jpg',
                'category_name' => 'Cosméticos',
            ],
        ];

        foreach ($products as $data) {
            $category = Category::where('name', $data['category_name'])->first();

            if ($category) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'stock' => $data['stock'],
                    'price' => $data['price'],
                    'image' => $data['image'],
                ]);
            }
        }
    }
}
