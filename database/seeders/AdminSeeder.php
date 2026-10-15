<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('The demo account seeder is restricted to local and testing environments.');
        }

        if (DB::connection()->getDriverName() !== 'sqlite') {
            throw new RuntimeException('The demo account seeder requires an isolated SQLite database.');
        }

        $email = 'admin@example.test';
        if (User::where('email', $email)->exists()) {
            throw new RuntimeException('The demo account already exists; refusing to overwrite it.');
        }

        User::create([
            'nama' => 'Admin Demo',
            'email' => $email,
            'password' => Hash::make('LocalDemoPass123!'),
            'role' => User::ROLE_ADMIN,
        ]);
    }
}
