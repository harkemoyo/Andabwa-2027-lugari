<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Empowerment', 'color' => '#6366f1'],
            ['name' => 'Scholarships', 'color' => '#10b981'],
            ['name' => 'Community Support', 'color' => '#f59e0b'],
            ['name' => 'Lugari Constituency', 'color' => '#ef4444'],
        ];

        $now = now();

        $payload = collect($categories)->map(fn ($cat) => [
            'name' => $cat['name'],
            'slug' => Str::slug($cat['name']),
            'description' => $cat['name'].' insights and updates.',
            'color' => $cat['color'],
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        DB::table('categories')->upsert(
            $payload,
            ['slug'], // unique column
            ['name', 'description', 'color', 'updated_at']
        );

        $this->command->info('Categories seeded.');
    }
}