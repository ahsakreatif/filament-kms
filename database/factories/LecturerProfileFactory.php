<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LecturerProfile>
 */
class LecturerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $academicRanks = ['assistant', 'lecturer', 'associate_professor', 'professor'];
        $qualifications = ['PhD', 'Master', 'PhD', 'PhD', 'Master']; // Higher chance for PhD
        $specializations = [
            'Computer Science', 'Software Engineering', 'Data Science', 'Artificial Intelligence',
            'Database Systems', 'Web Development', 'Mobile Development', 'Cybersecurity',
            'Civil Engineering', 'Mechanical Engineering', 'Electrical Engineering',
            'Business Administration', 'Economics', 'Accounting', 'Finance',
            'Mathematics', 'Physics', 'Chemistry', 'Biology',
            'English Literature', 'History', 'Philosophy', 'Psychology'
        ];

        return [
            'user_id' => User::factory(),
            'lecturer_id' => $this->generateLecturerId(),
            'faculty_id' => Faculty::factory(),
            'specialization' => $this->faker->randomElement($specializations),
            'academic_rank' => $this->faker->randomElement($academicRanks),
            'qualification' => $this->faker->randomElement($qualifications),
            'research_interests' => $this->generateResearchInterests(),
            'office_location' => $this->faker->buildingNumber() . ' ' . $this->faker->streetName(),
            'office_hours' => $this->generateOfficeHours(),
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'inactive']), // Higher chance for active
        ];
    }

    /**
     * Generate a realistic lecturer ID.
     */
    private function generateLecturerId(): string
    {
        do {
            $prefix = 'LEC';
            $year = $this->faker->numberBetween(2010, 2024);
            $randomNumber = $this->faker->numberBetween(1000, 9999);
            $suffix = $this->faker->numberBetween(10, 99);
            $lecturerId = $prefix . $year . $randomNumber . $suffix;
        } while (\App\Models\LecturerProfile::where('lecturer_id', $lecturerId)->exists());

        return $lecturerId;
    }

    /**
     * Generate research interests as an array.
     */
    private function generateResearchInterests(): array
    {
        $interests = [
            'Machine Learning', 'Artificial Intelligence', 'Data Mining', 'Big Data Analytics',
            'Software Engineering', 'Web Technologies', 'Mobile Computing', 'Cloud Computing',
            'Cybersecurity', 'Database Systems', 'Computer Networks', 'Operating Systems',
            'Human-Computer Interaction', 'Computer Vision', 'Natural Language Processing',
            'Robotics', 'Internet of Things', 'Blockchain Technology', 'Virtual Reality',
            'Augmented Reality', 'Game Development', 'E-commerce', 'Digital Marketing'
        ];

        $count = $this->faker->numberBetween(1, 4);
        return $this->faker->randomElements($interests, $count);
    }

    /**
     * Generate office hours.
     */
    private function generateOfficeHours(): string
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $selectedDays = $this->faker->randomElements($days, $this->faker->numberBetween(2, 4));

        $hours = [];
        foreach ($selectedDays as $day) {
            $startHour = $this->faker->numberBetween(9, 14);
            $endHour = $startHour + $this->faker->numberBetween(1, 3);
            $hours[] = "{$day}: {$startHour}:00 - {$endHour}:00";
        }

        return implode("\n", $hours);
    }

    /**
     * Indicate that the lecturer is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the lecturer is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the lecturer is retired.
     */
    public function retired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'retired',
        ]);
    }

    /**
     * Set the user for the lecturer profile.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Set the faculty for the lecturer profile.
     */
    public function forFaculty(Faculty $faculty): static
    {
        return $this->state(fn (array $attributes) => [
            'faculty_id' => $faculty->id,
        ]);
    }

    /**
     * Set a specific academic rank.
     */
    public function withRank(string $rank): static
    {
        return $this->state(fn (array $attributes) => [
            'academic_rank' => $rank,
        ]);
    }

    /**
     * Set a specific qualification.
     */
    public function withQualification(string $qualification): static
    {
        return $this->state(fn (array $attributes) => [
            'qualification' => $qualification,
        ]);
    }

    /**
     * Set a specific specialization.
     */
    public function withSpecialization(string $specialization): static
    {
        return $this->state(fn (array $attributes) => [
            'specialization' => $specialization,
        ]);
    }

    /**
     * Create a professor.
     */
    public function professor(): static
    {
        return $this->withRank('professor')->withQualification('PhD');
    }

    /**
     * Create an associate professor.
     */
    public function associateProfessor(): static
    {
        return $this->withRank('associate_professor')->withQualification('PhD');
    }

    /**
     * Create a lecturer.
     */
    public function lecturer(): static
    {
        return $this->withRank('lecturer');
    }

    /**
     * Create an assistant lecturer.
     */
    public function assistant(): static
    {
        return $this->withRank('assistant');
    }
}
