<?php

namespace App\Models;

use App\Events\WidgetsUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Widget extends Model
{
    protected $fillable = [
        'title', 'position', 'content', 'is_active',
        'widget_image', 'order', 'weight', 'variant',
        'url', 'type', 'starts_at', 'ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'order'     => 'integer',
        'weight'    => 'integer',
    ];

    protected $appends = ['full_widget_image_path'];

    protected function fullWidgetImagePath(): Attribute
    {
        return Attribute::make(
            get: fn () => empty($this->widget_image) 
                ? null 
                : (filter_var($this->widget_image, FILTER_VALIDATE_URL) 
                    ? $this->widget_image 
                    : asset('storage/' . $this->widget_image))
        );
    }

    protected static function booted(): void
    {
        // Use dispatching for better compatibility with observers
        static::saved(fn () => event(new WidgetsUpdated()));
        static::deleted(fn () => event(new WidgetsUpdated()));
    }

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
}






// // namespace App\Models;

// use App\Events\WidgetsUpdated;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\Casts\Attribute;
// use Illuminate\Support\Carbon;

// class Widget extends Model
// {
//     protected $fillable = [
//         'title', 'position', 'content', 'is_active',
//         'widget_image', 'order', 'weight', 'variant',
//         'url', 'type', 'starts_at', 'ends_at',
//     ];

//     protected $casts = [
//         'is_active' => 'boolean',
//         'starts_at' => 'datetime',
//         'ends_at'   => 'datetime',
//     ];

//     protected $appends = [
//         'full_widget_image_path'
//     ];

//     protected function fullWidgetImagePath(): Attribute
//     {
//         return Attribute::make(
//             get: function () {
//                 if (empty($this->widget_image)) {
//                     return null;
//                 }

//                 if (filter_var($this->widget_image, FILTER_VALIDATE_URL)) {
//                     return $this->widget_image;
//                 }

//                 return config('filesystems.disks.public.url') . '/' . $this->widget_image;
//             }
//         );
//     }

//     protected static function booted(): void
//     {
//         static::saved(fn () => event(new WidgetsUpdated()));
//         static::deleted(fn () => event(new WidgetsUpdated()));
//     }

//     // --- Scopes ---
    
//     public function scopeActive(Builder $query): Builder
//     {
//         return $query->where('is_active', true);
//     }

//     public function scopeForPosition(Builder $query, string $position): Builder
//     {
//         return $query->where('position', $position);
//     }

//     public function scopeScheduled(Builder $query): Builder
//     {
//         $now = Carbon::now();

//         return $query->where(function ($q) use ($now) {
//             $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
//         })->where(function ($q) use ($now) {
//             $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
//         });
//     }

//     public function scopeVariant(Builder $query, ?string $variant): Builder
//     {
//         return $query->where(function ($q) use ($variant) {
//             $q->whereNull('variant')->orWhere('variant', $variant);
//         });
//     }

//     // --- Relations & Helpers ---

//     public function impressions()
//     {
//         return $this->hasMany(WidgetImpression::class);
//     }

//     public function recordImpression($sessionId = null, $ip = null)
//     {
//         $this->impressions()->create([
//             'session_id' => $sessionId,
//             'ip' => $ip,
//         ]);

//         $this->increment('impressions');
//     }
// }

