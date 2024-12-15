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
                'name' => 'Bungus Teluk Kabung',
                'sub_districts' => ['Bungus Barat', 'Bungus Selatan', 'Bungus Timur', 'Teluk Kabung Selatan', 'Teluk Kabung Tengah', 'Teluk Kabung Utara']
            ],
            [
                'name' => 'Koto Tangah',
                'sub_districts' => ['Balai Gadang', 'Batang Kabung Ganting', 'Bungo Pasang', 'Dadok Tunggul Hitam', 'Koto Panjang Ikua Koto', 'Lubuk Buaya', 'Padang Sarai', 'Parupuk Tabing']
            ],
            [
                'name' => 'Kuranji',
                'sub_districts' => ['Anduring', 'Gunung Sarik', 'Kalumbuk', 'Korong Gadang', 'Kuranji', 'Lubuk Lintah', 'Pasar Ambacang', 'Sungai Sapih', 'Ampang']
            ],
            [
                'name' => 'Lubuk Begalung',
                'sub_districts' => ['Batuang Taba Nan XX', 'Batu Gadang', 'Cengkeh Nan XX', 'Gurun Laweh Nan XX', 'Kampung Baru Nan XX', 'Koto Baru Nan XX', 'Lubuk Begalung Nan XX', 'Pampangan Nan XX', 'Parak Laweh Pulau Aie Nan XX', 'Pegambiran Ampalu Nan XX', 'Pisang Nan XX', 'Tanah Sirah Piai Nan XX', 'Tanjung Saba Pitameh Nan XX', 'Tanjung Aur Nan XX', 'Gates Nan XX']
            ],
            [
                'name' => 'Lubuk Kilangan',
                'sub_districts' => ['Bandar Buat', 'Batu Gadang', 'Beringin', 'Indarung', 'Koto Lalang', 'Padang Besi', 'Tarantang']
            ],
            [
                'name' => 'Nanggalo',
                'sub_districts' => ['Gurun Laweh', 'Kampung Lapai', 'Kampung Olo', 'Kurao Pagang', 'Surau Gadang', 'Tabing Banda Gadang']
            ],
            [
                'name' => 'Padang Barat',
                'sub_districts' => ['Belakang Tangsi', 'Kampung Jao', 'Kampung Pondok', 'Olo', 'Padang Pasir', 'Purus', 'Rimbo Kaluang']
            ],
            [
                'name' => 'Padang Selatan',
                'sub_districts' => ['Air Manis', 'Alang Laweh', 'Batang Arau', 'Belakang Olo', 'Bukit Gado-gado', 'Mato Aie', 'Pasa Gadang', 'Ranah Parak Rumbio', 'Rawang', 'Seberang Padang', 'Seberang Palinggam', 'Teluk Bayur']
            ],
            [
                'name' => 'Padang Timur',
                'sub_districts' => ['Andalas', 'Ganting Parak Gadang', 'Jati', 'Kubu Marapalam', 'Parak Gadang Timur', 'Sawahan', 'Sawahan Timur', 'Simpang Haru']
            ],
            [
                'name' => 'Padang Utara',
                'sub_districts' => ['Air Tawar Barat', 'Air Tawar Timur', 'Alai Parak Kopi', 'Gunung Pangilun', 'Lolong Belanti', 'Ulak Karang Selatan', 'Ulak Karang Utara']
            ],
            [
                'name' => 'Pauh',
                'sub_districts' => ['Binuang Kampung Dalam', 'Cupak Tangah', 'Kapalo Koto', 'Koto Luar', 'Lambung Bukit', 'Limau Manis', 'Limau Manis Selatan', 'Pisang', 'Piai Tangah']
            ],
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
