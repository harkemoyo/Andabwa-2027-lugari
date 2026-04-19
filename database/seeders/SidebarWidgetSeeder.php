<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\SidebarWidget;

class SidebarWidgetSeeder extends Seeder
{
    public function run(): void
    {
        $widgets = [
            [
                'title' => 'Trending',
                'position' => 'left',
                'content' => '<p>🔥 Trending posts will appear here</p>',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Newsletter',
                'position' => 'right',
                'content' => '<p>📩 Subscribe to our newsletter</p>',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Ads',
                'position' => 'right',
                'content' => '<p>💰 Your ad here</p>',
                'is_active' => true,
                'order' => 2,
            ],
        ];

        foreach ($widgets as $widget) {
            SidebarWidget::updateOrCreate(
                [
                    'title' => $widget['title'],
                    'position' => $widget['position'],
                ],
                $widget
            );
        }
    }
}
