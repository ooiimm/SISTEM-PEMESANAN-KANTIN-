<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        
        User::create([
            'name' => 'Al Farrel Fabryan',
            'nim' => '2311501122',
            'password' => '123456',
            'role' => 'admin',
        ]);

        
        User::create([
            'name' => 'Rafi Imam Hernawan',
            'nim' => '2311500710',
            'password' => '123456', 
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Guest User',
            'nim' => 'guest_user_account', 
            'password' => 'a_very_secure_password_that_no_one_knows', 
            'role' => 'mahasiswa', 
        ]);
    }
}