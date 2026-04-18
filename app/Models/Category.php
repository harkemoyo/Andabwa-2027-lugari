<?php 
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;


class Category extends Model
{
    use HasSlug,HasFactory, BroadcastsEvents; 

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'is_active',
        'sort_order',
    ];
    

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate(); // Optional: keeps URLs stable even if name changes
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }


    // Broadcast on the channel Livewire is listening to
    public function broadcastOn($event): array
    {
        return [new Channel('categories')];
    }

    // Match the event name Livewire expects
    public function broadcastAs($event): string
    {
        return 'category.updated';
    }
}
