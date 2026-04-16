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
        static::saved(fn () => event(new FooterUpdated()));
        static::deleted(fn () => event(new FooterUpdated()));
    }
}
