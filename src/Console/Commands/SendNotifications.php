<?php

namespace Inisev\Newsletter\Console\Commands;

use Illuminate\Console\Command;
use Inisev\Newsletter\Jobs\SendPostToSubscribers;
use Inisev\Newsletter\Models\Post;

class SendNotifications extends Command
{
    /**
     * @var string
     */
    protected $signature = 'notifications:send';

    /**
     * @var string
     */
    protected $description = 'Sends all subscribers updates';

    public function handle()
    {
        Post::query()->get()->each(function (Post $post) {
            SendPostToSubscribers::dispatchSync($post);
        });
    }
}
