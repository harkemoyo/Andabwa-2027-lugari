<?php

// database/seeders/FooterSeeder.php
namespace Database\Seeders;

use App\Events\FooterUpdated;
use App\Events\SocialLinksUpdated;
use Illuminate\Database\Seeder;
use App\Models\FooterInfo;
use App\Models\FooterCta;
use App\Models\SocialLink;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        // (Assuming FooterInfo and FooterCta are also handled appropriately or truncated elsewhere)
        FooterInfo::create([
            'company_name' => 'Andabwa MP 2027',
            'title' => env('FOOTER_LOGO_PATH', 'images/andabwa-logo.svg'),
            'description' => '#Let the people decide  #Toa Jam in Lugari Constituency',
            'address' => 'Hurlingham, Nairobi, Kenya',
            'phone' => '+254 700000000',
            'email' => 'info@andabwa-foundation.com',
        ]);

        FooterCta::create([
            'title' => 'Stay Connected',
            'subtitle' => 'Join our newsletter to receive updates from Mheshimiwa Andabwa OGW MP Lugari 2027 .',
            'button_text' => 'Subscribe Now',
            'button_link' => '#subscribe',
        ]);

        // BUG FIX: Make Social Links Idempotent
        $socialLinks = [
            [
                'platform_name' => 'Facebook',
                'url' => 'https://facebook.com',
                'image_path' => 'social-links/facebook.gif',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'platform_name' => 'Instagram',
                'url' => 'https://instagram.com',
                'image_path' => 'social-links/instagram.gif',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'platform_name' => 'X',
                'url' => 'https://x.com',
                'image_path' => 'social-links/x.gif',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'platform_name' => 'Whatsapp',
                'url' => 'https://whatsapp.com',
                'image_path' => 'social-links/whatsapp.gif',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'platform_name' => 'LinkedIn',
                'url' => 'https://linkedin.com',
                'image_path' => 'social-links/linkedin.gif',
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($socialLinks as $link) {
            SocialLink::updateOrCreate(
                ['platform_name' => $link['platform_name']], // The "Unique" identifier to check
                [
                    'url' => $link['url'],
                    'image_path' => $link['image_path'],
                    'is_active' => true,
                    'order' => $link['order'] ?? 0,
                ]
            );
        }
        event(new FooterUpdated());
        event(new SocialLinksUpdated());
    }
}
