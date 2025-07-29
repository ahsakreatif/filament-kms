<?php

namespace Database\Factories;

use App\Models\ForumTopic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ForumTopic>
 */
class ForumTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ForumTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $topics = [
            'Laravel Development' => 'Discussions about Laravel framework development, best practices, and tips.',
            'PHP Programming' => 'General PHP programming discussions, language features, and development tips.',
            'Frontend Development' => 'Discussions about HTML, CSS, JavaScript, and frontend frameworks.',
            'Database Design' => 'Database design, optimization, and management discussions.',
            'DevOps & Deployment' => 'Discussions about deployment, server management, and DevOps practices.',
            'Testing & Quality Assurance' => 'Testing strategies, tools, and quality assurance practices.',
            'Security' => 'Web application security, best practices, and vulnerability discussions.',
            'Performance Optimization' => 'Application performance, caching, and optimization techniques.',
            'API Development' => 'RESTful APIs, GraphQL, and API design discussions.',
            'Mobile Development' => 'Mobile app development with web technologies.',
            'UI/UX Design' => 'User interface and user experience design discussions.',
            'Project Management' => 'Agile methodologies, project planning, and team collaboration.',
            'Career & Learning' => 'Career advice, learning resources, and professional development.',
            'Tools & Libraries' => 'Development tools, libraries, and third-party integrations.',
            'Troubleshooting' => 'Help with debugging, error resolution, and technical issues.',
        ];

        $topic = $this->faker->randomElement(array_keys($topics));
        $description = $topics[$topic];

        return [
            'name' => $topic,
            'slug' => Str::slug($topic),
            'description' => $description,
            'thumbnail' => $this->faker->imageUrl(400, 300, 'technology', true),
        ];
    }

    /**
     * Indicate that the topic is for Laravel development.
     */
    public function laravel(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Laravel Development',
            'slug' => 'laravel-development',
            'description' => 'Discussions about Laravel framework development, best practices, and tips.',
        ]);
    }

    /**
     * Indicate that the topic is for PHP programming.
     */
    public function php(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'PHP Programming',
            'slug' => 'php-programming',
            'description' => 'General PHP programming discussions, language features, and development tips.',
        ]);
    }

    /**
     * Indicate that the topic is for frontend development.
     */
    public function frontend(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Frontend Development',
            'slug' => 'frontend-development',
            'description' => 'Discussions about HTML, CSS, JavaScript, and frontend frameworks.',
        ]);
    }
}
