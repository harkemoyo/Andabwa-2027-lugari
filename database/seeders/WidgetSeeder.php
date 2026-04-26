<?php

namespace Database\Seeders;

use App\Models\Widget;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WidgetSeeder extends Seeder
{
    // 🔥 ENGINEER STANDARD: Disables Model Events & Broadcasts during seeding
    use WithoutModelEvents;

    public function run(): void
    {
        $widgets = [
            [
                'title' => 'Easter Greetings(Premium Ad)',
                'position' => 'right',
                'type' => 'ad',
                'content' => 'Welcome to Easter celebrations',
                'url' => 'https://google.com',
                'weight' => 1,
                'is_active' => true,
                'widget_image' => 'widgets/easter.png',
                'order' => 1,
            ],
            [
                'title' => 'Smile For Neurodiversity(Premium Ad)',
                'position' => 'right',
                'type' => 'ad',
                'content' => 'The humanitarian organization that really serves',
                'url' => 'https://google.com',
                'weight' => 2,
                'is_active' => true,
                'widget_image' => 'widgets/smile-logo.png',
                'order' => 2,
            ],
            [
                'title' => 'Flash Sale',
                'position' => 'right',
                'type' => 'promo',
                'content' => '<div class="bg-indigo-600 w-full h-full flex flex-col items-center justify-center text-white p-6"><h2 class="text-2xl font-black italic">FLASH SALE</h2><p class="text-sm opacity-90">Limited Time Only</p><button class="mt-4 bg-white text-indigo-600 px-4 py-2 rounded-full font-bold text-xs uppercase">Shop Now</button></div>',
                'url' => 'https://google.com',
                'weight' => 3,
                'is_active' => true,
                'widget_image' => null,
                'order' => 3,
            ],
            [
                'title' => 'Join the Club',
                'position' => 'right',
                'type' => 'newsletter',
                'content' => '<div class="p-6 bg-white flex flex-col h-full"><h4 class="font-bold text-gray-900 mb-2">Newsletter</h4><p class="text-xs text-gray-500 mb-4">Get the latest updates delivered to your inbox.</p><input type="email" placeholder="email@example.com" class="w-full text-xs p-2 border border-gray-200 rounded mb-2 focus:ring-1 focus:ring-black outline-none"><button class="w-full bg-gray-900 text-white text-xs py-2 rounded font-semibold hover:bg-black transition-colors">Subscribe</button></div>',
                'url' => 'https://google.com',
                'weight' => 3,
                'is_active' => true,
                'widget_image' => null,
                'order' => 1,
            ],
            [
                'title' => 'KNPSWU(Premium Ad)',
                'position' => 'right',
                'type' => 'ad',
                'content' => 'We serve diligently in matters of priate security well-being private security',
                'url' => 'https://google.com',
                'weight' => 3,
                'is_active' => true,
                'widget_image' => 'widgets/walinzi-sacco.png',
                'order' => 2,
            ],
            [
                'title' => 'Eagle Search(Premium Ad)',
                'position' => 'right',
                'type' => 'ad',
                'content' => 'We as andabwa foundation we fly highest',
                'url' => 'https://google.com',
                'weight' => 5,
                'is_active' => true,
                'widget_image' => 'widgets/eagle.png',
                'order' => 1,
            ],
            [
                'title' => 'Andabwa Foundation(Premium Ad)',
                'position' => 'right',
                'type' => 'ad',
                'content' => 'The foundation that lead in serving humanity',
                'url' => 'https://google.com',
                'weight' => 5,
                'is_active' => true,
                'widget_image' => 'widgets/andabwa-logo.svg',
                'order' => 2,
            ],
        ];

        $now = now();
        $upsertData = array_map(fn($w) => array_merge($w, ['created_at' => $now, 'updated_at' => $now]), $widgets);

        Widget::upsert(
            $upsertData,
            ['title'], // The column with the Unique Index
            ['position', 'type', 'content', 'url', 'weight', 'is_active', 'widget_image', 'order', 'updated_at']
        );
    }
}
