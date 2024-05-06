<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('channel_message_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_message_id')->constrained()->cascadeOnDelete();
            $table->enum('media_type', ['file', 'image', 'video', 'voice']);
            $table->string('media_path');
            $table->text('caption')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_message_media');
    }
};
