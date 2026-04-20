<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetImpression extends Model
{
     public $timestamps = false;

    protected $fillable = [
        'widget_id',
        'session_id',
        'ip',
        'viewed_at',
    ];
}
