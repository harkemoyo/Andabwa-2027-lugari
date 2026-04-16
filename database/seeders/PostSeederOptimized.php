<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Enums\MediaType;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

// Increase memory limit for image processing
ini_set('memory_limit', '512M');

class PostSeederOptimized extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting optimized post seeding...');

        // Get categories and tags
        $categories = Category::all();
        $tags = Tag::all();

        if ($categories->isEmpty() || $tags->isEmpty()) {
            $this->command->error('No categories or tags found. Please run CategorySeeder and TagSeeder first.');
            return;
        }

        // Create posts without media processing to avoid memory issues
        $this->createPosts($categories, $tags);

        // Process media separately with memory management
        $this->processMediaSeparately();

        $this->command->info('✅ Posts seeded successfully with optimized memory management!');
    }

    /**
     * Create posts without heavy media processing
     */
    private function createPosts($categories, $tags): void
    {
        $posts = [
            [
                'title' => 'Andabwa 2027: A Year of Transformation',
                'slug' => 'andabwa-2027-transformation',
                'content' => 'The year 2027 marked a significant transformation for Andabwa Ward, with major developments in education, infrastructure, and community empowerment initiatives.',
                'featured_image' => null, // Skip heavy image processing
                'media_type' => MediaType::Image,
                'is_featured' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Healthcare Initiative Launched in Lugari',
                'slug' => 'healthcare-initiative-lugari',
                'content' => 'A comprehensive healthcare initiative was launched in Lugari, bringing improved medical services to the community.',
                'featured_image' => null, // Skip heavy image processing
                'media_type' => MediaType::Image,
                'is_featured' => true,
                'published_at' => now()->subDays(30),
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(30),
            ],
            [
                'title' => 'Education Infrastructure Improvements',
                'slug' => 'education-infrastructure-improvements',
                'content' => 'Major improvements to educational infrastructure were completed, including new classrooms and learning resources.',
                'featured_image' => null, // Skip heavy image processing
                'media_type' => MediaType::Image,
                'is_featured' => false,
                'published_at' => now()->subDays(60),
                'created_at' => now()->subDays(60),
                'updated_at' => now()->subDays(60),
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::create($postData);

            // Attach random categories and tags
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')
            );

            $post->tags()->attach(
                $tags->random(rand(2, 5))->pluck('id')
            );
        }
    }

    /**
     * Process media files separately with memory management
     */
    private function processMediaSeparately(): void
    {
        $this->command->info('Processing media files separately...');

        // Define media files to process (skip large videos for now)
        $mediaFiles = [
            [
                'model_type' => 'App\Models\Post',
                'model_id' => 1,
                'collection_name' => 'featured',
                'file_path' => 'seed-images/scholorships.webp',
                'alt_text' => 'Empowering Lugari Youth through Scholarships',
                'media_type' => MediaType::Image,
            ],
            [
                'model_type' => 'App\Models\Post',
                'model_id' => 2,
                'collection_name' => 'featured',
                'file_path' => 'seed-images/security.jpg',
                'alt_text' => 'Peace and Security Forums in Kakamega',
                'media_type' => MediaType::Image,
            ],
            [
                'model_type' => 'App\Models\Post',
                'model_id' => 3,
                'collection_name' => 'featured',
                'file_path' => 'seed-images/andabwa-development.jpg',
                'alt_text' => 'Development Projects Launch Ceremony',
                'media_type' => MediaType::Image,
            ],
        ];

        foreach ($mediaFiles as $mediaData) {
            $fullPath = public_path($mediaData['file_path']);
            if (file_exists($fullPath)) {
                $this->command->info("Adding media from: {$mediaData['file_path']} to: {$mediaData['alt_text']}");
                
                // Find the post model
                $post = Post::find($mediaData['model_id']);
                if ($post) {
                    // Use Spatie Media Library addMedia method
                    $media = $post->addMedia($fullPath)
                        ->usingName($mediaData['alt_text'])
                        ->withCustomProperties([
                            'alt_text' => $mediaData['alt_text'],
                            'media_type' => $mediaData['media_type'],
                        ])
                        ->toMediaCollection($mediaData['collection_name'], 'public');

                    $this->command->info("Media created successfully for post {$mediaData['model_id']}");
                } else {
                    $this->command->warning("Post not found with ID: {$mediaData['model_id']}");
                }
            } else {
                $this->command->warning(" Media file not found: {$mediaData['file_path']}");
            }
        }
    }

    /**
     * Get MIME type for a file with fallback
     */
    private function getMimeType(string $filePath): string
    {
        try {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            return match(strtolower($extension)) {
                'jpg', 'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'webp' => 'image/webp',
                'gif' => 'image/gif',
                'pdf' => 'application/pdf',
                'mp4' => 'video/mp4',
                'mov' => 'video/quicktime',
                'avi' => 'video/x-msvideo',
                default => 'application/octet-stream'
            };
        } catch (\Exception $e) {
            return 'application/octet-stream';
        }
    }
}
