<?php

namespace App\Models;

use App\Events\SocialLinksUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SocialLink extends Model
{
    protected $fillable = [
        'platform_name',
        'url',
        'image_path',
        'is_active',
        'order',
    ];

    protected $appends = ['full_image_path'];


    protected static function booted(): void
{
    static::saved(function () {
        broadcast(new SocialLinksUpdated());
    });

    static::deleted(function () {
        broadcast(new SocialLinksUpdated());
    });
}

    public function getFullImagePathAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset('images/default-social.png');
        }

        if (Str::startsWith($this->image_path, ['http'])) {
            return $this->image_path;
        }

        // ✅ FIX: correct path for Filament uploads
        return asset('storage/' . $this->image_path);
    }
}