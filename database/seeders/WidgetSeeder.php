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
                'position' => 'right',
                'type' => 'ad',
                'content' => 'The foundation that lead in serving humanity',
                'url' => 'https://andabwafoundation.org',
                'weight' => 5,
                'is_active' => true,
                'widget_image' => 'widget_images/andabwa-mp-campaign.png',
                'image_name' => 'andabwa-mp-campaign.png',
                'order' => 1,
            ],
            [
                'title' => 'Walinzi Sacco',
                'position' => 'right',
                'type' => 'ad',
                'content' => 'Your trusted financial partner',
                'url' => 'https://walinizisacco.co.ke',
                'weight' => 4,
                'is_active' => true,
                'widget_image' => 'widget_images/andabwa-campaign-1.jpg',
                'image_name' => 'andabwa-campaign-1.jpg',
                'order' => 2,
            ],
            [
                'title' => 'Smile Organization',
                'position' => 'right',
                'type' => 'ad',
                'content' => 'Your trusted financial partner',
                'url' => 'https://smile.co.ke',
                'weight' => 3,
                'is_active' => true,
                'widget_image' => 'widget_images/andabwa-campaign-2.jpg',
                'image_name' => 'andabwa-campaign-2.jpg',
                'order' => 1,
            ],
            [
                'title'=>'KTN TV',
                 'position' => 'right',
                'type' => 'ad',
                'content' => 'Your trusted station',
                'url' => 'https://ktn.com',
                'weight' => 3,
                'is_active' => true,
                'widget_image' => 'widget_images/andabwa-development.jpg',
                'image_name' => 'andabwa-development.jpg',
                'order' => 2,

            ],
             [
                'title'=>'KBC TV',
                 'position' => 'right',
                'type' => 'ad',
                'content' => 'Your trusted station',
                'url' => 'https://kbc.co.ke',
                'weight' => 4,
                'is_active' => true,
                'widget_image' => 'widget_images/Dr.-Andabwa-for-MP-2027-campaign.png',
                'image_name' => 'Dr.-Andabwa-for-MP-2027-campaign.png',
                'order' => 2,

            ],
            [
                'title'=>'Citizen TV',
                 'position' => 'right',
                'type' => 'ad',
                'content' => 'Your trusted station',
                'url' => 'https://citizen.co.ke',
                'weight' => 6,
                'is_active' => true,
                'widget_image' => 'widget_images/scholorships.webp',
                'image_name' => 'scholorships.webp',
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