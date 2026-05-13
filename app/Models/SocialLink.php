<?php

namespace App\Models;

use App\Events\FooterUpdated;
use App\Events\SocialLinksUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SocialLink extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'platform_name',
        'url',
        'image_path',
        'is_active',
        'order',
    ];

    protected $appends = ['full_image_path', 'brand_color'];

    protected static function booted(): void
    {
        // Skip events during Filament saves for maximum speed
        if (request()->is('filament/*') || request()->is('admin/*')) {
            return;
        }

        static::saved(function () {
            try {
                event(new FooterUpdated());
                event(new SocialLinksUpdated());
            } catch (\Exception $e) {
                report($e);
            }
        });

        static::deleted(function () {
            try {
                event(new FooterUpdated());
                event(new SocialLinksUpdated());
            } catch (\Exception $e) {
                report($e);
            }
        });
    }

    /**
     * Register Media Collections
     * Engineer Standard: Use configured storage disk (R2 in production)
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('social_icons')
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
                ->width(64)
                ->height(64)
                ->sharpen(10)
                ->queued();
        }
    }

    /**
     * Engineer Standard: Resolved Image Path
     * Priority: 1. Spatie Media -> 2. External URL -> 3. Legacy Column -> 4. Default
     */
    public function getFullImagePathAttribute(): string
    {
        // 1. Check Spatie Media Library first (production-ready with R2)
        if ($this->hasMedia('social_icons')) {
            return $this->getFirstMediaUrl('social_icons');
        }

        // 2. Check if the legacy column contains a full URL
        if (!empty($this->image_path) && Str::startsWith($this->image_path, ['http'])) {
            return $this->image_path;
        }

        // 3. Fallback to legacy relative path (using public disk)
        if (!empty($this->image_path)) {
            return config('filesystems.disks.public.url') . '/' . $this->image_path;
        }

        // 4. Default fallback
        return asset('images/default-social.png');
    }

    public function getBrandColorAttribute(): string
    {
        return match (strtolower($this->platform_name)) {
            'facebook' => '#1877F2',
            'instagram' => '#f04f6c',
            'x' => '#1f1d1d',
            'whatsapp' => '#58f792',
            'linkedin' => '#5aa4ee',
            default => '#6B7280',
        };
    }
}
