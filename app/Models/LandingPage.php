<?php

namespace App\Models;

use App\Events\LandingPageUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandingPage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'hero_image',
        'content',
        'cta_text',
        'cta_link',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'full_hero_image_path',
    ];

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
     * Scope a query to only include active landing pages.
     */
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

        // Use the public disk URL configuration for production compatibility
        return config('filesystems.disks.public.url') . '/' . $this->hero_image;
    }
}