<?php
namespace App\Services;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LinkPreviewService
{
    private const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36';

    public function extract(string $url, bool $force = false): array
    {
        $url = $this->normalizeUrl($url);
        $cacheKey = "link_preview_" . md5($url);

        if ($force) {
            Cache::forget($cacheKey);
        }

        return Cache::remember($cacheKey, now()->addDay(), function () use ($url) {
            $finalUrl = $this->resolveFinalUrl($url);

            if ($youtubeId = $this->detectYoutubeId($finalUrl)) {
                return $this->extractYoutube($youtubeId, $finalUrl);
            }

            if ($video = $this->detectVideoPlatform($finalUrl)) {
                return [
                    'type' => $video['type'],
                    'title' => $video['platform'] === 'direct' ? 'Video File' : 'Embedded Video',
                    'description' => parse_url($finalUrl, PHP_URL_HOST),
                    'image' => null,
                    'url' => $finalUrl,
                    'embed_url' => $video['embed_url'],
                ];
            }

            return $this->extractExternal($finalUrl);
        });
    }

    private function resolveFinalUrl(string $url): string
    {
        try {
            // FIX: Use GET instead of HEAD. Many CDNs (Cloudflare) block HEAD requests.
            // We use a small timeout and 'allow_redirects' to find the true destination.
            $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])
                ->timeout(5)
                ->withOptions(['allow_redirects' => true])
                ->get($url);

