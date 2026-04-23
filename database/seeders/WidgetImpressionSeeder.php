<?php

namespace Database\Seeders;


use App\Models\Widget;
use App\Models\WidgetImpression;
use Illuminate\Database\Seeder;

class WidgetImpressionSeeder extends Seeder
{
    public function run(): void
    {
        // Get actual widget IDs from the database
        $widgetIds = Widget::pluck('id')->toArray();

        if (empty($widgetIds)) {
            $this->command->warn('No widgets found, skipping WidgetImpressionSeeder');
            return;
        }

        // Create impressions for each widget
        foreach ($widgetIds as $widgetId) {
            for ($i = 0; $i < 50; $i++) {
                WidgetImpression::create([
                    'widget_id' => $widgetId,
                    'session_id' => bin2hex(random_bytes(10)),
                    'ip' => '127.0.0.' . rand(1, 255),
                    'viewed_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }
}
