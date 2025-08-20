<?php

/**
 * Student Factory Usage Examples
 *
 * This file demonstrates how to use the student factories to create
 * realistic student data for testing and seeding purposes.
 */

// Example 1: Create a basic student with profile
$student = \Database\Factories\StudentFactory::new()->withProfile();
echo "Created student: " . $student->name . " with ID: " . $student->studentProfile->student_id;

// Example 2: Create a student with specific study program
$studyProgram = \App\Models\StudyProgram::where('code', 'CS')->first();
$csStudent = \Database\Factories\StudentFactory::new()
    ->withStudyProgram($studyProgram)
    ->active();
echo "Created CS student: " . $csStudent->name;

// Example 3: Create a graduated student
$graduatedStudent = \Database\Factories\StudentFactory::new()->graduated();
echo "Created graduated student: " . $graduatedStudent->name;

// Example 4: Create a student with specific GPA range
$highGpaStudent = \Database\Factories\StudentFactory::new()
    ->withGpa(3.8, 4.0)
    ->active();
echo "Created high GPA student: " . $highGpaStudent->name . " GPA: " . $highGpaStudent->studentProfile->gpa;

// Example 5: Create a student enrolled in a specific year
$freshman = \Database\Factories\StudentFactory::new()
    ->enrolledIn(2024)
    ->inSemester(1)
    ->active();
echo "Created freshman: " . $freshman->name;

// Example 6: Create multiple students at once
$studentFactory = new \Database\Factories\StudentFactory();
$students = $studentFactory->createStudents(10);
echo "Created " . $students->count() . " students";

// Example 7: Create students with advisors
$advisor = \App\Models\LecturerProfile::first();
$advisedStudent = \Database\Factories\StudentFactory::new()
    ->withAdvisor($advisor)
    ->active();
echo "Created advised student: " . $advisedStudent->name;

// Example 8: Using individual factories
// Create faculty first
$faculty = \App\Models\Faculty::factory()->create([
    'name' => 'Faculty of Engineering',
    'code' => 'FE'
]);

// Create study program
$studyProgram = \App\Models\StudyProgram::factory()
    ->forFaculty($faculty)
    ->create([
        'name' => 'Mechanical Engineering',
        'code' => 'ME'
    ]);

// Create student profile
$user = \App\Models\User::factory()->create();
$studentProfile = \App\Models\StudentProfile::factory()
    ->forUser($user)
    ->forStudyProgram($studyProgram)
    ->active()
    ->create();

echo "Created student with custom setup: " . $user->name;

// Example 9: Create students with specific statuses
$activeStudents = \App\Models\StudentProfile::factory()
    ->count(5)
    ->active()
    ->create();

$suspendedStudents = \App\Models\StudentProfile::factory()
    ->count(2)
    ->suspended()
    ->create();

echo "Created " . $activeStudents->count() . " active and " . $suspendedStudents->count() . " suspended students";

// Example 10: Query students by relationships
$csStudents = \App\Models\StudentProfile::query()
    ->whereHas('studyProgram', function($query) {
        $query->where('code', 'CS');
    })
    ->active()
    ->get();

echo "Found " . $csStudents->count() . " active Computer Science students";

// Example 11: Create students with realistic data distribution
$currentYear = now()->year;
$enrollmentYears = range($currentYear - 4, $currentYear);

foreach ($enrollmentYears as $year) {
    $studentsInYear = \Database\Factories\StudentFactory::new()
        ->enrolledIn($year)
        ->active();
    echo "Created student enrolled in " . $year;
}

// Example 12: Using factory states for different scenarios
$testScenarios = [
    'high_achiever' => function() {
        return \Database\Factories\StudentFactory::new()
            ->withGpa(3.8, 4.0)
            ->active();
    },
    'struggling_student' => function() {
        return \Database\Factories\StudentFactory::new()
            ->withGpa(2.0, 2.5)
            ->active();
    },
    'senior_student' => function() {
        return \Database\Factories\StudentFactory::new()
            ->inSemester(7)
            ->active();
    }
];

foreach ($testScenarios as $scenario => $factory) {
    $student = $factory();
    echo "Created {$scenario}: " . $student->name;
}
