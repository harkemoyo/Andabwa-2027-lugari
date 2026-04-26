<?php

namespace Database\Seeders;

use App\Models\LiveEvents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LiveEventsSeeder extends Seeder
{
    // 🔥 ENGINEER STANDARD: Disables Model Events & Broadcasts during seeding
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $liveEvents = [
            [
                'title' => 'The Future of Lugari',
                'type' => 'upload',
                'cover_image'=>'landing-pages/hero/smile-logo.jpeg',
                'image_name' => 'smile-logo.jpeg',
                'description'=>"Best event happening",
                'duration_minutes' => 45,
                'audio_url' => 'liveEvents/demo1.mp3',
            ],
            [
                'title' => 'Live Andabwa OGW security session: Private Security',
                'type' => 'live',
                'cover_image'=>'landing-pages/hero/smile-logo.jpeg',
                'image_name' => 'smile-logo.jpeg',
                'description'=>"Best event happening",
                'live_url' => 'https://youtube.com/live/example',
                'scheduled_at' => now()->addDays(2),
            ],
            [
                'title' => 'Live Andabwa OGW foundation: community empowerment',
                'type' => 'live',
                'cover_image'=>'landing-pages/hero/smile-logo.jpeg',
                'image_name' => 'smile-logo.jpeg',
                'description'=>"Best event happening",
                'live_url' => 'https://youtube.com/live/example',
                'scheduled_at' => now()->addDays(2),
            ]
        ];

        foreach ($liveEvents as $data) {
            $imageName = $data['image_name'] ?? null;
            unset($data['image_name']);

            $liveEvent = LiveEvents::updateOrCreate(['title' => $data['title']], $data);

            // Attach Media if a seed file exists (Engineer Standard: Check multiple paths)
            if ($imageName) {
                $seedPaths = [
                    storage_path("app/public/widget_images/{$imageName}"), // Check storage/widget_images
                    public_path("seed-images/{$imageName}"), // Check public/seed-images
                    public_path("images/{$imageName}"), // Check public/images
                    storage_path("app/public/landing-pages/hero/{$imageName}"), // Check storage/landing-pages/hero
                ];

                foreach ($seedPaths as $seedPath) {
                    if (File::exists($seedPath)) {
                        // Clear existing media to avoid duplicates
                        $liveEvent->clearMediaCollection('cover_images');

                        $liveEvent->addMedia($seedPath)
                            ->preservingOriginal()
                            ->toMediaCollection('cover_images');
                        break;
                    }
                }
            }
        }
    }
}
