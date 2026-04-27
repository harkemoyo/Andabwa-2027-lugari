<?php

namespace App\Models;

use App\Events\WidgetsUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Widget extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title', 'position', 'content', 'is_active', 'widget_image',
        'order', 'weight', 'variant', 'url', 'type', 'starts_at', 'ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'order'     => 'integer',
        'weight'    => 'integer',
    ];

    // Mirroring RadioChannels appends
    protected $appends = ['full_widget_image_path'];

    /**
     * Register Media Collections
     * Matches RadioChannels logic
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('widget_images')
            ->singleFile()
            ->useDisk(env('FILESYSTEM_DISK', 'public'));
    }

    /**
     * Register Media Conversions
     */
    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        if ($media && $media->mime_type && str_starts_with($media->mime_type, 'image/')) {
            $this->addMediaConversion('thumb')
                ->width(300)
                ->height(300)
                ->sharpen(10)
                ->nonQueued();
        }
    }

    /**
     * Logic copied from RadioChannels getFullCoverImagePathAttribute
     * Priority: 1. Spatie -> 2. HTTP URL -> 3. Local Storage -> 4. Default
     */
    public function getFullWidgetImagePathAttribute(): string
    {
        // 1. Check Spatie Media Library first
        if ($this->hasMedia('widget_images')) {
            $media = $this->getFirstMedia('widget_images');
            return $media->getUrl();
        }

        // 2. Check if the legacy column contains a full URL
        if (!empty($this->widget_image) && Str::startsWith($this->widget_image, ['http'])) {
            return $this->widget_image;
        }

        // 3. Fallback to legacy relative path (Using Storage::url like RadioChannels)
        if (!empty($this->widget_image)) {
            return Storage::url($this->widget_image);
        }

        // 4. Default fallback
        return asset('images/default-hero.png');
    }

    protected static function booted(): void
    {
        static::saved(fn() => event(new WidgetsUpdated()));
        static::deleted(fn() => event(new WidgetsUpdated()));
    }

    public function scopeActive(Builder $query): Builder { return $query->where('is_active', true); }
    public function scopeForPosition(Builder $query, string $pos): Builder { return $query->where('position', $pos); }
    public function scopeScheduled(Builder $query): Builder
    {
        $now = Carbon::now();
        return $query->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now))
                     ->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now));
    }
}