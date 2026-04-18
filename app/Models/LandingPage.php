<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'title', 'slug', 'subtitle', 'hero_image', 
        'content', 'cta_text', 'cta_link', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
