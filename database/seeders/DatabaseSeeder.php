<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\KecamatanTableSeeder;
use Database\Seeders\KelurahanTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(KecamatanTableSeeder::class);
        $this->call(KelurahanTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        
    }
}
