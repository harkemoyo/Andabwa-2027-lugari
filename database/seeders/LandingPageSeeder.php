<?php

namespace Database\Seeders;

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
                'title' => 'Scholarships',
                'slug' => 'scholarships',
                'subtitle' => 'Explore our fully-funded scholarship opportunities.',
                'content' => '<h2>Apply Today</h2><p>Here are the details for our 2026 scholarship programs...</p>',
                'cta_text' => 'Apply Now',
                'cta_link' => '/apply',
                'is_active' => true,
            ],
            [
                'title' => 'Alumni Network',
                'slug' => 'alumni-network',
                'subtitle' => 'Connect with graduates around the globe.',
                'content' => '<h2>Welcome Back</h2><p>Join our exclusive network...</p>',
                'cta_text' => 'Join Directory',
                'cta_link' => '/alumni/register',
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
    }
}