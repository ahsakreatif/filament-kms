<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing categories and tags
        $categories = Category::all();
        $tags = Tag::all();
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('No users found. Please run user seeders first.');
            return;
        }

        $documents = [
            [
                'title' => 'Introduction to Machine Learning Algorithms',
                'description' => 'A comprehensive guide to fundamental machine learning algorithms including supervised and unsupervised learning methods.',
                'abstract' => 'This paper provides an overview of essential machine learning algorithms, their applications, and implementation considerations.',
                'author' => 'Dr. Sarah Johnson',
                'keywords' => 'machine learning, algorithms, supervised learning, unsupervised learning',
                'publication_year' => 2023,
                'doi' => '10.1000/example.2023.001',
                'category_name' => 'Computer Science',
                'tags' => ['Machine Learning', 'Research', 'Programming', 'Graduate'],
                'file_path' => 'documents/ml-algorithms-guide.pdf',
                'file_name' => 'ml-algorithms-guide.pdf',
                'file_size' => 2048576,
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Sustainable Development in Urban Planning',
                'description' => 'Research on implementing sustainable development principles in modern urban planning and design.',
                'abstract' => 'This study examines the integration of sustainability principles in urban development projects.',
                'author' => 'Prof. Michael Chen',
                'keywords' => 'sustainability, urban planning, development, environment',
                'publication_year' => 2023,
                'doi' => '10.1000/example.2023.002',
                'category_name' => 'Environmental Science',
                'tags' => ['Sustainability', 'Research', 'Case Study', 'Graduate'],
                'file_path' => 'documents/sustainable-urban-planning.pdf',
                'file_name' => 'sustainable-urban-planning.pdf',
                'file_size' => 1536000,
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Advanced Database Management Systems',
                'description' => 'Comprehensive tutorial on advanced database concepts including distributed databases and NoSQL systems.',
                'abstract' => 'This tutorial covers advanced database management concepts for modern applications.',
                'author' => 'Dr. Emily Rodriguez',
                'keywords' => 'database, distributed systems, NoSQL, management',
                'publication_year' => 2023,
                'doi' => '10.1000/example.2023.003',
                'category_name' => 'Computer Science',
                'tags' => ['Database', 'Tutorial', 'Programming', 'Professional'],
                'file_path' => 'documents/advanced-database-systems.pdf',
                'file_name' => 'advanced-database-systems.pdf',
                'file_size' => 3072000,
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Quantitative Analysis in Social Sciences',
                'description' => 'Methodological approaches to quantitative research in sociology and psychology.',
                'abstract' => 'This paper discusses quantitative research methodologies in social science disciplines.',
                'author' => 'Dr. James Wilson',
                'keywords' => 'quantitative research, social sciences, methodology, statistics',
                'publication_year' => 2023,
                'doi' => '10.1000/example.2023.004',
                'category_name' => 'Social Sciences',
                'tags' => ['Quantitative', 'Research', 'Survey', 'PhD'],
                'file_path' => 'documents/quantitative-social-sciences.pdf',
                'file_name' => 'quantitative-social-sciences.pdf',
                'file_size' => 1792000,
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Modern Web Development with React',
                'description' => 'Complete guide to building modern web applications using React framework and best practices.',
                'abstract' => 'This tutorial provides a comprehensive introduction to React web development.',
                'author' => 'Alex Thompson',
                'keywords' => 'web development, React, JavaScript, frontend',
                'publication_year' => 2023,
                'doi' => '10.1000/example.2023.005',
                'category_name' => 'Computer Science',
                'tags' => ['Web Development', 'Programming', 'Tutorial', 'Undergraduate'],
                'file_path' => 'documents/react-web-development.pdf',
                'file_name' => 'react-web-development.pdf',
                'file_size' => 2560000,
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Healthcare Innovation in Digital Age',
                'description' => 'Analysis of digital transformation in healthcare systems and patient care delivery.',
                'abstract' => 'This research examines the impact of digital technologies on healthcare delivery.',
                'author' => 'Dr. Lisa Park',
                'keywords' => 'healthcare, digital innovation, patient care, technology',
                'publication_year' => 2023,
                'doi' => '10.1000/example.2023.006',
                'category_name' => 'Medicine & Health',
                'tags' => ['Healthcare', 'Innovation', 'Research', 'Professional'],
                'file_path' => 'documents/healthcare-digital-innovation.pdf',
                'file_name' => 'healthcare-digital-innovation.pdf',
                'file_size' => 2048000,
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Business Strategy in Global Markets',
                'description' => 'Case studies and analysis of business strategies for international market expansion.',
                'abstract' => 'This study explores business strategies for global market penetration.',
                'author' => 'Prof. David Kim',
                'keywords' => 'business strategy, global markets, international business, management',
                'publication_year' => 2023,
                'doi' => '10.1000/example.2023.007',
                'category_name' => 'Business & Management',
                'tags' => ['Business', 'Case Study', 'Research', 'Graduate'],
                'file_path' => 'documents/business-global-strategy.pdf',
                'file_name' => 'business-global-strategy.pdf',
                'file_size' => 2304000,
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Mathematical Foundations of Cryptography',
                'description' => 'Advanced mathematical concepts underlying modern cryptographic systems and security.',
                'abstract' => 'This paper explores the mathematical foundations of cryptographic algorithms.',
                'author' => 'Dr. Robert Martinez',
                'keywords' => 'cryptography, mathematics, security, algorithms',
                'publication_year' => 2023,
                'doi' => '10.1000/example.2023.008',
                'category_name' => 'Mathematics',
                'tags' => ['Research', 'Programming', 'PhD', 'English'],
                'file_path' => 'documents/cryptography-mathematics.pdf',
                'file_name' => 'cryptography-mathematics.pdf',
                'file_size' => 2816000,
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Educational Technology Integration',
                'description' => 'Research on effective integration of technology in educational settings and learning outcomes.',
                'abstract' => 'This study examines the impact of technology integration in educational environments.',
                'author' => 'Dr. Maria Santos',
                'keywords' => 'education, technology, learning, pedagogy',
                'publication_year' => 2023,
                'doi' => '10.1000/example.2023.009',
                'category_name' => 'Education',
                'tags' => ['Education', 'Research', 'Innovation', 'Graduate'],
                'file_path' => 'documents/educational-technology.pdf',
                'file_name' => 'educational-technology.pdf',
                'file_size' => 1920000,
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Experimental Physics: Quantum Mechanics',
                'description' => 'Laboratory experiments and theoretical analysis in quantum mechanics and particle physics.',
                'abstract' => 'This research presents experimental findings in quantum mechanics.',
                'author' => 'Dr. Thomas Anderson',
                'keywords' => 'physics, quantum mechanics, experimental, particles',
                'publication_year' => 2023,
                'doi' => '10.1000/example.2023.010',
                'category_name' => 'Physics',
                'tags' => ['Experimental', 'Research', 'PhD', 'English'],
                'file_path' => 'documents/quantum-mechanics-physics.pdf',
                'file_name' => 'quantum-mechanics-physics.pdf',
                'file_size' => 3584000,
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
            ],
        ];

        foreach ($documents as $documentData) {
            // Find the category
            $category = $categories->where('name', $documentData['category_name'])->first();
            if (!$category) {
                $this->command->warn("Category '{$documentData['category_name']}' not found, skipping document.");
                continue;
            }

            // Create the document
            $document = Document::create([
                'title' => $documentData['title'],
                'slug' => Str::slug($documentData['title']),
                'description' => $documentData['description'],
                'abstract' => $documentData['abstract'],
                'file_path' => $documentData['file_path'],
                'file_name' => $documentData['file_name'],
                'file_size' => $documentData['file_size'],
                'file_type' => $documentData['file_type'],
                'mime_type' => $documentData['mime_type'],
                'category_id' => $category->id,
                'uploaded_by' => $users->random()->id,
                'author' => $documentData['author'],
                'keywords' => $documentData['keywords'],
                'publication_year' => $documentData['publication_year'],
                'doi' => $documentData['doi'],
                'language' => 'en',
                'is_public' => true,
                'is_featured' => rand(0, 1),
                'download_count' => rand(0, 50),
                'view_count' => rand(10, 200),
                'status' => 'published',
                'approved_by' => $users->random()->id,
                'approved_at' => now(),
            ]);

            // Attach tags
            $tagIds = [];
            foreach ($documentData['tags'] as $tagName) {
                $tag = $tags->where('name', $tagName)->first();
                if ($tag) {
                    $tagIds[] = $tag->id;
                }
            }

            if (!empty($tagIds)) {
                $document->tags()->attach($tagIds);

                // Update usage count for tags
                foreach ($tagIds as $tagId) {
                    $tag = Tag::find($tagId);
                    $tag->increment('usage_count');
                }
            }
        }

        $this->command->info('Documents seeded successfully!');
    }
}
