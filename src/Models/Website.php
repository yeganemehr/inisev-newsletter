<?php

namespace Inisev\Newsletter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Inisev\Newsletter\Database\Factories\WebsiteFactory;

class Website extends Model
{
    public static function newFactory(): WebsiteFactory
    {
        return WebsiteFactory::new();
    }

    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'domain',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscriber::class);
    }
}
