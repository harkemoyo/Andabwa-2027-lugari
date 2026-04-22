<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,           // Create roles and permissions first
            AdminSeeder::class,          // Create users with roles (includes all needed users)
            PageSectionSeeder::class,
            NavigationSeeder::class,     // Create navigation menus and items
            CategorySeeder::class,
            TagSeeder::class,
            SidebarWidgetSeeder::class,
            PostSeeder::class,
            BlogPageSettingSeeder::class,
            ActivitySeeder::class,
            NavigationLogoHeaderSeeder::class,
            FooterSeeder::class,
            WidgetSeeder::class,         // Create widgets for the sidebar
            LandingPageSeeder::class,
        ]);
    }
}
