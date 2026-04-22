<?php

namespace App\Models;

use App\Events\FooterUpdated;
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
        });
        static::deleted(function () {
            event(new FooterUpdated());
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

        return Storage::url($this->image_path);
    }

    // public function getFullImagePathAttribute(): string
    // {
    //     return Storage::url($this->image_path);
    // }

    public function getBrandColorAttribute(): string
    {
        return match (strtolower($this->platform_name)) {
            'facebook' => '#1877F2',
            'instagram' => '#E4405F',
            'x' => '#000000',
            'whatsapp' => '#25D366',
            'linkedin' => '#0A66C2',
            default => '#6B7280',
        };
    }
}
