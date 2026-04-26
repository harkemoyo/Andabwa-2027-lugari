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
     */
    // public function registerMediaCollections(): void
    // {
    //     // Use the default disk (which you configured as R2 earlier)
    //     $this->addMediaCollection('widget_images')
    //         ->singleFile() // Widgets usually only need one image
    //         ->useDisk(config('filesystems.default'));
    // }

    /**
     * Engineer Standard: Resolved Image Path
     * Priority: 1. Spatie Media -> 2. External URL -> 3. Legacy Column -> 4. Null
     */
    // protected function fullWidgetImagePath(): Attribute
    // {
    //     return Attribute::make(
    //         get: function () {
    //             // 1. Check Spatie Media Library first
    //             if ($this->hasMedia('widget_images')) {
    //                 return $this->getFirstMediaUrl('widget_images');
    //             }

    //             // 2. Check if the legacy column contains a full URL
    //             if (filter_var($this->widget_image, FILTER_VALIDATE_URL)) {
    //                 return $this->widget_image;
    //             }

    //             // 3. Fallback to legacy relative path (using default storage)
    //             if ($this->widget_image) {
    //                 return Storage::url($this->widget_image);
    //             }

    //             return null;
    //         }
    //     );
    // }

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



    // 1. Match the collection name here
public function registerMediaCollections(): void
{
    $this->addMediaCollection('widget_images') // <--- Keep this consistent
        ->singleFile();
}

// 2. And match it here in the attribute
protected function fullWidgetImagePath(): Attribute
{
    return Attribute::make(
        get: function () {
            // Check Spatie first using the SAME name
            if ($this->hasMedia('widget_images')) { 
                return $this->getFirstMediaUrl('widget_images');
            }

            // Fallback logic...
            if (filter_var($this->widget_image, FILTER_VALIDATE_URL)) {
                return $this->widget_image;
            }

            return $this->widget_image ? Storage::url($this->widget_image) : null;
        }
    );
}
}