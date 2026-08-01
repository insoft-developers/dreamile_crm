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
            $table->string('tempat_lahir')->nullable()->after('is_customer');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('kode_pos')->nullable()->after('tanggal_lahir');
            $table->string('nama_ayah')->nullable()->after('kode_pos');
            $table->string('nama_ibu')->nullable()->after('nama_ayah');
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
