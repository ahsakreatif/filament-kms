<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed user types first
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            AcademicSeeder::class,
            UserTypeSeeder::class,
            LecturerSeeder::class,
            StudentSeeder::class,
            AcademicStaffSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            DocumentSeeder::class,
        ]);
    }
}
