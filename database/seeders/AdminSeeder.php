<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Irvan Afriandi', // Nama admin
            'email' => 'admin123@gmail.com', // Email admin
            'password' => Hash::make('admin1234'), // Password admin
            'role' => User::ROLE_ADMIN, // Role sebagai admin
        ]);
    }
}
