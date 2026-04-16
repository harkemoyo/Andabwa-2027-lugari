<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        PageSection::updateOrCreate(
            ['section' => 'resources'],
            [
                'title' => 'Our Resources',
                'description' => 'SFN resources include advocacy tools, psychosocial support for caregivers, educational materials, recreational activities, access to affordable therapies, and community-driven initiatives.',
                'is_visible' => true,
            ]
        );
    }
}