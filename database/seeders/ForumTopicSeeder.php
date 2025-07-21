<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ForumTopic;

class ForumTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $svgIcons = [
            'https://www.svgrepo.com/show/530226/camera.svg',
            'https://www.svgrepo.com/show/530232/card-holder.svg',
            'https://www.svgrepo.com/show/530236/location.svg',
            'https://www.svgrepo.com/show/530229/monitor.svg',
            'https://www.svgrepo.com/show/530244/article.svg',
            'https://www.svgrepo.com/show/530248/picture.svg'
        ];

        $topics = [
            [
                'name' => 'General Discussion',
                'slug' => 'general-discussion',
                'description' => 'Talk about anything related to the community.',
            ],
            [
                'name' => 'Announcements',
                'slug' => 'announcements',
                'description' => 'Official news and updates.',
            ],
            [
                'name' => 'Support',
                'slug' => 'support',
                'description' => 'Get help and support from the community.',
            ],
            [
                'name' => 'Questions',
                'slug' => 'questions',
                'description' => 'Ask questions and get answers from the community.',
            ],
            [
                'name' => 'Info',
                'slug' => 'info',
                'description' => 'Get information about the community.',
            ],
            [
                'name' => 'Events',
                'slug' => 'events',
                'description' => 'Announcements and updates about events.',
            ]
        ];

        $now = now();
        $data = [];
        foreach ($topics as $i => $topic) {
            $data[] = [
                'name' => $topic['name'],
                'slug' => $topic['slug'],
                'description' => $topic['description'],
                'thumbnail' => $svgIcons[$i],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        ForumTopic::insert($data);
    }
}
