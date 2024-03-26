<?php

namespace Inisev\Newsletter\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Inisev\Newsletter\Models\Post;
use Inisev\Newsletter\Models\Subscriber;
use Inisev\Newsletter\Notifications\NewPost;

class SendPostToSubscribers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        #[WithoutRelations]
        public Post $post
    ) {
    }

    public function handle(): void
    {
        // Clear failed tries to send a notification for this post
        $this->post->notifications()
            ->whereNull('sent_at')
            ->where('created_at', '<', now()->subMinutes(1))
            ->delete();

        // Subscribers who we already sent/sending them an email.
        $sent = $this->post->notifications()->toBase()->select('subscriber_id');

        // Subscribers are not in the sent-list.
        $targets = $this->post->website->subscribers()->whereNotIn('id', $sent)->get();

        foreach ($targets as $target) {
            /**
             * @var Subscriber $target
             */
            $target->notify(new NewPost($this->post));
        }
    }
}
