<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('conversation_id');

            $table->string('phone');

            $table->longText('message')->nullable();

            $table->enum('sender', ['customer', 'agent']);

            $table->string('message_id')->nullable();

            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('whatsapp_conversations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_messages');
    }
};
