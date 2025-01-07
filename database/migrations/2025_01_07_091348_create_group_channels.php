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
        Schema::create('group_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('group_id')
                ->constrained('groups')
                ->onDelete('cascade');

            $table->foreignId('youtube_channel_id')
                ->constrained('youtube_channels')
                ->onDelete('cascade');

            $table->string('channelId', 24)->nullable(true)->default('null')->comment('ID kanału Youtube');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_channels');
    }
};
