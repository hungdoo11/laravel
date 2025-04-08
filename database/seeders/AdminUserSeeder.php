<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'full_name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'phone' => '0123456789',
            'address' => '123 Admin Street',
            'level' => 1, // Admin
        ]);

        // Optional: Add another admin with level 2

    }
}
