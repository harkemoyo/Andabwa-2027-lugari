<?php

// app/Models/Post.php

namespace App\Models;

use App\Enums\MediaType;
use App\Jobs\GenerateSitemap;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'media_type'        => MediaType::class,
        'link_preview_data' => 'array',
        'is_featured'       => 'boolean',
        'is_published'      => 'boolean',
        'meta_title'        => 'string',
        'meta_description'  => 'string',
        'category_id'       => 'integer',
        'external_url'      => 'string',
        'published_at'      => 'datetime',
    ];

    /**
     * Boot model events
     */
    protected static function booted(): void
    {
        static::creating(function (Post $post): void {

            if (blank($post->slug)) {
                $post->slug = Str::slug($post->title)
                    . '-'
                    . Str::lower(Str::random(5));
            }
        });

        static::saved(function (Post $post): void {

            if (
                $post->is_published &&
                $post->wasChanged([
                    'title',
                    'content',
                    'category_id',
                    'is_published',
                ])
            ) {
                GenerateSitemap::dispatch()
                    ->delay(now()->addSeconds(5));
            }

            // Clear media-related cache
            Cache::forget("post-media-{$post->id}");
        });
    }

    /**
     * Optimized reusable eager loading scope
     */
    public function scopeWithMedia(Builder $query): Builder
    {
        return $query->with([
            'category:id,name,color',
            'tags:id,name',
            'media',
        ]);
    }

    /**
     * Category relationship
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Tags relationship
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Slug configuration
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Sitemap URL
     */
    public function getSitemapUrl(): string
    {
        return route('posts.show', $this->slug);
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')
            ->useDisk(env('FILESYSTEM_DISK', 'public'));
    }

    /**
     * Register media conversions
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        if (!$media?->mime_type) {
            return;
        }

        if (Str::startsWith($media->mime_type, 'image/')) {

            $this->addMediaConversion('thumb')
                ->width(300)
                ->height(300)
                ->sharpen(10)
                ->queued();
        }

        if (
            Str::startsWith($media->mime_type, 'video/') &&
            $this->isFFmpegAvailable()
        ) {
            $this->addMediaConversion('preview')
                ->width(640)
                ->height(360)
                ->performOnCollections('featured')
                ->queued();
        }
    }

    /**
     * Cached FFmpeg availability check
     */
    private function isFFmpegAvailable(): bool
    {
        return Cache::rememberForever('ffmpeg-availability', function () {

            $output = @shell_exec('ffmpeg -version 2>&1');

            if ($output && str_contains($output, 'ffmpeg version')) {
                return true;
            }

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
        });
    }

    /**
     * Featured image accessor
     */
    public function getFeaturedImageAttribute(): string
    {
        if ($this->hasMedia('featured')) {
            return $this->getFirstMediaUrl('featured');
        }

        if (!empty($this->link_preview_data['image'])) {
            return $this->link_preview_data['image'];
        }

        return asset('images/placeholder.jpg');
    }

    /**
     * Featured image URL accessor
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('featured');
    }

    /**
     * Read time accessor
     */
    protected function readTime(): Attribute
    {
        return Attribute::get(function (): string {

            $words = str_word_count(strip_tags($this->content ?? ''));

            return ceil($words / 200) . ' min read';
        });
    }

    /**
     * YouTube embed URL
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$id = $this->youtube_video_id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$id}";
    }

    /**
     * YouTube video ID
     */
    public function getYoutubeVideoIdAttribute(): ?string
    {
        if (!$this->external_url) {
            return null;
        }

        return $this->extractYoutubeId($this->external_url);
    }

    /**
     * YouTube thumbnail
     */
    public function getYoutubeThumbnailUrlAttribute(): ?string
    {
        if (!$id = $this->youtube_video_id) {
            return null;
        }

        return "https://img.youtube.com/vi/{$id}/hqdefault.jpg";
    }

    /**
     * YouTube duration
     */
    public function getYoutubeDurationAttribute(): ?string
    {
        if (!$id = $this->youtube_video_id) {
            return null;
        }

        try {

            $video = Youtube::getVideoInfo($id);

            return $video->contentDetails->duration ?? null;

        } catch (\Throwable $e) {

            report($e);

            return null;
        }
    }

    /**
     * Unified media resolver
     */
    public function getResolvedMediaAttribute(): array
    {
        return Cache::remember(
            "post-media-{$this->id}",
            now()->addMinutes(30),
            function () {

                // Uploaded media
                if ($this->hasMedia('featured')) {

                    $media = $this->getFirstMedia('featured');

                    return [
                        'type' => Str::startsWith(
                            $media->mime_type,
                            'video'
                        ) ? 'video' : 'image',

                        'url' => $media->getUrl(),
                    ];
                }

                // External URLs
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

                    return [
                        'type'  => 'link',
                        'url'   => $this->external_url,
                        'image' => $this->link_preview_data['image'] ?? null,
                    ];
                }

                // Fallback
                return [
                    'type' => 'placeholder',
                    'url'  => asset('images/placeholder.jpg'),
                ];
            }
        );
    }

    /**
     * Extract YouTube ID
     */
    private function extractYoutubeId(string $url): ?string
    {
        preg_match(
            '/(?:youtu\.be\/|youtube\.com.*(?:v=|embed\/))([^&\n?#]+)/',
            $url,
            $matches
        );

        return $matches[1] ?? null;
    }

    /**
     * Extract Vimeo ID
     */
    private function extractVimeoId(string $url): ?string
    {
        preg_match('/vimeo\.com\/(\d+)/', $url, $matches);

        return $matches[1] ?? null;
    }
}