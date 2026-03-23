<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class BlogPageSetting extends Model
{
    protected $guarded = []; // Allow all fields to be mass-assigned

    protected static function booted()
    {
        static::updated(function ($setting) {
            // Dispatch event to refresh the feed component
            Event::dispatch('settings-updated', $setting);
        });

        static::created(function ($setting) {
            // Dispatch event to refresh the feed component
            Event::dispatch('settings-updated', $setting);
        });
    }
}