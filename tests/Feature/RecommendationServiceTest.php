<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ForumThread;
use App\Models\Tag;
use App\Models\UserTagPreference;
use App\Services\RecommendationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected RecommendationService $recommendationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->recommendationService = app(RecommendationService::class);
    }

    public function test_record_like_updates_user_preferences()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();
        $forumThread = ForumThread::factory()->create();
        $forumThread->tags()->attach($tag);

        $this->recommendationService->recordLike($user, $forumThread);

        $this->assertDatabaseHas('user_tag_preferences', [
            'user_id' => $user->id,
            'tag_id' => $tag->id,
            'like_score' => 10,
            'view_score' => 0,
            'total_score' => 20, // like_score * 2 + view_score
        ]);
    }

    public function test_record_view_updates_user_preferences()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();
        $forumThread = ForumThread::factory()->create();
        $forumThread->tags()->attach($tag);

        $this->recommendationService->recordView($user, $forumThread);

        $this->assertDatabaseHas('user_tag_preferences', [
            'user_id' => $user->id,
            'tag_id' => $tag->id,
            'like_score' => 0,
            'view_score' => 1,
            'total_score' => 1, // like_score * 2 + view_score
        ]);
    }

    public function test_get_recommended_threads_returns_threads_with_preferred_tags()
    {
        $user = User::factory()->create();
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();

        // Create preference for tag1
        UserTagPreference::factory()->create([
            'user_id' => $user->id,
            'tag_id' => $tag1->id,
            'total_score' => 10,
        ]);

        // Create threads with different tags
        $thread1 = ForumThread::factory()->create(['user_id' => User::factory()->create()->id]);
        $thread1->tags()->attach($tag1);

        $thread2 = ForumThread::factory()->create(['user_id' => User::factory()->create()->id]);
        $thread2->tags()->attach($tag2);

        $recommendedThreads = $this->recommendationService->getRecommendedThreads($user, 5);

        $this->assertTrue($recommendedThreads->contains($thread1));
        $this->assertFalse($recommendedThreads->contains($thread2));
    }

    public function test_get_user_top_tags_returns_ordered_tags()
    {
        $user = User::factory()->create();
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();

        UserTagPreference::factory()->create([
            'user_id' => $user->id,
            'tag_id' => $tag1->id,
            'total_score' => 5,
        ]);

        UserTagPreference::factory()->create([
            'user_id' => $user->id,
            'tag_id' => $tag2->id,
            'total_score' => 10,
        ]);

        $topTags = $this->recommendationService->getUserTopTags($user, 2);

        $this->assertEquals($tag2->id, $topTags->first()->id);
        $this->assertEquals($tag1->id, $topTags->last()->id);
    }
}
