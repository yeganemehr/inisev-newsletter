<?php

namespace Inisev\Newsletter\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Queue\SerializesModels;
use Inisev\Newsletter\Models\Post;

class NewPost extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        #[WithoutRelations]
        public Post $post
    ) {
    }

    /**
     * @return string[]
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('New post is out!')
            ->salutation('')
            ->line($this->post->title)
            ->line($this->post->description)
            ->action('Read the article', $this->post->url);
    }
}
