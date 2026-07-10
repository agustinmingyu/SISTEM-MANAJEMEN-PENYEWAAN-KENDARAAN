<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'cyiva28@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        // // Member/User
        // User::updateOrCreate(
        //     ['email' => 'agustinanggun6@gmail.com'],
        //     [
        //         'name' => 'Minsya',
        //         'password' => Hash::make('user123'),
        //         'role' => 'user',
        //         'email_verified_at' => now(),
        //     ]
        // );
    }
}