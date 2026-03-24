<?php

// app/Models/Post.php
namespace App\Models;


use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Artisan;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory, HasSlug;

    protected $guarded = [];

    protected $casts = [
        'media_type' => \App\Enums\MediaType::class,
        'link_preview_data' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'meta_title' => 'string',
        'meta_description' => 'string',
    ];


    protected static function booted(): void
    {
        static::creating(function ($post) {
            if (!$post->slug) {
                // Generate slug and append a shorter, cleaner random string
                $post->slug = Str::slug($post->title) . '-' . Str::lower(Str::random(5));
            }
        });

        static::saved(function ($post) {
            // Use a background task if possible so the Admin/UI doesn't lag
            // This triggers the sitemap generation without making the user wait
            dispatch(function () {
                Artisan::call('sitemap:generate');
            })->afterResponse();
        });
    }

    /**
     * Scope to auto-load media and common relationships
     */
    public function scopeWithMedia($query)
    {
        return $query->with(['media', 'category', 'tags']);
    }

    /**
     * Get the featured image URL from Spatie Media Library.
     * Fallback to the link preview image if no local file exists.
     */
    public function getFeaturedImageAttribute(): string
    {
        // 1. Check Spatie first (The "How")
        if ($this->hasMedia('featured')) {
            return $this->getFirstMediaUrl('featured');
        }

        // 2. Fallback to scraped image from LinkPreviewService
        if (!empty($this->link_preview_data['image'])) {
            return $this->link_preview_data['image'];
        }

        // 3. Absolute Fallback
        return asset('images/placeholder.jpg');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')->useDisk('public');
    }


    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }


    public function getSitemapUrl(): string
    {
        return route('blog.show', $this->slug);
    }



    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }


    protected function readTime(): Attribute
    {
        return Attribute::get(function () {
            $words = str_word_count(strip_tags($this->content));
            $minutes = ceil($words / 200);

            return $minutes . ' min read';
        });
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$this->external_url) {
            return null;
        }

        if (!str_contains($this->external_url, 'youtube')) {
            return null;
        }

        parse_str(parse_url($this->external_url, PHP_URL_QUERY), $params);

        $id = $params['v'] ?? null;

        return $id
            ? "https://www.youtube.com/embed/{$id}"
            : null;
    }



    public function getResolvedMediaAttribute(): array
    {
        // 1️⃣ Uploaded media (highest priority)
        if ($this->hasMedia('featured')) {
            $media = $this->getFirstMedia('featured');

            return [
                'type' => Str::startsWith($media->mime_type, 'video') ? 'video' : 'image',
                'url'  => $media->getUrl(),
            ];
        }

        // 2️⃣ External URL (YouTube / Vimeo / External Articles)
        if ($this->external_url) {
            if ($youtube = $this->extractYoutubeId($this->external_url)) {
                return [
                    'type'      => 'youtube',
                    'embed_url' => "https://www.youtube.com/embed/{$youtube}",
                    'thumbnail' => "https://img.youtube.com/vi/{$youtube}/hqdefault.jpg",
                ];
            }

            if ($vimeo = $this->extractVimeoId($this->external_url)) {
                return [
                    'type'      => 'vimeo',
                    'embed_url' => "https://player.vimeo.com/video/{$vimeo}",
                ];
            }

            // For external articles and links
            return [
                'type' => 'link',
                'url'  => $this->external_url,
                'image' => $this->link_preview_data['image'] ?? null,
            ];
        }

        // 3️⃣ Fallback
        return [
            'type' => 'placeholder',
            'url'  => asset('images/placeholder.jpg'),
        ];
    }


    private function extractYoutubeId(string $url): ?string
    {
        preg_match('/(youtu\.be\/|youtube\.com.*v=)([^&]+)/', $url, $matches);
        return $matches[2] ?? null;
    }

    private function extractVimeoId(string $url): ?string
    {
        preg_match('/vimeo\.com\/(\d+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    public function getYoutubeDurationAttribute(): ?string
    {
        if (!$this->external_url) return null;

        if (!$id = $this->extractYoutubeId($this->external_url)) {
            return null;
        }

        $video = Youtube::getVideoInfo($id);

        return $video->contentDetails->duration ?? null;
    }

    // Optional: Helper to get the featured image URL
    public function getFeaturedImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('featured');
    }
}
