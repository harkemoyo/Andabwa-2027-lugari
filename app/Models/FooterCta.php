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
        static::saved(fn () => event(new FooterUpdated()));
        static::deleted(fn () => event(new FooterUpdated()));
    }
}
