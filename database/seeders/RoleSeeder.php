<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role as SpatieRole;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles using the Role enum
        foreach (Role::cases() as $role) {
            SpatieRole::updateOrCreate(
                [
                    'id' => $role->id(),
                    'name' => $role->value,
                    'guard_name' => 'web',
                ],
                [
                    'id' => $role->id(),
                    'name' => $role->value,
                    'guard_name' => 'web',
                ]
            );
        }
    }
}
