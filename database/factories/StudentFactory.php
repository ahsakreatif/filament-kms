<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\StudyProgram;
use App\Models\Faculty;
use App\Models\LecturerProfile;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class StudentFactory extends Factory
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

    public function basic(): User
    {
        $user = User::factory()->create();

        $user->assignRole(Role::STUDENT);

        return $user;
    }

    /**
     * Create a student with both user and profile.
     */
    public function withProfile(array $profileAttributes = []): User
    {
        $user = $this->basic();

        StudentProfile::factory()
            ->forUser($user)
            ->create($profileAttributes);

        $user->load('studentProfile');
        $profile = $user->studentProfile;

        $user->assignUserType(UserType::where('name', Role::STUDENT->value)->first(), $profile->id, true);

        return $user;
    }

    /**
     * Create a student with a specific study program.
     */
    public function withStudyProgram(StudyProgram $studyProgram, array $profileAttributes = []): User
    {
        $user = $this->basic();

        StudentProfile::factory()
            ->forUser($user)
            ->forStudyProgram($studyProgram)
            ->create($profileAttributes);

        $user->load('studentProfile');
        $profile = $user->studentProfile;

        $user->assignUserType(UserType::where('name', Role::STUDENT->value)->first(), $profile->id, true);

        return $user;
    }

    /**
     * Create a student with a specific faculty.
     */
    public function withFaculty(Faculty $faculty, array $profileAttributes = []): User
    {
        $user = $this->basic();

        StudentProfile::factory()
            ->forUser($user)
            ->forFaculty($faculty)
            ->create($profileAttributes);

        $user->load('studentProfile');
        $profile = $user->studentProfile;

        $user->assignUserType(UserType::where('name', Role::STUDENT->value)->first(), $profile->id, true);

        return $user;
    }

    /**
     * Create an active student.
     */
    public function active(array $profileAttributes = []): User
    {
        $user = $this->basic();

        StudentProfile::factory()
            ->forUser($user)
            ->active()
            ->create($profileAttributes);

        $user->load('studentProfile');
        $profile = $user->studentProfile;

        $user->assignUserType(UserType::where('name', Role::STUDENT->value)->first(), $profile->id, true);

        return $user;
    }

    /**
     * Create a graduated student.
     */
    public function graduated(array $profileAttributes = []): User
    {
        $user = $this->basic();

        StudentProfile::factory()
            ->forUser($user)
            ->graduated()
            ->create($profileAttributes);

        $user->load('studentProfile');
        $profile = $user->studentProfile;

        $user->assignUserType(UserType::where('name', Role::STUDENT->value)->first(), $profile->id, true);

        return $user;
    }

    /**
     * Create a student with an advisor.
     */
    public function withAdvisor(LecturerProfile $advisor, array $profileAttributes = []): User
    {
        $user = $this->basic();

        StudentProfile::factory()
            ->forUser($user)
            ->withAdvisor($advisor)
            ->create($profileAttributes);

        $user->load('studentProfile');
        $profile = $user->studentProfile;

        $user->assignUserType(UserType::where('name', Role::STUDENT->value)->first(), $profile->id, true);

        return $user;
    }

    /**
     * Create a student enrolled in a specific year.
     */
    public function enrolledIn(int $year, array $profileAttributes = []): User
    {
        $user = $this->basic();

        StudentProfile::factory()
            ->forUser($user)
            ->enrolledIn($year)
            ->create($profileAttributes);

        $user->load('studentProfile');
        $profile = $user->studentProfile;

        $user->assignUserType(UserType::where('name', Role::STUDENT->value)->first(), $profile->id, true);

        return $user;
    }

    /**
     * Create a student in a specific semester.
     */
    public function inSemester(int $semester, array $profileAttributes = []): User
    {
        $user = $this->basic();

        StudentProfile::factory()
            ->forUser($user)
            ->inSemester($semester)
            ->create($profileAttributes);

        $user->load('studentProfile');
        $profile = $user->studentProfile;

        $user->assignUserType(UserType::where('name', Role::STUDENT->value)->first(), $profile->id, true);

        return $user;
    }

    /**
     * Create a student with a specific GPA range.
     */
    public function withGpa(float $minGpa, float $maxGpa, array $profileAttributes = []): User
    {
        $user = $this->basic();

        StudentProfile::factory()
            ->forUser($user)
            ->withGpa($minGpa, $maxGpa)
            ->create($profileAttributes);

        $user->load('studentProfile');
        $profile = $user->studentProfile;

        $user->assignUserType(UserType::where('name', Role::STUDENT->value)->first(), $profile->id, true);

        return $user;
    }

    /**
     * Create multiple students with profiles.
     */
    public function createStudents(int $count, array $profileAttributes = []): \Illuminate\Database\Eloquent\Collection
    {
        $users = collect();

        for ($i = 0; $i < $count; $i++) {
            $users->push($this->withProfile($profileAttributes));
        }

        return $users;
    }
}
