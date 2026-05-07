<?php

namespace App\Models;

use App\Events\SidebarUpdated;
use Illuminate\Database\Eloquent\Model;

class SidebarWidget extends Model
{
    protected $fillable = [
        'title',
        'content',
        'position',
        'url',
        'is_active',
        'order',
    ];


    protected static function booted(): void
    {
        // Only fire events if we aren't running in the terminal/console
        if (!app()->runningInConsole()) {
            static::created(fn() => event(new SidebarUpdated()));
            static::updated(fn() => event(new SidebarUpdated()));
            static::deleted(fn() => event(new SidebarUpdated()));
        }
    }
}
