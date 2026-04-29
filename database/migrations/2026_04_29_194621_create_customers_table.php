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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('school_from');
            $table->string('class')->nullable();
            $table->string('major')->nullable();
            $table->string('phone_number')->index();
            $table->string('email')->nullable();
            $table->string('full_address')->nullable();
            $table->string('province_code')->nullable();
            $table->string('regency_code')->nullable();
            $table->string('district_code')->nullable();
            $table->string('village_code')->nullable();
            $table->integer('lead_source_id');
            $table->integer('event_id')->nullable();
            $table->datetime('visit_date')->nullable();
            $table->string('visit_status')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by');
            $table->integer('consultant_id')->nullable();
            $table->string('note')->nullable();
            $table->integer('branch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
