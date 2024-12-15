<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sayur Buah',
                'slug' => 'sayur-buah',
                'image' => 'https://ik.imagekit.io/dcjlghyytp1/0148577621efbe55ec252e73046c6ca7?tr=f-auto,w-360',
            ],
            [
                'name' => 'Sayur Daun',
                'slug' => 'sayur-daun',
                'image' => 'https://ik.imagekit.io/dcjlghyytp1/13a39fbcc08464e2373292518df3cda5?tr=f-auto,w-1000',
            ],
            [
                'name' => 'Buah',
                'slug' => 'buah',
                'image' => 'https://ik.imagekit.io/dcjlghyytp1/b35e86d14c5addd0d17bf4a0e7959da7?tr=f-auto,w-1000',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}