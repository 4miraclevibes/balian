<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\District;
use App\Models\SubDistrict;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [
                'name' => 'Cipondoh',
                'sub_districts' => ['Cipondoh Makmur', 'Cipondoh Indah', 'Poris Plawad', 'Poris Plawad Indah']
            ],
            [
                'name' => 'Karawaci',
                'sub_districts' => ['Karawaci Baru', 'Karawaci Lama', 'Nusa Jaya', 'Cimone']
            ],
            [
                'name' => 'Ciledug',
                'sub_districts' => ['Ciledug Indah', 'Paninggilan', 'Sudimara Barat', 'Sudimara Timur']
            ],
            [
                'name' => 'Batuceper',
                'sub_districts' => ['Batuceper', 'Poris Gaga', 'Poris Gaga Baru']
            ],
            [
                'name' => 'Benda',
                'sub_districts' => ['Benda', 'Belendung', 'Jurumudi']
            ],
            [
                'name' => 'Cibodas',
                'sub_districts' => ['Cibodas Baru', 'Cibodas Sari', 'Jatiuwung', 'Panunggangan Barat']
            ],
            [
                'name' => 'Jatiuwung',
                'sub_districts' => ['Jatake', 'Keroncong', 'Manis Jaya', 'Pasir Jaya']
            ],
            [
                'name' => 'Periuk',
                'sub_districts' => ['Gebang Raya', 'Gembor', 'Periuk', 'Periuk Jaya']
            ],
            [
                'name' => 'Pinang',
                'sub_districts' => ['Kunciran', 'Kunciran Indah', 'Nerogtog', 'Pinang']
            ],
            [
                'name' => 'Tangerang',
                'sub_districts' => ['Babakan', 'Cikokol', 'Kelapa Indah', 'Sukaasih', 'Sukasari', 'Tanah Tinggi']
            ],
            [
                'name' => 'Karang Tengah',
                'sub_districts' => ['Karang Mulya', 'Karang Tengah', 'Karang Timur', 'Parung Jaya']
            ],
            [
                'name' => 'Neglasari',
                'sub_districts' => ['Karangsari', 'Kedaung Baru', 'Kedaung Wetan', 'Mekarsari', 'Neglasari']
            ],
            [
                'name' => 'Larangan',
                'sub_districts' => ['Cipadu', 'Cipadu Jaya', 'Gaga', 'Larangan Indah', 'Larangan Selatan', 'Larangan Utara']
            ],
            // Tambahkan distrik dan sub-distrik lainnya sesuai kebutuhan
        ];

        foreach ($districts as $districtData) {
            $district = District::firstOrCreate(['name' => $districtData['name']]);

            foreach ($districtData['sub_districts'] as $subDistrictName) {
                SubDistrict::firstOrCreate([
                    'name' => $subDistrictName,
                    'district_id' => $district->id,
                    'fee' => $this->getRandomFee(), // Anda bisa mengubah ini sesuai kebutuhan
                    'description' => 'Kurang dari 5 km', // Anda bisa mengubah ini sesuai kebutuhan
                    'status' => 'active', // Anda bisa mengubah ini sesuai kebutuhan
                ]);
            }
        }
    }
    private function getRandomFee()
    {
        $fees = [6000, 7000, 8000, 9000, 10000];
        return $fees[array_rand($fees)];
    }
}
