<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\StudyProgram;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create faculties first
        $faculties = [
            ['name' => 'Faculty of Engineering', 'code' => 'FE'],
            ['name' => 'Faculty of Computer Science', 'code' => 'FCS'],
            ['name' => 'Faculty of Business and Economics', 'code' => 'FBE'],
            ['name' => 'Faculty of Medicine', 'code' => 'FM'],
            ['name' => 'Faculty of Law', 'code' => 'FL'],
        ];

        foreach ($faculties as $facultyData) {
            Faculty::factory()->create($facultyData);
        }

        // Create study programs for each faculty
        $studyPrograms = [
            // Engineering
            ['name' => 'Civil Engineering', 'code' => 'CE', 'faculty_code' => 'FE'],
            ['name' => 'Mechanical Engineering', 'code' => 'ME', 'faculty_code' => 'FE'],
            ['name' => 'Electrical Engineering', 'code' => 'EE', 'faculty_code' => 'FE'],

            // Computer Science
            ['name' => 'Computer Science', 'code' => 'CS', 'faculty_code' => 'FCS'],
            ['name' => 'Information Technology', 'code' => 'IT', 'faculty_code' => 'FCS'],
            ['name' => 'Software Engineering', 'code' => 'SE', 'faculty_code' => 'FCS'],
            ['name' => 'Data Science', 'code' => 'DS', 'faculty_code' => 'FCS'],

            // Business
            ['name' => 'Business Administration', 'code' => 'BA', 'faculty_code' => 'FBE'],
            ['name' => 'Economics', 'code' => 'ECON', 'faculty_code' => 'FBE'],
            ['name' => 'Accounting', 'code' => 'ACC', 'faculty_code' => 'FBE'],

            // Medicine
            ['name' => 'Medicine', 'code' => 'MED', 'faculty_code' => 'FM'],

            // Law
            ['name' => 'Law', 'code' => 'LAW', 'faculty_code' => 'FL'],
        ];

        foreach ($studyPrograms as $programData) {
            $faculty = Faculty::where('code', $programData['faculty_code'])->first();
            StudyProgram::factory()
                ->forFaculty($faculty)
                ->create([
                    'name' => $programData['name'],
                    'code' => $programData['code'],
                ]);
        }
    }
}
