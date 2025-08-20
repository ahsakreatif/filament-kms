<?php

/**
 * Academic Staff Factory Usage Examples
 *
 * This file demonstrates how to use the academic staff factories to create
 * realistic academic staff data for testing and seeding purposes.
 */

// Example 1: Create a basic academic staff with profile
$academicStaff = \Database\Factories\AcademicStaffFactory::new()->withProfile();
echo "Created academic staff: " . $academicStaff->name . " with ID: " . $academicStaff->academicStaffProfile->academic_id;

// Example 2: Create an academic staff with specific faculty
$faculty = \App\Models\Faculty::where('code', 'FCS')->first();
$csStaff = \Database\Factories\AcademicStaffFactory::new()
    ->withFaculty($faculty)
    ->active();
echo "Created CS faculty staff: " . $csStaff->name;

// Example 3: Create a dean
$dean = \Database\Factories\AcademicStaffFactory::new()->dean();
echo "Created dean: " . $dean->name . " - " . $dean->academicStaffProfile->position;

// Example 4: Create an associate dean
$associateDean = \Database\Factories\AcademicStaffFactory::new()->associateDean();
echo "Created associate dean: " . $associateDean->name;

// Example 5: Create a head of department
$hod = \Database\Factories\AcademicStaffFactory::new()->headOfDepartment();
echo "Created head of department: " . $hod->name;

// Example 6: Create a program coordinator
$coordinator = \Database\Factories\AcademicStaffFactory::new()->programCoordinator();
echo "Created program coordinator: " . $coordinator->name;

// Example 7: Create an academic advisor
$advisor = \Database\Factories\AcademicStaffFactory::new()->academicAdvisor();
echo "Created academic advisor: " . $advisor->name;

// Example 8: Create multiple academic staff at once
$academicStaffFactory = new \Database\Factories\AcademicStaffFactory();
$staff = $academicStaffFactory->createAcademicStaff(10);
echo "Created " . $staff->count() . " academic staff";

// Example 9: Create academic staff by position distribution
$positionDistribution = [
    'Dean' => 3,
    'Associate Dean' => 5,
    'Head of Department' => 8,
    'Program Coordinator' => 10,
    'Academic Advisor' => 6,
    'Administrative Officer' => 4,
];
$staffByPosition = $academicStaffFactory->createByPositionDistribution($positionDistribution);
echo "Created academic staff by position distribution";

// Example 10: Using individual factories
// Create faculty first
$faculty = \App\Models\Faculty::factory()->create([
    'name' => 'Faculty of Engineering',
    'code' => 'FE'
]);

// Create academic staff profile
$user = \App\Models\User::factory()->create();
$academicStaffProfile = \App\Models\AcademicStaffProfile::factory()
    ->forUser($user)
    ->forFaculty($faculty)
    ->dean()
    ->create();

echo "Created academic staff with custom setup: " . $user->name;

// Example 11: Create academic staff with specific statuses
$activeStaff = \App\Models\AcademicStaffProfile::factory()
    ->count(5)
    ->active()
    ->create();

$retiredStaff = \App\Models\AcademicStaffProfile::factory()
    ->count(2)
    ->retired()
    ->create();

echo "Created " . $activeStaff->count() . " active and " . $retiredStaff->count() . " retired academic staff";

// Example 12: Query academic staff by relationships
$csStaff = \App\Models\AcademicStaffProfile::query()
    ->whereHas('faculty', function($query) {
        $query->where('code', 'FCS');
    })
    ->active()
    ->get();

echo "Found " . $csStaff->count() . " active Computer Science faculty academic staff";

// Example 13: Create academic staff with specific positions
$positions = ['Dean', 'Associate Dean', 'Head of Department', 'Program Coordinator', 'Academic Advisor'];

foreach ($positions as $position) {
    $staff = \Database\Factories\AcademicStaffFactory::new()
        ->withPosition($position)
        ->active();
    echo "Created {$position}: " . $staff->name;
}

// Example 14: Create academic staff with specific responsibilities
$responsibilities = [
    'Academic Planning and Development',
    'Student Affairs Management',
    'Research Coordination',
    'Quality Assurance',
    'International Relations'
];

foreach ($responsibilities as $responsibility) {
    $staff = \App\Models\AcademicStaffProfile::factory()
        ->active()
        ->create([
            'responsibilities' => [$responsibility]
        ]);
    echo "Created staff with responsibility: {$responsibility} - " . $staff->user->name;
}

// Example 15: Create deans for each faculty
$faculties = \App\Models\Faculty::all();
foreach ($faculties as $faculty) {
    $dean = \Database\Factories\AcademicStaffFactory::new()
        ->withFaculty($faculty)
        ->dean()
        ->active();
    echo "Created dean for {$faculty->name}: " . $dean->name;
}

// Example 16: Create academic staff with office locations
$staffWithOffices = \App\Models\AcademicStaffProfile::factory()
    ->count(3)
    ->active()
    ->create();

foreach ($staffWithOffices as $staff) {
    echo "Staff: " . $staff->user->name . " - Office: " . $staff->office_location;
}

// Example 17: Create academic staff by qualification distribution
$qualifications = ['PhD', 'Master', 'Bachelor', 'PhD', 'Master']; // Higher chance for higher qualifications
foreach ($qualifications as $qualification) {
    $staff = \Database\Factories\AcademicStaffFactory::new()
        ->withPosition('Dean')
        ->active();
    echo "Created {$qualification} dean: " . $staff->name;
}

// Example 18: Create academic staff for specific study programs
$studyPrograms = \App\Models\StudyProgram::all();
foreach ($studyPrograms as $program) {
    $coordinator = \Database\Factories\AcademicStaffFactory::new()
        ->withFaculty($program->faculty)
        ->withPosition('Program Coordinator')
        ->active();
    echo "Created coordinator for {$program->name}: " . $coordinator->name;
}

// Example 19: Create academic staff with different statuses
$statuses = ['active', 'inactive', 'retired'];
foreach ($statuses as $status) {
    $staff = \Database\Factories\AcademicStaffFactory::new()
        ->withPosition('Dean');

    if ($status === 'active') {
        $staff = $staff->active();
    } elseif ($status === 'retired') {
        $staff = $staff->retired();
    } else {
        $staff = $staff->inactive();
    }

    echo "Created {$status} dean: " . $staff->name;
}

// Example 20: Create academic staff with realistic data for testing
$testScenarios = [
    'senior_dean' => function() {
        return \Database\Factories\AcademicStaffFactory::new()
            ->dean()
            ->withPosition('Dean');
    },
    'department_head' => function() {
        return \Database\Factories\AcademicStaffFactory::new()
            ->withPosition('Head of Department')
            ->active();
    },
    'program_coordinator' => function() {
        return \Database\Factories\AcademicStaffFactory::new()
            ->withPosition('Program Coordinator')
            ->active();
    },
    'academic_advisor' => function() {
        return \Database\Factories\AcademicStaffFactory::new()
            ->withPosition('Academic Advisor')
            ->active();
    }
];

foreach ($testScenarios as $scenario => $factory) {
    $staff = $factory();
    echo "Created {$scenario}: " . $staff->name;
}
