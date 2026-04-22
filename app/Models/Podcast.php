<?php

namespace App\Models;

use App\Events\LandingPageUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Podcast extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'audio_url',
        'live_url',
        'cover_image',
        'duration_minutes',
        'scheduled_at',
        'is_published'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_published' => 'boolean',
        'full_cover_image_path',

    ];

    // Engineer Standard: Auto-slugging
    protected static function boot()
    {
        parent::boot();
        static::creating(fn($podcast) => $podcast->slug = Str::slug($podcast->title));
    }

    protected function isLiveNow(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->type === 'live' && $this->scheduled_at?->isPast()
        );
    }

    protected static function booted(): void
    {
        static::saved(function () {
            event(new LandingPageUpdated());
        });
        static::deleted(function () {
            event(new LandingPageUpdated());
        });
    }


    public function getFullCoverImagePathAttribute(): string
    {
        if (empty($this->cover_image)) {
            return asset('images/default-hero.png');
        }

        if (Str::startsWith($this->cover_image, ['http'])) {
            return $this->cover_image;
        }

        return Storage::url($this->cover_image);
    }
}
