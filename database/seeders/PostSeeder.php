<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Enums\MediaType;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id');
        $tags = Tag::pluck('id');
        
        $seedImagePath = public_path('seed-images/sample.jpg');
        $seedVideoPath = public_path('seed-videos/sample.mp4');

        $projects = [
            [
                'title' => 'Empowering Lugari Youth through Scholarships',
                'media_type' => MediaType::Image,
                'content' => 'Dr. Andabwa OGW scholarship launch for bright needy students.',
                'meta_title' => 'Lugari Youth Scholarships | Dr. Andabwa OGW',
                'meta_description' => 'Education support for needy students in Lugari.',
                'external_url' => null,
            ],
            [
                'title' => 'Documentary: I cant Unsit Atwoli not only through endorsement by Executive',
                'media_type' => MediaType::LocalVideo, // Local MP4 File
                'content' => 'Watch the full video of the groundbreaking ceremony.',
                'meta_title' => 'Walinzi Sacco Groundbreaking Video',
                'meta_description' => 'Video highlights of the housing project launch.',
                'external_url' => null,
            ],
            [
                'title' => 'KNPSWU National Security Reforms Update',
                'media_type' => MediaType::Youtube, // YouTube Link
                'content' => 'Dr. Andabwa discusses private security reforms on national TV.',
                'meta_title' => 'Dr. Andabwa on Citizen TV | Security Reforms',
                'meta_description' => 'National interview regarding guard wages and rights.',
                'external_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Placeholder
            ],
            [
                'title' => 'Featured Article: The Future of Lugari Saccos',
                'media_type' => MediaType::Article, // External News Link
                'content' => 'Read this in-depth analysis on the Daily Nation website.',
                'meta_title' => 'Lugari Sacco Economic Impact Article',
                'meta_description' => 'Analysis of how Walinzi Sacco is changing lives.',
                'external_url' => 'https://nation.africa/kenya/business/saccos-lugari', // Placeholder
            ],
            [
                'title' => 'Peace and Security Forums in Kakamega',
                'media_type' => MediaType::Image,
                'content' => 'Community-led peace forums strengthen local security ties.',
                'meta_title' => 'Kakamega Peace Forums | Dr. Andabwa OGW',
                'meta_description' => 'Dr. Andabwa leads security forums in Kakamega.',
                'external_url' => null,
            ],
            [
                'title' => 'Walinzi Sacco: Member Registration Guide',
                'media_type' => MediaType::Youtube,
                'content' => 'Step-by-step video on how to join the Walinzi Sacco.',
                'meta_title' => 'How to Join Walinzi Sacco | Video Guide',
                'meta_description' => 'Tutorial video for new Sacco members.',
                'external_url' => 'https://www.youtube.com/watch?v=example',
            ],
        ];

        foreach ($projects as $index => $data) {
            $post = Post::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'category_id' => $categories->isNotEmpty() ? $categories->random() : null,
                    'is_published' => true,
                    'is_featured' => $index < 2,
                    'media_type' => $data['media_type'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_description'],
                    'external_url' => $data['external_url'],
                ]
            );

            // 1. Handle Tags
            if ($tags->isNotEmpty()) {
                $post->tags()->sync($tags->random(min(2, $tags->count()))->toArray());
            }

            // 2. Handle Local Media (Images/Videos)
            if ($post->getMedia('featured')->isEmpty()) {
                
                // If it's an Image post and image exists
                if ($data['media_type'] === MediaType::Image && File::exists($seedImagePath)) {
                    $post->addMedia($seedImagePath)
                        ->preservingOriginal()
                        ->toMediaCollection('featured', 'public');
                }

                // If it's a Local Video post and video exists
                if ($data['media_type'] === MediaType::LocalVideo && File::exists($seedVideoPath)) {
                    $post->addMedia($seedVideoPath)
                        ->preservingOriginal()
                        ->toMediaCollection('featured', 'public');
                }
            }
        }

        $this->command->info('Seeded Image, Video, Youtube, and Article posts for Dr. Andabwa.');
    }
}

