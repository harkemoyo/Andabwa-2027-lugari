<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\File;
use App\Models\NavigationLogoHeader;

class NavigationLogoHeaderSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Create or Update the Navigation Logo Header
        $logoHeader = NavigationLogoHeader::updateOrCreate(
            ['link' => url('/')],
            [
                'logo_path' => 'socials/andabwa-logo.svg', // Legacy path for fallback
            ]
        );

        // 2. Attach Media if a seed file exists (Engineer Standard: Check multiple paths)
        $imageName = 'andabwa-logo.svg';
        $seedPaths = [
            storage_path("app/public/socials/{$imageName}"), // Check storage/socials (actual location)
            public_path("images/{$imageName}"), // Check public/images
            storage_path("app/public/social-links/{$imageName}"), // Check storage/social-links
            public_path("seed-images/{$imageName}"), // Check public/seed-images
        ];

        foreach ($seedPaths as $seedPath) {
            if (File::exists($seedPath)) {
                // Clear existing media to avoid duplicates
                $logoHeader->clearMediaCollection('navigation_logos');

                $logoHeader->addMedia($seedPath)
                    ->preservingOriginal()
                    ->toMediaCollection('navigation_logos');
                $this->command->info("Navigation logo media attached from: {$seedPath}");
                break;
            }
        }

        $this->command->info('Navigation logos seeded.');
    }
}
