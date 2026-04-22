<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('live_events', function (Blueprint $table) {
            $table->id();
             $table->string('title')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['upload', 'live'])->default('upload');
            $table->string('audio_url')->nullable(); // For file path
            $table->string('live_url')->nullable();  // For external stream link            
            $table->integer('duration_minutes')->nullable();
            $table->dateTime('scheduled_at')->nullable(); // Important for Live
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_events');
    }
};
