<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Events\FooterUpdated;

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
            event(new FooterUpdated());
        });

        static::deleted(function () {
            event(new FooterUpdated());
        });
    }

    protected $appends = [
        'full_logo_path',
        'full_link_url',
    ];

    /**
     * Accessor: Get the full logo URL.
     */

    public function getFullLogoPathAttribute(): ?string
    {
        // Fallback to simple logic if no media found
        if (empty($this->logo_path)) {
            return null;
        }

        // If it's already a full URL, update it to current port and return it
        if (Str::startsWith($this->logo_path, ['http'])) {
            return asset($this->logo_path);
        }

        // Always use asset() for dynamic routes - works in both development and production
        return asset('storage/' . $this->logo_path);
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
