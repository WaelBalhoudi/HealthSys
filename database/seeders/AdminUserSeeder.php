<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Chef Medecine',
            'email' => 'chef@healthsys.com',
            'password' => Hash::make('password123'),
            'role' => 'chef_medecine',
            'phone' => '0612345678',
            'address' => 'Casablanca, Maroc',
            'birth_date' => '1980-01-01',
        ]);
    }
}