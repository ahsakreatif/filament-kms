<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faculty>
 */
class FacultyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faculties = [
            ['name' => 'Faculty of Engineering', 'code' => 'FE'],
            ['name' => 'Faculty of Computer Science', 'code' => 'FCS'],
            ['name' => 'Faculty of Business and Economics', 'code' => 'FBE'],
            ['name' => 'Faculty of Medicine', 'code' => 'FM'],
            ['name' => 'Faculty of Law', 'code' => 'FL'],
            ['name' => 'Faculty of Arts and Humanities', 'code' => 'FAH'],
            ['name' => 'Faculty of Science', 'code' => 'FS'],
            ['name' => 'Faculty of Education', 'code' => 'FED'],
            ['name' => 'Faculty of Agriculture', 'code' => 'FA'],
            ['name' => 'Faculty of Architecture', 'code' => 'FAR'],
        ];

        $faculty = $this->faker->randomElement($faculties);

        return [
            'name' => $faculty['name'],
            'code' => $faculty['code'],
            'description' => $this->faker->paragraph(),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }

    /**
     * Indicate that the faculty is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the faculty is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
