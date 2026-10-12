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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('tempat_lahir_ayah')->after('nama_ibu')->nullable();
            $table->string('tempat_lahir_ibu')->after('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->after('tempat_lahir_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->after('tempat_lahir_ayah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
