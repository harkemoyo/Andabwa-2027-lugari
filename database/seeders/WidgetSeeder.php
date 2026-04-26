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
                'image_name' => 'andabwa-logo.svg', // Used for seeding
                'order' => 1,
            ],
            // ... add other widgets here
        ];

        foreach ($widgets as $data) {
            $imageName = $data['image_name'] ?? null;
            unset($data['image_name']);

            // 1. Create or Update the Widget
            $widget = Widget::updateOrCreate(['title' => $data['title']], $data);

            // 2. Attach Media if a seed file exists
            if ($imageName) {
                $seedPath = public_path("seed-images/widgets/{$imageName}");

                if (File::exists($seedPath)) {
                    $widget->addMedia($seedPath)
                        ->preservingOriginal()
                        ->toMediaCollection('widget_images'); // <--- Must match the model
                }
            }
        }
    }
}
