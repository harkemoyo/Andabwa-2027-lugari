<?php

// database/migrations/xxxx_xx_xx_create_footer_ctas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('footer_ctas', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('footer_ctas');
    }
};

