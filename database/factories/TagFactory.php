<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = [
            'Laravel' => 'Laravel framework discussions and tutorials',
            'PHP' => 'PHP programming language discussions',
            'JavaScript' => 'JavaScript programming and frameworks',
            'Vue.js' => 'Vue.js framework discussions',
            'React' => 'React library discussions',
            'Angular' => 'Angular framework discussions',
            'Node.js' => 'Node.js runtime environment',
            'MySQL' => 'MySQL database discussions',
            'PostgreSQL' => 'PostgreSQL database discussions',
            'MongoDB' => 'MongoDB NoSQL database',
            'Redis' => 'Redis caching and data store',
            'Docker' => 'Docker containerization',
            'AWS' => 'Amazon Web Services',
            'Azure' => 'Microsoft Azure cloud platform',
            'Google Cloud' => 'Google Cloud Platform',
            'Git' => 'Version control with Git',
            'GitHub' => 'GitHub platform discussions',
            'CI/CD' => 'Continuous Integration and Deployment',
            'Testing' => 'Software testing strategies',
            'Unit Testing' => 'Unit testing methodologies',
            'API' => 'Application Programming Interfaces',
            'REST' => 'RESTful API design',
            'GraphQL' => 'GraphQL query language',
            'Security' => 'Application security',
            'Authentication' => 'User authentication systems',
            'Authorization' => 'User authorization and permissions',
            'Performance' => 'Application performance optimization',
            'Caching' => 'Caching strategies and techniques',
            'SEO' => 'Search Engine Optimization',
            'Mobile' => 'Mobile application development',
            'PWA' => 'Progressive Web Applications',
            'TypeScript' => 'TypeScript programming language',
            'Python' => 'Python programming language',
            'Java' => 'Java programming language',
            'C#' => 'C# programming language',
            'Go' => 'Go programming language',
            'Rust' => 'Rust programming language',
            'Kubernetes' => 'Kubernetes container orchestration',
            'Terraform' => 'Infrastructure as Code with Terraform',
            'Ansible' => 'Configuration management with Ansible',
            'Jenkins' => 'CI/CD with Jenkins',
            'GitLab' => 'GitLab platform and CI/CD',
            'Bitbucket' => 'Bitbucket platform discussions',
            'Jira' => 'Project management with Jira',
            'Trello' => 'Project management with Trello',
            'Slack' => 'Team communication with Slack',
            'Discord' => 'Community communication with Discord',
            'WordPress' => 'WordPress CMS discussions',
            'Drupal' => 'Drupal CMS discussions',
            'Joomla' => 'Joomla CMS discussions',
            'Shopify' => 'E-commerce with Shopify',
            'WooCommerce' => 'E-commerce with WooCommerce',
            'Magento' => 'E-commerce with Magento',
            'Stripe' => 'Payment processing with Stripe',
            'PayPal' => 'Payment processing with PayPal',
            'Twilio' => 'Communication APIs with Twilio',
            'SendGrid' => 'Email services with SendGrid',
            'Mailgun' => 'Email services with Mailgun',
            'Algolia' => 'Search services with Algolia',
            'Elasticsearch' => 'Search and analytics with Elasticsearch',
            'Sentry' => 'Error tracking with Sentry',
            'LogRocket' => 'Session replay with LogRocket',
            'Mixpanel' => 'Analytics with Mixpanel',
            'Google Analytics' => 'Web analytics with Google Analytics',
            'Hotjar' => 'User behavior analytics with Hotjar',
            'Optimizely' => 'A/B testing with Optimizely',
            'VWO' => 'Conversion optimization with VWO',
            'Intercom' => 'Customer messaging with Intercom',
            'Zendesk' => 'Customer support with Zendesk',
            'Freshdesk' => 'Customer support with Freshdesk',
            'Help Scout' => 'Customer support with Help Scout',
            'Zapier' => 'Workflow automation with Zapier',
            'IFTTT' => 'Applet automation with IFTTT',
            'Make' => 'Workflow automation with Make',
            'Airtable' => 'Database and collaboration with Airtable',
            'Notion' => 'Workspace and documentation with Notion',
            'Figma' => 'Design and prototyping with Figma',
            'Sketch' => 'Design with Sketch',
            'Adobe XD' => 'Design with Adobe XD',
            'InVision' => 'Design collaboration with InVision',
            'Zeplin' => 'Design handoff with Zeplin',
            'Abstract' => 'Design version control with Abstract',
            'Lucidchart' => 'Diagramming with Lucidchart',
            'Draw.io' => 'Diagramming with Draw.io',
            'Miro' => 'Collaborative whiteboarding with Miro',
            'Mural' => 'Collaborative whiteboarding with Mural',
            'Whimsical' => 'Collaborative whiteboarding with Whimsical',
            'Loom' => 'Video messaging with Loom',
            'Camtasia' => 'Screen recording with Camtasia',
            'Screencast-O-Matic' => 'Screen recording with Screencast-O-Matic',
            'OBS Studio' => 'Screen recording with OBS Studio',
            'Canva' => 'Graphic design with Canva',
            'GIMP' => 'Image editing with GIMP',
            'Inkscape' => 'Vector graphics with Inkscape',
            'Blender' => '3D modeling with Blender',
            'Unity' => 'Game development with Unity',
            'Unreal Engine' => 'Game development with Unreal Engine',
            'Godot' => 'Game development with Godot',
            'Flutter' => 'Mobile development with Flutter',
            'React Native' => 'Mobile development with React Native',
            'Ionic' => 'Mobile development with Ionic',
            'Xamarin' => 'Mobile development with Xamarin',
            'Swift' => 'iOS development with Swift',
            'Kotlin' => 'Android development with Kotlin',
            'Objective-C' => 'iOS development with Objective-C',
            'Java Android' => 'Android development with Java',
        ];

        $tag = $this->faker->randomElement(array_keys($tags));
        $description = $tags[$tag];

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
            '#14B8A6', // Teal
            '#F43F5E', // Rose
            '#A855F7', // Violet
            '#06B6D4', // Sky
            '#84CC16', // Lime
        ];

        return [
            'name' => $tag,
            'slug' => Str::slug($tag),
            'description' => $description,
            'color' => $this->faker->randomElement($colors),
            'usage_count' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the tag is popular (high usage count).
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_count' => $this->faker->numberBetween(50, 200),
        ]);
    }

    /**
     * Indicate that the tag is new (low usage count).
     */
    public function fresh(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_count' => $this->faker->numberBetween(0, 10),
        ]);
    }

    /**
     * Indicate that the tag is for Laravel development.
     */
    public function laravel(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Laravel',
            'slug' => 'laravel',
            'description' => 'Laravel framework discussions and tutorials',
            'color' => '#FF2D20',
        ]);
    }

    /**
     * Indicate that the tag is for PHP development.
     */
    public function php(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'PHP',
            'slug' => 'php',
            'description' => 'PHP programming language discussions',
            'color' => '#777BB4',
        ]);
    }

    /**
     * Indicate that the tag is for JavaScript development.
     */
    public function javascript(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'JavaScript',
            'slug' => 'javascript',
            'description' => 'JavaScript programming and frameworks',
            'color' => '#F7DF1E',
        ]);
    }
}
