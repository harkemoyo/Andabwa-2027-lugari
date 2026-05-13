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
        // Skip events during Filament saves for maximum speed
        if (request()->is('filament/*') || request()->is('admin/*')) {
            return;
        }

        // Only fire events if we aren't running in the terminal/console
        if (!app()->runningInConsole()) {
            static::created(function () {
                try {
                    event(new SidebarUpdated());
                } catch (\Exception $e) {
                    report($e);
                }
            });

            static::updated(function () {
                try {
                    event(new SidebarUpdated());
                } catch (\Exception $e) {
                    report($e);
                }
            });

            static::deleted(function () {
                try {
                    event(new SidebarUpdated());
                } catch (\Exception $e) {
                    report($e);
                }
            });
        }
    }
}
