<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetClick extends Model
{
     public $timestamps = false;

    protected $fillable = [
        'widget_id',
        'session_id',
        'ip',
        'clicked_at',
    ];
}
