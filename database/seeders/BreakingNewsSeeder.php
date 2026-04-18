<?php

namespace Database\Seeders;

use App\Models\BreakingNews;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BreakingNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        BreakingNews::updateOrCreate(
            ['id' => 1], // Ensures we only ever have one settings row
            [
                'title' => '🚨 Major event just happened... ✨ ⚡ 🚀 Andabwa (OGW) Lugari Contituency MP 2027 LIVE',
            ]
        );
    }
}
