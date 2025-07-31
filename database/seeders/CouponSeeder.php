<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;


class CouponSeeder extends Seeder
{
    public function run(): void
    {
        // Exemplo de cupons
        $cupons = [
            [
                'coupon_code' => 'DESCONTO10',
                'startDate' => now(),
                'endDate' => now()->addDays(30),
                'discount' => 10.00,
            ],
            [
                'coupon_code' => 'FRETEGRATIS',
                'startDate' => now(),
                'endDate' => now()->addDays(15),
                'discount' => 5.00,
            ],
            [
                'coupon_code' => 'BOASVINDAS20',
                'startDate' => now()->subDays(5),
                'endDate' => now()->addDays(10),
                'discount' => 20.00,
            ],
        ];

        foreach ($cupons as $cupom) {
            Coupon::create($cupom);
        }
    }
}
