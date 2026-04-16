<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedAsset extends Model
{
    protected $fillable = [
        'owner_id',
        'owner_type',
        'type',
        'prompt',
        'result_text',
        'image_url',
        'image_path',
        'input_path',
        'status',
        'error',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    public function owner()
    {
        return $this->morphTo();
    }
}
