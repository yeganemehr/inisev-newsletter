<?php

namespace Inisev\Newsletter\Tests\Feature\Jobs;

use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Support\Facades\Queue;
use Inisev\Newsletter\Jobs\SendPostToSubscribers;
use Inisev\Newsletter\Models\Notification;
use Inisev\Newsletter\Models\Post;
use Inisev\Newsletter\Models\Subscriber;
use Inisev\Newsletter\Tests\TestCase;

class SendPostToSubscribersTest extends TestCase
{
    public function testSendingToAllSubscribers(): void
    {
        Queue::fake();

        $post = Post::factory()->create();
        Subscriber::factory(3)->withWebsite($post->website_id)->create();

        (new SendPostToSubscribers($post))->handle();

        Queue::assertPushed(SendQueuedNotifications::class, 3);

    }

    public function testSendingToSomeSubscribers(): void
    {
        Queue::fake();

        $post = Post::factory()->create();
        $sent = Subscriber::factory()->withWebsite($post->website_id)->create();
        Notification::factory()->withPost($post)->withSubscriber($sent)->create();

        Subscriber::factory(2)->withWebsite($post->website_id)->create();

        (new SendPostToSubscribers($post))->handle();

        Queue::assertPushed(SendQueuedNotifications::class, 2);

    }
}
