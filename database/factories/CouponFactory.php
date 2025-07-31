<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coupon_code' => $this->faker->unique()->word,
            'startDate' => $this->faker->date(),
            'endDate' => $this->faker->date(),
            'discount' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
