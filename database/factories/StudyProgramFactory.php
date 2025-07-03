<?php

namespace Database\Factories;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudyProgram>
 */
class StudyProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $studyPrograms = [
            ['name' => 'Computer Science', 'code' => 'CS', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Information Technology', 'code' => 'IT', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Software Engineering', 'code' => 'SE', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Data Science', 'code' => 'DS', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Civil Engineering', 'code' => 'CE', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Mechanical Engineering', 'code' => 'ME', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Electrical Engineering', 'code' => 'EE', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Business Administration', 'code' => 'BA', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Economics', 'code' => 'ECON', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Accounting', 'code' => 'ACC', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Medicine', 'code' => 'MED', 'degree_level' => 'bachelor', 'duration_years' => 6],
            ['name' => 'Law', 'code' => 'LAW', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'English Literature', 'code' => 'EL', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Mathematics', 'code' => 'MATH', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Physics', 'code' => 'PHY', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Chemistry', 'code' => 'CHEM', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Biology', 'code' => 'BIO', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Education', 'code' => 'EDU', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Agriculture', 'code' => 'AGRI', 'degree_level' => 'bachelor', 'duration_years' => 4],
            ['name' => 'Architecture', 'code' => 'ARCH', 'degree_level' => 'bachelor', 'duration_years' => 5],
        ];

        $program = $this->faker->randomElement($studyPrograms);

        return [
            'name' => $program['name'],
            'code' => $program['code'],
            'faculty_id' => Faculty::factory(),
            'description' => $this->faker->paragraph(),
            'degree_level' => $program['degree_level'],
            'duration_years' => $program['duration_years'],
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }

    /**
     * Indicate that the study program is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the study program is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Set the faculty for the study program.
     */
    public function forFaculty(Faculty $faculty): static
    {
        return $this->state(fn (array $attributes) => [
            'faculty_id' => $faculty->id,
        ]);
    }
}
