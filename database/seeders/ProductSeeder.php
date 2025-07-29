<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 10; $i++) {
            DB::table('products')->insert([
                'category_id' => $faker->numberBetween(1, 5),
                'name' => $faker->words(3, true),
                'description' => $faker->sentence(),
                'stock' => $faker->numberBetween(0, 100),
                'price' => $faker->randomFloat(2, 5, 500),
                'image' => $faker->imageUrl(640, 480, 'products', true),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

