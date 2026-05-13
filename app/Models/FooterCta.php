<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\FooterUpdated;

class FooterCta extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_link',
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
                    event(new FooterUpdated());
                } catch (\Exception $e) {
                    report($e);
                }
            });

            static::updated(function () {
                try {
                    event(new FooterUpdated());
                } catch (\Exception $e) {
                    report($e);
                }
            });

            static::deleted(function () {
                try {
                    event(new FooterUpdated());
                } catch (\Exception $e) {
                    report($e);
                }
            });
        }
    }
}
