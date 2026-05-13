<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SidebarWidget;

class SidebarWidgetSeeder extends Seeder
{
    public function run(): void
    {
        // 🔥 This tells the model to IGNORE the booted() hooks during the seeder
        SidebarWidget::withoutEvents(function () {
            $widgets = [
                // 🔥 LEFT SIDEBAR - TRENDING NEWS
                [
                    'title' => 'Andabwa foundation grows bigger and better ',
                    'position' => 'left',
                    'content' => '🔥 Breaking: Top trending story #1 for the future',
                    'url' => 'https://google.com',
                    'is_active' => true,
                    'order' => 1,
                ],
                [
                    'title' => 'Fuel prices hike despite government cushioning Kenyans',
                    'position' => 'left',
                    'content' => '📈 Viral story gaining traction',
                    'url' => 'https://google.com',
                    'is_active' => true,
                    'order' => 2,
                ],
                [
                    'title' => 'Private security union helps the vulnerable in Kenya',
                    'position' => 'left',
                    'content' => '⚡ KNPSWU helps the disable in Kenya',
                    'url' => 'https://google.com',
                    'is_active' => true,
                    'order' => 3,
                ],
                [
                    'title' => 'Smile Organization join hands with Andabwa foundation',
                    'position' => 'left',
                    'content' => '⚡ Smile for Neurodiversity Organization is a kenyan humanitarian Org lead by Emoyo Carol',
                    'url' => 'https://google.com',
                    'is_active' => true,
                    'order' => 4,
                ],
            ];

            foreach ($widgets as $widget) {
                SidebarWidget::updateOrCreate(
                    ['title' => $widget['title'], 'position' => $widget['position']],
                    $widget
                );
            }
        });

        $this->command->info('Sidebar widgets seeded without firing broadcast events.');
    }
}
