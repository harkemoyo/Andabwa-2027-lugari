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
                'header_subtitle' => 'Community Insights',
                'header_title' => 'Andabwa (OGW) Lugari Contituency MP 2027',
                'header_emoji' => '✨ ⚡ 🚀',
                'search_title'=>'All Topics',
                'editorial_button_text'=> 'Back to Editorial',
                'featured_insight_text'=> 'Featured Insight',
                'share'=> 'Share this piece',
                'view_all_button'=> 'View All →',
                'header_description' => 'Stories, updates, and insights shaping the future of Lugari Constituency.',
                'featured_title' => 'Featured Articles',
                'latest_title' => 'Latest Articles',
                'featured_description' => 'Key Projects by Mheshimiwa Andabwa OGW MP LUGARI 2027.',
                'latest_description' => 'Discover the latest Projects.',
                
            ]
        );
    }
}