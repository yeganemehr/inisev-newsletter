<?php

namespace Inisev\Newsletter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Inisev\Newsletter\Database\Factories\SubscriberFactory;

class Subscriber extends Model
{
    public static function newFactory(): SubscriberFactory
    {
        return SubscriberFactory::new();
    }

    use HasFactory, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'website_id',
        'email',
        'name',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function routeNotificationForMail(Notification $notification): array|string
    {
        return [$this->email => $this->name];
    }
}
