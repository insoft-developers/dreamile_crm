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
        Schema::create('partnerships', function (Blueprint $table) {
            $table->id();
            $table->integer('partner_type_id');
            $table->string('instance_name');
            $table->integer('province_id');
            $table->integer('city_id');
            $table->string('address');
            $table->string('pic_name');
            $table->string('pic_title')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->integer('pic_dreamile')->nullable();
            $table->string('partnership_type_name')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnerships');
    }
};
