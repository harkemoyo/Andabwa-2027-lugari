<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SidebarWidget;

class SidebarWidgetSeeder extends Seeder
{
    public function run(): void
    {
        $widgets = [

            // 🔥 LEFT SIDEBAR - TRENDING NEWS (3 items)
            [
                'title' => 'Andabwa foundation grows bigger and better ',
                'position' => 'left',
                'content' => '<p>🔥 Breaking: Top trending story #1</p>',
                'url'=>'https://google.com',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Fuel prices hike despite government cushioning Kenyans',
                'position' => 'left',
                'content' => '<p>📈 Viral story gaining traction</p>',
                'url'=>'https://google.com',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Opera browser is te best',
                'position' => 'left',
                'content' => '<p>⚡ Latest buzz in tech & politics</p>',
                'url'=>'https://google.com',
                'is_active' => true,
                'order' => 3,
            ],

            // // 💰 RIGHT SIDEBAR - AD
            // [
            //     'title' => 'Advertisement',
            //     'position' => 'right',
            //     'content' => '<div class="p-4 bg-yellow-100 rounded-lg text-center">📢 Andabwa foundation the best</div>',
            //     'is_active' => true,
            //     'order' => 1,
            // ],

            // // 📩 RIGHT SIDEBAR - NEWSLETTER
            // [
            //     'title' => 'Newsletter Signup',
            //     'position' => 'right',
            //     'content' => '
            //         <div class="p-4 bg-gray-50 rounded-lg">
            //             <h4 class="font-bold mb-2">Subscribe</h4>
            //             <input type="email" placeholder="Enter email" class="w-full p-2 border rounded mb-2">
            //             <button class="w-full bg-black text-white py-2 rounded">Subscribe</button>
            //         </div>
            //     ',
            //     'is_active' => true,
            //     'order' => 2,
            // ],
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