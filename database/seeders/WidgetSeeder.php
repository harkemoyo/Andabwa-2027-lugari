<?php

namespace Database\Seeders;

use App\Models\Widget;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WidgetSeeder extends Seeder
{
    public function run(): void
    {
        $baseUrl = env('ASSET_BASE_URL', asset(''));
        $widgetImagePath = env('WIDGET_IMAGE_PATH', 'social-links/facebook.gif');

        $widgets = [
            [
                'title' => 'Premium Ad Banner 1',
                'position' => 'right',
                'type' => 'ad',
                'content' => '<div data-ad-content data-src="<img src=\'' . $baseUrl . 'images/andabwa-logo.svg\' class=\'w-full h-full object-cover\' />"></div>',
                'url' => 'https://google.com',
                'weight' => 1,
                'is_active' => true,
                'widget_image' => $widgetImagePath,
                'order' => 1,
            ],
            [
                'title' => 'Smile For Neurodiversity',
                'position' => 'right',
                'type' => 'ad',
                'content' => '<div data-ad-content data-src="<img src=\'' . $baseUrl . 'images/smile.png\' class=\'w-full h-full object-cover\' />"></div>',
                'url' => 'https://google.com',
                'weight' => 2,
                'is_active' => true,
                'widget_image' => $widgetImagePath,
                'order' => 1,
            ],
            [
                'title' => 'Andabwa Foundation',
                'position' => 'right',
                'type' => 'ad',
                'content' => '<div data-ad-content data-src="<img src=\'' . $baseUrl . 'images/andabwa-logo.svg\' class=\'w-full h-full object-cover\' />"></div>',
                'url' => 'https://google.com',
                'weight' => 3,
                'is_active' => true,
                'widget_image' => $widgetImagePath,
                'order' => 1,
            ],
            [
                'title' => 'Premium Ad Banner 2',
                'position' => 'right',
                'type' => 'ad',
                'content' => '<div data-ad-content data-src="<img src=\'' . $baseUrl . 'images/andabwa.png\' class=\'w-full h-full object-cover\' />"></div>',
                'url' => 'https://google.com',
                'weight' => 4,
                'is_active' => true,
                'widget_image' => $widgetImagePath,
                'order' => 1,
            ],
            [
                'title' => 'Flash Sale',
                'position' => 'right',
                'type' => 'ad',
                'content' => '<div data-ad-content data-src="<div class=\'bg-indigo-600 w-full h-full flex flex-col items-center justify-center text-white p-6\'><h2 class=\'text-2xl font-black italic\'>FLASH SALE</h2><p class=\'text-sm opacity-90\'>Limited Time Only</p><div data-ad-content data-src=\'<img src=&quot;' . $baseUrl . 'images/andabwa-logo.svg&quot; class=&quot;w-full h-full object-cover&quot; />\'></div><button class=\'mt-4 bg-white text-indigo-600 px-4 py-2 rounded-full font-bold text-xs uppercase\'>Shop Now</button></div>"></div>',
                'url' => 'https://google.com',
                'weight' => 5,
                'is_active' => true,
                'widget_image' => $widgetImagePath,
                'order' => 1,
            ],
            [
                'title' => 'Join the Club',
                'position' => 'right',
                'type' => 'newsletter',
                'content' => '<div class="p-6 bg-white flex flex-col h-full"><h4 class="font-bold text-gray-900 mb-2">Newsletter</h4><p class="text-xs text-gray-500 mb-4">Get the latest updates delivered to your inbox.</p><input type="email" placeholder="email@example.com" class="w-full text-xs p-2 border border-gray-200 rounded mb-2 focus:ring-1 focus:ring-black outline-none"><button class="w-full bg-gray-900 text-white text-xs py-2 rounded font-semibold hover:bg-black transition-colors">Subscribe</button></div>',
                'url' => 'https://google.com',
                'weight' => 6,
                'is_active' => true,
                'widget_image' => $widgetImagePath,
                'order' => 1,
            ],
            [
                'title' => 'Premium Ad Banner 3',
                'position' => 'right',
                'type' => 'ad',
                'content' => '<div data-ad-content data-src="<img src=\'' . $baseUrl . 'images/walinzi-sacco.png\' class=\'w-full h-full object-cover\' />"></div>',
                'url' => 'https://google.com',
                'weight' => 7,
                'is_active' => true,
                'widget_image' => $widgetImagePath,
                'order' => 1,
            ],
            [
                'title' => 'Spring Sale Promo',
                'position' => 'sidebar',
                'type' => 'promo',
                'content' => '<div class="text-center"><h3 class="text-xl font-bold text-pink-600">50% OFF</h3><p>Use code SPRING50</p></div>',
                'url' => '/sale',
                'weight' => 5,
                'is_active' => true,
                'widget_image' => $widgetImagePath,
                'order' => 1,
                'starts_at' => Carbon::now(),
                'ends_at' => Carbon::now()->addMonths(1),
            ],
            [
                'title' => 'Newsletter Signup',
                'position' => 'sidebar',
                'type' => 'newsletter',
                'content' => '<div class="text-center"><p class="font-semibold">Join 10k+ subscribers!</p></div>',
                'url' => '/newsletter',
                'weight' => 2,
                'is_active' => true,
                'widget_image' => $widgetImagePath,
                'order' => 2,
            ],
            [
                'title' => 'Premium Ad Slot',
                'position' => 'sidebar',
                'type' => 'ad',
                'content' => '<img src="' . $baseUrl . 'images/ads/premium-sponsor.jpg" alt="Sponsor" class="rounded w-full h-auto" />',
                'url' => 'https://sponsor-link.example.com',
                'weight' => 1,
                'is_active' => false,
                'order' => 3,
                'starts_at' => Carbon::now()->addDays(5),
                'ends_at' => Carbon::now()->addDays(15),
            ],
        ];

        foreach ($widgets as $widgetData) {
            Widget::updateOrCreate(
                ['title' => $widgetData['title']], 
                $widgetData
            );
        }
    }
}