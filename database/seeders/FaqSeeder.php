<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;
class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa itu Early Access?',
                'answer' => 'Early Access adalah fitur yang memungkinkan pengguna untuk mengakses aplikasi sebelum rilis resmi.'
            ],
            [
                'question' => 'Bagaimana cara menggunakan Early Access?',
                'answer' => 'Untuk menggunakan Early Access, pengguna harus menginstal aplikasi dari Play Store dan mengaktifkan fitur Early Access.'
            ],
            [
                'question' => 'Apa yang dapat saya lakukan dengan Early Access?',
                'answer' => 'Early Access memungkinkan pengguna untuk mengakses aplikasi sebelum rilis resmi dan memberikan umpan balik langsung kepada pengembang.'
            ],
            [
                'question' => 'Apakah Early Access gratis?',
                'answer' => 'Ya, Early Access gratis untuk semua pengguna.'
            ],
            [
                'question' => 'Bagaimana cara menghubungi pengembang?',
                'answer' => 'Pengguna dapat menghubungi pengembang melalui halaman kontak di aplikasi.'
            ],
            [
                'question' => 'Apakah Early Access aman?',
                'answer' => 'Ya, Early Access aman dan terpercaya. Pengguna dapat menginstal aplikasi dari Play Store dengan aman.'
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
