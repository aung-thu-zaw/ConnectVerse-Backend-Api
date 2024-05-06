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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("sender_id")->constrained("users")->cascadeOnDelete();
            $table->foreignId("receiver_id")->constrained("users")->cascadeOnDelete();
            $table->enum('notification_mute_status', ['not_muted', '1_hr', '4_hr', '8_hr', '1_day', '3_days', 'forever'])->default('not_muted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
