<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Programming' => 'General programming discussions and tutorials',
            'Web Development' => 'Web development topics and discussions',
            'Mobile Development' => 'Mobile app development discussions',
            'Database' => 'Database design, optimization, and management',
            'DevOps' => 'DevOps practices, deployment, and infrastructure',
            'Design' => 'UI/UX design and frontend development',
            'Testing' => 'Testing strategies and quality assurance',
            'Security' => 'Application security and best practices',
            'Performance' => 'Performance optimization and monitoring',
            'Tools' => 'Development tools and utilities',
            'Career' => 'Career advice and professional development',
            'Learning' => 'Educational resources and tutorials',
            'News' => 'Latest industry news and updates',
            'Community' => 'Community discussions and events',
            'Help' => 'Help and support for developers',
        ];

        $category = $this->faker->randomElement(array_keys($categories));
        $description = $categories[$category];

        $colors = [
            '#3B82F6', // Blue
            '#10B981', // Green
            '#F59E0B', // Yellow
            '#EF4444', // Red
            '#8B5CF6', // Purple
            '#06B6D4', // Cyan
            '#F97316', // Orange
            '#EC4899', // Pink
            '#84CC16', // Lime
            '#6366F1', // Indigo
        ];

        $icons = [
            'fas fa-code',
            'fas fa-globe',
            'fas fa-mobile-alt',
            'fas fa-database',
            'fas fa-server',
            'fas fa-palette',
            'fas fa-vial',
            'fas fa-shield-alt',
            'fas fa-tachometer-alt',
            'fas fa-tools',
            'fas fa-briefcase',
            'fas fa-graduation-cap',
            'fas fa-newspaper',
            'fas fa-users',
            'fas fa-question-circle',
        ];

        return [
            'name' => $category,
            'slug' => Str::slug($category),
            'description' => $description,
            'parent_id' => null,
            'icon' => $this->faker->randomElement($icons),
            'color' => $this->faker->randomElement($colors),
            'is_active' => true,
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }

    /**
     * Indicate that the category is a parent category.
     */
    public function parent(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => null,
        ]);
    }

    /**
     * Indicate that the category is a child category.
     */
    public function child(Category $parent = null): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => $parent ? $parent->id : Category::factory()->parent(),
        ]);
    }

    /**
     * Indicate that the category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Category $category) {
            // If this is a parent category, create some child categories
            if (!$category->parent_id && $this->faker->boolean(30)) {
                Category::factory()
                    ->count($this->faker->numberBetween(2, 5))
                    ->child($category)
                    ->create();
            }
        });
    }
}
