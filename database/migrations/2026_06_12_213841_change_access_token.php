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
        Schema::table('chat_access_tokens', function (Blueprint $table) {
            $table->datetime('expired_at')->nullable()->change();
            $table->datetime('used_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_access_tokens', function (Blueprint $table) {
            //
        });
    }
};
