<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPageSetting;

class BlogPageSettingSeeder extends Seeder
{
    public function run(): void
    {
        BlogPageSetting::updateOrCreate(
            ['id' => 1], // Ensures we only ever have one settings row
            [
                'header_subtitle' => 'Trending',
                'header_title' => 'DR. GW Andabwa (OGW) projects in religion kenya',
                'header_emoji' => 'PORTAL.CORE',
                'search_title'=>'All Topics',
                'editorial_button_text'=> 'Back to Editorial',
                'featured_insight_text'=> 'Featured Insight',
                'share'=> 'Share this piece',
                'view_all_button'=> 'Browse more upates',
                'header_description' => 'Stories, updates, and insights shaping the future of Religion Kenya',
                'featured_title' => 'Featured Upates',
                'latest_title' => 'Latest Upates',
                'featured_description' => 'Priority Updates.',
                'latest_description' => 'Happening Updates',
                
            ]
        );
    }
}