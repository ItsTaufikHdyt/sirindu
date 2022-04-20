<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
        $users = [
            [
                'name' => 'User',
                'nik' => '1234567890123456',
                'email' => 'user@myebtuts.com',
                'type' => 0,
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'Super Admin User',
                'nik' => '1234567890123457',
                'email' => 'super-admin@myebtuts.com',
                'type' => 1,
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'Manager User',
                'nik' => '1234567890123458',
                'email' => 'manager@myebtuts.com',
                'type' => 2,
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
