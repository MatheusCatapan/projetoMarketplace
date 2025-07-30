<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $table = 'user_addresses';

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'street' => $this->faker->streetAddress,
            'number' => $this->faker->numberBetween(1, 1000),
            'zip' => $this->faker->postcode,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
        ];
    }
}
