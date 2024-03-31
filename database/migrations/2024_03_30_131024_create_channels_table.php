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
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained("users")->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('notification_mute_status', ['not_muted', '1_hr', '4_hr', '8_hr', '1_day', '3_days', 'forever'])->default('not_muted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channels');
    }
};
