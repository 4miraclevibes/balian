<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShippingMethod;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingMethods = [
            [
                'name' => 'Regular',
                'cost' => 0,
                'description' => '8 - 10 jam',
            ],
            [
                'name' => 'Express',
                'cost' => 5000,
                'description' => '4 - 6 jam',
            ],
            [
                'name' => 'Instan',
                'cost' => 10000,
                'description' => '2 - 3 jam',
            ],
        ];

        foreach ($shippingMethods as $method) {
            ShippingMethod::create($method);
        }
    }
}
