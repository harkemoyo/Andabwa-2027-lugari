<?php
// database/migrations/xxxx_xx_xx_create_footer_infos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('footer_infos', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('footer_infos');
    }
};

