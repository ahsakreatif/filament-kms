<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\Role;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            [
                'name' => 'student',
                'display_name' => 'Student',
                'description' => 'University students who can access learning materials',
                'profile_table' => 'student_profiles',
                'role_name' => Role::STUDENT->value,
                'is_active' => true,
            ],
            [
                'name' => 'lecturer',
                'display_name' => 'Lecturer',
                'description' => 'Academic staff who can upload and manage documents',
                'profile_table' => 'lecturer_profiles',
                'role_name' => Role::LECTURER->value,
                'is_active' => true,
            ],
            [
                'name' => 'academic_staff',
                'display_name' => 'Academic Staff',
                'description' => 'Administrative staff for academic affairs',
                'profile_table' => 'academic_staff_profiles',
                'role_name' => Role::ACADEMIC_STAFF->value,
                'is_active' => true,
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'System administrators with full access',
                'profile_table' => 'admin_profiles',
                'role_name' => Role::SUPER_ADMIN->value,
                'is_active' => true,
            ],
        ];

        foreach ($userTypes as $userType) {
            UserType::updateOrCreate(
                ['name' => $userType['name']],
                $userType
            );
        }
    }
}
