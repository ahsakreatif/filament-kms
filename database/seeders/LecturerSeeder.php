<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LecturerProfile;
use App\Models\Faculty;
use App\Models\StudyProgram;
use Database\Factories\LecturerFactory;

class LecturerSeeder extends Seeder
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

        $lecturerFactory = new LecturerFactory();

        // Create lecturers by academic rank distribution
        $this->command->info('Creating lecturers with rank distribution...');
        $faculties = Faculty::all();

        // Create lecturers with rank distribution using existing faculties
        $rankDistribution = [
            'professor' => 15,
            'associate_professor' => 25,
            'lecturer' => 40,
            'assistant' => 20,
        ];

        foreach ($rankDistribution as $rank => $count) {
            for ($i = 0; $i < $count; $i++) {
                $faculty = $faculties->random();
                $lecturerFactory->withFaculty($faculty, [
                    'academic_rank' => $rank,
                    'status' => 'active'
                ]);
            }
        }

        // Create lecturers for specific faculties
        $faculties = Faculty::all();
        foreach ($faculties as $faculty) {
            $this->command->info("Creating lecturers for {$faculty->name}...");

            // Create 3-8 lecturers per faculty
            $count = rand(3, 8);
            for ($i = 0; $i < $count; $i++) {
                $lecturerFactory->withFaculty($faculty, [
                    'status' => 'active'
                ]);
            }
        }

        // Create lecturers with specific specializations
        $specializations = [
            'Computer Science' => 8,
            'Software Engineering' => 6,
            'Data Science' => 5,
            'Artificial Intelligence' => 4,
            'Business Administration' => 7,
            'Economics' => 5,
            'Mathematics' => 4,
            'Physics' => 3,
        ];

        foreach ($specializations as $specialization => $count) {
            $this->command->info("Creating {$count} lecturers specialized in {$specialization}...");
            for ($i = 0; $i < $count; $i++) {
                $faculty = $faculties->random();
                $lecturerFactory->withFaculty($faculty, [
                    'specialization' => $specialization,
                    'status' => 'active'
                ]);
            }
        }

        // Create some retired lecturers
        $this->command->info('Creating retired lecturers...');
        for ($i = 0; $i < 5; $i++) {
            $faculty = $faculties->random();
            $lecturerFactory->withFaculty($faculty, [
                'status' => 'retired'
            ]);
        }

        // Create lecturers with PhD qualifications
        $this->command->info('Creating PhD lecturers...');
        for ($i = 0; $i < 30; $i++) {
            $faculty = $faculties->random();
            $lecturerFactory->withFaculty($faculty, [
                'qualification' => 'PhD',
                'status' => 'active'
            ]);
        }

        $this->command->info('Lecturer seeder completed successfully!');
        $this->command->info('Created:');
        $this->command->info('- ' . LecturerProfile::count() . ' lecturer profiles');
        $this->command->info('- ' . LecturerProfile::where('status', 'active')->count() . ' active lecturers');
        $this->command->info('- ' . LecturerProfile::where('status', 'retired')->count() . ' retired lecturers');
        $this->command->info('- ' . LecturerProfile::where('academic_rank', 'professor')->count() . ' professors');
        $this->command->info('- ' . LecturerProfile::where('qualification', 'PhD')->count() . ' PhD holders');
    }
}
