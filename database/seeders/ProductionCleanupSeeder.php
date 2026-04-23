<?php

namespace Database\Seeders;

use App\Models\LandingPage;
use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use App\Models\SocialLink;
use App\Models\FooterInfo;
use App\Models\FooterCta;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class ProductionCleanupSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->command->warn('=== PRODUCTION CLEANUP STARTED ===');

        // 1. Clean up duplicate social links
        $this->cleanupSocialLinks();

        // 2. Clean up orphaned navigation items (landing pages not in seeder)
        $this->cleanupOrphanedNavigationItems();

        // 3. Clean up orphaned landing pages
        $this->cleanupOrphanedLandingPages();

        // 4. Ensure FooterInfo and FooterCta are singletons
        $this->cleanupFooterSingletons();

        $this->command->info('=== PRODUCTION CLEANUP COMPLETED ===');
    }

    protected function cleanupSocialLinks(): void
    {
        $this->command->warn('Cleaning up duplicate social links...');

        // Get all social links grouped by platform_name
        $duplicates = SocialLink::select('platform_name', DB::raw('COUNT(*) as count'))
            ->groupBy('platform_name')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            $this->command->warn("Found {$duplicate->count} duplicates for {$duplicate->platform_name}");

            // Keep the first one, delete the rest
            $links = SocialLink::where('platform_name', $duplicate->platform_name)
                ->orderBy('id')
                ->get();

            $keep = $links->first();
            $delete = $links->skip(1);

            foreach ($delete as $link) {
                $link->delete();
            }

            $this->command->info("Kept ID {$keep->id}, deleted {$delete->count()} duplicates for {$duplicate->platform_name}");
        }

        $this->command->info('Social links cleanup completed.');
    }

    protected function cleanupOrphanedNavigationItems(): void
    {
        $this->command->warn('Cleaning up orphaned navigation items...');

        // Define allowed slugs from seeders
        $allowedSlugs = ['home', 'tv', 'radio', 'podcasts', 'live-events'];

        // Get navigation items that are not in the allowed list
        $orphanedItems = NavigationItem::whereNotIn('slug', $allowedSlugs)
            ->whereNull('parent_id') // Only top-level items
            ->get();

        $count = 0;
        foreach ($orphanedItems as $item) {
            $this->command->warn("Deleting orphaned navigation item: {$item->title} (slug: {$item->slug})");
            $item->delete();
            $count++;
        }

        $this->command->info("Deleted {$count} orphaned navigation items.");
    }

    protected function cleanupOrphanedLandingPages(): void
    {
        $this->command->warn('Cleaning up orphaned landing pages...');

        // Define allowed slugs from LandingPageSeeder
        $allowedSlugs = ['tv', 'radio', 'podcasts', 'live-events'];

        // Get landing pages that are not in the allowed list
        $orphanedPages = LandingPage::whereNotIn('slug', $allowedSlugs)->get();

        $count = 0;
        foreach ($orphanedPages as $page) {
            $this->command->warn("Deleting orphaned landing page: {$page->title} (slug: {$page->slug})");
            $page->delete();
            $count++;
        }

        $this->command->info("Deleted {$count} orphaned landing pages.");
    }

    protected function cleanupFooterSingletons(): void
    {
        $this->command->warn('Cleaning up footer singletons...');

        // Ensure only one FooterInfo exists
        $footerInfos = FooterInfo::all();
        if ($footerInfos->count() > 1) {
            $keep = $footerInfos->first();
            $delete = $footerInfos->skip(1);
            foreach ($delete as $item) {
                $item->delete();
            }
            $this->command->info("Kept 1 FooterInfo, deleted {$delete->count()} duplicates");
        }

        // Ensure only one FooterCta exists
        $footerCtas = FooterCta::all();
        if ($footerCtas->count() > 1) {
            $keep = $footerCtas->first();
            $delete = $footerCtas->skip(1);
            foreach ($delete as $item) {
                $item->delete();
            }
            $this->command->info("Kept 1 FooterCta, deleted {$delete->count()} duplicates");
        }

        $this->command->info('Footer singletons cleanup completed.');
    }
}
