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
        Schema::create('chat_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->integer('conversation_id');
            $table->string('token');
            $table->datetime('expired_at');
            $table->datetime('used_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_access_tokens');
    }
};
