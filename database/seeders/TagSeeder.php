<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // Academic Subjects
            ['name' => 'Research', 'description' => 'Research papers and studies', 'color' => '#3B82F6'],
            ['name' => 'Thesis', 'description' => 'Student thesis and dissertations', 'color' => '#EF4444'],
            ['name' => 'Journal Article', 'description' => 'Published journal articles', 'color' => '#10B981'],
            ['name' => 'Conference Paper', 'description' => 'Conference proceedings and papers', 'color' => '#F59E0B'],
            ['name' => 'Review', 'description' => 'Literature reviews and systematic reviews', 'color' => '#8B5CF6'],

            // Technology & Computer Science
            ['name' => 'Programming', 'description' => 'Programming and coding related content', 'color' => '#06B6D4'],
            ['name' => 'Machine Learning', 'description' => 'Machine learning and AI content', 'color' => '#EC4899'],
            ['name' => 'Data Science', 'description' => 'Data analysis and data science', 'color' => '#84CC16'],
            ['name' => 'Web Development', 'description' => 'Web development and design', 'color' => '#F97316'],
            ['name' => 'Database', 'description' => 'Database systems and management', 'color' => '#22C55E'],

            // Research Types
            ['name' => 'Qualitative', 'description' => 'Qualitative research methods', 'color' => '#6366F1'],
            ['name' => 'Quantitative', 'description' => 'Quantitative research methods', 'color' => '#A855F7'],
            ['name' => 'Experimental', 'description' => 'Experimental research and studies', 'color' => '#EAB308'],
            ['name' => 'Case Study', 'description' => 'Case study research', 'color' => '#14B8A6'],
            ['name' => 'Survey', 'description' => 'Survey research and questionnaires', 'color' => '#F43F5E'],

            // Document Types
            ['name' => 'Tutorial', 'description' => 'Tutorial and how-to guides', 'color' => '#0EA5E9'],
            ['name' => 'Presentation', 'description' => 'Presentations and slides', 'color' => '#8B5A2B'],
            ['name' => 'Manual', 'description' => 'User manuals and documentation', 'color' => '#64748B'],
            ['name' => 'Report', 'description' => 'Technical reports and documentation', 'color' => '#475569'],
            ['name' => 'Book', 'description' => 'Books and book chapters', 'color' => '#1E293B'],

            // Popular Topics
            ['name' => 'Sustainability', 'description' => 'Environmental sustainability', 'color' => '#16A34A'],
            ['name' => 'Innovation', 'description' => 'Innovation and creativity', 'color' => '#DC2626'],
            ['name' => 'Education', 'description' => 'Educational content and pedagogy', 'color' => '#7C3AED'],
            ['name' => 'Healthcare', 'description' => 'Healthcare and medical content', 'color' => '#059669'],
            ['name' => 'Business', 'description' => 'Business and management content', 'color' => '#D97706'],

            // Academic Levels
            ['name' => 'Undergraduate', 'description' => 'Undergraduate level content', 'color' => '#2563EB'],
            ['name' => 'Graduate', 'description' => 'Graduate level content', 'color' => '#7C2D12'],
            ['name' => 'PhD', 'description' => 'PhD level research', 'color' => '#BE123C'],
            ['name' => 'Professional', 'description' => 'Professional development content', 'color' => '#854D0E'],

            // Languages
            ['name' => 'English', 'description' => 'Content in English', 'color' => '#1F2937'],
            ['name' => 'Indonesian', 'description' => 'Content in Indonesian', 'color' => '#DC2626'],
            ['name' => 'Multilingual', 'description' => 'Content in multiple languages', 'color' => '#059669'],
        ];

        foreach ($tags as $tagData) {
            Tag::create([
                'name' => $tagData['name'],
                'slug' => Str::slug($tagData['name']),
                'description' => $tagData['description'],
                'color' => $tagData['color'],
                'usage_count' => 0,
            ]);
        }
    }
}
