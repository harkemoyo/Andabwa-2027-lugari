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
        'title',
        'position',
        'content',
        'is_active',
        'widget_image',
        'order',
        'weight',
        'variant',
        'url',
        'type',
        'starts_at',
        'ends_at',
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
                ->queued();
        }
    }

    /**
     * Override the accessor to pull the image from Spatie Media Library
     * instead of the database column.
     */
    

    public function getFullWidgetImagePathAttribute()
    {
        if ($this->hasMedia('widget_images')) {
            return $this->getFirstMediaUrl('widget_images');
        }
        return $this->widget_image ? asset('storage/' . $this->widget_image) : null;
    }
   

    protected static function booted(): void
    {
        static::saved(function () {
            try {
                event(new WidgetsUpdated());
            } catch (\Exception $e) {
                report($e);
            }
        });

        static::deleted(function () {
            try {
                event(new WidgetsUpdated());
            } catch (\Exception $e) {
                report($e);
            }
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
    public function scopeForPosition(Builder $query, string $pos): Builder
    {
        return $query->where('position', $pos);
    }
    public function scopeScheduled(Builder $query): Builder
    {
        $now = Carbon::now();
        return $query->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now))
            ->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now));
    }
}
