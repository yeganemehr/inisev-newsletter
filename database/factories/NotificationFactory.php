<?php

namespace Inisev\Newsletter\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Inisev\Newsletter\Models\Notification;
use Inisev\Newsletter\Models\Post;
use Inisev\Newsletter\Models\Subscriber;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    /**
     * @return array<string,mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'subscriber_id' => Subscriber::factory(),
        ];
    }

    public function withPost(int|Post|PostFactory $post): static
    {
        return $this->state(fn () => [
            'post_id' => $post,
        ]);
    }

    public function withSubscriber(int|Subscriber|SubscriberFactory $subscriber): static
    {
        return $this->state(fn () => [
            'subscriber_id' => $subscriber,
        ]);
    }
}
