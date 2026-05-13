<?php

// database/seeders/FooterSeeder.php
namespace Database\Seeders;

use App\Events\FooterUpdated;
use App\Events\SocialLinksUpdated;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FooterInfo;
use App\Models\FooterCta;
use App\Models\SocialLink;
use Illuminate\Support\Facades\File;

class FooterSeeder extends Seeder
{
    // 🔥 ENGINEER STANDARD: Disables Model Events & Broadcasts during seeding
    use WithoutModelEvents;

    public function run(): void
    {
        // Make FooterInfo idempotent
        FooterInfo::updateOrCreate(
            ['id' => 1],
            [
            'company_name' => 'Andabwa MP 2027',
            'title' => env('FOOTER_LOGO_PATH', 'images/andabwa-logo.svg'),
            'description' => '#Let the people decide  #Toa Jam in Lugari Constituency',
            'address' => 'Hurlingham, Nairobi, Kenya',
            'phone' => '+254 700000000',
            'email' => 'info@andabwa-foundation.com',
        ]);

        // Make FooterCta idempotent
        FooterCta::updateOrCreate(
            ['id' => 1],
            [
            'title' => 'Stay Connected',
            'subtitle' => 'Join our newsletter to receive updates from Mheshimiwa Andabwa OGW MP Lugari 2027 .',
            'button_text' => 'Subscribe Now',
            'button_link' => '#subscribe',
        ]);

        // BUG FIX: Make Social Links Idempotent with Media Library support
        $socialLinks = [
            [
                'platform_name' => 'Facebook',
                'url' => 'https://facebook.com',
                'image_path' => 'images/social-links/facebook.gif', // Legacy path for fallback (matches actual file location)
                'image_name' => 'facebook.gif', // Used for Media Library seeding
                'is_active' => true,
                'order' => 1,
            ],
            [
                'platform_name' => 'Instagram',
                'url' => 'https://instagram.com',
                'image_path' => 'images/social-links/instagram.gif',
                'image_name' => 'instagram.gif',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'platform_name' => 'X',
                'url' => 'https://x.com',
                'image_path' => 'images/social-links/x.gif',
                'image_name' => 'x.gif',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'platform_name' => 'Whatsapp',
                'url' => 'https://whatsapp.com',
                'image_path' => 'images/social-links/whatsapp.gif',
                'image_name' => 'whatsapp.gif',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'platform_name' => 'LinkedIn',
                'url' => 'https://linkedin.com',
                'image_path' => 'images/social-links/linkedin.gif',
                'image_name' => 'linkedin.gif',
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($socialLinks as $link) {
            $imageName = $link['image_name'] ?? null;
            unset($link['image_name']);

            // 1. Create or Update the Social Link
            $socialLink = SocialLink::updateOrCreate(
                ['platform_name' => $link['platform_name']],
                [
                    'url' => $link['url'],
                    'image_path' => $link['image_path'],
                    'is_active' => true,
                    'order' => $link['order'] ?? 0,
                ]
            );

            // 2. Attach Media if a seed file exists (Engineer Standard: Check multiple paths)
            if ($imageName) {
                $seedPaths = [
                    public_path("images/social-links/{$imageName}"), // Check public/images/social-links (actual location)
                    public_path("seed-images/{$imageName}"), // Check public/seed-images
                    storage_path("app/public/social-links/{$imageName}"), // Check storage
                ];

                foreach ($seedPaths as $seedPath) {
                    if (File::exists($seedPath)) {
                        // Clear existing media to avoid duplicates
                        $socialLink->clearMediaCollection('social_icons');

                        $socialLink->addMedia($seedPath)
                            ->preservingOriginal()
                            ->toMediaCollection('social_icons');
                        break;
                    }
                }
            }
        }

        // 🔥 FIX: Only fire these if we aren't seeding from the terminal
        if (!app()->runningInConsole()) {
            event(new FooterUpdated());
            event(new SocialLinksUpdated());
        } else {
            $this->command->info('Footer events bypassed for seeding.');
        }
    }
}
