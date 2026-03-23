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
        $thumbPath = "thumbnails/{$this->post->id}.jpg";

        SupportFFMpeg::fromDisk('public')
            ->open($this->post->getUrl)
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk('public')
            ->save($thumbPath);

        $currentData = $this->post->link_preview_data ?? [];
        $currentData['image'] = $thumbPath;

        $this->post->update([
            'link_preview_data' => $currentData
        ]);
    }
}