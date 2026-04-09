<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as SupportFFMpeg;

class ProcessVideoThumbnail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Post $post) {}

   

    public function handle(): void
    {
        // Get media if it exists, otherwise bail
        $media = $this->post->getMedia('featured')->first();
        if (!$media) {
            return;
        }

        $thumbPath = "thumbnails/{$this->post->id}.jpg";

        try {
            SupportFFMpeg::fromDisk(config('filesystems.default'))
                ->open($media->getPath())
                ->getFrameFromSeconds(1)
                ->export()
                ->toDisk(config('filesystems.default'))
                ->save($thumbPath);

            $currentData = $this->post->link_preview_data ?? [];
            $currentData['thumbnail'] = $thumbPath;

            $this->post->update([
                'link_preview_data' => $currentData
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Video thumbnail generation failed for post {$this->post->id}: " . $e->getMessage());
        }
    }
}