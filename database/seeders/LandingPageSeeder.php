<?php

namespace Database\Seeders;

use App\Events\LandingPageUpdated;
use App\Models\LandingPage;
use App\Models\NavigationMenu;
use App\Models\NavigationItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LandingPageSeeder extends Seeder
{
    // 🔥 ENGINEER STANDARD: Disables Model Events & Broadcasts during seeding
    use WithoutModelEvents;

    public function run(): void
    {
        $pages = [          

            
            [
                'title' => 'TV',
                'slug' => 'tv',
                'subtitle' => 'Watch our latest programming and interviews.',
                'hero_image' => '/images/tv-hero.jpg',
                'content' => '<h2>Watch Live</h2><p>Join us for our daily show...</p>',
                'cta_text' => 'Watch Now',
                'cta_link' => '/tv',
                'is_active' => true,
            ],

             [
                'title' => 'Radio',
                'slug' => 'radio',
                'subtitle' => 'Listen to our latest shows and interviews.',
                'hero_image' => '/images/radio-hero.jpg',
                'content' => '<h2>Listen Live</h2><p>Join us for our daily radio show...</p>',
                'cta_text' => 'Listen Now',
                'cta_link' => '/radio',
                'is_active' => true,
            ],

             [
                'title' => 'Podcasts',
                'slug' => 'podcasts',
                'subtitle' => 'Explore our classical podacasts on private security.',
                'hero_image' => '/images/scholarships-hero.jpg',
                'content' => '<h2>Upcoming Events</h2><p>Check out our calendar for the latest happenings...</p>',
                'cta_text' => 'View Podcasts',
                'cta_link' => '/podcasts',
                'is_active' => true,
            ],
            [
                'title' => 'Live Events',
                'slug' => 'live-events',
                'subtitle' => 'Join us for upcoming webinars and conferences.',
                'hero_image' => '/images/events-hero.jpg',
                'content' => '<h2>Upcoming Events</h2><p>Check out our calendar for the latest happenings...</p>',
                'cta_text' => 'View Events',
                'cta_link' => '/events',
                'is_active' => true,
            ],
        ];

        // Ensure the main menu exists to attach adaptive links
        $mainMenu = NavigationMenu::firstOrCreate(
            ['slug' => 'main'],
            ['name' => 'Main Menu', 'is_active' => true, 'order' => 1]
        );

        foreach ($pages as $index => $pageData) {
            // 1. Idempotent Landing Page Creation
            $landingPage = LandingPage::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );

            // 2. Adaptive Navigation Linking (Automatically adds this page to the menu)
            NavigationItem::updateOrCreate(
                ['menu_id' => $mainMenu->id, 'slug' => $landingPage->slug],
                [
                    'title' => $landingPage->title,
                    'url' => '/' . $landingPage->slug,
                    'label' => 'View ' . $landingPage->title,
                    'target' => '_self',
                    'order' => 10 + $index, // Appends after main standard items
                    'is_active' => $landingPage->is_active,
                    'parent_id' => null,
                ]
            );
        }

        event(new LandingPageUpdated());
    }
}