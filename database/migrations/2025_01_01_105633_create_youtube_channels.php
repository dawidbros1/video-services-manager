<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// php artisan migrate --path=/database/migrations/2025_01_01_105633_create_youtube_channels.php
// php artisan migrate:rollback --path=/database/migrations/2025_01_01_105633_create_youtube_channels.php

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('youtube_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                    ->constrained('users')
                    ->onDelete('cascade');
            $table->string('name', 255);
            $table->text('description');
            $table->string('thumb', 255);
            $table->string('channelId', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_channels');
    }
};
