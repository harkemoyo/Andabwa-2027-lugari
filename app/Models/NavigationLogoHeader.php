<?php

namespace App\Models;

use App\Events\FooterUpdates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Events\FooterUpdated;
use Illuminate\Support\Facades\Storage;

class NavigationLogoHeader extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'logo_path',
        'link',
    ];

    protected static function booted(): void
    {
        static::saved(function () {
            // This will now broadcast instantly to the 'ui-updates' channel
            event(new FooterUpdates());
        });

        static::deleted(function () {
            event(new FooterUpdates());
        });
    }

    protected $appends = [
        'full_logo_path',
        'full_link_url',
    ];

    /**
     * Register Media Collections
     * Engineer Standard: Use configured storage disk (R2 in production)
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('navigation_logos')
            ->singleFile()
            ->useDisk(env('FILESYSTEM_DISK', 'public'));
    }

    /**
     * Register Media Conversions
     * Engineer Standard: Generate thumbnails for logos
     */
    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        if ($media && $media->mime_type && str_starts_with($media->mime_type, 'image/')) {
            $this->addMediaConversion('thumb')
                ->width(150)
                ->height(50)
                ->sharpen(10)
                ->nonQueued();
        }
    }

    /**
     * Engineer Standard: Resolved Logo Path (Same as Post model)
     * Priority: 1. Spatie Media -> 2. External URL -> 3. Legacy Column -> 4. Default
     */
    public function getFullLogoPathAttribute(): string
    {
        // 1. Check Spatie Media Library first (production-ready with R2)
        if ($this->hasMedia('navigation_logos')) {
            $media = $this->getFirstMedia('navigation_logos');
            return $media->getUrl();
        }

        // 2. Check if the legacy column contains a full URL
        if (!empty($this->logo_path) && Str::startsWith($this->logo_path, ['http'])) {
            return $this->logo_path;
        }

        // 3. Fallback to legacy relative path (using public disk)
        if (!empty($this->logo_path)) {
            return Storage::url($this->logo_path);
        }

        // 4. Default fallback
        return asset('images/default-logo.png');
    }

    /**
     * Accessor: Get the full link URL.
     */
    public function getFullLinkUrlAttribute(): ?string
    {
        $link = $this->link;

        if (!$link) {
            return null;
        }

        // Already valid
        if (Str::startsWith($link, ['http://', 'https://'])) {
            return $link;
        }

        // Internal path
        return url($link);
    }

    /**
     * Mutator: Ensure valid protocol for link.
     */
    public function setLinkAttribute($value): void
    {
        if (!empty($value) && !Str::startsWith($value, ['http://', 'https://'])) {
            $this->attributes['link'] = 'https://' . $value;
        } else {
            $this->attributes['link'] = $value;
        }
    }
}
