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
                'name' => 'John Doe',
                'email' => 'john@test.com',
                'password' => Hash::make('password123'),
                'usia' => 25,
                'no_hp' => '081234567890',
                'jenis_kelamin' => 'laki-laki',
                'kesibukan' => 'mahasiswa',
                'koin' => 100,
                'role' => 'user',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@test.com',
                'password' => Hash::make('password123'),
                'usia' => 28,
                'no_hp' => '081234567891',
                'jenis_kelamin' => 'perempuan',
                'kesibukan' => 'karyawan',
                'koin' => 150,
                'role' => 'user',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => Hash::make('admin123'),
                'usia' => 30,
                'no_hp' => '081234567892',
                'jenis_kelamin' => 'laki-laki',
                'kesibukan' => 'profesional',
                'koin' => 0,
                'role' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            $role = $user['role'];
            unset($user['role']);
            
            $user = User::create($user);
            $user->assignRole($role);
        }

        // Generate additional dummy users (kalau factory-nya sudah disesuaikan dengan kolom yang sama)
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
