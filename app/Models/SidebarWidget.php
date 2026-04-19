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
    'is_active',
    'order',
];


    protected static function booted(): void
    {
        static::created(fn() => event(new SidebarUpdated()));
        static::updated(fn() => event(new SidebarUpdated()));
        static::deleted(fn() => event(new SidebarUpdated()));

        
    }
}
