<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\LecturerProfile;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class LecturerFactory extends Factory
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
     * Create a lecturer with both user and profile.
     */
    public function withProfile(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::LECTURER);

        LecturerProfile::factory()
            ->forUser($user)
            ->create($profileAttributes);

        return $user->load('lecturerProfile');
    }

    /**
     * Create a lecturer with a specific faculty.
     */
    public function withFaculty(Faculty $faculty, array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::LECTURER);

        LecturerProfile::factory()
            ->forUser($user)
            ->forFaculty($faculty)
            ->create($profileAttributes);

        return $user->load('lecturerProfile');
    }

    /**
     * Create an active lecturer.
     */
    public function active(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::LECTURER);

        LecturerProfile::factory()
            ->forUser($user)
            ->active()
            ->create($profileAttributes);

        return $user->load('lecturerProfile');
    }

    /**
     * Create a professor.
     */
    public function professor(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::LECTURER);

        LecturerProfile::factory()
            ->forUser($user)
            ->professor()
            ->create($profileAttributes);

        return $user->load('lecturerProfile');
    }

    /**
     * Create an associate professor.
     */
    public function associateProfessor(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::LECTURER);

        LecturerProfile::factory()
            ->forUser($user)
            ->associateProfessor()
            ->create($profileAttributes);

        return $user->load('lecturerProfile');
    }

    /**
     * Create a lecturer with specific rank.
     */
    public function withRank(string $rank, array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::LECTURER);

        LecturerProfile::factory()
            ->forUser($user)
            ->withRank($rank)
            ->create($profileAttributes);

        return $user->load('lecturerProfile');
    }

    /**
     * Create a lecturer with specific specialization.
     */
    public function withSpecialization(string $specialization, array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::LECTURER);

        LecturerProfile::factory()
            ->forUser($user)
            ->withSpecialization($specialization)
            ->create($profileAttributes);

        return $user->load('lecturerProfile');
    }

    /**
     * Create a lecturer with specific qualification.
     */
    public function withQualification(string $qualification, array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::LECTURER);

        LecturerProfile::factory()
            ->forUser($user)
            ->withQualification($qualification)
            ->create($profileAttributes);

        return $user->load('lecturerProfile');
    }

    /**
     * Create a retired lecturer.
     */
    public function retired(array $profileAttributes = []): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::LECTURER);

        LecturerProfile::factory()
            ->forUser($user)
            ->retired()
            ->create($profileAttributes);

        return $user->load('lecturerProfile');
    }

    /**
     * Create multiple lecturers with profiles.
     */
    public function createLecturers(int $count, array $profileAttributes = []): \Illuminate\Database\Eloquent\Collection
    {
        $users = collect();

        for ($i = 0; $i < $count; $i++) {
            $users->push($this->withProfile($profileAttributes));
        }

        return $users;
    }

    /**
     * Create lecturers by academic rank distribution.
     */
    public function createByRankDistribution(array $distribution = []): \Illuminate\Database\Eloquent\Collection
    {
        $defaultDistribution = [
            'professor' => 20,
            'associate_professor' => 30,
            'lecturer' => 35,
            'assistant' => 15,
        ];

        $distribution = array_merge($defaultDistribution, $distribution);
        $users = collect();

        foreach ($distribution as $rank => $count) {
            for ($i = 0; $i < $count; $i++) {
                $users->push($this->withRank($rank));
            }
        }

        return $users;
    }
}
