<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('navigation_items', function (Blueprint $table) {

            $table->id();

            // ✅ ONLY THIS ONE (correct)
            $table->foreignId('menu_id')
                ->constrained('navigation_menus')
                ->cascadeOnDelete();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('navigation_items')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('url')->nullable();

            $table->string('label')->nullable(); // 🔥 also fix this (see below)

            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->string('target')->nullable();

            // 🔥 newsroom extras
            $table->string('link_url')->nullable();            
            $table->string('breaking')->nullable();
            $table->string('elite')->nullable();
            $table->string('live')->nullable();
            $table->string('experience')->nullable();
            $table->boolean('is_breaking')->default(false);            
            $table->boolean('is_live')->default(false)->after('is_breaking');
            $table->integer('ai_score')->default(0)->after('is_live'); // Higher = shown first
            $table->timestamp('expires_at')->nullable()->after('ai_score');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_items');
    }
};
