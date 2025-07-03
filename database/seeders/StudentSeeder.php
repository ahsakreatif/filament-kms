<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\LecturerProfile;
use Database\Factories\StudentFactory;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing lecturers for advisors
        $advisors = LecturerProfile::where('status', 'active')->limit(10)->get();

        if ($advisors->isEmpty()) {
            $this->command->info('No active lecturers found. Please run LecturerSeeder first.');
            return;
        }

        // Create students using different factory methods
        $studentFactory = new StudentFactory();

        // Create 50 active students with random profiles
        for ($i = 0; $i < 50; $i++) {
            $studyProgram = StudyProgram::inRandomOrder()->first();
            $advisor = $advisors->random();

            $studentFactory->withStudyProgram($studyProgram, [
                'advisor_id' => $advisor->id,
                'status' => 'active'
            ]);
        }

        // Create 10 graduated students
        for ($i = 0; $i < 10; $i++) {
            $studyProgram = StudyProgram::inRandomOrder()->first();

            $studentFactory->withStudyProgram($studyProgram, [
                'status' => 'graduated'
            ]);
        }

        // Create 5 suspended students
        for ($i = 0; $i < 5; $i++) {
            $studyProgram = StudyProgram::inRandomOrder()->first();

            $studentFactory->withStudyProgram($studyProgram, [
                'status' => 'suspended'
            ]);
        }

        // Create students with specific characteristics
        $computerScienceProgram = StudyProgram::where('code', 'CS')->first();

        // Create 20 Computer Science students with high GPA
        for ($i = 0; $i < 20; $i++) {
            $studentFactory->withStudyProgram($computerScienceProgram, [
                'gpa' => fake()->randomFloat(2, 3.5, 4.0),
                'status' => 'active'
            ]);
        }

        // Create students enrolled in different years
        $currentYear = now()->year;
        for ($year = $currentYear - 3; $year <= $currentYear; $year++) {
            $studyProgram = StudyProgram::inRandomOrder()->first();

            $studentFactory->withStudyProgram($studyProgram, [
                'enrollment_year' => $year,
                'status' => 'active'
            ]);
        }

        $this->command->info('Student seeder completed successfully!');
        $this->command->info('Created:');
        $this->command->info('- ' . Faculty::count() . ' faculties');
        $this->command->info('- ' . StudyProgram::count() . ' study programs');
        $this->command->info('- ' . \App\Models\StudentProfile::count() . ' student profiles');
    }
}
