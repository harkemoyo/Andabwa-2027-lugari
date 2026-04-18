<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\MenusUpdated;

class NavigationMenu extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /* ---------------- RELATIONSHIPS ---------------- */

    public function items()
    {
        return $this->hasMany(NavigationItem::class, 'menu_id')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    // 🔥 REQUIRED FOR UI TREE
    public function itemsRecursive()
    {
        return $this->items()->with('childrenRecursive');
    }

    /* ---------------- REALTIME ---------------- */

    protected static function booted(): void
    {
        static::saved(function ($menu) {
            broadcast(new MenusUpdated([
                'menu_id' => $menu->id
            ]))->toOthers();
        });

        static::deleted(function ($menu) {
            broadcast(new MenusUpdated([
                'menu_id' => $menu->id,
                'deleted' => true
            ]))->toOthers();
        });
    }
}