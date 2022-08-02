<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kec = [
            [
                'id' => '1',
                'name' => 'Bontang Barat',
            ],
            [
                'id' => '2',
                'name' => 'Bontang Selatan',
            ],
            [
                'id' => '3',
                'name' => 'Bontang Utara',
            ],
        ];

        foreach ($kec as $key => $kec) {
            Kecamatan::create($kec);
        }
    }
}
