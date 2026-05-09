<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\FooterUpdated;

class FooterInfo extends Model
{
    protected $fillable = [
        'company_name',
        'title',
        'description',
        'address',
        'phone',
        'email',
    ];

    protected static function booted(): void
    {
        // Skip events during Filament saves for maximum speed
        if (request()->is('filament/*') || request()->is('admin/*')) {
            return;
        }

        static::saved(function () {
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
