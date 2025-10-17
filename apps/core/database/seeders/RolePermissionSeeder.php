<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            // For User
            'view-dashboard',
            'dass21-test',
            'create-curhat',
            'penanganan-curhat',
            'konsultasi-curhat',

            // For Admin
            'manajemen-user',
            'manajemen-penanganan',
            'manajemen-konsultan',
            'manajemen-curhat',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view-dashboard',
            'dass21-test',
            'create-curhat',
            'penanganan-curhat',
            'konsultasi-curhat',
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
}
