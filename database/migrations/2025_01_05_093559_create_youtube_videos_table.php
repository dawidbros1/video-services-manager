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
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('videoId', 32)->unique();
            $table->string('channelId', 32)->index()->comment('Kanał twórcy');
            $table->string('channelTitle', 255);
            $table->string('thumb', 255);
            $table->dateTime('publishedAt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_videos');
    }
};
