<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\MenuUpdated;

class NavigationItem extends Model
{
    protected $fillable = [
        'menu_id',
        'title',
        'slug',
        'url',
        'label',
        'parent_id',
        'order',
        'is_active',
        'target',
        'link_url',
        'breaking',
        'elite',
        'experience',
        'live'
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_breaking' => 'boolean',
        'is_live'     => 'boolean',
        'expires_at'  => 'datetime',
    ];

    /* ---------------- RELATIONSHIPS ---------------- */

    public function menu()
    {
        return $this->belongsTo(NavigationMenu::class, 'menu_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    // CRITICAL (fixes nested UI breaking)
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /* ---------------- REALTIME ---------------- */

    protected static function booted(): void
    {
        static::saved(function () {
            try {
                event(new MenuUpdated());
            } catch (\Exception $e) {
                report($e);
            }
        });

        static::deleted(function () {
            try {
                event(new MenuUpdated());
            } catch (\Exception $e) {
                report($e);
            }
        });
    }
}