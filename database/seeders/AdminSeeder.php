<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@portalfilm.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'User Demo',
            'email' => 'user@portalfilm.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_USER,
            'email_verified_at' => now(),
        ]);
    }
}
