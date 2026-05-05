<?php

namespace Database\Seeders;

use App\Models\Widget;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\File;

class WidgetSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $widgets = [
            [
                'title' => 'Andabwa Foundation(Premium Ad)',
                'position' => 'sidebar', // <--- Change 'right' to 'sidebar'
                'type' => 'ad',
                'content' => 'The foundation that lead in serving humanity',
                'url' => 'https://andabwafoundation.org',
                'weight' => 5,
                'is_active' => true,
                'widget_image' => 'widget_images/andabwa-logo.svg',
                'image_name' => 'andabwa-logo.svg',
                'room_name' => 'home',
                'order' => 1,
            ],
            [
                'title' => 'Walinzi Sacco',
                'position' => 'sidebar', // <--- Change 'right' to 'sidebar'
                'type' => 'ad',
                'content' => 'Your trusted financial partner',
                'url' => 'https://walinizisacco.co.ke',
                'weight' => 4,
                'is_active' => true,
                'widget_image' => 'widget_images/walinzi-sacco.png',
                'image_name' => 'walinzi-sacco.png',
                'room_name' => 'home',
                'order' => 2,
            ],
            [
                'title' => 'Smile Organization',
                'position' => 'sidebar', // <--- Change 'right' to 'sidebar'
                'type' => 'ad',
                'content' => 'Your trusted financial partner',
                'url' => 'https://smile.co.ke',
                'weight' => 3,
                'is_active' => true,
                'widget_image' => 'widget_images/smile-logo.png',
                'image_name' => 'smile-logo.png',
                'room_name' => 'home',
                'order' => 1,
            ],
            [
                'title'=>'KTN TV',
                 'position' => 'sidebar', // <--- Change 'right' to 'sidebar'
                'type' => 'ad',
                'content' => 'Your trusted station',
                'url' => 'https://ktn.com',
                'weight' => 3,
                'is_active' => true,
                'widget_image' => 'widget_images/eagle.png',
                'image_name' => 'eagle.png',
                'room_name' => 'home',
                'order' => 2,

            ],
             [
                'title'=>'KBC TV',
                 'position' => 'sidebar', // <--- Change 'right' to 'sidebar'
                'type' => 'ad',
                'content' => 'Your trusted station',
                'url' => 'https://kbc.co.ke',
                'weight' => 4,
                'is_active' => true,
                'widget_image' => 'widget_images/easter.png',
                'image_name' => 'easter.png',
                'room_name' => 'home',
                'order' => 2,

            ],
            [
                'title'=>'Citizen TV',
                 'position' => 'sidebar', // <--- Change 'right' to 'sidebar'
                'type' => 'ad',
                'content' => 'Your trusted station',
                'url' => 'https://citizen.co.ke',
                'weight' => 6,
                'is_active' => true,
                'widget_image' => 'widget_images/knpswu.jpeg',
                'image_name' => 'knpswu.jpeg',
                'room_name' => 'home',
                'order' => 2,

            ]
        ];

        foreach ($widgets as $data) {
            $imageName = $data['image_name'] ?? null;
            unset($data['image_name']);

            // Matches RadioChannel::updateOrCreate logic
            $widget = Widget::updateOrCreate(['title' => $data['title']], $data);

            if ($imageName) {
                $seedPaths = [
                    public_path("seed-images/{$imageName}"),
                    public_path("images/{$imageName}"),
                    storage_path("app/public/widgets/{$imageName}"), 
                    storage_path("app/public/widget_images/{$imageName}"),
                ];

                foreach ($seedPaths as $seedPath) {
                    if (File::exists($seedPath)) {
                        // Clear existing media to avoid duplicates
                        $widget->clearMediaCollection('widget_images');

                        $widget->addMedia($seedPath)
                            ->preservingOriginal()
                            ->toMediaCollection('widget_images', env('FILESYSTEM_DISK', 'public'));
                        break;
                    }
                }
            }
        }
    }
}