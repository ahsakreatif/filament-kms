<?php

namespace Tests\Feature;

use App\Models\ForumThread;
use App\Models\ForumTopic;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForumThreadFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_forum_thread_factory_creates_valid_thread()
    {
        $thread = ForumThread::factory()->create();

        $this->assertDatabaseHas('forum_threads', [
            'id' => $thread->id,
            'title' => $thread->title,
            'body' => $thread->body,
        ]);

        $this->assertNotNull($thread->user);
        $this->assertNotNull($thread->topic);
        $this->assertNotNull($thread->category);
    }

    public function test_forum_thread_factory_creates_popular_thread()
    {
        $thread = ForumThread::factory()->popular()->create();

        $this->assertGreaterThanOrEqual(20, $thread->likes_count);
        $this->assertGreaterThanOrEqual(100, $thread->views_count);
    }

    public function test_forum_thread_factory_creates_fresh_thread()
    {
        $thread = ForumThread::factory()->fresh()->create();

        $this->assertLessThanOrEqual(5, $thread->likes_count);
        $this->assertLessThanOrEqual(20, $thread->views_count);
    }

    public function test_forum_thread_factory_creates_controversial_thread()
    {
        $thread = ForumThread::factory()->controversial()->create();

        $this->assertGreaterThanOrEqual(150, $thread->views_count);
        $this->assertLessThanOrEqual(15, $thread->likes_count);
    }

    public function test_forum_thread_factory_attaches_tags()
    {
        // Create some tags first
        Tag::factory()->count(5)->create();

        $thread = ForumThread::factory()->create();

        $this->assertGreaterThan(0, $thread->tags->count());
        $this->assertLessThanOrEqual(4, $thread->tags->count());
    }

    public function test_forum_topic_factory_creates_valid_topic()
    {
        $topic = ForumTopic::factory()->create();

        $this->assertDatabaseHas('forum_topics', [
            'id' => $topic->id,
            'name' => $topic->name,
            'slug' => $topic->slug,
        ]);
    }

    public function test_category_factory_creates_valid_category()
    {
        $category = Category::factory()->create();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
        ]);
    }

    public function test_tag_factory_creates_valid_tag()
    {
        $tag = Tag::factory()->create();

        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug,
        ]);
    }

    public function test_forum_thread_seeder_creates_data()
    {
        $this->artisan('db:seed', ['--class' => 'ForumThreadSeeder']);

        $this->assertGreaterThan(0, ForumThread::count());
        $this->assertGreaterThan(0, ForumTopic::count());
        $this->assertGreaterThan(0, Category::count());
        $this->assertGreaterThan(0, Tag::count());
        $this->assertGreaterThan(0, User::count());
    }
}
