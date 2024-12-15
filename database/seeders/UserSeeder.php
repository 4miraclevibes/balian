<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role_id' => 1],
            ['name' => 'User', 'email' => 'user@example.com', 'password' => Hash::make('password'), 'role_id' => 2],
            ['name' => 'Driver', 'email' => 'driver@example.com', 'password' => Hash::make('password'), 'role_id' => 3],
        ];

        User::insert($users);

        $userAddresses = [
            ['user_id' => 2,
                'sub_district_id' => 2,
                'address' => 'Jl. Sudirman',
                'latitude' => '-6.21462',
                'longitude' => '106.84513',
                'type' => 'home',
                'receiver_name' => 'John Doe',
                'receiver_phone' => '081234567890',
                'status' => 'active'
            ],
        ];

        UserAddress::insert($userAddresses);
    }
}
