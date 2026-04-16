<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\NavigationLogoHeader;

class NavigationLogoHeaderSeeder extends Seeder
{
    public function run(): void
    {
        // $shops = Shop::all();

        // foreach ($shops as $shop) {
            $logoHeader = NavigationLogoHeader::updateOrCreate(
                // ['shop_id' => $shop->id],
                [
                    'link' => url('/'),
                ]
            );

            // Set logo path to use asset() - works in both development and production
            $logoHeader->logo_path = 'imagess/andabwa-logo.svg';
            $logoHeader->save();
            
            $this->command->info('Logo path set to: ' . asset('imagess/andabwa-logo.svg'));
        // }

        $this->command->info('Navigation logos seeded .');
    }
}








