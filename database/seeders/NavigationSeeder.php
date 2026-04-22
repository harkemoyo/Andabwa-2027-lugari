<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\NavigationMenu;
use App\Models\NavigationItem;

class NavigationSeeder extends Seeder
{
    // 🔥 ENGINEER STANDARD: Disables Model Events & Broadcasts during seeding for maximum speed
    use WithoutModelEvents;

    public function run(): void
    {
        $menu = NavigationMenu::updateOrCreate(
            ['slug' => 'main'],
            ['name' => 'Main Menu', 'is_active' => true, 'order' => 1]
        );

        $home = NavigationItem::updateOrCreate(
            ['menu_id' => $menu->id, 'title' => 'News'],
            [
                'slug' => 'home',
                'url' => '/',
                'label' => 'Go to homepage',
                'target' => '_self',
                'order' => 1,
                'is_active' => true,
                'parent_id' => null,
            ]
        );

        // $about = NavigationItem::updateOrCreate(
        //     ['menu_id' => $menu->id, 'title' => 'About'],
        //     [
        //         'slug' => 'about',
        //         'url' => '/about',
        //         'label' => 'Learn more about us',
        //         'target' => '_self',
        //         'order' => 2,
        //         'is_active' => true,
        //         'parent_id' => null,
        //     ]
        // );

        // $services = NavigationItem::updateOrCreate(
        //     ['menu_id' => $menu->id, 'title' => 'Services'],
        //     [
        //         'slug' => 'services',
        //         'url' => '/services',
        //         'label' => 'Our services',
        //         'target' => '_self',
        //         'order' => 3,
        //         'is_active' => true,
        //         'parent_id' => null,
        //     ]
        // );

        // NavigationItem::updateOrCreate(
        //     ['menu_id' => $menu->id, 'title' => 'Consulting'],
        //     [
        //         'slug' => 'consulting',
        //         'url' => '/services/consulting',
        //         'label' => 'Consulting services',
        //         'target' => '_self',
        //         'order' => 1,
        //         'is_active' => true,
        //         'parent_id' => $services->id,
        //     ]
        // );

        // NavigationItem::updateOrCreate(
        //     ['menu_id' => $menu->id, 'title' => 'Development'],
        //     [
        //         'slug' => 'development',
        //         'url' => '/services/development',
        //         'label' => 'Development projects',
        //         'target' => '_self',
        //         'order' => 2,
        //         'is_active' => true,
        //         'parent_id' => $services->id,
        //     ]
        // );

        // NavigationItem::updateOrCreate(
        //     ['menu_id' => $menu->id, 'title' => 'Contact'],
        //     [
        //         'slug' => 'contact',
        //         'url' => '/contact',
        //         'label' => 'Reach out to us',
        //         'target' => '_self',
        //         'order' => 4,
        //         'is_active' => true,
        //         'parent_id' => null,
        //     ]
        // );

        
    }
}