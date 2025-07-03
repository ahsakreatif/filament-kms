<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\StudyProgram;
use App\Models\Faculty;
use App\Models\LecturerProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentProfile>
 */
class StudentProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currentYear = now()->year;
        $enrollmentYear = $this->faker->numberBetween($currentYear - 4, $currentYear);
        $maxSemester = min(8, ($currentYear - $enrollmentYear + 1) * 2);
        $currentSemester = $this->faker->numberBetween(1, $maxSemester);

        return [
            'user_id' => User::factory(),
            'student_id' => $this->generateStudentId($enrollmentYear),
            'study_program_id' => StudyProgram::factory(),
            'faculty_id' => Faculty::factory(),
            'enrollment_year' => $enrollmentYear,
            'current_semester' => $currentSemester,
            'gpa' => $this->faker->randomFloat(2, 2.0, 4.0),
            'advisor_id' => null, // Will be set separately if needed
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'graduated', 'suspended']), // Higher chance for active
        ];
    }

    /**
     * Generate a realistic student ID based on enrollment year.
     */
    private function generateStudentId(int $enrollmentYear): string
    {
        $yearSuffix = substr($enrollmentYear, -2);
        $randomNumber = $this->faker->numberBetween(1000, 9999);
        return $yearSuffix . $randomNumber;
    }

    /**
     * Indicate that the student is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the student has graduated.
     */
    public function graduated(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'graduated',
            'current_semester' => 8, // Assuming 8 semesters for graduation
        ]);
    }

    /**
     * Indicate that the student is suspended.
     */
    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'suspended',
        ]);
    }

    /**
     * Indicate that the student has dropped out.
     */
    public function dropped(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'dropped',
        ]);
    }

    /**
     * Set the user for the student profile.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Set the study program for the student profile.
     */
    public function forStudyProgram(StudyProgram $studyProgram): static
    {
        return $this->state(fn (array $attributes) => [
            'study_program_id' => $studyProgram->id,
            'faculty_id' => $studyProgram->faculty_id, // Automatically set faculty from study program
        ]);
    }

    /**
     * Set the faculty for the student profile.
     */
    public function forFaculty(Faculty $faculty): static
    {
        return $this->state(fn (array $attributes) => [
            'faculty_id' => $faculty->id,
        ]);
    }

    /**
     * Set the advisor for the student profile.
     */
    public function withAdvisor(LecturerProfile $advisor): static
    {
        return $this->state(fn (array $attributes) => [
            'advisor_id' => $advisor->id,
        ]);
    }

    /**
     * Set a specific enrollment year.
     */
    public function enrolledIn(int $year): static
    {
        return $this->state(fn (array $attributes) => [
            'enrollment_year' => $year,
            'student_id' => $this->generateStudentId($year),
        ]);
    }

    /**
     * Set a specific current semester.
     */
    public function inSemester(int $semester): static
    {
        return $this->state(fn (array $attributes) => [
            'current_semester' => $semester,
        ]);
    }

    /**
     * Set a specific GPA range.
     */
    public function withGpa(float $minGpa, float $maxGpa): static
    {
        return $this->state(fn (array $attributes) => [
            'gpa' => $this->faker->randomFloat(2, $minGpa, $maxGpa),
        ]);
    }
}
