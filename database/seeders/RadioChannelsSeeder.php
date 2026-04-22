<?php

namespace Database\Seeders;

use App\Models\RadioChannels;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RadioChannelsSeeder extends Seeder
{
    // 🔥 ENGINEER STANDARD: Disables Model Events & Broadcasts during seeding
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $radioChannels = [
            [
                'title' => 'The Future of Lugari',
                'type' => 'upload',
                'cover_image'=>'landing-pages/hero/smile-logo.jpeg',
                'description'=>"Best event happening",
                'duration_minutes' => 45,
                'audio_url' => 'radioChannels/demo1.mp3',
            ],
            [
                'title' => 'Live Andabwa OGW security session: Private Security',
                'type' => 'live',
                'cover_image'=>'landing-pages/hero/smile-logo.jpeg',
                'description'=>"Best event happening",
                'live_url' => 'https://youtube.com/live/example',
                'scheduled_at' => now()->addDays(2),
            ],
            [
                'title' => 'Live Andabwa OGW foundation: community empowerment',
                'type' => 'live',
                'cover_image'=>'landing-pages/hero/smile-logo.jpeg',
                'description'=>"Best event happening",
                'live_url' => 'https://youtube.com/live/example',
                'scheduled_at' => now()->addDays(2),
            ]
        ];

        foreach ($radioChannels as $p) {
            RadioChannels::updateOrCreate(['title' => $p['title']], $p);
        }
    }
}
