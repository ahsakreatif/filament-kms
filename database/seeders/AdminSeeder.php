<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Enums\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@utpas.ac.id',
            'password' => Hash::make('@Utpas-2025!'),
            'email_verified_at' => now(),
        ]);

        // Assign super admin role to the user
        $superAdmin->assignRole(Role::SUPER_ADMIN);
    }
}
