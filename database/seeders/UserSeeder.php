<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Awais Safdar',
            'email' => 'awais@gmail.com',
            'password' => Hash::make('awais123@'),
        ]);

        // Mohsin user
        User::create([
            'name' => 'Mohsin',
            'email' => 'mohsin@gmail.com',
            'password' => Hash::make('password'), // Change password if needed
        ]);

        // Sohaib user
        User::create([
            'name' => 'Sohaib',
            'email' => 'sohaib@gmail.com',
            'password' => Hash::make('password'), // Change password if needed
        ]);

        // moosa user
        User::create([
            'name' => 'moosa',
            'email' => 'moosa@gmail.com',
            'password' => Hash::make('password'), // Change password if needed
        ]);
    }
}
