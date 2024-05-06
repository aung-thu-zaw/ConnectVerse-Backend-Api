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
        Schema::create('group_chat_message_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_chat_message_id')->constrained()->cascadeOnDelete();
            $table->enum('media_type', ['application', 'image', 'video', 'voice']);
            $table->string('media_path');
            $table->text('caption')->nullable();
            $table->foreignId('reply_to_message_id')->nullable()->references('id')->on('group_chat_message_media')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_chat_message_media');
    }
};
