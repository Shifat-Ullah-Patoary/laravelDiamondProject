<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure this matches your User model
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // The unique identifier to check
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'), // Change this!
                // If your users table has an 'is_admin' column (recommended):
                'is_admin' => true,
            ]
        );
    }
}