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
use App\Jobs\GenerateSitemap;
use Stringable;

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
        'category_id' => 'integer',
        'external_url' => 'string',
        'published_at' => 'datetime',
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
            // Only queue sitemap regeneration for published posts
            // This prevents blocking on image/video uploads and edits
            if ($post->is_published && $post->wasChanged(['title', 'content', 'category_id', 'is_published'])) {
                dispatch(new GenerateSitemap())->delay(now()->addSeconds(5));
            }
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
        $this->addMediaCollection('featured')->useDisk(env('FILESYSTEM_DISK', 'public'));
    }

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        if ($media && $media->mime_type && str_starts_with($media->mime_type, 'image/')) {
            $this->addMediaConversion('thumb')
                ->width(300)
                ->height(300)
                ->sharpen(10)
                ->queued(); // Ensure conversions are queued for better performance
        }

        if ($media && $media->mime_type && str_starts_with($media->mime_type, 'video/')) {
            // Only add video conversion if FFmpeg is available
            if ($this->isFFmpegAvailable()) {
                $this->addMediaConversion('preview')
                    ->width(640)
                    ->height(360)
                    ->performOnCollections('featured')
                    ->queued(); // Ensure conversions are queued for better performance
            }
        }
    }

    /**
     * Check if FFmpeg/FFProbe is available on the system
     */
    private function isFFmpegAvailable(): bool
    {
        // Suppress error output and check if ffmpeg command works
        $output = @shell_exec('ffmpeg -version 2>&1');
        
        // If output contains version info, FFmpeg is available
        if ($output && str_contains($output, 'ffmpeg version')) {
            return true;
        }

        // Check Windows common paths
        $windowsPaths = [
            'C:\\ffmpeg\\bin\\ffmpeg.exe',
            'C:\\Program Files\\ffmpeg\\bin\\ffmpeg.exe',
            'C:\\ProgramData\\chocolatey\\bin\\ffmpeg.exe',
        ];

        foreach ($windowsPaths as $path) {
            if (file_exists($path)) {
                return true;
            }
        }

        return false;
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
        return route('posts.show', $this->slug);
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

    public function getYoutubeVideoIdAttribute(): ?string
    {
        if (!$this->external_url) {
            return null;
        }

        return $this->extractYoutubeId($this->external_url);
    }

    public function getYoutubeThumbnailUrlAttribute(): ?string
    {
        if (!$id = $this->youtube_video_id) {
            return null;
        }

        return "https://img.youtube.com/vi/{$id}/hqdefault.jpg";
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