            return (string) ($response->effectiveUri() ?? $url);
        } catch (\Exception $e) {
            return $url;
        }
    }

    private function extractExternal(string $url): array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => self::USER_AGENT,
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            ])->timeout(10)
                ->withOptions(['allow_redirects' => true, 'verify' => false])
                ->get($url);

            if ($response->failed()) throw new \Exception("Request failed");

            $html = $response->body();

            // FIX: findMeta now takes the $url to ensure relative paths are converted to absolute
            $image = $this->findMeta($html, ['og:image:secure_url', 'og:image', 'twitter:image:src', 'twitter:image'], $url);
            
            if (!$image) {
                $image = $this->extractFirstImage($html, $url);
            }

            if (!$image) {
                $image = $this->extractFavicon($url);
            }

            return [
                'type' => 'external_link',
                'title' => $this->findMeta($html, ['og:title', 'twitter:title', 'title']) ?: parse_url($url, PHP_URL_HOST),
                'description' => $this->findMeta($html, ['og:description', 'twitter:description', 'description']),
                'image' => $image,
                'url' => $url,
                'embed_url' => null,
                'source' => parse_url($url, PHP_URL_HOST),
            ];
        } catch (\Exception $e) {
            return [
                'type' => 'external_link',
                'title' => parse_url($url, PHP_URL_HOST) ?? 'External Link',
                'description' => 'Preview unavailable.',
                'image' => $this->extractFavicon($url),
                'url' => $url,
                'embed_url' => null,
            ];
        }
    }

    private function findMeta(string $html, array $properties, string $baseUrl = ''): ?string
    {
        foreach ($properties as $property) {
            if ($property === 'title') {
                if (preg_match('/<title>(.*?)<\/title>/is', $html, $match)) {
                    return trim(html_entity_decode($match[1]));
                }
                continue;
            }

            $pattern = '/<meta[^>]+(?:property|name)=["\']' . preg_quote($property, '/') . '["\'][^>]+content=["\']([^"\']+)["\']/i';
            if (preg_match($pattern, $html, $match)) {
                $content = html_entity_decode($match[1]);
                
                // FIX: If this is an image property, make it absolute
                if (Str::contains($property, 'image') && !empty($baseUrl)) {
                    return $this->absUrl($content, $baseUrl);
                }
                
                return $content;
            }
        }
        return null;
    }

    /**
     * Helper to convert relative URLs to Absolute URLs
     */
    private function absUrl(string $url, string $baseUrl): string
    {
        if (empty($url) || Str::startsWith($url, ['http://', 'https://', 'data:'])) {
            return $url;
        }

        $parts = parse_url($baseUrl);
        $root = $parts['scheme'] . '://' . $parts['host'] . (isset($parts['port']) ? ':' . $parts['port'] : '');

        if (Str::startsWith($url, '//')) {
            return $parts['scheme'] . ':' . $url;
        }

        if (Str::startsWith($url, '/')) {
            return $root . $url;
        }

        return rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
    }
    
    // private const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/119 Safari/537.36';

    /**
     * Main entry point to extract metadata from a URL.
     */
    // public function extract(string $url, bool $force = false): array
    // {
    //     $url = $this->normalizeUrl($url);
    //     $cacheKey = "link_preview_" . md5($url);

    //     if ($force) {
    //         Cache::forget($cacheKey);
    //     }

    //     return Cache::remember($cacheKey, now()->addDay(), function () use ($url) {
    //         // Resolve redirects first (bit.ly, t.co, etc)
    //         $url = $this->resolveFinalUrl($url);

    //         // 1. YouTube detection
    //         if ($youtubeId = $this->detectYoutubeId($url)) {
    //             return $this->extractYoutube($youtubeId, $url);
    //         }

    //         // 2. Other video platforms (Vimeo, Streamable, Direct MP4)
    //         if ($video = $this->detectVideoPlatform($url)) {
    //             return [
    //                 'type' => $video['type'],
    //                 'title' => $video['platform'] === 'direct' ? 'Video File' : 'Embedded Video',
    //                 'description' => parse_url($url, PHP_URL_HOST),
    //                 'image' => null,
    //                 'url' => $url,
    //                 'embed_url' => $video['embed_url'],
    //             ];
    //         }

    //         // 3. Normal external link (News Articles, Blogs, etc.)
    //         return $this->extractExternal($url);
    //     });
    // }

    /**
     * Ensure URL has a scheme.
     */
    private function normalizeUrl(string $url): string
    {
        $url = trim($url);
        if (!Str::startsWith($url, ['http://', 'https://'])) {
            $url = 'https://' . $url;
        }
        return $url;
    }

    /**
     * Follow redirects to find the real destination.
     */
    // private function resolveFinalUrl(string $url): string
    // {
    //     try {
    //         $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])
    //             ->timeout(3) // Reduced from 6 to 3 seconds
    //             ->withOptions(['allow_redirects' => true])
    //             ->head($url);

    //         return (string) ($response->effectiveUri() ?? $url);
    //     } catch (\Exception $e) {
    //         return $url;
    //     }
    // }

    private function detectYoutubeId(string $url): ?string
    {
        $patterns = [
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/',
            '/[?&]v=([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    private function extractYoutube(string $id, string $url): array
    {
        try {
            $oembed = Http::timeout(3) // Reduced from 6 to 3 seconds
                ->get("https://www.youtube.com/oembed", [
                'url' => "https://www.youtube.com/watch?v={$id}",
                'format' => 'json',
            ])->json();

            return [
                'type' => 'youtube',
                'title' => $oembed['title'] ?? 'YouTube Video',
                'description' => $oembed['author_name'] ?? 'YouTube',
                'image' => "https://img.youtube.com/vi/{$id}/maxresdefault.jpg",
                'url' => $url,
                'video_id' => $id,
                'embed_url' => "https://www.youtube-nocookie.com/embed/{$id}?rel=0&modestbranding=1&playsinline=1",
            ];
        } catch (\Exception $e) {
            return [
                'type' => 'youtube',
                'title' => 'YouTube Video',
                'image' => "https://img.youtube.com/vi/{$id}/hqdefault.jpg",
                'video_id' => $id,
                'embed_url' => "https://www.youtube-nocookie.com/embed/{$id}",
                'url' => $url,
            ];
        }
    }

    // private function extractExternal(string $url): array
    // {
    //     try {
    //         $response = Http::withHeaders([
    //             'User-Agent' => self::USER_AGENT,
    //             'Accept-Language' => 'en-US,en;q=0.9',
    //             'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    //         ])->timeout(8)
    //             ->withOptions(['allow_redirects' => true, 'verify' => false])
    //             ->get($url);

    //         if ($response->failed()) throw new \Exception("Failed");

    //         $html = $response->body();

    //         // Try to extract image with better priority
    //         $image = $this->findMeta($html, ['og:image:secure_url', 'og:image', 'twitter:image:src', 'twitter:image']);
            
    //         // If no image found, try to find the first image in the content
    //         if (!$image) {
    //             $image = $this->extractFirstImage($html, $url);
    //         }

    //         // Fallback to favicon if still no image
    //         if (!$image) {
    //             $image = $this->extractFavicon($url);
    //         }

    //         return [
    //             'type' => 'external_link',
    //             'title' => $this->findMeta($html, ['og:image:alt', 'og:title', 'twitter:title', 'title']) ?: parse_url($url, PHP_URL_HOST),
    //             'description' => $this->findMeta($html, ['og:description', 'twitter:description', 'description']),
    //             'image' => $image,
    //             'url' => $url,
    //             'embed_url' => null,
    //             'source' => parse_url($url, PHP_URL_HOST),
    //         ];
    //     } catch (\Exception $e) {
    //         return [
    //             'type' => 'external_link',
    //             'title' => parse_url($url, PHP_URL_HOST) ?? 'External Link',
    //             'description' => 'Preview unavailable, but link is valid.',
    //             'image' => $this->extractFavicon($url),
    //             'url' => $url,
    //             'embed_url' => null,
    //         ];
    //     }
    // }

    private function extractFavicon(string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST);
        return "https://www.google.com/s2/favicons?domain={$host}&sz=256";
    }

    private function extractFirstImage(string $html, string $baseUrl): ?string
    {
        // Extract the first img tag with a valid src
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $html, $matches)) {
            $imgSrc = $matches[1];
            
            // Convert relative URLs to absolute
            if (!Str::startsWith($imgSrc, ['http://', 'https://'])) {
                $baseUrl = rtrim($baseUrl, '/');
                if (Str::startsWith($imgSrc, '/')) {
                    $parsedUrl = parse_url($baseUrl);
                    $imgSrc = ($parsedUrl['scheme'] ?? 'https') . '://' . ($parsedUrl['host'] ?? '') . $imgSrc;
                } else {
                    $imgSrc = $baseUrl . '/' . ltrim($imgSrc, '/');
                }
            }
            
            // Filter out small images (likely icons/trackers)
            if (preg_match('/width=["\']?(\d+)/i', $matches[0], $widthMatch)) {
                if ((int)$widthMatch[1] < 100) {
                    return null;
                }
            }
            
            return $imgSrc;
        }
        
        return null;
    }

    // private function findMeta(string $html, array $properties): ?string
    // {
    //     foreach ($properties as $property) {
    //         if ($property === 'title') {
    //             if (preg_match('/<title>(.*?)<\/title>/is', $html, $match)) {
    //                 return trim(html_entity_decode($match[1]));
    //             }
    //             continue;
    //         }

    //         $pattern = '/<meta[^>]+(?:property|name)=["\']' . preg_quote($property, '/') . '["\'][^>]+content=["\']([^"\']+)["\']/i';
    //         if (preg_match($pattern, $html, $match)) {
    //             return html_entity_decode($match[1]);
    //         }
    //     }
    //     return null;
    // }

    private function detectVideoPlatform(string $url): ?array
    {
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            return [
                'type' => 'video_embed', 
                'platform' => 'vimeo', 
                'embed_url' => "https://player.vimeo.com/video/{$matches[1]}"
            ];
        }

        if (preg_match('/streamable\.com\/([a-zA-Z0-9]+)/', $url, $matches)) {
            return [
                'type' => 'video_embed', 
                'platform' => 'streamable', 
                'embed_url' => "https://streamable.com/e/{$matches[1]}"
            ];
        }

        if (preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $url)) {
            return [
                'type' => 'video_file', 
                'platform' => 'direct', 
                'embed_url' => $url
            ];
        }

        return null;
    }
}

