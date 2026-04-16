<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class NavigationMenu extends Model
{
    protected $fillable = ['name', 'slug', 'is_active', 'order'];

    protected static function booted(): void
    {
        static::saved(fn () => event(new \App\Events\MenuUpdated()));
        static::deleted(fn () => event(new \App\Events\MenuUpdated()));
    }

    // public function items(): HasMany
    // {
    //     return $this->hasMany(NavigationItem::class)->whereNull('parent_id')->orderBy('order');
    // }

    public function items()
    {
        return $this->hasMany(NavigationItem::class, 'menu_id')
            ->whereNull('parent_id')
            ->orderBy('order');
    }
}
