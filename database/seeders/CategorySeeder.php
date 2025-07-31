<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Eletrônicos',
                'description' => 'Produtos eletrônicos como celulares, televisores e computadores.',
            ],
            [
                'name' => 'Roupas',
                'description' => 'Vestuário masculino, feminino e infantil.',
            ],
            [
                'name' => 'Livros',
                'description' => 'Livros de diversos gêneros e autores.',
            ],
            [
                'name' => 'Alimentos',
                'description' => 'Produtos alimentícios e bebidas.',
            ],
            [
                'name' => 'Móveis',
                'description' => 'Móveis para casa e escritório, incluindo sofás, mesas e cadeiras.',
            ],
            [
                'name' => 'Cosméticos',
                'description' => 'Produtos de beleza e cuidados pessoais, como cosméticos e perfumes.',
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
