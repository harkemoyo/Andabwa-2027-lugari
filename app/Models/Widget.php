<?php

namespace App\Models;
use App\Events\WidgetsUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute; // Add this
use Illuminate\Support\Facades\Storage;           // Add this
use Illuminate\Support\Carbon;

class Widget extends Model
{
    protected $fillable = [
        'title',
        'position',
        'content',
        'is_active',
        'widget_image',
        'order',
        'weight',
        'variant',
        'url',
        'type',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    // REQUIRED: Ensures the accessor is available when Livewire converts the model to an array
    protected $appends = [
        'full_widget_image_path'
    ];

    // REQUIRED: Defines the missing accessor the Blade view is trying to call
    protected function fullWidgetImagePath(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->widget_image)) {
                    return null;
                }

                // If it's already a full URL (e.g., from an external source)
                if (filter_var($this->widget_image, FILTER_VALIDATE_URL)) {
                    return $this->widget_image;
                }

                // Use the public disk URL configuration for production compatibility
                return config('filesystems.disks.public.url') . '/' . $this->widget_image;
            }
        );
    }

    // ... [Keep all your existing booted methods, scopes, and relations below untouched] ...    

    protected static function booted(): void
    {
        static::saved(function () {
            event(new WidgetsUpdated());
        });
        static::deleted(function () {
            event(new WidgetsUpdated());
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (important for clean queries)
    |--------------------------------------------------------------------------
    */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeForPosition(Builder $query, string $position): Builder
    {
        return $query->where('position', $position);
    }

    public function scopeScheduled(Builder $query): Builder
    {
        $now = Carbon::now();

        return $query->where(function ($q) use ($now) {
            $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
        });
    }

    public function scopeVariant(Builder $query, ?string $variant): Builder
    {
        return $query->where(function ($q) use ($variant) {
            $q->whereNull('variant')
                ->orWhere('variant', $variant);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function impressions()
    {
        return $this->hasMany(WidgetImpression::class);
    }

    // WidgetClick model not yet implemented - commented out
    // public function clicks()
    // {
    //     return $this->hasMany(WidgetClick::class);
    // }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function recordImpression($sessionId = null, $ip = null)
    {
        $this->impressions()->create([
            'session_id' => $sessionId,
            'ip' => $ip,
        ]);

        $this->increment('impressions');
    }

    public function recordClick($sessionId = null, $ip = null)
    {
        $this->clicks()->create([
            'session_id' => $sessionId,
            'ip' => $ip,
        ]);

        $this->increment('clicks');
    }
}

