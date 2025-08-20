<?php

/**
 * Lecturer Factory Usage Examples
 *
 * This file demonstrates how to use the lecturer factories to create
 * realistic lecturer data for testing and seeding purposes.
 */

// Example 1: Create a basic lecturer with profile
$lecturer = \Database\Factories\LecturerFactory::new()->withProfile();
echo "Created lecturer: " . $lecturer->name . " with ID: " . $lecturer->lecturerProfile->lecturer_id;

// Example 2: Create a lecturer with specific faculty
$faculty = \App\Models\Faculty::where('code', 'FCS')->first();
$csLecturer = \Database\Factories\LecturerFactory::new()
    ->withFaculty($faculty)
    ->active();
echo "Created CS faculty lecturer: " . $csLecturer->name;

// Example 3: Create a professor
$professor = \Database\Factories\LecturerFactory::new()->professor();
echo "Created professor: " . $professor->name . " - " . $professor->lecturerProfile->academic_rank;

// Example 4: Create an associate professor
$associateProf = \Database\Factories\LecturerFactory::new()->associateProfessor();
echo "Created associate professor: " . $associateProf->name;

// Example 5: Create a lecturer with specific specialization
$aiLecturer = \Database\Factories\LecturerFactory::new()
    ->withSpecialization('Artificial Intelligence')
    ->active();
echo "Created AI lecturer: " . $aiLecturer->name;

// Example 6: Create a lecturer with specific qualification
$phdLecturer = \Database\Factories\LecturerFactory::new()
    ->withQualification('PhD')
    ->active();
echo "Created PhD lecturer: " . $phdLecturer->name;

// Example 7: Create multiple lecturers at once
$lecturerFactory = new \Database\Factories\LecturerFactory();
$lecturers = $lecturerFactory->createLecturers(10);
echo "Created " . $lecturers->count() . " lecturers";

// Example 8: Create lecturers by rank distribution
$rankDistribution = [
    'professor' => 5,
    'associate_professor' => 8,
    'lecturer' => 12,
    'assistant' => 5,
];
$lecturersByRank = $lecturerFactory->createByRankDistribution($rankDistribution);
echo "Created lecturers by rank distribution";

// Example 9: Using individual factories
// Create faculty first
$faculty = \App\Models\Faculty::factory()->create([
    'name' => 'Faculty of Engineering',
    'code' => 'FE'
]);

// Create lecturer profile
$user = \App\Models\User::factory()->create();
$lecturerProfile = \App\Models\LecturerProfile::factory()
    ->forUser($user)
    ->forFaculty($faculty)
    ->professor()
    ->withSpecialization('Mechanical Engineering')
    ->create();

echo "Created lecturer with custom setup: " . $user->name;

// Example 10: Create lecturers with specific statuses
$activeLecturers = \App\Models\LecturerProfile::factory()
    ->count(5)
    ->active()
    ->create();

$retiredLecturers = \App\Models\LecturerProfile::factory()
    ->count(2)
    ->retired()
    ->create();

echo "Created " . $activeLecturers->count() . " active and " . $retiredLecturers->count() . " retired lecturers";

// Example 11: Query lecturers by relationships
$csLecturers = \App\Models\LecturerProfile::query()
    ->whereHas('faculty', function($query) {
        $query->where('code', 'FCS');
    })
    ->active()
    ->get();

echo "Found " . $csLecturers->count() . " active Computer Science faculty lecturers";

// Example 12: Create lecturers with specific academic ranks
$academicRanks = ['assistant', 'lecturer', 'associate_professor', 'professor'];

foreach ($academicRanks as $rank) {
    $lecturer = \Database\Factories\LecturerFactory::new()
        ->withRank($rank)
        ->active();
    echo "Created {$rank}: " . $lecturer->name;
}

// Example 13: Create lecturers with research interests
$researchInterests = [
    'Machine Learning',
    'Artificial Intelligence',
    'Data Science',
    'Software Engineering',
    'Cybersecurity'
];

foreach ($researchInterests as $interest) {
    $lecturer = \Database\Factories\LecturerFactory::new()
        ->withSpecialization($interest)
        ->withQualification('PhD')
        ->active();
    echo "Created {$interest} researcher: " . $lecturer->name;
}

// Example 14: Create department heads (professors)
$faculties = \App\Models\Faculty::all();
foreach ($faculties as $faculty) {
    $departmentHead = \Database\Factories\LecturerFactory::new()
        ->withFaculty($faculty)
        ->professor()
        ->active();
    echo "Created department head for {$faculty->name}: " . $departmentHead->name;
}

// Example 15: Create lecturers with office hours
$lecturersWithOfficeHours = \App\Models\LecturerProfile::factory()
    ->count(3)
    ->active()
    ->create();

foreach ($lecturersWithOfficeHours as $lecturer) {
    echo "Lecturer: " . $lecturer->user->name . " - Office Hours: " . $lecturer->office_hours;
}

// Example 16: Create lecturers by qualification distribution
$qualifications = ['PhD', 'Master', 'PhD', 'PhD', 'Master']; // Higher chance for PhD
foreach ($qualifications as $qualification) {
    $lecturer = \Database\Factories\LecturerFactory::new()
        ->withQualification($qualification)
        ->active();
    echo "Created {$qualification} lecturer: " . $lecturer->name;
}

// Example 17: Create lecturers for specific study programs
$studyPrograms = \App\Models\StudyProgram::all();
foreach ($studyPrograms as $program) {
    $lecturer = \Database\Factories\LecturerFactory::new()
        ->withFaculty($program->faculty)
        ->withSpecialization($program->name)
        ->active();
    echo "Created lecturer for {$program->name}: " . $lecturer->name;
}

// Example 18: Create lecturers with different statuses
$statuses = ['active', 'inactive', 'retired'];
foreach ($statuses as $status) {
    $lecturer = \Database\Factories\LecturerFactory::new()
        ->withRank('lecturer');

    if ($status === 'active') {
        $lecturer = $lecturer->active();
    } elseif ($status === 'retired') {
        $lecturer = $lecturer->retired();
    } else {
        $lecturer = $lecturer->inactive();
    }

    echo "Created {$status} lecturer: " . $lecturer->name;
}

// Example 19: Create lecturers with realistic data for testing
$testScenarios = [
    'senior_professor' => function() {
        return \Database\Factories\LecturerFactory::new()
            ->professor()
            ->withQualification('PhD')
            ->withSpecialization('Computer Science');
    },
    'junior_lecturer' => function() {
        return \Database\Factories\LecturerFactory::new()
            ->withRank('lecturer')
            ->withQualification('Master')
            ->withSpecialization('Software Engineering');
    },
    'research_assistant' => function() {
        return \Database\Factories\LecturerFactory::new()
            ->withRank('assistant')
            ->withQualification('Master')
            ->withSpecialization('Data Science');
    }
];

foreach ($testScenarios as $scenario => $factory) {
    $lecturer = $factory();
    echo "Created {$scenario}: " . $lecturer->name;
}
