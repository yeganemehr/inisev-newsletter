<?php

namespace Inisev\Newsletter\Tests\Feature\Http\Controllers;

use Illuminate\Support\Facades\Queue;
use Inisev\Newsletter\Jobs\SendPostToSubscribers;
use Inisev\Newsletter\Models\Notification;
use Inisev\Newsletter\Models\Post;
use Inisev\Newsletter\Models\Subscriber;
use Inisev\Newsletter\Models\Website;
use Inisev\Newsletter\Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function testList(): void
    {
        $website = Website::factory()->create();
        Post::factory(5)->withWebsite($website)->create();

        $response = $this->getJson(route('websites.posts.index', ['website' => $website->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'website_id',
                        'local_id',
                        'title',
                        'description',
                        'url',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta' => [
                    'path',
                    'per_page',
                    'next_cursor',
                    'prev_cursor',
                ],
                'links' => [
                    'first',
                    'last',
                    'next',
                    'prev',
                ],
            ]);
        $this->assertCount(5, $response['data']);
    }

    public function testStore(): void
    {
        Queue::fake();

        $website = Website::factory()->create();

        $data = [
            'local_id' => fake()->uuid(),
            'title' => fake()->words(asText: true),
            'description' => fake()->sentences(asText: true),
            'url' => fake()->url(),
        ];
        $this->postJson(route('websites.posts.store', ['website' => $website->id]), $data)
            ->assertCreated()
            ->assertJson([
                'data' => $data,
            ]);

        Queue::assertPushed(SendPostToSubscribers::class);
    }

    public function testDuplicateStore(): void
    {
        $post = Post::factory()->create();

        $this->postJson(route('websites.posts.store', ['website' => $post->website_id]), [
            'local_id' => $post->local_id,
            'title' => fake()->words(asText: true),
            'description' => fake()->sentences(asText: true),
            'url' => fake()->url(),
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('local_id');
    }

    public function testShow(): void
    {
        $post = Post::factory()->create();

        $this->getJson(route('websites.posts.show', ['website' => $post->website_id, 'post' => $post->id]))
            ->assertOk()
            ->assertJson([
                'data' => [
                    'website_id' => $post->website_id,
                    'local_id' => $post->local_id,
                    'title' => $post->title,
                    'description' => $post->description,
                    'url' => $post->url,
                ],
            ]);
    }

    public function testUpdateWithoutResending(): void
    {
        Queue::fake();

        $post = Post::factory()->create();

        $this->putJson(route('websites.posts.update', ['website' => $post->website_id, 'post' => $post->id]), [
            'title' => 'New Project',
            'resend' => false,
        ])
            ->assertOk()
            ->assertJson([
                'data' => [
                    'title' => 'New Project',
                ],
            ]);

        Queue::assertNothingPushed();
    }

    public function testUpdateWithResending(): void
    {
        Queue::fake();

        $post = Post::factory()->create();
        $subscriber = Subscriber::factory()->withWebsite($post->website_id)->create();
        $notification = Notification::factory()->withPost($post)->withSubscriber($subscriber)->create();

        $this->putJson(route('websites.posts.update', ['website' => $post->website_id, 'post' => $post->id]), [
            'title' => 'New Project',
            'resend' => true,
        ])
            ->assertOk()
            ->assertJson([
                'data' => [
                    'title' => 'New Project',
                ],
            ]);

        $this->assertDatabaseMissing($notification, ['id' => $notification->id]);

        Queue::assertPushed(SendPostToSubscribers::class);
    }

    public function testDestroy(): void
    {
        $post = Post::factory()->create();

        $this->deleteJson(route('websites.posts.destroy', ['website' => $post->website_id, 'post' => $post->id]))
            ->assertNoContent();
        $this->assertDatabaseMissing($post, ['id' => $post->id]);
    }
}
