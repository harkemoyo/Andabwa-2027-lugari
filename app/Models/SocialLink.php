<?php

namespace App\Models;

use App\Events\FooterUpdated;
use App\Events\SocialLinksUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    protected $appends = ['full_image_path', 'brand_color'];

    protected static function booted(): void
    {
        static::saved(function () {
            event(new FooterUpdated());
            event(new SocialLinksUpdated());
        });
        static::deleted(function () {
            event(new FooterUpdated());
            event(new SocialLinksUpdated());
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

        // Use the public disk URL configuration for production compatibility
        return config('filesystems.disks.public.url') . '/' . $this->image_path;
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
