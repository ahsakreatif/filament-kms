<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicStaffProfile;
use App\Models\Faculty;
use Database\Factories\AcademicStaffFactory;

class AcademicStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have faculties first
        if (Faculty::count() === 0) {
            $this->command->info('No faculties found. Please run FacultySeeder first.');
            return;
        }

        $academicStaffFactory = new AcademicStaffFactory();
        $faculties = Faculty::all();

        // Create academic staff by position distribution
        $this->command->info('Creating academic staff with position distribution...');
        $academicStaff = $academicStaffFactory->createByPositionDistribution([
            'Dean' => 5,
            'Associate Dean' => 8,
            'Head of Department' => 12,
            'Program Coordinator' => 15,
            'Academic Advisor' => 10,
            'Administrative Officer' => 8,
            'Quality Assurance Officer' => 5,
            'Student Affairs Officer' => 6,
            'Research Coordinator' => 4,
        ], ['faculty' => $faculties->random()]);

        // Create academic staff for specific faculties
        foreach ($faculties as $faculty) {
            $this->command->info("Creating academic staff for {$faculty->name}...");

            // Create dean for each faculty
            $academicStaffFactory->dean(['faculty_id' => $faculty->id]);

            // Create associate dean for each faculty
            $academicStaffFactory->associateDean(['faculty_id' => $faculty->id]);

            // Create 2-4 additional staff per faculty
            $count = rand(2, 4);
            for ($i = 0; $i < $count; $i++) {
                $academicStaffFactory->active(['faculty_id' => $faculty->id]);
            }
        }

        // Create academic staff with specific positions
        $positions = [
            'Dean' => 5,
            'Associate Dean' => 8,
            'Head of Department' => 12,
            'Program Coordinator' => 15,
            'Academic Advisor' => 10,
            'Quality Assurance Officer' => 5,
            'Student Affairs Officer' => 6,
            'Research Coordinator' => 4,
            'International Relations Officer' => 3,
            'Library Coordinator' => 2,
            'IT Coordinator' => 3,
        ];

        foreach ($positions as $position => $count) {
            $this->command->info("Creating {$count} academic staff with position: {$position}...");
            for ($i = 0; $i < $count; $i++) {
                $academicStaffFactory->withPosition($position, ['faculty_id' => $faculties->random()->id]);
            }
        }

        // Create some retired academic staff
        $this->command->info('Creating retired academic staff...');
        for ($i = 0; $i < 3; $i++) {
            $academicStaffFactory->retired(['faculty_id' => $faculties->random()->id]);
        }

        // Create academic staff with specific responsibilities
        $this->command->info('Creating academic staff with specific responsibilities...');
        $responsibilityGroups = [
            'Academic Planning' => ['Dean', 'Associate Dean', 'Head of Department'],
            'Student Affairs' => ['Student Affairs Officer', 'Academic Advisor'],
            'Quality Assurance' => ['Quality Assurance Officer'],
            'Research' => ['Research Coordinator'],
            'Administration' => ['Administrative Officer', 'Secretary'],
        ];

        foreach ($responsibilityGroups as $responsibility => $positions) {
            foreach ($positions as $position) {
                $academicStaffFactory->withPosition($position, ['faculty_id' => $faculties->random()->id]);
            }
        }

        $this->command->info('Academic Staff seeder completed successfully!');
        $this->command->info('Created:');
        $this->command->info('- ' . AcademicStaffProfile::count() . ' academic staff profiles');
        $this->command->info('- ' . AcademicStaffProfile::where('status', 'active')->count() . ' active academic staff');
        $this->command->info('- ' . AcademicStaffProfile::where('status', 'retired')->count() . ' retired academic staff');
        $this->command->info('- ' . AcademicStaffProfile::where('position', 'Dean')->count() . ' deans');
        $this->command->info('- ' . AcademicStaffProfile::where('position', 'Head of Department')->count() . ' heads of department');
        $this->command->info('- ' . AcademicStaffProfile::where('position', 'Program Coordinator')->count() . ' program coordinators');
    }
}
