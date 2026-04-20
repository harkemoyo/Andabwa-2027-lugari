<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\NavigationLogoHeader;

class NavigationLogoHeaderSeeder extends Seeder
{
    public function run(): void
    {
        
            $logoHeader = NavigationLogoHeader::updateOrCreate(
                [
                    'link' => url('/'),
                ]
            );

            // Set logo path to use asset() - works in both development and production
            $logoHeader->logo_path = 'social-links/andabwa-logo.svg';
            $logoHeader->save();
            
            $this->command->info('Logo path set to: ' . asset('social-links/andabwa-logo.svg'));

        $this->command->info('Navigation logos seeded .');
    }
}








