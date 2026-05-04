<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Support\Str;

class StreamSeeder extends Seeder
{
    public function run(): void
    {
        $host = User::first() ?? User::factory()->create();
        Stream::create([
            'user_id' => $host->id,
            'title' => 'System Architecture Q&A',
            'description' => 'Discussing Laravel Reverb and WebRTC scaling.',
            'status' => 'scheduled',
            'is_live' => false,
            'livekit_room' => Str::random(10),
        ]);
    }
}