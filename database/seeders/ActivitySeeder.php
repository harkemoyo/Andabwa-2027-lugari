<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@example.com')->first();
        $superAdminUser = User::where('email', 'superadmin@example.com')->first();

        if (!$adminUser || !$superAdminUser) {
            $this->command->error('Admin users not found. Please run AdminSeeder first.');
            return;
        }

        // Create 5 sample activities
        Activity::create([
            'user_id' => $superAdminUser->id,
            'action' => 'logged_in',
            'model_type' => null,
            'model_id' => null,
            'description' => 'Super Admin logged in to the system',
        ]);

        Activity::create([
            'user_id' => $adminUser->id,
            'action' => 'created',
            'model_type' => 'App\Models\User',
            'model_id' => $adminUser->id,
            'description' => 'Created new user: Admin User',
        ]);

        Activity::create([
            'user_id' => $adminUser->id,
            'action' => 'updated',
            'model_type' => 'App\Models\NavigationMenu',
            'model_id' => 1,
            'description' => 'Updated navigation menu: Main Menu',
        ]);

        Activity::create([
            'user_id' => $superAdminUser->id,
            'action' => 'created',
            'model_type' => 'App\Models\Post',
            'model_id' => 1,
            'description' => 'Created new post: Welcome to Our Blog',
        ]);

        Activity::create([
            'user_id' => $adminUser->id,
            'action' => 'deleted',
            'model_type' => 'App\Models\Category',
            'model_id' => 3,
            'description' => 'Deleted category: Old Category',
        ]);

        $this->command->info('✅ 5 activities seeded successfully!');
    }
}
