<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama' => 'John Doe',
                'email' => 'john@test.com',
                'password' => Hash::make('password123'),
                'usia' => 25,
                'no_hp' => '081234567890',
                'jenis_kelamin' => 'laki-laki',
                'koin' => 100,
            ],
            [
                'nama' => 'Jane Smith',
                'email' => 'jane@test.com',
                'password' => Hash::make('password123'),
                'usia' => 28,
                'no_hp' => '081234567891',
                'jenis_kelamin' => 'perempuan',
                'koin' => 150,
            ],
            [
                'nama' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => Hash::make('admin123'),
                'usia' => 30,
                'no_hp' => '081234567892',
                'jenis_kelamin' => 'laki-laki',
                'koin' => 500,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Generate additional dummy users (kalau factory-nya sudah disesuaikan dengan kolom yang sama)
        User::factory(10)->create();
    }
}
