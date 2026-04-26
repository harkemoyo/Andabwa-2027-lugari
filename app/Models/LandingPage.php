<?php

namespace App\Models;

use App\Events\LandingPageUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LandingPage extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'subtitle', 'hero_image', 'content', 'cta_text', 'cta_link', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['full_hero_image_path'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate(); // Keeps slug intact
    }

    protected static function booted(): void
    {
        // ENGINEER FIX: Ensure listeners catch the change immediately
        static::saved(fn () => event(new LandingPageUpdated()));
        static::deleted(fn () => event(new LandingPageUpdated()));
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Register Media Collections
     * Engineer Standard: Use configured storage disk (R2 in production)
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_images')
            ->singleFile()
            ->useDisk(env('FILESYSTEM_DISK', 'public'));
    }

    /**
     * Register Media Conversions
     * Engineer Standard: Generate thumbnails for hero images
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
     * Engineer Standard: Resolved Hero Image Path (Same as Post model)
     * Priority: 1. Spatie Media -> 2. External URL -> 3. Legacy Column -> 4. Default
     */
    public function getFullHeroImagePathAttribute(): string
    {
        // 1. Check Spatie Media Library first (production-ready with R2)
        if ($this->hasMedia('hero_images')) {
            $media = $this->getFirstMedia('hero_images');
            return $media->getUrl();
        }

        // 2. Check if the legacy column contains a full URL
        if (!empty($this->hero_image) && Str::startsWith($this->hero_image, ['http'])) {
            return $this->hero_image;
        }

        // 3. Fallback to legacy relative path (using public disk)
        if (!empty($this->hero_image)) {
            return Storage::url($this->hero_image);
        }

        // 4. Default fallback
        return asset('images/default-hero.png');
    }
}

// use App\Events\LandingPageUpdated;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Builder;
// use Spatie\Sluggable\HasSlug;
// use Spatie\Sluggable\SlugOptions;
// use Illuminate\Support\Str;

// class LandingPage extends Model
// {
//     use HasFactory, HasSlug;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array<int, string>
//      */
//     protected $fillable = [
//         'title',
//         'slug',
//         'subtitle',
//         'hero_image',
//         'content',
//         'cta_text',
//         'cta_link',
//         'is_active',
//     ];

//     /**
//      * The attributes that should be cast.
//      *
//      * @var array<string, string>
//      */
//     protected $casts = [
//         'is_active' => 'boolean',
//     ];

//     protected $appends = [
//         'full_hero_image_path',
//     ];


//     /**
//      * Engineer Standard: Configure Spatie Sluggable
//      */
//     public function getSlugOptions(): SlugOptions
//     {
//         return SlugOptions::create()
//             ->generateSlugsFrom('title')
//             ->saveSlugsTo('slug')
//             ->doNotGenerateSlugsOnUpdate(); // CRITICAL: Prevents slug from changing when title is edited
//     }

//     protected static function booted(): void
//     {
//         static::saved(function () {
//             event(new LandingPageUpdated());
//         });
//         static::deleted(function () {
//             event(new LandingPageUpdated());
//         });
//     }

//     /**
//      * Scope a query to only include active landing pages.
//      */
//     public function scopeActive(Builder $query): Builder
//     {
//         return $query->where('is_active', true);
//     }

//     public function getFullHeroImagePathAttribute(): string
//     {
//         if (empty($this->hero_image)) {
//             return asset('images/default-hero.png');
//         }

//         if (Str::startsWith($this->hero_image, ['http'])) {
//             return $this->hero_image;
//         }

//         // Use the public disk URL configuration for production compatibility
//         return config('filesystems.disks.public.url') . '/' . $this->hero_image;
//     }
// }