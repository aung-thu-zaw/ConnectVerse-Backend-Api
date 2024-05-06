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
        Schema::create('user_chat_participation', function (Blueprint $table) {
            $table->primary(['user_id', 'chat_id', 'chat_type']);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('chat');
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chat_participation');
    }
};
