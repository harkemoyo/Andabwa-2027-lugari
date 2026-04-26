<?php

namespace App\Models;

use App\Events\WidgetsUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
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

    protected $appends = ['full_widget_image_path'];

    /**
     * Register Media Collections
     * Engineer Standard: Use configured storage disk (R2 in production)
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('widget_images')
            ->singleFile()
            ->useDisk(env('FILESYSTEM_DISK', 'public'));
    }

    /**
     * Register Media Conversions
     * Engineer Standard: Generate thumbnails for images
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
     * Engineer Standard: Resolved Image Path
     * Priority: 1. Spatie Media -> 2. External URL -> 3. Legacy Column -> 4. Null
     */
    protected function fullWidgetImagePath(): Attribute
    {
        return Attribute::make(
            get: function () {
                // 1. Check Spatie Media Library first (production-ready with R2)
                if ($this->hasMedia('widget_images')) {
                    return $this->getFirstMediaUrl('widget_images');
                }

                // 2. Check if the legacy column contains a full URL
                if (filter_var($this->widget_image, FILTER_VALIDATE_URL)) {
                    return $this->widget_image;
                }

                // 3. Fallback to legacy relative path (using public disk)
                if ($this->widget_image) {
                    return config('filesystems.disks.public.url') . '/' . $this->widget_image;
                }

                return null;
            }
        );
    }

    protected static function booted(): void
    {
        static::saved(fn() => event(new WidgetsUpdated()));
        static::deleted(fn() => event(new WidgetsUpdated()));
    }

    // Scopes...
    public function scopeActive(Builder $query): Builder { return $query->where('is_active', true); }
    public function scopeForPosition(Builder $query, string $pos): Builder { return $query->where('position', $pos); }
    public function scopeScheduled(Builder $query): Builder
    {
        $now = Carbon::now();
        return $query->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now))
                     ->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now));
    }
}