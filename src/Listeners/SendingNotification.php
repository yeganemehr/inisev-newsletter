<?php

namespace Inisev\Newsletter\Listeners;

use Illuminate\Notifications\Events\NotificationSending;
use Inisev\Newsletter\Models\Notification;
use Inisev\Newsletter\Notifications\NewPost;

class SendingNotification
{
    public function handle(NotificationSending $event): bool
    {
        if (!$event->notification instanceof NewPost) {
            return true;
        }

        $log = new Notification();
        $log->post_id = $event->notification->post->id;
        $log->subscriber_id = $event->notifiable->id;

        return $log->save();
    }
}
