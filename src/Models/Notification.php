<?php

namespace Inisev\Newsletter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Inisev\Newsletter\Database\Factories\NotificationFactory;

class Notification extends Model
{
    const UPDATED_AT = null;

    public static function newFactory(): NotificationFactory
    {
        return NotificationFactory::new();
    }

    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'post_id',
        'subscriber_id',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }
}
