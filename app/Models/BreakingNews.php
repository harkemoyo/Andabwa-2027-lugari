<?php

namespace App\Models;

use App\Events\BreakingNewsUpdated;
use Illuminate\Database\Eloquent\Model;
use App\Services\HeadlineAIService;


class BreakingNews extends Model
{
    protected $fillable = [
        'title',
        'url',
        'is_active',
        'is_live',
        'expires_at',
        'priority',
    ];

    public function scopeActive($query)
    {
        return $query
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }


    public function getDisplayTitleAttribute()
    {
        return $this->ai_title ?: $this->title;
    }


    public function updateScore()
    {
        $this->ai_score =
            ($this->views * 0.3) +
            ($this->clicks * 0.6) +
            ($this->is_urgent ? 100 : 0) +
            (now()->diffInMinutes($this->created_at) < 10 ? 50 : 0);

        $this->saveQuietly();
    }



    protected static function booted(): void
    {
        static::saved(fn() => broadcast(new BreakingNewsUpdated()));
        static::deleted(fn() => broadcast(new BreakingNewsUpdated()));
        static::saved(function ($item) {
            $item->updateScore();
        });
        static::created(function ($item) {
            dispatch(function () use ($item) {
                $ai = app(HeadlineAIService::class);

                $item->updateQuietly([
                    'original_title' => $item->title,
                    'ai_title' => $ai->rewrite($item->title),
                ]);
            });
        });
    }



    // protected static function booted(): void
    // {
    //     static::created(function ($item) {
    //         dispatch(function () use ($item) {
    //             $ai = app(HeadlineAIService::class);

    //             $item->updateQuietly([
    //                 'original_title' => $item->title,
    //                 'ai_title' => $ai->rewrite($item->title),
    //             ]);
    //         });
    //     });
    // }
}
