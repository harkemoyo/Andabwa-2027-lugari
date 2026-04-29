<?php

namespace App\Models;

use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Stream extends Model
{
    use HasUuids, HasSlug, BroadcastsEvents;

    protected $fillable = [
        'title', 'slug', 'description', 'status', 'started_at', 'ended_at', 'user_id'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function broadcastOn(string $event): array
    {
        return [new PresenceChannel("stream.{$this->id}")];
    }
}







