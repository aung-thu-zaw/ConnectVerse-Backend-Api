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
        Schema::create('group_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained("users")->cascadeOnDelete();
            $table->foreignId('group_chat_id')->constrained()->cascadeOnDelete();
            $table->text('content')->nullable();
            $table->enum('message_type', ['text', 'media']);
            $table->foreignId('reply_to_message_id')->nullable()->references('id')->on('group_chat_messages')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_chat_messages');
    }
};
