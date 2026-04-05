<?php
// app/Actions/GenerateSeoTags.php
namespace App\Actions;

use App\Models\Post;
use Illuminate\Support\Str;

class GenerateSeoTags 
{
    public function execute(Post $post): array 
    {
        return [
            'title' => "{$post->title} | Andabwa Lugari Constituency Development Projects",
            'description' => Str::limit(strip_tags($post->content), 160),
            'og_image' => $post->media_type === 'image' 
                ? asset('storage/' . $post->getUrl()) 
                : ($post->link_preview_data['image'] ?? asset('default-og.jpg')),
        ];
    }
}