<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Test users for development
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@test.com',
                'password' => Hash::make('password123'),
                'age' => 25,
                'phone' => '081234567890',
                'gender' => 'male',
                'coins' => 100
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@test.com',
                'password' => Hash::make('password123'),
                'age' => 28,
                'phone' => '081234567891',
                'gender' => 'female',
                'coins' => 150
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => Hash::make('admin123'),
                'age' => 30,
                'phone' => '081234567892',
                'gender' => 'male',
                'coins' => 500
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Generate additional dummy users
        User::factory(10)->create();
    }
}