<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            "Dr Isaac GM Andabwa OGW",
            "Andabwa Foundation",
            "Lugari Constituency empowerment",
            "Waliniz Sacco",
            "KNPSWU",
            "Scholarships Kenya",
            "NGO in Kakamega",
            "Community empowerment Kenya",
            "Security sector reforms Kenya"
        ];

        $now = now();

        $payload = collect($tags)->map(fn($tag) => [
            'name' => $tag,
            'slug' => Str::slug($tag),
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        DB::table('tags')->upsert(
            $payload,
            ['slug'],
            ['name', 'updated_at']
        );

        $this->command->info('Tags seeded.');
    }
}
