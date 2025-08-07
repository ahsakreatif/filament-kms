<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\AcademicStaffProfile;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AcademicStaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Create an academic staff with both user and profile.
     */
    public function withProfile(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create an academic staff with a specific faculty.
     */
    public function withFaculty(Faculty $faculty, array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->forFaculty($faculty)
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create an active academic staff.
     */
    public function active(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->active()
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create a dean.
     */
    public function dean(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->dean()
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create an associate dean.
     */
    public function associateDean(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->associateDean()
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create a head of department.
     */
    public function headOfDepartment(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->headOfDepartment()
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create a program coordinator.
     */
    public function programCoordinator(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->programCoordinator()
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create an academic advisor.
     */
    public function academicAdvisor(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->academicAdvisor()
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create an academic staff with specific position.
     */
    public function withPosition(string $position, array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->withPosition($position)
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create an academic staff with specific position and faculty.
     */
    public function withPositionAndFaculty(string $position, Faculty $faculty, array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->withPosition($position)
            ->forFaculty($faculty)
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create a retired academic staff.
     */
    public function retired(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::ACADEMIC_STAFF);

        AcademicStaffProfile::factory()
            ->forUser($user)
            ->retired()
            ->create($profileAttributes);

        return $user->load('academicStaffProfile');
    }

    /**
     * Create multiple academic staff with profiles.
     */
    public function createAcademicStaff(int $count, array $profileAttributes = []): \Illuminate\Database\Eloquent\Collection
    {
        $users = collect();

        for ($i = 0; $i < $count; $i++) {
            $users->push($this->withProfile($profileAttributes));
        }

        return $users;
    }

    /**
     * Create academic staff by position distribution.
     */
    public function createByPositionDistribution(array $distribution = [], array $profileAttributes = []): \Illuminate\Support\Collection
    {
        $defaultDistribution = [
            'Dean' => 5,
            'Associate Dean' => 8,
            'Head of Department' => 12,
            'Program Coordinator' => 15,
            'Academic Advisor' => 10,
            'Administrative Officer' => 8,
        ];

        $distribution = array_merge($defaultDistribution, $distribution);
        $users = collect();

        foreach ($distribution as $position => $count) {
            for ($i = 0; $i < $count; $i++) {
                // If faculty is provided in profileAttributes, use it
                if (isset($profileAttributes['faculty'])) {
                    $faculty = $profileAttributes['faculty'];
                    unset($profileAttributes['faculty']); // Remove from attributes
                    $users->push($this->withPositionAndFaculty($position, $faculty, $profileAttributes));
                } else {
                    $users->push($this->withPosition($position, $profileAttributes));
                }
            }
        }

        return $users;
    }
}
