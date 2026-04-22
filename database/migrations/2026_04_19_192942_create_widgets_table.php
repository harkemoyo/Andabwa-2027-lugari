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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();

            // Core
            $table->string('title');
            $table->string('widget_image')->nullable();
            $table->string('position')->index(); // left, right, header, footer
            $table->longText('content');

            // Control
            $table->boolean('is_active')->default(true)->index();
            $table->integer('order')->default(0)->index();

            // Ad Engine Features
            $table->integer('weight')->default(1); // rotation priority
            $table->string('variant')->nullable()->index(); // A/B testing

            // Type (important for logic separation)
            $table->enum('type', ['ad', 'newsletter', 'promo'])->default('ad')->index();

            // Scheduling (future-proof)
            $table->timestamp('starts_at')->nullable()->index();
            $table->timestamp('ends_at')->nullable()->index();

            // Analytics cache (fast reads)
            $table->unsignedBigInteger('impressions')->default(0);
            $table->unsignedBigInteger('clicks')->default(0);
                        $table->string('url')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
