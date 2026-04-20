<?php

namespace Database\Seeders;

use App\Models\Widget;
use Illuminate\Database\Seeder;

class WidgetSeeder extends Seeder
{
    public function run(): void
    {
        // High Weight Ad (Appears more often)
        Widget::updateOrCreate(['title' => 'Premium Ad Banner'], [
            'position' => 'right',
            'type' => 'ad',
            'content' => '
                <div data-ad-content data-src="
                    <img src=\'imagess\andabwa-logo.svg\' class=\'w-full h-full object-cover\' />
                "></div>',
            'url'=>'https://google.com',
            'weight' => 1,
            'is_active' => true,
            'order' => 1,
        ]);

        // High Weight Ad (Appears more often)
        Widget::updateOrCreate(['title' => 'Smile For Neurodiersity'], [
            'position' => 'right',
            'type' => 'ad',
            'content' => '
                <div data-ad-content data-src="
                    <img src=\'imagess\walinzi.png\' class=\'w-full h-full object-cover\' />
                "></div>',
            'url'=>'https://google.com',
            'weight' => 2,
            'is_active' => true,
            'order' => 1,
        ]);

        // High Weight Ad (Appears more often)
        Widget::updateOrCreate(['title' => 'Smile For Neurodiersity'], [
            'position' => 'right',
            'type' => 'ad',
            'content' => '
                <div data-ad-content data-src="
                    <img src=\'imagess\smile.png\' class=\'w-full h-full object-cover\' />
                "></div>',
            'url'=>'https://google.com',
            'weight' => 3,
            'is_active' => true,
            'order' => 1,
        ]);

        // High Weight Ad (Appears more often)
        Widget::updateOrCreate(['title' => 'Premium Ad Banner'], [
            'position' => 'right',
            'type' => 'ad',
            'content' => '
                <div data-ad-content data-src="
                    <img src=\'imagess\andabwa.png\' class=\'w-full h-full object-cover\' />
                "></div>',
            'url'=>'https://google.com',
            'weight' => 4,
            'is_active' => true,
            'order' => 1,
        ]);

        // Standard Ad (FIXED QUOTES HERE)
        Widget::updateOrCreate(['title' => 'Flash Sale'], [
            'position' => 'right',
            'type' => 'ad',
            'content' => '
                <div data-ad-content data-src="
                    <div class=\'bg-indigo-600 w-full h-full flex flex-col items-center justify-center text-white p-6\'>
                        <h2 class=\'text-2xl font-black italic\'>FLASH SALE</h2>
                        <p class=\'text-sm opacity-90\'>Limited Time Only</p>
                        <div data-ad-content data-src=\'
                            <img src=&quot;imagess\andabwa-logo.svg&quot; class=&quot;w-full h-full object-cover&quot; />
                        \'></div>
                        <button class=\'mt-4 bg-white text-indigo-600 px-4 py-2 rounded-full font-bold text-xs uppercase\'>Shop Now</button>
                    </div>
                "></div>',
            'url'=>'https://google.com',
            'weight' => 5,
            'is_active' => true,
            'order' => 1,
        ]);

        // Static Content (Newsletter)
        Widget::updateOrCreate(['title' => 'Join the Club'], [
            'position' => 'right',
            'type' => 'newsletter',
            'content' => '
                <div class="p-6 bg-white flex flex-col h-full">
                    <h4 class="font-bold text-gray-900 mb-2">Newsletter</h4>
                    <p class="text-xs text-gray-500 mb-4">Get the latest updates delivered to your inbox.</p>
                    <input type="email" placeholder="email@example.com" class="w-full text-xs p-2 border border-gray-200 rounded mb-2 focus:ring-1 focus:ring-black outline-none">
                    <button class="w-full bg-gray-900 text-white text-xs py-2 rounded font-semibold hover:bg-black transition-colors">Subscribe</button>
                </div>',
            'url'=>'https://google.com',
            'weight' => 6,
            'is_active' => true,
            'order' => 1,
        ]);
    }
}