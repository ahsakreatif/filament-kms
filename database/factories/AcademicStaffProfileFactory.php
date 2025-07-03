<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicStaffProfile>
 */
class AcademicStaffProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            'Dean', 'Associate Dean', 'Head of Department', 'Deputy Head of Department',
            'Program Coordinator', 'Academic Advisor', 'Research Coordinator',
            'Quality Assurance Officer', 'Student Affairs Officer', 'International Relations Officer',
            'Library Coordinator', 'IT Coordinator', 'Administrative Officer', 'Secretary'
        ];

        $responsibilities = [
            'Academic Planning and Development',
            'Student Affairs Management',
            'Research Coordination',
            'Quality Assurance',
            'International Relations',
            'Curriculum Development',
            'Faculty Development',
            'Student Counseling',
            'Administrative Support',
            'Budget Management',
            'Strategic Planning',
            'Accreditation Management'
        ];

        return [
            'user_id' => User::factory(),
            'academic_id' => $this->generateAcademicId(),
            'faculty_id' => Faculty::inRandomOrder()->first()?->id ?? 1,
            'position' => $this->faker->randomElement($positions),
            'office_location' => $this->faker->buildingNumber() . ' ' . $this->faker->streetName(),
            'responsibilities' => $this->generateResponsibilities($responsibilities),
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'inactive']), // Higher chance for active
        ];
    }

    /**
     * Generate a realistic academic staff ID.
     */
    private function generateAcademicId(): string
    {
        $prefix = 'ACAD';
        $year = $this->faker->numberBetween(2010, 2024);

        do {
            $randomNumber = $this->faker->numberBetween(1000, 99999);
            $suffix = $this->faker->numberBetween(10, 99);
            $academicId = $prefix . $year . $randomNumber . $suffix;
        } while (\App\Models\AcademicStaffProfile::where('academic_id', $academicId)->exists());

        return $academicId;
    }

    /**
     * Generate responsibilities as an array.
     */
    private function generateResponsibilities(array $responsibilities): array
    {
        $count = $this->faker->numberBetween(1, 4);
        return $this->faker->randomElements($responsibilities, $count);
    }

    /**
     * Indicate that the academic staff is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the academic staff is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the academic staff is retired.
     */
    public function retired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'retired',
        ]);
    }

    /**
     * Set the user for the academic staff profile.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Set the faculty for the academic staff profile.
     */
    public function forFaculty(Faculty $faculty): static
    {
        return $this->state(fn (array $attributes) => [
            'faculty_id' => $faculty->id,
        ]);
    }

    /**
     * Set a specific position.
     */
    public function withPosition(string $position): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => $position,
        ]);
    }

    /**
     * Create a dean.
     */
    public function dean(): static
    {
        return $this->withPosition('Dean');
    }

    /**
     * Create an associate dean.
     */
    public function associateDean(): static
    {
        return $this->withPosition('Associate Dean');
    }

    /**
     * Create a head of department.
     */
    public function headOfDepartment(): static
    {
        return $this->withPosition('Head of Department');
    }

    /**
     * Create a program coordinator.
     */
    public function programCoordinator(): static
    {
        return $this->withPosition('Program Coordinator');
    }

    /**
     * Create an academic advisor.
     */
    public function academicAdvisor(): static
    {
        return $this->withPosition('Academic Advisor');
    }
}
