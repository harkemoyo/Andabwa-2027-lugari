<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Widget extends Model
{
    protected $fillable = [
        'title',
        'position',
        'content',
        'is_active',
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

    public function clicks()
    {
        return $this->hasMany(WidgetClick::class);
    }

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
