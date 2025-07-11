<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Computer Science',
                'description' => 'Documents related to computer science, programming, algorithms, and software engineering',
                'icon' => 'heroicon-o-computer-desktop',
                'color' => '#3B82F6',
                'sort_order' => 1,
            ],
            [
                'name' => 'Mathematics',
                'description' => 'Mathematical research, theorems, proofs, and mathematical concepts',
                'icon' => 'heroicon-o-calculator',
                'color' => '#EF4444',
                'sort_order' => 2,
            ],
            [
                'name' => 'Physics',
                'description' => 'Physics research papers, experiments, and theoretical physics',
                'icon' => 'heroicon-o-beaker', // Changed from atom which doesn't exist
                'color' => '#8B5CF6',
                'sort_order' => 3,
            ],
            [
                'name' => 'Engineering',
                'description' => 'Engineering projects, technical specifications, and engineering research',
                'icon' => 'heroicon-o-wrench', // Changed from wrench-screwdriver which doesn't exist
                'color' => '#F59E0B',
                'sort_order' => 4,
            ],
            [
                'name' => 'Business & Management',
                'description' => 'Business strategies, management theories, and case studies',
                'icon' => 'heroicon-o-building-office',
                'color' => '#10B981',
                'sort_order' => 5,
            ],
            [
                'name' => 'Medicine & Health',
                'description' => 'Medical research, health studies, and clinical documentation',
                'icon' => 'heroicon-o-heart',
                'color' => '#EC4899',
                'sort_order' => 6,
            ],
            [
                'name' => 'Literature & Arts',
                'description' => 'Literary works, artistic research, and cultural studies',
                'icon' => 'heroicon-o-book-open',
                'color' => '#06B6D4',
                'sort_order' => 7,
            ],
            [
                'name' => 'Social Sciences',
                'description' => 'Sociology, psychology, anthropology, and social research',
                'icon' => 'heroicon-o-users',
                'color' => '#84CC16',
                'sort_order' => 8,
            ],
            [
                'name' => 'Environmental Science',
                'description' => 'Environmental research, sustainability studies, and climate science',
                'icon' => 'heroicon-o-globe-americas', // Changed from leaf which doesn't exist
                'color' => '#22C55E',
                'sort_order' => 9,
            ],
            [
                'name' => 'Education',
                'description' => 'Educational materials, teaching resources, and pedagogical research',
                'icon' => 'heroicon-o-academic-cap',
                'color' => '#F97316',
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'icon' => $categoryData['icon'],
                'color' => $categoryData['color'],
                'sort_order' => $categoryData['sort_order'],
                'is_active' => true,
            ]);
        }
    }
}
