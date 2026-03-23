<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('posts')->where('media_type', 'youtube_link')->update([
            'media_type' => 'youtube'
        ]);
    }

    public function down(): void
    {
        DB::table('posts')->where('media_type', 'youtube')->update([
            'media_type' => 'youtube_link'
        ]);
    }
};