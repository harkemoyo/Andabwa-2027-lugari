<?php

namespace App\Models;

use App\Events\LandingPageUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RadioChannels extends Model implements HasMedia
{
    use InteractsWithMedia;
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


    /**
     * Register Media Collections
     * Engineer Standard: Use configured storage disk (R2 in production)
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover_images')
            ->singleFile()
            ->useDisk(env('FILESYSTEM_DISK', 'public'));
    }

    /**
     * Register Media Conversions
     * Engineer Standard: Generate thumbnails for cover images
     */
    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        if ($media && $media->mime_type && str_starts_with($media->mime_type, 'image/')) {
            $this->addMediaConversion('thumb')
                ->width(400)
                ->height(300)
                ->sharpen(10)
                ->nonQueued();
        }
    }

    /**
     * Engineer Standard: Resolved Cover Image Path (Same as Post model)
     * Priority: 1. Spatie Media -> 2. External URL -> 3. Legacy Column -> 4. Default
     */
    public function getFullCoverImagePathAttribute(): string
    {
        // 1. Check Spatie Media Library first (production-ready with R2)
        if ($this->hasMedia('cover_images')) {
            $media = $this->getFirstMedia('cover_images');
            return $media->getUrl();
        }

        // 2. Check if the legacy column contains a full URL
        if (!empty($this->cover_image) && Str::startsWith($this->cover_image, ['http'])) {
            return $this->cover_image;
        }

        // 3. Fallback to legacy relative path (using public disk)
        if (!empty($this->cover_image)) {
            return Storage::url($this->cover_image);
        }

        // 4. Default fallback
        return asset('images/default-hero.png');
    }
}
