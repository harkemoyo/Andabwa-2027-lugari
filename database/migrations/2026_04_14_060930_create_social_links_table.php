<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform_name');
            $table->string('url');
            $table->string('image_path')->nullable(); // uploaded icon
            $table->boolean('is_active')->default(true);
            // $table->string('color')->nullable(); // ✅ Add this line
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('social_links');
    }
};
