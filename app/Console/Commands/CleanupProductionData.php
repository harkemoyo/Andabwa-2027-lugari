<?php

namespace App\Console\Commands;

use App\Models\LandingPage;
use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use App\Models\SocialLink;
use App\Models\FooterInfo;
use App\Models\FooterCta;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupProductionData extends Command
{
    protected $signature = 'production:cleanup';
    protected $description = 'Clean up production data - remove duplicates and orphaned records';

    public function handle()
    {
        $this->warn('=== PRODUCTION DATA CLEANUP STARTED ===');
        $this->newLine();

        // 1. Clean up social links
        $this->cleanupSocialLinks();

        // 2. Clean up navigation items
        $this->cleanupNavigationItems();

        // 3. Clean up landing pages
        $this->cleanupLandingPages();

        // 4. Clean up footer singletons
        $this->cleanupFooterSingletons();

        $this->newLine();
        $this->info('=== PRODUCTION DATA CLEANUP COMPLETED ===');
        $this->newLine();
        $this->info('Now run: php artisan db:seed --force');
    }

    protected function cleanupSocialLinks(): void
    {
        $this->warn('1. Cleaning up social links...');

        // Define allowed platforms
        $allowedPlatforms = ['Facebook', 'Instagram', 'X', 'Whatsapp', 'LinkedIn'];

        // Delete all social links not in allowed list
        $deleted = SocialLink::whereNotIn('platform_name', $allowedPlatforms)->delete();
        if ($deleted > 0) {
            $this->warn("   Deleted {$deleted} social links with invalid platforms");
        }

        // Handle duplicates within allowed platforms
        foreach ($allowedPlatforms as $platform) {
            $count = SocialLink::where('platform_name', $platform)->count();
            if ($count > 1) {
                $this->warn("   Found {$count} duplicates for {$platform}");
                
                // Keep the first one, delete the rest
                $keep = SocialLink::where('platform_name', $platform)
                    ->orderBy('id')
                    ->first();
                
                $deleted = SocialLink::where('platform_name', $platform)
                    ->where('id', '!=', $keep->id)
                    ->delete();
                
                $this->info("   Kept ID {$keep->id}, deleted {$deleted} duplicates for {$platform}");
            }
        }

        // Ensure all allowed platforms exist with correct data
        $defaultLinks = [
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

        foreach ($defaultLinks as $link) {
            SocialLink::updateOrCreate(
                ['platform_name' => $link['platform_name']],
                $link
            );
        }

        $this->info('   Social links cleaned up successfully');
    }

    protected function cleanupNavigationItems(): void
    {
        $this->warn('2. Cleaning up navigation items...');

        // Define allowed slugs
        $allowedSlugs = ['home', 'tv', 'radio', 'podcasts', 'live-events'];

        // Get all navigation items
        $allItems = NavigationItem::all();
        $deleted = 0;

        foreach ($allItems as $item) {
            // Delete if not in allowed list and is a top-level item
            if (!in_array($item->slug, $allowedSlugs) && is_null($item->parent_id)) {
                $this->warn("   Deleting: {$item->title} (slug: {$item->slug})");
                $item->delete();
                $deleted++;
            }
        }

        $this->info("   Deleted {$deleted} orphaned navigation items");

        // Ensure home exists
        $mainMenu = NavigationMenu::where('slug', 'main')->first();
        if ($mainMenu) {
            NavigationItem::updateOrCreate(
                ['menu_id' => $mainMenu->id, 'slug' => 'home'],
                [
                    'title' => 'News',
                    'url' => '/',
                    'label' => 'Go to homepage',
                    'target' => '_self',
                    'order' => 1,
                    'is_active' => true,
                    'parent_id' => null,
                ]
            );
        }
    }

    protected function cleanupLandingPages(): void
    {
        $this->warn('3. Cleaning up landing pages...');

        // Define allowed slugs
        $allowedSlugs = ['tv', 'radio', 'podcasts', 'live-events'];

        // Define default landing pages
        $defaultPages = [
            [
                'title' => 'TV',
                'slug' => 'tv',
                'subtitle' => 'Watch our latest Private Security and interviews.',
                'hero_image' => 'widgets/walinzi-sacco.png',
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
                'content' => '<h2>Upcoming Events</h2><p>Check out our calendar for the latest happenings...</p>',
                'cta_text' => 'View Events',
                'cta_link' => '/events',
                'is_active' => true,
            ],
        ];

        // Delete pages not in allowed list
        $deleted = LandingPage::whereNotIn('slug', $allowedSlugs)->delete();
        if ($deleted > 0) {
            $this->warn("   Deleted {$deleted} orphaned landing pages");
        }

        // Create/update default pages
        $mainMenu = NavigationMenu::where('slug', 'main')->first();
        foreach ($defaultPages as $index => $pageData) {
            $landingPage = LandingPage::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );

            // Create navigation item for each landing page
            if ($mainMenu) {
                NavigationItem::updateOrCreate(
                    ['menu_id' => $mainMenu->id, 'slug' => $landingPage->slug],
                    [
                        'title' => $landingPage->title,
                        'url' => '/' . $landingPage->slug,
                        'label' => 'View ' . $landingPage->title,
                        'target' => '_self',
                        'order' => 10 + $index,
                        'is_active' => $landingPage->is_active,
                        'parent_id' => null,
                    ]
                );
            }
        }

        $this->info('   Landing pages cleaned up successfully');
    }

    protected function cleanupFooterSingletons(): void
    {
        $this->warn('4. Cleaning up footer singletons...');

        // FooterInfo
        $footerInfos = FooterInfo::all();
        if ($footerInfos->count() > 1) {
            $keep = $footerInfos->first();
            $delete = $footerInfos->skip(1);
            foreach ($delete as $item) {
                $item->delete();
            }
            $this->info("   Kept 1 FooterInfo, deleted {$delete->count()} duplicates");
        }

        // Ensure FooterInfo exists
        FooterInfo::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Andabwa MP 2027',
                'title' => env('FOOTER_LOGO_PATH', 'images/andabwa-logo.svg'),
                'description' => '#Let the people decide  #Toa Jam in Lugari Constituency',
                'address' => 'Hurlingham, Nairobi, Kenya',
                'phone' => '+254 700000000',
                'email' => 'info@andabwa-foundation.com',
            ]
        );

        // FooterCta
        $footerCtas = FooterCta::all();
        if ($footerCtas->count() > 1) {
            $keep = $footerCtas->first();
            $delete = $footerCtas->skip(1);
            foreach ($delete as $item) {
                $item->delete();
            }
            $this->info("   Kept 1 FooterCta, deleted {$delete->count()} duplicates");
        }

        // Ensure FooterCta exists
        FooterCta::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Stay Connected',
                'subtitle' => 'Join our newsletter to receive updates from Mheshimiwa Andabwa OGW MP Lugari 2027 .',
                'button_text' => 'Subscribe Now',
                'button_link' => '#subscribe',
            ]
        );

        $this->info('   Footer singletons cleaned up successfully');
    }
}
