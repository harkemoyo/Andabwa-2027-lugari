<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetImpression extends Model
{
    public $timestamps = false;
    protected $fillable = ['widget_id', 'session_id', 'ip', 'viewed_at'];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public static function record(string $widgetId): void
    {
        // Use updateOrCreate to ignore duplicate key errors if the user refreshes
        static::updateOrCreate([
            'widget_id'  => $widgetId,
            'session_id' => session()->getId(),
            'ip'         => request()->ip(),
        ], [
            'viewed_at'  => now(),
        ]);
    }
}
