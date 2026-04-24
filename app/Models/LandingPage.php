<?php

namespace App\Models;

use App\Events\LandingPageUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class LandingPage extends Model
{
    use HasFactory, HasSlug;

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

    public function getFullHeroImagePathAttribute(): string
    {
        if (empty($this->hero_image)) {
            return asset('images/default-hero.png');
        }
        if (Str::startsWith($this->hero_image, ['http'])) {
            return $this->hero_image;
        }
        return config('filesystems.disks.public.url') . '/' . $this->hero_image;
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