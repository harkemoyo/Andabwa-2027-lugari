<?php

namespace Database\Seeders;

use App\Events\LandingPageUpdated;
use App\Models\LandingPage;
use App\Models\NavigationMenu;
use App\Models\NavigationItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\File;

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
                'subtitle' => 'Watch our latest Private Security and interviews.',
                'hero_image' => 'widgets/walinzi-sacco.png',
                'image_name' => 'walinzi-sacco.png',
                'content' => '<h2>Watch Live</h2><p>Join us for our daily show...</p>',
                'cta_text' => 'Watch Now',
                'cta_link' => '/tv',
                'is_active' => true,
            ],
            [
                'title' => 'Radio',
                'slug' => 'radio',
                'subtitle' => 'Listen to our latest shows and interviews.',
                'hero_image' => 'landing-pages/hero/smile-logo.jpeg',
                'image_name' => 'smile-logo.jpeg',
                'content' => '<h2>Listen Live</h2><p>Join us for our daily radio show...</p>',
                'cta_text' => 'Listen Now',
                'cta_link' => '/radio',
                'is_active' => true,
            ],
            [
                'title' => 'Podcasts',
                'slug' => 'podcasts',
                'subtitle' => 'Explore our classical podacasts on private security.',
                'hero_image' => 'landing-pages/hero/walinzi.png',
                'image_name' => 'walinzi.png',
                'content' => '<h2>Upcoming Events</h2><p>Check out our calendar for the latest happenings...</p>',
                'cta_text' => 'View Podcasts',
                'cta_link' => '/podcasts',
                'is_active' => true,
            ],
            [
                'title' => 'Live Events',
                'slug' => 'live-events',
                'subtitle' => 'Join us for upcoming webinars and conferences.',
                'hero_image' => 'landing-pages/hero/smile-logo.jpeg',
                'image_name' => 'smile-logo.jpeg',
                'content' => '<h2 class="text-lg font-bold">Upcoming Events</h2><p class="text-md font-medium">Check out our calendar for the latest happenings...</p>',
                'cta_text' => 'View Events',
                'cta_link' => '/events',
                'is_active' => true,
            ],

            [
                'title' => 'Stream Live',
                'slug' => 'stream',
                'subtitle' => 'Join  our livestreams.',
                'hero_image' => 'landing-pages/hero/smile-logo.jpeg',
                'image_name' => 'smile-logo.jpeg',
                'content' => '<h2 class="text-lg font-bold">Upcoming Events</h2><p class="text-md font-medium">Check out our calendar for the latest happenings...</p>',
                'cta_text' => 'Live Stream Now',
                'cta_link' => '/streams',
                'is_active' => true,
            ],
        ];

        // Ensure the main menu exists to attach adaptive links
        $mainMenu = NavigationMenu::firstOrCreate(
            ['slug' => 'main'],
            ['name' => 'Main Menu', 'is_active' => true, 'order' => 1]
        );

        foreach ($pages as $index => $pageData) {
            $imageName = $pageData['image_name'] ?? null;
            unset($pageData['image_name']);

            // 1. Idempotent Landing Page Creation
            $landingPage = LandingPage::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );

            // 2. Attach Media if a seed file exists (Engineer Standard: Check multiple paths)
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
                        // ONLY change this line:
                        $landingPage->clearMediaCollection('hero_images'); // ✅ already correct

                        $landingPage->addMedia($seedPath)
                            ->preservingOriginal()
                            ->toMediaCollection('hero_images'); // ✅ keep this
                        break;
                    }
                }
            }

            // 3. Adaptive Navigation Linking (Automatically adds this page to the menu)
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

        

         // 🔥 FIX: Only fire this if we aren't seeding from the terminal
         if (!app()->runningInConsole()) {
            event(new LandingPageUpdated());
        } else {
            $this->command->info('LandingPage events bypassed for seeding.');
         }
    }
}
