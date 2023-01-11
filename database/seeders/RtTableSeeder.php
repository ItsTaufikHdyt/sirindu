<?php

namespace Database\Seeders;

use App\Models\Rt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RtTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rt = [
            [
                'id' => '1',
                'id_posyandu' => 1,
                'id_kelurahan' => 1,
                'no' => 'Bontang Barat',
            ],
        ];
        foreach ($rt as $key => $rt) {
           Rt::create($rt);
        }
    }
}
