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
        Schema::table('partnerships', function (Blueprint $table) {
            $table->date('start_date')->after('partnership_type_name')->nullable();
            $table->string('mou_file')->after('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partnerships', function (Blueprint $table) {
            //
        });
    }
};
