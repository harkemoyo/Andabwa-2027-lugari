<?php

namespace App\DTOs;

use Illuminate\Contracts\Support\Arrayable;

class LinkPreviewData implements Arrayable
{
    public function __construct(
        public string $type,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $image = null,
        public ?string $url = null,
        public ?string $youtubeId = null,
    ) {}

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'url' => $this->url,
            'youtube_id' => $this->youtubeId,
        ];
    }

    
}

