<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
            'image' => 'https://filemanager.layananberhentikuliah.com/storage/files/3QRbmUXtT8qvsBjD1ctUYFQT3H2iCzK1xKUVSv32.png',
            'is_active' => true,
        ]);
    }
}
