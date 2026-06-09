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
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->datetime('date');
            $table->integer('consultant_id');
            $table->integer('audience')->nullable();
            $table->integer('sangat_tertarik')->nullable();
            $table->integer('tertarik')->nullable();
            $table->integer('kurang_tertarik')->nullable();
            $table->integer('lead')->nullable();
            $table->integer('deal')->nullable();
            $table->string('description')->nullable();
            $table->integer('branch_id');
            $table->integer('userid');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentations');
    }
};
