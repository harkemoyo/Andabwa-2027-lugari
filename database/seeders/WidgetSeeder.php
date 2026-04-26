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
                'widget_image' => 'widgets/andabwa-logo.svg', // Legacy path for fallback
                'image_name' => 'andabwa-logo.svg', // Used for Media Library seeding
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
                'widget_image' => 'widgets/walinzi-sacco.png',
                'image_name' => 'walinzi-sacco.png',
                'order' => 2,
            ],
            [
                'title' => 'Eagle Security',
                'position' => 'right',
                'type' => 'ad',
                'content' => 'Secure your future with us',
                'url' => 'https://eaglesecurity.co.ke',
                'weight' => 3,
                'is_active' => true,
                'widget_image' => 'widgets/eagle.png',
                'image_name' => 'eagle.png',
                'order' => 3,
            ],
            [
                'title' => 'Smile Logo',
                'position' => 'right',
                'type' => 'ad',
                'content' => 'Bringing smiles to Lugari',
                'url' => 'https://smilefoundation.org',
                'weight' => 2,
                'is_active' => true,
                'widget_image' => 'widgets/smile-logo.png',
                'image_name' => 'smile-logo.png',
                'order' => 4,
            ],
        ];

        foreach ($widgets as $data) {
            $imageName = $data['image_name'] ?? null;
            unset($data['image_name']);

            // 1. Create or Update the Widget
            $widget = Widget::updateOrCreate(['title' => $data['title']], $data);

            // 2. Attach Media if a seed file exists (Engineer Standard: Check multiple paths)
            if ($imageName) {
                $seedPaths = [
                    storage_path("app/public/widget_images/{$imageName}"), // Check storage/widget_images (actual location)
                    public_path("seed-images/{$imageName}"), // Check public/seed-images
                    public_path("images/{$imageName}"), // Check public/images
                    storage_path("app/public/widgets/{$imageName}"), // Check storage/widgets
                ];

                foreach ($seedPaths as $seedPath) {
                    if (File::exists($seedPath)) {
                        // Clear existing media to avoid duplicates
                        $widget->clearMediaCollection('widget_images');

                        $widget->addMedia($seedPath)
                            ->preservingOriginal()
                            ->toMediaCollection('widget_images');
                        break;
                    }
                }
            }
        }
    }
}
