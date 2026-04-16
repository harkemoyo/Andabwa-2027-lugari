<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Events\MenuUpdated;
use Illuminate\Support\Facades\Log;

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

    public function children()
    {
        return $this->hasMany(NavigationItem::class, 'parent_id')
            ->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(NavigationItem::class, 'parent_id');
    }

    public function menu()
    {
        return $this->belongsTo(NavigationMenu::class, 'menu_id');
    }

    protected static function booted(): void
    {
        static::saved(function ($item) {
            Log::info('NavigationItem saved, dispatching MenuUpdated', ['id' => $item->id, 'title' => $item->title, 'is_breaking' => $item->is_breaking]);
            event(new MenuUpdated());
        });
        static::deleted(function ($item) {
            Log::info('NavigationItem deleted, dispatching MenuUpdated', ['id' => $item->id]);
            event(new MenuUpdated());
        });
    }
}